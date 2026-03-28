<!DOCTYPE html>
<html lang="id" style="scroll-behavior: smooth;">
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
    0%, 100% { transform: translateY(0px) rotate(-6deg); }
    50%       { transform: translateY(-14px) rotate(-6deg); }
  }
  @keyframes float2 {
    0%, 100% { transform: translateY(0px) rotate(5deg); }
    50%       { transform: translateY(-10px) rotate(5deg); }
  }
  @keyframes float3 {
    0%, 100% { transform: translateY(0px) rotate(-2deg); }
    50%       { transform: translateY(-18px) rotate(-2deg); }
  }
  @keyframes float4 {
    0%, 100% { transform: translateY(0px) rotate(3deg); }
    50%       { transform: translateY(-12px) rotate(3deg); }
  }

  .book-float-1 { animation: float1 5s ease-in-out infinite; }
  .book-float-2 { animation: float2 6s ease-in-out infinite 0.5s; }
  .book-float-3 { animation: float3 5.5s ease-in-out infinite 1s; }
  .book-float-4 { animation: float4 5.8s ease-in-out infinite 0.2s; }

  /* ═══ MODIFIKASI: Styling Cover Buku (Tanpa Border, Halus) ═══ */
  .book-cover {
    position: absolute;
    display: block;
    border-radius: 10px;
    object-fit: cover;
    border: none !important;
  }

  /* Container untuk area buku di kanan */
  .hero-right-container {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: visible;
  }
</style>
</head>
<body id="home" class="bg-white text-slate-800 overflow-x-hidden">

<nav class="fixed top-2 left-0 right-0 z-50 px-4 md:px-8 py-2">
  <div class="max-w-6xl mx-auto flex items-center justify-between h-14 px-5 md:px-8 bg-white/70 backdrop-blur-md rounded-full shadow-sm border border-white/20">
    <div class="flex items-center gap-2 flex-shrink-0">
      <img src="{{ asset('images/logo/LogoBlack.png') }}" alt="LibSchool Logo" class="h-9 w-auto object-contain">
    </div>

    <ul class="hidden md:flex gap-8 list-none absolute left-1/2 -translate-x-1/2 bg-white/60 backdrop-blur-sm px-6 py-2 rounded-full shadow-sm">
      <li><a href="#home" class="text-sm font-semibold text-blue no-underline">Beranda</a></li>
      <li><a href="#fitur" class="text-sm font-medium text-slate-700 hover:text-blue no-underline transition-colors">Fitur</a></li>
      <li><a href="#layanan" class="text-sm font-medium text-slate-700 hover:text-blue no-underline transition-colors">Layanan</a></li>
      <li><a href="#about" class="text-sm font-medium text-slate-700 hover:text-blue no-underline transition-colors">Tentang Kami</a></li>
      <li><a href="#contact" class="text-sm font-medium text-slate-700 hover:text-blue no-underline transition-colors">Hubungi Kami</a></li>
    </ul>

    <a href="{{ route('login') }}" class="hidden md:block px-6 py-2 rounded-full bg-white text-slate-800 shadow-sm border border-slate-200 text-sm font-semibold hover:bg-slate-50 transition-colors no-underline flex-shrink-0">Login</a>

    <button id="hamburger" class="hamburger md:hidden flex flex-col justify-center gap-[5px] p-1.5 bg-transparent border-none cursor-pointer" aria-label="Menu">
      <span class="block w-6 h-0.5 bg-navy rounded transition-all duration-300"></span>
      <span class="block w-6 h-0.5 bg-navy rounded transition-all duration-300"></span>
      <span class="block w-6 h-0.5 bg-navy rounded transition-all duration-300"></span>
    </button>
  </div>
</nav>

