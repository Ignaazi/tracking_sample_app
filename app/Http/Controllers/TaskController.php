<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Menampilkan Kanban Board Task
    public function index()
    {
        // Mengambil semua data task
        $tasks = Task::all();

        // Mengelompokkan data berdasarkan status kanban masing-masing
        $todo = $tasks->where('status', 'To Do');
        $inProgress = $tasks->where('status', 'In Progress');
        $readyQa = $tasks->where('status', 'Ready for QA');
        $completed = $tasks->where('status', 'Completed');

        // FIXED: Memastikan return view mengarah ke folder tunggal 'task'
        return view('admin.task.index', compact('todo', 'inProgress', 'readyQa', 'completed'));
    }

    // Memproses simpan data task baru dari Modal Create
    public function store(Request $request)
    {
        // Menyelaraskan validasi dengan input form modal-create-task
        $request->validate([
            'project_name'       => 'required|string|max:255',
            'customer'           => 'required|string|max:255',
            'item_code'          => 'required|string|max:255',
            'sap_number'         => 'required|string|max:255',
            'brand_family'       => 'required|string|max:255',
            'market'             => 'required|string|max:255',
            'ascis_pd'           => 'nullable|string|max:255',
            'cs_brand'           => 'nullable|string|max:255',
            'cs_hw'              => 'nullable|string|max:255',
            'ghw_set'            => 'nullable|string|max:255',
            'status'             => 'required|in:To Do,In Progress,Ready for QA,Completed',
            'development_status' => 'required|in:Active,Testing',
            'remark'             => 'nullable|string',
        ]);

        Task::create($request->all());

        return redirect()->back()->with('success', 'Project Node successfully created.');
    }

    // Memproses pembaruan data task / status sub-process / status kanban
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        // Validasi dibuat fleksibel (sometimes) karena form ini dipakai bersamaan oleh:
        // 1. Modal Full Edit Specs (banyak field)
        // 2. Modal Sub-Process Checklist (hanya kirim satu status sub-process saja)
        $request->validate([
            'project_name'       => 'sometimes|required|string|max:255',
            'customer'           => 'sometimes|required|string|max:255',
            'item_code'          => 'sometimes|required|string|max:255',
            'sap_number'         => 'sometimes|required|string|max:255',
            'brand_family'       => 'sometimes|required|string|max:255',
            'market'             => 'sometimes|required|string|max:255',
            'ascis_pd'           => 'nullable|string|max:255',
            'cs_brand'           => 'nullable|string|max:255',
            'cs_hw'              => 'nullable|string|max:255',
            'ghw_set'            => 'nullable|string|max:255',
            'status'             => 'sometimes|required|in:To Do,In Progress,Ready for QA,Completed',
            'development_status' => 'sometimes|required|in:Active,Testing',
            'layout_status'      => 'sometimes|required|in:Pending,In Progress,Completed',
            'baan_status'        => 'sometimes|required|in:Pending,In Progress,Completed',
            'promp_status'       => 'sometimes|required|in:Pending,In Progress,Completed',
            'job_bag_status'     => 'sometimes|required|in:Pending,In Progress,Completed',
            'remark'             => 'nullable|string',
        ]);

        $task->update($request->all());

        return redirect()->back()->with('success', 'Project specs successfully updated.');
    }

    // Memproses hapus data task
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()->back()->with('success', 'Project node successfully deleted.');
    }

    public function tableIndex()
    {
    // Mengambil semua data task diurutkan dari yang terbaru dimasukkan
    $tasks = Task::orderBy('created_at', 'desc')->get();

    // Diarahkan ke file view table yang terpisah
    return view('admin.task.table', compact('tasks'));
   }
}