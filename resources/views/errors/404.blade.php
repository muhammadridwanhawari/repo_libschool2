<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan (404) - LibSchool</title>
    <link rel="icon" href="{{ asset('images/logo/LOGO.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 antialiased bg-[#eef1fa]">
    
    <div class="max-w-[850px] w-full bg-white rounded-2xl shadow-[0_24px_64px_-12px_rgba(0,0,0,0.08)] p-12 md:p-24 text-center transition-all">
        
        <h1 class="text-[2.75rem] sm:text-6xl md:text-[4.5rem] font-semibold text-[#333333] mb-8 tracking-tight uppercase leading-tight">
            KAMU NYASAR YAA
        </h1>
        
        <p class="text-[#4a4a4a] text-base md:text-[1.15rem] max-w-[42rem] mx-auto leading-relaxed font-medium">
            Halaman yang kamu cari udah pindah alamat atau emang nggak<br class="hidden md:block">
            pernah ada. Yuk, putar balik sebelum makin jauh!
        </p>

        <div class="mt-14 flex justify-center">
            <button onclick="window.history.back()" class="inline-flex items-center justify-center bg-[#4361EE] hover:bg-[#3A56D4] text-white font-semibold text-sm md:text-[0.95rem] px-10 py-4 md:px-12 md:py-[1.15rem] rounded-lg transition-transform hover:scale-[1.02] shadow-[0_4px_14px_0_rgba(67,97,238,0.39)] hover:shadow-[0_6px_20px_rgba(67,97,238,0.23)]">
                Balik Ke Halaman sebelumnya
            </button>
        </div>
        
    </div>

</body>
</html>
