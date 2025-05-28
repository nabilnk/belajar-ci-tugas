<?= $this->extend('layout') ?>
<?= $this->section('content') ?> 

<?php 
if (session()->getFlashData('success')){
 ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php 
}
?>
<?php 
if (session()->getFlashData('failed')) {
?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('failed') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
    Tambah Kategori
</button>

<!-- Table with stripped rows -->
<table class="table datatable mt-3">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nama Kategori</th>
            <th scope="col">Deskripsi</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $index => $kategori) : ?>
            <tr>
                <th scope="row"><?= $index + 1 ?></th>
                <td><?= esc($kategori['nama_kategori']) ?></td>
                <td><?= esc($kategori['deskripsi']) ?></td>
                <td>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal-<?= $kategori['id'] ?>">
                        Ubah
                    </button>
                    <a href="<?= base_url('produkkategori/delete/' . $kategori['id']) ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus kategori ini ?')">
                        Hapus
                    </a>
                </td>
            </tr>

            <!-- Edit Modal Begin -->
            <div class="modal fade" id="editModal-<?= $kategori['id'] ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Kategori</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('produkkategori/edit/' . $kategori['id']) ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nama_kategori">Nama Kategori</label>
                                    <input type="text" name="nama_kategori" class="form-control" id="nama_kategori" value="<?= esc($kategori['nama_kategori']) ?>" required>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" id="deskripsi" required><?= esc($kategori['deskripsi']) ?></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Edit Modal End -->
        <?php endforeach ?>
    </tbody>
</table>
<!-- End Table with stripped rows --> 

<!-- Add Modal Begin -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('produkkategori') ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control" id="nama_kategori" placeholder="Nama Kategori" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Deskripsi Kategori" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Modal End -->
<?= $this->endSection() ?>
