<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\ProductModel;

class TransaksiController extends BaseController
{
    protected $cart;
    protected $client;
    protected $apiKey;
    protected $transaction;
    protected $transaction_detail;

    function __construct()
    {
        helper('number');
        helper('form');
        $this->cart = \Config\Services::cart();
        $this->client = new \GuzzleHttp\Client();
        $this->apiKey = env('COST_KEY');
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();
    }

    public function index()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();
        $data['menu_aktif'] = 'keranjang';
        return view('v_keranjang', $data);
    }


    public function cart_add()
{
    $id_produk = $this->request->getPost('id');
    $produkModel = new \App\Models\ProductModel();
    $produk = $produkModel->find($id_produk);

    if ($produk) {
        $diskon = session()->get('diskon') ?? 0;
        
        $harga_setelah_diskon = $produk['harga'] - $diskon;
        $harga_setelah_diskon = max(0, $harga_setelah_diskon); 

        $this->cart->insert([
            'id'      => $produk['id'],
            'qty'     => 1,
            'price'   => $harga_setelah_diskon,
            'name'    => $produk['nama'],
            'options' => [
                'foto'       => $produk['foto'],
                'harga_asli' => $produk['harga'] 
            ]
        ]);
        
        session()->setFlashdata('success', 'Produk berhasil ditambahkan ke keranjang.');
    } else {
        session()->setFlashdata('failed', 'Produk tidak ditemukan.');
    }
    return redirect()->to(base_url('keranjang'));
}


    public function cart_clear()
    {
        $this->cart->destroy();
        session()->setflashdata('success', 'Keranjang Berhasil Dikosongkan');
        return redirect()->to(base_url('keranjang'));
    }



    public function cart_edit()
{
    $cartData = $this->request->getPost();
    $data_update = [];

    if (!empty($cartData['rowid'])) {
        for ($i = 0; $i < count($cartData['rowid']); $i++) {
            $data_update[] = [
                'rowid' => $cartData['rowid'][$i],
                'qty'   => $cartData['qty'][$i]
            ];
        }
        $this->cart->update($data_update);
        
        session()->setFlashdata('success', 'Keranjang Berhasil Diperbarui');
    } else {
        session()->setFlashdata('failed', 'Tidak ada data untuk diperbarui.');
    }

    return redirect()->to(base_url('keranjang'));
}


    public function cart_delete($rowid)
    {
        $this->cart->remove($rowid);
        session()->setflashdata('success', 'Keranjang Berhasil Dihapus');
        return redirect()->to(base_url('keranjang'));
    }

     public function checkout()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();

        return view('v_checkout', $data);
    }

        public function getLocation()
    {
        $search = $this->request->getGet('search');

        $response = $this->client->request(
            'GET', 
            'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search='.$search.'&limit=50', [
                'headers' => [
                    'accept' => 'application/json',
                    'key' => $this->apiKey,
                ],
            ]
        );

        $body = json_decode($response->getBody(), true); 
        return $this->response->setJSON($body['data']);
    }

    public function getCost()
    { 
        $destination = $this->request->getGet('destination');

        $response = $this->client->request(
            'POST', 
            'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
                'multipart' => [
                    [
                        'name' => 'origin',
                        'contents' => '64999'
                    ],
                    [
                        'name' => 'destination',
                        'contents' => $destination
                    ],
                    [
                        'name' => 'weight',
                        'contents' => '1000'
                    ],
                    [
                        'name' => 'courier',
                        'contents' => 'jne'
                    ]
                ],
                'headers' => [
                    'accept' => 'application/json',
                    'key' => $this->apiKey,
                ],
            ]
        );

        $body = json_decode($response->getBody(), true); 
        return $this->response->setJSON($body['data']);
    }


    public function buy()
    {
        if ($this->request->getPost()) { 
            $dataForm = [
                'username' => $this->request->getPost('username'),
                'total_harga' => $this->request->getPost('total_harga'),
                'alamat' => $this->request->getPost('alamat'),
                'ongkir' => $this->request->getPost('ongkir'),
                'status' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];
            $this->transaction->insert($dataForm);
            $last_insert_id = $this->transaction->getInsertID();

            foreach ($this->cart->contents() as $value) {
                // Hitung diskon yang didapat untuk item ini
                $harga_asli = $value['options']['harga_asli'] ?? $value['price'];
                $diskon_per_item = $harga_asli - $value['price'];

                $dataFormDetail = [
                    'transaction_id' => $last_insert_id,
                    'product_id' => $value['id'],
                    'jumlah' => $value['qty'],
                    'diskon' => $diskon_per_item, // <-- PERBAIKAN: Catat diskonnya
                    'subtotal_harga' => $value['qty'] * $value['price'],
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ];
                $this->transaction_detail->insert($dataFormDetail);
            }
            $this->cart->destroy();
            session()->setFlashdata('success', 'Transaksi berhasil!');
            return redirect()->to(base_url('profile'));
        }
    }
}
