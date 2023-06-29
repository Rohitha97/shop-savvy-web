<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    protected $data = [
        [
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => 'Admin@123',
        ],
        [
            'name' => 'Store Manager',
            'email' => 'store@gmail.com',
            'password' => 'store@123',
        ],
        [
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => 'User@123',
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data as $key => $value) {
            $value['usertype'] = $key + 1;
            $value['password'] = Hash::make($value['password']);
            User::create($value);
        }
    }
}
