<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PointService
{
    public function getPointList($classId, Request $request)
    {
        if (! $request->subject_id) {
            return new LengthAwarePaginator([], 0, 20);
        }

        $data = User::with([
            'oralTestScores' => fn ($query) => $query->where('subject_id', $request->subject_id),
            'quizScores' => fn ($query) => $query->where('subject_id', $request->subject_id),
            'midtermTestScores' => fn ($query) => $query->where('subject_id', $request->subject_id),
            'finalTestScores' => fn ($query) => $query->where('subject_id', $request->subject_id),
        ])->where([
            'role' => 'Sinh viên',
            'class_id' => $classId,
        ]);

        if ($request->search) {
            $data = $data->where('name', 'like', "%$request->search%");
        }

        return $data->orderByRaw("SUBSTRING_INDEX(name, ' ', -1) COLLATE utf8mb4_vietnamese_ci")
            ->paginate(20);
    }
}
