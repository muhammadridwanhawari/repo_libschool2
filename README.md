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

### 3. Dashboard Penjaga Perpustakaan
<img src="public/images/readme.md image/dashboard-petugas.png" alt="Dashboard Penjaga Perpustakaan" width="100%">
**Deskripsi:** Ruang kerja khusus untuk penjaga dalam menangani urusan operasional sirkulasi fisik perpustakaan dari hari ke hari.
**Keunggulan:** Menyajikan tabel informasi real-time mengenai permintaan peminjaman dan jadwal pengembalian. Penjaga dipermudah dengan automasi sistem kalkulasi denda keterlambatan baku, serta pencatatan sirkulasi pergerakan inventaris yang transparan dan akurat.

### 4. Dashboard Siswa (Member)
<img src="public/images/readme.md image/dashboard-siswa.png" alt="Dashboard Siswa" width="100%">
**Deskripsi:** Portal interaktif mandiri yang dikhususkan bagi siswa (anggota aktif) untuk berpartisipasi dalam program literasi perpustakaan.
**Keunggulan:** Menawarkan fitur penelusuran katalog cerdas. Siswa dapat melakukan pengecekan ketersediaan stok buku, mengajukan proses pemesanan (booking) sirkulasi dari jauh secara mandiri, melacak rekam jejak denda dan detail riwayat peminjaman mereka, serta menyimpan literatur favorit.

---

## Fitur-fitur Lengkap Aplikasi

Aplikasi LibSchool membagi rentetan fiturnya menjadi 3 pilar jenis pengguna (Admin, Penjaga, dan Siswa). Berikut adalah penjelasan santai dan mudah dipahami untuk semua fitur yang ada:

### 1. Fitur Umum & Keamanan
*   **Login & Register Mudah**: Pengguna bisa login dengan aman, siswa baru bisa mendaftar akun sekolah secara mandiri, dan ada fitur *Reset Password* via email kalau sewaktu-waktu lupa sandi.
*   **Pendeteksi Login Otomatis**: Jika pengguna sudah pernah masuk (*login*) sebelumnya, ketika membuka website akan langsung diarahkan masuk ke dasbornya masing-masing tanpa harus login ulang, sangat efisien.
*   **Pembatasan Akses (Aman dari Orang Iseng)**: Fitur keamanan kuat yang mencegah siswa menyusup ke halaman Admin, begitupun sebaliknya. Setiap orang hanya bisa melihat halaman yang memang sesuai porsinya.

### 2. Fitur Khusus Siswa
*   **Dasbor Pintar (Hero & Notifikasi)**: Tampilan beranda modern yang menyambut siswa dengan Profil *Hero Card*, akumulasi Poin, serta Gelar Literasi. Dilengkapi Lonceng Notifikasi yang otomatis memberi peringatan cerdas apabila terdapat buku yang mendekati *deadline* pengembalian atau ada tunggakan denda.
*   **Papan Peringkat & Gelar Poin (Gamifikasi)**: Bersaing literasi dengan interaktif! Sistem memberikan ekstra Poin bagi siswa yang mengembalikan buku terpat waktu (+10) dan memberi rekomendasi ulasan (+3). Namun, poin dipotong (-5) jika menunggak telat. Akumulasi tersebut akan mendobrak *Leaderboard* peringkat siswa guna memperebutkan level gelar dari "Pemula" hingga "Duta Literasi"!
*   **Katalog Interaktif Terpadu**: Eksplorasi koleksi perpustakaan dengan dukungan *Hero Banner Slider* yang estetik untuk "Buku Terfavorit". Siswa juga dibekali filter pencarian buku yang canggih dan dinamis.
*   **Sistem Booking Jarak Jauh**: Takut kehilangan buku incaran karena dipinjam teman? Lakukan reservasi (*Booking*) dari rumah hanya lewat layar *smartphone*, dan ambil fisik bukunya di perpustakaan.
*   **Ruang Opini & Ulasan**: Siswa yang telah tuntas membaca dapat menyematkan *Rating* bintang dan menulis ulasan publik untuk memandu minat baca kawan-kawan sekolah lainnya.
*   **Rekam Jejak & Sistem Pembayaran Denda Digital**: Menyimpan dengan rapi rekam historis peminjaman. Aplikasi juga mengakomodasi penyelesaian denda telat; siswa diwajibkan mengunggah *Proof of Payment* (Bukti Pembayaran) langsung lewat aplikasi untuk divalidasi oleh pihak perpustakaan.
*   **Formulir Pengajuan Buku Baru**: Tidak menemukan buku yang pas? Siswa punya hak prerogatif untuk mengirim draf proposal pengadaan buku baru yang nantinya akan ditinjau untuk dibeli oleh Penjaga perpustakaan.
*   **Rak Favorit Pribadi & E-Card**: Simpan buku idaman ke sudut "*Favorite*" agar mudah dicari kelak. Mengunduh/mencetak Kartu Tanda Anggota Library (*E-Card*) dapat dilakukan secara digital dengan mudah.
*   **Pengaturan Profil Lengkap**: Siswa diberikan kendali privasi lewat menu pengaturan untuk meng-update informasi akun pribadi, bebas mengganti foto *Avatar* mereka, hingga merubah kunci kata sandi (*reset password*) demi keamanan ganda secara mandiri.

