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
    <link href="<?php base_url() ?>../resources/template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php base_url() ?>../resources/template/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- Scroller CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/scroller/2.0.3/css/scroller.dataTables.min.css">

    <!-- NProgress -->
    <link href="<?php base_url() ?>../resources/template/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php base_url() ?>../resources/template/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="<?php base_url() ?>../resources/template/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?php base_url() ?>../resources/template/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="<?php base_url() ?>../resources/template/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    <!-- Custom Theme Style -->
    <link href="<?php base_url() ?>../resources/template/build/css/custom.min.css" rel="stylesheet">
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
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Pengiriman Data Terjadwal</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="">
                                <div class="col-sm-12">
                                    <div class="card-box table-responsive">
                                        <table id="datatable-buttons" class="table table-striped table-bordered" style="width:98%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Pasien</th>
                                                    <th>NIK</th>
                                                    <th>No.Pelayanan</th>
                                                    <th>Tanggal Lahir</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Nama Fasyankes</th>
                                                    <th>ID TB</th>
                                                    <th>Tanggal Kirim</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($data_schedule)) : ?>
                                                    <?php $no = 1; ?>
                                                    <?php foreach ($data_schedule as $row) : ?>
                                                        <tr>
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $row->patient_name; ?></td>
                                                            <td><?php echo $row->patient_nik; ?></td>
                                                            <td><?php echo substr($row->encounter_local_id, 3); ?></td>
                                                            <td><?php echo $row->patient_dob; ?></td>
                                                            <td><?php echo $row->patient_gender; ?></td>
                                                            <td><?php echo $row->patient_district; ?></td>
                                                            <td><?php echo $row->episode_of_care_id_tb_03; ?></td>
                                                            <td><?php echo $row->tanggal; ?></td>
                                                            <td>
                                                                <?php
                                                                $status = $row->status;

                                                                if ($status == 'success') {
                                                                    $badgeClass = 'badge-info';
                                                                } elseif ($status == 'error') {
                                                                    $badgeClass = 'badge-danger';
                                                                }
                                                                ?>
                                                                <p class="badge <?= $badgeClass; ?>"><?= ucfirst($status); ?></p>
                                                            </td>
                                                            <td>
                                                                <?php if ($row->status == 'success') : ?>
                                                                    <!-- Jika status success, tampilkan ikon check -->
                                                                    <i class="fa fa-check"></i>
                                                                <?php else : ?>
                                                                    <?php echo $row->status; ?>
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <tr>
                                                        <td colspan="11" style="text-align:center;">Data tidak ditemukan</td>
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
    <script src="<?php base_url() ?>../resources/template/vendors/jquery/dist/jquery.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <!-- Bootstrap -->
    <script src="<?php base_url() ?>../resources/template/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="<?php base_url() ?>../resources/template/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php base_url() ?>../resources/template/vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="<?php base_url() ?>../resources/template/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="<?php base_url() ?>../resources/template/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="<?php base_url() ?>../resources/template/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="<?php base_url() ?>../resources/template/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="<?php base_url() ?>../resources/template/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="<?php base_url() ?>../resources/template/vendors/Flot/jquery.flot.js"></script>
    <script src="<?php base_url() ?>../resources/template/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="<?php base_url() ?>../resources/template/vendors/Flot/jquery.flot.time.js"></script>
    <script src="<?php base_url() ?>../resources/template/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="<?php base_url() ?>../resources/template/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="<?php base_url() ?>../resources/template/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="<?php base_url() ?>../resources/template/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="<?php base_url() ?>../resources/template/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="<?php base_url() ?>../resources/template/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="<?php base_url() ?>../resources/template/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="<?php base_url() ?>../resources/template/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="<?php base_url() ?>../resources/template/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="<?php base_url() ?>../resources/template/vendors/moment/min/moment.min.js"></script>
    <script src="<?php base_url() ?>../resources/template/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- <script src="<?php base_url() ?>../resources/template/vendors/datatables.net/js/jquery.dataTables.min.js"></script> -->
    <!-- <script src="<?php base_url() ?>../resources/template/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <!-- Scroller JavaScript -->
    <script type="text/javascript" src="https://cdn.datatables.net/scroller/2.0.3/js/dataTables.scroller.min.js"></script>
    <!-- <script src="<?php base_url() ?>../resources/template/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script> -->
    <!-- <script src="<?php base_url() ?>../resources/template/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?php base_url() ?>../resources/template/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?php base_url() ?>../resources/template/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php base_url() ?>../resources/template/vendors/datatables.net-buttons/js/buttons.print.min.js"></script> -->
    <script src="<?php base_url() ?>../resources/template/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?php base_url() ?>../resources/template/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <!-- <script src="<?php base_url() ?>../resources/template/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script> -->
    <!-- <script src="<?php base_url() ?>../resources/template/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script> -->
    <script src="<?php base_url(); ?>../resources/template/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <!-- <script src="<?php base_url() ?>../resources/template/vendors/jszip/dist/jszip.min.js"></script> -->
    <!-- <script src="<?php base_url() ?>../resources/template/vendors/pdfmake/build/pdfmake.min.js"></script> -->
    <!-- <script src="<?php base_url() ?>../resources/template/vendors/pdfmake/build/vfs_fonts.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php base_url() ?>../resources/template/build/js/custom.min.js"></script>

    <script>
        function postData(encodedName) {
            // Kirim AJAX request ke controller
            $.ajax({
                url: '<?= base_url('dataController/index_post/'); ?>' + encodedName,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response.data.status === 'success') {
                        // Ambil status_process dan keterangan dari response.data
                        let status_process = response.data.status_process;
                        let keterangan = response.data.keterangan;

                        // Tampilkan pesan sukses dengan SweetAlert
                        Swal.fire({
                            title: 'Berhasil!',
                            text: keterangan,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    } else if (response.status === 'error') {
                        // Ambil keterangan dari response.data
                        let keterangan = response.data.keterangan;

                        // Tampilkan pesan error dengan SweetAlert
                        Swal.fire({
                            title: 'Gagal!',
                            text: keterangan,
                            icon: 'error',
                            confirmButtonText: 'Coba Lagi'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Jika ada error pada request
                    Swal.fire({
                        title: 'Error!',
                        text: 'Terjadi kesalahan koneksi atau server.',
                        icon: 'error',
                        confirmButtonText: 'Coba Lagi'
                    });
                    console.error('AJAX Error: ' + status + ' ' + error);
                }
            });
        }

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