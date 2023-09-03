<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            ['name'=>'CHIR. HOMME'],
            ['name'=>'CHIR. FEMME'],
            ['name'=>'MED INT HOMME'],
            ['name'=>'MED INT FEMME'],
            ['name'=>'PEDIATRIE']
        ];
        Room::insert($data);
    }
}
