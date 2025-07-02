<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transaction';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username', 'total_harga', 'alamat', 'ongkir', 'status', 'created_at', 'updated_at'
    ];

    public function getTransaksiForApi()
{
    return $this->select('transaction.*, SUM(transaction_detail.jumlah) as jumlah_item')
                ->join('transaction_detail', 'transaction_detail.transaction_id = transaction.id', 'left')
                ->groupBy('transaction.id')
                ->orderBy('transaction.created_at', 'DESC')
                ->findAll();
}

}