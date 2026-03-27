<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LibSchool - Cari dan ulas buku favorite Anda dengan mudah</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        fontFamily: {
          sans: ['Plus Jakarta Sans', 'sans-serif'],
          serif: ['Instrument Serif', 'serif'],
        },
        colors: {
          blue: {
            DEFAULT: '#2563EB',
            light: '#3B82F6',
            dark: '#1D4ED8',
          },
          navy: '#0F172A',
        },
        keyframes: {
          fadeUp: {
            'from': { opacity: '0', transform: 'translateY(30px)' },
            'to': { opacity: '1', transform: 'translateY(0)' },
          },
        },
        animation: {
          fadeUp: 'fadeUp 0.7s ease both',
          fadeUpDelay: 'fadeUp 0.7s ease 0.2s both',
        },
      },
    },
  }
</script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
<style>
  body { font-family: 'Plus Jakarta Sans', sans-serif; }
  .font-serif-italic { font-family: 'Instrument Serif', serif; font-style: italic; }
  .hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
  .hamburger.open span:nth-child(2) { opacity: 0; }
  .hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

  /* ═══ MODIFIKASI: Animasi Mengapung Unik per Buku ═══ */
  @keyframes float1 {
    0%, 100% { transform: translateY(0px) rotate(-5deg); }
    50%       { transform: translateY(-15px) rotate(-5deg); }
  }
  @keyframes float2 {
    0%, 100% { transform: translateY(0px) rotate(4deg); }
    50%       { transform: translateY(-10px) rotate(4deg); }
  }
  @keyframes float3 {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50%       { transform: translateY(-20px) rotate(0deg); }
  }
  @keyframes float4 {
    0%, 100% { transform: translateY(0px) rotate(6deg); }
    50%       { transform: translateY(-12px) rotate(6deg); }
  }

  .book-float-1 { animation: float1 5s ease-in-out infinite; }
  .book-float-2 { animation: float2 6s ease-in-out infinite 0.5s; }
  .book-float-3 { animation: float3 5.5s ease-in-out infinite 1s; }
  .book-float-4 { animation: float4 5.8s ease-in-out infinite 0.2s; }

  /* ═══ MODIFIKASI: Styling Cover Buku (Tanpa Border, Halus) ═══ */
  .book-cover {
    position: absolute;
    display: block;
    border-radius: 8px; /* Sedikit rounding agar natural */
    object-fit: cover;
    /* Shadow halus agar terlihat tumpuk di atas background biru */
    box-shadow: 0 10px 30px rgba(0,0,0,0.2), 0 4px 10px rgba(0,0,0,0.1);
    /* Pastikan tidak ada border */
    border: none !important;
  }

  /* Container untuk area buku di kanan */
  .hero-right-container {
    position: relative;
    width: 100%;
    height: 100%; /* Mengikuti tinggi grid parent */
    min-h-[500px];
    overflow: visible;
  }
</style>
</head>
<body class="bg-white text-slate-800 overflow-x-hidden">

<nav class="fixed top-2 left-0 right-0 z-50 px-4 md:px-8 py-2">
  <div class="max-w-6xl mx-auto flex items-center justify-between h-14 px-5 md:px-8 bg-white/70 backdrop-blur-md rounded-full shadow-sm border border-white/20">
    <div class="flex items-center gap-2 flex-shrink-0">
      <img src="{{ asset('images/logo/LogoBlack.png') }}" alt="LibSchool Logo" class="h-9 w-auto object-contain">
    </div>

    <ul class="hidden md:flex gap-8 list-none absolute left-1/2 -translate-x-1/2 bg-white/60 backdrop-blur-sm px-6 py-2 rounded-full shadow-sm">
      <li><a href="#" class="text-sm font-semibold text-blue no-underline">Beranda</a></li>
      <li><a href="#fitur" class="text-sm font-medium text-slate-700 hover:text-blue no-underline transition-colors">Fitur</a></li>
      <li><a href="#layanan" class="text-sm font-medium text-slate-700 hover:text-blue no-underline transition-colors">Layanan</a></li>
      <li><a href="#team" class="text-sm font-medium text-slate-700 hover:text-blue no-underline transition-colors">Tentang Kami</a></li>
    </ul>

    <a href="{{ route('login') }}" class="hidden md:block px-6 py-2 rounded-lg bg-white text-slate-800 shadow-sm border border-slate-200 text-sm font-semibold hover:bg-slate-50 transition-colors no-underline flex-shrink-0">Login</a>

    <button id="hamburger" class="hamburger md:hidden flex flex-col justify-center gap-[5px] p-1.5 bg-transparent border-none cursor-pointer" aria-label="Menu">
      <span class="block w-6 h-0.5 bg-navy rounded transition-all duration-300"></span>
      <span class="block w-6 h-0.5 bg-navy rounded transition-all duration-300"></span>
      <span class="block w-6 h-0.5 bg-navy rounded transition-all duration-300"></span>
    </button>
  </div>
