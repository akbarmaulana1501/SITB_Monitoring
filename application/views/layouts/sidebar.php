<!-- SIDEBAR DENGAN AKSES MENU -->
<!-- <?php $akses = $this->session->userdata('akses_menu'); ?>
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav side-menu">
            <?php if (in_array(1, $akses)) : ?>
                <li><a href="<?= base_url() ?>dataController/data_terkirim"><i class="fa fa-edit"></i> Data Pasien</a></li>
            <?php endif; ?>

            <?php if (in_array(2, $akses)) : ?>
                <li><a><i class="fa fa-desktop"></i> Log Pengiriman <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="<?= base_url() ?>dataController/schedule_data">Terjadwal</a></li>
                        <li><a href="<?= base_url() ?>dataController/data_gagal">Manual</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if (in_array(3, $akses)) : ?>
                <li><a href="<?= base_url() ?>dataController/rekap_data"><i class="fa fa-file"></i> Rekap Data</a></li>
            <?php endif; ?>

            <?php if (in_array(4, $akses)) : ?>
                <li><a><i class="fa fa-bell"></i> Pemberitahuan Pasien <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="<?= base_url() ?>dataController/pemberitahuan_pasien2">Cek Laboratorium 2</a></li>
                        <li><a href="<?= base_url() ?>dataController/pemberitahuan_pasien3">Cek Laboratorium 3</a></li>
                        <li><a href="<?= base_url() ?>dataController/pemberitahuan_pasien4">Cek Laboratorium 4</a></li>
                        <li><a href="<?= base_url() ?>dataController/pemberitahuan_pasien6">Cek Laboratorium 6</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if (in_array(5, $akses)) : ?>
                <li><a href="<?= base_url() ?>dataController/access_control"><i class="fa fa-gear"></i> Akses Kontrol</a></li>
            <?php endif; ?>
            <li><a href="<?= base_url() ?>AdminController/kelola_user"><i class="fa fa-user-gear"></i> Kelola User</a></li>
        </ul>
    </div>
</div> -->

<!--SIDEBAR KOMPONEN -->
<?php $akses = $this->session->userdata('role'); ?>
<?php if ($akses == "PTB") : ?>
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <ul class="nav side-menu">
                <li><a href="<?= base_url() ?>AdminController/dashboard"><i class="fa fa-gauge"></i> Dashboard</a></li>
                <li><a href="<?= base_url() ?>DataController/data_terkirim"><i class="fa fa-database"></i> Data Pasien</a></li>
                <li><a><i class="fa fa-desktop"></i> Log Pengiriman <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="<?= base_url() ?>DataController/schedule_data">Terjadwal</a></li>
                        <li><a href="<?= base_url() ?>DataController/data_gagal">Manual</a></li>
                    </ul>
                </li>
                <li><a href="<?= base_url() ?>DataController/rekap_data"><i class="fa fa-file"></i> Rekap Data</a></li>
                <li><a><i class="fa fa-bell"></i> Notifikasi Pasien <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="<?= base_url() ?>DataController/pemberitahuan_pasien2">Cek Laboratorium 2</a></li>
                        <li><a href="<?= base_url() ?>DataController/pemberitahuan_pasien3">Cek Laboratorium 3</a></li>
                        <li><a href="<?= base_url() ?>DataController/pemberitahuan_pasien4">Cek Laboratorium 5</a></li>
                        <li><a href="<?= base_url() ?>DataController/pemberitahuan_pasien6">Cek Laboratorium 6</a></li>
                    </ul>
                </li>
                <?php $username = $this->session->userdata('username'); ?>
                <?php if ($username == "Nunik_tb") : ?>
                <!-- <li><a href="<?= base_url() ?>dataController/access_control"><i class="fa fa-gear"></i> Akses Kontrol</a></li> -->
                <li><a href="<?= base_url() ?>AdminController/kelola_user"><i class="fa fa-user-gear"></i> Kelola User</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
<?php elseif ($akses == "kperawat"): ?>
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <ul class="nav side-menu">
                <li><a href="<?= base_url() ?>PerawatController/dashboard"><i class="fa fa-gauge"></i> Dashboard</a></li>
                <li><a href="<?= base_url() ?>PerawatController/laporan"><i class="fa fa-database"></i> Data Pasien</a></li>
                <li><a href="<?= base_url() ?>PerawatController/rekap_data"><i class="fa fa-file"></i> Rekap Data</a></li>
            </ul>
        </div>
    </div>
<?php elseif ($akses == "direktur"): ?>
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <ul class="nav side-menu">
                <li><a href="<?= base_url() ?>DirekturController/dashboard"><i class="fa fa-gauge"></i> Dashboard</a></li>
                <li><a href="<?= base_url() ?>DirekturController/laporan_direktur"><i class="fa fa-database"></i> Data Pasien</a></li>
                <li><a href="<?= base_url() ?>DirekturController/rekap_data"><i class="fa fa-file"></i> Rekap Data</a></li>
            </ul>
        </div>
    </div>
<?php endif; ?>