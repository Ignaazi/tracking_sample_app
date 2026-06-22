<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendWorkspaceEmail;

class EmailController extends Controller
{
    /**
     * Menampilkan daftar email berdasarkan folder dan kata kunci pencarian
     */
    public function index(Request $request)
    {
        // 1. Ambil parameter filter dari request browser
        $folder = $request->query('folder', 'inbox');
        $search = $request->get('search');
        
        $query = Email::query();
        
        // 2. Logika Pemisahan Folder secara Dinamis di Database
        switch ($folder) {
            case 'starred':
                $query->where('is_starred', true);
                break;
            case 'sent':
                $query->where('folder', 'sent');
                break;
            case 'drafts':
                $query->where('folder', 'drafts');
                break;
            case 'spam':
                $query->where('folder', 'spam');
                break;
            case 'trash':
                $query->where('folder', 'trash');
                break;
            case 'inbox':
            default:
                // Menjaga agar email yang sudah dibuang ke trash tidak muncul di inbox
                $query->where('folder', 'inbox');
                break;
        }

        // 3. Fitur Live Search Pintar (Nama, Subjek, & Isi Surat)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('sender_name', 'LIKE', "%{$search}%")
                  ->orWhere('subject', 'LIKE', "%{$search}%")
                  ->orWhere('message', 'LIKE', "%{$search}%");
            });
        }

        // 4. Batasi Tampilan Hanya 25 Data per Halaman (Sesuai Mockup UI)
        $emails = $query->latest()->paginate(25)->withQueryString();
        
        // 5. Counter badge dinamis untuk menu navigasi samping
        $totalInbox = Email::where('folder', 'inbox')->count();
        $totalDrafts = Email::where('folder', 'drafts')->count();
        $totalSpam = Email::where('folder', 'spam')->count();

        // Pastikan path return view diarahkan ke lokasi folder blade kamu ('admin.email.index')
        return view('admin.email.index', compact('emails', 'folder', 'totalInbox', 'totalDrafts', 'totalSpam', 'search'));
    }

    /**
     * Menyimpan data email ke DB dan mengirimkannya lewat SMTP Gmail Nyata
     */
    public function store(Request $request)
    {
        $request->validate([
            'sender_name'  => 'required|string',
            'sender_email' => 'required|email',
            'subject'      => 'required|string',
            'message'      => 'required|string',
        ]);

        // Rekam data ke database sebagai log kotak masuk/terkirim
        $email = Email::create([
            'sender_name'  => $request->sender_name,
            'sender_email' => $request->sender_email,
            'subject'      => $request->subject,
            'message'      => $request->message,
            'label'        => $request->label ?? 'Work',
            'folder'       => 'inbox', // Standar masuk inbox awal
            'is_read'      => false,
            'is_starred'   => false
        ]);

        // Eksekusi pengiriman email riil melalui Gmail App Password kamu
        try {
            Mail::to($request->sender_email)->send(new SendWorkspaceEmail(
                $request->sender_name,
                $request->subject,
                $request->message
            ));
            
            return redirect()->back()->with('success', 'Message sent and recorded successfully!');
        } catch (\Exception $e) {
            // Jika SMTP error (misal internet mati), data tetap aman tersimpan di DB lokal
            return redirect()->back()->with('success', 'Message saved locally, but failed to broadcast: ' . $e->getMessage());
        }
    }

    /**
     * Menangani Aksi Massal dari Dropdown Titik Tiga (Mark as Read & Star All)
     */
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $ids = $request->input('ids', []); // Menangkap array id email yang dicentang
        $currentFolder = $request->input('current_folder', 'inbox');

        // Aksi 1: Tandai Sudah Dibaca
        if ($action == 'mark_all_read') {
            if (empty($ids)) {
                Email::where('folder', $currentFolder)->update(['is_read' => true]);
            } else {
                Email::whereIn('id', $ids)->update(['is_read' => true]);
            }
            return redirect()->back()->with('success', 'Selected messages marked as read.');
        }

        // Aksi 2: Berikan Bintang Massal
        if ($action == 'star_all') {
            if (empty($ids)) {
                Email::where('folder', $currentFolder)->update(['is_starred' => true]);
            } else {
                Email::whereIn('id', $ids)->update(['is_starred' => true]);
            }
            return redirect()->back()->with('success', 'Starred state synchronized successfully.');
        }

        return redirect()->back()->with('error', 'Action handler routine unrecognized.');
    }
    
    /**
     * Menghapus email (Sistem Soft Trash / Penghapusan Permanen)
     */
    public function destroy($id)
    {
        $email = Email::findOrFail($id);
        
        // Jika email sudah berada di folder trash lalu diklik hapus lagi, hapus selamanya dari database
        if ($email->folder === 'trash') {
            $email->delete();
            return redirect()->back()->with('success', 'Message permanently purged from records.');
        }

        // Jika dari inbox biasa, ubah status foldernya saja menjadi trash (tidak langsung hilang)
        $email->update(['folder' => 'trash']);
        return redirect()->back()->with('success', 'Message successfully moved to Trash folder.');
    }
}