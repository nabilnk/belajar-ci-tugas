<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductCategoryModel;

class ProdukCategoryController extends BaseController
{
    protected $category;

    function __construct()
    {
        $this->category = new ProductCategoryModel();
    }

    public function index()
    {
        $categories = $this->category->findAll();
        $data['categories'] = $categories;

        return view('v_produkkategori', $data);
    }

    public function create()
    {
        $dataForm = [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'created_at' => date("Y-m-d H:i:s")
        ];

        $this->category->insert($dataForm);

        return redirect('produkkategori')->with('success', 'Kategori Berhasil Ditambah');
    }

    public function edit($id)
    {
        $dataForm = [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'updated_at' => date("Y-m-d H:i:s")
        ];

        $this->category->update($id, $dataForm);

        return redirect('produkkategori')->with('success', 'Kategori Berhasil Diubah');
    }

    public function delete($id)
    {
        $this->category->delete($id);

        return redirect('produkkategori')->with('success', 'Kategori Berhasil Dihapus');
    }
}