<div id="mobileMenu" class="hidden fixed top-24 left-4 right-4 z-40 bg-white/95 backdrop-blur-md rounded-2xl border border-slate-200 shadow-lg px-6 py-4 flex-col">
  <a href="#home" onclick="closeMenu()" class="py-3 text-[15px] font-semibold text-slate-800 border-b border-slate-100 hover:text-blue no-underline transition-colors">Beranda</a>
  <a href="#fitur" onclick="closeMenu()" class="py-3 text-[15px] font-semibold text-slate-800 border-b border-slate-100 hover:text-blue no-underline transition-colors">Fitur</a>
  <a href="#layanan" onclick="closeMenu()" class="py-3 text-[15px] font-semibold text-slate-800 border-b border-slate-100 hover:text-blue no-underline transition-colors">Layanan</a>
  <a href="#about" onclick="closeMenu()" class="py-3 text-[15px] font-semibold text-slate-800 border-b border-slate-100 hover:text-blue no-underline transition-colors">Tentang Kami</a>
  <a href="#contact" onclick="closeMenu()" class="py-3 text-[15px] font-semibold text-slate-800 hover:text-blue no-underline transition-colors">Hubungi Kami</a>
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
      <h1 class="text-[clamp(36px,7vw,72px)] font-extrabold leading-tight tracking-tight text-navy mb-4">
        Perpustakaan Digital Sekolah Modern <span class=" text-blue underline decoration-blue/40 underline-offset-4">Hemat Waktu, Pinjam Buku Instant!</span><br>
      </h1>
      <p class="text-[clamp(16px,2.5vw,20px)] leading-relaxed text-slate-500 max-w-md mx-auto md:mx-0 mb-8">
        Mulailah perjalanan sastra yang belum pernah ada sebelumnya dengan aplikasi perpustakaan revolusioner kami! Memperkenalkan pengalaman tanpa hambatan yang melampaui batasan tradisional, di mana Anda dapat dengan mudah mencari buku favorit Anda. ✨
      </p>
      <a href="#fitur" class="inline-flex items-center gap-2 bg-blue text-white px-7 py-3.5 rounded-xl text-sm font-bold hover:bg-blue-dark hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(37,99,235,.3)] transition-all no-underline">
        Mulai sekarang
        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M8 0L6.59 1.41 12.17 7H0v2h12.17l-5.58 5.59L8 16l8-8-8-8z"/></svg>
      </a>
    </div>

    <div class="animate-fadeUpDelay hidden md:block relative w-full h-full min-h-[550px]">

      {{-- "Talking to Strangers" — tengah-atas, sedikit condong kiri, foreground kiri --}}
      <img src="{{ asset('images/landing/books-herosection/Talking to Strangers.png') }}"
           alt="Talking to Strangers"
           class="book-cover book-float-1"
           style="width: 250px; top: 30px; left: 20%; z-index: 20;">

      {{-- "The Midnight Library" — kanan-atas, lebih kecil, sedikit condong kanan, di belakang --}}
      <img src="{{ asset('images/landing/books-herosection/The Midnight Library.png') }}"
           alt="The Midnight Library"
           class="book-cover book-float-2"
           style="width: 300px; top: 30px; right: 20%; z-index: 15;">

      {{-- "Dompet Ayah Sepatu Ibu" — besar di tengah-kiri bawah, paling depan --}}
      <img src="{{ asset('images/landing/books-herosection/Dompet Ayah Sepatu Ibu.png') }}"
           alt="Dompet Ayah Sepatu Ibu"
           class="book-cover book-float-3"
           style="width: 300px; bottom: 35px; left: 15%; z-index: 30;">

      {{-- "The Visual MBA" — kanan-bawah, ukuran sedang, sedikit condong kanan --}}
      <img src="{{ asset('images/landing/books-herosection/The Visual MBA.png') }}"
           alt="The Visual MBA"
           class="book-cover book-float-4"
           style="width: 275px; bottom: 80px; right: 20%; z-index: 25;">
           
    </div>
  </div>
</section>

