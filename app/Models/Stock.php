<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    public static $status = [1 => 'Active', 2 => 'Inactive', 3 => 'Deleted'];

    protected $fillable = ['product', 'rfid', 'status'];

    public static function getData($getActiveOnly = false)
    {
        return self::whereIn('status', ($getActiveOnly) ? [1] : [1, 2])->orderby('id', 'DESC');
    }

    public function productdata()
    {
        return $this->hasOne(Product::class, 'id', 'product');
    }
}
