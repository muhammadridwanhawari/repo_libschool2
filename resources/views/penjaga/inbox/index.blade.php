@extends('layouts.penjaga')

@section('title', 'Inbox - Penjaga')

@push('styles')
<style>
    /* Stat Cards */
    .stat-cards {
        display: grid; grid-template-columns: repeat(2, 1fr);
        gap: 16px; margin-bottom: 28px;
    }
    .stat-card {
        background: #fff; border-radius: 14px;
        padding: 20px 24px; border: 1.5px solid #e5e7eb;
        display: flex; align-items: center; justify-content: space-between;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }
    .stat-card-label { font-size: 0.8rem; color: #666; margin: 0 0 4px; font-weight: 500; }
    .stat-card-value { font-size: 2rem; font-weight: 700; color: #222; margin: 0; }
    .stat-card-value.primary { color: #4361ee; }
    .stat-card-value.warning { color: #f59e0b; }
    .stat-card-icon {
        width: 44px; height: 44px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%; flex-shrink: 0;
    }
    .stat-card:nth-child(1) .stat-card-icon { background: #eef0ff; color: #4361ee; }
    .stat-card:nth-child(2) .stat-card-icon { background: #fef3c7; color: #f59e0b; }

    /* Message List */
    .msg-item {
        display: flex; align-items: flex-start; gap: 14px;
        padding: 16px 24px; border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s; text-decoration: none; color: inherit;
    }
    .msg-item:hover { background: #f8faff; }
    .msg-item.unread { background: #f5f7ff; }
    .msg-avatar {
        width: 38px; height: 38px; border-radius: 50%;
        background: #eef0ff; color: #4361ee;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; font-weight: 700; font-size: 0.9rem;
    }
    .msg-unread-dot {
        width: 8px; height: 8px; border-radius: 50%; background: #4361ee;
        flex-shrink: 0; margin-top: 6px;
    }
    .msg-subject { font-size: 0.88rem; font-weight: 600; color: #1e293b; margin: 0 0 2px; }
    .msg-preview { font-size: 0.77rem; color: #64748b; margin: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 480px; }
    .msg-meta { font-size: 0.7rem; color: #94a3b8; margin-top: 3px; }
    .msg-read .msg-subject { font-weight: 500; color: #475569; }
    .pagination-wrap {
        padding: 16px; border-top: 1px solid #f0f0f0;
        display: flex; align-items: center; gap: 4px;
    }
    .pagination-wrap a, .pagination-wrap span {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px; border-radius: 6px;
        font-size: 0.8rem; text-decoration: none;
        color: #666; border: 1px solid #e5e7eb;
    }
    .pagination-wrap .active { background: #4361ee; color: #fff; border-color: #4361ee; }
    .pagination-wrap nav p.text-sm.text-gray-700 { display: none !important; }
</style>
@endpush

@section('content')
<div>

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-[1.35rem] font-bold text-sky-950">Inbox</h1>
        <p class="text-slate-500 text-[0.875rem] mt-1">Pesan masuk dari siswa.</p>
    </div>

    {{-- Flash --}}
    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-5 text-[0.85rem] flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Stat Cards --}}
    @php
        $totalMessages = $messages->total();
    @endphp
    <div class="stat-cards">
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Total Pesan</p>
                <p class="stat-card-value primary">{{ $totalMessages }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0l-8 4-8-4"/></svg>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-card-info">
                <p class="stat-card-label">Belum Dibaca</p>
                <p class="stat-card-value warning">{{ $unreadCount }}</p>
            </div>
            <div class="stat-card-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
        </div>
    </div>

    {{-- Message List --}}
    <div class="bg-white rounded-2xl shadow-[0_1px_6px_rgba(0,0,0,0.06)] overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between flex-wrap gap-4">
            <h2 class="font-bold text-slate-800 text-[1rem]">Pesan Masuk</h2>
            <div class="flex items-center gap-4">
                <form method="GET" action="{{ route('penjaga.inbox') }}" class="m-0">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pengirim..." class="bg-white border border-slate-200 text-slate-600 text-[0.82rem] pl-9 pr-4 py-1.5 rounded-lg outline-none focus:border-indigo-500 w-full sm:w-64 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                    </div>
                </form>
                <span class="text-[0.75rem] text-slate-400 font-medium whitespace-nowrap">{{ $totalMessages }} pesan</span>
            </div>
        </div>

        @forelse ($messages as $msg)
        <a href="{{ route('penjaga.inbox.show', $msg->id) }}"
           class="msg-item {{ $msg->is_read ? 'msg-read' : 'unread' }} flex">
            <div class="msg-avatar">
                {{ strtoupper(substr($msg->user->name ?? 'S', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="msg-subject">{{ $msg->subject }}</p>
                <p class="msg-preview">{{ Str::limit($msg->body, 100) }}</p>
                <p class="msg-meta">
                    Dari: <strong>{{ $msg->user->name ?? 'Siswa' }}</strong>
                    &bull; {{ $msg->created_at->diffForHumans() }}
                </p>
            </div>
            @if(!$msg->is_read)
            <div class="msg-unread-dot self-center"></div>
            @endif
        </a>
        @empty
        <div class="px-6 py-14 text-center">
            <div class="flex flex-col items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24" class="mb-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0l-8 4-8-4"/>
                </svg>
                <p class="text-slate-400 text-[0.85rem]">
                    {{ request('search') ? 'Tidak ada pesan dari pengirim dengan nama tersebut.' : 'Belum ada pesan masuk.' }}
                </p>
            </div>
        </div>
        @endforelse

        @if($messages->hasPages())
        <div class="pagination-wrap">
            {{ $messages->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