<section id="fitur" class="py-20 px-5 md:px-8 lg:px-16 bg-white">
  <h2 class="text-[clamp(24px,3vw,38px)] font-extrabold text-navy tracking-tight text-center mb-12">Fitur Utama Untuk Siswa</h2>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto">

    {{-- Card 1: Mencari buku --}}
    <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm hover:shadow-[0_12px_40px_rgba(37,99,235,.12)] hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center">
      <div class="w-[72px] h-[72px] rounded-2xl bg-[#4F80F5] flex items-center justify-center mb-5 shadow-md">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="11" cy="11" r="7" stroke="white" stroke-width="2.2"/>
          <path d="M17 17L21 21" stroke="white" stroke-width="2.2" stroke-linecap="round"/>
        </svg>
      </div>
      <h3 class="text-lg font-bold text-navy mb-3">Mencari buku</h3>
      <p class="text-sm leading-relaxed text-slate-500">cari koleksi buku sekolah hanya dengan satu ketukan di SmartPhone</p>
    </div>

    {{-- Card 2: Cek Ketersediaan --}}
    <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm hover:shadow-[0_12px_40px_rgba(37,99,235,.12)] hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center">
      <div class="w-[72px] h-[72px] rounded-2xl bg-[#4F80F5] flex items-center justify-center mb-5 shadow-md">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M5 7h9" stroke="white" stroke-width="2.2" stroke-linecap="round"/>
          <path d="M5 12h9" stroke="white" stroke-width="2.2" stroke-linecap="round"/>
          <path d="M5 17h9" stroke="white" stroke-width="2.2" stroke-linecap="round"/>
          <path d="M17 8l-2 2-1-1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M17 13l-2 2-1-1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M17 18l-2 2-1-1" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <h3 class="text-lg font-bold text-navy mb-3">Cek Ketersediaan</h3>
      <p class="text-sm leading-relaxed text-slate-500">ketahui apakah buku sedang tersedia atau sedang di pinjam secara real time.</p>
    </div>

    {{-- Card 3: Booking Buku --}}
    <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm hover:shadow-[0_12px_40px_rgba(37,99,235,.12)] hover:-translate-y-1 transition-all duration-300 flex flex-col items-center text-center">
      <div class="w-[72px] h-[72px] rounded-2xl bg-[#4F80F5] flex items-center justify-center mb-5 shadow-md">
        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect x="4" y="3" width="14" height="18" rx="2" stroke="white" stroke-width="2.2"/>
          <path d="M9 7h6" stroke="white" stroke-width="2" stroke-linecap="round"/>
          <path d="M12 11v5" stroke="white" stroke-width="2" stroke-linecap="round"/>
          <path d="M9.5 13.5L12 16l2.5-2.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <h3 class="text-lg font-bold text-navy mb-3">Booking Buku</h3>
      <p class="text-sm leading-relaxed text-slate-500">Amankan buku favoritmu! Sebelum orang lain meminjamnya.</p>
    </div>

  </div>
</section>

