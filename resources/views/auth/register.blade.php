<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - LibSchool</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Sembunyikan ikon visibility bawaan browser (Edge, Chrome, IE) */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear,
        input[type="password"]::-webkit-contacts-auto-fill-button,
        input[type="password"]::-webkit-credentials-auto-fill-button { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

    {{-- Logo --}}
    <div class="flex justify-center pt-10 pb-6">
        <img src="{{ asset('images/logo/logo.png') }}" alt="LibSchool Logo" width="88" height="88" style="object-fit:contain;filter:drop-shadow(0 4px 14px rgba(99,102,241,0.4))">
    </div>


    {{-- Garis Pemisah --}}
    <hr class="border-t border-indigo-100 w-full">

    {{-- Konten Utama --}}
    <main class="flex-1 flex justify-center px-4 py-8">
        <div class="w-full max-w-[680px] bg-white rounded-[1.25rem] border border-slate-100 shadow-[0_2px_16px_rgba(0,0,0,0.06)] px-10 py-10">

            {{-- Breadcrumb --}}
            <nav class="text-[0.8rem] mb-6 text-gray-400">
                <a href="/" class="text-indigo-500 font-medium no-underline hover:underline">Beranda</a>
                <span class="mx-1">/</span>
                <span>Login</span>
            </nav>

            {{-- Judul --}}
            <h1 class="text-[1.6rem] font-bold text-slate-800 mb-1">Daftar</h1>
            <p class="text-[0.85rem] text-slate-400 mb-8">Daftarkan diri Anda untuk melakukan sesuatu di LibSchool.</p>

            {{-- Pesan Error --}}
            @if ($errors->any())
                <div class="mb-6 px-4 py-4 bg-red-50 border border-red-200 rounded-[0.75rem] text-red-600 text-[0.85rem]">
                    <ul class="list-none p-0 m-0">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" autocomplete="off">
                @csrf

                {{-- Grid 2 Kolom --}}
                <div class="grid grid-cols-2 gap-5 sm:grid-cols-1">

                    <div>
                        <label class="block text-[0.85rem] font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" name="name" autocomplete="off"
                               class="w-full border-[1.5px] border-gray-200 rounded-[0.6rem] px-4 py-2.5 text-[0.875rem] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-indigo-500 focus:ring-[3px] focus:ring-indigo-500/15 placeholder-slate-300"
                               placeholder="e.g. Riski Satria"
                               value="{{ old('name') }}" required>
                    </div>

                    <div>
                        <label class="block text-[0.85rem] font-semibold text-gray-700 mb-1.5">NIK</label>
                        <input type="text" name="nik" autocomplete="off"
                               class="w-full border-[1.5px] border-gray-200 rounded-[0.6rem] px-4 py-2.5 text-[0.875rem] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-indigo-500 focus:ring-[3px] focus:ring-indigo-500/15 placeholder-slate-300"
                               placeholder="e.g. 1050241708900001"
                               value="{{ old('nik') }}" required>
                    </div>

                    <div>
                        <label class="block text-[0.85rem] font-semibold text-gray-700 mb-1.5">Nama pengguna</label>
                        <input type="text" name="username" autocomplete="off"
                               class="w-full border-[1.5px] border-gray-200 rounded-[0.6rem] px-4 py-2.5 text-[0.875rem] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-indigo-500 focus:ring-[3px] focus:ring-indigo-500/15 placeholder-slate-300"
                               placeholder="e.g. alfianchii"
                               value="{{ old('username') }}" required>
                    </div>

                    <div>
                        <label class="block text-[0.85rem] font-semibold text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="email" autocomplete="off"
                               class="w-full border-[1.5px] border-gray-200 rounded-[0.6rem] px-4 py-2.5 text-[0.875rem] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-indigo-500 focus:ring-[3px] focus:ring-indigo-500/15 placeholder-slate-300"
                               placeholder="e.g. alhan.ganteng@gmail.com"
                               value="{{ old('email') }}" required>
                    </div>

                    <div>
                        <label class="block text-[0.85rem] font-semibold text-gray-700 mb-1.5">Telepon</label>
                        <input type="text" name="telepon" autocomplete="off"
                               class="w-full border-[1.5px] border-gray-200 rounded-[0.6rem] px-4 py-2.5 text-[0.875rem] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-indigo-500 focus:ring-[3px] focus:ring-indigo-500/15 placeholder-slate-300"
                               placeholder="e.g. 082384763478"
                               value="{{ old('telepon') }}" required>
                    </div>

                    <div>
                        <label class="block text-[0.85rem] font-semibold text-gray-700 mb-1.5">Tanggal lahir</label>
                        <input type="date" name="tanggal_lahir"
                               class="w-full border-[1.5px] border-gray-200 rounded-[0.6rem] px-4 py-2.5 text-[0.875rem] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-indigo-500 focus:ring-[3px] focus:ring-indigo-500/15"
                               value="{{ old('tanggal_lahir') }}" required>
                    </div>

                    <div>
                        <label class="block text-[0.85rem] font-semibold text-gray-700 mb-1.5">Kata sandi</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" autocomplete="new-password"
                                   class="w-full border-[1.5px] border-gray-200 rounded-[0.6rem] px-4 py-2.5 pr-11 text-[0.875rem] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-indigo-500 focus:ring-[3px] focus:ring-indigo-500/15 placeholder-slate-300"
                                   placeholder="e.g. 4kuBu7uhM3dk1t" required>
                            <button type="button"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 bg-transparent border-0 cursor-pointer text-gray-400 flex items-center p-0 hover:text-gray-600"
                                    onclick="togglePassword('password', this)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[0.85rem] font-semibold text-gray-700 mb-1.5">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
                                   class="w-full border-[1.5px] border-gray-200 rounded-[0.6rem] px-4 py-2.5 pr-11 text-[0.875rem] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-indigo-500 focus:ring-[3px] focus:ring-indigo-500/15 placeholder-slate-300"
                                   placeholder="Ulangi kata sandi" required>
                            <button type="button"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 bg-transparent border-0 cursor-pointer text-gray-400 flex items-center p-0 hover:text-gray-600"
                                    onclick="togglePassword('password_confirmation', this)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[0.85rem] font-semibold text-gray-700 mb-1.5">Gender</label>
                        <div class="flex gap-6 mt-2">
                            <label class="flex items-center gap-1.5 cursor-pointer text-[0.875rem] text-gray-700">
                                <input type="radio" name="gender" value="Laki-laki"
                                       class="accent-indigo-500 w-4 h-4"
                                       {{ old('gender') == 'Laki-laki' ? 'checked' : '' }} required>
                                Laki-laki
                            </label>
                            <label class="flex items-center gap-1.5 cursor-pointer text-[0.875rem] text-gray-700">
                                <input type="radio" name="gender" value="Perempuan"
                                       class="accent-indigo-500 w-4 h-4"
                                       {{ old('gender') == 'Perempuan' ? 'checked' : '' }}>
                                Perempuan
                            </label>
                        </div>
                    </div>

                </div>

                {{-- Tombol Submit --}}
                <button type="submit"
                        class="w-full mt-8 bg-indigo-500 text-white border-0 rounded-[0.75rem] py-3.5 text-[0.95rem] font-bold tracking-wide cursor-pointer transition-all duration-200 shadow-[0_2px_8px_rgba(99,102,241,0.25)] hover:bg-indigo-600 hover:shadow-[0_4px_14px_rgba(99,102,241,0.35)] active:bg-indigo-700 block">
                    Daftar
                </button>

                <p class="text-center mt-5 text-[0.85rem] text-gray-500">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-indigo-500 font-bold no-underline hover:underline">Masuk</a>
                </p>
            </form>

        </div>
    </main>

    <footer class="text-center text-[0.8rem] text-slate-400 py-6">
        &copy; 2026 LibSchool. Hak cipta dilindungi.
    </footer>

    <script>
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            btn.innerHTML = isHidden
                ? `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`
                : `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>`;
        }
    </script>

</body>
</html>