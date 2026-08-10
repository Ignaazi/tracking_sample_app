<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskListProjectController extends Controller
{
    public function index()
    {
        // Ambil semua task beserta relasi itemSpecs
        $tasks = Task::with('itemSpecs')->orderBy('created_at', 'desc')->get();

        // Filter fleksibel (mencakup huruf besar, kecil, spasi, maupun strip)
        $todoTasks = $tasks->filter(function($t) {
            $status = strtolower($t->status ?? '');
            return in_array($status, ['todo', 'to do', '']);
        });

        $inProgressTasks = $tasks->filter(function($t) {
            $status = strtolower($t->status ?? '');
            return in_array($status, ['in-progress', 'in progress', 'progress', 'ready for qa']);
        });

        $completedTasks = $tasks->filter(function($t) {
            $status = strtolower($t->status ?? '');
            return in_array($status, ['completed', 'done']);
        });

        return view('admin.task-list-project.index', compact(
            'todoTasks', 
            'inProgressTasks', 
            'completedTasks'
        ));
    }

    // Endpoint jika ingin update status via AJAX/Form
    public function updateSubStatus(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        
        $validated = $request->validate([
            'field'  => 'required|in:layout_status,baan_status,promp_status,job_bag_status,status',
            'status' => 'required|string'
        ]);

        $task->update([
            $validated['field'] => $validated['status']
        ]);

        return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui!']);
    }
}