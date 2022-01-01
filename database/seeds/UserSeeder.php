<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'codcon' => '21287654',
            'email' => 'jperaltag@iglesiaprimitivaperu.org',            
            'password' => bcrypt('123456'),            
            'active' => 1,
        ]);
        User::find(1)->assignRole('liderred');

        DB::table('users')->insert([
            'codcon' => '21287549',
            'email' => 'jcardenasz@iglesiaprimitivaperu.org',            
            'password' => bcrypt('123456'),            
            'active' => 1,
        ]);
        User::find(2)->assignRole('liderred');

        DB::table('users')->insert([
            'codcon' => '40856025',
            'email' => 'rperaltag@iglesiaprimitivaperu.org',            
            'password' => bcrypt('123456'),            
            'active' => 1,
        ]);
        User::find(3)->assignRole('liderred');

        DB::table('users')->insert([
            'codcon' => '41192360',
            'email' => 'jsalvah@iglesiaprimitivaperu.org',            
            'password' => bcrypt('123456'),            
            'active' => 1,
        ]);
        User::find(4)->assignRole('liderred');

        DB::table('users')->insert([
            'codcon' => '47403238',
            'email' => 'aaguirreh@iglesiaprimitivaperu.org',
            'password' => bcrypt('123456'),
            'active' => 1,
        ]);
        User::find(5)->assignRole('lidercdp');

        DB::table('users')->insert([
            'codcon' => 'NC005165',
            'email' => 'ccarmonao@iglesiaprimitivaperu.org',
            'password' => bcrypt('123456'),
            'active' => 1,
        ]);
        User::find(6)->assignRole('administrador');
    }
}
