<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Menampilkan Dashboard Utama Admin beserta Data Sampelnya
    public function dashboard()
    {
        // Mengambil data sampel terbaru dari database local
        $samples = Sample::latest()->get();
        
        return view('admin.dashboard', compact('samples'));
    }
}