</nav>

<div id="mobileMenu" class="hidden fixed top-24 left-4 right-4 z-40 bg-white/95 backdrop-blur-md rounded-2xl border border-slate-200 shadow-lg px-6 py-4 flex-col">
  <a href="#" onclick="closeMenu()" class="py-3 text-[15px] font-semibold text-slate-800 border-b border-slate-100 hover:text-blue no-underline transition-colors">Beranda</a>
  <a href="#fitur" onclick="closeMenu()" class="py-3 text-[15px] font-semibold text-slate-800 border-b border-slate-100 hover:text-blue no-underline transition-colors">Fitur</a>
  <a href="#layanan" onclick="closeMenu()" class="py-3 text-[15px] font-semibold text-slate-800 border-b border-slate-100 hover:text-blue no-underline transition-colors">Layanan</a>
  <a href="#team" onclick="closeMenu()" class="py-3 text-[15px] font-semibold text-slate-800 hover:text-blue no-underline transition-colors">Tentang Kami</a>
  <a href="{{ route('login') }}" class="mt-3 w-full py-3 rounded-xl bg-white border border-slate-300 text-slate-800 text-[15px] font-bold text-center no-underline block">Login</a>
</div>

<section class="relative bg-white overflow-hidden min-h-screen">
  <div class="absolute inset-y-0 right-0 w-1/2 z-0">
    <img src="{{ asset('images/landing/CoverLanding.png') }}" 
         alt="Hero Background" 
         class="w-full h-full object-cover object-left">
  </div>

  <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 items-center gap-8 md:gap-10 px-5 md:px-8 lg:px-16 pt-32 pb-12 md:pt-40 md:pb-20 min-h-screen">
    <div class="animate-fadeUp text-center md:text-left pr-0 md:pr-10">
      <h1 class="text-[clamp(28px,5vw,54px)] font-extrabold leading-tight tracking-tight text-navy mb-4">
        Cari dan ulas <span class="font-serif-italic text-blue underline decoration-blue/40 underline-offset-4">buku favorite</span> Anda<br>dengan mudah
      </h1>
      <p class="text-[15px] leading-relaxed text-slate-500 max-w-md mx-auto md:mx-0 mb-8">
        Mulailah perjalanan sastra yang belum pernah ada sebelumnya dengan aplikasi perpustakaan revolusioner kami! Memperkenalkan pengalaman tanpa hambatan yang melampaui batasan tradisional, di mana Anda dapat dengan mudah mencari buku favorit Anda. ✨
      </p>
      <a href="#fitur" class="inline-flex items-center gap-2 bg-blue text-white px-7 py-3.5 rounded-xl text-sm font-bold hover:bg-blue-dark hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(37,99,235,.3)] transition-all no-underline">
        Mulai sekarang
        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M8 0L6.59 1.41 12.17 7H0v2h12.17l-5.58 5.59L8 16l8-8-8-8z"/></svg>
      </a>
    </div>

    <div class="animate-fadeUpDelay hidden md:block relative w-full h-full min-h-[550px]">
      
      <img src="{{ asset('images/landing/books-herosection/Talking to Strangers.png') }}"
           alt="Talking to Strangers"
           class="book-cover book-float-1"
           style="width: 190px; top: 10px; left: 10%; z-index: 20;">

      <img src="{{ asset('images/landing/books-herosection/The Midnight Library.png') }}"
           alt="The Midnight Library"
           class="book-cover book-float-2"
           style="width: 120px; top: 80px; right: 15%; z-index: 10;">

      <img src="{{ asset('images/landing/books-herosection/Dompet Ayah Sepatu Ibu.png') }}"
           alt="Dompet Ayah Sepatu Ibu"
           class="book-cover book-float-3"
           style="width: 260px; bottom: 20px; left: 25%; z-index: 30;">

      <img src="{{ asset('images/landing/books-herosection/The Visual MBA.png') }}"
           alt="The Visual MBA"
           class="book-cover book-float-4"
           style="width: 140px; bottom: 70px; right: 10%; z-index: 25;">
           
    </div>
  </div>
