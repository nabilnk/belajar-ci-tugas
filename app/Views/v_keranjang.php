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
?>

<?php echo form_open('keranjang/edit') ?>

<?php if (empty($items)) : ?>
    <div class="alert alert-info mt-3" role="alert">
        Keranjang belanja Anda masih kosong.
    </div>
<?php else : ?>
    <table class="table datatable">
        <thead>
            <tr>
                <th scope="col">Nama</th>
                <th scope="col">Foto</th>
                <th scope="col">Harga</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item) : ?>
                <tr>
                    <!-- Kirim rowid sebagai array -->
                    <input type="hidden" name="rowid[]" value="<?= $item['rowid'] ?>">

                    <td><?= $item['name'] ?></td>
                    <td>
                        <!-- Pengecekan aman untuk foto -->
                        <?php if (isset($item['options']['foto'])) : ?>
                            <img src="<?= base_url('img/' . $item['options']['foto']) ?>" width="100px">
                        <?php endif; ?>
                    </td>
                    <td><?= number_to_currency($item['price'], 'IDR', 'id_ID', 0) ?></td>
                    <td>
                        <input type="number" min="1" name="qty[]" class="form-control" value="<?= $item['qty'] ?>">
                    </td>
                    <td><?= number_to_currency($item['subtotal'], 'IDR', 'id_ID', 0) ?></td>
                    <td>
                        <a href="<?= base_url('keranjang/delete/' . $item['rowid']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus item ini?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <hr>
    <div class="d-flex justify-content-between align-items-center">
        <h4>Total = <?= number_to_currency($total, 'IDR', 'id_ID', 0) ?></h4>
        <div>
            <button type="submit" class="btn btn-primary">Perbarui Keranjang</button>
            <a class="btn btn-warning" href="<?= base_url('keranjang/clear') ?>" onclick="return confirm('Yakin kosongkan keranjang?')">Kosongkan Keranjang</a>
            <a class="btn btn-success" href="<?= base_url('checkout') ?>">Selesai Belanja</a>
        </div>
    </div>
<?php endif; ?>

<?php echo form_close() ?>
<?= $this->endSection() ?>