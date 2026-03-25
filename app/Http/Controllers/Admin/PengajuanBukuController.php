<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class PengajuanBukuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Pengajuan::with(['user', 'category']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul_buku', 'like', '%' . $search . '%')
                  ->orWhere('penulis', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        if ($status && $status !== 'semua') {
            $query->where('status', $status);
        }

        $pengajuan = $query->latest()->paginate(15)->appends($request->query());

        return view('admin.pengajuan.index', compact('pengajuan', 'search', 'status'));
    }

    public function updateStatus(Request $request, $id)
    {
        $item = Pengajuan::findOrFail($id);
        $newStatus = $request->input('status');

        if (in_array($newStatus, ['disetujui', 'ditolak', 'menunggu'])) {
            $item->update(['status' => $newStatus]);
        }

        return redirect()->route('admin.pengajuan.index')
            ->with('success', 'Status pengajuan buku berhasil diperbarui.');
    }
}
