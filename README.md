<div align="center">
  <img src="public/images/readme.md image/landing-page.png" alt="Beranda Aplikasi LibSchool" width="100%">
  <br>

  <h1>Sistem Informasi Manajemen Perpustakaan Sekolah (LibSchool)</h1>
  <p>Proyek aplikasi web manajemen sirkulasi perpustakaan modern dengan sentuhan Gamifikasi, Pembayaran Denda Digital, Otomasi Kalkulasi Denda, serta antarmuka yang bersih dan interaktif.</p>
</div>

---

## Deskripsi Proyek

**LibSchool** adalah sistem informasi perpustakaan berbasis web yang dibangun secara tangguh menggunakan framework Laravel 12 dan antarmuka dinamis Tailwind CSS. Platform ini dirancang khusus untuk memenuhi standar profesional dalam mengelola sirkulasi peminjaman buku, administrasi rak katalog, operasional denda, hingga integrasi rekam jejak setiap anggota sekolah dalam satu ruang lingkup terpusat. Proyek ini sangat cocok untuk digitalisasi perpustakaan instansi dengan keunggulan pada _UI/UX_ yang responsif, modern, dan alur konfirmasi yang transparan. Lebih dari itu, sistem ini juga dirancang dan disusun secara komprehensif guna memenuhi kualifikasi **UKK (Uji Kompetensi Keahlian)**, sekaligus sebagai ruang unjuk kebolehan arsitektur perangkat lunak terkini.

## Fitur Unggulan Sistem

Aplikasi ini menyajikan desain yang _responsive_ dengan dukungan fitur-fitur **advance / tingkat lanjut** sebagai berikut:

### Fitur Baru & Integrasi Modern

- **Sistem Gamifikasi (Papan Peringkat & Gelar Literasi)**: Mendorong semangat siswa untuk giat membaca! Sistem memberikan ekstra Poin (+10) untuk pengembalian yang tepat waktu dan penulisan ulasan. Namun, poin di korting (-5) untuk tiap keterlambatan. Poin diakumulasi menjadi peringkat (_Leaderboard_) tingkat sekolah yang dapat mendobrak level gelar dari "Pemula" hingga "Duta Literasi".
- **Pembayaran Denda Digital & Verifikasi Bukti**: Terintegrasi secara penuh dengan prosedur bukti transfer kas. Siswa dapat melunasi denda keterlambatan secara _cashless_, kemudian mengunggah bukti struk atau *screenshot* (_Proof of Payment_) langsung via aplikasi agar divalidasi oleh layar Kasir Denda meja staf penjaga otomatis.
- **Pembuat Laporan Otomatis (Generator PDF DomPDF)**: Dengan sekali penyetelan rekap kalender, semua arsip dan siklus transaksi dilaporkan ke format PDF legal terstruktur nan eksekutif untuk diserahkan ke kepala arsip bulanan.
- **Deteksi Login Cerdas & Pertahanan Akses**: Fitur arsitektur _Role and Permission_ kokoh melindungi privasi akses silang. Mengarahkan akun _login_ sesuai teritorial peruntukannya (Admin, Staf, atau Anggota) serta memastikan anggota tak dapat menyusup perizinan admin lewat modifikasi parameter *URL*.

#### 📸 Ilustrasi Fitur Unggulan Modern

**1. Sistem Gamifikasi (Poin & Gelar Literasi Siswa)**
| Medali & Profil Poin Siswa | Klasemen Papan Peringkat (Leaderboard) |
|:---:|:---:|
| <img src="public/images/readme.md image/profil siswa.png" height="280"> | <img src="public/images/readme.md image/leader board.png" height="280"> |

> **Penjelasan Integritas Alur:**
> Gambar di panel kiri merupakan pusaka identitas literasi siswa. Di ruang ini, siswa dapat melihat pencapaian **Poin** berserta akumulasi medali lencana gelar yang tumbuh menilik kedisiplinan membaca. Sebagai pemantik kompetisi sehat, poin-poin tersebut diadu secara spektakuler pada tampilan **Leaderboard** klasemen tingkat Sekolah secara *real-time* (gambar kanan), memicu semangat seluruh siswa untuk berebut tahta puncak "Duta Literasi"!

**2. Alur Pembayaran Denda Digital Terpadu**
| Antarmuka *Upload* Struk (Panel Siswa) | Meja Validasi Kasir (Panel Petugas) |
|:---:|:---:|
| <img src="public/images/readme.md image/bayar denda.png" height="280"> | <img src="public/images/readme.md image/admin menyelesaikan denda.png" height="280"> |

