<?php

namespace App\Http\Controllers;

use App\Models\ItemSpec;
use App\Models\Task;
use Illuminate\Http\Request;

class ItemSpecController extends Controller
{
    /**
     * Display workspace index with grouped tasks.
     */
    public function index()
    {
        // 1. Ambil semua Task beserta relasi itemSpecs-nya
        $tasks = Task::with('itemSpecs')->orderBy('created_at', 'desc')->get();

        // 2. Filter Task berdasarkan status board-nya (To Do, In Progress, Completed)
        $todoSpecs = $tasks->filter(fn($t) => in_array(strtolower($t->status ?? ''), ['to do', 'todo']));
        $inProgressSpecs = $tasks->filter(fn($t) => in_array(strtolower($t->status ?? ''), ['in progress', 'in-progress', 'progress']));
        $completedSpecs = $tasks->filter(fn($t) => in_array(strtolower($t->status ?? ''), ['completed', 'done']));

        return view('admin.item-specs.index', compact('tasks', 'todoSpecs', 'inProgressSpecs', 'completedSpecs'));
    }

    /**
     * Show full page form to create / manage Item Specs.
     */
    public function create(Request $request)
    {
        // Ambil ID task dari parameter query (?task_id=X atau ?id=X)
        $taskId = $request->query('task_id') ?? $request->query('id');

        if (!$taskId) {
            return redirect()->route('admin.item-specs.index')
                             ->with('error', 'Parameter Task ID tidak ditemukan di URL.');
        }

        // Cari record Task dari tabel 'task' beserta relasi itemSpecs-nya
        $task = Task::with('itemSpecs')->find($taskId);

        if (!$task) {
            return redirect()->route('admin.item-specs.index')
                             ->with('error', "Task dengan ID '{$taskId}' tidak ditemukan di database!");
        }

        // Render file view addItemSpecs.blade.php
        if (view()->exists('admin.item-specs.partials.addItemSpecs')) {
            return view('admin.item-specs.partials.addItemSpecs', compact('task'));
        }

        return view('admin.item-specs.addItemSpecs', compact('task'));
    }

    /**
     * Display A4 Print & Preview page for Item Specification Sheet.
     */
    public function show($id)
    {
        // Ambil Task beserta seluruh urutan Item Specs-nya
        $task = Task::with('itemSpecs')->findOrFail($id);

        // Pengecekan path template preview
        if (view()->exists('admin.item-specs.partials.previewAddItemSpecs')) {
            return view('admin.item-specs.partials.previewAddItemSpecs', compact('task'));
        }

        return view('admin.item-specs.previewAddItemSpecs', compact('task'));
    }

    /**
     * Store new Item Spec into database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_code'               => 'required|string',
            'sequence'                => 'required|integer|min:1|max:12',
            'colour'                  => 'required|string|max:255',
            'baan_cylinder'           => 'nullable|string|max:255',
            'film_number'             => 'nullable|string|max:255',
            'ink_system'              => 'nullable|string|max:255',
            'ink_code'                => 'nullable|string|max:255',
            'supplier_ink'            => 'nullable|string|max:255',
            'baan_ink_code'           => 'nullable|string|max:255',
            'coverage'                => 'nullable|numeric|min:0|max:100',
            'usage_kg_th'             => 'nullable|numeric|min:0',
            'angle_anilox'            => 'nullable|string|max:255',
            'remarks'                 => 'nullable|string',
            'main_design_attachment'  => 'nullable|file|mimes:pdf,ai,psd,jpg,png,jpeg,zip|max:10240',
            'project_status'          => 'required|in:To Do,Progress,Completed',
        ]);

        // Handling file upload
        if ($request->hasFile('main_design_attachment')) {
            $file = $request->file('main_design_attachment');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_\.-]/', '', $file->getClientOriginalName());
            $file->move(public_path('uploads/item-specs'), $filename);
            $validated['main_design_attachment'] = 'uploads/item-specs/' . $filename;
        }

        ItemSpec::create($validated);

        // Cari task berdasarkan item_code untuk kembalikan user ke form addItemSpecs
        $task = Task::where('item_code', $request->item_code)->first();

        if ($task) {
            return redirect()->route('admin.item-specs.create', ['task_id' => $task->id])
                             ->with('success', "Sequence #{$request->sequence} ({$request->colour}) successfully added!");
        }

        return redirect()->route('admin.item-specs.index')
                         ->with('success', 'Sequence specification successfully added!');
    }

    /**
     * Update existing Item Spec.
     */
    public function update(Request $request, $id)
    {
        $itemSpec = ItemSpec::findOrFail($id);

        $validated = $request->validate([
            'item_code'               => 'required|string',
            'sequence'                => 'required|integer|min:1|max:12',
            'colour'                  => 'required|string|max:255',
            'baan_cylinder'           => 'nullable|string|max:255',
            'film_number'             => 'nullable|string|max:255',
            'ink_system'              => 'nullable|string|max:255',
            'ink_code'                => 'nullable|string|max:255',
            'supplier_ink'            => 'nullable|string|max:255',
            'baan_ink_code'           => 'nullable|string|max:255',
            'coverage'                => 'nullable|numeric|min:0|max:100',
            'usage_kg_th'             => 'nullable|numeric|min:0',
            'angle_anilox'            => 'nullable|string|max:255',
            'remarks'                 => 'nullable|string',
            'main_design_attachment'  => 'nullable|file|mimes:pdf,ai,psd,jpg,png,jpeg,zip|max:10240',
            'project_status'          => 'required|in:To Do,Progress,Completed',
        ]);

        if ($request->hasFile('main_design_attachment')) {
            // Hapus file lama jika ada
            if ($itemSpec->main_design_attachment && file_exists(public_path($itemSpec->main_design_attachment))) {
                @unlink(public_path($itemSpec->main_design_attachment));
            }

            $file = $request->file('main_design_attachment');
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9_\.-]/', '', $file->getClientOriginalName());
            $file->move(public_path('uploads/item-specs'), $filename);
            $validated['main_design_attachment'] = 'uploads/item-specs/' . $filename;
        }

        $itemSpec->update($validated);

        return redirect()->back()->with('success', "Sequence #{$itemSpec->sequence} successfully updated!");
    }

    /**
     * Delete Item Spec.
     */
    public function destroy($id)
    {
        $itemSpec = ItemSpec::findOrFail($id);
        $seq = $itemSpec->sequence;

        if ($itemSpec->main_design_attachment && file_exists(public_path($itemSpec->main_design_attachment))) {
            @unlink(public_path($itemSpec->main_design_attachment));
        }

        $itemSpec->delete();

        return redirect()->back()->with('success', "Sequence #{$seq} successfully deleted!");
    }
}