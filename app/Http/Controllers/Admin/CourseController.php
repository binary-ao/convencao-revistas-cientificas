<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCourseRequest;
use App\Http\Requests\Admin\UpdateCourseRequest;
use App\Models\Course;
use App\Models\Event;
use App\Models\Speaker;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        return view('admin.courses.index', [
            'courses' => Course::with('trainer')->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.courses.create', ['speakers' => Speaker::orderBy('name')->get()]);
    }

    public function store(StoreCourseRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['event_id'] = Event::current()->id;
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Course::create($data);

        return redirect()->route('admin.courses.index')->with('status', 'Curso criado com sucesso.');
    }

    public function edit(Course $course): View
    {
        return view('admin.courses.edit', ['course' => $course, 'speakers' => Speaker::orderBy('name')->get()]);
    }

    public function update(UpdateCourseRequest $request, Course $course): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $course->update($data);

        return redirect()->route('admin.courses.index')->with('status', 'Curso actualizado com sucesso.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->route('admin.courses.index')->with('status', 'Curso removido.');
    }
}
