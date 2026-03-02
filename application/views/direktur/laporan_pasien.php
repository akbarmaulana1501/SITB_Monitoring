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
    <?php $this->load->view('layouts/style'); ?>
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
                        <a href="<?= base_url() ?>./DirekturController" class="site_title"><img src="<?= base_url() ?>./resources/template/production/images/logoIHC.png" alt="" width="25%"><span> SIM TBC</span></a>
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


                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2><i class="fa fa-file"></i> Laporan pasien TBC</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row mb-3 d-flex justify-content-center">
                                <div class="col-md-3">
                                    <label for="start_date">Tanggal Masuk Awal:</label>
                                    <input type="date" id="start_date" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="end_date">Tanggal Masuk Akhir:</label>
                                    <input type="date" id="end_date" class="form-control">
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button class="btn btn-sm btn-primary" onclick="filterByDate()">Filter</button>
                                    <button class="btn btn-sm btn-secondary" onclick="resetFilter()">Reset</button>
                                    <!-- <button id="exportExcel" class="btn btn-success"><i class="fa fa-file"></i> Excel</button> -->
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <table id="datatable-buttons" class="table table-striped table-bordered" style="width:98%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Pasien</th>
                                                <th>No.RM</th>
                                                <th>No.Pelayanan</th>
                                                <th>Tanggal Lahir</th>
                                                <th>Tanggal Masuk</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Status Pengobatan</th>
                                                <th>ID TB</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($pasien)) : ?>
                                                <?php $no = 1; ?>
                                                <?php foreach ($pasien as $row) : ?>
                                                    <tr>
                                                        <td><?php echo $no++; ?></td>
                                                        <td><?php echo $row->patient_name; ?></td>
                                                        <td><?php echo $row->no_rm; ?></td>
                                                        <td>
                                                            <?php
                                                            // Extract the numeric part after removing 'pl_'
                                                            $numeric_id = substr($row->encounter_local_id, 3);
                                                            echo $numeric_id;
                                                            ?>

                                                        </td>
                                                        <td><?php echo $row->patient_dob; ?></td>
                                                        <td><?php echo date('Y-m-d', strtotime($row->encounter_period_start)); ?></td>
                                                        <td><?php echo $row->patient_gender; ?></td>
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
                                                        <td><?php echo $row->episode_of_care_id_tb_03; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="14" style="text-align:center;">Data tidak ditemukan</td>
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
    <?php $this->load->view('layouts/script'); ?>
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

        function filterByDate() {
            // Ambil nilai tanggal dari input
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            // Konversi nilai ke Date
            const start = new Date(startDate);
            const end = new Date(endDate);

            // Loop melalui setiap baris di tabel untuk memfilter data
            document.querySelectorAll("#datatable-buttons tbody tr").forEach(row => {
                const dateCell = row.querySelector('td:nth-child(6)');
                const rowDate = new Date(dateCell.textContent.trim());

                // Tampilkan atau sembunyikan baris berdasarkan rentang tanggal
                if ((start && rowDate < start) || (end && rowDate > end)) {
                    row.style.display = "none";
                } else {
                    row.style.display = "";
                }
            });
        }

        function resetFilter() {
            // Reset input tanggal
            document.getElementById('start_date').value = "";
            document.getElementById('end_date').value = "";

            // Tampilkan semua baris
            document.querySelectorAll("#datatable-buttons tbody tr").forEach(row => {
                row.style.display = "";
            });
        }
    </script>
    <script>
        const tanggalMulai = document.getElementById('start_date');
        const tanggalAkhir = document.getElementById('end_date');

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