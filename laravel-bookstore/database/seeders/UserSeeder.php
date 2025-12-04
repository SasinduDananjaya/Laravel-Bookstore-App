<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@bookstore.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '0714875269',
            'address' => '56/2 8 Araliya Uyana, 1st Lane, Maharagama',
        ]);

        // create members
        User::create([
            'name' => 'Sasindu Gunawardana',
            'email' => 'sasindu@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'phone' => '0716975269',
            'address' => '123 Galle Road, Colombo 03',
        ]);

        User::create([
            'name' => 'Sapumal',
            'email' => 'sapumal@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);
    }
}
