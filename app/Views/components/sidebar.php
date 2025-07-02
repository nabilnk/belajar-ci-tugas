<nav id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link <?= (!isset($menu_aktif) || $menu_aktif == 'dashboard') ? '' : 'collapsed' ?>" href="<?= base_url('/') ?>">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link <?= (isset($menu_aktif) && $menu_aktif == 'keranjang') ? '' : 'collapsed' ?>" href="<?= base_url('keranjang') ?>">
                <i class="bi bi-cart-fill"></i>
                <span>Keranjang</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= (isset($menu_aktif) && $menu_aktif == 'profile') ? '' : 'collapsed' ?>" href="<?= base_url('profile') ?>">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= (isset($menu_aktif) && $menu_aktif == 'produk') ? '' : 'collapsed' ?>" href="<?= base_url('produk') ?>">
                <i class="bi bi-box-seam-fill"></i>
                <span>Produk</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= (isset($menu_aktif) && $menu_aktif == 'produkkategori') ? '' : 'collapsed' ?>" href="<?= base_url('produkkategori') ?>">
                <i class="bi bi-bookmark-fill"></i>
                <span>Produk Kategori</span>
            </a>
        </li>

        <?php if (session()->get('role') == 'admin') : ?>
        <li class="nav-item">
            <a class="nav-link <?= (isset($menu_aktif) && $menu_aktif == 'diskon') ? '' : 'collapsed' ?>" href="<?= base_url('admin/diskon') ?>">
                <i class="bi bi-tags-fill"></i>
                <span>Diskon</span>
            </a>
        </li>
        <?php endif; ?>
        

        <li class="nav-item">
            <a class="nav-link <?= (isset($menu_aktif) && $menu_aktif == 'faq') ? '' : 'collapsed' ?>" href="<?= base_url('faq') ?>">
                <i class="bi bi-question-circle"></i>
                <span>F.A.Q</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= (isset($menu_aktif) && $menu_aktif == 'contact') ? '' : 'collapsed' ?>" href="<?= base_url('contact') ?>">
                <i class="bi bi-envelope"></i>
                <span>Contact</span>
            </a>
        </li>

    </ul>

        </nav><!-- End Sidebar-->