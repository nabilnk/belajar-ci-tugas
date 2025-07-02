Tentu saja. Anda benar sekali. Ini adalah langkah terakhir yang sangat penting dan saya minta maaf karena belum memberikannya secara lengkap.

Anda telah bekerja keras menyelesaikan semua masalah teknis, sekarang saatnya menyempurnakan dokumentasinya sesuai dengan Poin 5 di lembar soal UAS.

Berikut adalah isi file README.md yang lengkap, detail, dan profesional. Anda bisa langsung menyalin seluruh teks di bawah ini dan menempelkannya ke dalam file README.md di root proyek Anda.

Generated markdown
# Proyek E-Commerce "Toko" - UAS Pemrograman Web Lanjut

Ini adalah proyek aplikasi web E-Commerce yang dibangun menggunakan framework **CodeIgniter 4**. Proyek ini merupakan hasil pengerjaan Ujian Akhir Semester (UAS) untuk mata kuliah Pemrograman Web Lanjut, yang mencakup berbagai fitur mulai dari manajemen produk, transaksi, hingga implementasi fitur diskon dan webservice.

---

## Fitur

Aplikasi ini memiliki serangkaian fitur yang terbagi menjadi beberapa modul utama:

#### **1. Fitur Utama & Autentikasi**
- **User Roles:** Sistem membedakan hak akses antara **Admin** dan **Guest** (pengguna biasa).
- **Login & Logout:** Sistem autentikasi berbasis session untuk keamanan akses.
- **Dashboard:** Halaman utama yang menampilkan daftar produk yang tersedia untuk dibeli.
- **Notifikasi Diskon Dinamis:** Header akan menampilkan informasi diskon secara otomatis jika ada diskon yang berlaku pada hari itu.

#### **2. Fitur Manajemen Data**
- **Manajemen Produk:** Pengguna dapat melakukan CRUD (Create, Read, Update, Delete) pada data produk melalui antarmuka modal (popup).
- **Manajemen Kategori Produk:** Pengguna dapat melakukan CRUD pada data kategori produk.
- **(Admin) Manajemen Diskon:**
  - Menu khusus yang hanya bisa diakses oleh **Admin**.
  - Admin dapat melakukan CRUD pada data diskon harian.
  - Terdapat validasi untuk mencegah penambahan diskon pada tanggal yang sama (`is_unique`).
  - Input tanggal pada form *edit* dibuat `readonly` sesuai ketentuan.

#### **3. Fitur Transaksi & Keranjang**
- **Keranjang Belanja:** Pengguna dapat menambahkan produk ke keranjang, memperbarui jumlah (`quantity`), menghapus item per item, dan mengosongkan seluruh keranjang.
- **Penerapan Diskon Otomatis:** Harga produk akan secara otomatis dipotong sesuai dengan nominal diskon yang berlaku saat produk dimasukkan ke dalam keranjang.
- **Checkout & Ongkos Kirim:** Proses checkout yang terintegrasi dengan API **RajaOngkir** untuk menghitung ongkos kirim secara dinamis.
- **Simpan Transaksi:** Data transaksi (termasuk harga setelah diskon dan ongkir) disimpan ke dalam database.
- **Profil & Riwayat Transaksi:** Pengguna dapat melihat riwayat semua transaksi yang pernah dilakukannya.
- **Selesaikan Transaksi:** Pengguna dapat mengubah status transaksi dari "Belum Selesai" menjadi "Selesai" melalui halaman profil.

#### **4. Fitur Webservice & Dashboard Eksternal**
- **API (Webservice):** Proyek "Toko" menyediakan sebuah endpoint API (`/api/uas-report`) yang mengeluarkan data semua transaksi dalam format JSON.
- **Data Jumlah Item:** Data JSON dari API sudah dimodifikasi untuk menyertakan **total jumlah item** (`jumlah_item`) untuk setiap transaksi.
- **Dashboard Sederhana:** Terdapat aplikasi dashboard eksternal (di dalam folder `public/dashboard-toko`) yang mengonsumsi data dari webservice di atas dan menampilkannya dalam bentuk tabel.

---

