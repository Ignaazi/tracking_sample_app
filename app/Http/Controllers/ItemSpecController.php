<?php

namespace App\Http\Controllers;

use App\Models\ItemSpec;
use App\Models\Task;
use Illuminate\Http\Request;

class ItemSpecController extends Controller
{
    public function index()
    {
        // 1. Ambil semua Task beserta relasi itemSpecs-nya
        $tasks = Task::with('itemSpecs')->orderBy('created_at', 'desc')->get();

        // 2. Filter Task berdasarkan status board-nya (To Do, In Progress, Completed)
        $todoSpecs = $tasks->filter(fn($t) => in_array(strtolower($t->status), ['to do', 'todo']));
        $inProgressSpecs = $tasks->filter(fn($t) => in_array(strtolower($t->status), ['in progress', 'in-progress', 'progress']));
        $completedSpecs = $tasks->filter(fn($t) => in_array(strtolower($t->status), ['completed', 'done']));

        return view('admin.item-specs.index', compact('tasks', 'todoSpecs', 'inProgressSpecs', 'completedSpecs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_code'               => 'required|exists:task,item_code',
            'sequence'                => 'required|integer|min:1|max:12',
            'colour'                  => 'required|string|max:255',
            'baan_cylinder'           => 'nullable|string|max:255',
            'film_number'             => 'nullable|string|max:255',
            'ink_system'              => 'nullable|string|max:255',
            'ink_code'                => 'nullable|string|max:255',
            'supplier_ink'            => 'nullable|in:SIEG,DIC,HUBER,SC',
            'baan_ink_code'           => 'nullable|string|max:255',
            'coverage'                => 'nullable|numeric|min:0|max:100',
            'usage_kg_th'             => 'nullable|numeric|min:0',
            'angle_anilox'            => 'nullable|string|max:255',
            'remarks'                 => 'nullable|string',
            'main_design_attachment'  => 'nullable|file|mimes:pdf,ai,psd,jpg,png,zip|max:10240',
            'project_status'          => 'required|in:To Do,Progress,Completed',
        ]);

        if ($request->hasFile('main_design_attachment')) {
            $file = $request->file('main_design_attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/item-specs'), $filename);
            $validated['main_design_attachment'] = 'uploads/item-specs/' . $filename;
        }

        ItemSpec::create($validated);

        return redirect()->back()->with('success', 'Spesifikasi warna/tinta berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $itemSpec = ItemSpec::findOrFail($id);

        $validated = $request->validate([
            'item_code'               => 'required|exists:task,item_code',
            'sequence'                => 'required|integer|min:1|max:12',
            'colour'                  => 'required|string|max:255',
            'baan_cylinder'           => 'nullable|string|max:255',
            'film_number'             => 'nullable|string|max:255',
            'ink_system'              => 'nullable|string|max:255',
            'ink_code'                => 'nullable|string|max:255',
            'supplier_ink'            => 'nullable|in:SIEG,DIC,HUBER,SC',
            'baan_ink_code'           => 'nullable|string|max:255',
            'coverage'                => 'nullable|numeric|min:0|max:100',
            'usage_kg_th'             => 'nullable|numeric|min:0',
            'angle_anilox'            => 'nullable|string|max:255',
            'remarks'                 => 'nullable|string',
            'main_design_attachment'  => 'nullable|file|mimes:pdf,ai,psd,jpg,png,zip|max:10240',
            'project_status'          => 'required|in:To Do,Progress,Completed',
        ]);

        if ($request->hasFile('main_design_attachment')) {
            if ($itemSpec->main_design_attachment && file_exists(public_path($itemSpec->main_design_attachment))) {
                @unlink(public_path($itemSpec->main_design_attachment));
            }
            $file = $request->file('main_design_attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/item-specs'), $filename);
            $validated['main_design_attachment'] = 'uploads/item-specs/' . $filename;
        }

        $itemSpec->update($validated);

        return redirect()->back()->with('success', 'Spesifikasi warna/tinta berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $itemSpec = ItemSpec::findOrFail($id);
        if ($itemSpec->main_design_attachment && file_exists(public_path($itemSpec->main_design_attachment))) {
            @unlink(public_path($itemSpec->main_design_attachment));
        }
        $itemSpec->delete();

        return redirect()->back()->with('success', 'Spesifikasi berhasil dihapus!');
    }
}