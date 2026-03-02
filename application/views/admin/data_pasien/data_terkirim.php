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

    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        /* Semi-transparent background */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        /* Ensure it's on top of other elements */
        /* visibility: hidden; */
        /* Hidden by default */
    }

    .loader {
        width: 50px;
        padding: 8px;
        aspect-ratio: 1;
        border-radius: 50%;
        background: #25b09b;
        --_m:
            conic-gradient(#0000 10%, #000),
            linear-gradient(#000 0 0) content-box;
        -webkit-mask: var(--_m);
        mask: var(--_m);
        -webkit-mask-composite: source-out;
        mask-composite: subtract;
        animation: l3 1s infinite linear;
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

    @keyframes l3 {
        to {
            transform: rotate(1turn)
        }
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
                            <h2>Data Pasien TBC</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="overlay" id="loader-overlay" style="display: none;">
                            <div class="card">
                                <div class="card-body">
                                    <div class="loader"></div>
                                </div>
                            </div>
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
                                                <th>NIK</th>
                                                <th>No.RM</th>
                                                <th>No.Pelayanan</th>
                                                <!-- <th>Tanggal Lahir</th> -->
                                                <!-- <th>Tanggal Masuk</th> -->
                                                <th>Jenis Kelamin</th>
                                                <!-- <th>Nama Fasyankes</th> -->
                                                <th>Status Pengobatan</th>
                                                <th>ID TB</th>
                                                <th>Status Obat</th>
                                                <th>Status Labor</th>
                                                <!-- <th>Status</th> -->
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($encounter)) : ?>
                                                <?php $no = 1; ?>
                                                <?php foreach ($encounter as $row) : ?>
                                                    <?php
                                                    // Cek apakah ada data yang null atau kosong
                                                    $is_incomplete = (
                                                        // empty($row->middleware_id) ||
                                                        empty($row->organization_id) ||
                                                        empty($row->location_id) ||
                                                        empty($row->practitioner_nik) ||
                                                        empty($row->patient_nik) ||
                                                        empty($row->patient_name) ||
                                                        empty($row->patient_gender) ||
                                                        empty($row->patient_dob) ||
                                                        empty($row->patient_province) ||
                                                        empty($row->patient_district) ||
                                                        empty($row->patient_address) ||
                                                        empty($row->encounter_local_id) ||
                                                        empty($row->encounter_classification) ||
                                                        empty($row->encounter_period_start) ||
                                                        empty($row->encounter_period_in_progress) ||
                                                        empty($row->diagnosis_type) ||
                                                        empty($row->diagnosis_location_anatomi) ||
                                                        empty($row->treatment_history) ||
                                                        // empty($row->condition_clinical_status_tb) ||
                                                        // empty($row->condition_icd_x_code) ||
                                                        // empty($row->kfa_code) ||
                                                        // empty($row->kfa_name) ||
                                                        // empty($row->form_code) ||
                                                        // empty($row->local_id) ||
                                                        // empty($row->type_observation) ||
                                                        // empty($row->issued) ||
                                                        // empty($row->hasil) ||
                                                        // empty($row->episode_number) ||
                                                        // empty($row->episode_of_care_ihs_id) ||
                                                        // empty($row->episode_of_care_id_tb_03) ||
                                                        empty($row->episode_of_care_status) ||
                                                        empty($row->episode_of_care_type_code) ||
                                                        empty($row->episode_of_care_period_start)
                                                        // Tambahkan pengecekan kolom lain yang diinginkan
                                                    );
                                                    $medication_exists = $this->db->where('id_pelayanan', $row->encounter_local_id)
                                                        ->count_all_results('tb_medication') > 0;

                                                    // Cek data pada tb_observ_lab
                                                    $observ_lab = $this->db->select('type_observation')
                                                        ->where('id_pelayanan', $row->encounter_local_id)
                                                        ->get('tb_observ_labor')
                                                        ->result();

                                                    $has_valid_type_observ = false;
                                                    foreach ($observ_lab as $lab) {
                                                        if (in_array($lab->type_observation, ['microscopic', 'MIKROBIOLOGI', 'tcm', 'culture-treatment'])) {
                                                            $has_valid_type_observ = true;
                                                            break;
                                                        }
                                                    }

                                                    // $is_lab_and_medication_missing = !$medication_exists || !$observ_lab;
                                                    $is_lab_and_medication_missing = !$medication_exists;

                                                    ?>
                                                    <tr>
                                                        <td><?php echo $no++; ?>
                                                            <?php if ($is_incomplete) : ?>
                                                                <i class="fa fa-exclamation-circle text-danger" title="Data belum lengkap"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row->patient_name; ?>
                                                            <?php if (empty($row->patient_name)) : ?>
                                                                <i class="fa fa-exclamation-circle text-warning" title="Nama tidak lengkap"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row->patient_nik; ?>
                                                            <?php if (empty($row->patient_nik)) : ?>
                                                                <i class="fa fa-exclamation-circle text-warning" title="NIK tidak lengkap"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row->no_rm; ?>
                                                            <?php if (empty($row->no_rm)) : ?>
                                                                <i class="fa fa-exclamation-circle text-warning" title="No.RM tidak ada"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            // Extract the numeric part after removing 'pl_'
                                                            $numeric_id = substr($row->encounter_local_id, 3);
                                                            echo $numeric_id;
                                                            ?>
                                                            <?php if (empty($numeric_id)) : ?>
                                                                <i class="fa fa-exclamation-circle text-warning" title="No RM tidak lengkap"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <!-- <td>
                                                            <?php echo $row->patient_dob; ?>
                                                            <?php if (empty($row->patient_dob)) : ?>
                                                                <i class="fa fa-exclamation-circle text-warning" title="Tanggal lahir tidak lengkap"></i>
                                                            <?php endif; ?>
                                                        </td> -->
                                                        <!-- <td>
                                                            <?php echo date('Y-m-d', strtotime($row->encounter_period_start)); ?>
                                                            <?php if (empty($row->encounter_period_start)) : ?>
                                                                <i class="fa fa-exclamation-circle text-warning" title="Tanggal Masuk tidak Ada!"></i>
                                                            <?php endif; ?>
                                                        </td> -->
                                                        <td>
                                                            <?php echo $row->patient_gender; ?>
                                                            <?php if (empty($row->patient_gender)) : ?>
                                                                <i class="fa fa-exclamation-circle text-warning" title="Jenis kelamin tidak lengkap"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <!-- <td>
                                                            <?php
                                                            // Check if patient_district is '1901' and replace it with 'Pangkalpinang'
                                                            echo ($row->patient_district == '1901') ? 'RSBT Pangkalpinang' : $row->patient_district;
                                                            ?>

                                                            <?php if (empty($row->patient_district)) : ?>
                                                                <i class="fa fa-exclamation-circle text-warning" title="nomor fasyankes tidak lengkap"></i>
                                                            <?php endif; ?>
                                                        </td> -->
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
                                                        <td>
                                                            <!-- Cek data lab dan data obat -->
                                                            <?php if ($medication_exists) : ?>
                                                                <i class="fa fa-check-circle text-success" title="Obat Sesuai!"></i>
                                                            <?php else: ?>
                                                                <i class="fa fa-exclamation-circle text-warning" title="Data obat tidak ditemukan"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($has_valid_type_observ) : ?>
                                                                <i class="fa fa-check-circle text-success" title="Pemeriksaan Penunjang Sesuai"></i>
                                                            <?php else : ?>
                                                                <i class="fa fa-exclamation-circle text-warning" title="Pemeriksaan Penunjang tidak valid!"></i>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td> <?php if ($is_incomplete || $is_lab_and_medication_missing) : ?>
                                                                <a href="<?= base_url('dataController/update_data/') . base64_encode($row->encounter_local_id); ?>" class="btn btn-warning">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                            <?php elseif ($row->episode_of_care_status == "finished"): ?>
                                                                <a href="<?= base_url('dataController/info_data/') . base64_encode($row->encounter_local_id); ?>" class="btn btn-info">
                                                                    <i class="fa fa-info-circle"></i>
                                                                </a>
                                                            <?php else : ?>
                                                                <!-- Tampilkan ikon info jika data sudah lengkap -->
                                                                <a href="<?= base_url('dataController/update_data/') . base64_encode($row->encounter_local_id); ?>" class="btn btn-warning">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                                <a href="javascript:void(0)" onclick="postData('<?= base64_encode($row->encounter_local_id); ?>')" class="btn btn-success"><i class="fa fa-paper-plane"></i></a>
                                                            <?php endif; ?>
                                                        </td>
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
    <script src="<?php base_url() ?>../resources/template/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <!-- <script src="<?php base_url() ?>../resources/template/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?php base_url() ?>../resources/template/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php base_url() ?>../resources/template/vendors/datatables.net-buttons/js/buttons.print.min.js"></script> -->
    <script src="<?php base_url() ?>../resources/template/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?php base_url() ?>../resources/template/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <!-- <script src="<?php base_url() ?>../resources/template/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script> -->
    <!-- <script src="<?php base_url() ?>../resources/template/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script> -->
    <script src="<?php base_url(); ?>../resources/template/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <!-- <script src="<?php base_url() ?>../resources/template/vendors/jszip/dist/jszip.min.js"></script>
    <script src="<?php base_url() ?>../resources/template/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?php base_url() ?>../resources/template/vendors/pdfmake/build/vfs_fonts.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php base_url() ?>../resources/template/build/js/custom.min.js"></script>

    <script>
        // $(document).ready(function() {
        //     $('#datatable-buttons').DataTable({
        //         dom: 'Bfrtip', // 'B' stands for buttons, which includes export options
        //         buttons: [{
        //             extend: 'excelHtml5',
        //             title: 'Daftar_Pasien', // Sesuaikan judul file Excel
        //             text: 'Ekspor ke Excel', // Teks tombol
        //             exportOptions: {
        //                 columns: ':visible' // Mengekspor semua kolom yang terlihat
        //             }
        //         }],
        //         initComplete: function() {
        //             // Memindahkan tombol di atas tabel
        //             this.api().buttons().container()
        //                 .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)'); // Sesuaikan sesuai layout Anda
        //         }
        //     });
        // });



        function postData(encodedName) {
            // Kirim AJAX request ke controller
            document.getElementById('loader-overlay').style.display = 'flex';
            $.ajax({
                url: '<?= base_url('dataController/index_post/'); ?>' + encodedName,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    // console.log(response);
                    if (response.status === 'success') {
                        // Ambil status_process dan keterangan dari response.data
                        // let status_process = response.data.status_process;
                        // let keterangan = response.data.keterangan;
                        document.getElementById('loader-overlay').style.display = 'none';
                        // Tampilkan pesan sukses dengan SweetAlert
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data Berhasil Dikirim!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else if (response.status === 'error') {
                        // Ambil keterangan dari response.data
                        // let keterangan = response.data.keterangan;
                        document.getElementById('loader-overlay').style.display = 'none';
                        // Tampilkan pesan error dengan SweetAlert
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Data Gagal Dikirim!',
                            icon: 'error',
                            confirmButtonText: 'Coba Lagi'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Jika ada error pada request
                    document.getElementById('loader-overlay').style.display = 'none';
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

        function filterByDate() {
            // Ambil nilai tanggal dari input
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            // Konversi nilai ke Date
            const start = new Date(startDate);
            const end = new Date(endDate);

            // Loop melalui setiap baris di tabel untuk memfilter data
            document.querySelectorAll("#datatable-buttons tbody tr").forEach(row => {
                const dateCell = row.querySelector('td:nth-child(7)');
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

        function edit_password() {
            $('#edit_password').modal('show');
        }

        function close_modal() {
            document.getElementById('pass_baru').value = ''; // Kosongkan input password
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