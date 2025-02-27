<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

class StudentService
{
    public function getStudentListByClass($classId, Request $request)
    {
        $data = User::where([
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
