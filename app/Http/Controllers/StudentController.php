<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Services\StudentService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateStudentRequest;

class StudentController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(int $classId, Request $request)
    {
        return Inertia::render('user/student/Index', [
            'students' => $this->studentService->getStudentListByClass($classId, $request),
            'class_id' => $classId,
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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $classId, $studentId)
    {
        return Inertia::render('user/student/Edit', [
            'class_id' => $classId,
            'student' => User::find($studentId),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, $classId, $studentId)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'class_id' => $classId,
            'role' => "Sinh viên",
        ];
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        User::findOrFail($studentId)->update($data);
        return redirect()->route('students.index', $classId)->with('alert_success', 'Cập nhật sinh viên thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($classId, $studentId)
    {
        $user = User::find($studentId);

        if (!$user) {
            return redirect()->back()->with('alert_error', 'Không tìm thấy sinh viên.');
        }

        $user->delete();

        return redirect()->back()->with('alert_success', 'Xóa sinh viên thành công.');
    }
}
