<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'usertype', 'status'];

    public function permissiondata()
    {
        return $this->hasMany(Permissions::class, 'usertype', 'id');
    }

    public function permissionandroutesdata()
    {
        return $this->hasMany(Permissions::class, 'usertype', 'id')->with('routedata');
    }

    public static $status = [1 => 'Active', 2 => 'Inactive', 3 => 'Blocked', 4 => 'Deleted'];

    public static function getData($getActiveOnly = false)
    {
        return self::whereIn('status', ($getActiveOnly) ? [1] : [1, 2]);
    }
}
