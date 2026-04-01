# LibSchool - Sistem Informasi Manajemen Perpustakaan Sekolah

LibSchool adalah sistem informasi manajemen perpustakaan modern berbasis web. Dibangun dengan framework Laravel 12 dan antarmuka dinamis Tailwind CSS, platform ini dirancang khusus untuk memenuhi standar profesional dalam mengelola sirkulasi buku, administrasi rak dan kategori, manajemen denda, hingga integrasi rekam jejak setiap anggota sekolah dalam satu ruang lingkup terpusat.

## Tinjauan Antarmuka dan Fitur Utama

Sistem ini mensyaratkan tiga jenis hak akses untuk menjaga privasi data dan melancarkan alur operasional. Berikut adalah ringkasan fitur utama yang dilengkapi dengan visualisasi antarmuka:

### 1. Halaman Beranda (Landing Page)
<img src="public/images/readme.md image/landing-page.png" alt="Landing Page" width="100%">
**Deskripsi:** Antarmuka awal yang dioptimalkan untuk menyambut pengunjung dengan tampilan elegan dan responsif pada berbagai perangkat layar.
**Keunggulan:** Desain modern, struktur navigasi yang jelas, dan pemuatan elemen cepat. Pengunjung dapat langsung memperoleh gambaran singkat mengenai fasilitas sirkulasi perpustakaan sebelum masuk ke sistem.

### 2. Dashboard Administrator
<img src="public/images/readme.md image/dashboard-admin.png" alt="Dashboard Administrator" width="100%">
**Deskripsi:** Pusat kendali tingkat tertinggi yang diperuntukkan bagi manajer perpustakaan atau staf teknologi informasi sekolah.
**Keunggulan:** Menyediakan kontrol penuh dan visualisasi data statistik yang komprehensif. Admin dapat mengelola persetujuan KYC siswa (verifikasi anggota), manajemen inventaris buku secara terperinci, mengekspor laporan kinerja ke format PDF menggunakan DomPDF, serta mengelola akses seluruh staf dan member.

### 3. Dashboard Petugas Perpustakaan
<img src="public/images/readme.md image/dashboard-petugas.png" alt="Dashboard Petugas Perpustakaan" width="100%">
**Deskripsi:** Ruang kerja khusus untuk pustakawan dalam menangani urusan operasional sirkulasi fisik perpustakaan dari hari ke hari.
**Keunggulan:** Menyajikan tabel informasi real-time mengenai permintaan peminjaman dan jadwal pengembalian. Petugas dipermudah dengan automasi sistem kalkulasi denda keterlambatan baku, serta pencatatan sirkulasi pergerakan inventaris yang transparan dan akurat.

### 4. Dashboard Siswa (Member)
<img src="public/images/readme.md image/dashboard-siswa.png" alt="Dashboard Siswa" width="100%">
**Deskripsi:** Portal interaktif mandiri yang dikhususkan bagi siswa (anggota aktif) untuk berpartisipasi dalam program literasi perpustakaan.
**Keunggulan:** Menawarkan fitur penelusuran katalog cerdas. Siswa dapat melakukan pengecekan ketersediaan stok buku, mengajukan proses pemesanan (booking) sirkulasi dari jauh secara mandiri, melacak rekam jejak denda dan detail riwayat peminjaman mereka, serta menyimpan literatur favorit.

---

## Rincian Ekosistem Fitur Sistem

Secara teknis, platform web LibSchool mengkategorisasikan otorisasi fiturnya secara hierarki ke dalam tiga tingkatan jenis pilar pengguna:

### 1. 🌐 Fungsionalitas Umum
*   **Keamanan Autentikasi Berlapis**: Mulai dari integrasi Login sandi terenkripsi, pendaftaran Registrasi independen (khusus siswa baru), hingga penanganan aman "*Lupa Kata Sandi*" melalui email (SMTP).
*   **Halaman Beranda (Landing Page) Pintar**: Front-end pertama kali yang secara pintar bisa mendeteksi jika peramban komputer klien memiliki sesi *login* yang sedang aktif dan mengalihkan mereka menembus ke dasbornya secara seketika.
*   **Proteksi Middleware Role**: Menolak keras pengguna yang "nakal" untuk mengakses dasbor antar-peran (Skeptis secara baku).

### 2. 👨‍🎓 Penjelajah Siswa (Anggota Reguler)
*   **Dasbor Kalkulator Pintar**: Menyajikan matrik visual tentang jumlah koleksi bacaan di saku pengguna hingga ke kemampuan sistem menghitung pergerakan denda harian secara *real-time* yang dibebankan kepada siswa telat mengembalikan buku.
*   **Eksplorasi Katalog Buku Pintar**: Mesin jelajah digital estetik dengan filterisasi. Menyediakan pandangan halaman buku lengkap lewat ringkasan pustakawan.
*   **Ulasan Kepuasan (Review)**: Modul untuk memupuk literasi berkelompok yang mengizinkan siswa berpendapat, merating, dan memberikan kritik/saran mengenai kepuasan baca terhadap buku tertentu.
*   **Booking Pintar Online**: Sistem reservasi / "*hold*" buku terdigitalisasi, agar buku impian siswa aman dari rebutan pelajar lain sembari siswa berangkat menuju bangunan perpustakaan di sekolah.
*   **Manajemen Koleksi (Wishlist) Pribadi**: Fasilitas me-#tag "*Favorite*" buku yang ingin dibaca esok hari untuk disimpan di pustaka favorit internal akun.
*   **Histori Transaksi Absolut**: Pengarsipan masa pendaftaran pesanan (`BK-***`), pelunasan pinalti digital mandiri, sampai *deadline* jatuh tempo pengembalian.
*   **Manajemen Custom Identitas & Kartu Visual**: Upload Avatar sesuka hati dan ekspor identitas sebagai format grafis "Kartu Tanda Anggota" elektronik.
*   **Pusat Pengajuan Bantuan (Helpdesk)**: Formulir pengaduan perihal pesanan meleset hingga mengirim sinyal keluhan (*ticket chat*) personal kepada staff yang bertugas tanpa butuh berhadapan langsung.

