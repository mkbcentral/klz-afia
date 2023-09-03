<?php

namespace Database\Seeders;

use App\Models\MedicalPatern;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        //$this->call(RoleSeeder::class);
        //$this->call(UserSeeder::class);
        //$this->call(RoomSeeder::class);
        //$this->call(RateSeeder::class);

        $this->call(ChangeRateSeeder::class);
    }
}
