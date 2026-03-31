<?php

namespace App\Http\Controllers\Penjaga;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class PenjagaInboxController extends Controller
{
    public function index(Request $request)
    {
        // 1. DATA INBOX PESAN
        $queryMessage = Message::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $queryMessage->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $messages = $queryMessage->orderBy('is_read', 'asc')
                          ->latest()
                          ->paginate(10, ['*'], 'msg_page')
                          ->withQueryString();

        $unreadCount = Message::where('is_read', false)->count();

        // 2. DATA PENGAJUAN BUKU
        $searchPengajuan = $request->input('search_pengajuan');
        $statusPengajuan = $request->input('status_pengajuan');
        
        $queryPengajuan = Pengajuan::with(['user', 'category']);
        if ($searchPengajuan) {
            $queryPengajuan->where(function ($q) use ($searchPengajuan) {
                $q->where('judul_buku', 'like', '%' . $searchPengajuan . '%')
                  ->orWhere('penulis', 'like', '%' . $searchPengajuan . '%')
                  ->orWhereHas('user', function ($uq) use ($searchPengajuan) {
                      $uq->where('name', 'like', '%' . $searchPengajuan . '%');
                  });
            });
        }
        if ($statusPengajuan && $statusPengajuan !== 'semua') {
            $queryPengajuan->where('status', $statusPengajuan);
        }
        
        $pengajuan = $queryPengajuan->latest()->paginate(10, ['*'], 'pengajuan_page')->withQueryString();

        return view('penjaga.inbox.index', compact('messages', 'unreadCount', 'pengajuan', 'searchPengajuan', 'statusPengajuan'));
    }

    public function show($id)
    {
        $message = Message::with('user')->findOrFail($id);

        // Mark as read
        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('penjaga.inbox.show', compact('message'));
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()->route('penjaga.inbox')
            ->with('success', 'Pesan berhasil dihapus.');
    }

    public function updateStatusPengajuan(Request $request, $id)
    {
        $item = Pengajuan::findOrFail($id);
        $newStatus = $request->input('status');

        if (in_array($newStatus, ['disetujui', 'ditolak', 'menunggu'])) {
            $item->update(['status' => $newStatus]);
        }

        return redirect()->route('penjaga.inbox', ['#pengajuan'])
            ->with('success', 'Status pengajuan buku berhasil diperbarui.');
    }
}
