<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\StoreStudentRequest;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('user', 'class')->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $classes = ClassRoom::all();
        return view('admin.students.create', compact('classes'));
    }


    public function store(StoreStudentRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                $user->roles()->attach(Role::where('name', 'Student')->first());

                Student::create([
                    'user_id' => $user->id,
                    'roll_number' => $request->roll_number,
                    'class_id' => $request->class_id,
                ]);
            });

            return redirect()->route('admin.students.index')
                ->with('success', 'Student created successfully.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to create student: ' . $e->getMessage());
        }
    }

    public function destroy(Student $student)
    {
        $student->user->delete();
        return back()->with('success', 'Student deleted.');
    }
}
