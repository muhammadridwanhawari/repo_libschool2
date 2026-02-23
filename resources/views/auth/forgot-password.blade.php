<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - LibSchool</title>
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
                <a href="{{ route('login') }}" class="text-indigo-500 font-semibold no-underline hover:underline">Login</a>
                <span class="mx-1 text-gray-300">/</span>
                <span>Lupa Kata Sandi</span>
            </nav>

            {{-- Judul --}}
            <h1 class="text-[1.65rem] font-bold text-indigo-950 mb-1.5">Lupa Kata Sandi?</h1>
            <p class="text-[0.85rem] text-slate-400 mb-7 leading-relaxed">
                Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mereset kata sandi Anda.
            </p>

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

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                {{-- Alamat Email --}}
                <div class="mb-5">
                    <label for="email" class="block text-[0.875rem] font-semibold text-indigo-950 mb-1.5">Alamat Email</label>
                    <input type="email" name="email" id="email"
                           class="w-full border-[1.5px] border-gray-200 rounded-[0.65rem] px-4 py-2.5 text-[0.875rem] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-indigo-500 focus:ring-[3px] focus:ring-indigo-500/15 placeholder-slate-300"
                           placeholder="contoh@email.com"
                           value="{{ old('email') }}"
                           required autofocus>
                </div>

                {{-- Tombol Submit --}}
                <button type="submit"
                        class="w-full mt-2 bg-indigo-500 text-white border-0 rounded-[0.75rem] py-3.5 text-[0.95rem] font-bold tracking-wide cursor-pointer transition-all duration-200 shadow-[0_3px_10px_rgba(99,102,241,0.3)] hover:bg-indigo-600 hover:shadow-[0_5px_16px_rgba(99,102,241,0.4)] active:bg-indigo-700 block">
                    Kirim Tautan Reset
                </button>
            </form>
        </div>

        {{-- Link kembali login --}}
        <p class="text-center mt-6 text-[0.85rem] text-gray-400">
            Ingat kata sandi?
            <a href="{{ route('login') }}" class="text-indigo-500 font-bold no-underline hover:underline">Login!</a>
        </p>
    </main>

    <footer class="text-center text-[0.8rem] text-slate-400 py-6 px-4">
        &copy; 2026 LibSchool. Hak cipta dilindungi.
    </footer>

</body>
</html>
