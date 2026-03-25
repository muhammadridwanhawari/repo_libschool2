<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Message;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaPengajuanController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $query = Pengajuan::with('category')
            ->where('user_id', $userId)
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengajuan = $query->get();

        $total     = Pengajuan::where('user_id', $userId)->count();
        $menunggu  = Pengajuan::where('user_id', $userId)->where('status', 'menunggu')->count();
        $disetujui = Pengajuan::where('user_id', $userId)->where('status', 'disetujui')->count();
        $ditolak   = Pengajuan::where('user_id', $userId)->where('status', 'ditolak')->count();

        $categories = Category::orderBy('name')->get();

        return view('siswa.pengajuan.index', compact('pengajuan', 'total', 'menunggu', 'disetujui', 'ditolak', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('siswa.pengajuan.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_buku'   => ['required', 'string', 'max:255'],
            'penulis'      => ['required', 'string', 'max:255'],
            'isbn'         => ['nullable', 'string', 'max:30'],
            'penerbit'     => ['nullable', 'string', 'max:255'],
            'tahun_terbit' => ['nullable', 'digits:4', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'category_id'  => ['nullable', 'exists:categories,id'],
            'alasan'       => ['required', 'string', 'min:10'],
        ]);

        Pengajuan::create([
            'judul_buku'   => $request->judul_buku,
            'penulis'      => $request->penulis,
            'isbn'         => $request->isbn,
            'penerbit'     => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'category_id'  => $request->category_id ?: null,
            'alasan'       => $request->alasan,
            'user_id'      => Auth::id(),
            'status'       => 'menunggu',
        ]);

        return redirect()->route('siswa.pengajuan')
            ->with('success', 'Pengajuan buku berhasil dikirim! Kami akan meninjau usulan Anda dalam 1-3 hari kerja.');
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'body'    => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        Message::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'body'    => $request->body,
        ]);

        return redirect()->route('siswa.pengajuan')
            ->with('success', 'Pesan berhasil dikirim ke penjaga!');
    }
}

