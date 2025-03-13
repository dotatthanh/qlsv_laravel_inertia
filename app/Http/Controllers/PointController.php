<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Point;
use App\Services\PointService;
use App\Services\SubjectService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PointController extends Controller
{
    protected $pointService;

    protected $subjectService;

    public function __construct(PointService $pointService, SubjectService $subjectService)
    {
        $this->pointService = $pointService;
        $this->subjectService = $subjectService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(int $classId, Request $request)
    {
        return Inertia::render('point/Index', [
            'points' => $this->pointService->getPointList($classId, $request),
            'classData' => Classes::find($classId),
            'subjects' => $this->subjectService->getAllSubject(),
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Point $point)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Point $point)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Point $point)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Point $point)
    {
        //
    }
}
