<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentService
{
    public function getStudentListByClass($classId, Request $request)
    {
        $users = User::where([
            'role' => 'Sinh viên',
            'class_id' => $classId
        ]);

        if ($request->search) {
            $users = $users->where('name', 'like', "%$request->search%");
        }

        $users = $users->orderByRaw("SUBSTRING_INDEX(name, ' ', -1) COLLATE utf8mb4_vietnamese_ci")
            ->paginate(20);
        return $users;
    }
}
