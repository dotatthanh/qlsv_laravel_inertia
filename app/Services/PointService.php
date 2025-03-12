<?php

namespace App\Services;

use App\Models\Point;
use App\Models\User;
use Illuminate\Http\Request;

class PointService
{
    public function getPointList($classId, Request $request)
    {
        // $data = Point::with('user')->where('class_id', $classId);

        // if ($request->search) {
        //     $data = $data->whereHas('user', function ($query) use($request) {
        //         $query->where('name',  'like', "%$request->search%");
        //     });
        // }

        // $data = $data
        //     // ->orderBy('name')
        //     ->paginate(20);

        // return $data;

        $data = User::with(['oralTestScores', 'quizScores', 'midtermTestScores', 'finalTestScores'])
            ->where([
                'role' => 'Sinh viên',
                'class_id' => $classId,
            ]);

        if ($request->search) {
            $data = $data->where('name', 'like', "%$request->search%");
        }

        $data = $data->orderByRaw("SUBSTRING_INDEX(name, ' ', -1) COLLATE utf8mb4_vietnamese_ci")
            ->paginate(20);

        return $data;
    }
}
