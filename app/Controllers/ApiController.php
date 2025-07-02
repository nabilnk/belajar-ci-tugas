<?php
// =========================================================================================
// FILE: app/Controllers/ApiController.php
// GANTI SEMUA ISI FILE DENGAN KODE LENGKAP DI BAWAH INI
// =========================================================================================

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class ApiController extends ResourceController
{
    // Tentukan model utama yang akan digunakan oleh controller ini
    protected $modelName = 'App\Models\TransactionModel';
    // Tentukan format output default
    protected $format    = 'json';

    /**
     * Metode ini akan dipanggil saat ada request GET ke /api
     * (Biarkan saja, mungkin digunakan untuk hal lain)
     */
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    /**
     * Endpoint khusus untuk laporan transaksi UAS
     * Mengembalikan daftar transaksi beserta jumlah total item per transaksi.
     */
    public function uasReport()
    {
        // Panggil method getTransaksiForApi() dari model yang sudah didefinisikan
        $data = $this->model->getTransaksiForApi();
        
        // Kembalikan data dalam format JSON
        return $this->respond($data, 200);
    }
}