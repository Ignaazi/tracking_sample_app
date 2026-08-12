<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkflowController extends Controller
{
    /**
     * GET /api/workflow
     * Menampilkan daftar project task yang berstatus 'completed' dalam format JSON
     */
    public function index()
    {
        try {
            $completedItems = Task::with(['pdUser', 'qaUser', 'plannerUser', 'timelines'])
                ->where('status', 'completed')
                ->orderBy('updated_at', 'desc')
                ->get();

            return response()->json([
                'status'         => 'success',
                'message'        => 'Data workflow berhasil dimuat',
                'completedItems' => $completedItems
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal memuat data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST /api/workflow/{id}/approve
     * Memproses approval berjenjang (PD -> QA -> PLANNER)
     */
    public function approve(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Task / Job Bag tidak ditemukan!'
            ], 404);
        }

        $user  = Auth::user();
        $stage = $request->input('stage');

        // 1. Stage PD (Prepared)
        if ($stage === 'pd' && in_array($user->role, ['PD', 'Administrator'])) {
            $task->update([
                'pd_prepared_at' => now(),
                'pd_prepared_by' => $user->id,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Berhasil melakukan Sign Prepared (PD) oleh ' . $user->name,
                'data'    => $task
            ], 200);
        }

        // 2. Stage QA (Checked) - Harus sudah di-prepare oleh PD
        if ($stage === 'qa' && in_array($user->role, ['QA', 'Administrator'])) {
            if (!$task->pd_prepared_at) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Proses harus di-prepare oleh PD terlebih dahulu!'
                ], 400);
            }

            $task->update([
                'qa_checked_at' => now(),
                'qa_checked_by' => $user->id,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Berhasil melakukan Sign Checked (QA) oleh ' . $user->name,
                'data'    => $task
            ], 200);
        }

        // 3. Stage PLANNER (Approved) - Harus sudah di-check oleh QA
        if ($stage === 'planner' && in_array($user->role, ['PLANNER', 'Administrator'])) {
            if (!$task->qa_checked_at) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Proses harus di-check oleh QA terlebih dahulu!'
                ], 400);
            }

            $task->update([
                'planner_approved_at' => now(),
                'planner_approved_by' => $user->id,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Berhasil melakukan Final Approval (PLANNER) oleh ' . $user->name,
                'data'    => $task
            ], 200);
        }

        return response()->json([
            'status'  => 'error',
            'message' => 'Anda tidak memiliki hak akses untuk stage approval ini!'
        ], 403);
    }

    /**
     * POST /api/workflow/{id}/reject
     * Memproses Reject / Reset Approval
     */
    public function reject(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Task / Job Bag tidak ditemukan!'
            ], 404);
        }

        $user   = Auth::user();
        $stage  = $request->input('stage');
        $reason = $request->input('reject_reason', 'Perlu perbaikan data');

        // 1. Reject oleh QA -> Reset Sign PD agar PD memperbaiki data
        if ($stage === 'qa' && in_array($user->role, ['QA', 'Administrator'])) {
            $task->update([
                'pd_prepared_at' => null,
                'pd_prepared_by' => null,
                'qa_checked_at'  => null,
                'qa_checked_by'  => null,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Workflow ditolak oleh QA! Sign PD di-reset. Alasan: ' . $reason,
                'data'    => $task
            ], 200);
        }

        // 2. Reject oleh PLANNER -> Reset Check QA agar QA memeriksa kembali
        if ($stage === 'planner' && in_array($user->role, ['PLANNER', 'Administrator'])) {
            $task->update([
                'qa_checked_at'       => null,
                'qa_checked_by'       => null,
                'planner_approved_at' => null,
                'planner_approved_by' => null,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Workflow ditolak oleh Planner! Check QA di-reset. Alasan: ' . $reason,
                'data'    => $task
            ], 200);
        }

        // 3. Reset All oleh Administrator
        if ($stage === 'reset' && $user->role === 'Administrator') {
            $task->update([
                'pd_prepared_at'      => null,
                'pd_prepared_by'      => null,
                'qa_checked_at'       => null,
                'qa_checked_by'       => null,
                'planner_approved_at' => null,
                'planner_approved_by' => null,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Seluruh status approval project berhasil di-reset.',
                'data'    => $task
            ], 200);
        }

        return response()->json([
            'status'  => 'error',
            'message' => 'Gagal memproses penolakan.'
        ], 400);
    }
}