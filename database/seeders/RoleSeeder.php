<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $items = [

            ['id' => 1, 'role' => 'Administrator (can create other users)',],
            ['id' => 2, 'role' => 'Simple user',],
            ['id' => 3, 'role' => 'Tester',],

        ];

        foreach ($items as $item) {
            Roles::updateOrCreate($item);
        }

    }
}
