<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TimelineController;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskListProjectController extends Controller
{
    /**
     * Menampilkan Halaman Kanban Task List Project
     */
    public function index()
    {
        // Ambil task beserta relasi itemSpecs dan timelines
        $tasks = Task::with(['itemSpecs', 'timelines'])->orderBy('created_at', 'desc')->get();

        // Transformasi & auto-generate timeline jika belum ada, lalu hitung status dinamis sub-process
        $tasks->transform(function ($task) {
            
            // Auto-generate default checklist jika project belum memiliki timeline
            if ($task->timelines->count() === 0) {
                TimelineController::generateDefaultChecklists($task);
                $task->load('timelines');
            }

            $timelines = $task->timelines;

            // Kalkulasi status dinamis per sub-process
            $task->layout_status  = $this->calculateSectionStatus($timelines, 'layout');
            $task->baan_status    = $this->calculateSectionStatus($timelines, 'baan');
            $task->promp_status   = $this->calculateSectionStatus($timelines, 'promp');
            $task->job_bag_status = $this->calculateSectionStatus($timelines, 'job');

            return $task;
        });

        // Filter data per kolom Kanban Board
        $todoTasks = $tasks->filter(function($t) {
            $status = strtolower(trim($t->status ?? ''));
            return in_array($status, ['todo', 'to do', 'pending', '']);
        });

        $inProgressTasks = $tasks->filter(function($t) {
            $status = strtolower(trim($t->status ?? ''));
            return in_array($status, ['in-progress', 'in progress', 'progress', 'ready for qa']);
        });

        $completedTasks = $tasks->filter(function($t) {
            $status = strtolower(trim($t->status ?? ''));
            return in_array($status, ['completed', 'done']);
        });

        return view('admin.task-list-project.index', compact(
            'todoTasks', 
            'inProgressTasks', 
            'completedTasks'
        ));
    }

    /**
     * Helper Function untuk menghitung status dinamis sub-process dari tabel timelines
     */
    private function calculateSectionStatus($timelines, $keyword)
    {
        $sectionItems = $timelines->filter(function ($item) use ($keyword) {
            return str_contains(strtolower($item->section_key ?? ''), $keyword);
        });

        $total = $sectionItems->count();
        if ($total === 0) {
            return 'Pending';
        }

        $completed = $sectionItems->where('is_completed', 1)->count();

        if ($completed === $total) {
            return 'Completed';
        } elseif ($completed > 0) {
            return 'In Progress';
        }

        return 'Pending';
    }

    /**
     * Endpoint update status manual via AJAX / Form dari Kanban
     */
    public function updateSubStatus(Request $request, $id)
    {
        $task = Task::where('id', $id)->orWhere('item_code', $id)->firstOrFail();
        
        $validated = $request->validate([
            'field'  => 'required|in:layout_status,baan_status,promp_status,job_bag_status,status',
            'status' => 'required|string'
        ]);

        $task->update([
            $validated['field'] => $validated['status']
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui!']);
        }

        return redirect()->back()->with('success', 'Status berhasil diperbarui!');
    }
}