> **Penjelasan Integritas Alur:**
> Tangkapan di sebelah kiri memperlihatkan **Panel Siswa** yang sedang menunggak denda. Siswa dapat menuntaskan denda secara daring dengan mengunggah *screenshot* / foto **Bukti Transfer** (_Proof of Payment_). Setelah terkirim, pada sisi kanan, gambar bukti tersebut akan langsung tertampil *real-time* berserta detail faktur tagihannya di layang depan **Panel Kasir Petugas** guna divalidasi keasliannya dan diterbitkan struk lunas!

**3. Siklus Automasi Laporan Dokumen (DomPDF)**
| Kolom Penyetelan Arsip Waktu | Hasil File Render PDF Eksekutif |
|:---:|:---:|
| <img src="public/images/readme.md image/laporan.png" height="280"> | <img src="public/images/readme.md image/laporan cetak pdf.png" height="280"> |

> **Penjelasan Integritas Alur:**
> Gambar kiri memperlihatkan **Filter Cetak**. Petugas hanya butuh menyaring arsip berdasarkan tanggal atau rentang bulan peminjaman. Sistem pelaporan akan menyapu ribuan laju data riwayat dan memadatinya ke dalam bentuk luaran laporan rekap sirkulasi **Berformat Arsip PDF** terstandar untuk diaudit secara instan oleh Kepala Perpustakaan (*Gambar Kanan*).

**4. Pergerakan Sistem Peminjaman Daring (*Booking*)**
| Kode Reservasi Berjalan (Panel Siswa) | Antrean Peminjaman Baru (Panel Petugas) |
|:---:|:---:|
| <img src="public/images/readme.md image/kode booking.png" height="200"> | <img src="public/images/readme.md image/konfirmasi peminjaman.png" height="200"> |

> **Penjelasan Integritas Alur:**
> Sangat memanjakan *Member/Siswa*. Tangkap gambar kiri memperlihatkan siswa yang takut kehabisan buku favorit di kelas, dapat melakukan *Booking* secara mandiri, sehingga memperoleh **Kode Reservasi Peminjaman**. Setelahnya (pada layar kanan), reservasinya akan muncul ke area monitor Petugas agar slot antreannya diamankan sementara hingga tiba waktunya siswa bersangkutan menjemput wujud buku tersebut di meja administrasi.

### Panel Admin (Kepala / Administrator)

- **Pusat Komando Analitik (Dashboard)**: Visualisasi metrik rekap rasio siswa, siklus pengembalian dan sirkulasi peminjaman berjalan yang berbentuk *Stat Cards* komprehensif.
- **Otoritas Verifikasi Anggota (KYC Member)**: Tameng pendaftaran daring. Siswa baru tidak diperbolehkan "*Booking*" sebelum identitas registrasinya divalidasi dan di konfirmasi kebenarannya oleh Admin pusat.
- **Manajemen Pengguna (CRUD) & Perizinan**: Otoritas pengangkatan atau pewarisan peran silang staf ke penjaga. Mendukung eksekusi tombol "_Reset Password Paksa_" apabila anggota lupa sandi mereka secara drastis.

### Panel Petugas (Penjaga Perpustakaan / Sirkulasi)

- **Persetujuan Sirkulasi (*Booking* Jarak Jauh)**: Penjaga menyortir dan menerbitkan rilis buku secara cepat. Tinggal validasi nomor *booking* dan tabrak tombol *Konfirmasi*.
- **Kalkulasi Denda Harian Otomatis**: Tak perlu lagi pusing kalkulator manual! Saat anggota mengembalikan buku via petugas, sistem serentak mengurai total denda berdasar hari secara murni sebelum di finalisasi.
- **Agenda Harian & Resolusi Pengaduan (*Inbox*)**: Cukup mengklik meja informasi pesan masukan, staf dan penjaga perpustakaan dapat melayani permintaan spesifik perihal koleksi buku dari siswa.

### Panel Anggota (Siswa / Member)

