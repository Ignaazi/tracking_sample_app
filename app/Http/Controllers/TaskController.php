<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Menampilkan Board Task (Sistem Filter 3 Status Utama)
    public function index(Request $request)
    {
        $tasks = Task::all();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json($tasks, 200);
        }

        $todo = $tasks->filter(function($task) {
            return in_array(strtolower($task->status), ['to do', 'todo']);
        });

        $inProgress = $tasks->filter(function($task) {
            return in_array(strtolower($task->status), ['in progress', 'in-progress']);
        });

        $completed = $tasks->filter(function($task) {
            return in_array(strtolower($task->status), ['completed', 'done']);
        });

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
            // General Info
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
            'main_design_attachment'  => 'nullable|string|max:255',
            'remark'                  => 'nullable|string',

            // Sub-process Trackers Validation (Sesuai ENUM DB)
            'layout_status'           => 'nullable|in:Pending,In Progress,Completed',
            'baan_status'             => 'nullable|in:Pending,In Progress,Completed',
            'promp_status'            => 'nullable|in:Pending,In Progress,Completed',
            'job_bag_status'          => 'nullable|in:Pending,In Progress,Completed',
        ]);

        $data = $request->all();

        // 1. Normalisasi Status Utama Board
        if (isset($data['status'])) {
            if (in_array(strtolower($data['status']), ['todo', 'to do'])) {
                $data['status'] = 'To Do';
            } elseif (in_array(strtolower($data['status']), ['in-progress', 'in progress'])) {
                $data['status'] = 'In Progress';
            } elseif (in_array(strtolower($data['status']), ['completed', 'done'])) {
                $data['status'] = 'Completed';
            }
        }

        // 2. Default Sub-status diset 'Pending' agar cocok dengan ENUM MySQL
        $data['layout_status']  = $request->input('layout_status', 'Pending');
        $data['baan_status']    = $request->input('baan_status', 'Pending');
        $data['promp_status']   = $request->input('promp_status', 'Pending');
        $data['job_bag_status'] = $request->input('job_bag_status', 'Pending');

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

    // Memproses pembaruan data (Update)
    public function update(Request $request, $id)
    {
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
            'main_design_attachment'  => 'nullable|string|max:255',
            
            // Sub-proses trackers sesuaikan dengan Opsi ENUM Database
            'layout_status'           => 'sometimes|required|in:Pending,In Progress,Completed',
            'baan_status'             => 'sometimes|required|in:Pending,In Progress,Completed',
            'promp_status'            => 'sometimes|required|in:Pending,In Progress,Completed',
            'job_bag_status'          => 'sometimes|required|in:Pending,In Progress,Completed',
            'remark'                  => 'nullable|string',
        ]);

        $data = $request->all();

        if (isset($data['status'])) {
            if (in_array(strtolower($data['status']), ['todo', 'to do'])) {
                $data['status'] = 'To Do';
            } elseif (in_array(strtolower($data['status']), ['in-progress', 'in progress'])) {
                $data['status'] = 'In Progress';
            } elseif (in_array(strtolower($data['status']), ['completed', 'done'])) {
                $data['status'] = 'Completed';
            }
        }

        $task->fill($data);

        // Otomatisasi Status Utama berdasarkan Sub-proses
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

    public function subProcess(Request $request, $id)
    {
        $task = Task::where('id', $id)->orWhere('item_code', $id)->firstOrFail();
        $type = $request->query('type', 'layout');

        $subTypes = [
            'layout' => ['title' => 'Layout Management Process', 'short' => 'Layout', 'field' => 'layout_status', 'icon' => 'bi-layers-half'],
            'baan'   => ['title' => 'BaaN ERP System Mapping', 'short' => 'BaaN', 'field' => 'baan_status', 'icon' => 'bi-cpu-fill'],
            'promp'  => ['title' => 'Promp Quality Verification', 'short' => 'Prompt', 'field' => 'promp_status', 'icon' => 'bi-terminal-fill'],
            'jobbag' => ['title' => 'Job Bag Production Release', 'short' => 'Job Bag', 'field' => 'job_bag_status', 'icon' => 'bi-briefcase-fill']
        ];

        if (!array_key_exists($type, $subTypes)) {
            $type = 'layout';
        }

        $currentTypeInfo = $subTypes[$type];
        $currentStatus = $task->{$currentTypeInfo['field']} ?? 'Pending';

        return view('admin.task.partials.sub-process', compact('task', 'type', 'subTypes', 'currentTypeInfo', 'currentStatus'));
    }

    public function previewSubProcess(Request $request, $id)
    {
        $task = Task::where('id', $id)->orWhere('item_code', $id)->firstOrFail();
        $type = $request->query('type', 'layout');

        $subTypes = [
            'layout' => ['title' => 'Layout Management Process', 'short' => 'Layout', 'field' => 'layout_status', 'icon' => 'bi-layers-half'],
            'baan'   => ['title' => 'BaaN ERP System Mapping', 'short' => 'BaaN', 'field' => 'baan_status', 'icon' => 'bi-cpu-fill'],
            'promp'  => ['title' => 'Promp Quality Verification', 'short' => 'Prompt', 'field' => 'promp_status', 'icon' => 'bi-terminal-fill'],
            'jobbag' => ['title' => 'Job Bag Production Release', 'short' => 'Job Bag', 'field' => 'job_bag_status', 'icon' => 'bi-briefcase-fill']
        ];

        if (!array_key_exists($type, $subTypes)) {
            $type = 'layout';
        }

        $currentTypeInfo = $subTypes[$type];

        return view('admin.task.partials.previewSub-process', compact('task', 'type', 'subTypes', 'currentTypeInfo'));
    }

    public function updateSubProcess(Request $request, $id)
    {
        $task = Task::where('id', $id)->orWhere('item_code', $id)->firstOrFail();
        $type = $request->input('type', 'layout');

        $request->validate([
            'status' => 'required|in:Pending,In Progress,Completed',
        ]);

        $fieldMap = [
            'layout' => 'layout_status',
            'baan'   => 'baan_status',
            'promp'  => 'promp_status',
            'jobbag' => 'job_bag_status',
        ];

        if (isset($fieldMap[$type])) {
            $field = $fieldMap[$type];
            $task->{$field} = $request->input('status');

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
        }

        return redirect()->route('admin.task.subProcess', ['id' => $task->id, 'type' => $type])
                         ->with('success', 'Status sub-proses berhasil diperbarui!');
    }

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

    public function tableIndex()
    {
        $tasks = Task::orderBy('created_at', 'desc')->get();
        return view('admin.task.table', compact('tasks'));
    }
}