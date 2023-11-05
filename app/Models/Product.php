<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'quantity',
        'price',
        'cost',
        'img',
    ];
    public function sales()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function getTotalSalesAttribute()
    {
        return $this->sales->sum('quantity');
    }
}
