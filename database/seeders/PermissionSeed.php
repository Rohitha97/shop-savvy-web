<?php

namespace Database\Seeders;

use App\Models\Permissions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeed extends Seeder
{
    protected $data = [
        [
            'usertype' => 1,
            'route' => 1,
        ],
        [
            'usertype' => 1,
            'route' => 2,
        ],
        [
            'usertype' => 1,
            'route' => 3,
        ],
        [
            'usertype' => 1,
            'route' => 4,
        ],
        [
            'usertype' => 1,
            'route' => 5,
        ],
        [
            'usertype' => 1,
            'route' => 6,
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data as $key => $value) {
            Permissions::create($value);
        }
    }
}
