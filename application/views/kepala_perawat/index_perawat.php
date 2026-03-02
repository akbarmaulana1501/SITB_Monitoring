<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php base_url() ?>../resources/template/production/images/logoIHC.png" type="image/ico" />

    <title> BOS - SITB Monitoring</title>

    <!-- Bootstrap -->
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
                        <a href="<?= base_url() ?>./PerawatController/dashboard" class="site_title"><img src="<?= base_url() ?>./resources/template/production/images/logoIHC.png" alt="" width="25%"><span> SIM TBC</span></a>
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
                    <?php $this->load->view('layouts/user'); ?>
                </div>
            </div>
            <?php $this->load->view('layouts/modals'); ?>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="row">
                    <div class="col-md-4 col-sm-4 ">
                        <div class="x_panel">
                            <p class="text-center items-align-center">Jumlah Pasien Aktif:</p>
                            <h4 class="text-center items-align-center"><?= $pasien_active; ?></h4>
                            <p class="text-center items-align-center">Pasien</p>
                            <div class="text-center items-align-center">
                                <a href="<?= base_url('PerawatController/laporan?status=active'); ?>" class="btn btn-sm btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 ">
                        <div class="x_panel">
                            <p class="text-center">Selesai Pengobatan:</p>
                            <h4 class="text-center items-align-center"><?= $pasien_selesai; ?></h4>
                            <p class="text-center items-align-center">Pasien</p>
                            <div class="text-center items-align-center">
                                <a href="<?= base_url('PerawatController/laporan?status=finished'); ?>" class="btn btn-sm btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 ">
                        <div class="x_panel">
                            <p class="text-center">Putus Berobat:</p>
                            <h4 class="text-center items-align-center"><?= $pasien_berhenti; ?></h4>
                            <p class="text-center items-align-center">Pasien</p>
                            <div class="text-center items-align-center">
                                <a href="<?= base_url('PerawatController/laporan?status=canceled'); ?>" class="btn btn-sm btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><i class="fa fa-circle-info"></i> Notifikasi Pengobatan</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <?php foreach ($notifikasi_pengobatan as $notif): ?>
                                    <?php
                                    $tanggal = date('Y-m-d', strtotime($notif->issued)); // pastikan field 'tanggal' ada
                                    $bulan = date('F', strtotime($tanggal)); // Misalnya April
                                    $hari = date('d', strtotime($tanggal));  // Misalnya 23
                                    ?>
                                    <article class="media event mb-3">
                                        <a class="pull-left date">
                                            <p class="month"><?= $bulan ?></p>
                                            <p class="day"><?= $hari ?></p>
                                        </a>
                                        <div class="media-body">
                                            <p><strong><?= $notif->patient_name ?? 'Nama Tidak Ada' ?></strong></p>
                                            <p> Pengobatan Episode <?= $notif->episode_number ?? 'Episode pengobatan tidak ada' ?></p>
                                        </div>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2><i class="fa fa-clock"></i> Aktivitas Pasien Terbaru</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="card-box table-responsive">
                                    <table id="datatable-buttons" class="table table-striped table-bordered" style="width:98%">
                                        <thead>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Status Berobat</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Selesai</th>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($pasien_terbaru)) : ?>
                                                <?php $no = 1; ?>
                                                <?php foreach ($pasien_terbaru as $row) : ?>
                                                    <tr>
                                                        <td><?php echo $no++; ?></td>
                                                        <td><?php echo $row->patient_name; ?></td>
                                                        <td>
                                                            <?php
                                                            $status = $row->episode_of_care_status;

                                                            if ($status == 'finished') {
                                                                $badgeClass = 'badge-success';
                                                            } elseif ($status == 'active') {
                                                                $badgeClass = 'badge-warning';
                                                            } elseif ($status == 'canceled') {
                                                                $badgeClass = 'badge-danger'; // default jika bukan keduanya
                                                            }
                                                            ?>
                                                            <p class="badge <?= $badgeClass; ?>"><?= ucfirst($status); ?></p>
                                                        </td>
                                                        <td><?php echo $row->episode_of_care_period_start; ?></td>
                                                        <td>
                                                            <?php
                                                            if ($row->episode_of_care_status == 'canceled' || $row->episode_of_care_status == 'finished') {
                                                                echo $row->period_end;
                                                            } else {
                                                                echo '----';
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="3" style="text-align:center;">Data tidak ditemukan</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
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
        $(document).ready(function() {
            // Pastikan untuk menghancurkan instance sebelumnya jika sudah ada
            if ($.fn.DataTable.isDataTable('#datatable-buttons')) {
                $('#datatable-buttons').DataTable().destroy();
            }

            // Inisialisasi DataTable
            $('#datatable-buttons').DataTable({
                responsive: true,
                pageLength: 5, // Menampilkan 5 data per halaman
                lengthMenu: [5, 10, 25, 50, 100] // Opsi jumlah data per halaman
            });
        });

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
    </script>

</body>

</html>