<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $appends = ["formatPrice"];

    public static $status = [1 => 'Active', 2 => 'Inactive', 3 => 'Deleted'];

    protected $fillable = [ 'img', 'name', 'description', 'qty', 'price', 'status'];

    public static function getData($getActiveOnly = false)
    {
        $query = self::whereIn('status', ($getActiveOnly) ? [1] : [1, 2]);
        return $query->with('stockdata');
    }

    protected function img(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => asset('assets/img/products/' . $value),
        );
    }

    public function getFormatPriceAttribute()
    {
        return format_currency($this->attributes['price']);
    }

    public function stockdata()
    {
        return $this->hasMany(Stock::class, 'product', 'id')->where('status', 1);
    }
}
