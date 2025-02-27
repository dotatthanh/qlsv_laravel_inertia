<?php

namespace App\Services;

use App\Models\Classes;
use Illuminate\Http\Request;

class ClassService
{
    public function getClassList(Request $request)
    {
        $data = Classes::query();

        if ($request->search) {
            $data = $data->where('name', 'like', "%$request->search%");
        }

        $data = $data->orderBy('name')
            ->paginate(20);

        return $data;
    }
}