<!-- SECTION METODE PEMINJAMAN -->
<section id="how-to" class="py-20 px-5 md:px-8 lg:px-16 bg-white overflow-hidden">
  <div class="max-w-6xl mx-auto">
    <h2 class="text-[clamp(24px,3vw,38px)] font-extrabold text-navy tracking-tight text-center mb-16">Bagaimana Cara Meminjam Buku?</h2>
    
    <div class="relative">
      <!-- Continuous horizontal line -->
      <div class="hidden md:block absolute top-[117px] left-[12.5%] right-[12.5%] h-[2px] bg-blue-200 z-0"></div>
      
      <div class="grid grid-cols-1 md:grid-cols-4 gap-12 md:gap-4 relative z-10 w-full">
        <!-- Step 1 -->
        <div class="flex flex-col items-center justify-start text-center group">
          <div class="w-20 h-20 rounded-full bg-[#4F80F5] text-white flex items-center justify-center text-3xl font-bold shadow-[0_8px_24px_rgba(79,128,245,.4)] mb-8 transition-transform duration-300 group-hover:-translate-y-2">
            1
          </div>
          <div class="hidden md:block w-3 h-3 rounded-full bg-[#4F80F5] mb-8 ring-4 ring-white"></div>
          <h3 class="text-lg font-bold text-navy mb-2">Cari & Booking</h3>
          <p class="text-[13.5px] leading-relaxed text-slate-500 max-w-[220px]">Temukan buku di aplikasi dan tekan tombol pinjam.</p>
        </div>

        <!-- Step 2 -->
        <div class="flex flex-col items-center justify-start text-center group">
          <div class="w-20 h-20 rounded-full bg-[#4F80F5] text-white flex items-center justify-center text-3xl font-bold shadow-[0_8px_24px_rgba(79,128,245,.4)] mb-8 transition-transform duration-300 group-hover:-translate-y-2">
            2
          </div>
          <div class="hidden md:block w-3 h-3 rounded-full bg-[#4F80F5] mb-8 ring-4 ring-white"></div>
          <h3 class="text-lg font-bold text-navy mb-2">Dapatkan Kode</h3>
          <p class="text-[13.5px] leading-relaxed text-slate-500 max-w-[220px]">Sistem akan mengirimkan kode booking unik ke akunmu.</p>
        </div>

        <!-- Step 3 -->
        <div class="flex flex-col items-center justify-start text-center group">
          <div class="w-20 h-20 rounded-full bg-[#4F80F5] text-white flex items-center justify-center text-3xl font-bold shadow-[0_8px_24px_rgba(79,128,245,.4)] mb-8 transition-transform duration-300 group-hover:-translate-y-2">
            3
          </div>
          <div class="hidden md:block w-3 h-3 rounded-full bg-[#4F80F5] mb-8 ring-4 ring-white"></div>
          <h3 class="text-lg font-bold text-navy mb-2">Tunjukkan Kode</h3>
          <p class="text-[13.5px] leading-relaxed text-slate-500 max-w-[220px]">Datang ke perpustakaan dan tunjukan kode kepada petugas.</p>
        </div>

        <!-- Step 4 -->
        <div class="flex flex-col items-center justify-start text-center group">
          <div class="w-20 h-20 rounded-full bg-[#4F80F5] text-white flex items-center justify-center text-3xl font-bold shadow-[0_8px_24px_rgba(79,128,245,.4)] mb-8 transition-transform duration-300 group-hover:-translate-y-2">
            4
          </div>
          <div class="hidden md:block w-3 h-3 rounded-full bg-[#4F80F5] mb-8 ring-4 ring-white"></div>
          <h3 class="text-lg font-bold text-navy mb-2">Buku Diterima</h3>
          <p class="text-[13.5px] leading-relaxed text-slate-500 max-w-[220px]">Petugas check kode dan melakukan proses, dan buku siap dibawa.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="layanan" class="py-20 px-5 md:px-8 lg:px-16 bg-white overflow-hidden">
  <div class="max-w-6xl mx-auto">
    <h2 class="text-[clamp(24px,3vw,38px)] font-extrabold text-navy tracking-tight text-center mb-16">Layanan Untukmu</h2>

    <div class="max-w-5xl mx-auto flex flex-col gap-20">
      {{-- Card 1 --}}
      <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 items-center">
        <div class="order-1 group">
          <div class="overflow-hidden rounded-2xl shadow-[0_8px_30px_rgba(0,0,0,0.08)]">
            <img src="{{ asset('images/landing/layanan/Gemini_Generated_Image_15bdob15bdob15bd.png') }}" alt="Membaca di Aplikasi" class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500">
          </div>
        </div>
        <div class="order-2">
          <h3 class="text-2xl font-bold text-navy mb-1">Pinjam Buku Favoritmu</h3>
          <p class="text-xl text-[#4F80F5] mb-4">Langsung dari Aplikasi!</p>
          <p class="text-[14.5px] leading-relaxed text-slate-500">
            Tidak perlu lagi bolak-balik ke perpustakaan untuk mengecek ketersediaan buku. Cari judul yang kamu butuhkan, lihat detailnya, dan amankan bukumu dengan fitur booking online kapan saja dan dari mana saja.
          </p>
        </div>
      </div>

      {{-- Card 2 --}}
      <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 items-center">
        <div class="order-2 md:order-1">
          <h3 class="text-2xl font-bold text-navy mb-1">Sewa/Pinjam Buku Cepat:</h3>
          <p class="text-xl text-[#4F80F5] mb-4">Langsung Nikmati Aktivitas Membaca</p>
          <p class="text-[14.5px] leading-relaxed text-slate-500">
            Lupakan antrian panjang di meja administrasi. Cukup tunjukan kode booking dari smartPhone mu kepada penjaga perpustakaan, ambil bukumu dan kamu bisa langsung pokus membaca tanpa proses yang berlibet.
          </p>
        </div>
        <div class="order-1 md:order-2 group">
          <div class="overflow-hidden rounded-2xl shadow-[0_8px_30px_rgba(0,0,0,0.08)]">
            <img src="{{ asset('images/landing/layanan/The Secret World of Arrietty.jpg') }}" alt="Aktivitas Membaca Cepat" class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500">
          </div>
        </div>
      </div>

      {{-- Card 3 --}}
      <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 items-center">
        <div class="order-1 group">
          <div class="overflow-hidden rounded-2xl shadow-[0_8px_30px_rgba(0,0,0,0.08)]">
            <img src="{{ asset('images/landing/layanan/Gemini_Generated_Image_g4plelg4plelg4pl.png') }}" alt="Platform Digital" class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500">
          </div>
        </div>
        <div class="order-2">
          <h3 class="text-2xl font-bold text-navy mb-1">Platform Digital Yang Menyediakan:</h3>
          <p class="text-xl text-[#4F80F5] mb-4">Akses Mudah, Cepat dan Efisien!</p>
          <p class="text-[14.5px] leading-relaxed text-slate-500">
            nikmati kemudahan akses koleksi literatur sekolah dalam genggaman, di dukung sistem yang responsif untuk memaksimalkan efisiensi belajar anda.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="about" class="py-20 px-5 md:px-8 lg:px-16 bg-white overflow-hidden">
  <div class="max-w-6xl mx-auto">
    <h2 class="text-[clamp(24px,3vw,38px)] font-extrabold text-navy tracking-tight text-center mb-16">Tentang Kami</h2>

    <div class="max-w-5xl mx-auto">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 items-center">
        <div class="order-1 group">
          <div class="overflow-hidden rounded-2xl shadow-[0_8px_30px_rgba(0,0,0,0.08)]">
            <img src="{{ asset('images/landing/tentang-kami/Gemini_Generated_Image_j1rtt1j1rtt1j1rt.png') }}" alt="Tentang Kami" class="w-full h-auto object-cover group-hover:scale-105 transition-transform duration-500">
          </div>
        </div>
        <div class="order-2">
          <h3 class="text-2xl font-bold text-navy mb-1">Platform Digital Yang Menyediakan:</h3>
          <p class="text-xl text-[#4F80F5] mb-6">Akses Mudah, Cepat, dan Efisien!</p>
          <div class="space-y-4">
            <p class="text-[14.5px] leading-relaxed text-slate-500">
              Perpustakaan Digital kami hadir sebagai solusi pembelajaran berbasis Teknologi yang memudahkan siswa dan tenaga pendidik dalam Mengakses, meminjam, dan mengelola koleksi buku secara online.
            </p>
            <p class="text-[14.5px] leading-relaxed text-slate-500">
              Kami mengintregrasikan sistem yang transparan, mendukung budaya Literasi di lingkungan sekolah.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="team" class="py-20 px-5 md:px-8 lg:px-16 bg-white overflow-hidden">
  <div class="max-w-6xl mx-auto">
    <h2 class="text-[clamp(24px,3vw,32px)] font-bold text-gray-900 text-center mb-16">
      Tim Profesional Pembuatan Libshool.
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
      
      {{-- Card 1: CTO --}}
      <div class="bg-white border border-slate-100 shadow-[0_4px_24px_rgba(0,0,0,0.06)] px-6 py-12 flex flex-col items-center text-center">
        <img src="{{ asset('images/landing/profildev/Ridwan.jpeg') }}" 
             alt="Muhammad Ridwan hawari" 
             class="w-32 h-32 rounded-full object-cover mb-8">
        <h3 class="text-[17px] font-bold text-slate-500 mb-16">Muhammad Ridwan hawari</h3>
        
        <p class="text-[13px] font-bold text-slate-700 mb-2">CTO</p>
        <p class="text-[11px] font-medium text-slate-700">Chief Technology Officer</p>
      </div>

      {{-- Card 2: BE --}}
      <div class="bg-white border border-slate-100 shadow-[0_4px_24px_rgba(0,0,0,0.06)] px-6 py-12 flex flex-col items-center text-center">
        <img src="{{ asset('images/landing/profildev/Riski.png') }}" 
             alt="Riski Satria" 
             class="w-32 h-32 rounded-full object-cover mb-8">
        <h3 class="text-[17px] font-bold text-slate-500 mb-16">Riski Satria</h3>
        
        <p class="text-[13px] font-bold text-slate-700 mb-2">BE</p>
        <p class="text-[11px] font-medium text-slate-700">Back End Depelover</p>
      </div>

      {{-- Card 3: UI/UX & FE --}}
      <div class="bg-white border border-slate-100 shadow-[0_4px_24px_rgba(0,0,0,0.06)] px-6 py-12 flex flex-col items-center text-center">
        <img src="{{ asset('images/landing/profildev/Dzikri.jpeg') }}" 
             alt="Muhammad Dzikri" 
             class="w-32 h-32 rounded-full object-cover mb-8">
        <h3 class="text-[17px] font-bold text-slate-500 mb-16">Muhammad Dzikri</h3>
        
        <p class="text-[13px] font-bold text-slate-700 mb-2">UI/UX & FE</p>
        <p class="text-[11px] font-medium text-slate-700">UI/UX Front End Depelover</p>
      </div>

    </div>
  </div>
