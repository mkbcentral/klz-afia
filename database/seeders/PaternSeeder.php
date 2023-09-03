<?php

namespace Database\Seeders;

use App\Models\MedPatern;
use Illuminate\Database\Seeder;

class PaternSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            ['name'=>'Fièvre'],
            ['name'=>'Maux de tête'],
            ['name'=>'Toux sec']
        ];

        MedPatern::insert($data);
    }
}
