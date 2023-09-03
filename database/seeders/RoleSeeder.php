<?php

namespace Database\Seeders;

use App\Models\Role;
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
        $roles=[
            ['name'=>'Admin'],
            ['name'=>'Pharma'],
            ['name'=>'Fiance'],
            ['name'=>'Nursing']
        ];
        Role::insert($roles);
    }
}
