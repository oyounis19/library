<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;

class ProductsImport implements ToModel, WithValidation, WithHeadingRow
{
    use Importable;

    /**
     * @param array $row
     *
     * @return Product|null
     */
    public function model(array $row)
    {
        // Convert each row from the Excel file into an Eloquent model
        return new Product([
            'name' => $row['name'],
            'quantity' => $row['stock'],
            'price' => $row['price'],
            'cost' => $row['cost'],
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'stock' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:0.25',
            'cost' => 'required|numeric|min:0.25|lt:*.price',
        ];
    }
    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'name.required'=> 'Name is required',
            'name.string'=> 'Name must be text',
            'name.max'=> 'Name must be less than 255 characters',

            'stock.required' => 'Stock is required',
            'stock.numeric' => 'Stock must be a number',
            'stock.min' => 'Stock Can\'t be smaller than 1',

            'price.required'=> 'Price is required',
            'price.numeric'=> 'must be a number',
            'price.min'=> 'must be greater than 0.25',

            'cost.required'=> 'Cost is required',
            'cost.numeric'=> 'Cost must be a number',
            'cost.min'=> 'Cost must be greater than 0.25',
            'cost.lt'=> 'Cost Can\'t be greater than price',
        ];
    }
}
