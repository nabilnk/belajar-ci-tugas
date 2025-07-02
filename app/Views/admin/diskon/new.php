<?= $this->extend('layout'); ?>

<?= $this->section('content'); ?>
<main id="main" class="main">
    <div class="pagetitle">
        <h1><?= $title; ?></h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Form Tambah Data Diskon</h5>
                        <form action="<?= base_url('admin/diskon'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="row mb-3">
                                <label for="tanggal" class="col-sm-3 col-form-label">Tanggal Diskon</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control <?= ($validation->hasError('tanggal')) ? 'is-invalid' : ''; ?>" id="tanggal" name="tanggal" value="<?= old('tanggal'); ?>">
                                    <div class="invalid-feedback"><?= $validation->getError('tanggal'); ?></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="nominal" class="col-sm-3 col-form-label">Nominal (Rp)</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control <?= ($validation->hasError('nominal')) ? 'is-invalid' : ''; ?>" id="nominal" name="nominal" value="<?= old('nominal'); ?>" placeholder="Contoh: 50000">
                                    <div class="invalid-feedback"><?= $validation->getError('nominal'); ?></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?= $this->endSection(); ?>