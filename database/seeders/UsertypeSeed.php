<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsertypeSeed extends Seeder
{
    public static $usertypes = ['Administrator', 'Shop Owner', 'User'];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$usertypes as $key => $value) {
            UserType::create([
                'usertype' => $value,
            ]);
        }
    }
}