</section>

{{-- ═══ SECTION: CTA Banner ═══ --}}
<section id="contact" class="py-16 px-5 md:px-8 lg:px-16 bg-white">
  <div class="max-w-5xl mx-auto">
    <div class="relative rounded-3xl overflow-hidden" style="background: linear-gradient(135deg, #4475F2 0%, #7BA3F7 60%, #FDFDFD 100%);">
      
      {{-- Gambar di sebelah kanan dengan opacity --}}
      <div class="absolute inset-y-0 right-0 w-1/2 flex items-center justify-end">
        <img src="{{ asset('images/landing/fitur-tambahan/download.jpg') }}" 
             alt="Fitur Tambahan" 
             class="h-full w-full object-cover object-left"
             style="opacity: 0.35; mix-blend-mode: luminosity;">
      </div>

      {{-- Konten teks + tombol --}}
      <div class="relative z-10 px-10 py-16 md:py-20 md:w-3/5 text-white">
        <h2 class="text-[clamp(26px,4vw,42px)] font-extrabold leading-tight mb-5">
          Transformasi Perpustakaan Sekolah Anda Sekarang!
        </h2>
        <p class="text-[15px] leading-relaxed text-white/80 mb-10 max-w-md">
          Rasakan pengalaman membaca yang lebih Modern dan menyenangkan menggunakan Libschool!
        </p>
        <div class="flex flex-wrap gap-4">
          <a href="{{ route('register') }}" 
             class="px-8 py-3.5 bg-white text-[#4475F2] font-bold text-sm rounded-full shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all no-underline">
            Daftar Gratis
          </a>
          <a href="#footer" 
             class="px-8 py-3.5 bg-transparent border-2 border-white/60 text-white font-bold text-sm rounded-full hover:bg-white/10 hover:-translate-y-0.5 transition-all no-underline">
            Hubungi Kami
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="py-16 px-5 md:px-8 lg:px-16 bg-white text-center">
  <h2 class="text-2xl md:text-3xl font-extrabold text-navy tracking-tight mb-14">Dipercaya oleh Institusi Terkemuka.</h2>
  <div class="flex flex-wrap items-center justify-center gap-12 md:gap-20 max-w-5xl mx-auto">

    {{-- Perpustakaan Nasional --}}
    <div class="opacity-60 hover:opacity-100 transition-all duration-300 hover:-translate-y-1">
      <img src="{{ asset('images/landing/logo/LOGO-PERPUSNAS 1.png') }}" alt="Perpustakaan Nasional" class="h-16 w-auto object-contain">
    </div>

    {{-- Gramedia --}}
    <div class="opacity-60 hover:opacity-100 transition-all duration-300 hover:-translate-y-1">
      <img src="{{ asset('images/landing/logo/Gramedia_wordmark 1.png') }}" alt="Gramedia" class="h-10 w-auto object-contain">
    </div>

    {{-- World Literacy Foundation --}}
    <div class="opacity-60 hover:opacity-100 transition-all duration-300 hover:-translate-y-1">
      <img src="{{ asset('images/landing/logo/WLF.png') }}" alt="World Literacy Foundation" class="h-16 w-auto object-contain">
    </div>

    {{-- Penguin Random House --}}
    <div class="opacity-60 hover:opacity-100 transition-all duration-300 hover:-translate-y-1">
      <img src="{{ asset('images/landing/logo/Penguin Random House New 2024 1.png') }}" alt="Penguin Random House" class="h-12 w-auto object-contain">
    </div>

  </div>
