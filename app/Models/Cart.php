<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Cart extends Model
{
    use HasFactory;

    protected $appends = ["formatTotal", "formatDate", "statusText", 'orderNumber'];

    public static $status = [1 => 'Paid', 2 => 'Live', 3 => 'Expired', 4 => 'Verified'];

    protected $fillable = ['user', 'status', 'total'];

    public static function getData()
    {
        return self::where('status', 2);
    }

    public function cartproducts()
    {
        return $this->hasMany(CartProduct::class, 'cart', 'id')->with('productdata');
    }

    public function getFormatTotalAttribute()
    {
        return format_currency($this->attributes['total']);
    }

    public function getFormatDateAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
    }

    public function getStatusTextAttribute()
    {
        return self::$status[$this->attributes['status']];
    }

    public function getOrderNumberAttribute()
    {
        return  '#' . str_pad($this->attributes['id'], 5, "0", STR_PAD_LEFT);
    }
}
