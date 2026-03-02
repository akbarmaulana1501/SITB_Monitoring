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

    <!-- Bootstrap -->
    <link href="<?= base_url() ?>./resources/template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= base_url() ?>./resources/template/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css"> -->
    <!-- NProgress -->
    <link href="<?= base_url() ?>./resources/template/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?= base_url() ?>./resources/template/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="<?= base_url() ?>./resources/template/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?= base_url() ?>./resources/template/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="<?= base_url() ?>./resources/template/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?= base_url() ?>./resources/template/build/css/custom.min.css" rel="stylesheet">
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
                    <?php $akses = $this->session->userdata('akses_menu'); ?>
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
                    </div>
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
            <div class="modal fade" id="edit_password" tabindex="-1" aria-labelledby="edit_password" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="edit_password">Edit Password</h5>
                            <button type="button" class="btn btn-danger" onclick="close_modal()" data-bs-dismiss="modal" aria-label="Close">x</button>
                        </div>
                        <div class="modal-body">
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="modal_observ_id">Password</label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="password" id="pass_baru" name="pass_baru" required="required" class="form-control">
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="show_pass"></label>
                                <div class="col-md-6 col-sm-6">
                                    <input type="checkbox" id="show_pass" onclick="togglePassword()"> Show Password
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success" onclick="Simpan_password()"><i class="fa fa-download"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <!-- top tiles -->

                <!-- /top tiles -->


                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><i class="fa fa-gear"></i> Akses kontrol</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="">
                                <div class="col-sm-12">
                                    <div class="card-box table-responsive">
                                        <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
                                            <form id="form-akses" action="<?= base_url('DataController/update') ?>" method="post">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="2" style="text-align: center; vertical-align: middle;">#</th>
                                                        <th rowspan="2" class="text-center" style="text-align: center; vertical-align: middle;">Username</th>
                                                        <th rowspan="2" class="text-center" style="text-align: center; vertical-align: middle;">Role</th>
                                                        <th colspan="<?= count($menu) ?>" class="text-center">Hak Akses Menu</th>
                                                    </tr>
                                                    <tr>
                                                        <?php foreach ($menu as $menus):
                                                            // Tentukan header sesuai nama menu
                                                            if ($menus['nama_menu'] == "rekap_data") {
                                                                $header = "Rekap Data";
                                                            } else if ($menus['nama_menu'] == "data_pasien") {
                                                                $header = "Data Pasien";
                                                            } else if ($menus['nama_menu'] == "log_pengiriman") {
                                                                $header = "Log Pengiriman";
                                                            } else if ($menus['nama_menu'] == "pemberitahuan_pasien") {
                                                                $header = "Pemberitahuan Pasien";
                                                            } else if ($menus['nama_menu'] == "akses_kontrol") {
                                                                $header = "Akses Kontrol";
                                                            } else {
                                                                $header = ucfirst($menus['nama_menu']); // fallback ke nama_menu dalam format ucfirst
                                                            }
                                                        ?>
                                                            <th class="text-center"><?= htmlspecialchars($header) ?></th>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($user)) : ?>
                                                        <?php $no = 1; ?>
                                                        <?php foreach ($user as $row) : ?>
                                                            <tr>
                                                                <td class="text-center align-middle"><?= $no++; ?></td>
                                                                <td class="text-center align-middle"><?= htmlspecialchars($row->username); ?></td>
                                                                <td class="text-center align-middle"><?= htmlspecialchars($row->role); ?></td>
                                                                <?php foreach ($menu as $menus): ?>
                                                                    <td class="text-center align-middle">
                                                                        <input type="checkbox"
                                                                            name="akses[<?= $row->id ?>][<?= $menus['id_menu'] ?>]"
                                                                            <?= isset($akses_user[$row->id][$menus['id_menu']]) && $akses_user[$row->id][$menus['id_menu']]['allowed'] == 1 ? 'checked' : '' ?>>

                                                                    </td>
                                                                <?php endforeach; ?>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <tr>
                                                            <td colspan="<?= 3 + count($menu) ?>" class="text-center">Data tidak ditemukan</td>
                                                        </tr>
                                                    <?php endif; ?>

                                                </tbody>
                                        </table>
                                        <div class="text-center">
                                            <button id="btn-simpan" type="submit" class="btn btn-success">Simpan</button>
                                        </div>
                                        </form>
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
    <script src="<?= base_url() ?>./resources/template/vendors/jquery/dist/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> -->
    <!-- Bootstrap -->
    <script src="<?= base_url() ?>./resources/template/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="<?= base_url() ?>./resources/template/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?= base_url() ?>./resources/template/vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="<?= base_url() ?>./resources/template/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="<?= base_url() ?>./resources/template/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?= base_url() ?>./resources/template/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?= base_url() ?>./resources/template/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="<?= base_url() ?>./resources/template/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="<?= base_url() ?>./resources/template/vendors/Flot/jquery.flot.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/Flot/jquery.flot.time.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="<?= base_url() ?>./resources/template/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="<?= base_url() ?>./resources/template/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="<?= base_url() ?>./resources/template/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?= base_url() ?>./resources/template/vendors/moment/min/moment.min.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?= base_url() ?>./resources/template/build/js/custom.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function edit_password() {
            $('#edit_password').modal('show');
        }

        function close_modal() {
            document.getElementById('pass_baru').value = ''; // Kosongkan input password
            document.getElementById('show_pass').checked = false; // Uncheck "Show Password" checkbox
            document.getElementById('pass_baru').type = 'password';
            $('#edit_password').modal('hide');
        }

        function togglePassword() {
            var passwordInput = document.getElementById("pass_baru");
            var showPass = document.getElementById("show_pass");
            passwordInput.type = showPass.checked ? "text" : "password";
        }

        function Simpan_password() {
            var pass_baru = $('#pass_baru').val();
            var nama = <?= json_encode($this->session->userdata('username')) ?>;
            // AJAX request to send the data to the server
            $.ajax({
                url: '<?= base_url("LoginController/update_password") ?>', // Replace with your actual update endpoint
                type: 'POST',
                data: {
                    pass_baru: pass_baru,
                    nama: nama
                },
                success: function(response) {
                    // Handle the response from the server
                    if (response.status == "success") {
                        Swal.fire({
                            title: "Good job!",
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
    <script>
        $(document).ready(function() {
            $('#form-akses').on('submit', function(e) {
                e.preventDefault(); // Mencegah reload halaman

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json', // Pastikan response berupa JSON
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload(); // atau panggil ulang fungsi refresh tabel jika pakai DataTables
                            });
                        } else {
                            Swal.fire({
                                title: 'Gagal!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'Coba Lagi'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan pada server.',
                            icon: 'error'
                        });
                    }
                });
            });
        });
    </script>


</body>

</html>