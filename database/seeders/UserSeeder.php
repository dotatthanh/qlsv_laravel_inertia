<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => fake()->name(),
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123123123'),
                'class_id' => 1,
                'role' => 'Admin',
            ],
            [
                'name' => fake()->name(),
                'email' => 'gv1@gmail.com',
                'password' => Hash::make('123123123'),
                'class_id' => 1,
                'role' => 'Giảng viên',
            ],
            [
                'name' => fake()->name(),
                'email' => 'gv2@gmail.com',
                'password' => Hash::make('123123123'),
                'class_id' => 2,
                'role' => 'Giảng viên',
            ],
            [
                'name' => fake()->name(),
                'email' => 'gv3@gmail.com',
                'password' => Hash::make('123123123'),
                'class_id' => 3,
                'role' => 'Giảng viên',
            ],
            [
                'name' => fake()->name(),
                'email' => 'gv4@gmail.com',
                'password' => Hash::make('123123123'),
                'class_id' => 4,
                'role' => 'Giảng viên',
            ],
        ]);

        for ($i = 1; $i <= 4; $i++) {
            for ($j = 1; $j <= 40; $j++) {
                User::create([
                    'name' => fake()->name(),
                    'email' => fake()->unique()->safeEmail(),
                    'password' => Hash::make('123123123'),
                    'class_id' => $i,
                    'role' => 'Sinh viên',
                ]);
            }
        }
    }
}
