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
          float: {
            '0%, 100%': { transform: 'translateY(0px) rotate(-3deg)' },
            '50%': { transform: 'translateY(-12px) rotate(-3deg)' },
          },
          fadeUp: {
            'from': { opacity: '0', transform: 'translateY(30px)' },
            'to': { opacity: '1', transform: 'translateY(0)' },
          },
        },
        animation: {
          float: 'float 5s ease-in-out infinite',
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
  .hero-before::before {
    content: '';
    position: absolute; top: -120px; right: -120px;
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(59,130,246,0.15), transparent 70%);
    border-radius: 50%;
    pointer-events: none;
  }
</style>
</head>
<body class="bg-white text-slate-800 overflow-x-hidden">

<!-- ═══ NAVBAR ═══ -->
<nav class="sticky top-0 z-50 flex items-center justify-between px-5 md:px-8 lg:px-16 h-16 bg-white/90 backdrop-blur-md border-b border-slate-200">
  <div class="flex items-center gap-2">
    <img src="{{ asset('images/logo/LogoBlack.png') }}" alt="LibSchool Logo" class="h-9 w-auto object-contain">
  </div>

  <ul class="hidden md:flex gap-8 list-none">
    <li><a href="#" class="text-sm font-semibold text-blue no-underline">Beranda</a></li>
    <li><a href="#fitur" class="text-sm font-medium text-slate-500 hover:text-blue no-underline transition-colors">Fitur</a></li>
    <li><a href="#layanan" class="text-sm font-medium text-slate-500 hover:text-blue no-underline transition-colors">Layanan</a></li>
    <li><a href="#team" class="text-sm font-medium text-slate-500 hover:text-blue no-underline transition-colors">Tentang Kami</a></li>
  </ul>

  <!-- ✅ Login Button Desktop — sudah diarahkan ke route login -->
  <a href="{{ route('login') }}" class="hidden md:block px-6 py-2 rounded-lg bg-blue text-white text-sm font-semibold hover:bg-blue-dark transition-colors no-underline">Login</a>

  <button id="hamburger" class="hamburger md:hidden flex flex-col justify-center gap-[5px] p-1.5 bg-transparent border-none cursor-pointer" aria-label="Menu">
    <span class="block w-6 h-0.5 bg-navy rounded transition-all duration-300"></span>
    <span class="block w-6 h-0.5 bg-navy rounded transition-all duration-300"></span>
    <span class="block w-6 h-0.5 bg-navy rounded transition-all duration-300"></span>
  </button>
</nav>

<!-- MOBILE MENU -->
<div id="mobileMenu" class="hidden fixed top-16 left-0 right-0 z-40 bg-white border-b border-slate-200 shadow-lg px-6 py-4 flex-col">
  <a href="#" onclick="closeMenu()" class="py-3 text-[15px] font-semibold text-slate-800 border-b border-slate-100 hover:text-blue no-underline transition-colors">Beranda</a>
  <a href="#fitur" onclick="closeMenu()" class="py-3 text-[15px] font-semibold text-slate-800 border-b border-slate-100 hover:text-blue no-underline transition-colors">Fitur</a>
  <a href="#layanan" onclick="closeMenu()" class="py-3 text-[15px] font-semibold text-slate-800 border-b border-slate-100 hover:text-blue no-underline transition-colors">Layanan</a>
  <a href="#team" onclick="closeMenu()" class="py-3 text-[15px] font-semibold text-slate-800 hover:text-blue no-underline transition-colors">Tentang Kami</a>
  <!-- ✅ Login Button Mobile — sudah diarahkan ke route login -->
  <a href="{{ route('login') }}" class="mt-3 w-full py-3 rounded-xl bg-blue text-white text-[15px] font-bold text-center no-underline block">Login</a>
</div>

