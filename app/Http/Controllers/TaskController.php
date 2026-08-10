<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CreateTask;
use App\Models\ItemSpec;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Menampilkan Halaman Task List Project - Kanban Board
     */
    public function index()
    {
        // 1. Ambil seluruh data Task (Model Eloquent) beserta relasi itemSpecs
        $tasks = Task::with(['itemSpecs'])->orderBy('created_at', 'desc')->get();

        // 2. Pemetaan default jika ada record CreateTask yang belum tercatat di tabel task
        $createTasks = CreateTask::with(['itemSpecs'])->get();
        foreach ($createTasks as $cTask) {
            $exists = $tasks->firstWhere('item_code', $cTask->item_code);
            if (!$exists) {
                // Buat instance temporary agar tidak merusak tampilan Kanban
                $tempTask = new Task([
                    'item_code'            => $cTask->item_code,
                    'brand_family'         => $cTask->brand_family,
                    'market'               => $cTask->market,
                    'project_name'         => $cTask->project_name,
                    'customer'             => $cTask->customer,
                    'information_received' => $cTask->information_received,
                    'plm_released'         => $cTask->plm_released,
                    'status'               => 'todo',
                    'layout_status'        => 'Pending',
                    'baan_status'          => 'Pending',
                    'promp_status'         => 'Pending',
                    'job_bag_status'       => 'Pending',
                ]);
                $tempTask->setRelation('itemSpecs', $cTask->itemSpecs);
                $tasks->push($tempTask);
            }
        }

        // 3. Kelompokkan data ke variabel yang dibutuhkan index.blade.php
        $todo       = $tasks->filter(function($t) {
            return in_array(strtolower($t->status ?? ''), ['todo', 'to do', '']);
        });

        $inProgress = $tasks->filter(function($t) {
            return in_array(strtolower($t->status ?? ''), ['in-progress', 'in progress', 'progress']);
        });

        $completed  = $tasks->filter(function($t) {
            return in_array(strtolower($t->status ?? ''), ['completed', 'done']);
        });

        // 4. Return variabel $todo, $inProgress, $completed ke view
        return view('admin.task.index', compact('todo', 'inProgress', 'completed'));
    }

    /**
     * Menampilkan Halaman Data Project Status (Tabel Penggabungan 1-28 dan Item Specs 29-42)
     */
    public function tableIndex()
    {
        // Ambil data CreateTask beserta relasi itemSpecs dan data Task overview
        $tasks = CreateTask::with(['itemSpecs' => function($query) {
            $query->orderBy('sequence', 'asc');
        }])
        ->orderBy('created_at', 'desc')
        ->get();

        // Mapping status overview dari tabel task ke model CreateTask agar Blade dapat membacanya
        $taskStatuses = Task::pluck('status', 'item_code')->toArray();
        foreach ($tasks as $task) {
            $task->status = $taskStatuses[$task->item_code] ?? 'To Do';
        }

        // Return ke Blade table.blade.php
        return view('admin.task.table', compact('tasks'));
    }

    /**
     * Menyimpan Project Baru (Create Task)
     */
    public function store(Request $request)
    {
        // Validasi input utama (mencegah duplikat item_code)
        $validated = $request->validate([
            'item_code' => 'required|string|max:255|unique:create_task,item_code|unique:task,item_code',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Ambil 28 Field Murni create_task
            $data28Fields = $request->only([
                'no', 'item_code', 'brand_family', 'market', 'project_name',
                'ascis_pd', 'customer', 'cs_brand', 'cs_hw', 'cpi_hw',
                's5_internal_approval', 'ghw_set', 'information_received',
                'plm_released', 'coi_number', 'green_light', 'td', 'machine',
                'board', 'board_u_code', 'board_a_code', 'type_cm',
                'die_cut_number', 's10_number', 's11_number', 's12_number',
                'cylinder_supplier', 'repro_by'
            ]);

            // 2. Simpan ke tabel create_task
            $createTask = CreateTask::create($data28Fields);

            // 3. LOGIKA OTOMATIS: CEK APABILA SELURUH 28 FIELD TERISI
            $isComplete = true;
            foreach ($data28Fields as $key => $value) {
                if (is_null($value) || trim((string)$value) === '') {
                    $isComplete = false;
                    break;
                }
            }

            // Jika 28 terisi penuh -> 'in-progress', jika ada 1 kosong -> 'todo'
            $computedStatus = $isComplete ? 'in-progress' : 'todo';

            // 4. Auto Sync ke Tabel Overview task (Lengkap dengan sub-process default)
            Task::updateOrCreate(
                ['item_code' => $createTask->item_code],
                [
                    'brand_family'         => $createTask->brand_family,
                    'market'               => $createTask->market,
                    'project_name'         => $createTask->project_name,
                    'customer'             => $createTask->customer,
                    'information_received' => $createTask->information_received,
                    'plm_released'         => $createTask->plm_released,
                    'status'               => $computedStatus,
                    'layout_status'        => 'Pending',
                    'baan_status'          => 'Pending',
                    'promp_status'         => 'Pending',
                    'job_bag_status'       => 'Pending',
                ]
            );
        });

        return redirect()->back()->with('success', 'Task berhasil dibuat!');
    }

    /**
     * Memperbarui Project
     */
    public function update(Request $request, $id)
    {
        $createTask = CreateTask::findOrFail($id);

        DB::transaction(function () use ($request, $createTask) {
            // 1. Ambil 27 Field (KECUALI item_code)
            $dataToUpdate = $request->only([
                'no', 'brand_family', 'market', 'project_name',
                'ascis_pd', 'customer', 'cs_brand', 'cs_hw', 'cpi_hw',
                's5_internal_approval', 'ghw_set', 'information_received',
                'plm_released', 'coi_number', 'green_light', 'td', 'machine',
                'board', 'board_u_code', 'board_a_code', 'type_cm',
                'die_cut_number', 's10_number', 's11_number', 's12_number',
                'cylinder_supplier', 'repro_by'
            ]);

            // 2. Update tabel create_task
            $createTask->update($dataToUpdate);

            // 3. Evaluasi Ulang Status
            $all28Fields = array_merge($dataToUpdate, ['item_code' => $createTask->item_code]);
            $isComplete = true;
            foreach ($all28Fields as $key => $value) {
                if (is_null($value) || trim((string)$value) === '') {
                    $isComplete = false;
                    break;
                }
            }

            $computedStatus = $isComplete ? 'in-progress' : 'todo';

            // 4. Synchronize data ke Tabel Overview task
            Task::updateOrCreate(
                ['item_code' => $createTask->item_code],
                [
                    'brand_family'         => $createTask->brand_family,
                    'market'               => $createTask->market,
                    'project_name'         => $createTask->project_name,
                    'customer'             => $createTask->customer,
                    'information_received' => $createTask->information_received,
                    'plm_released'         => $createTask->plm_released,
                    'status'               => $computedStatus,
                ]
            );
        });

        return redirect()->back()->with('success', 'Project Specification berhasil diperbarui!');
    }

    /**
     * Menghapus Project
     */
    public function destroy($id)
    {
        $createTask = CreateTask::find($id);

        if (!$createTask) {
            $createTask = CreateTask::where('item_code', $id)->firstOrFail();
        }

        DB::transaction(function () use ($createTask) {
            ItemSpec::where('item_code', $createTask->item_code)->delete();
            Task::where('item_code', $createTask->item_code)->delete();
            $createTask->delete();
        });

        return redirect()->back()->with('success', 'Task beserta seluruh spesifikasinya berhasil dihapus!');
    }
}