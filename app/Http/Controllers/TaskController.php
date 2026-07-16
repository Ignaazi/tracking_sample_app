<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Menampilkan Board Task (Sistem Filter 3 Status Utama)
    public function index(Request $request)
    {
        // Mengambil semua data task
        $tasks = Task::all();

        // HYBRID CHECK: Jika request datang dari API Flutter (mengharapkan JSON)
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json($tasks, 200);
        }

        // Memetakan data ke 3 Status Utama
        $todo = $tasks->filter(function($task) {
            return in_array(strtolower($task->status), ['to do', 'todo']);
        });

        $inProgress = $tasks->filter(function($task) {
            return in_array(strtolower($task->status), ['in progress', 'in-progress']);
        });

        $completed = $tasks->filter(function($task) {
            return in_array(strtolower($task->status), ['completed', 'done']);
        });

        // Penggabungan data lama 'Ready for QA' ke in-progress agar tidak hilang
        $readyQa = $tasks->filter(function($task) {
            return strtolower($task->status) === 'ready for qa';
        });
        if ($readyQa->count() > 0) {
            $inProgress = $inProgress->merge($readyQa);
        }

        return view('admin.task.index', compact('todo', 'inProgress', 'completed'));
    }

    // Memproses simpan data task baru (Create)
    public function store(Request $request)
    {
        $request->validate([
            // Tab 1: General Info
            'project_name'            => 'required|string|max:255',
            'customer'                => 'required|string|max:255',
            'item_code'               => 'required|string|max:255',
            'sap_number'              => 'nullable|string|max:255',
            'brand_family'            => 'nullable|string|max:255',
            'market'                  => 'nullable|string|max:255',
            'ascis_pd'                => 'nullable|string|max:255',
            'cs_brand'                => 'nullable|string|max:255',
            'cs_hw'                   => 'nullable|string|max:255',
            'cpi_hw'                  => 'nullable|string|max:255',
            'status'                  => 'required|in:todo,in-progress,completed,To Do,In Progress,Completed',
            'development_status'      => 'required|in:Active,Testing',
            'end_date'                => 'nullable|date',

            // Tab 2: Technical Specs
            's5_internal_approval'    => 'nullable|string|max:255',
            'ghw_set'                 => 'nullable|string|max:255',
            'information_received'    => 'nullable|date',
            'plm_released'            => 'nullable|date',
            'coi_number'              => 'nullable|string|max:255',
            'green_light'             => 'nullable|string|max:255',
            'td'                      => 'nullable|string|max:255',
            'repro_by'                => 'nullable|string|max:255',

            // Tab 3: Board & Tooling Specs
            'machine'                 => 'nullable|string|max:255',
            'board'                   => 'nullable|string|max:255',
            'type_cm'                 => 'nullable|string|max:255',
            'board_u_code'            => 'nullable|string|max:255',
            'board_a_code'            => 'nullable|string|max:255',
            'die_cut_number'          => 'nullable|string|max:255',
            's10_number'              => 'nullable|string|max:255',
            's11_number'              => 'nullable|string|max:255',
            's12_number'              => 'nullable|string|max:255',
            'cylinder_supplier'       => 'nullable|string|max:255',
            'baan_cylinder'           => 'nullable|string|max:255',

            // Tab 4: Ink & Colour Specs
            'sequence_seq'            => 'nullable|string|max:255',
            'colour'                  => 'nullable|string|max:255',
            'film_number'             => 'nullable|string|max:255',
            'ink_system'              => 'nullable|string|max:255',
            'ink_code'                => 'nullable|string|max:255',
            'supplier_ink'            => 'nullable|string|max:255',
            'baan_ink_code'           => 'nullable|string|max:255',
            'coverage_percent'        => 'nullable|numeric|min:0|max:100',
            'usage_kg_th'             => 'nullable|numeric|min:0',
            'angle_anilox'            => 'nullable|string|max:255',
            'main_design_attachment'  => 'nullable|string|max:500',
            'remark'                  => 'nullable|string',
        ]);

        $data = $request->all();

        // Nilai default sub-proses
        $data['layout_status']  = $request->input('layout_status', 'Pending');
        $data['baan_status']    = $request->input('baan_status', 'Pending');
        $data['promp_status']   = $request->input('promp_status', 'Pending');
        $data['job_bag_status'] = $request->input('job_bag_status', 'Pending');

        // Normalisasi format status input ke Database (Enum)
        if (isset($data['status'])) {
            if ($data['status'] === 'todo') {
                $data['status'] = 'To Do';
            } elseif ($data['status'] === 'in-progress') {
                $data['status'] = 'In Progress';
            } elseif ($data['status'] === 'completed') {
                $data['status'] = 'Completed';
            }
        }

        // Jalankan logika penyesuaian otomatisasi status utama berdasarkan sub-proses
        if (
            $data['layout_status'] === 'Completed' && 
            $data['baan_status'] === 'Completed' && 
            $data['promp_status'] === 'Completed' && 
            $data['job_bag_status'] === 'Completed'
        ) {
            $data['status'] = 'Completed';
        } elseif (
            $data['layout_status'] === 'Pending' && 
            $data['baan_status'] === 'Pending' && 
            $data['promp_status'] === 'Pending' && 
            $data['job_bag_status'] === 'Pending'
        ) {
            $data['status'] = 'To Do';
        } else {
            $data['status'] = 'In Progress';
        }

        $task = Task::create($data);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => 'success',
                'message' => 'Project Node successfully created via API.',
                'data' => $task
            ], 201);
        }

        return redirect()->back()->with('success', 'Project Node successfully created.');
    }

    // Memproses pembaruan data (Update - mendukung parameter ID / item_code)
    public function update(Request $request, $id)
    {
        // Cari data berdasarkan primary key ID atau item_code jika ID tidak ditemukan
        $task = Task::where('id', $id)->orWhere('item_code', $id)->firstOrFail();

        $request->validate([
            'project_name'            => 'sometimes|required|string|max:255',
            'customer'                => 'sometimes|required|string|max:255',
            'item_code'               => 'sometimes|required|string|max:255',
            'sap_number'              => 'nullable|string|max:255',
            'brand_family'            => 'nullable|string|max:255',
            'market'                  => 'nullable|string|max:255',
            'ascis_pd'                => 'nullable|string|max:255',
            'cs_brand'                => 'nullable|string|max:255',
            'cs_hw'                   => 'nullable|string|max:255',
            'cpi_hw'                  => 'nullable|string|max:255',
            'status'                  => 'sometimes|required|in:todo,in-progress,completed,To Do,In Progress,Completed',
            'development_status'      => 'sometimes|required|in:Active,Testing',
            'end_date'                => 'nullable|date',

            // Technical Specs
            's5_internal_approval'    => 'nullable|string|max:255',
            'ghw_set'                 => 'nullable|string|max:255',
            'information_received'    => 'nullable|date',
            'plm_released'            => 'nullable|date',
            'coi_number'              => 'nullable|string|max:255',
            'green_light'             => 'nullable|string|max:255',
            'td'                      => 'nullable|string|max:255',
            'repro_by'                => 'nullable|string|max:255',

            // Board & Tooling Specs
            'machine'                 => 'nullable|string|max:255',
            'board'                   => 'nullable|string|max:255',
            'type_cm'                 => 'nullable|string|max:255',
            'board_u_code'            => 'nullable|string|max:255',
            'board_a_code'            => 'nullable|string|max:255',
            'die_cut_number'          => 'nullable|string|max:255',
            's10_number'              => 'nullable|string|max:255',
            's11_number'              => 'nullable|string|max:255',
            's12_number'              => 'nullable|string|max:255',
            'cylinder_supplier'       => 'nullable|string|max:255',
            'baan_cylinder'           => 'nullable|string|max:255',

            // Ink & Colour Specs
            'sequence_seq'            => 'nullable|string|max:255',
            'colour'                  => 'nullable|string|max:255',
            'film_number'             => 'nullable|string|max:255',
            'ink_system'              => 'nullable|string|max:255',
            'ink_code'                => 'nullable|string|max:255',
            'supplier_ink'            => 'nullable|string|max:255',
            'baan_ink_code'           => 'nullable|string|max:255',
            'coverage_percent'        => 'nullable|numeric|min:0|max:100',
            'usage_kg_th'             => 'nullable|numeric|min:0',
            'angle_anilox'            => 'nullable|string|max:255',
            'main_design_attachment'  => 'nullable|string|max:500',
            
            // Sub-proses trackers
            'layout_status'           => 'sometimes|required|in:Pending,In Progress,Completed',
            'baan_status'             => 'sometimes|required|in:Pending,In Progress,Completed',
            'promp_status'            => 'sometimes|required|in:Pending,In Progress,Completed',
            'job_bag_status'          => 'sometimes|required|in:Pending,In Progress,Completed',
            'remark'                  => 'nullable|string',
        ]);

        $data = $request->all();

        // Normalisasi status saat update
        if (isset($data['status'])) {
            if ($data['status'] === 'todo') {
                $data['status'] = 'To Do';
            } elseif ($data['status'] === 'in-progress') {
                $data['status'] = 'In Progress';
            } elseif ($data['status'] === 'completed') {
                $data['status'] = 'Completed';
            }
        }

        // Terapkan data input ke model
        $task->fill($data);

        // OTOMATISASI WORKFLOW STATUS UTAMA
        $layout = $task->layout_status;
        $baan   = $task->baan_status;
        $promp  = $task->promp_status;
        $jobBag = $task->job_bag_status;

        if ($layout === 'Completed' && $baan === 'Completed' && $promp === 'Completed' && $jobBag === 'Completed') {
            $task->status = 'Completed';
        } elseif ($layout === 'Pending' && $baan === 'Pending' && $promp === 'Pending' && $jobBag === 'Pending') {
            $task->status = 'To Do';
        } else {
            $task->status = 'In Progress';
        }

        $task->save();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => 'success',
                'message' => 'Project specs successfully updated.',
                'data' => $task
            ], 200);
        }

        return redirect()->back()->with('success', 'Project specs successfully updated.');
    }

    // Memproses hapus data task (Delete)
    public function destroy(Request $request, $id)
    {
        $task = Task::where('id', $id)->orWhere('item_code', $id)->firstOrFail();
        $task->delete();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => 'success',
                'message' => 'Project node successfully deleted via API.'
            ], 200);
        }

        return redirect()->back()->with('success', 'Project node successfully deleted.');
    }

    // Menampilkan halaman table list terpisah
    public function tableIndex()
    {
        $tasks = Task::orderBy('created_at', 'desc')->get();
        return view('admin.task.table', compact('tasks'));
    }
}