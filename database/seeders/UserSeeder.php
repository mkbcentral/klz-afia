<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_role=Role::where('name','Admin')->first();
        $users=[
            [
                'name'=>'Ben MWILA',
                'email'=>'mkbcentral@gmail.com',
                'password'=>Hash::make('123456'),
                'role_id'=>$admin_role->id
            ],
            [
                'name'=>'Hilde NUMBI',
                'email'=>'hillde@shukra.app',
                'password'=>Hash::make('123456h'),
                'role_id'=>$admin_role->id
            ],
            [
                'name'=>'Marlene MUSAU',
                'email'=>'marlene@shukra.app',
                'password'=>Hash::make('123456mm'),
                'role_id'=>$admin_role->id
            ],
            [
                'name'=>'Rebecca RCPT',
                'email'=>'rebeccarcp@shukra.app',
                'password'=>Hash::make('123456rbc'),
                 'role_id'=>$admin_role->id
            ],
            [
                'name'=>'Magalie RCPT',
                'email'=>'magaliercpt@shukra.app',
                'password'=>Hash::make('123456rbc'),
                 'role_id'=>$admin_role->id
            ],
            [
                'name'=>'Angel NURSINBG',
                'email'=>'angelnrs@shukra.app',
                'password'=>Hash::make('123456rbc'),
                 'role_id'=>$admin_role->id
            ],
            [
                'name'=>'Patrick NURSINBG',
                'email'=>'patricknrs@shukra.app',
                'password'=>Hash::make('123456rbc'),
                 'role_id'=>$admin_role->id
            ],
            [
                'name'=>'Esoxie infirmerie',
                'email'=>'edoxieinf@shukra.app',
                'password'=>Hash::make('123456rbc'),
                'role_id'=>$admin_role->id
            ],
            [
                'name'=>'AG ',
                'email'=>'agshukra@shukra.app',
                'password'=>Hash::make('123456rbc'),
                'role_id'=>$admin_role->id
            ],
            [
                'name'=>'Medecin',
                'email'=>'medecinshukra@shukra.app',
                'password'=>Hash::make('123456rbc'),
                'role_id'=>$admin_role->id
            ],
            [
                'name'=>'Jhon Fact',
                'email'=>'kabwitfact@shukra.app',
                'password'=>Hash::make('123456rbc'),
                'role_id'=>$admin_role->id
            ]
        ];

        User::insert($users);
    }
}
