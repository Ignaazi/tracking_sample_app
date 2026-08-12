<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use App\Models\Task; // 👈 Import Model Task
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Menampilkan Dashboard Utama Admin beserta Data Sampelnya
    public function dashboard()
    {
        // 1. Mengambil data sampel terbaru dari database local untuk tabel
        $samples = Sample::latest()->get();

        // 2. Ambil Recent Activity dari tabel 'task' beserta relasi user-nya
        $recentActivities = Task::with(['pdUser', 'qaUser', 'plannerUser'])
            ->latest('updated_at')
            ->take(6)
            ->get();

        // 3. Statistik Card Ringkasan dari tabel 'task'
        $totalDevelopment = Task::count();
        $pendingTasks = Task::where('status', 'todo')
            ->orWhere('status', 'progress')
            ->count();
        $activeProjects = Task::where('development_status', 'Active')->count();
        $completedProjects = Task::where('status', 'completed')->count();

        // 4. Data untuk ApexCharts (Berdasarkan status job_bag / task)
        $chartData = [
            'pending'     => Task::where('job_bag_status', 'Pending')->count(),
            'in_progress' => Task::where('job_bag_status', 'In Progress')->count(),
            'completed'   => Task::where('status', 'completed')->count(),
        ];

        // Pass seluruh variabel ke view admin.dashboard
        return view('admin.dashboard', compact(
            'samples',
            'recentActivities',
            'totalDevelopment',
            'pendingTasks',
            'activeProjects',
            'completedProjects',
            'chartData'
        ));
    }
}