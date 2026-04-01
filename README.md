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

## Fitur-fitur Lengkap Aplikasi

Aplikasi LibSchool membagi rentetan fiturnya menjadi 3 pilar jenis pengguna (Admin, Petugas, dan Siswa). Berikut adalah penjelasan santai dan mudah dipahami untuk semua fitur yang ada:

### 1. 🌐 Fitur Umum & Keamanan
*   **Login & Register Mudah**: Pengguna bisa login dengan aman, siswa baru bisa mendaftar akun sekolah secara mandiri, dan ada fitur *Reset Password* via email kalau sewaktu-waktu lupa sandi.
*   **Pendeteksi Login Otomatis**: Jika pengguna sudah pernah masuk (*login*) sebelumnya, ketika membuka website akan langsung diarahkan masuk ke dasbornya masing-masing tanpa harus login ulang, sangat efisien.
*   **Pembatasan Akses (Aman dari Orang Iseng)**: Fitur keamanan kuat yang mencegah siswa menyusup ke halaman Admin, begitupun sebaliknya. Setiap orang hanya bisa melihat halaman yang memang sesuai porsinya.

### 2. 👨‍🎓 Fitur Khusus Siswa
*   **Dasbor Pintar**: Tampilan beranda yang langsung ngasih tahu siswa info penting, seperti "Berapa buku yang sedang saya pinjam?" dan "Berapa hari lagi harus dikembalikan?". Sistem juga otomatis memantau hitungan denda telat secara langsung!
*   **Katalog Buku Seru**: Tempat siswa bebas mencari dan melihat koleksi buku. Ada fitur filter canggih buat nemuin buku yang persis sedang dicari.
*   **Berbagi Ulasan**: Selesai baca? Siswa bisa memberi bintang (*rating*) dan menulis komentar pendapat tentang buku tersebut, agar teman lain termotivasi membacanya.
*   **Booking Buku dari Rumah**: Punya buku incaran tapi takut dipinjam teman lain? Booking saja lewat HP dari rumah, lalu ambil aman ke perpustakaan sekolah.
*   **Rak Favorit Kita**: Kalau lagi naksir buku tapi tidak sempat pinjam hari ini, tinggal tandai masuk ke rak "*Favorite*" supaya gampang dicari besok lagi.
*   **Riwayat Bacaan Personal**: Menampilkan jejak rekam buku apa saja yang pernah sukses dipinjam sampai dikembalikan, hingga nota pelunasan denda juga tercatat abadi.
*   **Ubah Kartu Tanda Anggota**: Siswa bisa ganti foto pas *Avatar* sendiri dan bahkan mencetak visual grafis "Kartu Anggota Elektronik"-nya.
*   **Chat Pelayanan (Helpdesk)**: Enggan mendatangi staf perpus untuk komplain pelayanan? Siswa tinggal menulis pesan (*chat*) laporan melalui pusat pengaduan.

### 3. 👨‍💼 Fitur Khusus Petugas Perpustakaan
*   **Persetujuan Pinjam Buku (Klik Tombol)**: Tempat petugas memeriksa kode booking dari anak-anak (Contoh: `BK-001`). Setelah anak mengambil fisik bukunya di meja perpus, petugas tinggal tekan "Konfirmasi" dan sah sudah dipinjam!
*   **Kasir Denda Berjalan**: Disaat mendata anak yang mengembalikan buku melewati hari batas waktu (*deadline*), sistem yang akan memikirkan hitungan denda dan seketika langsung menghardik muncul di hadapan layar petugas otomatis.
*   **Catatan Aktivitas Staf Harian**: Rangkuman arus buku apa saja di luar rak, dan ada berapa buku yang tersimpan siang itu.
*   **Buka Surat Keluhan (Inbox)**: Menerima, membaca, dan menyelesaikan laporan pertolongan yang masuk dari aplikasi si anak.

### 4. 👑 Fitur Pemilik Toko (Administrator)
*   **Pantauan Semesta (Dasbor)**: Seluruh gerak operasional perpustakaan tergambar rapi lewat statistik jumlah di layar ini.
*   **Kekuasaan Mutlak Pengguna**: Admin memegang kendali menambah petugas baru tanpa batas, membekukan/memecat akun yang jelek, mengganti isi bio info orang lain, atau merubah sandi orang yang susah masuk.
*   **Kunci Pintu (Validasi Member Baru)**: Fitur ampuh menghindari siswa bodong masuk. Setiap pendaftar baru tidak bisa main pesan (*Booking*) buku tanpa verifikasi status "Boleh Pinjam" dari jari Sang Admin di layar validasi. Bot palsu tidak akan bisa hidup disini.
*   **Sulap Kekuatan Peran**: Hanya butuh 1 klik admin untuk merendahkan staf penjaga menjadi peran anak siswa standar, kejam dan dinamis.

**Akses Fitur Kolaborasi Pekerjaan (Bisa Dilakukan Admin + Petugas)**:
*   **Mengisi Rak Buku Utama**: Kegiatan merapikan laci-laci etalase dari nama judul buku, menyusun buku fiksi berseri, dan membagi rak Kategori A / B.
*   **Verifikasi Tutup Denda Hutang**: Menekan sah pelunasan tagihan anak yang membawa uang koin denda dan memastikan rekamnya terganti menjadi "Lunas".
*   **Sulap Dokumen Laporan**: Cukup sentuh cetak, triliunan mili catatan historis orang yang lalang pinjam di sulap rekayasa sistem berubah menjadi Kertas elektronik PDF (Buku Laporan Penjaga).

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
