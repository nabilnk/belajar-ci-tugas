# Proyek E-Commerce "Toko" - UAS Pemrograman Web Lanjut

Ini adalah proyek aplikasi web E-Commerce yang dibangun menggunakan framework **CodeIgniter 4**. Proyek ini merupakan hasil pengerjaan Ujian Akhir Semester (UAS) untuk mata kuliah Pemrograman Web Lanjut, yang mencakup berbagai fitur mulai dari manajemen produk, transaksi, hingga implementasi fitur diskon dan webservice sesuai dengan ketentuan soal.

---

## Fitur

Aplikasi ini memiliki serangkaian fitur yang terbagi menjadi beberapa modul utama, dirancang untuk memenuhi semua poin dalam soal UAS:

#### **1. Fitur Utama & Autentikasi**
- **User Roles:** Sistem membedakan hak akses antara **Admin** dan **Guest** (pengguna biasa).
- **Login & Logout:** Sistem autentikasi berbasis session untuk keamanan akses.
- **Dashboard:** Halaman utama yang menampilkan daftar produk yang tersedia untuk dibeli.
- **Notifikasi Diskon Dinamis:** Header akan menampilkan informasi diskon secara otomatis jika ada diskon yang berlaku pada hari itu. Logika ini ditempatkan di `BaseController` untuk memastikan data selalu *up-to-date* di setiap halaman.

#### **2. Fitur Manajemen Data**
- **Manajemen Produk:** Pengguna dapat melakukan CRUD (Create, Read, Update, Delete) pada data produk melalui antarmuka modal (popup).
- **Manajemen Kategori Produk:** Pengguna dapat melakukan CRUD pada data kategori produk.
- **(Admin) Manajemen Diskon:**
  - Menu khusus yang **hanya bisa diakses oleh Admin**.
  - Admin dapat melakukan CRUD pada data diskon harian melalui antarmuka modal.
  - Terdapat validasi untuk mencegah penambahan diskon pada tanggal yang sama (`is_unique`).
  - Input tanggal pada form *edit* dibuat `readonly` sesuai ketentuan.

#### **3. Fitur Transaksi & Keranjang**
- **Keranjang Belanja:** Pengguna dapat menambahkan produk ke keranjang, memperbarui jumlah (`quantity`), menghapus item per item, dan mengosongkan seluruh keranjang.
- **Penerapan Diskon Otomatis:** Harga produk akan secara otomatis dipotong sesuai dengan nominal diskon yang berlaku saat produk dimasukkan ke dalam keranjang.
- **Checkout & Ongkos Kirim:** Proses checkout yang terintegrasi dengan API **RajaOngkir** untuk menghitung ongkos kirim secara dinamis.
- **Simpan Transaksi:** Data transaksi (termasuk harga setelah diskon dan ongkir) disimpan ke dalam database.
- **Profil & Riwayat Transaksi:** Pengguna dapat melihat riwayat semua transaksi yang pernah dilakukannya.
- **Selesaikan Transaksi:** Pengguna dapat mengubah status transaksi dari "Belum Selesai" menjadi "Selesai" melalui sebuah tombol di halaman profil.

#### **4. Fitur Webservice & Dashboard Eksternal**
- **API (Webservice):** Proyek "Toko" menyediakan sebuah endpoint API (`/api/uas-report`) yang mengeluarkan data semua transaksi dalam format JSON.
- **Data Jumlah Item:** Data JSON dari API sudah dimodifikasi untuk menyertakan **total jumlah item** (`jumlah_item`) untuk setiap transaksi, sesuai permintaan soal.
- **Dashboard Sederhana:** Terdapat aplikasi dashboard eksternal (di dalam folder `public/dashboard-toko`) yang mengonsumsi data dari webservice di atas dan menampilkannya dalam bentuk tabel.

---

## Kebutuhan Sistem & Instalasi

Berikut adalah kebutuhan dan langkah-langkah untuk menjalankan proyek ini di lingkungan lokal.

#### **Kebutuhan Sistem**
- PHP versi 7.4 atau lebih baru
- Composer
- Web Server (Apache/Nginx, atau bisa menggunakan `php spark serve`)
- Database (MySQL/MariaDB)
- Ekstensi PHP `intl` (untuk format mata uang) dan `curl` (untuk API).

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
    # Atur environment ke 'development' untuk menampilkan error saat pengembangan
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
    Perintah ini akan secara otomatis membuat semua tabel (`transaction`, `transaction_detail`, `diskon`, dll.) di database Anda sesuai dengan file migrasi.
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

Aplikasi ini dibangun di atas arsitektur **Model-View-Controller (MVC)** yang disediakan oleh CodeIgniter 4. Struktur ini memisahkan logika aplikasi, data, dan tampilan, sehingga membuat proyek lebih terorganisir, mudah dikelola, dan skalabel. Berikut adalah rincian dari direktori dan file-file kunci dalam proyek ini:

-   `app/`
    > Direktori ini adalah jantung dari aplikasi Anda. Semua kode spesifik untuk proyek "Toko" berada di sini.

    -   `Controllers/`
        > Berisi kelas-kelas Controller yang bertindak sebagai "manajer" atau "otak" dari setiap permintaan. Tugasnya adalah menerima input dari pengguna, berkomunikasi dengan Model untuk mengelola data, dan kemudian mengirimkan data tersebut ke View untuk ditampilkan.
        -   **`BaseController.php`**: Controller induk tempat semua controller lain mewarisi. Di proyek ini, `BaseController` dimodifikasi untuk secara otomatis mengecek diskon yang berlaku setiap hari pada setiap halaman.
        -   **`HomeController.php`**: Mengelola halaman-halaman statis dan halaman utama, seperti Dashboard (`index`), `profile`, `faq`, dan `contact`.
        -   **`AuthController.php`**: Menangani semua proses yang berkaitan dengan autentikasi, seperti menampilkan form `login` dan memproses login/logout pengguna.
        -   **`ProdukController.php` & `ProdukCategoryController.php`**: Mengelola semua logika CRUD (Create, Read, Update, Delete) untuk data produk dan kategorinya.
        -   **`TransaksiController.php`**: Mengelola semua alur transaksi, mulai dari menambah item ke keranjang (`cart_add`), mengedit keranjang, hingga proses checkout dan menyimpan data transaksi ke database (`buy`).
        -   **`ApiController.php`**: Menyediakan endpoint webservice (API) untuk dikonsumsi oleh aplikasi lain (dalam kasus ini, Dashboard eksternal).
        -   `Admin/Diskon.php`: Sub-direktori yang menunjukkan implementasi *controller namespacing*. Controller ini khusus menangani logika CRUD untuk data diskon dan hanya bisa diakses oleh admin.

    -   `Models/`
        > Berisi kelas-kelas Model yang bertanggung jawab penuh atas interaksi dengan database. Model mengabstraksi query database, sehingga Controller tidak perlu menulis SQL secara langsung.
        -   **`ProductModel.php`**, **`TransactionModel.php`**, dll.: Masing-masing model merepresentasikan satu tabel di database. Mereka mendefinisikan nama tabel, primary key, dan kolom mana saja yang boleh diisi (`$allowedFields`).
        -   Di dalam `TransactionModel.php`, terdapat metode kustom `getTransaksiForApi()` yang melakukan `LEFT JOIN` untuk mengambil data transaksi beserta total jumlah itemnya.

    -   `Views/`
        > Berisi semua file yang membentuk antarmuka pengguna (User Interface). File-file ini umumnya berisi HTML yang disisipi dengan sedikit PHP untuk menampilkan data yang dikirim dari Controller.
        -   `layout.php`: File template utama yang berisi struktur dasar HTML (seperti `<head>`, `<body>`, header, sidebar, dan footer).
        -   `components/`: Direktori yang berisi bagian-bagian UI yang dapat digunakan kembali, seperti `header.php` dan `sidebar.php`.
        -   `v_home.php`, `v_produk.php`, `v_keranjang.php`, dll.: Masing-masing adalah view spesifik untuk menampilkan konten halaman tertentu.
        -   `admin/diskon/`: Sub-direktori yang menunjukkan pengorganisasian view berdasarkan role atau modul.

    -   `Database/`
        > Direktori ini mengelola semua yang berkaitan dengan struktur dan data awal database.
        -   `Migrations/`: Berisi file-file skema bernomor versi. Setiap file mendefinisikan cara membuat atau mengubah satu tabel di database. Ini memungkinkan struktur database untuk dilacak dan dibagikan dengan mudah.
        -   `Seeds/`: Berisi file-file untuk "menanam" data awal (seeding) ke dalam database setelah tabel dibuat. Berguna untuk mengisi data default seperti akun admin atau data dummy untuk pengujian.

    -   `Filters/`
        > Berisi kelas-kelas Filter yang berfungsi sebagai "penjaga gerbang". Filter dieksekusi sebelum atau sesudah sebuah Controller dijalankan.
        -   **`AuthFilter.php`**: Memeriksa apakah pengguna sudah login sebelum mengakses halaman yang dilindungi. Jika belum, pengguna akan "ditendang" ke halaman login.
        -   **`RedirectFilter.php`**: Mencegah pengguna yang sudah login untuk mengakses kembali halaman login atau register.

    -   `Config/`
        > Direktori konfigurasi inti CodeIgniter.
        -   **`Routes.php`**: File yang paling penting, berfungsi sebagai "peta" aplikasi. Ia mendefinisikan URL mana yang harus memanggil metode Controller mana. Di sini juga kita mendefinisikan grup rute untuk admin dan menerapkan filter.
        -   **`Autoload.php`**: Mengonfigurasi library atau helper apa yang akan dimuat secara otomatis di seluruh aplikasi.
        -   **`Filters.php`**: Mendaftarkan alias untuk kelas-kelas Filter agar bisa digunakan di `Routes.php`.

-   `public/`
    > Ini adalah satu-satunya direktori yang seharusnya dapat diakses secara publik melalui browser. Ia bertindak sebagai *document root*.
    -   `index.php`: File "pintu masuk" utama yang menerima semua permintaan HTTP dan memulai framework CodeIgniter.
    -   Aset seperti CSS, JavaScript, dan gambar juga ditempatkan di sini.
    -   `dashboard-toko/`: Sesuai instruksi UAS, folder ini berisi aplikasi Dashboard eksternal yang terpisah, membuktikan bahwa proyek "Toko" dapat menyediakan data melalui webservice-nya.

-   `.env`
    > File konfigurasi yang sangat krusial untuk lingkungan pengembangan. File ini **tidak boleh** di-commit ke repository Git karena berisi informasi sensitif seperti kredensial database, API Key, dan pengaturan spesifik untuk mesin lokal (`CI_ENVIRONMENT`, `app.baseURL`).