</section>

<section class="py-16 px-5 md:px-8 lg:px-16 bg-white text-center">
  <h2 class="text-2xl md:text-3xl font-extrabold text-navy tracking-tight mb-14">Teknologi Yang Di Gunakan</h2>
  <div class="flex flex-col sm:flex-row items-center justify-center gap-10 md:gap-16">

    {{-- Laravel --}}
    <div class="opacity-80 hover:opacity-100 transition-all duration-300 hover:-translate-y-1">
      <img src="{{ asset('images/landing/logo/bahasa/laravel-logolockup-rgb-red 1.png') }}" alt="Laravel" class="h-12 w-auto object-contain">
    </div>

    {{-- Tailwind CSS --}}
    <div class="opacity-80 hover:opacity-100 transition-all duration-300 hover:-translate-y-1">
      <img src="{{ asset('images/landing/logo/bahasa/tailwindcss-logotype 1.png') }}" alt="Tailwind CSS" class="h-10 w-auto object-contain">
    </div>

  </div>
</section>

<footer id="footer" style="background-color: #E8ECF8;" class="px-5 md:px-8 lg:px-16 pt-14 pb-10">
  <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-10 md:gap-8">

    {{-- Kolom 1: Brand --}}
    <div class="md:col-span-1">
      <div class="flex items-center gap-2 mb-4">
        <img src="{{ asset('images/logo/LogoBlack.png') }}" alt="LibSchool Logo" class="h-7 w-auto object-contain">
        <span class="text-[17px] font-extrabold text-[#3B5BDB]">Libschool</span>
      </div>
      <p class="text-[13.5px] leading-relaxed text-slate-500 max-w-[220px]">
        Digital Library Framework from modern school from indonesia. Empowering literacy throught technology
      </p>
    </div>

    {{-- Kolom 2: Navigasi --}}
    <div>
      <h4 class="text-[14px] font-semibold text-[#3B5BDB] mb-5">Navigasi</h4>
      <ul class="space-y-3 list-none p-0 m-0">
        <li><a href="#" class="text-[13.5px] text-slate-600 hover:text-[#3B5BDB] no-underline transition-colors">Beranda</a></li>
        <li><a href="#fitur" class="text-[13.5px] text-slate-600 hover:text-[#3B5BDB] no-underline transition-colors">Fitur</a></li>
        <li><a href="#layanan" class="text-[13.5px] text-slate-600 hover:text-[#3B5BDB] no-underline transition-colors">Layanan</a></li>
        <li><a href="#about" class="text-[13.5px] text-slate-600 hover:text-[#3B5BDB] no-underline transition-colors">Tentang kami</a></li>
        <li><a href="#contact" class="text-[13.5px] text-slate-600 hover:text-[#3B5BDB] no-underline transition-colors">Hubungi Kami</a></li>
      </ul>
    </div>

    {{-- Kolom 3: Legal --}}
    <div>
      <h4 class="text-[14px] font-semibold text-[#3B5BDB] mb-5">Legal</h4>
      <ul class="space-y-3 list-none p-0 m-0">
        <li><a href="#" class="text-[13.5px] text-slate-600 hover:text-[#3B5BDB] no-underline transition-colors">Privasi</a></li>
        <li><a href="#" class="text-[13.5px] text-slate-600 hover:text-[#3B5BDB] no-underline transition-colors">Syarat &amp; Ketentuan</a></li>
      </ul>
    </div>

    {{-- Kolom 4: Kontak --}}
    <div>
      <h4 class="text-[14px] font-semibold text-[#3B5BDB] mb-5">Kontak</h4>
      <div class="flex flex-col gap-3">

        {{-- Alamat --}}
        <div class="flex items-start gap-3">
          <span class="mt-0.5 flex-shrink-0 text-slate-500">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" fill="#64748b"/>
            </svg>
          </span>
          <p class="text-[13px] leading-relaxed text-slate-500">Jl. Teknologi pendidikan No. 123<br>Jakarta selatan, Indonesia</p>
        </div>

        {{-- Instagram --}}
        <a href="https://instagram.com/libschool.id" target="_blank" rel="noopener noreferrer"
           class="flex items-center gap-3 no-underline group">
          <span class="flex-shrink-0 text-slate-500 group-hover:text-[#E1306C] transition-colors">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect x="2" y="2" width="20" height="20" rx="5" stroke="#64748b" stroke-width="1.8" class="group-hover:stroke-[#E1306C] transition-colors"/>
              <circle cx="12" cy="12" r="4" stroke="#64748b" stroke-width="1.8" class="group-hover:stroke-[#E1306C] transition-colors"/>
              <circle cx="17.5" cy="6.5" r="1" fill="#64748b" class="group-hover:fill-[#E1306C] transition-colors"/>
            </svg>
          </span>
          <span class="text-[13px] text-slate-500 group-hover:text-[#E1306C] transition-colors">@libschool.id</span>
        </a>

        {{-- Email --}}
        <a href="mailto:libschool@gmail.com"
           class="flex items-center gap-3 no-underline group">
          <span class="flex-shrink-0 group-hover:text-[#3B5BDB] transition-colors">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect x="2" y="4" width="20" height="16" rx="2" stroke="#64748b" stroke-width="1.8" class="group-hover:stroke-[#3B5BDB] transition-colors"/>
              <path d="M2 7l10 7 10-7" stroke="#64748b" stroke-width="1.8" stroke-linecap="round" class="group-hover:stroke-[#3B5BDB] transition-colors"/>
            </svg>
          </span>
          <span class="text-[13px] text-slate-500 group-hover:text-[#3B5BDB] transition-colors">libschool@gmail.com</span>
        </a>

        {{-- Twitter / X --}}
        <a href="https://twitter.com/libschool_id" target="_blank" rel="noopener noreferrer"
           class="flex items-center gap-3 no-underline group">
          <span class="flex-shrink-0 group-hover:text-slate-900 transition-colors">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M4 4l16 16M20 4L4 20" stroke="#64748b" stroke-width="2" stroke-linecap="round" class="group-hover:stroke-slate-900 transition-colors"/>
              <rect x="2" y="2" width="20" height="20" rx="4" stroke="#64748b" stroke-width="1.8" class="group-hover:stroke-slate-900 transition-colors"/>
            </svg>
          </span>
          <span class="text-[13px] text-slate-500 group-hover:text-slate-900 transition-colors">libschool_id</span>
        </a>

        {{-- WhatsApp --}}
        <a href="https://wa.me/628231067615" target="_blank" rel="noopener noreferrer"
           class="flex items-center gap-3 no-underline group">
          <span class="flex-shrink-0 group-hover:text-[#25D366] transition-colors">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M20.52 3.48A11.95 11.95 0 0 0 12 0C5.37 0 0 5.37 0 12c0 2.11.55 4.16 1.6 5.97L0 24l6.23-1.57A11.96 11.96 0 0 0 12 24c6.63 0 12-5.37 12-12 0-3.2-1.25-6.21-3.48-8.52zM12 22c-1.85 0-3.66-.5-5.24-1.44l-.38-.22-3.7.93.99-3.59-.24-.38A9.95 9.95 0 0 1 2 12C2 6.48 6.48 2 12 2c2.66 0 5.16 1.04 7.04 2.92A9.93 9.93 0 0 1 22 12c0 5.52-4.48 10-10 10zm5.47-7.38c-.3-.15-1.77-.87-2.05-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.95 1.17-.17.2-.35.22-.65.07-.3-.15-1.27-.47-2.42-1.5-.9-.8-1.5-1.79-1.68-2.09-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51-.17-.01-.37-.01-.57-.01-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.22 3.08c.15.2 2.1 3.2 5.1 4.49.71.31 1.27.49 1.7.63.72.23 1.37.2 1.88.12.57-.09 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.35z" fill="#64748b" class="group-hover:fill-[#25D366] transition-colors"/>
            </svg>
          </span>
          <span class="text-[13px] text-slate-500 group-hover:text-[#25D366] transition-colors">+62 823–1067–6151</span>
        </a>

      </div>
    </div>

  </div>

  {{-- Divider --}}
  <div class="max-w-6xl mx-auto mt-10 pt-6 border-t border-slate-200/80 text-center">
    <p class="text-[13px] text-slate-500">© 2026 LibSchool. All rights reserved.</p>
  </div>
