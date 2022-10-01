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
                <a href="dashboard.html" class="sidebar-link">
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="importkki.html" class="sidebar-link">
                    <i class="bi bi-file-earmark-arrow-up-fill"></i>
                    <span>Import KKI</span>
                </a>
            </li>

            <li class="sidebar-item has-sub">
                <a href="#" class="sidebar-link">
                    <i class="bi bi-boxes"></i>
                    <span>Inventarisasi</span>
                </a>
                <ul class="submenu">
                    <li class="submenu-item">
                        <a href="inventarisasi/pmnontik.html">PM NON TIK</a>
                    </li>
                    <li class="submenu-item">
                        <a href="inventarisasi/pmtik.html">PM TIK</a>
                    </li>
                    <li class="submenu-item">
                        <a href="inventarisasi/atb.html">ATB</a>
                    </li>
                    <li class="submenu-item">
                        <a href="inventarisasi/atl.html">ATL</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item has-sub">
                <a href="#" class="sidebar-link">
                    <i class="bi bi-envelope-paper-fill"></i>
                    <span>Report</span>
                </a>
                <ul class="submenu">
                    <li class="submenu-item">
                        <a href="report/rekapitulasi.html">Rekapitulasi</a>
                    </li>
                    <li class="submenu-item">
                        <a href="report/inventarisasi.html">Inventarisasi</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a href="cetaklabel.html" class="sidebar-link">
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
                        <a href="masterdata/gedung.html">Gedung</a>
                    </li>
                    <li class="submenu-item">
                        <a href="masterdata/ruangan.html">Ruangan</a>
                    </li>
                    <li class="submenu-item">
                        <a href="masterdata/satker.html">Satker</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-title">Sistem</li>

            <li class="sidebar-item">
                <a href="roleuser.html" class="sidebar-link">
                    <i class="bi bi-people-fill"></i>
                    <span>Role User</span>
                </a>
            </li>
        </ul>
    </div>
</div>