### 3. Fitur Khusus Penjaga Perpustakaan
*   **Persetujuan Pinjam Buku (Klik Tombol)**: Tempat penjaga memeriksa kode booking dari anak-anak (Contoh: `BK-2026403-0001`). Setelah anak mengambil fisik bukunya di meja perpus, penjaga tinggal tekan "Konfirmasi" dan sah sudah dipinjam!
*   **Kasir Denda Berjalan**: Disaat mendata anak yang mengembalikan buku melewati hari batas waktu (*deadline*), sistem yang akan memikirkan hitungan denda dan seketika langsung menghardik muncul di hadapan layar penjaga otomatis.
*   **Catatan Aktivitas Staf Harian**: Rangkuman arus buku apa saja di luar rak, dan ada berapa buku yang tersimpan siang itu.
*   **Buka Surat Keluhan (Inbox)**: Menerima, membaca, dan menyelesaikan laporan pertolongan yang masuk dari aplikasi si anak.
### 4. Fitur Spesial Administrator (Kepala Perpustakaan)
*   **Pusat Komando (Dashboard Analitik)**: Visualisasi level eksekutif yang merangkum keseluruhan total pergerakan koleksi buku, laju pendaftaran siswa baru, hingga metrik laporan aktif dalam bentuk *Stat Cards* komprehensif.
*   **Manajemen Pengguna (CRUD)**: Otoritas mutlak untuk mencipta akun Penjaga/Siswa baru, memperbaiki rincian kesalahan alamat/biodata, hingga fitur "*Reset Password*" paksa bagi pengguna yang terkunci.
*   **Portal Verifikasi Anggota (KYC Member)**: Tameng pertahanan dari pengunjung bodong. Siswa yang mendaftar secara daring belum diizinkan "*Booking*" buku sebelum berkasnya mendapatkan "Centang Verifikasi" manual dari Admin.
*   **Kendali Hak Akses Khusus (Role & Permission)**: Kapabilitas luar biasa untuk mengubah peranan staf (*Downgrade* penjaga menjadi siswa) seketika! Admin dapat memecah tugas administratif dengan memberikan matriks perizinan modul (*Permission*) spesifik bagi staf tertentu.

### 5. Pengelolaan Sirkulasi & Inventaris (Hak Akses: Admin & Penjaga)
*   **Gudang Inventaris Buku Terpadu**: Fasilitas melengkapi profil beribu literatur secara mendalam, dari input Nomor Standar (ISBN), Sampul Muka (*Display Cover*), Sinopsis Cerita, Info Penerbit, Tahun Keluar, hingga pemetaan Posisi Rak Asli (*Location*).
*   **Katalogisasi Ganda (Kategori & Seri Buku)**: Algoritma penyusunan maju yang tak hanya bertumpu pada "Filter Kategori" (misal: *Novel*, *Ensiklopedia*), namun perpustakaan dapat mengikat koleksi novel bernomor urut ke dalam himpunan "*Book Series*".
*   **Meja Verifikasi Bukti Denda**: Fitur ruang rekonsiliasi yang disiapkan untuk staf dalam melakukan perbandingan antara struk foto Bukti Bayar Digital (*Proof of Payment*) lampiran siswa melawan besaran denda tagihan kasir sebelum dinyatakan lunas tuntas.
*   **Pembuat Laporan Otomatis (Generator PDF)**: Dengan satu kali sentuhan tombol konfigurasi bulan/tahun kalender, sistem meringkas ribuan rekam jejak aktivitas sirkulasi dan mencetak dokumen legal elektronik format **PDF** yang menawan sebagai bahan laporan pengesahan bulanan.
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
