<?php

namespace App\Services;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectService
{
    public function getSubjectList(Request $request)
    {
        $data = Subject::query();

        if ($request->search) {
            $data = $data->where('name', 'like', "%$request->search%");
        }

        $data = $data->orderBy('name')
            ->paginate(20);

        return $data;
    }

    public function getAllSubject()
    {
        return Subject::orderBy('name')->get();
    }
}
