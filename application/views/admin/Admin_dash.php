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

    .custom-pink-square {
        color: #FFC0CB;
        /* Light Pink */
    }

    .custom-grey {
        color: #c1c8d4;
    }
</style>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col menu_fixed">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="<?= base_url() ?>./AdminController/dashboard" class="site_title"><img src="<?= base_url() ?>./resources/template/production/images/logoIHC.png" alt="" width="25%"><span> SIM TBC</span></a>
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


                <!-- <div class="row">
                    <div class="col-md-12 col-sm-12 ">
                        <div class="x_panel">
                            <h3 class="text-center">Selamat Datang di Sistem TBC v.1</h3>
                        </div>
                    </div>
                </div> -->
                <!-- <div class="col-md-4 col-sm-4 ">
                    <div class="x_panel tile fixed_height_250">
                        <div class="x_title">
                            <h2>Jumlah Kasus TBC</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="dashboard-widget-content">
                                <div class="sidebar-widget">
                                    <i class="fa fa-search fa-5x"></i>
                                </div>
                                <div>
                                    <strong>jumlah kasus: <?= $jumlah_kasus->jumlah_kasus_tb; ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="row">
                    <div class="col-md-4 col-sm-4 ">
                        <div class="x_panel">
                            <p class="text-center items-align-center">Jumlah Pasien Aktif:</p>
                            <h4 class="text-center items-align-center"><?= $pasien_active; ?></h4>
                            <p class="text-center items-align-center">Pasien</p>
                            <div class="text-center items-align-center">
                                <a href="<?= base_url('DataController/data_terkirim?status=active'); ?>" class="btn btn-sm btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 ">
                        <div class="x_panel">
                            <p class="text-center">Selesai Pengobatan:</p>
                            <h4 class="text-center items-align-center"><?= $pasien_selesai; ?></h4>
                            <p class="text-center items-align-center">Pasien</p>
                            <div class="text-center items-align-center">
                                <a href="<?= base_url('DataController/data_terkirim?status=finished'); ?>" class="btn btn-sm btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 ">
                        <div class="x_panel">
                            <p class="text-center">Putus Berobat:</p>
                            <h4 class="text-center items-align-center"><?= $pasien_berhenti; ?></h4>
                            <p class="text-center items-align-center">Pasien</p>
                            <div class="text-center items-align-center">
                                <a href="<?= base_url('DataController/data_terkirim?status=canceled'); ?>" class="btn btn-sm btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 mb-3">
                    <div class="dashboard_graph">

                        <div class="row x_title">
                            <div class="col-md-6">
                                <h3>Virus Tuberkulosis <small>Grafik kasus TBC RS Bakti Timah</small></h3>
                            </div>
                            <div class="col-md-6">
                                <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                    <i class="fa fa-calendar"></i>
                                    <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9 col-sm-9 ">
                            <div style="width:100%; margin: auto;">
                                <canvas id="chart_plot_01"></canvas>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3  bg-white">
                            <div class="x_title">
                                <h2>Distribusi Usia Pasien</h2>
                                <div class="clearfix"></div>
                            </div>

                            <?php
                            // Inisialisasi default
                            $usia = [
                                '0-14 Tahun' => 0,
                                '15-24 Tahun' => 0,
                                '25-54 Tahun' => 0,
                                '55+ Tahun' => 0
                            ];

                            $total_pasien = 0;

                            foreach ($distribusi_usia as $row) {
                                $usia[$row->kelompok_usia] = $row->total;
                                $total_pasien += $row->total;
                            }

                            // Menghitung persentase
                            function persen($jumlah, $total)
                            {
                                return $total > 0 ? round(($jumlah / $total) * 100) : 0;
                            }
                            ?>

                            <div class="col-md-12 col-sm-12">
                                <?php foreach ($usia as $label => $jumlah): ?>
                                    <div>
                                        <p><?= $label ?> (<?= $jumlah ?>)</p>
                                        <div class="">
                                            <div class="progress progress_sm" style="width: 100%;">
                                                <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?= persen($jumlah, $total_pasien) ?>"></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 ">
                    <div class="x_panel tile fixed_height_320 overflow_hidden">
                        <div class="x_title">
                            <h2>Resistensi TBC</h2>
                            <div class="clearfix"></div>
                        </div>
                        <?php
                        $total_so = $resistensi->total_tb_so;
                        $total_ro = $resistensi->total_tb_ro;
                        $total_semua = $total_so + $total_ro;

                        $persen_so = ($total_semua > 0) ? round(($total_so / $total_semua) * 100) : 0;
                        $persen_ro = ($total_semua > 0) ? round(($total_ro / $total_semua) * 100) : 0;
                        ?>

                        <div class="x_content">
                            <table class="" style="width:100%">
                                <tr>
                                    <td>
                                        <canvas class="canvas2" height="160" width="160" style="margin: 15px 10px 10px 0"></canvas>
                                    </td>
                                    <td>
                                        <table class="tile_info">
                                            <tr>
                                                <td>
                                                    <p><i class="fa fa-square blue"></i>TB-SO </p>
                                                    <em style="font-size: 12px; display: block;">*Pasien TB yang merespon pengobatan lini pertama</em>
                                                </td>
                                                <td><?= $persen_so ?>%</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p><i class="fa fa-square green"></i>TB-RO </p>
                                                    <em style="font-size: 12px; display: block;">*Pasien dengan TB resisten terhadap obat lini pertama</em>
                                                </td>
                                                <td><?= $persen_ro ?>%</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 ">
                    <div class="x_panel tile fixed_height_320 overflow_hidden">
                        <div class="x_title">
                            <h2>Statistik Gender Pasien TBC</h2>
                            <div class="clearfix"></div>
                        </div>
                        <?php
                        $laki_laki = $gender['male'];
                        $perempuan = $gender['female'];
                        $unknown = $gender['unknown'];
                        $jumlah_total = $laki_laki + $perempuan + $unknown;

                        $persen_laki = ($jumlah_total > 0) ? round(($laki_laki / $jumlah_total) * 100) : 0;
                        $persen_perempuan = ($jumlah_total > 0) ? round(($perempuan / $jumlah_total) * 100) : 0;
                        $persen_unknown = ($jumlah_total > 0) ? round(($unknown / $jumlah_total) * 100) : 0;
                        ?>

                        <div class="x_content">
                            <table class="" style="width:100%">
                                <tr>
                                    <td>
                                        <canvas class="canvas3" height="160" width="160" style="margin: 15px 10px 10px 0"></canvas>
                                    </td>
                                    <td>
                                        <table class="tile_info">
                                            <tr>
                                                <td>
                                                    <p><i class="fa fa-square blue"></i>Laki-laki </p>
                                                    <em style="font-size: 12px; display: block;">*Pasien TB dengan jenis kelamin laki-laki</em>
                                                </td>
                                                <td><?= $persen_laki ?>%</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p><i class="fa fa-square custom-pink-square"></i>Perempuan </p>
                                                    <em style="font-size: 12px; display: block;">*Pasien TB dengan jenis kelamin perempuan</em>
                                                </td>
                                                <td><?= $persen_perempuan ?>%</td>
                                            </tr>
                                            <!-- <tr>
                                                <td>
                                                    <p><i class="fa fa-square custom-grey"></i>Tidak Ada </p>
                                                    <em style="font-size: 12px; display: block;">*Pasien TB dengan jenis kelamin Tidak Diketahui</em>
                                                </td>
                                                <td><?= $persen_unknown ?>%</td>
                                            </tr> -->
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Aktivitas Terbaru</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="dashboard-widget-content">

                                <ul class="list-unstyled timeline widget">
                                    <?php foreach ($recent_activity as $log): ?>
                                        <li>
                                            <div class="block">
                                                <div class="block_content">
                                                    <h2 class="title">
                                                        <a><?= $log->activity ?></a>
                                                    </h2>
                                                    <div class="byline">
                                                        <span><?= time_elapsed_string($log->created_at) ?></span> oleh <a><?= $log->username ?></a>
                                                    </div>
                                                    <p class="excerpt">Aktivitas dilakukan di sistem oleh <?= $log->username ?></p>
                                                </div>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
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
            var ctx = document.getElementsByClassName("canvas2")[0].getContext("2d");

            // Jika sudah ada chart sebelumnya, hapus dulu

            canvas2 = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ["TB-SO", "TB-RO"],
                    datasets: [{
                        data: [<?= $total_so ?>, <?= $total_ro ?>],
                        backgroundColor: ["#3498DB", "#1ABB9C", "#c1c8d4"],
                        hoverBackgroundColor: ["#2980B9", "#16A085", "#c1c8d4"]
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false,
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });
        });

        $(document).ready(function() {
            var ctx = document.getElementsByClassName("canvas3")[0].getContext("2d");

            // Jika sudah ada chart sebelumnya, hapus dulu

            canvas2 = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ["Laki-laki", "Perempuan"],
                    datasets: [{
                        data: [<?= $laki_laki ?>, <?= $perempuan ?>],
                        backgroundColor: ["#3498DB", "#FFC0CB"],
                        hoverBackgroundColor: ["#2980B9", "#FFC0CB"]
                    }]
                },
                options: {
                    responsive: false,
                    maintainAspectRatio: false,
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });
        });
    </script>

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
    </script>
    <script>
        $(document).ready(function() {
            $('#reportrange').daterangepicker({
                startDate: moment(), // Menampilkan hari ini secara default
                endDate: moment(), // Menampilkan hari ini secara default
                minDate: moment("2020-01-01"), // Tidak bisa memilih sebelum 2020
                maxDate: moment("2025-12-31"), // Tidak bisa memilih setelah 2025
                showDropdowns: true, // Dropdown untuk memilih bulan dan tahun
                alwaysShowCalendars: true, // Kalender tetap tampil meskipun tidak memilih preset
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                }
            }, function(start, end) {
                // Menampilkan tanggal yang dipilih
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var chart; // global chart instance

            function renderChart(labels, values) {
                var ctx = document.getElementById("chart_plot_01").getContext("2d");
                if (chart) chart.destroy(); // destroy old chart if exists
                chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Kasus TBC',
                            data: values,
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.5)',
                                'rgba(255, 99, 132, 0.5)',
                                'rgba(54, 162, 235, 0.5)',
                                'rgba(255, 206, 86, 0.5)',
                                'rgba(153, 102, 255, 0.5)'
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(153, 102, 255, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            }

            // Inisialisasi chart awal
            renderChart(
                ["Poli Dalam", "Poli Anak", "Poli Umum", "Poli Paru", "Poli Obgyne"],
                [<?= $poli_dalam ?>, <?= $poli_anak ?>, <?= $poli_umum ?>, <?= $poli_paru ?>, <?= $poli_obgyne ?>]
            );

            // Inisialisasi date range picker
            $('#reportrange').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'YYYY-MM-DD'
                }
            }, function(start, end, label) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

                // AJAX untuk ambil data berdasarkan tanggal
                $.ajax({
                    url: "<?= base_url('AdminController/get_data_by_date') ?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        start_date: start.format('YYYY-MM-DD'),
                        end_date: end.format('YYYY-MM-DD')
                    },
                    success: function(response) {
                        // response = { labels: [...], values: [...] }
                        renderChart(response.labels, response.values);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            });
        });
    </script>

</body>

</html>