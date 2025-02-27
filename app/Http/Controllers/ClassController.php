<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClassRequest;
use App\Models\Classes;
use App\Services\ClassService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClassController extends Controller
{
    protected $classService;

    public function __construct(ClassService $classService)
    {
        $this->classService = $classService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('class/Index', [
            'classes' => $this->classService->getClassList($request),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('class/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClassRequest $request)
    {
        Classes::create(['name' => $request->name]);

        return redirect()->route('classes.index')->with('alert_success', 'Thêm lớp thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classes $class)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classes $class)
    {
        return Inertia::render('class/Edit', [
            'data' => $class,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreClassRequest $request, Classes $class)
    {
        $class->update(['name' => $request->name]);

        return redirect()->route('classes.index')->with('alert_success', 'Cập nhật lớp thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classes $class)
    {
        if ($class->users()->count() > 0) {
            return redirect()->back()->with('alert_error', 'Không thể xóa lớp vì vẫn còn học sinh và giảng viên.');
        }

        $class->delete();

        return redirect()->back()->with('alert_success', 'Xóa lớp thành công.');
    }
}
