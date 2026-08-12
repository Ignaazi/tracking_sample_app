<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Timeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimelineController extends Controller
{
    /**
     * Menampilkan Halaman Dashboard Interactive Gantt Roadmap
     */
    public function index()
    {
        // 1. AMBIL SEMUA DATA TASK TERBARU
        $tasks = Task::with('timelines')->orderBy('created_at', 'desc')->get()->map(function ($task) {
            
            // 2. AUTO-GENERATE CHECKLIST TIMELINE JIKA BELUM ADA DATA TIMELINE
            if ($task->timelines->count() === 0) {
                self::generateDefaultChecklists($task);
                $task->load('timelines');
            }

            // 3. KALKULASI REAL-TIME STATUS PROJECT BERDASARKAN TIMELINE CHECKLIST
            $totalItems = $task->timelines->count();
            $completedItems = $task->timelines->where('is_completed', 1)->count();

            if ($totalItems > 0) {
                if ($completedItems === $totalItems) {
                    $status = 'completed';
                } elseif ($completedItems > 0) {
                    $status = 'in-progress';
                } else {
                    $status = 'todo';
                }

                // Update status di DB jika berbeda
                if (strtolower($task->status ?? '') !== $status) {
                    $task->update(['status' => $status]);
                    $task->status = $status;
                }
            }

            return $task;
        });

        return view('admin.timeline.index', compact('tasks'));
    }

    /**
     * Menampilkan Halaman Detail Project Gantt Graph (detailTimeLine.blade.php)
     */
    public function detail($id)
    {
        // Cari task berdasarkan ID atau Item Code
        $task = Task::where('id', $id)->orWhere('item_code', $id)->firstOrFail();
        
        // Load relasi timeline
        $task->load('timelines');

        // Auto-generate checklist default jika project belum memiliki timeline
        if ($task->timelines->count() === 0) {
            self::generateDefaultChecklists($task);
            $task->load('timelines');
        }

        // RETURNING VIEW KE detailTimeLine.blade.php DI FOLDER admin/timeline/
        return view('admin.timeline.detailTimeLine', compact('task'));
    }

    /**
     * Update data item Timeline (Termasuk Remarks & Time Unit)
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'remarks'          => 'nullable|string',
            'time_unit'        => 'nullable|string|max:50',
            'is_completed'     => 'nullable|boolean',
            'progress_percent' => 'nullable|integer|min:0|max:100',
            'start_date'       => 'nullable|date',
            'end_date'         => 'nullable|date',
        ]);

        $timeline = Timeline::findOrFail($id);
        $timeline->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Timeline berhasil diperbarui!',
            'data'    => $timeline
        ]);
    }

    /**
     * Helper Static Method: Auto-Generate Default Timeline Checklist untuk Task Baru
     */
    public static function generateDefaultChecklists(Task $task)
    {
        $startDate = !empty($task->information_received) 
            ? date('Y-m-d', strtotime($task->information_received)) 
            : date('Y-m-d', strtotime($task->created_at ?? now()));

        $endDate = !empty($task->plm_released) 
            ? date('Y-m-d', strtotime($task->plm_released)) 
            : date('Y-m-d', strtotime($startDate . ' + 14 days'));

        // Struktur Checklist Standar Development Timeline
        $defaultSections = [
            'layout_process' => [
                'Review Initial Specification & Artwork Brief',
                'Create Technical Layout & Die-Cut Alignment',
                'Internal Pre-Press Design Approval'
            ],
            'baan_process' => [
                'BaaN Cylinder Code Creation',
                'BaaN Ink & Substrate Master Registration',
                'BaaN Bill of Materials (BOM) Setup'
            ],
            'promp_process' => [
                'PROMP Proof Approval Request',
                'Customer Color Standard Verification',
                'PROMP Final Approval Status'
            ],
            'job_bag_process' => [
                'Cylinder Repro & Engraving Order',
                'Job Bag Production Package Assembly',
                'Final Production Release & Green Light'
            ]
        ];

        DB::transaction(function () use ($task, $defaultSections, $startDate, $endDate) {
            foreach ($defaultSections as $sectionKey => $titles) {
                foreach ($titles as $title) {
                    Timeline::create([
                        'task_id'          => $task->id,
                        'project_name'     => $task->project_name ?? 'Project Task',
                        'section_key'      => $sectionKey,
                        'task_title'       => $title,
                        'phase'            => 'Develop',
                        'start_date'       => $startDate,
                        'end_date'         => $endDate,
                        'is_completed'     => false,
                        'progress_percent' => 0,
                        'remarks'          => null,   // Ditambahkan
                        'time_unit'        => 'Days', // Ditambahkan (default: Days/Hari)
                    ]);
                }
            }
        });
    }
}