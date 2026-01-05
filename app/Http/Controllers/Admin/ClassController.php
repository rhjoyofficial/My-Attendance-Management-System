<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = ClassRoom::latest()->paginate(10);
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        return view('admin.classes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_name' => 'required|string|max:255',
            'section' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
        ]);

        ClassRoom::create($request->only(['class_name', 'section', 'subject']));

        return redirect()->route('admin.classes.index')->with('success', 'Class created.');
    }

    public function edit(ClassRoom $class)
    {
        return view('admin.classes.edit', compact('class'));
    }

    public function update(Request $request, ClassRoom $class)
    {
        $request->validate([
            'class_name' => 'required|string|max:255',
        ]);

        $class->update($request->only(['class_name', 'section', 'subject']));

        return redirect()->route('admin.classes.index')->with('success', 'Class updated.');
    }

    public function destroy(ClassRoom $class)
    {
        $class->delete();
        return back()->with('success', 'Class deleted.');
    }
}
