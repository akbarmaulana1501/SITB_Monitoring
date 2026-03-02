<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?= base_url() ?>./resources/template/production/images/logoIHC.png" type="image/ico" />

    <title> BOS - SITB Monitoring</title>

    <?php $this->load->view('layouts/style') ?>
</head>
<style>
    .navbar.nav_title img {
        width: 25% !important;
        /* Ensures the logo remains at 25% width */
    }

    .left_col .nav_title {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        /* Ensures the container doesn’t shrink */
        padding: 10px 0;
    }

    .left_col {
        transition: width 0.5s ease;
        /* Optional: smooth transition effect for sidebar */
    }

    body.nav-sm .left_col {
        width: 70px;
        /* Adjust this width according to your sidebar's collapsed state */
    }

    body.nav-sm .navbar.nav_title img {
        width: 60% !important;
        margin: 8px;
        /* Ensure the logo maintains its size even in collapsed state */
    }
</style>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col menu_fixed">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="<?= base_url() ?>./AdminController" class="site_title"><img src="<?= base_url() ?>./resources/template/production/images/logoIHC.png" alt="" width="25%"><span> SIM TBC</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <?php $this->load->view('layouts/sidebar'); ?>
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                    <img src="<?= base_url() ?>./resources/template/production/images/user.png" alt="">Hai,<?php echo $this->session->userdata('username'); ?>
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                                    <!-- <a class="dropdown-item" href="javascript:;"> Edit Profile</a> -->
                                    <a class="dropdown-item" href="javascript:;" onclick="edit_password()"><i class="fa fa-gear pull-right"></i> Edit Password</a>
                                    <!-- <a class="dropdown-item" href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                    </a> -->
                                    <!-- <a class="dropdown-item" href="javascript:;">Help</a> -->
                                    <a class="dropdown-item" href="<?php echo base_url('LoginController/logout'); ?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <?php $this->load->view('layouts/modals'); ?>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <!-- top tiles -->

                <!-- /top tiles -->


                <div class="row justify-content-left">
                    <div class="col-md-6 col-sm-12">
                        <div class="x_panel p-4">
                            <h6 class="mb-3">Laporan Rekap TBC</h6>
                            <hr>
                            <form action="<?= base_url() ?>DataController/filter_data" method="post">
                                <!-- Input tanggal mulai -->
                                <div class="mb-3">
                                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai:</label>
                                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?= isset($tanggal_mulai) ? $tanggal_mulai : '' ?>">
                                </div>
                                <!-- Input tanggal akhir -->
                                <div class="mb-3">
                                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir:</label>
                                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?= isset($tanggal_akhir) ? $tanggal_akhir : '' ?>">
                                </div>
                                <!-- Dropdown Pilih Data -->
                                <div class="mb-3">
                                    <label for="tipe_file" class="form-label">Pilih Data:</label>
                                    <select class="form-control" id="tipe_file" name="tipe_file">
                                        <option value="" disabled <?= !isset($tipe_file) ? 'selected' : '' ?>>Pilih Data</option>
                                        <option value="data_tbc" <?= isset($tipe_file) && $tipe_file == 'data_tbc' ? 'selected' : '' ?>>Data Pasien TBC</option>
                                        <option value="data_terkirim" <?= isset($tipe_file) && $tipe_file == 'data_terkirim' ? 'selected' : '' ?>>Data Terkirim</option>
                                    </select>
                                </div>
                                <!-- Tombol Export -->
                                <button class="btn btn-success">Tampilkan</button>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="row justify-content-left">
                    <div class="col-md-12 col-sm-12">
                        <div class="x_panel p-4">
                            <h6 class="mb-3">Tampilan Filter Data</h6>
                            <hr>
                            <?php if (isset($filtered) && $filtered): ?>
                                <?php if (!empty($hasil)): ?>
                                    <div class="table-responsive" style="max-height:700px; overflow-x:auto;">
                                        <table id="datatable-buttons" class="table table-striped table-bordered" style="width:95%">
                                            <thead>
                                                <?php if ($tipe_file == "data_tbc"): ?>
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th class="text-center">Nama Pasien</th>
                                                        <th class="text-center">Tanggal Mulai</th>
                                                        <th class="text-center">Tanggal Akhir</th>
                                                        <th class="text-center">Status</th>
                                                    </tr>
                                                <?php elseif ($tipe_file == "data_terkirim"): ?>
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th class="text-center">ID TB</th>
                                                        <th class="text-center">ID Pelayanan</th>
                                                        <th class="text-center">Status</th>
                                                        <th class="text-center">Tanggal Kirim</th>
                                                    </tr>
                                                <?php endif; ?>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; ?>
                                                <?php foreach ($hasil as $row): ?>
                                                    <tr>
                                                        <td class="text-center"><?= $no++; ?></td>

                                                        <?php if ($tipe_file == 'data_tbc'): ?>
                                                            <td class="text-center"><?= $row->patient_name ?></td>
                                                            <td class="text-center"><?= $row->episode_of_care_period_start ?></td>
                                                            <td class="text-center">
                                                                <?php
                                                                if ($row->episode_of_care_status == 'canceled' || $row->episode_of_care_status == 'finished') {
                                                                    echo $row->period_end;
                                                                } else {
                                                                    echo '----';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <?php
                                                                $status = $row->episode_of_care_status;
                                                                if ($status == 'finished') {
                                                                    $badgeClass = 'badge-success';
                                                                } elseif ($status == 'active') {
                                                                    $badgeClass = 'badge-warning';
                                                                } elseif ($status == 'canceled') {
                                                                    $badgeClass = 'badge-danger';
                                                                } else {
                                                                    $badgeClass = 'badge-secondary';
                                                                }
                                                                ?>
                                                                <p class="badge <?= $badgeClass; ?>"><?= ucfirst($status); ?></p>
                                                            </td>

                                                        <?php elseif ($tipe_file == 'data_terkirim'): ?>
                                                            <td class="text-center"><?= $row->id_tb ?></td>
                                                            <td class="text-center"><?= $row->id_pelayanan ?></td>
                                                            <td class="text-center">
                                                                <span class="badge badge-info"><?= ucfirst($row->status) ?></span>
                                                            </td>
                                                            <td class="text-center"><?= $row->tanggal ?></td>
                                                        <?php endif; ?>

                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>

                                        </table>
                                    </div>
                                    <!-- Tombol cetak -->
                                    <form method="post" action="<?= base_url('DataController/extract_data') ?>">
                                        <input type="hidden" name="tanggal_mulai" value="<?= $tanggal_mulai ?>">
                                        <input type="hidden" name="tanggal_akhir" value="<?= $tanggal_akhir ?>">
                                        <input type="hidden" name="tipe_file" value="<?= $tipe_file ?>">
                                        <button class="btn btn-success w-100 mt-3"><i class="fa fa-file"></i> Cetak ke Excel</button>
                                    </form>
                                <?php else: ?>
                                    <div class="alert alert-warning" role="alert">
                                        Data tidak ada untuk filter yang dipilih.
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <button class="btn btn-secondary w-100" disabled>Silakan filter laporan terlebih dahulu</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /page content -->

            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    2024 © Development by Akbar Maulana
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>

    <!-- jQuery -->
    <?php $this->load->view('layouts/script') ?>
    <script>
        function edit_password() {
            $('#edit_password').modal('show');
        }

        function close_modal() {
            document.getElementById('pass_baru').value = ''; // Kosongkan input password
            document.getElementById('pass_baru').type = 'password';
            $('#edit_password').modal('hide');
        }

        function togglePassword() {
            const passwordField = document.getElementById("pass_baru");
            const icon = document.getElementById("iconPass");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }

        function Simpan_password() {
            var pass_baru = $('#pass_baru').val();
            var nama = "<?php echo $this->session->userdata('username'); ?>";
            var email = $('#email').val();

            if (pass_baru === "") {
                Swal.fire({
                    icon: "warning",
                    title: "Peringatan",
                    text: "Password baru tidak boleh kosong!"
                });
                return; // Hentikan proses
            }

            if (pass_baru.length < 6) {
                Swal.fire({
                    icon: "warning",
                    title: "Peringatan",
                    text: "Password tidak boleh kurang dari 6 karakter!"
                });
                return; // Hentikan proses
            }
            $.ajax({
                url: '<?= base_url("LoginController/update_password") ?>', // Replace with your actual update endpoint
                type: 'POST',
                data: {
                    pass_baru: pass_baru,
                    nama: nama,
                    email: email
                },
                success: function(response) {
                    // Handle the response from the server
                    if (response.status == "success") {
                        Swal.fire({
                            title: "Success!",
                            text: "Password berhasil di update!",
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirect setelah user menekan OK pada Swal
                                $('#edit_password').modal('hide');
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: 'Gagal memperbarui Password!'
                        });
                        // Optionally log the error message for debugging
                        console.error('Failed to update data: ' + response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!"
                    });
                    // Optionally log the error message for debugging
                    console.error('An error occurred: ' + textStatus);
                }
            });
        }


        function ekstrak_data() {
            var mulai = $('#tanggal_mulai').val();
            var selesai = $('#tanggal_akhir').val();
            var jenis = $('#tipe_file').val();

            $.ajax({
                url: '<?= base_url("DataController/extract_data") ?>', // Replace with your actual update endpoint
                type: 'POST',
                data: {
                    mulai: mulai,
                    selesai: selesai,
                    jenis: jenis
                },
                success: function(response) {
                    // Handle the response from the server
                    if (response.status == "success") {
                        Swal.fire({
                            title: "Success!",
                            text: "Data berhasil di rekap!",
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirect setelah user menekan OK pada Swal
                                $('#edit_password').modal('hide');
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: 'Gagal Rekap Data!'
                        });
                        // Optionally log the error message for debugging
                        console.error('Failed to update data: ' + response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Ada Kesalahan Hubungi Admin!"
                    });
                    // Optionally log the error message for debugging
                    console.error('An error occurred: ' + textStatus);
                }
            });
        }
    </script>
    <script>
        const tanggalMulai = document.getElementById('tanggal_mulai');
        const tanggalAkhir = document.getElementById('tanggal_akhir');

        // Set min tanggal akhir saat halaman load sesuai tanggal mulai
        tanggalAkhir.min = tanggalMulai.value;

        // Update min tanggal akhir setiap tanggal mulai berubah
        tanggalMulai.addEventListener('change', () => {
            if (tanggalMulai.value > tanggalAkhir.value) {
                tanggalAkhir.value = tanggalMulai.value; // agar tanggal akhir otomatis ikut jika lebih kecil
            }
            tanggalAkhir.min = tanggalMulai.value;
        });
    </script>

</body>

</html>