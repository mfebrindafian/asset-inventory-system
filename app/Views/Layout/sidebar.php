<div class="sidebar-wrapper position-fixed active">
    <div class="sidebar-header position-relative">
        <div class="d-flex justify-content-between align-items-center">
            <div class="logo mt-4">
                <a href="#"><img src="<?= base_url('/assets/images/logo-sibamira.png') ?>" style="width: 222px; height: 100%" alt="Logo Sibamira" srcset="" /></a>
            </div>
            <div class="sidebar-toggler x">
                <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
            </div>
        </div>
    </div>
    <div class="sidebar-menu">
        <ul class="menu">
            <li class="sidebar-title">Menu</li>
            <?php $list_menu = session('list_menu') ?>
            <?php $angle = '#' ?>
            <?php $list_submenu = session('list_submenu') ?>
            <?php foreach ($list_menu as $list) : ?>
                <?php if ($list['is_active'] == 'Y' && $list['view_level'] == 'Y') : ?>
                    <li class="sidebar-item <?php if ($list['link'] == '#') {
                                                echo 'has-sub';
                                            } ?> <?= ($menu == $list['nama_menu']) ? 'active' : ''; ?>">
                        <a href="<?= base_url($list['link']); ?>" class="sidebar-link">
                            <i class="<?= $list['icon']; ?>"></i>
                            <span><?= $list['nama_menu']; ?></span>
                        </a>
                        <?php if ($list['link'] == '#') : ?>
                            <ul class="submenu <?= ($menu == $list['nama_menu']) ? 'active' : ''; ?>">
                                <?php foreach ($list_submenu as $sub) : ?>
                                    <?php if (($sub['menu_id'] == $list['id']) && $sub['is_active'] == 'Y' && $sub['view_level'] == 'Y') :  ?>
                                        <li class="submenu-item <?= ($subMenu == $sub['nama_submenu']) ? 'active' : '' ?>">
                                            <a href="<?= base_url($sub['link']); ?>"><?= $sub['nama_submenu']; ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>