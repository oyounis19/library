<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ProductController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'quantity' => 'required|integer',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        // Create a new product using the validated data
        $product = new Product([
            'name' => $validatedData['name'],
            'quantity' => $validatedData['quantity'],
            'cost' => $validatedData['cost'],
            'price' => $validatedData['price'],
        ]);

        $product->save();

        // Redirect to the index page or a different view
        return redirect()->back()->with('success', 'Product created successfully');
    }

    public function storeExcel(Request $request){
        $request->validate([
             'file' => 'required|mimes:xls,xlsx'
        ]);

        $sheet = $request->file('file');

        try{
            Excel::import(new ProductsImport, $sheet);
        }catch(ValidationException $e){
            return redirect()->back()->with('allerrors', $e->errors());
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Products imported successfully.');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);

        if(!$product)   return redirect()->route('not.found');

        return view('admin.products.edit', [
            'user' => Auth::user(),
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }

        // Validate the request data
        $request->validate([
            'name' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'sold' => 'required|integer|min:0',
            'cost' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
        ]);
        // dd('sss');

        // Update product attributes
        $product->name = $request->input('name');
        $product->quantity = $request->input('quantity');
        $product->cost = $request->input('cost');
        $product->price = $request->input('price');

        // $product->fill($data);
        // Save sale if "sold" column changed
        if ($request->input('totalSales') != $request->input('sold')) {
            $this->saveSale($product, $request->input('totalSales'), $request->input('sold'));
            return redirect()->back()->with('success', 'Product updated successfully');
        }
        if($product->isDirty()){
            $product->save(); // Save the updated product
            return redirect()->back()->with('success', 'Product updated successfully');
        }
        else
            return redirect()->back()->with('info', 'No changes were made');
    }

    private function saveSale($product, $totalSales, $sold){
        $sale = Sale::create([
            'user_id' => Auth::user()->id,
        ]);

        SaleItem::create([
            'sale_id' => $sale->id,
            'product_id' => $product->id,
            'quantity' => abs($totalSales - $sold),
            'total_price' => $product->price,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Product Deleted successfully');
    }
}