</section>

<section id="fitur" class="py-20 px-5 md:px-8 lg:px-16 bg-slate-50">
  <div class="flex items-center gap-2 text-xs font-bold text-blue uppercase tracking-wider mb-3">
    <span class="w-2 h-2 rounded-full bg-blue inline-block"></span>Fitur
  </div>
  <h2 class="text-[clamp(24px,3vw,38px)] font-extrabold text-navy tracking-tight mb-12">🤝 Apa yang bisa kamu lakukan?</h2>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white rounded-2xl p-8 border border-slate-200 hover:border-blue-light hover:shadow-[0_8px_32px_rgba(37,99,235,.1)] hover:-translate-y-1 transition-all duration-300">
      <div class="w-[52px] h-[52px] rounded-2xl bg-blue-100 flex items-center justify-center text-2xl mb-5">🔍</div>
      <h3 class="text-lg font-bold text-navy mb-2.5">Mencari buku</h3>
      <p class="text-sm leading-relaxed text-slate-500">Temukan buku-buku Anda favorite dengan pencarian buku kami yang canggih dan intuitif. Temukan karya terbaik dengan mudah dan cepat.</p>
    </div>
    <div class="bg-white rounded-2xl p-8 border border-slate-200 hover:border-blue-light hover:shadow-[0_8px_32px_rgba(37,99,235,.1)] hover:-translate-y-1 transition-all duration-300">
      <div class="w-[52px] h-[52px] rounded-2xl bg-blue-100 flex items-center justify-center text-2xl mb-5">💬</div>
      <h3 class="text-lg font-bold text-navy mb-2.5">Mengulas buku</h3>
      <p class="text-sm leading-relaxed text-slate-500">Tuliskan komentar dan pandangan Anda tentang buku yang telah Anda baca. Bagikan pengalaman membaca kepada sesama dengan mudah.</p>
    </div>
    <div class="bg-white rounded-2xl p-8 border border-slate-200 hover:border-blue-light hover:shadow-[0_8px_32px_rgba(37,99,235,.1)] hover:-translate-y-1 transition-all duration-300">
      <div class="w-[52px] h-[52px] rounded-2xl bg-blue-100 flex items-center justify-center text-2xl mb-5">❤️</div>
      <h3 class="text-lg font-bold text-navy mb-2.5">Wishlist buku</h3>
      <p class="text-sm leading-relaxed text-slate-500">Susun impian sastra Anda — buat daftar buku yang ingin Anda baca untuk perencanaan dan pertemuan di masa mendatang.</p>
    </div>
  </div>
</section>

<section id="layanan" class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <div class="mb-12">
            <p class="text-blue font-semibold mb-2">Layanan</p>
            <h2 class="text-3xl font-bold text-gray-900">
                🚀 • Layanan untukmu
            </h2>
        </div>

        <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
            <div>
                <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?w=800&h=600&fit=crop" alt="Library" class="rounded-xl shadow-2xl">
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">
                    <span class="text-blue">Pinjam</span> buku favoritmu langsung dari <span class="text-blue">LibSkool!</span>
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    Pinjam, nikmati, dan kembalikan buku dengan mudah! Dengan Libskhool, kamu dapat meminjam berbagai koleksi buku favorit secara digital maupun fisik. Sistem peminjaman yang mudah dan transparan memastikan kamu tidak akan kehilangan jejak buku yang dipinjam. Proses pengembalian juga sangat sederhana - cukup scan barcode atau konfirmasi secara online. Libskhool memudahkan perjalanan literasimu dengan layanan yang fleksibel dan user-friendly.
                </p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
            <div class="order-2 md:order-1">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">
                    Sewa Buku Cepat:<br>
                    Langsung <span class="text-blue">Aktivitas Membaca</span>
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    Pengen baca buku tapi gak mau beli? Sewa aja! Libskhool menyediakan layanan sewa buku dengan harga terjangkau. Pilih buku yang kamu inginkan, tentukan durasi sewa, dan mulai membaca! Sistem sewa yang fleksibel memungkinkan kamu untuk menikmati berbagai buku tanpa harus mengeluarkan biaya pembelian penuh. Cocok untuk pelajar, mahasiswa, atau siapa saja yang suka eksplorasi buku baru.
                </p>
            </div>
            <div class="order-1 md:order-2">
                <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=800&h=600&fit=crop" alt="Reading" class="rounded-xl shadow-2xl">
            </div>
        </div>

        <div class="mb-12">
            <p class="text-blue font-semibold mb-2">Terbaru kini!</p>
            <h2 class="text-3xl font-bold text-gray-900">
                💎 • Perpustakaan Digital
            </h2>
        </div>

        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=800&h=600&fit=crop" alt="Digital Library" class="rounded-xl shadow-2xl">
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">
                    Platform Digital Yang Menyediakan:<br>
                    Akses <span class="text-blue">Mudah, Cepat, dan Efisien!</span>
                </h3>
                <p class="text-gray-600 leading-relaxed">
                    Perpustakaan digital Libskhool memberi akses tanpa batas ke ribuan koleksi buku digital yang dapat dibaca kapan saja, di mana saja. Dengan antarmuka yang intuitif dan fitur pencarian yang canggih, menemukan buku yang kamu cari menjadi lebih mudah.
                </p>
                <p class="text-gray-600 leading-relaxed mt-4">
                    Akses perpustakaan digital melalui website atau aplikasi mobile kami. Baca buku favorit dari smartphone, tablet, atau komputer dengan pengalaman membaca yang nyaman dan menyenangkan.
                </p>
            </div>
        </div>
    </div>
