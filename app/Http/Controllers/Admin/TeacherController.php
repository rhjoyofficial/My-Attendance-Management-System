<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Teacher;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\StoreTeacherRequest;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user', 'classRoom')->paginate(10);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        $classes = ClassRoom::all();
        return view('admin.teachers.create', compact('classes'));
    }

    public function store(StoreTeacherRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->roles()->attach(Role::where('name', 'Teacher')->first());

        Teacher::create([
            'user_id' => $user->id,
            'class_id' => $request->class_id,
            'subject' => $request->subject,
        ]);

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher created.');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->user->delete();
        return back()->with('success', 'Teacher deleted.');
    }
}
