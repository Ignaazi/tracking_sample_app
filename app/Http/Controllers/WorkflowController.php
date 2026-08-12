<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkflowController extends Controller
{
    /**
     * Menampilkan daftar project task yang berstatus 'completed' dan siap di-assign / approve.
     */
    public function index()
    {
        $completedItems = Task::with(['pdUser', 'qaUser', 'plannerUser', 'timelines'])
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.workflow.index', compact('completedItems'));
    }

    /**
     * Memproses approval berjenjang (PD -> QA -> PLANNER)
     */
    public function approve(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $user = Auth::user();
        $stage = $request->input('stage');

        // 1. Stage PD (Prepared)
        if ($stage === 'pd' && in_array($user->role, ['PD', 'Administrator'])) {
            $task->update([
                'pd_prepared_at' => now(),
                'pd_prepared_by' => $user->id,
            ]);
            return redirect()->back()->with('success', 'Berhasil melakukan Sign Prepared (PD) oleh ' . $user->name);
        }

        // 2. Stage QA (Checked) - Harus sudah di-prepare oleh PD
        if ($stage === 'qa' && in_array($user->role, ['QA', 'Administrator'])) {
            if (!$task->pd_prepared_at) {
                return redirect()->back()->with('error', 'Proses harus di-prepare oleh PD terlebih dahulu!');
            }
            $task->update([
                'qa_checked_at' => now(),
                'qa_checked_by' => $user->id,
            ]);
            return redirect()->back()->with('success', 'Berhasil melakukan Sign Checked (QA) oleh ' . $user->name);
        }

        // 3. Stage PLANNER (Approved) - Harus sudah di-check oleh QA
        if ($stage === 'planner' && in_array($user->role, ['PLANNER', 'Administrator'])) {
            if (!$task->qa_checked_at) {
                return redirect()->back()->with('error', 'Proses harus di-check oleh QA terlebih dahulu!');
            }
            $task->update([
                'planner_approved_at' => now(),
                'planner_approved_by' => $user->id,
            ]);
            return redirect()->back()->with('success', 'Berhasil melakukan Final Approval (PLANNER) oleh ' . $user->name);
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki hak akses untuk stage approval ini!');
    }

    /**
     * Memproses Reject / Reset Approval
     */
    public function reject(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $user = Auth::user();
        $stage = $request->input('stage');
        $reason = $request->input('reject_reason', 'Perlu perbaikan data');

        // 1. Reject oleh QA -> Reset Sign PD agar PD memperbaiki data
        if ($stage === 'qa' && in_array($user->role, ['QA', 'Administrator'])) {
            $task->update([
                'pd_prepared_at' => null,
                'pd_prepared_by' => null,
                'qa_checked_at'  => null,
                'qa_checked_by'  => null,
            ]);
            return redirect()->back()->with('error', 'Workflow ditolak oleh QA! Approval Sign PD telah di-reset. Alasan: ' . $reason);
        }

        // 2. Reject oleh PLANNER -> Reset Check QA agar QA memeriksa kembali
        if ($stage === 'planner' && in_array($user->role, ['PLANNER', 'Administrator'])) {
            $task->update([
                'qa_checked_at'       => null,
                'qa_checked_by'       => null,
                'planner_approved_at' => null,
                'planner_approved_by' => null,
            ]);
            return redirect()->back()->with('error', 'Workflow ditolak oleh Planner! Approval Check QA telah di-reset. Alasan: ' . $reason);
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
            return redirect()->back()->with('success', 'Seluruh status approval project berhasil di-reset ke kondisi awal.');
        }

        return redirect()->back()->with('error', 'Gagal memproses penolakan.');
    }

    /**
     * Menampilkan Preview HTML / Mengunduh File PDF
     * Menggunakan APP_URL dari .env (support Ngrok / Custom Host)
     */
    public function printPdf(Request $request, $id)
    {
        $item = Task::with(['pdUser', 'qaUser', 'plannerUser', 'itemSpecs'])->findOrFail($id);

        $cleanItemCode = preg_replace('/[^A-Za-z0-9\-]/', '_', $item->item_code);
        $fileName = 'JOB_ASSIGNMENT_' . $cleanItemCode . '.pdf';

        // Mengambil Base URL dari config app.url (.env) secara murni tanpa port/ip lokal jika di-override ngrok
        $baseUrl = rtrim(config('app.url'), '/');
        
        // Buat QR / Dynamic Link menggunakan domain .env
        $qrUrl = $baseUrl . '/admin/workflow/' . $item->id . '/print-pdf';

        // Jika tombol 'Download PDF' di halaman preview diklik (?download=pdf)
        if ($request->has('download') && $request->download === 'pdf') {
            $pdf = app('dompdf.wrapper')
                ->loadView('admin.workflow.pdf_template', compact('item', 'qrUrl', 'baseUrl'))
                ->setPaper('a4', 'portrait');

            return $pdf->download($fileName);
        }

        // Default: Tampilkan Halaman HTML Preview (Siap untuk Scan HP via Ngrok)
        return view('admin.workflow.pdf_template', compact('item', 'qrUrl', 'baseUrl'));
    }
}