- **Sistem _Booking_ Jarak Jauh (Reservasi)**: Takut keburu ludes di rak? Siswa dapat mengajukan reservasi antrean dari _smartphone_ via katalog, lalu mengambil fisik rupa buku di ruang perpus keesokannya.
- **Katalog Interaktif Terpadu**: Jelajahi etalase buku dengan _Hero Banner Slider_ estetik dari pustaka favorit berserta dukungan penyaringan (_filter_) canggih.
- **Pelacakan Koleksi & KTA (*E-Card*)**: Panel meninjau jatuh tempo yang tertunda. Menyalin ke Rak Favorit digital, plus tombol instan guna cetak/unduh Kartu Tanda Anggota bernomor barcode unik secara digital.
- **Ruang Ulasan & Permintaan Pustaka**: Mengunggah aspirasi lewat fitur proposal buku (*Propose Book*) untuk meminta di adakan ke koleksi perpus dan mendiskusikan *rating* reviu kepada kawan sesama pemustaka.

---

## Dokumentasi & Antarmuka (Preview)

Berikut adalah beberapa pratinjau cuplikan resolusi antarmuka di sistem LibSchool yang difokuskan pada fungsionalitas dan estetika:

### 1. Dashboard Administrator
> Pusat kendali mutlak khusus pimpinan dan manajer dengan presentasi _Stat Cards_ operasional keseluruhan.
> <img src="public/images/readme.md image/dashboard-admin.png" alt="Dashboard Administrasi" width="800">

### 2. Dashboard Pelayanan Petugas
> Ruang sirkulasi garda depan! Memonitor perputaran stok pinjaman masuk-keluar secara interaktif dan serba _real-time_.
> <img src="public/images/readme.md image/dashboard-petugas.png" alt="Dashboard Panel Penjaga" width="800">

### 3. Tampilan Katalog Siswa Terpadu
> Mengeksplorasi ribuan judul yang asyik! Memiliki struktur *layout hero banner slider* guna memprioritaskan fitur pencarian, sekaligus menjadi laman penyambutan siswa yang efisien.
> <img src="public/images/readme.md image/katalog.png" alt="Beranda Katalog Siswa" width="800">

---

## Teknologi Utama di Balik Sistem

Proyek platform LibSchool ini mengadopsi stack tekonologi yang tangkas dan berpusat pada penyesuaian proses manajemen pustaka nan solid:

- **Bahasa & Backend Framework**: PHP (Laravel 12.x) - *Memerlukan ^PHP 8.2*
- **Frontend / Styling Toolbox**: CSS Utility-First (Tailwind CSS v3 murni) yang sangat dapat dikustomisasi
- **Database Server**: Relational DB (MySQL / MariaDB via PDO)
- **State & Interactivity**: Blade Templating Engine & Alpine.js
- **Assets Bundler Kompilasi**: Vite v6 terintegrasi (laravel-vite-plugin)
- **Ekosistem Otentikasi**: Laravel Breeze v2 (Session & Cookie Authentication)
- **Generator Dokumen Eksternal**: DomPDF (`barryvdh/laravel-dompdf`) guna pencetakan dokumen *Report* dan E-Card PDF.

---

## Kebutuhan Sistem

### 1.2.1 Software (Perangkat Lunak)

- **Sistem Operasi:** Windows 10/11 atau Linux (Ubuntu 20.04+).
- **Development Server:** XAMPP v8.2+ (sudah mencakup Apache, PHP 8.2+, dan phpMyAdmin).
- **Database Service:** MySQL 5.7+ (berjalan melalui XAMPP Control Panel secara lokal).
- **Database Manager:** phpMyAdmin (aplikasi GUI berbasis web untuk mengelola database, sudah terintegrasi dalam XAMPP).
- **Dependency Manager PHP:** Composer 2.x (untuk mengelola dependensi Laravel).
- **Dependency Manager JS:** NPM (Node.js v18 LTS atau lebih baru, untuk mengelola dependensi frontend dan build asset Vite).

### 1.2.2 Hardware (Perangkat Keras Minimal Server/Lokal)

- **CPU:** Intel Core i3 / AMD Ryzen 3 atau setara.
- **RAM:** Minimal 4 GB.
- **Penyimpanan:** Ruang kosong Harddisk/SSD minimal 1 GB.
- **Jaringan:** Koneksi internet yang stabil untuk pengiriman email notifikasi melalui layanan SMTP Gmail (fitur reset password).

---

## Panduan Instalasi dan Konfigurasi

### 1. Persiapan Perangkat Lunak

Sebelum memulai instalasi, pastikan seluruh perangkat lunak berikut telah terpasang:

