<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubjectRequest;
use App\Models\Subject;
use App\Services\SubjectService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubjectController extends Controller
{
    protected $subjectService;

    public function __construct(SubjectService $subjectService)
    {
        $this->subjectService = $subjectService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('subject/Index', [
            'subjects' => $this->subjectService->getSubjectList($request),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('subject/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
    {
        Subject::create(['name' => $request->name]);

        return redirect()->route('subjects.index')->with('alert_success', 'Thêm môn học thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return Inertia::render('subject/Edit', [
            'data' => $subject,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSubjectRequest $request, Subject $subject)
    {
        $subject->update(['name' => $request->name]);

        return redirect()->route('subjects.index')->with('alert_success', 'Cập nhật môn học thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        // if ($subject->users()->count() > 0) {
        //     return redirect()->back()->with('alert_error', 'Không thể xóa môn học vì vẫn còn học sinh và giảng viên.');
        // }

        $subject->delete();

        return redirect()->back()->with('alert_success', 'Xóa môn học thành công.');
    }
}
