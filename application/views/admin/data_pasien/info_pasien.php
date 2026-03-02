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
    <!-- NProgress -->
    <link href="<?= base_url() ?>./resources/template/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?= base_url() ?>./resources/template/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

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
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                    <img src="<?= base_url('resources/template/production/images/user.png') ?>" alt="">Hai,<?php echo $this->session->userdata('nama'); ?>
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
                <div class="col-md-12 col-sm-12 ">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 ">
                            <div class="x_panel">

                                <div class="x_title">
                                    <h2>Informasi Pasien</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <!-- <form id="demo-form2" class="form-horizontal form-label-left" method="POST"> -->
                                    <!-- <h6 class="text-center">Form Data Pasien</h6> -->
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama">Nama Pasien
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="nama" required="required" class="form-control" value="<?php echo $pasien->patient_name ?>" name="nama" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="nik">NIK
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="nik" name="nik" required="required" class="form-control" value="<?php echo $pasien->patient_nik ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label for="gender" class="col-form-label col-md-3 col-sm-3 label-align">Gender</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input id="gender" class="form-control" type="text" name="gender" value="<?php echo $pasien->patient_gender ?>" readonly>
                                        </div>
                                    </div>
                                    <!-- <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align">Gender</label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <div id="gender" class="btn-group" data-toggle="buttons">
                                                    <label class="btn btn-secondary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                        <input type="radio" name="gender" value="male" class="join-btn"> &nbsp; Male &nbsp;
                                                    </label>
                                                    <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                        <input type="radio" name="gender" value="female" class="join-btn"> Female
                                                    </label>
                                                </div>
                                            </div>
                                        </div> -->
                                    <!-- <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align">Date Of Birth
                                            </label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input id="birthday" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" required="required" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)">
                                                <script>
                                                    function timeFunctionLong(input) {
                                                        setTimeout(function() {
                                                            input.type = 'text';
                                                        }, 60000);
                                                    }
                                                </script>
                                            </div>
                                        </div> -->
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="ttl">Tanggal Lahir
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="ttl" name="ttl" required="required" class="form-control" value="<?php echo $pasien->patient_dob ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label for="prov" class="col-form-label col-md-3 col-sm-3 label-align">Provinsi</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input id="prov" class="form-control" type="text" name="prov" value="<?php echo $pasien->patient_province ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label for="distrik" class="col-form-label col-md-3 col-sm-3 label-align">Distrik</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input id="distrik" class="form-control" type="text" name="distrik" value="<?php echo $pasien->patient_district ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label for="alamat" class="col-form-label col-md-3 col-sm-3 label-align">Alamat</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input id="alamat" class="form-control" type="text" name="alamat" value="<?php echo $pasien->patient_address ?>" readonly>
                                        </div>
                                    </div>
                                    <!-- <div class="ln_solid"></div> -->
                                    <div class="x_title">
                                        <h2>Encounter</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="local_id">Local ID</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="local_id" name="local_id" required="required" class="form-control " value="<?php echo $pasien->encounter_local_id ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="klasifikasi">Klasifikasi
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="klasifikasi" name="klasifikasi" required="required" class="form-control" value="<?php echo $pasien->encounter_classification ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label for="enc_period_start" class="col-form-label col-md-3 col-sm-3 label-align">Period Start</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input id="enc_period_start" class="form-control" type="text" name="enc_period_start" value="<?php echo $pasien->encounter_period_start ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label for="enc_period_in_progress" class="col-form-label col-md-3 col-sm-3 label-align">Period In Progress</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input id="enc_period_in_progress" class="form-control" type="text" name="enc_period_in_progress" value="<?php echo $pasien->encounter_period_in_progress  ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label for="enc_period_end" class="col-form-label col-md-3 col-sm-3 label-align">Period End</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input id="enc_period_end" class="form-control" type="text" name="enc_period_end" value="<?php echo $pasien->encounter_period_end ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="x_title">
                                        <h2>Quitioners Response</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="type_diagnosis">Tipe Diagnosa
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="type_diagnosis" name="type_diagnosis" required="required" class="form-control " value="<?php echo $pasien->diagnosis_type  ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="location_anatomi">Lokasi Anatomi
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="location_anatomi" name="location_anatomi" required="required" class="form-control" value="<?php echo $pasien->diagnosis_location_anatomi  ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="treatment_history">Sejarah Perawatan
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="treatment_history" name="treatment_history" required="required" class="form-control" value="<?php echo $pasien->treatment_history ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="end_result">Hasil Akhir Perawatan
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="end_result" name="end_result" required="required" class="form-control" value="<?php echo $pasien->end_result_treatment ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="x_title">
                                        <h2>Kondisi</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="icd">Kode ICD
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="icd" name="icd" required="required" class="form-control " value="<?php echo $pasien->condition_icd_x_code  ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="status">Status
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="status" name="status" required="required" class="form-control" value="<?php echo $pasien->condition_clinical_status_tb ?>" readonly>
                                        </div>
                                    </div>
                                    <?php foreach ($obat as $index => $obat): ?>
                                        <div class="x_title">
                                            <h2>Obat <?= $index + 1 ?></h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="kode_kfa_<?= $index ?>">Kode KFA</label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="text" id="kode_kfa_<?= $index ?>" name="kode_kfa[]" required="required" class="form-control" value="<?= $obat->kfa_code ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama_kfa_<?= $index ?>">Nama KFA</label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="text" id="nama_kfa_<?= $index ?>" name="nama_kfa[]" required="required" class="form-control" value="<?= $obat->kfa_name ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label for="kode_form_<?= $index ?>" class="col-form-label col-md-3 col-sm-3 label-align">Kode Form</label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input id="kode_form_<?= $index ?>" class="form-control" type="text" name="kode_form[]" value="<?= $obat->form_code ?>" readonly>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <?php foreach ($labor as $index => $labor): ?>
                                        <div class="x_title">
                                            <h2>Pemeriksaan Penunjang <?= $index + 1 ?></h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="lid_<?= $index ?>">Local ID</label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="text" id="lid_<?= $index ?>" name="lid[]" required="required" class="form-control" value="<?= $labor->local_id ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="type_obs_<?= $index ?>">Tipe Observasi</label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input type="text" id="type_obs_<?= $index ?>" name="type_obs[]" required="required" class="form-control" value="<?= $labor->type_observation ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label for="issued_<?= $index ?>" class="col-form-label col-md-3 col-sm-3 label-align">Issued</label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input id="issued_<?= $index ?>" class="form-control" type="text" name="issued[]" value="<?= $labor->issued ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label for="hasil_<?= $index ?>" class="col-form-label col-md-3 col-sm-3 label-align">Hasil</label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input id="hasil_<?= $index ?>" class="form-control" type="text" name="hasil[]" value="<?= $labor->hasil ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label for="eps_number_<?= $index ?>" class="col-form-label col-md-3 col-sm-3 label-align">Episod Number</label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <input id="eps_number_<?= $index ?>" class="form-control" type="text" name="eps_number[]" value="<?= $labor->episode_number ?>" readonly>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <div class="x_title">
                                        <h2>Episode Perawatan</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <!-- <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="ihs_id">IHS ID
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="ihs_id" required="required" class="form-control" name="ihs_id" value="<?php echo $pasien->episode_of_care_ihs_id ?>" readonly>
                                        </div>
                                    </div> -->
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="id_tb">ID TB
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="id_tb" name="id_tb" required="required" class="form-control" value="<?php echo $pasien->episode_of_care_id_tb_03 ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="status_berobat">Status
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="status_berobat" name="status_berobat" required="required" class="form-control" value="<?php echo $pasien->episode_of_care_status ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="type_code">Type Code
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="type_code" name="type_code" required="required" class="form-control" value="<?php echo $pasien->episode_of_care_type_code ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label for="period_start" class="col-form-label col-md-3 col-sm-3 label-align">Periode Start</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input id="period_start" class="form-control" type="text" name="period_start" value="<?php echo $pasien->episode_of_care_period_start ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label for="period_end" class="col-form-label col-md-3 col-sm-3 label-align">Periode End</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input id="period_end" class="form-control" type="date" name="period_end" value="<?php echo date('Y-m-d', strtotime($pasien->period_end)); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <div class="col-md-6 col-sm-6 offset-md-3">
                                            <!-- <button class="btn btn-primary" type="button">Cancel</button>
                                                <button class="btn btn-primary" type="reset">Reset</button> -->
                                            <!-- <button class="btn btn-success" onclick="update()">Submit</button> -->
                                        </div>
                                    </div>
                                    <!-- </form> -->
                                </div>
                                <!-- <form action="<?= base_url() ?>./ihs_api/index_post" method="post">
                                    <div class="item form-group">
                                        <div class="col-md-6 col-sm-6 offset-md-3">
                                            <button class="btn btn-primary" type="button">Cancel</button>
                                        <button class="btn btn-primary" type="reset">Reset</button>
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </div>
                                </form> -->
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
    <script src="<?= base_url() ?>./resources/template/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/jszip/dist/jszip.min.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?= base_url() ?>./resources/template/vendors/pdfmake/build/vfs_fonts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?= base_url() ?>./resources/template/build/js/custom.min.js"></script>
    <script>
        function update() {
            // Ambil data dari form dengan id "demo-form2"
            var nama = $('#nama').val();
            var nik = $('#nik').val();
            var gender = $('#gender').val();
            var ttl = $('#ttl').val();
            var prov = $('#prov').val();
            var distrik = $('#distrik').val();
            var alamat = $('#alamat').val();
            var local_id = $('#local_id').val();
            var klasifikasi = $('#klasifikasi').val();
            var enc_period_start = $('#enc_period_start').val();
            var enc_period_in_progress = $('#enc_period_in_progress').val();
            var enc_period_end = $('#enc_period_end').val();
            var type_diagnosis = $('#type_diagnosis').val();
            var location_anatomi = $('#location_anatomi').val();
            var treatment_history = $('#treatment_history').val();
            var end_result = $('#end_result').val();
            var icd = $('#icd').val();
            var status = $('#status').val();
            var kode_kfa = $('#kode_kfa').val();
            var nama_kfa = $('#nama_kfa').val();
            var kode_form = $('#kode_form').val();
            var lid = $('#lid').val();
            var type_obs = $('#type_obs').val();
            var issued = $('#issued').val();
            var hasil = $('#hasil').val();
            var eps_number = $('#eps_number').val();
            var ihs_id = $('#ihs_id').val();
            var id_tb = $('#id_tb').val();
            var status_berobat = $('#status_berobat').val();
            var type_code = $('#type_code').val();
            var period_start = $('#period_start').val();
            var period_end = $('#period_end').val();

            // Jalankan AJAX request
            $.ajax({
                url: '<?= base_url("dataController/edit_data") ?>', // Ganti dengan URL Controller yang sesuai
                type: 'POST', // Metode pengiriman
                data: {
                    nama: nama,
                    nik: nik,
                    gender: gender,
                    ttl: ttl,
                    prov: prov,
                    distrik: distrik,
                    alamat: alamat,
                    local_id: local_id,
                    klasifikasi: klasifikasi,
                    enc_period_start: enc_period_start,
                    enc_period_in_progress: enc_period_in_progress,
                    enc_period_end: enc_period_end,
                    type_diagnosis: type_diagnosis,
                    location_anatomi: location_anatomi,
                    treatment_history: treatment_history,
                    end_result: end_result,
                    icd: icd,
                    status: status,
                    kode_kfa: kode_kfa,
                    nama_kfa: nama_kfa,
                    kode_form: kode_form,
                    lid: lid,
                    type_obs: type_obs,
                    issued: issued,
                    hasil: hasil,
                    eps_number: eps_number,
                    ihs_id: ihs_id,
                    id_tb: id_tb,
                    status_berobat: status_berobat,
                    type_code: type_code,
                    period_start: period_start,
                    period_end: period_end
                }, // Data yang akan dikirim
                success: function(response) {
                    // Callback jika request berhasil
                    Swal.fire({
                        title: "Good job!",
                        text: "Data berhasil di update!",
                        icon: "success"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect setelah user menekan OK pada Swal
                            window.location.href = "<?= base_url('dataController/data_terkirim') ?>";
                        }
                    });
                },
                error: function(xhr, status, error) {
                    // Callback jika terjadi error
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!"
                    });
                    // Menampilkan pesan error
                    // console.log(xhr.responseText);
                }
            });
        }
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

</body>

</html>