## Kebutuhan Sistem & Instalasi

Berikut adalah kebutuhan dan langkah-langkah untuk menjalankan proyek ini di lingkungan lokal.

#### **Kebutuhan Sistem**
- PHP versi 7.4 atau lebih baru
- Composer
- Web Server (Apache/Nginx, atau bisa menggunakan `php spark serve`)
- Database (MySQL/MariaDB)

#### **Langkah-langkah Instalasi**
1.  **Clone Repository**
    ```bash
    git clone [URL_REPOSITORY_GITHUB_ANDA]
    ```

2.  **Masuk ke Direktori Proyek**
    ```bash
    cd [nama-folder-proyek]
    ```

3.  **Install Dependencies**
    Jalankan Composer untuk mengunduh semua library yang dibutuhkan (termasuk CodeIgniter).
    ```bash
    composer install
    ```

4.  **Konfigurasi Environment**
    Salin file `env` menjadi `.env`. File ini digunakan untuk konfigurasi lokal Anda.
    ```bash
    cp env .env
    ```

5.  **Setup File `.env`**
    Buka file `.env` dengan teks editor dan sesuaikan baris-baris berikut:
    ```
    # Atur environment ke 'development' untuk menampilkan error
    CI_ENVIRONMENT = development

    # Atur URL dasar aplikasi Anda
    app.baseURL = 'http://localhost:8080'

    # Konfigurasi koneksi database Anda
    database.default.hostname = localhost
    database.default.database = nama_database_anda
    database.default.username = root
    database.default.password = 

    # Masukkan API Key RajaOngkir Anda
    COST_KEY = "api_key_rajaongkir_anda"
    ```

6.  **Jalankan Migrasi Database**
    Perintah ini akan secara otomatis membuat semua tabel (`transaction`, `transaction_detail`, `diskon`, dll.) di database Anda.
    ```bash
    php spark migrate
    ```

7.  **Jalankan Database Seeder**
    Perintah ini akan mengisi data awal yang diperlukan, seperti akun admin dan data diskon.
    ```bash
    php spark db:seed UserSeeder
    php spark db:seed DiskonSeeder
    ```

8.  **Jalankan Server**
    Gunakan server bawaan CodeIgniter untuk menjalankan aplikasi.
    ```bash
    php spark serve
    ```
    Aplikasi sekarang dapat diakses melalui alamat **http://localhost:8080**.

---

## Struktur Proyek

Berikut adalah penjelasan singkat mengenai struktur direktori utama dalam proyek ini:

-   `app/`
    -   `Controllers/`: Berisi logika utama aplikasi. Menangani permintaan dari pengguna, berinteraksi dengan Model, dan menampilkan View. Contoh: `HomeController.php`, `TransaksiController.php`, `Admin/Diskon.php`.
    -   `Models/`: Bertanggung jawab untuk semua interaksi dengan database. Menyediakan metode untuk mengambil, menyimpan, dan mengubah data. Contoh: `ProductModel.php`, `TransactionModel.php`, `DiskonModel.php`.
    -   `Views/`: Berisi semua file HTML/PHP yang membentuk antarmuka pengguna (UI). Contoh: `v_home.php`, `v_keranjang.php`, `layout.php`.
    -   `Database/`:
        -   `Migrations/`: Berisi file-file skema untuk membangun struktur tabel database.
        -   `Seeds/`: Berisi file-file untuk mengisi data awal ke dalam tabel.
    -   `Filters/`: Berisi class untuk menyaring permintaan sebelum atau sesudah Controller dijalankan. Contoh: `AuthFilter.php` untuk memeriksa status login.
-   `public/`
    -   Merupakan *document root* dari aplikasi. Semua aset publik seperti CSS, JavaScript, dan gambar disimpan di sini.
    -   `index.php`: File utama yang menangani semua permintaan masuk.
    -   `dashboard-toko/`: Folder berisi aplikasi Dashboard sederhana yang mengonsumsi webservice.
-   `.env`
    -   File konfigurasi yang sangat penting. Menyimpan semua pengaturan sensitif dan spesifik untuk lingkungan pengembangan Anda, seperti detail database dan API Key.
