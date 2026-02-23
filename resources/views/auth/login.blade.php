<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LibSchool</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">


    {{-- Logo --}}
    <div class="flex justify-center pt-10 pb-6">
        <img src="{{ asset('images/logo/logo.png') }}" alt="LibSchool Logo" width="92" height="92" style="object-fit:contain;filter:drop-shadow(0 6px 20px rgba(99,102,241,0.35))">
    </div>


    {{-- Garis Pemisah --}}
    <hr class="border-t-[1.5px] border-indigo-100 w-full">

    {{-- Konten Utama --}}
    <main class="flex-1 flex flex-col items-center px-4 pt-10 pb-4">
        <div class="w-full max-w-[420px] bg-white rounded-[1.25rem] border border-violet-100 shadow-[0_4px_24px_rgba(99,102,241,0.08)] px-9 py-9">

            {{-- Breadcrumb --}}
            <nav class="text-[0.82rem] mb-5 text-gray-400">
                <a href="/" class="text-indigo-500 font-semibold no-underline hover:underline">Beranda</a>
                <span class="mx-1 text-gray-300">/</span>
                <span>Login</span>
            </nav>

            {{-- Judul --}}
            <h1 class="text-[1.65rem] font-bold text-indigo-950 mb-1.5">Login</h1>
            <p class="text-[0.85rem] text-slate-400 mb-7 leading-relaxed">Masukkan nama pengguna dan kata sandi Anda.</p>

            {{-- Status Sesi --}}
            @if (session('status'))
                <div class="mb-5 px-4 py-3.5 bg-green-50 border border-green-200 rounded-[0.7rem] text-green-600 text-[0.83rem]">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Pesan Error --}}
            @if ($errors->any())
                <div class="mb-5 px-4 py-3.5 bg-red-50 border border-red-200 rounded-[0.7rem] text-red-600 text-[0.83rem]">
                    <ul class="list-none p-0 m-0">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" autocomplete="off">
                @csrf

                {{-- Nama Pengguna --}}
                <div class="mb-5">
                    <label for="username" class="block text-[0.875rem] font-semibold text-indigo-950 mb-1.5">Nama</label>
                    <input type="text" name="username" id="username"
                           class="w-full border-[1.5px] border-gray-200 rounded-[0.65rem] px-4 py-2.5 text-[0.875rem] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-indigo-500 focus:ring-[3px] focus:ring-indigo-500/15 placeholder-slate-300"
                           placeholder="e.g. ikyyskibidi"
                           value=""
                           autocomplete="off"
                           required autofocus>
                </div>

                {{-- Kata Sandi --}}
                <div class="mb-5">
                    <label for="password" class="block text-[0.875rem] font-semibold text-indigo-950 mb-1.5">Kata sandi</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                               class="w-full border-[1.5px] border-gray-200 rounded-[0.65rem] px-4 py-2.5 pr-11 text-[0.875rem] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-indigo-500 focus:ring-[3px] focus:ring-indigo-500/15 placeholder-slate-300"
                               placeholder="e.g. 4kuBu7uhM3dk1t"
                               autocomplete="new-password"
                               required>
                        <button type="button"
                                class="absolute right-3 top-1/2 -translate-y-1/2 bg-transparent border-0 cursor-pointer text-gray-400 flex items-center p-0 hover:text-gray-600"
                                onclick="togglePassword('password', this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    {{-- Lupa Kata Sandi --}}
                    <div class="flex justify-end mt-1.5">
                        <a href="{{ route('password.request') }}"
                           class="text-[0.78rem] text-indigo-500 font-medium hover:text-indigo-700 hover:underline transition-colors duration-150">
                            Lupa kata sandi?
                        </a>
                    </div>
                </div>

                {{-- Tombol Submit --}}
                <button type="submit"
                        class="w-full mt-2 bg-indigo-500 text-white border-0 rounded-[0.75rem] py-3.5 text-[0.95rem] font-bold tracking-wide cursor-pointer transition-all duration-200 shadow-[0_3px_10px_rgba(99,102,241,0.3)] hover:bg-indigo-600 hover:shadow-[0_5px_16px_rgba(99,102,241,0.4)] active:bg-indigo-700 block">
                    Login
                </button>
            </form>
        </div>

        {{-- Link Daftar --}}
        <p class="text-center mt-6 text-[0.85rem] text-gray-400">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-indigo-500 font-bold no-underline hover:underline">Daftar!</a>
        </p>
    </main>

    <footer class="text-center text-[0.8rem] text-slate-400 py-6 px-4">
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