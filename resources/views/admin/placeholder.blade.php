@extends('layouts.admin')

@section('title', 'Coming Soon')

@section('content')
    <div style="display:flex; align-items:center; justify-content:center; min-height:60vh; flex-direction:column;">
        <div style="width:70px; height:70px; border-radius:50%; background:#f0f3ff; display:flex; align-items:center; justify-content:center; margin-bottom:20px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="#4361ee" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
        </div>
        <h2 style="font-size:1.3rem; font-weight:700; color:#222; margin:0 0 8px;">Halaman {{ ucwords(str_replace('-', ' ', $page)) }}</h2>
        <p style="font-size:0.9rem; color:#888; margin:0;">Fitur ini sedang dalam pengembangan dan akan segera tersedia.</p>
        <a href="{{ route('admin.dashboard') }}" style="margin-top:20px; padding:10px 24px; background:#4361ee; color:#fff; border-radius:8px; text-decoration:none; font-size:0.85rem; font-weight:600;">← Kembali ke Dashboard</a>
    </div>
@endsection
