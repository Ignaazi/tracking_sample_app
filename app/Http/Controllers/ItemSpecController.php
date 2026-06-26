<?php

namespace App\Http\Controllers;

use App\Models\ItemSpec;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemSpecController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itemSpecs = ItemSpec::orderBy('created_at', 'desc')->get();
        return view('admin.item-specs.index', compact('itemSpecs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_name'  => 'required|string|max:255',
            'sap_code'   => 'required|string|unique:item_specs,sap_code',
            'brand'      => 'required|string',
            'model_type' => 'required|string',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Maksimal 2MB
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Simpan langsung ke public/uploads/items agar mudah diakses tanpa symlink
            $file->move(public_path('uploads/items'), $filename);
            $data['image_path'] = 'uploads/items/' . $filename;
        }

        ItemSpec::create($data);

        return redirect()->back()->with('success', 'Item Specification berhasil ditambahkan, bor!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $itemSpec = ItemSpec::findOrFail($id);

        $request->validate([
            'item_name'  => 'required|string|max:255',
            'sap_code'   => 'required|string|unique:item_specs,sap_code,' . $id,
            'brand'      => 'required|string',
            'model_type' => 'required|string',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada fisik filenya
            if ($itemSpec->image_path && file_exists(public_path($itemSpec->image_path))) {
                @unlink(public_path($itemSpec->image_path));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/items'), $filename);
            $data['image_path'] = 'uploads/items/' . $filename;
        }

        $itemSpec->update($data);

        return redirect()->back()->with('with', 'Data Item Specification berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $itemSpec = ItemSpec::findOrFail($id);

        // Hapus file fisik gambar dari penyimpanan lokal sebelum delete row
        if ($itemSpec->image_path && file_exists(public_path($itemSpec->image_path))) {
            @unlink(public_path($itemSpec->image_path));
        }

        $itemSpec->delete();

        return redirect()->back()->with('success', 'Item Specification berhasil dihapus!');
    }
}