<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CreateTask;
use App\Models\ItemSpec;
use App\Models\Task;
use App\Models\Timeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Menampilkan Halaman Project Development Roadmap (Gantt Chart & Master Registry)
     */
    public function roadmapIndex()
    {
        // Ambil data utama dari CreateTask beserta relasi Task dan Timelines
        $tasks = CreateTask::orderBy('created_at', 'desc')->get()->map(function ($cTask) {
            // Cari data di tabel 'task' berdasarkan item_code
            $taskRecord = Task::with('timelines')->where('item_code', $cTask->item_code)->first();

            // Default status
            $status = 'To Do';

            if ($taskRecord) {
                $status = $taskRecord->status ?? 'To Do';

                // Jika ada checklist di tabel timelines, kalkulasi ulang status secara presisi
                if ($taskRecord->timelines->count() > 0) {
                    $totalItems = $taskRecord->timelines->count();
                    $completedItems = $taskRecord->timelines->where('is_completed', 1)->count();

                    if ($completedItems === $totalItems && $totalItems > 0) {
                        $status = 'Completed';
                    } elseif ($completedItems > 0) {
                        $status = 'In Progress';
                    } else {
                        $status = 'To Do';
                    }

                    // Sync status terbaru ke database tabel task
                    $taskRecord->update(['status' => strtolower(str_replace(' ', '-', $status))]);
                }
            }

            // Tempelkan atribut yang dibutuhkan Blade Gantt Chart
            $cTask->id = $taskRecord ? $taskRecord->id : $cTask->id;
            $cTask->status = $status;
            $cTask->development_status = $taskRecord->development_status ?? 'Active';
            $cTask->sap_number = $taskRecord->sap_number ?? '-';

            return $cTask;
        });

        return view('admin.task.roadmap', compact('tasks'));
    }

    /**
     * Menampilkan Halaman Task List Project - Kanban Board
     */
    public function index()
    {
        // Ambil seluruh data Task (Model Eloquent) beserta relasi itemSpecs
        $tasks = Task::with(['itemSpecs'])->orderBy('created_at', 'desc')->get();

        // Pemetaan default jika ada record CreateTask yang belum tercatat di tabel task
        $createTasks = CreateTask::with(['itemSpecs'])->get();
        foreach ($createTasks as $cTask) {
            $exists = $tasks->firstWhere('item_code', $cTask->item_code);
            if (!$exists) {
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

        // Kelompokkan data ke variabel yang dibutuhkan Blade Kanban Board
        $todoTasks       = $tasks->filter(function($t) {
            return in_array(strtolower(trim($t->status ?? '')), ['todo', 'to do', '']);
        });

        $inProgressTasks = $tasks->filter(function($t) {
            return in_array(strtolower(trim($t->status ?? '')), ['in-progress', 'in progress', 'progress']);
        });

        $completedTasks  = $tasks->filter(function($t) {
            return in_array(strtolower(trim($t->status ?? '')), ['completed', 'done']);
        });

        return view('admin.task.index', compact('todoTasks', 'inProgressTasks', 'completedTasks'));
    }

    /**
     * Menampilkan Halaman Detail Sub-Process Checklist & Timeline (subProcess.blade.php)
     */
    public function subProcess($id)
    {
        // Cari data berdasarkan ID atau Item Code
        $createTask = CreateTask::find($id);
        if (!$createTask) {
            $createTask = CreateTask::where('item_code', $id)->firstOrFail();
        }

        // Pastikan record di tabel 'task' selalu tersedia
        $task = Task::firstOrCreate(
            ['item_code' => $createTask->item_code],
            [
                'brand_family'         => $createTask->brand_family,
                'market'               => $createTask->market,
                'project_name'         => $createTask->project_name,
                'customer'             => $createTask->customer,
                'information_received' => $createTask->information_received,
                'plm_released'         => $createTask->plm_released,
                'status'               => 'todo',
                'layout_status'        => 'Pending',
                'baan_status'          => 'Pending',
                'promp_status'         => 'Pending',
                'job_bag_status'       => 'Pending',
            ]
        );

        $task->load('timelines');
        $task->setRelation('itemSpecs', $createTask->itemSpecs ?? collect());

        // Kelompokkan timeline berdasarkan section_key (layout, baan, promp, job_bag)
        $existingChecklists = $task->timelines->groupBy('section_key');

        return view('admin.task.subProcess', compact('task', 'createTask', 'existingChecklists'));
    }

    /**
     * Menyimpan/Memperbarui Sub-Process Checklist ke Tabel Timelines
     */
    public function updateSubStatus(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            $createTask = CreateTask::findOrFail($id);
            $task = Task::firstOrCreate(
                ['item_code' => $createTask->item_code],
                [
                    'brand_family'         => $createTask->brand_family,
                    'market'               => $createTask->market,
                    'project_name'         => $createTask->project_name,
                    'customer'             => $createTask->customer,
                    'information_received' => $createTask->information_received,
                    'plm_released'         => $createTask->plm_released,
                    'status'               => 'todo',
                ]
            );
        }

        DB::transaction(function () use ($request, $task) {
            // Hapus data timeline lama terkait task ini untuk digantikan data terbaru
            Timeline::where('task_id', $task->id)->delete();

            $totalItems = 0;
            $completedItems = 0;

            if ($request->has('checklists')) {
                foreach ($request->checklists as $sectionKey => $items) {
                    foreach ($items as $item) {
                        if (!empty($item['title'])) {
                            $isDone = isset($item['done']) && $item['done'] == '1';
                            $totalItems++;
                            if ($isDone) $completedItems++;

                            Timeline::create([
                                'task_id'          => $task->id,
                                'project_name'     => $task->project_name ?? 'Project Task',
                                'section_key'      => $sectionKey,
                                'task_title'       => $item['title'],
                                'phase'            => 'Develop',
                                'start_date'       => !empty($item['start_date']) ? $item['start_date'] : null,
                                'end_date'         => !empty($item['end_date']) ? $item['end_date'] : null,
                                'is_completed'     => $isDone,
                                'progress_percent' => $isDone ? 100 : 0,
                            ]);
                        }
                    }
                }
            }

            // Hitung status otomatis untuk Kanban dan Roadmap
            if ($totalItems > 0) {
                if ($completedItems === $totalItems) {
                    $task->status = 'completed';
                } elseif ($completedItems > 0) {
                    $task->status = 'in-progress';
                } else {
                    $task->status = 'todo';
                }
                $task->save();
            }
        });

        return redirect()->back()->with('success', 'Sub-Process Checklist & Timeline berhasil diperbarui!');
    }

    /**
     * Menampilkan Halaman Data Project Status (Tabel Penggabungan)
     */
    public function tableIndex()
    {
        $tasks = CreateTask::with(['itemSpecs' => function($query) {
            $query->orderBy('sequence', 'asc');
        }])
        ->orderBy('created_at', 'desc')
        ->get();

        $taskStatuses = Task::pluck('status', 'item_code')->toArray();
        foreach ($tasks as $task) {
            $task->status = $taskStatuses[$task->item_code] ?? 'To Do';
        }

        return view('admin.task.table', compact('tasks'));
    }

    /**
     * Menyimpan Project Baru (Create Task)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_code' => 'required|string|max:255|unique:create_task,item_code|unique:task,item_code',
        ]);

        DB::transaction(function () use ($request) {
            $data28Fields = $request->only([
                'no', 'item_code', 'brand_family', 'market', 'project_name',
                'ascis_pd', 'customer', 'cs_brand', 'cs_hw', 'cpi_hw',
                's5_internal_approval', 'ghw_set', 'information_received',
                'plm_released', 'coi_number', 'green_light', 'td', 'machine',
                'board', 'board_u_code', 'board_a_code', 'type_cm',
                'die_cut_number', 's10_number', 's11_number', 's12_number',
                'cylinder_supplier', 'repro_by'
            ]);

            $createTask = CreateTask::create($data28Fields);

            $isComplete = true;
            foreach ($data28Fields as $key => $value) {
                if (is_null($value) || trim((string)$value) === '') {
                    $isComplete = false;
                    break;
                }
            }

            $computedStatus = $isComplete ? 'in-progress' : 'todo';

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
            $dataToUpdate = $request->only([
                'no', 'brand_family', 'market', 'project_name',
                'ascis_pd', 'customer', 'cs_brand', 'cs_hw', 'cpi_hw',
                's5_internal_approval', 'ghw_set', 'information_received',
                'plm_released', 'coi_number', 'green_light', 'td', 'machine',
                'board', 'board_u_code', 'board_a_code', 'type_cm',
                'die_cut_number', 's10_number', 's11_number', 's12_number',
                'cylinder_supplier', 'repro_by'
            ]);

            $createTask->update($dataToUpdate);

            $all28Fields = array_merge($dataToUpdate, ['item_code' => $createTask->item_code]);
            $isComplete = true;
            foreach ($all28Fields as $key => $value) {
                if (is_null($value) || trim((string)$value) === '') {
                    $isComplete = false;
                    break;
                }
            }

            $computedStatus = $isComplete ? 'in-progress' : 'todo';

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

        return redirect()->back()->with('success', 'Task berhasil dihapus!');
    }
}