</section>

<section id="about" class="py-20 px-5 md:px-8 lg:px-16 bg-slate-50">
  <div class="flex items-center gap-2 text-xs font-bold text-blue uppercase tracking-wider mb-3">
    <span class="w-2 h-2 rounded-full bg-blue inline-block"></span>tentang kami
  </div>
  <h2 class="text-[clamp(24px,3vw,38px)] font-extrabold text-navy tracking-tight mb-12">💬 Perpustakaan Digital</h2>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-16 items-center">
    <div class="rounded-2xl h-56 md:h-80 bg-gradient-to-br from-[#1e3a5f] to-blue flex items-center justify-center text-7xl">🏛️</div>
    <div>
      <h3 class="text-2xl font-extrabold text-navy tracking-tight leading-snug mb-4">
        Platform Digital Yang Menyediakan: Akses <span class="text-blue">Mudah, Cepat,</span> dan <span class="text-blue">Efisien!</span>
      </h3>
      <p class="text-sm leading-relaxed text-slate-500 mb-6">Perpustakaan Digital kami hadir sebagai solusi pembelajaran berbasis teknologi yang memudahkan Anda dalam mengakses koleksi data secara online.</p>
      <div class="flex flex-col gap-4">
        <div class="flex items-start gap-4 bg-white rounded-xl border border-slate-200 px-5 py-4">
          <span class="w-2.5 h-2.5 rounded-full bg-blue flex-shrink-0 mt-1.5"></span>
          <div>
            <strong class="block text-sm font-bold text-navy mb-0.5">Akses Mudah & Cepat</strong>
            <p class="text-sm text-slate-500">Baca ribuan buku kapan saja dan di mana saja tanpa batas waktu.</p>
          </div>
        </div>
        <div class="flex items-start gap-4 bg-white rounded-xl border border-slate-200 px-5 py-4">
          <span class="w-2.5 h-2.5 rounded-full bg-blue flex-shrink-0 mt-1.5"></span>
          <div>
            <strong class="block text-sm font-bold text-navy mb-0.5">Koleksi Lengkap</strong>
            <p class="text-sm text-slate-500">Tersedia berbagai genre buku dari dalam dan luar negeri terlengkap.</p>
          </div>
        </div>
        <div class="flex items-start gap-4 bg-white rounded-xl border border-slate-200 px-5 py-4">
          <span class="w-2.5 h-2.5 rounded-full bg-blue flex-shrink-0 mt-1.5"></span>
          <div>
            <strong class="block text-sm font-bold text-navy mb-0.5">Platform Terpercaya</strong>
            <p class="text-sm text-slate-500">Sistem yang aman dan terjamin kualitasnya untuk pengalaman membaca terbaik.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="team" class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900">
                Tim Profesional Pembuatan <span class="text-blue">Libschool.</span>
            </h2>
        </div>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-2xl transition overflow-hidden">
                <img src="public/images/landing/profildev/Ridwan.jpeg" alt="Muhammad Ridwan Hawari" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
                <h3 class="font-bold text-gray-900 mb-1">Muhammad Ridwan Hawari</h3>
                <p class="text-blue font-semibold mb-2">CEO</p>
                <p class="text-gray-600 text-sm">Chief Technology Officer </p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-2xl transition overflow-hidden">
                <img src="public/images/landing/profildev/Riski.png" alt="Riski Satria" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
                <h3 class="font-bold text-gray-900 mb-1">Riski Satria</h3>
                <p class="text-blue font-semibold mb-2">BE</p>
                <p class="text-gray-600 text-sm">Back End Developer</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-2xl transition overflow-hidden">
                <img src="public/images/landing/profildev/Dzikri.jpeg" alt="Muhammad Dzikri" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
                <h3 class="font-bold text-gray-900 mb-1">Muhammad Dzikri</h3>
                <p class="text-blue font-semibold mb-2">UI/UX & FE</p>
                <p class="text-gray-600 text-sm">UI/UX & Front End Developer</p>
            </div>
        </div>
    </div>
