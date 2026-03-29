<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi - LibSchool</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative" style="background: linear-gradient(135deg, #4475F2 0%, #A2BEF8 100%);">

    {{-- Kartu --}}
    <div class="w-full max-w-[500px] bg-white rounded-3xl shadow-xl px-10 py-12 relative z-10">

        {{-- Logo --}}
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/logo/LogoBlack.png') }}" alt="LibSchool Logo" class="h-14 w-auto object-contain">
        </div>

        {{-- Judul / Subtitle --}}
        <h1 class="text-[22px] font-bold text-center text-slate-800 mb-2">Reset Kata Sandi</h1>
        <p class="text-[15px] font-medium text-slate-600 text-center mb-8 leading-relaxed">
            Masukkan kata sandi baru Anda di bawah ini.
        </p>

        {{-- Status / Error --}}
        @if ($errors->any())
            <div class="mb-5 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm font-medium">
                <ul class="list-none p-0 m-0">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.store') }}" autocomplete="off">
            @csrf

            {{-- Token --}}
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            {{-- Input Email --}}
            <div class="mb-5">
                <label for="email" class="block text-[15px] font-medium text-slate-800 mb-2">Alamat Email</label>
                <input type="email" name="email" id="email"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 text-[15px] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-[#4475F2] focus:ring-[3px] focus:ring-[#4475F2]/20"
                       placeholder="contoh@email.com"
                       value="{{ old('email', $request->email) }}"
                       required autofocus autocomplete="username">
            </div>

            {{-- Input Kata Sandi Baru --}}
            <div class="mb-5">
                <label for="password" class="block text-[15px] font-medium text-slate-800 mb-2">Kata Sandi Baru</label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 pr-12 text-[15px] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-[#4475F2] focus:ring-[3px] focus:ring-[#4475F2]/20"
                           placeholder="Kata sandi baru"
                           autocomplete="new-password"
                           required>
                    <button type="button"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none"
                            onclick="togglePassword('password', this)">
                        {{-- Icon Eye Slash --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Input Konfirmasi Kata Sandi --}}
            <div class="mb-8">
                <label for="password_confirmation" class="block text-[15px] font-medium text-slate-800 mb-2">Konfirmasi Kata Sandi</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 pr-12 text-[15px] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-[#4475F2] focus:ring-[3px] focus:ring-[#4475F2]/20"
                           placeholder="Ulangi kata sandi baru"
                           autocomplete="new-password"
                           required>
                    <button type="button"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none"
                            onclick="togglePassword('password_confirmation', this)">
                        {{-- Icon Eye Slash --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Tombol Submit --}}
            <button type="submit"
                    class="w-full bg-[#4475F2] text-white rounded-xl py-3.5 text-[16px] font-bold tracking-wide transition-all hover:bg-blue-600 shadow-md hover:shadow-lg hover:-translate-y-0.5 active:bg-blue-700 active:shadow-md">
                Reset Kata Sandi
            </button>
        </form>

        {{-- Login Link --}}
        <div class="mt-8 text-center text-[14.5px] text-gray-800">
            Ingat kata sandi? 
            <a href="{{ route('login') }}" class="font-bold text-[#4475F2] hover:text-blue-700 hover:underline">
                Login disini
            </a>
        </div>
    </div>

    <script>
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            btn.innerHTML = isHidden
                ? `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`
                : `<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>`;
        }
    </script>
</body>
</html>
