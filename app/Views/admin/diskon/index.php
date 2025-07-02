<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php
if (session()->getFlashData('success')) {
?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}

if (session()->getFlashData('failed')) {
?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('failed') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>

<!-- Tombol Tambah Data -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
    Tambah Data Diskon
</button>

<!-- Tabel Data Diskon -->
<table class="table datatable">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Nominal Diskon</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>

<tbody>
    <?php foreach ($diskon as $index => $d) : ?>
        <tr>
            <th scope="row"><?= $index + 1 ?></th>
            <td><?= date('d F Y', strtotime($d['tanggal'])) ?></td>
            <td><?= number_to_currency($d['nominal'], 'IDR', 'id_ID', 0) ?></td>
            <td>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal-<?= $d['id'] ?>">
                    Ubah
                </button>
                <form action="<?= base_url('admin/diskon/' . $d['id']) ?>" method="post" class="d-inline">
                    <?= csrf_field(); ?>
                    <!-- Baris ini "memalsukan" request POST menjadi DELETE -->
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin hapus data ini?')">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>

        <!-- Edit Modal untuk setiap data -->
        <div class="modal fade" id="editModal-<?= $d['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data Diskon</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?= base_url('admin/diskon/' . $d['id']) ?>" method="post">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="_method" value="PUT">
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" id="tanggal" value="<?= $d['tanggal'] ?>" readonly>
                                <small class="text-muted">Tanggal tidak dapat diubah.</small>
                            </div>
                            <div class="form-group">
                                <label for="name">Nominal (Rp)</label>
                                <input type="number" name="nominal" class="form-control" id="nominal" value="<?= $d['nominal'] ?>" placeholder="Contoh: 50000" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Edit Modal -->

    <?php endforeach ?>
</tbody>
</table>
<!-- End Table --> 

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Diskon Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/diskon') ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="name">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" id="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Nominal (Rp)</label>
                        <input type="number" name="nominal" class="form-control" id="nominal" placeholder="Contoh: 50000" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Add Modal -->

<?= $this->endSection() ?>