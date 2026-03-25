<?php

namespace App\Http\Controllers\Penjaga;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class PenjagaInboxController extends Controller
{
    public function index(Request $request)
    {
        // Otomatis hapus pesan yang lebih dari 7 hari
        Message::where('created_at', '<', now()->subDays(7))->delete();

        $query = Message::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $messages = $query->orderBy('is_read', 'asc')
                          ->latest()
                          ->paginate(10)
                          ->withQueryString();

        $unreadCount = Message::where('is_read', false)->count();

        return view('penjaga.inbox.index', compact('messages', 'unreadCount'));
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
}
