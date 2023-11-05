<?php

namespace App\Http\Controllers;

use App\Models\DailyStat;
use App\Models\Notification;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellingController extends Controller
{
    public function addToCart(Request $request){
        $id = $request->input("id");
        $quantity = $request->input("quantity") ?? 1;

        $productRequest = Product::find($id);

        if(!$productRequest){
            return back()->with("error","Product not found");
        }

        $cart = $request->session()->get('cart', []);

        $existingProduct = null;

        foreach ($cart as $key => $product) {
            if ($product['id'] === $id) {
                $existingProduct = $key;
                break;
            }
        }

        if ($existingProduct !== null) {
            // Product already in cart; update quantity.
            $cart[$existingProduct]['quantity'] += $quantity;
            // Check stock
            if($cart[$existingProduct]['quantity'] > $productRequest->quantity)
                return redirect()->back()->with('error','Can\'t put in cart, product low on stock');
        } else {
            // Product not in cart; add it.
            $cart[] = [
                'id' => $id,
                'name' => $productRequest->name,
                'price' => $productRequest->price,
                'quantity' => $quantity,
            ];
            // Check stock
            if($quantity > $productRequest->quantity)
                return redirect()->back()->with('error','Can\'t put in cart, product low on stock');
        }

        // Store the updated cart in the session
        $request->session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart');
    }

    public function removeItem(Request $request){
        $id = $request->input('id');

        // Get the current cart from the session
        $cart = $request->session()->get('cart', []);

        // Iterate through the cart to find the product with the specified ID
        foreach ($cart as $key => $product) {
            if ($product['id'] == $id) {
                // Product found, remove it from the cart
                unset($cart[$key]);
                break; // Exit the loop since we found the product
            }
        }

        // Update the cart in the session with the modified cart (without the removed item)
        $request->session()->put('cart', array_values($cart));

        return redirect()->back()->with('success', 'Product removed from cart');
    }

    public function showCart(){
        $cart = session()->get('cart', []);
        return view('checkout', [
            'cart'=> $cart,
        ]);
    }

    public function editQuantity(int $id){
        $product = Product::find($id);

        if(empty($product))
            return redirect()->back()->with('error','Product not found');

        $cart = session()->get('cart', []);
        $quantity = null;


        foreach ($cart as $key => $p) {
            if ((int)$p['id'] === $id) {
                $quantity = $p['quantity'];
                break;
            }
        }
        return view('editQuantity', [
            'product' => $product,
            'quantity' => $quantity,
        ]);
    }

    public function updateQuantity(Request $request, int $id){
        $cart = session()->get('cart', []);

        $p = Product::find($id);

        if(empty($p))
            return redirect()->back()->with('error','Product not found');

        // Find the product in the cart
        foreach ($cart as $key => $product) {
            if ((int)$product['id'] === $id) {
                // Update the quantity with the new value from the form
                $newQuantity = (int)$request->input('quantity');

                if ($newQuantity > 0) {
                    $cart[$key]['quantity'] = $newQuantity;
                    $message = 'Quantity updated';
                    if($p->quantity < $newQuantity) {
                        return redirect()->back()->with('error','Can\'t put this quantity, product low on stock');
                    }
                } else {
                    // If the new quantity is 0 or less, remove the product from the cart
                    unset($cart[$key]);
                    $message = 'Product removed from the cart';
                }

                // Update the cart in the session
                session()->put('cart', array_values($cart));

                return redirect()->back()->with('success', $message);
            }
        }

        return redirect()->back()->with('error', 'Product not found in cart');
    }

    public function applyPromo(Request $request){
        if(session('promoDiscount'))
            return redirect()->back()->with('error','Coupon has already been applied');

        $request->validate([
            'promocode'=> 'required|max:255',
        ]);

        $code = $request->input('promocode');

        $promo = PromoCode::where('code', $code)->first();

        if (!$promo or $promo->is_used == true) {
            return redirect()->back()->with('error','Promocode not valid');
        }

        session()->put('promoDiscount', $promo->discount);

        $promo->is_used = true;
        $promo->save();

        return redirect()->back()->with('success','Promocode applied successfully');
    }

    public function sell(Request $request){
        $total = $request->session()->get('total');
        $cart = $request->session()->get('cart');

        $promoApplied = $request->input('promoApplied');
        $promoDiscount = $request->session()->get('promoDiscount');

        if(!$this->saveStat($total, $cart)) {
            return redirect()->back()->with('error','Error occured while saving daily statistics');
        }

        if(!$this->saveSale($promoApplied, $promoDiscount, $cart, $total)) {
            return redirect()->back()->with('error','Error occured while saving transaction');
        }

        if(!$this->decrementInventory($cart)) {
            return redirect()->back()->with('error','Error occured while decrementing product inventory');
        }

        session()->forget(['cart', 'promoDiscount', 'total']);

        return redirect()->back()->with('success', 'Sale saved successfully');
    }

    private function saveSale($promoApplied, $promoDiscount, $cart, $total){
        try{
            $sale = Sale::create([
                'user_id' => Auth::user()->id,
                'promo_applied' => $promoApplied ?? false,
                'discount_percentage' => $promoDiscount ?? null,
                'total_price' => $total,
            ]);

            foreach ($cart as $item) {
                SaleItem::create([// Must paginate
                    'sale_id' => $sale->id,
                    'product_id' => $item["id"],
                    'quantity' => (int)$item["quantity"],
                    'total_price' => (float)$item["price"] * (int)$item["quantity"],
                ]);
            }
            return true;
        }catch(\Exception $e){
            return false;
        }
    }

    private function decrementInventory($cart){
        try{
            foreach ($cart as $item) {
                $id = $item['id'];
                $product = Product::findOrFail($id);
                $newQuantity = $product->quantity - $item['quantity'];
                $product->quantity = $newQuantity;
                $product->save();

                if($newQuantity <= config('lib.min_stock_level')){
                    $this->notifyAdmin($id, $newQuantity);
                }
            }
            return true;
        }catch(\Exception $e){
            return false;
        }
    }

    private function notifyAdmin($id, $productQuantity){
        try{
            Notification::create([
                'message' => 'Product with id: '. $id .' is low on stock, ' . $productQuantity . ' left',
            ]);
        }catch(\Exception $e){
            return redirect()->back()->with('error', 'Error notifying admin of low inventory');
        }
    }

    private function saveStat($total, $cart){
        // try{

            $totalCost = $this->totalCost($cart);

            $stat = DailyStat::where('date', now()->toDateString())->first();

            if($stat){// update
                $stat->total_income += $total;
                $stat->total_cost += $totalCost;
                $stat->save();
            }else{// create
                $stat = new DailyStat([
                    'date' =>now()->toDateString(),
                    'total_income' => $total,
                    'total_cost' => $totalCost,
                ]);
                $stat->save();
            }
            return true;
        // }catch(\Exception $e){
        //     return false;
        // }
    }

    private function totalCost($cart) {
        $totalCost = 0;
        $dev = null;
        foreach ($cart as $item) {
            $productCost = (float)Product::findOrFail($item['id'])->cost;
            $productCost *= (int)$item['quantity'];

            $totalCost += $productCost;
        }
        return $totalCost;
    }
}
