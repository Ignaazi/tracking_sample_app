<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Menampilkan Kanban Board Task (Hybrid: Support Web View & Flutter API)
    public function index(Request $request)
    {
        // Mengambil semua data task
        $tasks = Task::all();

        // HYBRID CHECK: Jika request datang dari API Flutter (mengharapkan JSON)
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json($tasks, 200);
        }

        // Jika request dari Browser Web Admin biasa, jalankan kode Blade kamu di bawah ini
        $todo = $tasks->where('status', 'To Do');
        $inProgress = $tasks->where('status', 'In Progress');
        $readyQa = $tasks->where('status', 'Ready for QA');
        $completed = $tasks->where('status', 'Completed');

        return view('admin.task.index', compact('todo', 'inProgress', 'readyQa', 'completed'));
    }

    // Memproses simpan data task baru (Hybrid: Support Modal Web & Flutter Form)
    public function store(Request $request)
    {
        // Menyelaraskan validasi dengan input form
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

        // Menyimpan ke database tabel task
        $task = Task::create($request->all());

        // HYBRID CHECK: Jika request dari Flutter API
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => 'success',
                'message' => 'Project Node successfully created via API.',
                'data' => $task
            ], 201);
        }

        // Jika request dari Web Admin biasa
        return redirect()->back()->with('success', 'Project Node successfully created.');
    }

    // Memproses pembaruan data task / status sub-process / status kanban
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

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

        // HYBRID CHECK: Jika pembaruan dipicu oleh Flutter API
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => 'success',
                'message' => 'Project specs successfully updated via API.',
                'data' => $task
            ], 200);
        }

        return redirect()->back()->with('success', 'Project specs successfully updated.');
    }

    // Memproses hapus data task
    public function destroy(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        // HYBRID CHECK: Jika dihapus via Flutter API
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => 'success',
                'message' => 'Project node successfully deleted via API.'
            ], 200);
        }

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