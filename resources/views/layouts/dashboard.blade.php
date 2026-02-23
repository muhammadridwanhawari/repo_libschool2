@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">Dashboard</h2>

<div class="grid grid-cols-3 gap-4">
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-semibold">Jumlah Buku</h3>
        <p class="text-3xl">{{ $booksCount }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-semibold">Jumlah Pinjaman</h3>
        <p class="text-3xl">{{ $borrowingsCount }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-semibold">Jumlah Denda</h3>
        <p class="text-3xl">{{ $finesCount }}</p>
    </div>
</div>
@endsection