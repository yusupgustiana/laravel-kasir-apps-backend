<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory(15)->create();

        \App\Models\User::create([
            'name' => 'Yusuf Gustiana',
            'email' => 'yusuf@gmail.com',
            'password' => Hash::make( '12345678'), // password
            'roles' =>'ADMIN',
            'phone' => '081234567890',
        ]);

    }
}
