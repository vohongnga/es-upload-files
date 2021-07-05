<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       $this->call([
           UserSeeder::class
       ]);
       DB::table('users')->insert([
           'username'=>'ngavo',
           'password'=>Hash::make('11111111'),
           'role_id'=>1,
           'remember_token'=>''
       ]);
    }
}
