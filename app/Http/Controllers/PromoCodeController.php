<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromoCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.promos.index', [
            'promocodes' => PromoCode::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.promos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the input (discount percentage)
        $request->validate([
            'discount' => 'required|integer|between:1,100',
        ]);

        // Generate a unique promo code (e.g., a random string)
        $code = $this->generateUniqueCode();

        // Create and save the promo code record
        $promoCode = new PromoCode([
            'code' => $code,
            'discount' => $request->input('discount'),
        ]);
        $promoCode->save();

        // Redirect back with a success message and the generated code
        return redirect()->back()->with('success', 'Promo code created successfully. Copy and use this code:')->with('code', $code);
    }

    private function generateUniqueCode()
    {
        $code = null;

        do {
            // Generate a unique code (e.g., using random letters and numbers)
            $prefix = 'PROMO_';
            $randomPart = strtoupper(Str::random(3));
            $timestampPart = now()->format('iHds');

            $code = $prefix . $randomPart . $timestampPart;

            // Check if the generated code already exists in the database
        } while (PromoCode::where('code', $code)->exists());

        return $code;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pc = PromoCode::find($id);

        if(!$pc)
            return redirect()->route('not.found');

        return view('admin.promos.edit', [
            'promocode' => $pc,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the input (discount percentage)
        $request->validate([
            'discount' => 'required|integer|between:1,100',
        ]);

        // Find the promo code by its ID
        $promoCode = PromoCode::find($id);

        if (!$promoCode) {
            return redirect()->back()->with('error', 'Promo Code not found');
        }

        // Update the promo code's discount value
        $promoCode->discount = $request->input('discount');

        if($promoCode->isDirty()){
            $promoCode->save(); // Save the updated Promo code
            return redirect()->back()->with('success', 'Promo Code updated successfully');
        }
        // Redirect back with a success message
        return redirect()->back()->with('info', 'No changes were made');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        PromoCode::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Promo Code Deleted successfully');
    }
}