#### 1.1 XAMPP
XAMPP adalah paket server lokal yang menyediakan Apache, MySQL, dan PHP dalam satu instalasi.
- **Unduh**: https://www.apachefriends.org/download.html
- **Versi yang dibutuhkan**: XAMPP dengan PHP **8.2 atau lebih baru**
- Setelah instalasi, buka **XAMPP Control Panel** → klik **Start** pada **Apache** & **MySQL** → pastikan kedua indikator berwarna **hijau**.

#### 1.2 Composer
Composer adalah *dependency manager* untuk PHP yang digunakan Laravel.
- **Unduh**: https://getcomposer.org/download/
- Unduh `Composer-Setup.exe`, jalankan installer (otomatis mendeteksi PHP dari XAMPP).
- Verifikasi: `composer --version` → pastikan menampilkan versi **Composer 2.x**.

#### 1.3 Node.js & NPM
Node.js diperlukan untuk kompilasi aset frontend (Tailwind CSS & Vite).
- **Unduh**: https://nodejs.org (pilih versi **LTS 18.x atau 20.x**)
- Verifikasi: `node --version` dan `npm --version`

---

### 2. Instalasi Aplikasi

#### 2.1 Membuat Database
1. Buka browser, akses **phpMyAdmin**: `http://localhost/phpmyadmin`
2. Klik menu **"Database"** → pada kolom *Create database*, ketik:
   ```
   libschool
   ```
3. Pilih collation **`utf8mb4_unicode_ci`** → klik **Create**.

#### 2.2 Clone Repository
```bash
git clone <URL_REPOSITORY>
cd LIBSCHOOL
```
> Jika tidak menggunakan Git, ekstrak file ZIP proyek ke `C:\xampp\htdocs\LIBSCHOOL`.

#### 2.3 Instalasi Dependensi PHP
```bash
composer install
```

#### 2.4 Instalasi Dependensi JavaScript
```bash
npm install
```

---

### 3. Konfigurasi Environment

#### 3.1 Salin File Environment
```bash
copy .env.example .env
```

#### 3.2 Generate Application Key
```bash
php artisan key:generate
```
Perintah ini otomatis mengisi nilai `APP_KEY` di dalam file `.env`.

---

### 4. Konfigurasi Database

Buka file `.env`, sesuaikan bagian berikut:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=libschool
DB_USERNAME=root
DB_PASSWORD=
```

| Parameter | Nilai Default XAMPP | Keterangan |
| :--- | :--- | :--- |
| `DB_CONNECTION` | `mysql` | Driver database yang digunakan |
| `DB_HOST` | `127.0.0.1` | Alamat server database lokal |
| `DB_PORT` | `3306` | Port default MySQL |
| `DB_DATABASE` | `libschool` | Nama database yang telah dibuat |
| `DB_USERNAME` | `root` | Username default XAMPP |
| `DB_PASSWORD` | *(kosong)* | Password default XAMPP kosong |

---

### 5. Konfigurasi SMTP Email (Gmail)

Fitur **Reset Password** memerlukan konfigurasi layanan email via **Gmail SMTP**.

#### 5.1 Mendapatkan Gmail App Password
> ⚠️ Gmail tidak mengizinkan login langsung dengan password akun biasa. Wajib menggunakan **App Password**.

1. Buka https://myaccount.google.com → pilih menu **"Keamanan"**.
2. Aktifkan **Verifikasi 2 Langkah** jika belum aktif.
3. Cari **"Sandi Aplikasi"** (App Passwords).
4. Pilih **"Lainnya (Nama Kustom)"** → ketik `LibSchool` → klik **Buat**.
5. Google menampilkan kode **16 karakter** — salin kode ini (hanya tampil sekali).

#### 5.2 Isi Konfigurasi SMTP di File `.env`

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email_anda@gmail.com
MAIL_PASSWORD="xxxx xxxx xxxx xxxx"
MAIL_FROM_ADDRESS="email_anda@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"
```

| Parameter | Nilai | Keterangan |
| :--- | :--- | :--- |
| `MAIL_HOST` | `smtp.gmail.com` | Server SMTP Gmail |
| `MAIL_PORT` | `587` | Port SMTP dengan enkripsi TLS |
| `MAIL_USERNAME` | `email_anda@gmail.com` | Alamat Gmail pengirim |
| `MAIL_PASSWORD` | `xxxx xxxx xxxx xxxx` | App Password 16 karakter dari Google |
| `MAIL_FROM_ADDRESS` | `email_anda@gmail.com` | Alamat pengirim di email |

---

### 6. Migrasi & Seeding Database