<!-- ═══ HERO ═══ -->
<section class="hero-before relative overflow-hidden grid grid-cols-1 md:grid-cols-2 items-center gap-8 md:gap-10 px-5 md:px-8 lg:px-16 py-12 md:py-20 bg-gradient-to-br from-blue-50 via-blue-100 to-blue-50 min-h-[auto] md:min-h-[580px]">
  <div class="animate-fadeUp text-center md:text-left">
    <div class="inline-flex items-center gap-2 bg-white border border-slate-200 rounded-full px-4 py-1.5 text-xs font-semibold text-blue mb-6">
      📚 Platform Perpustakaan Digital
    </div>
    <h1 class="text-[clamp(28px,5vw,54px)] font-extrabold leading-tight tracking-tight text-navy mb-4">
      Cari dan ulas <span class="font-serif-italic text-blue">buku favorite</span> Anda dengan mudah
    </h1>
    <p class="text-[15px] leading-relaxed text-slate-500 max-w-md mx-auto md:mx-0 mb-8">
      Pelajari pelajaran apa saja yang paling penting! Anda ada di tempat yang tepat dengan semua pelajaran belajar rekomendasi terbaik. Menemukan serta hambatan dan mencari solusi di mana Anda bisa dengan mudah menemukan buku-buku favorit Anda.
    </p>
    <a href="#fitur" class="inline-flex items-center gap-2 bg-blue text-white px-7 py-3.5 rounded-xl text-sm font-bold hover:bg-blue-dark hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(37,99,235,.3)] transition-all no-underline">
      Mulai sekarang
      <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M8 0L6.59 1.41 12.17 7H0v2h12.17l-5.58 5.59L8 16l8-8-8-8z"/></svg>
    </a>
  </div>

  <div class="animate-fadeUpDelay flex justify-center items-center h-64 md:h-[500px] relative">
    <!-- Background Image -->
    <img src="{{ asset('images/landing/CoverLanding.png') }}" alt="Cover Background" class="absolute opacity-90">
    <!-- Book Cards -->
    <div class="animate-float grid grid-cols-2 gap-4 rotate-[-3deg] relative z-10">
      <div class="w-[90px] h-[130px] md:w-[130px] md:h-[190px] bg-gradient-to-br from-yellow-100 to-yellow-300 rounded-2xl shadow-xl flex items-center justify-center translate-y-5">
        <p class="text-center text-[9px] md:text-[11px] font-bold text-navy px-2">Talking to Strangers</p>
      </div>
      <div class="w-[90px] h-[130px] md:w-[130px] md:h-[190px] bg-gradient-to-br from-blue-100 to-blue-300 rounded-2xl shadow-xl flex items-center justify-center">
        <p class="text-center text-[9px] md:text-[11px] font-bold text-navy px-2">Sepotong Hati</p>
      </div>
      <div class="w-[90px] h-[130px] md:w-[130px] md:h-[190px] bg-gradient-to-br from-emerald-100 to-emerald-300 rounded-2xl shadow-xl flex items-center justify-center">
        <p class="text-center text-[9px] md:text-[11px] font-bold text-navy px-2">The Visual MBA</p>
      </div>
      <div class="w-[90px] h-[130px] md:w-[130px] md:h-[190px] bg-gradient-to-br from-pink-100 to-pink-300 rounded-2xl shadow-xl flex items-center justify-center -translate-y-2.5">
        <p class="text-center text-[9px] md:text-[11px] font-bold text-navy px-2">Buku Populer</p>
      </div>
    </div>
  </div>
</section>

