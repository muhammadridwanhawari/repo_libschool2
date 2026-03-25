@extends('layouts.penjaga')

@section('title', 'Baca Pesan - Penjaga')

@section('content')
<div>

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 mb-6 text-[0.82rem] text-slate-400">
        <a href="{{ route('penjaga.inbox') }}" class="hover:text-slate-600 transition-colors">Inbox</a>
        <span>/</span>
        <span class="text-slate-600 font-medium">Baca Pesan</span>
    </div>

    {{-- Message Card --}}
    <div class="bg-white rounded-2xl shadow-[0_1px_6px_rgba(0,0,0,0.06)] overflow-hidden max-w-3xl">

        {{-- Header --}}
        <div class="px-6 py-5 border-b border-slate-100">
            <h1 class="text-[1.05rem] font-bold text-slate-800">{{ $message->subject }}</h1>
            <div class="flex items-center gap-3 mt-2">
                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-[0.85rem] flex-shrink-0">
                    {{ strtoupper(substr($message->user->name ?? 'S', 0, 1)) }}
                </div>
                <div>
                    <p class="text-[0.82rem] font-semibold text-slate-700">{{ $message->user->name ?? 'Siswa' }}</p>
                    <p class="text-[0.72rem] text-slate-400">{{ $message->user->email ?? '' }} &bull; {{ $message->created_at->translatedFormat('d F Y, H:i') }}</p>
                </div>
            </div>
        </div>

        {{-- Body --}}
        <div class="px-6 py-6">
            <p class="text-[0.88rem] text-slate-700 leading-relaxed whitespace-pre-wrap">{{ $message->body }}</p>
        </div>

        {{-- Actions --}}
        <div class="px-6 py-4 border-t border-slate-100 flex justify-between items-center">
            <a href="{{ route('penjaga.inbox') }}"
               class="text-[0.82rem] text-slate-500 hover:text-slate-700 flex items-center gap-1.5 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Inbox
            </a>

            <form method="POST" action="{{ route('penjaga.inbox.destroy', $message->id) }}"
                  onsubmit="confirmAction(event, 'Hapus pesan ini?', 'Ya, Hapus', 'Konfirmasi Hapus'); return false;">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="text-[0.78rem] font-semibold text-red-500 hover:text-red-700 flex items-center gap-1 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Hapus Pesan
                </button>
            </form>
        </div>

    </div>

</div>
@endsection
