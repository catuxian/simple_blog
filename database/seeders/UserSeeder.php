<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        // for($i = 0; $i < 10; $i++ ) {
        //     DB::table('users')->insert([
        //         'name' => Str::random(10),
        //         'email' => Str::random(10).'@gmail.com',
        //         'password' => Hash::make('password'),
        //     ]);
        // }
        DB::table('users')->insert([
            'name' => 'jack',
            'email' => 'jack@mail.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => Hash::make('1234'),
        ]);
        DB::table('users')->insert([
            'name' => 'jason',
            'email' => 'jason@mail.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => Hash::make('1234'),
        ]);
        DB::table('users')->insert([
            'name' => 'tony',
            'email' => 'tony@mail.com',
            'email_verified_at' => date('Y-m-d H:i:s'),
            'password' => Hash::make('1234'),
        ]);
        
    }
}
