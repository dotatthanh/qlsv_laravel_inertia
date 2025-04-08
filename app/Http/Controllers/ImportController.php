<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\ClassService;
use App\Services\SubjectService;
use App\Http\Requests\ImportRequest;
use App\Imports\PointImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    protected $classService;
    protected $subjectService;

    public function __construct(ClassService $classService, SubjectService $subjectService)
    {
        $this->classService = $classService;
        $this->subjectService = $subjectService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('import/Index', [
            'classes' => $this->classService->getAllClasses(),
            'subjects' => $this->subjectService->getAllSubjects(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ImportRequest $request)
    {
        Excel::import(new PointImport($request->all()), $request->file);

        return redirect()->route('import.index')->with('alert_success', 'Nhập điểm thành công.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