#### 6.1 Jalankan Migrasi dan Seeder
Membuat seluruh struktur tabel sekaligus mengisi data awal (akun demo, kategori, data contoh):
```bash
php artisan migrate --seed
```

#### 6.2 Aktifkan Storage Link
Agar file yang diunggah (cover buku, bukti bayar denda) dapat diakses secara publik:
```bash
php artisan storage:link
```

---

### 7. Menjalankan Aplikasi

Aplikasi membutuhkan **dua layanan** yang berjalan secara bersamaan di dua jendela terminal terpisah.

**Terminal 1** — Server PHP Laravel:
```bash
php artisan serve
```

**Terminal 2** — Kompilasi Aset Frontend (Vite + Tailwind CSS):
```bash
npm run dev
```

Setelah kedua layanan aktif, buka browser dan akses:
```
http://127.0.0.1:8000
```

> **Catatan**: Pastikan layanan **Apache** dan **MySQL** di XAMPP Control Panel selalu **aktif (hijau)** setiap kali menjalankan aplikasi.

---

## Tabel Hak Akses Pengguna

Berikut adalah matriks hak akses seluruh modul dan fitur sistem berdasarkan peran (*role*) masing-masing pengguna:

| Modul / Fitur | Guest (Tamu) | Siswa (Anggota) | Penjaga (Petugas) | Admin |
| :--- | :---: | :---: | :---: | :---: |
| Landing Page | ✓ | ✓ | ✓ | ✓ |
| Registrasi & Login | ✓ | ✓ | ✓ | ✓ |
| Reset & Lupa Password | ✓ | ✓ | ✓ | ✓ |
| Dashboard & Profil | - | ✓ | ✓ | ✓ |
| Eksplorasi Katalog Buku | - | ✓ | - | - |
| Booking Buku (Reservasi) | - | ✓ | - | - |
| Batal Booking | - | ✓ | - | - |
| Riwayat Peminjaman Pribadi | - | ✓ | - | - |
| Koleksi Favorit (Wishlist) | - | ✓ | - | - |
| Ulasan & Rating Buku | - | ✓ | - | - |
| Pengajuan / Usulan Buku Baru | - | ✓ | ✓ | ✓ |
| Kartu Anggota Digital (E-Card) | - | ✓ | - | - |
| Pembayaran Denda (Upload Bukti) | - | ✓ | - | - |
| Gamifikasi (Poin & Leaderboard) | - | ✓ | - | - |
| Proses Konfirmasi Booking | - | - | ✓ | - |
| Proses Pengembalian & Hitung Denda | - | - | ✓ | ✓ |
| Verifikasi Bukti Bayar Denda | - | - | ✓ | ✓ |
| Riwayat Transaksi Seluruh | - | - | ✓ | ✓ |
| Inbox & Kelola Pengajuan | - | - | ✓ | - |
| Verifikasi Anggota Baru (KYC) | - | - | - | ✓ |
| Manajemen Katalog Buku (CRUD) | - | - | ✓* | ✓ |
| Manajemen Kategori & Series | - | - | ✓* | ✓ |
| Laporan Sistem (Export PDF) | - | - | ✓* | ✓ |
| Manajemen Pengguna | - | - | - | ✓ |
| Manajemen Hak Akses | - | - | - | ✓ |

> **Keterangan:** ✓\* = Penjaga hanya dapat mengakses modul tersebut apabila izin (*Permission*) telah diberikan secara eksplisit oleh Admin melalui fitur **Manajemen Hak Akses**.

---

## Basis Akun / Kredensial Demonstrasi

Bilamana instalasi disusupkan lewat _flag_ `--seed` saat migrasi database, cobalah autentikasi simulasi pengujian (Demo) dengan deretan identitas di bawah:

| Roles / Tingkat Otoritas | Username Atribut | Password Sandi Standar |
| :--- | :--- | :--- |
| **Admin Pusat Eksekutif** | `admin` | `password` |
| **Petugas / Pustakawan** | `penjaga` | `password` |
| **Anggota Siswa** | `siswa` | `password` |

> **Catatan Keamanan:** Pastikan mengganti password default dan menghapus data *seeder* sebelum aplikasi digunakan di lingkungan produksi.

---

<p align="center">
  <sub>Dibangun oleh pengembang sistem berdedikasi demi mendobrak digitalisasi arsip sirkulasi perbukuan, menjadikannya tertata, efisien dan kompetitif secara interaktif dalam lingkungan akademik sekolah.</sub>
</p>
