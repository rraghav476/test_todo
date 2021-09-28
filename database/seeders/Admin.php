<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Admin extends Seeder
{
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'rohtash',
            'email' => 'ro@gmail.in',
            'password' => bcrypt('r@ghav1999'),
            'email_verified_at'=>now(),
            'role' => 1
        ]);
    }
}
