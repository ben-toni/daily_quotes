<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@demo.com',
            'password' => bcrypt('@123qwer')
        ]);
    }
}
