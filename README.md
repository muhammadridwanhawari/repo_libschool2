# LibSchool - Sistem Informasi Manajemen Perpustakaan Sekolah

**LibSchool** adalah sebuah sistem informasi manajemen perpustakaan modern berbasis web yang dikembangkan menggunakan ekosistem **Laravel 11** dan dipoles antarmukanya menggunakan **Tailwind CSS**. Sistem ini dirancang secara khusus untuk mempermudah proses sirkulasi peminjaman buku, manajemen inventaris pustaka, pengelolaan operasional sanksi denda, hingga integrasi rekam jejak (*history*) anggota sekolah dalam satu ruang lingkup profesional.

## 🌟 Fitur Utama & Multi-Role (Tiga Hak Akses)

Aplikasi dipisah menjadi 3 pintu gerbang utama untuk membatasi privasi data:

### 1. Admin (Administrator Senior)
Berfungsi sebagai pusat manajemen pengaturan dengan kuasa kontrol penuh atas aplikasi web ini.
- **Kelola Data Induk Pustaka**: Mulai dari integrasi rak Kategori Buku, pembagian _Series_ (Seri) Buku secara linear, hingga pencatatan kuantitas sirkulasi stok.
- **Kelola Daftar Pengguna**: Eksekusi tambah, ubah kata sandi rahasia, dan blokir/hapus akses untuk setiap Penjaga maupun Siswa.
- **Verifikasi Anggota (KYC Internal)**: Layar pemvalidasi pendaftaran baru. Siswa tidak akan diizinkan *booking* peminjaman hingga akun tervalidasi oleh Admin.
- **Manajemen Global Otoritas**: Mengontrol rekam jejak pembayaran denda masuk, mengaudit daftar pinjaman buku mandek, dan mengubah batasan otorisasi sistem.
- **Export Laporan (Reporting)**: Tarik dan *download* rekapitulasi data krusial secara berkala.

### 2. Penjaga (Pustakawan Front-End)
Berfungsi sebagai ujung tombak pelaksana operasional harian fisik perpustakaan.
- **Peminjaman Buku Instan**: Posisi Penjaga perpustakaan untuk mengeksekusi pinjaman serta menyerahkan objek buku fisik berdasar pengajuan *booking* daring otomatis dari ranah siswa.
- **Pengembalian Otomatis**: Layar untuk mengonfirmasi dan meregristrasikan sistem pengembalian buku tepat jadwal, atau mengeksekusi perhitungan penagihan denda keterlambatan secara matematis (Otomasi sistem per-hari telat).
- **Manajemen Inbox Pengajuan**: Berinteraksi merepons korespondensi surat dan dokumen permintaan akses sirkulasi.

### 3. Siswa (Member Regular)
Berfungsi sebagai pengunjung loyal penikmat literasi sekolah, dapat mengakses sistem via gawai genggam/telepon seluler.
- **Katalog Buku Interaktif**: Mesin perpustakaan mutakhir agar siswa bisa dengan elegan mencari literatur bacaan, merangkai filter *series*/kategori, melihat ulasan deskripsi lengkap, serta menciptakan perpustakaan pribadi menggunakan fitur simpan *Favorite*.
- **Booking Mandiri Real-Time**: Ajukan pinjaman melalui perangkat kapanpun dan biarkan Pustakawan memproses dokumen reservasi Anda sebelum menjemput koleksinya di gedung sekolah.
- **Monitor Riwayat Akun Transparan**: Tampilan layar interaktif khusus guna mengeksplor histori tagihan terlambat bayar, rekap log pinjaman sukses/balik gudang, serta penampil tenggat batas (Deadline) peminjaman.
- **Kustomisasi Profil Mandiri**: Fleksibilitas unggah Avatar *profil* baru dan mutasi kunci kata sandi akun dengan desain antarmuka modern yang estetik.

## 🛠️ Modul Teknologi

*   **Core / Backend Framework**: Laravel 11.x (PHP 8.2+)
*   **Database Management**: Relational Database menggunakan MySQL / MariaDB
*   **Frontend UI Ecosystem**: Blade Templating Engine 
*   **Struktur Visual Rendering**: Tailwind CSS v3 / Vanilla CSS modern (Responsive - Web Mobile Friendly)
*   **Infrastruktur Autentikasi**: Laravel Session Guards & Standard Role-Based Middleware 

## 🚀 Panduan Ringkas Pemasangan Standar (Development)

Pastikan lingkungan server lokal (seperti XAMPP, Laragon, Valet) dan perangkat Composer serta NodeJS telah beroperasi mulus di atas mesin komputer Anda. 

1. **Pengunduhan Repositori Source Code Penuh**
   ```bash
   git clone <link-repositori-anda>
   cd LIBSCHOOL
   ```
2. **Memulihkan Kumpulan Paket Fundamental**
   ```bash
   # Merangkul *Vendor* PHP
   composer install
   
   # Merangkul Konstruksi *Node Modules* untuk desain Web Tailwind
   npm install
   ```
3. **Menggandakan Parameter Lingkungan Otomatis**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   > Jangan lupa, tautkan dan edit variabel `DB_DATABASE=libschool` ke database kosong Anda!
4. **Instalasi Skema dan Isi (Seeder) Database Awal**
   ```bash
   php artisan migrate:fresh --seed
   ```
5. **Memautkan Ekosistem Aset Gambar Publik**
   Guna memastikan gambar logo buku, pratinjau PDF, dan cover Siswa tidak pecah pada tatap muka aplikasi:
   ```bash
   php artisan storage:link
   ```
6. **Pembangkitan Dua Terminal *Dual Engine* Lokal (Running Platform)**
   Buka *Command Prompt / Bash Terminal*, sediakan menjadi dua halaman layar dan ketik rutinitas komando ini secara masing-masing:
   ```bash
   # Terminal Pertama (Jantung Back-end Laravel Node Lokal Server)
   php artisan serve

   # Terminal Kedua (Kompilator Aset HMR Vite Tailwind CSS)
   npm run dev
   ```

🎉 Platform Administrasi Pustaka siap dimainkan lewat peramban web (*browser*) dengan menyentuh rute: `http://localhost:8000`. 

## 🔒 Standar Kebersihan Rancang-Bangun Sistem

Bahan baku konstruksi dari baris sumber LIBSCHOOL disajikan berdasar paradigma **Clean Code Principles**, yang meliputi pemisahan fungsional via ekosistem berlapis (Middlewares, Controllers, Models, Routes) sembari tetap menyandarkan fleksibel UI dan kompatibilitas peramban telepon melalui implementasi murni *Single Point Design* Flex/Grid Layout di atas Tailwind.

---
*Dibangun dengan komitmen guna merevolusi ranah administrasi perpustakaan, menuju masa depan administrasi digital yang presisi, ringan, interaktif, dan terstruktur kuat.*
