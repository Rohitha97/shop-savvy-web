<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    use HasFactory;

    protected $fillable = ['cart', 'product', 'qty', 'total','rfid'];

    public function productdata()
    {
        return $this->hasOne(Product::class, 'id', 'product');
    }
}