<!-- ═══ FITUR ═══ -->
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

 <!-- Services Section -->
    <section id="layanan" class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="mb-12">
                <p class="text-primary font-semibold mb-2">Layanan</p>
                <h2 class="text-3xl font-bold text-gray-900">
                    🚀 • Layanan untukmu
                </h2>
            </div>

            <!-- Service 1 -->
            <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
                <div>
                    <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?w=800&h=600&fit=crop" alt="Library" class="rounded-xl shadow-2xl">
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        <span class="text-primary">Pinjam</span> buku favoritmu langsung dari <span class="text-primary">LibSkool!</span>
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        Pinjam, nikmati, dan kembalikan buku dengan mudah! Dengan Libskhool, kamu dapat meminjam berbagai koleksi buku favorit secara digital maupun fisik. Sistem peminjaman yang mudah dan transparan memastikan kamu tidak akan kehilangan jejak buku yang dipinjam. Proses pengembalian juga sangat sederhana - cukup scan barcode atau konfirmasi secara online. Libskhool memudahkan perjalanan literasimu dengan layanan yang fleksibel dan user-friendly.
                    </p>
                </div>
            </div>

            <!-- Service 2 -->
            <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
                <div class="order-2 md:order-1">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                        Sewa Buku Cepat:<br>
                        Langsung <span class="text-primary">Aktivitas Membaca</span>
                    </h3>
                    <p class="text-gray-600 leading-relaxed">
                        Pengen baca buku tapi gak mau beli? Sewa aja! Libskhool menyediakan layanan sewa buku dengan harga terjangkau. Pilih buku yang kamu inginkan, tentukan durasi sewa, dan mulai membaca! Sistem sewa yang fleksibel memungkinkan kamu untuk menikmati berbagai buku tanpa harus mengeluarkan biaya pembelian penuh. Cocok untuk pelajar, mahasiswa, atau siapa saja yang suka eksplorasi buku baru.
                    </p>
                </div>
                <div class="order-1 md:order-2">
                    <img src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=800&h=600&fit=crop" alt="Reading" class="rounded-xl shadow-2xl">
                </div>
            </div>

            <!-- Service 3 -->
            <div class="mb-12">
                <p class="text-primary font-semibold mb-2">Terbaru kini!</p>
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
                        Akses <span class="text-primary">Mudah, Cepat, dan Efisien!</span>
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

<!-- ═══ ABOUT ═══ -->
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

    <!-- Team Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">
                    Tim Propesional Pembuatan <span class="text-primary">Libschool.</span>
                </h2>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-2xl transition">
                    <img src="public/images/landing/profildev/Ridwan.jpeg" alt="Muhammad Ridwan Hawari" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
                    <h3 class="font-bold text-gray-900 mb-1">Muhammad Ridwan Hawari</h3>
                    <p class="text-primary font-semibold mb-2">CEO</p>
                    <p class="text-gray-600 text-sm">hief Technology Officer </p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-2xl transition">
                    <img src="public/images/landing/profildev/Riski.png" alt="Riski Satria" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
                    <h3 class="font-bold text-gray-900 mb-1">Riski Satria</h3>
                    <p class="text-primary font-semibold mb-2">BE</p>
                    <p class="text-gray-600 text-sm">Back End Developer</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-2xl transition">
                    <img src="public/images/landing/profildev/Dzikri.jpeg" alt="Muhammad Dzikri" class="w-24 h-24 rounded-full mx-auto mb-4 object-cover">
                    <h3 class="font-bold text-gray-900 mb-1">Muhammad Dzikri</h3>
                    <p class="text-primary font-semibold mb-2">UI/UX & FE</p>
                    <p class="text-gray-600 text-sm">UI/UX & Front End Developerr</p>
                </div>
            </div>
        </div>
    </section>

<!-- ═══ TRUSTED ═══ -->
<section class="py-16 px-5 md:px-8 lg:px-16 bg-slate-50 text-center">
  <h2 class="text-2xl md:text-3xl font-extrabold text-navy tracking-tight mb-12">Dipercaya oleh Institusi Terkemuka.</h2>
  <div class="flex flex-wrap items-center justify-center gap-10 md:gap-14">
    <div class="opacity-60 hover:opacity-100 transition-opacity flex items-center gap-2 text-sm font-bold text-navy">⭐ INSTITUTION LOCAL</div>
    <div class="opacity-60 hover:opacity-100 transition-opacity text-2xl font-black text-navy">Gramedia</div>
    <div class="opacity-60 hover:opacity-100 transition-opacity text-xs font-bold text-navy text-center leading-tight">WORLD<br>FOUNDATION</div>
    <div class="opacity-60 hover:opacity-100 transition-opacity text-sm font-extrabold text-navy leading-snug">🐧 Penguin<br>Random House</div>
  </div>
</section>

<!-- ═══ TEKNOLOGI ═══ -->
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

<!-- ═══ FOOTER ═══ -->
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
    <p class="text-base font-bold text-white">#KeepUpOnPrettyJavav</p>
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
    const isOpen = mobileMenu.classList.toggle('hidden');
    mobileMenu.style.display = isOpen ? 'none' : 'flex';
    mobileMenu.style.flexDirection = 'column';
  });

  function closeMenu() {
    hamburger.classList.remove('open');
    mobileMenu.classList.add('hidden');
    mobileMenu.style.display = 'none';
  }
</script>
</body>
</html>