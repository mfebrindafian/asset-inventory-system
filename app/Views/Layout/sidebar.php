<div class="sidebar-wrapper active">
    <div class="sidebar-header position-relative">
        <div class="d-flex justify-content-between align-items-center">
            <div class="logo mt-4">
                <a href="#"><img src="assets/images/logo-sibamira.png" style="width: 222px; height: 100%" alt="Logo Sibamira" srcset="" /></a>
            </div>
            <div class="sidebar-toggler x">
                <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
            </div>
        </div>
    </div>
    <div class="sidebar-menu">
        <ul class="menu">
            <li class="sidebar-title">Menu</li>

            <li class="sidebar-item <?= ($halaman == 'dashboard') ? 'active' : ''; ?>">
                <a href="<?= base_url('/dashboard-sibamira') ?>" class="sidebar-link">
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item <?= ($halaman == 'kki') ? 'active' : ''; ?>">
                <a href="<?= base_url('/list-kki'); ?>" class="sidebar-link">
                    <i class="bi bi-file-earmark-arrow-up-fill"></i>
                    <span>Import KKI</span>
                </a>
            </li>

            <li class="sidebar-item has-sub <?= ($halaman == 'pmnontik' || $halaman == 'pmtik' || $halaman == 'atl' || $halaman == 'atb' || $halaman == 'isikertaskerja') ? 'active' : ''; ?>">
                <a href="#" class="sidebar-link">
                    <i class="bi bi-boxes"></i>
                    <span>Inventarisasi</span>
                </a>
                <ul class="submenu <?= ($halaman == 'pmnontik' || $halaman == 'pmtik' || $halaman == 'atl' || $halaman == 'atb' || $halaman == 'isikertaskerja') ? 'active' : ''; ?>">
                    <li class="submenu-item <?= ($halaman == 'pmnontik') ? 'active' : ''; ?>">
                        <a href="<?= base_url('/inv-pmnontik') ?>">PM NON TIK</a>
                    </li>
                    <li class="submenu-item <?= ($halaman == 'pmtik') ? 'active' : ''; ?>">
                        <a href="<?= base_url('/inv-pmtik') ?>">PM TIK</a>
                    </li>
                    <li class="submenu-item <?= ($halaman == 'atb') ? 'active' : ''; ?>">
                        <a href="<?= base_url('/inv-atb') ?>">ATB</a>
                    </li>
                    <li class="submenu-item <?= ($halaman == 'atl') ? 'active' : ''; ?>">
                        <a href="<?= base_url('/inv-atl') ?>">ATL</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item has-sub <?= ($halaman == 'rekapitulasi' || $halaman == 'inventarisasi') ? 'active' : ''; ?>">
                <a href="#" class="sidebar-link">
                    <i class="bi bi-envelope-paper-fill"></i>
                    <span>Report</span>
                </a>
                <ul class="submenu <?= ($halaman == 'rekapitulasi' || $halaman == 'inventarisasi') ? 'active' : ''; ?>">
                    <li class="submenu-item <?= ($halaman == 'rekapitulasi') ? 'active' : ''; ?>">
                        <a href="<?= base_url('/report-rekapitulasi') ?>">Rekapitulasi</a>
                    </li>
                    <li class="submenu-item <?= ($halaman == 'inventarisasi') ? 'active' : ''; ?>">
                        <a href="<?= base_url('/report-inventarisasi') ?>">Inventarisasi</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item <?= ($halaman == 'detaillabel' || $halaman == 'carilabel') ? 'active' : ''; ?>">
                <a href="<?= base_url('/label') ?>" class="sidebar-link">
                    <i class="bi bi-printer-fill"></i>
                    <span>Cetak Label</span>
                </a>
            </li>

            <li class="sidebar-item has-sub">
                <a href="#" class="sidebar-link">
                    <i class="bi bi-stack"></i>
                    <span>Master Data</span>
                </a>
                <ul class="submenu">
                    <li class="submenu-item">
                        <a href="#">Gedung</a>
                    </li>
                    <li class="submenu-item">
                        <a href="#">Ruangan</a>
                    </li>
                    <li class="submenu-item">
                        <a href="#">Satker</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-title">Sistem</li>

            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <i class="bi bi-people-fill"></i>
                    <span>Role User</span>
                </a>
            </li>
        </ul>
    </div>
</div>