<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - LibSchool</title>
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
        <h1 class="text-[22px] font-bold text-center text-slate-800 mb-2">Lupa Kata Sandi?</h1>
        <p class="text-[15px] font-medium text-slate-600 text-center mb-8 leading-relaxed">
            Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mereset kata sandi Anda.
        </p>

        {{-- Status / Error --}}
        @if (session('status'))
            <div class="mb-5 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-green-600 text-sm font-medium">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm font-medium">
                <ul class="list-none p-0 m-0">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" autocomplete="off">
            @csrf

            {{-- Input Email --}}
            <div class="mb-8">
                <label for="email" class="block text-[15px] font-medium text-slate-800 mb-2">Alamat Email</label>
                <input type="email" name="email" id="email"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 text-[15px] text-slate-800 bg-white outline-none transition-all duration-200 focus:border-[#4475F2] focus:ring-[3px] focus:ring-[#4475F2]/20"
                       placeholder="contoh@email.com"
                       value="{{ old('email') }}"
                       required autofocus>
            </div>

            {{-- Tombol Submit --}}
            <button type="submit"
                    class="w-full bg-[#4475F2] text-white rounded-xl py-3.5 text-[16px] font-bold tracking-wide transition-all hover:bg-blue-600 shadow-md hover:shadow-lg hover:-translate-y-0.5 active:bg-blue-700 active:shadow-md">
                Kirim Tautan Reset
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

</body>
</html>
