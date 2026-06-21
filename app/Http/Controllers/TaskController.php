<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Menampilkan Kanban Board Task
    public function index()
    {
        $tasks = Task::orderBy('start_date', 'asc')->get();

        // Mengelompokkan data berdasarkan status kanban masing-masing
        $todo = $tasks->where('status', 'To Do');
        $inProgress = $tasks->where('status', 'In Progress');
        $readyQa = $tasks->where('status', 'Ready for QA');
        $completed = $tasks->where('status', 'Completed');

        return view('admin.task.index', compact('todo', 'inProgress', 'readyQa', 'completed'));
    }

    // Memproses simpan data task baru dari Modal
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:To Do,In Progress,Ready for QA,Completed',
            'priority' => 'required|in:Low,Medium,High',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Task::create($request->all());

        return redirect()->back()->with('success', 'Task successfully created.');
    }

    // Memproses pembaruan data task / status kanban
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:To Do,In Progress,Ready for QA,Completed',
            'priority' => 'required|in:Low,Medium,High',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $task->update($request->all());

        return redirect()->back()->with('success', 'Task successfully updated.');
    }

    // Memproses hapus data task
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->back()->with('success', 'Task successfully deleted.');
    }
}