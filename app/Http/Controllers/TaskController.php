<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TimelineController;
use App\Models\ItemSpec;
use App\Models\Task;
use App\Models\Timeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Daftar 27 Field Utama Spesifikasi Master Project
     */
    private $masterFields = [
        'item_code', 'brand_family', 'market', 'project_name', 'ascis_pd', 'customer',
        'cs_brand', 'cs_hw', 'cpi_hw', 's5_internal_approval', 'ghw_set',
        'information_received', 'plm_released', 'coi_number', 'green_light', 'td',
        'machine', 'board', 'board_u_code', 'board_a_code', 'type_cm', 'die_cut_number',
        's10_number', 's11_number', 's12_number', 'cylinder_supplier', 'repro_by'
    ];

    /**
     * Menampilkan Halaman Project Development Roadmap (Gantt Chart & Master Registry)
     */
    public function roadmapIndex()
    {
        $tasks = Task::with('timelines')->orderBy('created_at', 'desc')->get()->map(function ($task) {
            
            if ($task->timelines->count() === 0) {
                TimelineController::generateDefaultChecklists($task);
                $task->load('timelines');
            }

            $status = $task->status ?? 'todo';

            if ($task->timelines->count() > 0) {
                $totalItems = $task->timelines->count();
                $completedItems = $task->timelines->where('is_completed', 1)->count();

                if ($completedItems === $totalItems && $totalItems > 0) {
                    $status = 'completed';
                } elseif ($completedItems > 0) {
                    $status = 'in-progress';
                } else {
                    $status = 'todo';
                }

                $task->update(['status' => $status]);
            }

            $task->status = $status;
            $task->development_status = $task->development_status ?? 'Active';
            $task->sap_number = $task->sap_number ?? '-';

            return $task;
        });

        return view('admin.task.roadmap', compact('tasks'));
    }

    /**
     * Menampilkan Halaman Task List Project - Kanban / Table View
     */
    public function index()
    {
        $tasks = Task::with(['itemSpecs', 'timelines'])->orderBy('created_at', 'desc')->get()->map(function($task) {
            
            if ($task->timelines->count() === 0) {
                TimelineController::generateDefaultChecklists($task);
                $task->load('timelines');
            }

            if (strtolower($task->status ?? '') !== 'completed') {
                $isComplete = true;
                foreach ($this->masterFields as $field) {
                    if (empty($task->$field)) {
                        $isComplete = false;
                        break;
                    }
                }
                $newStatus = $isComplete ? 'in-progress' : 'todo';
                if ($task->status !== $newStatus) {
                    $task->update(['status' => $newStatus]);
                }
            }
            return $task;
        });

        $todoTasks = $tasks->filter(function($t) {
            $status = strtolower(trim($t->status ?? ''));
            return in_array($status, ['todo', 'to do', '']);
        });

        $inProgressTasks = $tasks->filter(function($t) {
            $status = strtolower(trim($t->status ?? ''));
            return in_array($status, ['in-progress', 'in progress', 'progress', 'ready for qa']);
        });

        $completedTasks = $tasks->filter(function($t) {
            $status = strtolower(trim($t->status ?? ''));
            return in_array($status, ['completed', 'done']);
        });

        return view('admin.task.index', compact('tasks', 'todoTasks', 'inProgressTasks', 'completedTasks'));
    }

    /**
     * Menampilkan Halaman Detail Sub-Process Checklist & Timeline
     */
    public function subProcess($id)
    {
        $task = Task::where('id', $id)->orWhere('item_code', $id)->firstOrFail();
        $task->load(['timelines', 'itemSpecs']);

        if ($task->timelines->count() === 0) {
            TimelineController::generateDefaultChecklists($task);
            $task->load('timelines');
        }

        // Grouping dengan membersihkan akhiran _process agar match dengan form key view
        $existingChecklists = $task->timelines->groupBy(function($item) {
            return str_replace('_process', '', $item->section_key);
        });

        return view('admin.task.subProcess', compact('task', 'existingChecklists'));
    }

    /**
     * Menyimpan/Memperbarui Sub-Process Checklist & Status Task
     */
    public function updateSubStatus(Request $request, $id)
    {
        $task = Task::where('id', $id)->orWhere('item_code', $id)->firstOrFail();

        // Handle Update Status Tunggal via AJAX / Drag-and-Drop Kanban
        if ($request->has('field') || ($request->has('status') && !$request->has('checklists'))) {
            $validated = $request->validate([
                'field'  => 'nullable|string|in:layout_status,baan_status,promp_status,job_bag_status,status',
                'status' => 'required|string'
            ]);

            $fieldToUpdate = $validated['field'] ?? 'status';
            $task->update([$fieldToUpdate => $validated['status']]);

            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui!']);
            }
            return redirect()->back()->with('success', 'Status berhasil diperbarui!');
        }

        // Handle Update Timelines Sub-Process Checklist Form
        DB::transaction(function () use ($request, $task) {
            
            if ($request->has('checklists')) {
                $processedTimelineIds = [];

                foreach ($request->checklists as $sectionKey => $items) {
                    $formattedSectionKey = str_contains($sectionKey, '_process') ? $sectionKey : $sectionKey . '_process';

                    foreach ($items as $item) {
                        if (!empty($item['title'])) {
                            $isDone = isset($item['done']) && $item['done'] == '1';

                            $timeline = Timeline::updateOrCreate(
                                [
                                    'task_id'    => $task->id,
                                    'task_title' => $item['title'],
                                ],
                                [
                                    'project_name'     => $task->project_name ?? 'Project Task',
                                    'section_key'      => $formattedSectionKey,
                                    'phase'            => 'Develop',
                                    'start_date'       => !empty($item['start_date']) ? $item['start_date'] : null,
                                    'end_date'         => !empty($item['end_date']) ? $item['end_date'] : null,
                                    'is_completed'     => $isDone ? 1 : 0,
                                    'progress_percent' => $isDone ? 100 : 0,
                                ]
                            );

                            $processedTimelineIds[] = $timeline->id;
                        }
                    }
                }

                // Hapus item timeline yang dihapus user melalui interface form
                if (!empty($processedTimelineIds)) {
                    Timeline::where('task_id', $task->id)
                        ->whereNotIn('id', $processedTimelineIds)
                        ->delete();
                }
            }

            // Hitung ulang status task berdasarkan item timelines yang aktif
            $allTimelines = Timeline::where('task_id', $task->id)->get();
            $totalItems = $allTimelines->count();
            $completedItems = $allTimelines->where('is_completed', 1)->count();

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
     * Menampilkan Halaman Data Project Status Table
     */
    public function tableIndex()
    {
        $tasks = Task::with(['itemSpecs' => function($query) {
            $query->orderBy('sequence', 'asc');
        }, 'timelines'])
        ->orderBy('created_at', 'desc')
        ->get()
        ->map(function($task) {
            
            if ($task->timelines->count() === 0) {
                TimelineController::generateDefaultChecklists($task);
                $task->load('timelines');
            }

            if (strtolower($task->status ?? '') !== 'completed') {
                $isComplete = true;
                foreach ($this->masterFields as $field) {
                    if (empty($task->$field)) {
                        $isComplete = false;
                        break;
                    }
                }

                $expectedStatus = $isComplete ? 'in-progress' : 'todo';
                
                if (strtolower($task->status ?? '') !== $expectedStatus) {
                    $task->update(['status' => $expectedStatus]);
                    $task->status = $expectedStatus;
                }
            }
            return $task;
        });

        return view('admin.task.table', compact('tasks'));
    }

    /**
     * Menyimpan Project Task Baru & Auto-Generate Timeline
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_code'            => 'required|string|max:255|unique:task,item_code',
            'brand_family'         => 'nullable|string|max:255',
            'market'               => 'nullable|string|max:255',
            'project_name'         => 'nullable|string|max:255',
            'ascis_pd'             => 'nullable|string|max:255',
            'customer'             => 'nullable|string|max:255',
            'cs_brand'             => 'nullable|string|max:255',
            'cs_hw'                => 'nullable|string|max:255',
            'cpi_hw'               => 'nullable|string|max:255',
            's5_internal_approval' => 'nullable|string|max:255',
            'ghw_set'              => 'nullable|string|max:255',
            'information_received' => 'nullable|date',
            'plm_released'         => 'nullable|date',
            'coi_number'           => 'nullable|string|max:255',
            'green_light'          => 'nullable|date',
            'td'                   => 'nullable|string|max:255',
            'machine'              => 'nullable|string|max:255',
            'board'                => 'nullable|string|max:255',
            'board_u_code'         => 'nullable|string|max:255',
            'board_a_code'         => 'nullable|string|max:255',
            'type_cm'              => 'nullable|string|max:255',
            'die_cut_number'       => 'nullable|string|max:255',
            's10_number'           => 'nullable|string|max:255',
            's11_number'           => 'nullable|string|max:255',
            's12_number'           => 'nullable|string|max:255',
            'cylinder_supplier'    => 'nullable|string|max:255',
            'repro_by'             => 'nullable|string|max:255',
        ]);

        $latestTask = Task::latest('id')->first();
        $nextId = $latestTask ? $latestTask->id + 1 : 1;
        $formattedNo = sprintf('%02d', $nextId);
        $validated['no'] = $formattedNo;

        $isComplete = true;
        foreach ($this->masterFields as $field) {
            if (empty($validated[$field] ?? null)) {
                $isComplete = false;
                break;
            }
        }

        $defaultStatus = $isComplete ? 'in-progress' : 'todo';

        $taskData = array_merge($validated, [
            'status'             => $defaultStatus,
            'layout_status'      => 'Pending',
            'baan_status'        => 'Pending',
            'promp_status'       => 'Pending',
            'job_bag_status'     => 'Pending',
            'development_status' => 'Active',
        ]);

        $task = Task::create($taskData);
        TimelineController::generateDefaultChecklists($task);

        return redirect()->back()->with('success', "Project Task [No. {$formattedNo}] dan Timeline berhasil dibuat!");
    }

    /**
     * Memperbarui Project Specification pada Tabel Task
     */
    public function update(Request $request, $id)
    {
        $task = Task::where('id', $id)->orWhere('item_code', $id)->firstOrFail();

        $validated = $request->validate([
            'brand_family'         => 'nullable|string|max:255',
            'market'               => 'nullable|string|max:255',
            'project_name'         => 'nullable|string|max:255',
            'ascis_pd'             => 'nullable|string|max:255',
            'customer'             => 'nullable|string|max:255',
            'cs_brand'             => 'nullable|string|max:255',
            'cs_hw'                => 'nullable|string|max:255',
            'cpi_hw'               => 'nullable|string|max:255',
            's5_internal_approval' => 'nullable|string|max:255',
            'ghw_set'              => 'nullable|string|max:255',
            'information_received' => 'nullable|date',
            'plm_released'         => 'nullable|date',
            'coi_number'           => 'nullable|string|max:255',
            'green_light'          => 'nullable|date',
            'td'                   => 'nullable|string|max:255',
            'machine'              => 'nullable|string|max:255',
            'board'                => 'nullable|string|max:255',
            'board_u_code'         => 'nullable|string|max:255',
            'board_a_code'         => 'nullable|string|max:255',
            'type_cm'              => 'nullable|string|max:255',
            'die_cut_number'       => 'nullable|string|max:255',
            's10_number'           => 'nullable|string|max:255',
            's11_number'           => 'nullable|string|max:255',
            's12_number'           => 'nullable|string|max:255',
            'cylinder_supplier'    => 'nullable|string|max:255',
            'repro_by'             => 'nullable|string|max:255',
            'status'               => 'nullable|string',
        ]);

        $task->fill($validated);

        if (strtolower($task->status ?? '') !== 'completed') {
            $isComplete = true;
            foreach ($this->masterFields as $field) {
                if (empty($task->$field)) {
                    $isComplete = false;
                    break;
                }
            }

            $task->status = $isComplete ? 'in-progress' : 'todo';
        }

        $task->save();

        return redirect()->back()->with('success', 'Project Task berhasil diperbarui!');
    }

    /**
     * Menghapus Project dari Tabel Task
     */
    public function destroy($id)
    {
        $task = Task::where('id', $id)->orWhere('item_code', $id)->firstOrFail();

        DB::transaction(function () use ($task) {
            if ($task->main_design_attachment) {
                Storage::disk('public')->delete($task->main_design_attachment);
            }
            ItemSpec::where('item_code', $task->item_code)->delete();
            Timeline::where('task_id', $task->id)->delete();
            $task->delete();
        });

        return redirect()->back()->with('success', 'Task berhasil dihapus!');
    }
}