@extends('layouts.siswa')

@section('title', 'Usulkan Buku Baru')

@section('content')

<div class="w-full">
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-xl md:text-2xl font-bold text-slate-800">Usulkan Buku Baru</h1>
        <p class="text-xs md:text-[0.85rem] text-slate-500 mt-1">Bantu kembangkan koleksi perpustakaan</p>
    </div>

    <!-- MAIN FORM -->
    <form method="POST" action="{{ route('siswa.pengajuan.store') }}" class="mb-6">
        @csrf
        <div class="flex flex-col xl:flex-row gap-6 items-start">
            
            {{-- Left Col: Informasi Buku --}}
            <div class="w-full xl:flex-1 bg-white rounded-2xl p-6 md:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.02)] border border-slate-100">
                <div class="mb-6">
                    <h2 class="text-[0.95rem] font-bold text-slate-800">Informasi Buku</h2>
                    <p class="text-[0.75rem] text-slate-400 mt-0.5">Detail buku yang ingin Anda usulkan</p>
                </div>

                <div class="space-y-5">
                    {{-- Judul Buku --}}
                    <div>
                        <label class="block text-[0.8rem] font-bold text-slate-700 mb-2">Judul Buku <span class="text-red-500">*</span></label>
                        <input type="text" name="judul_buku" value="{{ old('judul_buku') }}" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-[0.85rem] text-slate-700 focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all {{ $errors->has('judul_buku') ? 'border-red-400' : '' }}" required>
                        @error('judul_buku') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Penulis --}}
                    <div>
                        <label class="block text-[0.8rem] font-bold text-slate-700 mb-2">Nama Penulis / Pengarang <span class="text-red-500">*</span></label>
                        <input type="text" name="penulis" value="{{ old('penulis') }}" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-[0.85rem] text-slate-700 focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all {{ $errors->has('penulis') ? 'border-red-400' : '' }}" required>
                        @error('penulis') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- ISBN & Penerbit --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[0.8rem] font-bold text-slate-700 mb-2">Nomor ISBN <span class="text-slate-400 font-normal">(opsional)</span></label>
                            <input type="text" name="isbn" value="{{ old('isbn') }}" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-[0.85rem] text-slate-700 focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all {{ $errors->has('isbn') ? 'border-red-400' : '' }}">
                            @error('isbn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-[0.8rem] font-bold text-slate-700 mb-2">Penerbit <span class="text-slate-400 font-normal">(opsional)</span></label>
                            <input type="text" name="penerbit" value="{{ old('penerbit') }}" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-[0.85rem] text-slate-700 focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all {{ $errors->has('penerbit') ? 'border-red-400' : '' }}">
                            @error('penerbit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Tahun & Kategori --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[0.8rem] font-bold text-slate-700 mb-2">Tahun Terbit <span class="text-slate-400 font-normal">(opsional)</span></label>
                            <input type="number" name="tahun_terbit" min="1900" max="{{ date('Y')+1 }}" value="{{ old('tahun_terbit') }}" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-[0.85rem] text-slate-700 focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all {{ $errors->has('tahun_terbit') ? 'border-red-400' : '' }}">
                            @error('tahun_terbit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-[0.8rem] font-bold text-slate-700 mb-2">Kategori <span class="text-slate-400 font-normal">(opsional)</span></label>
                            <select name="category_id" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-[0.85rem] text-slate-700 focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all bg-white {{ $errors->has('category_id') ? 'border-red-400' : '' }}">
                                <option value="">Pilih Kategori...</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Col: Informasi Pengusul --}}
            <div class="w-full xl:w-[420px] flex flex-col gap-6">
                
                <div class="bg-white rounded-2xl p-6 md:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.02)] border border-slate-100">
                    <div class="mb-6">
                        <h2 class="text-[0.95rem] font-bold text-slate-800">Informasi Pengusul</h2>
                        <p class="text-[0.75rem] text-slate-400 mt-0.5">Data diri dan alasan pengusulan</p>
                    </div>

                    <div class="space-y-5">
                        {{-- Nama --}}
                        <div>
                            <label class="block text-[0.8rem] font-bold text-slate-700 mb-2">Nama Lengkap Pengusul <span class="text-red-500">*</span></label>
                            <input type="text" value="{{ auth()->user()->name }}" class="w-full border border-slate-100 bg-slate-50 text-slate-500 rounded-xl px-4 py-3 text-[0.85rem] cursor-not-allowed outline-none focus:ring-0" readonly>
                        </div>

                        {{-- Alasan --}}
                        <div>
                            <label class="block text-[0.8rem] font-bold text-slate-700 mb-2">Alasan Pengusulan <span class="text-red-500">*</span></label>
                            <textarea name="alasan" rows="5" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-[0.85rem] text-slate-700 focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all resize-none {{ $errors->has('alasan') ? 'border-red-400' : '' }}" placeholder="Jelaskan mengapa buku ini perlu diadakan di perpustakaan..." required>{{ old('alasan') }}</textarea>
                            <p class="text-[0.7rem] text-slate-400 mt-2">Minimal 10 karakter</p>
                            @error('alasan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Footer form --}}
                        <div class="pt-4 mt-2 flex flex-wrap items-center justify-between border-t border-slate-100 gap-4">
                            <span class="text-[0.75rem] text-slate-400 font-medium"><span class="text-red-500">*</span> Wajib diisi</span>
                            <button type="submit" class="bg-[#4361ee] hover:bg-[#3250d4] text-white px-6 py-2.5 rounded-lg text-[0.85rem] font-bold transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2 flex-grow sm:flex-grow-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                                Kirim Pengajuan
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Info Box --}}
                <div class="bg-[#f0f6ff] border border-[#dce8fa] rounded-xl p-5 flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#3b82f6" stroke-width="2" class="mt-0.5 flex-shrink-0" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    <p class="text-[0.75rem] text-blue-600 font-medium leading-relaxed m-0">Pengajuan Anda akan ditinjau oleh admin perpustakaan. Proses review biasanya membutuhkan 1-3 hari kerja.</p>
                </div>
                
            </div>
        </div>
    </form>


    {{-- Kirim Pesan ke Penjaga --}}
    <form method="POST" action="{{ route('siswa.pengajuan.pesan') }}">
        @csrf
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-[0_2px_12px_rgba(0,0,0,0.02)] border border-slate-100 mt-2">
            
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-lg bg-[#f0f4ff] flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="#4361ee" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <div>
                    <h2 class="text-[0.95rem] font-bold text-slate-800">Kirim Pesan ke Penjaga</h2>
                    <p class="text-[0.75rem] text-slate-400 mt-0.5">Ada pertanyaan atau hal yang ingin disampaikan?</p>
                </div>
            </div>

            <div class="space-y-5">
                <div>
                    <label class="block text-[0.8rem] font-bold text-slate-700 mb-2">Subjek <span class="text-red-500">*</span></label>
                    <input type="text" name="subject" value="{{ old('subject') }}" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-[0.85rem] text-slate-700 focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all {{ $errors->has('subject') ? 'border-red-400' : '' }}" placeholder="Mis: Pertanyaan tentang peminjaman..." required>
                    @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-[0.8rem] font-bold text-slate-700 mb-2">Pesan <span class="text-red-500">*</span></label>
                    <textarea name="body" rows="4" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-[0.85rem] text-slate-700 focus:outline-none focus:border-indigo-400 focus:ring-4 focus:ring-indigo-50 transition-all resize-none {{ $errors->has('body') ? 'border-red-400' : '' }}" placeholder="Tulis pesanmu di sini..." required>{{ old('body') }}</textarea>
                    
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mt-3 gap-3">
                        <p class="text-[0.7rem] text-slate-400">Minimal 10 &bull; Maksimal 2000 karakter</p>
                        <button type="submit" class="bg-[#4361ee] hover:bg-[#3250d4] text-white px-8 py-2.5 rounded-lg text-[0.85rem] font-bold transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                            Kirim
                        </button>
                    </div>
                    @error('body') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

        </div>
    </form>

</div>

@endsection