### 3. 👨‍💼 Staf Penjaga (Operasional Pustakawan Frontliner)
*   **Konfirmasi Peminjaman (Booking Validator)**: Halaman dinamis memanggil kode pemesanan siswa untuk secara syah mengkonversikan status buku yang menempel/booking ke status hukum peminjaman aktif.
*   **Integrasi Pengembalian Buku Otomatis**: Layar mesin pemeriksa penyetoran kembali barang inventaris. Apabila kalender melewati hari *deadline*, ia akan serempak menyambar memunculkan beban pinalti harga denda tepat di layar petugas.
*   **Rekap Log Riwayat Harian**: Lacak *flow* arus masuk keluar inventaris komoditi.
*   **Manajemen Pesan Kotak Masuk (Inbox)**: Merespons, memperbaharui progres validitas pesanan dan membelas rentetan *ticket* yang digulirkan dari pengguna/siswa tanpa perlu membuka aplikasi surel luar.

### 4. 👑 Administrator Jaringan (Super User)
*   **Kendali Operasional Pengguna (CRUD)**: Punya alat komplit untuk melahirkan pengguna abdi baru, membekukan/mem-Banned pihak nakal, mendisiplinkan para sandi yang terpejam hingga mengubah nasib otoritas pangkat bawahan.
*   **Verifikasi KYC Anti-Bot (Aktifasi Validitas Peminjam Dasar)**: Sistem penyaringan pintu untuk siswa murid mendaftar bebas. Tidak peduli seberapa gencar murid memesan buku, mereka *freeze* tanpa pesetujuan aktivasi centang dari Sang Admin tingkat atas.

**Kewenangan Gabungan / Hak Akses Tersanding (Admin & Penjaga)**:
*   **Data Induk Utama**: Modul manajemen pengayaan pustaka (Buku, Kategori Spesifik, Series Labeling).
*   **Pusat Penarikan Denda**: Validator "Kasir" untuk meregistrasi bahwa denda lunas ke dalam neraca pendapatan atau tetap menjadi rekor tagihan (hutang tak tertagih).
*   **Pencari Bukti Elektronik Laporan**: Mesin kalkulasi tarikan *record SQL* transaksi besar-besaran untuk dirangkai ulang ke wujud rapi tabel laporan manajerial dan *export* menjadi arsip PDF.

---

## Spesifikasi Teknis

Platform LibSchool dikembangkan di atas arsitektur peranti lunak terkini guna memastikan keamanan, performa tinggi, serta kemudahan proses uji coba (development):

*   **Pondasi Backend:** Laravel 12 (Membutuhkan PHP versi ^8.2)
*   **Akses Basis Data:** Konfigurasi standar mesin MySQL atau MariaDB
*   **Perancangan Frontend:** Kombinasi Laravel Blade Templating Engine dan Alpine.js
*   **Kerangka Gaya (Styling):** Tailwind CSS v3 murni
*   **Pemoles Aset (Bundler):** Vite v6 terintegrasi (laravel-vite-plugin)
*   **Infrastruktur Autentikasi:** Laravel Breeze v2 (Menggunakan session guard otentikasi konvensional)
*   **Sistem Ekspor Dokumen:** barryvdh/laravel-dompdf (Generasi laporan analitik format PDF)

## Panduan Instalasi Lokal

Langkah-langkah berikut akan membantu tahapan penyetelan (setup) awal bagi pengembang untuk menjalankan aplikasi LibSchool di lingkungan server mesin komputer lokal (seperti sistem XAMPP, Laragon, atau Herd). Pastikan Composer dan NodeJS telah terpasang dengan versi spesifikasi di atas.

**1. Kloning Repositori**
Unduh keseluruhan berkas kode sumber dari repositori ke dalam memori komputer dan masuk ke direktori proyek.
```bash
git clone <url-repositori>
cd LIBSCHOOL
```

**2. Instalasi Dependensi Pihak Ketiga**
Pasang pustaka bawaan framework PHP dan susun ekstensi modul node (Javascript) aplikasi.
```bash
composer install
npm install
```

**3. Konfigurasi Lingkungan Server**
Gandakan berkas contoh konfigurasi *environment* dan hasilkan token kunci aplikasi.
```bash
cp .env.example .env
php artisan key:generate
```
*(Catatan: Konfigurasi pengaturan koneksi database Anda di bagian `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di dalam berkas `.env` sebelum ke tahap selanjutnya)*

**4. Migrasi Skema dan Pembenihan Data**
Eksekusi struktur tabel rancangan sistem sekaligus memasukkan pangkalan data pengujian awalan (dummy data).
```bash
php artisan migrate:fresh --seed
```

**5. Pembuatan Tautan Direktori Berkas Publik**
Untuk menjamin gambar pratinjau buku dan aset file lainnya dapat diakses pada ranah publik sistem antarmuka web.
```bash
php artisan storage:link
```

**6. Menjalankan Server Publik**
Buka dua terminal terpisah pada lingkungan direktori yang sama dan operasikan kedua mesin pelayan berikut ini:

Terminal Pertama (Menjalankan pelayan pengujian backend Laravel):
```bash
php artisan serve
```

Terminal Kedua (Menjalankan proses pemantauan aset gaya (CSS/JS) web interaktif menggunakan Vite):
```bash
npm run dev
```

Akses sistem di peramban web melalui pranala: `http://localhost:8000`.
