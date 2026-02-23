@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div>
    <div style="margin-bottom:1.5rem;">
        <h1 style="font-size:1.35rem;font-weight:700;color:#1e1b4b;">Selamat Datang, {{ Auth::user()->name }}! 🛡️</h1>
        <p style="color:#64748b;font-size:0.875rem;margin-top:0.25rem;">Panel administrasi LibSchool.</p>
    </div>

    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem;">
        <div style="background:#fff;border-radius:1rem;padding:1.25rem;box-shadow:0 1px 6px rgba(0,0,0,0.06);">
            <p style="font-size:0.75rem;color:#94a3b8;font-weight:500;margin-bottom:0.4rem;">Total Users</p>
            <p style="font-size:1.75rem;font-weight:700;color:#1e1b4b;">0</p>
        </div>
        <div style="background:#fff;border-radius:1rem;padding:1.25rem;box-shadow:0 1px 6px rgba(0,0,0,0.06);">
            <p style="font-size:0.75rem;color:#94a3b8;font-weight:500;margin-bottom:0.4rem;">Total Buku</p>
            <p style="font-size:1.75rem;font-weight:700;color:#1e1b4b;">0</p>
        </div>
        <div style="background:#fff;border-radius:1rem;padding:1.25rem;box-shadow:0 1px 6px rgba(0,0,0,0.06);">
            <p style="font-size:0.75rem;color:#94a3b8;font-weight:500;margin-bottom:0.4rem;">Peminjaman Aktif</p>
            <p style="font-size:1.75rem;font-weight:700;color:#1e1b4b;">0</p>
        </div>
        <div style="background:#fff;border-radius:1rem;padding:1.25rem;box-shadow:0 1px 6px rgba(0,0,0,0.06);">
            <p style="font-size:0.75rem;color:#94a3b8;font-weight:500;margin-bottom:0.4rem;">Denda Belum Lunas</p>
            <p style="font-size:1.75rem;font-weight:700;color:#dc2626;">Rp 0</p>
        </div>
    </div>

    <div style="background:#fff;border-radius:1rem;padding:1.5rem;box-shadow:0 1px 6px rgba(0,0,0,0.06);">
        <p style="font-size:0.95rem;font-weight:700;color:#1e1b4b;margin-bottom:0.5rem;">Admin Panel</p>
        <p style="font-size:0.85rem;color:#64748b;">Fitur manajemen lengkap akan segera tersedia.</p>
    </div>
</div>
@endsection
