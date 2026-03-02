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
    <!-- NProgress -->
    <link href="<?= base_url() ?>./resources/template/vendors/nprogress/nprogress.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
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

    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .container.body {
        display: flex;
        flex-direction: column;
        min-height: 100%;
    }

    .main_container {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        background-color: #F7F7F7;
        /* Atau #F7F7F7, warna latar konten Gentelella standar */
        /* Jika Anda menggunakan body.nav-md, Anda mungkin perlu margin-left di sini juga,
       tapi Gentelella biasanya sudah menanganinya jika struktur HTML benar.
       Contoh: margin-left: 230px; (jika sidebar lebarnya 230px)
       Namun, ini seharusnya sudah ada dari CSS Gentelella asli.
       Fokus utama di sini adalah background-color.
    */
    }

    .right_col {
        flex-grow: 1;
    }

    footer {
        flex-shrink: 0;
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
                    <?php $this->load->view('layouts/user'); ?>
                </div>
            </div>
            <?php $this->load->view('layouts/modals'); ?>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <!-- top tiles -->

                <!-- /top tiles -->


                <div class="col-md-9 col-sm-9 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><i class="fa fa-user-gear"></i> Daftar User</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="">
                                <div class="col-sm-12">
                                    <div class="card-box table-responsive">
                                        <div class="mb-2">
                                            <a href="<?= base_url('AdminController/tambah_akun/'); ?>" class="btn btn-primary"><i class="fa fa-user-plus"></i> Tambah User</a>
                                        </div>
                                        <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Nama</th>
                                                <th class="text-center">Email</th>
                                                <th class="text-center">Username</th>
                                                <th class="text-center">Role</th>
                                                <th class="text-center">Aksi</th>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($user)) : ?>
                                                    <?php $no = 1; ?>
                                                    <?php foreach ($user as $row) : ?>
                                                        <tr>
                                                            <td class="text-center align-middle"><?= $no++; ?></td>
                                                            <td class="text-center align-middle"><?= $row->nama; ?></td>
                                                            <td class="text-center align-middle"><?= $row->email; ?></td>
                                                            <td class="text-center align-middle"><?= $row->username; ?></td>
                                                            <td class="text-center align-middle"><?= $row->role; ?></td>
                                                            <td class="text-center align-middle">
                                                                <?php if ($row->status_akun == 1): ?>
                                                                    <button class="btn btn-danger btn-nonaktif" data-id="<?= $row->id; ?>"><i class="fa fa-power-off"></i></button>
                                                                <?php else: ?>
                                                                    <button class="btn btn-success btn-aktifkan" data-id="<?= $row->id; ?>"><i class="fa fa-check"></i></button>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <tr>
                                                        <td colspan="<?= 3 + count($menu) ?>" class="text-center">Data tidak ditemukan</td>
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
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
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
    <script>
        $(document).ready(function() {
            // Nonaktifkan akun
            $('#datatable-buttons').on('click', '.btn-nonaktif', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin ingin menonaktifkan akun ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Ya, Nonaktifkan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= base_url('AdminController/non_aktif_akun'); ?>',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                id: id
                            },
                            success: function(response) {
                                if (response.status === "success") {
                                    Swal.fire({
                                        title: "Berhasil!",
                                        text: "Akun berhasil dinonaktifkan.",
                                        icon: "success"
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Gagal!",
                                        text: response.message || 'Gagal menonaktifkan akun.'
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Terjadi kesalahan pada server."
                                });
                            }
                        });
                    }
                });
            });

            // Aktifkan akun
            $('#datatable-buttons').on('click', '.btn-aktifkan', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin ingin mengaktifkan akun ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Ya, Aktifkan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?= base_url('AdminController/aktifkan_akun'); ?>',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                id: id
                            },
                            success: function(response) {
                                if (response.status === "success") {
                                    Swal.fire({
                                        title: "Berhasil!",
                                        text: "Akun berhasil diaktifkan.",
                                        icon: "success"
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: "error",
                                        title: "Gagal!",
                                        text: response.message || 'Gagal mengaktifkan akun.'
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: "Terjadi kesalahan pada server."
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>



</body>

</html>