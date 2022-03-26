<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('admins')->insert([
            'first_name' => 'admin',
            'last_name' => 'user',
            'email' => 'admin1@yopmail.com',
            'password' => bcrypt('12345678'),
            'phone_number' => '+91 9999999999'
        ]);
    }
}
