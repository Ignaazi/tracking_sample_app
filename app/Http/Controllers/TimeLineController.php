<?php

namespace App\Http\Controllers;

use App\Models\Timeline;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function index()
    {
        // Ambil data timeline dan pisahkan berdasarkan kategori fasenya
        $timelines = Timeline::orderBy('start_date', 'asc')->get();
        return view('admin.timeline.index', compact('timelines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_name'     => 'required|string|max:255',
            'phase'            => 'required|in:Plan,Test,Develop,Launch',
            'task_title'       => 'required|string|max:255',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after_or_equal:start_date',
            'progress_percent' => 'required|integer|between:0,100',
        ]);

        Timeline::create($request->all());

        return redirect()->route('admin.timelines.index')->with('success', 'Task timeline berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $timeline = Timeline::findOrFail($id);

        $request->validate([
            'project_name'     => 'required|string|max:255',
            'phase'            => 'required|in:Plan,Test,Develop,Launch',
            'task_title'       => 'required|string|max:255',
            'start_date'       => 'required|date',
            'end_date'         => 'required|date|after_or_equal:start_date',
            'progress_percent' => 'required|integer|between:0,100',
        ]);

        $timeline->update($request->all());

        return redirect()->route('admin.timelines.index')->with('success', 'Timeline berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $timeline = Timeline::findOrFail($id);
        $timeline->delete();

        return redirect()->route('admin.timelines.index')->with('success', 'Timeline berhasil dihapus!');
    }
}