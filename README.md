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

### 3. Dashboard Siswa & Katalog Cerdas
> Beranda gamifikasi interaktif yang merangkum skor poin, medali gelar siswa, serta pemaparan denda yang dikemas estetis.
> <img src="public/images/readme.md image/katalog.png" alt="Beranda Panel Siswa" width="800">

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

## Panduan Menjalankan Sistem (Setup Lokal)

Ikuti instruksi tahapan instalasi peranti tunjang di bawah untuk menjalankan layanan aplikasinya dari PC Anda:

1. **Clone repository ini dari basis kendali versi (Git):**

    ```bash
    git clone <URL_REPO_ANDA>
    cd LIBSCHOOL
    ```

2. **Dapatkan Paket Pustaka lewat Dependensi Composer & Node Package Manager:**

    ```bash
    composer install
    npm install
    ```

3. **Salin & Modifikasi Pembenihan Environment Variable:**

    ```bash
    cp .env.example .env
    ```

4. **Konfigurasikan Data Database & SMTP Email dalam file `.env`:**
   Atur dan sesuaikan parameter kredensial `DB_DATABASE`, `DB_USERNAME`, *port* pangkalan data server, hingga pengaturan layanan `MAIL_MAILER` agar fitur *Lupa Kata Sandi* (Reset Password) dapat beroperasi sebagaimana mestinya.

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=db_libschool
    DB_USERNAME=root
    DB_PASSWORD=

    # Konfigurasi SMTP Email (Wajib untuk fitur Lupa Sandi)
    MAIL_MAILER=smtp
    MAIL_HOST=sandbox.smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="hello@libschool.com"
    MAIL_FROM_NAME="${APP_NAME}"
    ```

5. **Pembuatan Key Hash Internal Laravel:**

    ```bash
    php artisan key:generate
    ```

6. **Migrasikan Struktur Tabel Basis Data dan Suntik Data Dummy:**
   _(Langkah ini teramat praktis! Otomatis men-generate basis pola klasifikasi, tatanan buku, serta akun dummy anggota lewat _Seeder_)._

    ```bash
    php artisan migrate --seed
    ```

7. **Aktifkan Storage Link (Untuk Unggah Gambar Cover/Bukti Bukti Bayar):**

    ```bash
    php artisan storage:link
    ```

8. **Proses Akhir: Menghidupkan Layanan Dua Serangkai**
   Buka jendela terminal utama dan komando agar melayani basis mesin PHP:
    ```bash
    php artisan serve
    ```
    Buka jendela terminal kedua (Sangat vital demi merangkai dan menyaksikan kompilasi *Tailwind* secara langsung):
    ```bash
    npm run dev
    ```
    _Silakan mengakses portal di http://127.0.0.1:8000 via browser (peramban) kesayangan Anda._

---

## Basis Akun / Kredensial Demonstrasi

Bilamana instalasi disusupkan lewat _flag_ `--seed` saat migrasi database, cobalah autentikasi simulasi pengujian (Demo) dengan deretan identitas di bawah:

| Roles / Tingkat Otoritas |    Username Atribut     | Password Sandi Standar |
| :----------------------- | :---------------------- | :--------------------- |
| **Admin Pusat Eksekutif**| `admin`                 | `password`             |
| **Petugas / Pustakawan** | `penjaga`               | `password`             |
| **Anggota Siswa**        | `siswa`                 | `password`             |

_Catatan Edukasi: Pastikan kelak membiasakan pergantian mutlak kata kunci maupun pencopotan _seeder_ saat mentransformasi aplikasi LibSchool menjadi wujud komersial guna menghindari paparan kerentanan._

---

<p align="center">
  <sub>Dibangun oleh pengembang sistem berdedikasi demi mendobrak digitalisasi arsip sirkulasi perbukuan, menjadikannya tertata, efisien dan kompetitif secara interaktif dalam lingkungan akademik sekolah.</sub>
</p>