</footer>

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

  // Scrollspy Navigation Logic
  document.addEventListener('DOMContentLoaded', () => {
    // Definisi ID tiap section yang ingin di track
    const sections = ['home', 'fitur', 'how-to', 'layanan', 'about', 'team', 'contact'].map(id => document.getElementById(id)).filter(Boolean);
    const navLinksDesktop = document.querySelectorAll('nav ul a[href^="#"]');
    const navLinksMobile = document.querySelectorAll('#mobileMenu a[href^="#"]');

    function onScroll() {
      let currentSectionId = 'home';
      const scrollY = window.pageYOffset;

      sections.forEach(section => {
        const sectionTop = section.offsetTop - 150; // Deteksi lebih awal saat scroll
        const sectionHeight = section.offsetHeight;
        if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
          currentSectionId = section.id;
        }
      });

      // Kondisi untuk section paling bawah agar pasti terpilih
      if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight - 50) {
         currentSectionId = 'contact';
      }

      // Update Class Desktop Links
      navLinksDesktop.forEach(link => {
        const href = link.getAttribute('href').substring(1);
        if (['home', 'fitur', 'layanan', 'about', 'contact'].includes(href)) {
            const isActive = (href === currentSectionId) || (href === 'about' && currentSectionId === 'team') || (href === 'fitur' && currentSectionId === 'how-to');
            if(isActive) {
                link.classList.remove('text-slate-700', 'font-medium');
                link.classList.add('text-blue', 'font-semibold');
            } else {
                link.classList.remove('text-blue', 'font-semibold');
                link.classList.add('text-slate-700', 'font-medium');
            }
        }
      });

      // Update Class Mobile Links
      navLinksMobile.forEach(link => {
        const href = link.getAttribute('href').substring(1);
        if (['home', 'fitur', 'layanan', 'about', 'contact'].includes(href)) {
            const isActive = (href === currentSectionId) || (href === 'about' && currentSectionId === 'team') || (href === 'fitur' && currentSectionId === 'how-to');
            if(isActive) {
                link.classList.remove('text-slate-800');
                link.classList.add('text-blue');
            } else {
                link.classList.remove('text-blue');
                link.classList.add('text-slate-800');
            }
        }
      });
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll(); // Set active link pertama kali diload
  });
</script>
</body>
</html>