</section>

<section class="py-16 px-5 md:px-8 lg:px-16 bg-slate-50 text-center">
  <h2 class="text-2xl md:text-3xl font-extrabold text-navy tracking-tight mb-12">Dipercaya oleh Institusi Terkemuka.</h2>
  <div class="flex flex-wrap items-center justify-center gap-10 md:gap-14">
    <div class="opacity-60 hover:opacity-100 transition-opacity flex items-center gap-2 text-sm font-bold text-navy">⭐ INSTITUTION LOCAL</div>
    <div class="opacity-60 hover:opacity-100 transition-opacity text-2xl font-black text-navy">Gramedia</div>
    <div class="opacity-60 hover:opacity-100 transition-opacity text-xs font-bold text-navy text-center leading-tight">WORLD<br>FOUNDATION</div>
    <div class="opacity-60 hover:opacity-100 transition-opacity text-sm font-extrabold text-navy leading-snug">🐧 Penguin<br>Random House</div>
  </div>
</section>

<section class="py-16 px-5 md:px-8 lg:px-16 bg-white text-center">
  <h2 class="text-2xl md:text-3xl font-extrabold text-navy tracking-tight mb-12">Teknologi Yang Di Gunakan</h2>
  <div class="flex flex-col sm:flex-row items-center justify-center gap-5">
    <div class="flex items-center gap-3 px-6 py-3.5 rounded-xl border-2 border-red-200 bg-red-50 text-red-500 text-lg font-bold">
      <span class="text-xl">🔴</span> Laravel
    </div>
    <div class="flex items-center gap-3 px-6 py-3.5 rounded-xl border-2 border-sky-200 bg-sky-50 text-sky-500 text-lg font-bold">
      <span class="text-xl">🔵</span> tailwindcss
    </div>
  </div>
</section>

<footer class="bg-navy text-white px-5 md:px-8 lg:px-16 py-10 grid grid-cols-1 md:grid-cols-3 gap-8">
  <div>
    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Dikelola Oleh</p>
    <p class="text-2xl font-extrabold text-blue-light">LibSchool</p>
  </div>
  <div>
    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Sosial Media</p>
    <div class="flex gap-3">
      <a href="#" class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center hover:bg-blue transition-colors no-underline text-base">𝕏</a>
      <a href="#" class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center hover:bg-blue transition-colors no-underline text-base">📷</a>
      <a href="#" class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center hover:bg-blue transition-colors no-underline text-base">📘</a>
    </div>
  </div>
  <div>
    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Slogan</p>
    <p class="text-base font-bold text-white">#KeepUpOnPrettyJawir</p>
  </div>
</footer>
<div class="bg-[#0a0f1e] text-center text-slate-500 text-sm py-4 px-5">
  © 2026 LibSchool. All rights reserved.
</div>

<script>
  const hamburger = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobileMenu');

  hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('open');
    mobileMenu.classList.toggle('hidden');
    // Sinkronisasi display style
    if(mobileMenu.classList.contains('hidden')) {
        mobileMenu.style.display = 'none';
    } else {
        mobileMenu.style.display = 'flex';
        mobileMenu.style.flexDirection = 'column';
    }
  });

  function closeMenu() {
    hamburger.classList.remove('open');
    mobileMenu.classList.add('hidden');
    mobileMenu.style.display = 'none';
  }
</script>
</body>
</html>