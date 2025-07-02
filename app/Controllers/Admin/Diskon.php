<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DiskonModel;

class Diskon extends BaseController
{
    protected $diskonModel;

    public function __construct()
    {
        $this->diskonModel = new DiskonModel();
    }

    public function index()
    {
        $data = [
            'title'      => 'Diskon',
            'diskon'     => $this->diskonModel->orderBy('tanggal', 'DESC')->findAll(),
            'menu_aktif' => 'diskon',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/diskon/index', $data);
    }

    public function create()
    {
        $rules = [
            'tanggal' => 'required|is_unique[diskon.tanggal]',
            'nominal' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('failed', $this->validator->listErrors());
            return redirect()->to(base_url('admin/diskon'))->withInput();
        }

        $this->diskonModel->save([
            'tanggal' => $this->request->getVar('tanggal'),
            'nominal' => $this->request->getVar('nominal'),
        ]);

        session()->setFlashdata('success', 'Data diskon berhasil ditambahkan.');
        return redirect()->to(base_url('admin/diskon'));
    }
    
    public function update($id = null)
    {
        if (!$this->validate(['nominal' => 'required|numeric'])) {
            session()->setFlashdata('failed', $this->validator->listErrors());
            return redirect()->to(base_url('admin/diskon'))->withInput();
        }

        $this->diskonModel->update($id, [
            'nominal' => $this->request->getVar('nominal'),
        ]);

        session()->setFlashdata('success', 'Data diskon berhasil diubah.');
        return redirect()->to(base_url('admin/diskon'));
    }

    public function delete($id = null)
    {
        $this->diskonModel->delete($id);
        session()->setFlashdata('success', 'Data diskon berhasil dihapus.');
        return redirect()->to(base_url('admin/diskon'));
    }
}