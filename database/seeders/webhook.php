<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class webhook extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = "ro@gmail.in";
        $user = User::where("email",$email)->first();
        DB::table('webhooks')->insert([
            'key' => Str::random(16),
            'admin_id' => $user->id,
            'callback_url' => null
        ]);
    }
}
