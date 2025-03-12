<?php

namespace Database\Seeders;

use App\Models\Point;
use App\Models\User;
use Illuminate\Database\Seeder;

class PointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Kiểm tra miệng', 'Kiểm tra 15 phút', 'Kiểm tra 45 phút', 'Kiểm tra học kì'];
        foreach ($types as $type) { // loại điểm
            for ($i = 1; $i <= 4; $i++) { // môn
                for ($j = 1; $j <= 160; $j++) { // user
                    Point::create([
                        'class_id' => User::find($j)->class_id,
                        'user_id' => $j,
                        'subject_id' => $i,
                        'point' => rand(0, 10),
                        'type' => $type,
                    ]);
                }
            }
        }
    }
}
