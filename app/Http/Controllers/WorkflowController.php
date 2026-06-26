<?php

namespace App\Http\Controllers;

use App\Models\ItemSpec;
use Illuminate\Http\Request;

class WorkflowController extends Controller
{
    /**
     * Menampilkan daftar item spesifikasi yang sudah selesai dikembangkan.
     */
    public function index()
    {
        // Mengambil data item spesifikasi yang sudah lengkap / selesai
        // (Asumsi data yang tampil adalah yang memiliki SAP Code dan detail spesifikasi lengkap)
        $completedItems = ItemSpec::orderBy('updated_at', 'desc')->get();
        
        return view('admin.workflow.index', compact('completedItems'));
    }

    /**
     * Menampilkan template layout assignment perusahaan khusus untuk dicetak PDF.
     */
    public function printPdf($id)
    {
        $item = ItemSpec::findOrFail($id);
        
        return view('admin.workflow.pdf_template', compact('item'));
    }
}