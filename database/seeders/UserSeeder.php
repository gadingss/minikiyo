<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'admin',
            'email' => 'admin@minikiyo.com',
            'password_hash' => bcrypt('password123'), // sesuaikan dengan field di DB
            'full_name' => 'Administrator',
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

}
