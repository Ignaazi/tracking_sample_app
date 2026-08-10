<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    /**
     * Display project development analytics & task timeline (Master Gantt).
     */
    public function index()
    {
        // Ambil data task dan urutkan berdasarkan tanggal dibuat/informasi diterima
        $tasks = Task::orderBy('created_at', 'desc')->get();

        return view('admin.timeline.index', compact('tasks'));
    }

    /**
     * Display detail timeline per project (Sub-process Gantt & Stage Management).
     */
    public function detail($id)
    {
        // Cari project berdasarkan item_code ATAU id database
        $task = Task::where('item_code', $id)
                    ->orWhere('id', $id)
                    ->firstOrFail();

        return view('admin.timeline.detailTimeline', compact('task'));
    }

    /**
     * Store new task item into database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_code'            => 'required|string|max:255',
            'project_name'         => 'nullable|string|max:255',
            'brand_family'         => 'nullable|string|max:255',
            'market'               => 'nullable|string|max:255',
            'customer'             => 'nullable|string|max:255',
            'information_received' => 'nullable|date',
            'plm_released'         => 'nullable|date|after_or_equal:information_received',
            'sap_number'           => 'nullable|string|max:255',
            'status'               => 'required|in:To Do,In Progress,Completed',
            'development_status'   => 'required|in:Active,Testing',
        ]);

        Task::create($validated);

        return redirect()->route('admin.timelines.index')->with('success', 'Project task berhasil ditambahkan!');
    }

    /**
     * Update existing task item.
     */
    public function update(Request $request, $id)
    {
        $task = Task::where('item_code', $id)->orWhere('id', $id)->firstOrFail();

        $validated = $request->validate([
            'item_code'            => 'required|string|max:255',
            'project_name'         => 'nullable|string|max:255',
            'brand_family'         => 'nullable|string|max:255',
            'market'               => 'nullable|string|max:255',
            'customer'             => 'nullable|string|max:255',
            'information_received' => 'nullable|date',
            'plm_released'         => 'nullable|date|after_or_equal:information_received',
            'sap_number'           => 'nullable|string|max:255',
            'status'               => 'required|in:To Do,In Progress,Completed',
            'development_status'   => 'required|in:Active,Testing',
        ]);

        $task->update($validated);

        return redirect()->route('admin.timelines.index')->with('success', 'Project task berhasil diperbarui!');
    }

    /**
     * Delete task item from database.
     */
    public function destroy($id)
    {
        $task = Task::where('item_code', $id)->orWhere('id', $id)->firstOrFail();
        $itemCode = $task->item_code;
        
        $task->delete();

        return redirect()->route('admin.timelines.index')->with('success', "Project task [{$itemCode}] berhasil dihapus!");
    }
}