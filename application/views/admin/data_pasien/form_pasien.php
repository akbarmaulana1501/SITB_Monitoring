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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

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

    .suggestions {
        border: 1px solid #ccc;
        max-height: 150px;
        overflow-y: auto;
        display: none;
        position: absolute;
        background: white;
        z-index: 1000;
    }

    .suggestion-item {
        padding: 8px;
        cursor: pointer;
    }

    .suggestion-item:hover {
        background-color: #f0f0f0;
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

    /* HTML: <div class="loader"></div> */
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
                                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                    </symbol>
                                    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                    </symbol>
                                    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                    </symbol>
                                </svg>
                                <div class="x_title">
                                    <h2>Data Pasien</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <!-- <form id="demo-form2" class="form-horizontal form-label-left" method="POST"> -->
                                    <!-- <h6 class="text-center">Form Data Pasien</h6> -->
                                    <?php if (empty($labor)) : ?>
                                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                                            <svg class="bi flex-shrink-0 me-2" width="22" height="22" role="img" aria-label="Danger:">
                                                <use xlink:href="#exclamation-triangle-fill"/>
                                            </svg>
                                            <div>
                                                 Data labor pasien belum ada!
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama">Nama Pasien
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="patient_name" required="required" class="form-control" value="<?php echo $pasien->patient_name ?>" name="patient_name">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="nik">NIK
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="nik" name="nik" required="required" class="form-control" value="<?php echo $pasien->patient_nik ?>">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label for="gender" class="col-form-label col-md-3 col-sm-3 label-align">Jenis Kelamin</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input id="gender" class="form-control" type="text" name="gender" value="<?php echo $pasien->patient_gender ?>">
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
                                            <input type="text" id="ttl" name="ttl" required="required" class="form-control" value="<?php echo $pasien->patient_dob ?>">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label for="prov" class="col-form-label col-md-3 col-sm-3 label-align">Nama Provinsi</label>
                                        <div class="col-md-6 col-sm-6">
                                            <input id="prov" class="form-control" type="text" name="prov"
                                                value="<?php echo ($pasien->patient_province == '19') ? 'Bangka Belitung' : $pasien->patient_province; ?>">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label for="distrik" class="col-form-label col-md-3 col-sm-3 label-align">Kab/kota</label>
                                        <div class="col-md-6 col-sm-6">
                                            <input id="distrik" class="form-control" type="text" name="distrik"
                                                value="<?php echo ($pasien->patient_district == '1901') ? 'RSBT Pangkalpinang' : $pasien->patient_district; ?>">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label for="alamat" class="col-form-label col-md-3 col-sm-3 label-align">Alamat Lengkap</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input id="alamat" class="form-control" type="text" name="alamat" value="<?php echo $pasien->patient_address ?>">
                                        </div>
                                    </div>
                                    <!-- <div class="ln_solid"></div> -->
                                    <div class="x_title">
                                        <h2>Kunjungan</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="local_id">ID Kunjungan</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="local_id" name="local_id" required="required" class="form-control" value="<?php echo substr($pasien->encounter_local_id, 3); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="klasifikasi">Jenis Kunjungan
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="klasifikasi" name="klasifikasi" required="required" class="form-control" value="<?php
                                                                                                                                                    switch ($pasien->encounter_classification) {
                                                                                                                                                        case 'AMB':
                                                                                                                                                            echo 'Rawat Jalan';
                                                                                                                                                            break;
                                                                                                                                                        case 'EMER':
                                                                                                                                                            echo 'IGD';
                                                                                                                                                            break;
                                                                                                                                                        case 'HH':
                                                                                                                                                            echo 'Home Care';
                                                                                                                                                            break;
                                                                                                                                                        default:
                                                                                                                                                            echo "$pasien->encounter_classification"; // Default value if none of the cases match
                                                                                                                                                            break;
                                                                                                                                                    }
                                                                                                                                                    ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label for="enc_period_start" class="col-form-label col-md-3 col-sm-3 label-align">Waktu registrasi kunjungan</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input id="enc_period_start" class="form-control" type="text" name="enc_period_start" value="<?php echo $pasien->encounter_period_start ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label for="enc_period_in_progress" class="col-form-label col-md-3 col-sm-3 label-align">Waktu perawatan</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input id="enc_period_in_progress" class="form-control" type="text" name="enc_period_in_progress" value="<?php echo $pasien->encounter_period_start  ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label for="enc_period_end" class="col-form-label col-md-3 col-sm-3 label-align">Waktu selesai kunjungan</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input id="enc_period_end" class="form-control" type="text" name="enc_period_end" value="<?php echo $pasien->encounter_period_end ?>" readonly>
                                        </div>
                                    </div>
                                    <!-- <div class="x_title">
                                        <h2>Quitioners Response</h2>
                                        <div class="clearfix"></div>
                                    </div> -->
                                    <div class="x_title">
                                        <h2>Diagnosis</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <?php if (!empty($pasien->condition_icd_x_code)): ?>
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="kode_diag">Kode Diagnosa</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" id="kode_diag" name="kode_diag" class="form-control" placeholder="Ketik Kode ICD" required="required" value="<?php echo $pasien->condition_icd_x_code ?>" disabled>
                                                <div id="suggestions-box2" style="display: none; position: absolute; z-index: 1000; border: 1px solid #ccc; background-color: white;"></div>
                                            </div>
                                        </div>
                                    <?php elseif (empty($pasien->condition_icd_x_code)): ?>
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="kode_diag">Kode Diagnosa</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" id="kode_diag" name="kode_diag" class="form-control" placeholder="Ketik Kode ICD" required="required">
                                                <div id="suggestions-box2" style="display: none; position: absolute; z-index: 1000; border: 1px solid #ccc; background-color: white;"></div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($pasien->other_icd)): ?>
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="kode_diag_dokter">Kode Diagnosa Lain</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" id="kode_diag_dokter" name="kode_diag_dokter" class="form-control" placeholder="Ketik Kode ICD" required="required" value="<?php echo $pasien->other_icd ?> | <?php echo $pasien->nama_diagnosa ?>">
                                                <div id="suggestions-box" style="display: none; position: absolute; z-index: 1000; border: 1px solid #ccc; background-color: white;"></div>
                                            </div>
                                        </div>
                                    <?php elseif (empty($pasien->other_icd)): ?>
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="kode_diag_dokter">Kode Diagnosa Lain</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" id="kode_diag_dokter" name="kode_diag_dokter" class="form-control" placeholder="Ketik Kode ICD" required="required">
                                                <div id="suggestions-box" style="display: none; position: absolute; z-index: 1000; border: 1px solid #ccc; background-color: white;"></div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="id_diagnosa" name="id_diagnosa" class="form-control" placeholder="Ketik Kode ICD" required="required">
                                        <input type="hidden" id="nama_diagnosa" name="nama_diagnosa" class="form-control" placeholder="Ketik Kode ICD" required="required">
                                    <?php endif; ?>
                                    <!-- <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="icd">Kode ICD
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="icd" name="icd" required="required" class="form-control " value="<?php echo $pasien->condition_icd_x_code  ?>">
                                        </div>
                                    </div> -->
                                    <div class="item form-group">
                                        <!-- <label class="col-form-label col-md-3 col-sm-3 label-align" for="status">Status
                                        </label> -->
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="hidden" id="status" name="status" required="required" class="form-control" value="<?php echo $pasien->condition_clinical_status_tb ?>">
                                        </div>
                                    </div>
                                    <!-- <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="status"></label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <a href="javascript:void(0);" id="toggleDiagnosis"><i class="fa fa-add"></i> Diagnosis lain</a>
                                        </div>
                                    </div> -->

                                    <!-- Initially hidden fields for additional diagnosis -->
                                    <!-- <?php if (!empty($pasien->other_icd)): ?>
                                        <div id="additionalDiagnosis">
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="other_icd">Kode ICD</label>
                                                <div class="col-md-6 col-sm-6">
                                                    <select id="other_icd" name="other_icd" required="required" class="form-control">
                                                        <option value="">Pilih Kode ICD</option>
                                                        <?php foreach ($diagnosa as $diag): ?>
                                                            <option value="<?= $diag->id_diagnosa ?>" <?= ($diag->id_diagnosa == $pasien->other_icd) ? 'selected="selected"' : '' ?>>
                                                                <?= $diag->id_diagnosa ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="other_name">Nama Diagnosis</label>
                                                <div class="col-md-6 col-sm-6">
                                                    <select id="other_name" name="other_name" required="required" class="form-control">
                                                        <option value="">Pilih Nama Diagnosis</option>
                                                        <?php foreach ($diagnosa as $diag): ?>
                                                            <option value="<?= $diag->nama_diagnosa ?>" <?= ($diag->nama_diagnosa == $pasien->nama_diagnosa) ? 'selected="selected"' : '' ?>>
                                                                <?= $diag->nama_diagnosa ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php elseif (empty($pasien->other_icd)): ?>
                                        <div id="additionalDiagnosis" style="display: none;">
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="other_icd">Kode ICD</label>
                                                <div class="col-md-6 col-sm-6">
                                                    <select id="other_icd" name="other_icd" required="required" class="form-control">
                                                        <option value="">Pilih Kode ICD</option>
                                                        <?php foreach ($diagnosa as $diag): ?>
                                                            <option value="<?= $diag->id_diagnosa ?>">
                                                                <?= $diag->id_diagnosa ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="other_name">Nama Diagnosis</label>
                                                <div class="col-md-6 col-sm-6">
                                                    <select id="other_name" name="other_name" required="required" class="form-control">
                                                        <option value="">Pilih Nama Diagnosis</option>
                                                        <?php foreach ($diagnosa as $diag): ?>
                                                            <option value="<?= $diag->nama_diagnosa ?>">
                                                                <?= $diag->nama_diagnosa ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?> -->

                                    <!-- <div class="x_title">
                                        <h2>Diagnosis Dokter</h2>
                                        <div class="clearfix"></div>
                                    </div> -->




                                    <div class="x_title">
                                        <h2>Pemeriksaan Penunjang</h2>
                                        <div class="clearfix"></div>
                                    </div>

                                    <?php if (empty($labor)) : ?>
                                        <!-- Jika tidak ada data labor -->
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="observ_id">ID Pemeriksaan</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input type="text" id="observ_id" name="observ_id" required="required" class="form-control">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="type_observ">Jenis Pemeriksaan</label>
                                            <div class="col-md-6 col-sm-6">
                                                <select id="type_observ" name="type_observ" required="required" class="form-control">
                                                    <option value="">-- Pilih Jenis Pemeriksaan --</option>
                                                    <option value="microscopic"> Mikroskopis</option>
                                                    <option value="tcm"> Test Cepat Molekuler </option>
                                                    <option value="culture-treatment"> Biakan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label for="issued" class="col-form-label col-md-3 col-sm-3 label-align">Waktu Pemeriksaan</label>
                                            <div class="col-md-6 col-sm-6">
                                                <input id="issued" class="form-control" type="datetime-local" name="issued">
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="hasil">Hasil Pemeriksaan</label>
                                            <div class="col-md-6 col-sm-6">
                                                <select id="hasil" name="hasil" required="required" class="form-control">
                                                    <option value="">-- Pilih Hasil Pemeriksaan --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="rifampicin" style="display: none;">
                                            <div class="item form-group">
                                                <label for="issued_rifampicin" class="col-form-label col-md-3 col-sm-3 label-align">Waktu Rifampicin </label>
                                                <div class="col-md-6 col-sm-6">
                                                    <input id="issued_rifampicin" class="form-control" type="datetime-local" name="issued_rifampicin">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label for="period_number" class="col-form-label col-md-3 col-sm-3 label-align">Periode Pemeriksaan (Bulan)</label>
                                            <div class="col-md-6 col-sm-6">
                                                <select id="period_number" name="period_number" required="required" class="form-control">
                                                    <option value="">-- Pilih Periode Pemeriksaan Bulan --</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="item form-group">
                                            <label for="" class="col-form-label col-md-3 col-sm-3 label-align"></label>
                                            <div class="col-md-6 col-sm-6">
                                                <button class="btn btn-success" onclick="simpan_pemeriksaan_empty('<?= $pasien->encounter_local_id ?>')"><i class="fa fa-download"></i> Simpan</button>
                                            </div>
                                        </div>

                                    <?php else : ?>
                                        <!-- Looping untuk setiap pemeriksaan -->

                                        <?php foreach ($labor as $key => $labor_item) : ?>
                                            <?php if ($labor_item->cara_input == "manual") : ?>

                                                <div class="item form-group">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="manual_observ_id">ID Pemeriksaan </label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="text" id="manual_observ_id" name="manual_observ_id[]" required="required" class="form-control" value="<?php echo $labor_item->local_id ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="manual_type_obs">Jenis Pemeriksaan</label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="text" id="manual_type_obs" name="manual_type_obs[]" required="required" class="form-control" value="<?php
                                                                                                                                                                            switch ($labor_item->type_observation) {
                                                                                                                                                                                case 'microscopic':
                                                                                                                                                                                    echo 'Mikroskopis';
                                                                                                                                                                                    break;
                                                                                                                                                                                case 'tcm':
                                                                                                                                                                                    echo 'Test Cepat Molekuler';
                                                                                                                                                                                    break;
                                                                                                                                                                                case 'culture-treatment':
                                                                                                                                                                                    echo 'Biakan';
                                                                                                                                                                                    break;
                                                                                                                                                                                default:
                                                                                                                                                                                    echo "$labor_item->type_observation"; // Default value if none of the cases match
                                                                                                                                                                                    break;
                                                                                                                                                                            }
                                                                                                                                                                            ?>" readonly>

                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label for="manual_issued" class="col-form-label col-md-3 col-sm-3 label-align">Waktu Pemeriksaan </label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input id="manual_issued" class="form-control" type="datetime-local" name="manual_issued[]" value="<?php echo $labor_item->issued ?>" readonly>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="cara_input" name="cara_input" value="<?php echo $labor_item->cara_input ?>">
                                                <div class="item form-group">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="manual_hasil[]">Hasil Pemeriksaan</label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="text" id="manual_hasil" name="manual_hasil[]" required="required" class="form-control" onchange="toggleRifampicin()" value="<?php
                                                                                                                                                                                                    switch ($labor_item->hasil) {
                                                                                                                                                                                                        case 'neg':
                                                                                                                                                                                                            echo 'Negatif';
                                                                                                                                                                                                            break;
                                                                                                                                                                                                        case 'tidak dilakukan':
                                                                                                                                                                                                            echo 'Tidak Dilakukan';
                                                                                                                                                                                                            break;
                                                                                                                                                                                                        case 'rif-sen':
                                                                                                                                                                                                            echo 'Rifampicin Sensitive';
                                                                                                                                                                                                            break;
                                                                                                                                                                                                        case 'rif-res':
                                                                                                                                                                                                            echo 'Rifampicin Resistant';
                                                                                                                                                                                                            break;
                                                                                                                                                                                                        case 'rif-indet':
                                                                                                                                                                                                            echo 'Rifampicin Indeterminate';
                                                                                                                                                                                                            break;
                                                                                                                                                                                                        case 'invalid':
                                                                                                                                                                                                            echo 'Invalid';
                                                                                                                                                                                                            break;
                                                                                                                                                                                                        case 'error':
                                                                                                                                                                                                            echo 'Error';
                                                                                                                                                                                                            break;
                                                                                                                                                                                                        case 'no result':
                                                                                                                                                                                                            echo 'No Result';
                                                                                                                                                                                                            break;
                                                                                                                                                                                                        case 'ntm':
                                                                                                                                                                                                            echo 'ntm';
                                                                                                                                                                                                            break;
                                                                                                                                                                                                        case 'kontaminasi':
                                                                                                                                                                                                            echo 'Kontaminasi';
                                                                                                                                                                                                            break;
                                                                                                                                                                                                        default:
                                                                                                                                                                                                            echo "$labor_item->hasil"; // Default value if none of the cases match
                                                                                                                                                                                                            break;
                                                                                                                                                                                                    }
                                                                                                                                                                                                    ?>" readonly>
                                                    </div>
                                                </div>

                                                <div id="rifampicin_manual" style="display: <?php echo ($labor_item->hasil == 'rif-sen' || $labor_item->hasil == 'rif-res' || $labor_item->hasil == 'rif-indet') ? 'block' : 'none'; ?>;">
                                                    <div class="item form-group">
                                                        <label for="issued_rifampicin_manual" class="col-form-label col-md-3 col-sm-3 label-align">Waktu Rifampicin </label>
                                                        <div class="col-md-6 col-sm-6">
                                                            <input id="issued_rifampicin_manual" class="form-control" type="datetime-local" name="issued_rifampicin_manual[]" value="<?php echo $labor_item->issued_rifampicin ?>" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="item form-group">
                                                    <label for="manual_period_number" class="col-form-label col-md-3 col-sm-3 label-align">Periode Pemeriksaan (bulan) </label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="text" id="manual_period_number" name="manual_period_number[]" required="required" class="form-control" value="<?php echo $labor_item->episode_number ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="status"></label>
                                                    <div class="col-md-6 col-sm-6 d-flex">
                                                        <button type="button" class="btn btn-warning me-2" id="add-form-btn" onclick="update_pemeriksaan('<?= $labor_item->local_id ?>')">
                                                            <i class="fa fa-pencil"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger" id="add-form-btn" onclick="hapus_pemeriksaan('<?= $labor_item->local_id ?>')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <hr>

                                            <?php endif; ?>
                                            <!-- Menyembunyikan bagian bawah jika cara_input bukan manual -->
                                            <?php if ($labor_item->cara_input == "labor") : ?>
                                                <input type="hidden" name="labor_cara_input" id="labor_cara_input" value="<?php echo $labor_item->cara_input ?>">
                                                <div class="item form-group">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="lid_<?php echo $key; ?>">ID Pemeriksaan</label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="text" id="lid_<?php echo $key; ?>" name="lid[]" required="required" class="form-control" value="<?php echo $labor_item->local_id ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="type_obs_<?php echo $key; ?>">Jenis Pemeriksaan</label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="text" id="type_obs_<?php echo $key; ?>" name="type_obs[]" required="required" class="form-control" value="<?php echo $labor_item->type_observation ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label for="issued_<?php echo $key; ?>" class="col-form-label col-md-3 col-sm-3 label-align">Waktu Pemeriksaan</label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input id="issued_<?php echo $key; ?>" class="form-control" type="text" name="issued[]" value="<?php echo $labor_item->issued ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label for="hasil_<?php echo $key; ?>" class="col-form-label col-md-3 col-sm-3 label-align">Hasil Pemeriksaan</label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="text" id="hasil_<?php echo $key; ?>" class="form-control" name="hasil[]" required="required" value="<?php echo $labor_item->hasil ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label for="eps_number_<?php echo $key; ?>" class="col-form-label col-md-3 col-sm-3 label-align">Periode Pemeriksaan (bulan)</label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input id="eps_number_<?php echo $key; ?>" class="form-control" type="text" name="eps_number[]" value="<?php echo $labor_item->episode_number ?>" readonly>
                                                    </div>
                                                </div>
                                                <hr>


                                            <?php endif; ?>

                                        <?php endforeach; ?>

                                        <div id="manual-forms">
                                        </div>
                                        <div style="display: none;" id="btn-update">
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="status"></label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <button type="button" class="btn btn-primary" id="update-form-btn" onclick="simpan_pemeriksaan('<?= $pasien->encounter_local_id ?>')"><i class="fa fa-floppy-disk"></i> Simpan </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="item form-group">
                                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="status"></label>
                                            <div class="col-md-6 col-sm-6 ">
                                                <button type="button" class="btn btn-success" id="add-form-btn" onclick="add_pemeriksaan()"><i class="fa fa-add"></i> Tambah Pemeriksaan Baru</button>
                                            </div>
                                        </div>
                                    <?php endif; ?>


                                    <div class="x_title">
                                        <h2>Obat</h2>
                                        <div class="clearfix"></div>
                                    </div>

                                    <?php if (empty($obat) || count($obat) === 0) : ?>
                                        <!-- Display this when the data array is empty -->
                                        <div class="item form-group">
                                            <div class="col-md-6 col-sm-6 offset-md-3">
                                                <p>Belum ada data obat</p>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <!-- Display this section if the data is available -->
                                        <?php foreach ($obat as $item) : ?>
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="kode_kfa_<?php echo $item->kfa_code; ?>">Kode KFA</label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="text" id="kode_kfa_<?php echo $item->kfa_code; ?>" name="kode_kfa[]" required="required" class="form-control" value="<?php echo $item->kfa_code; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama_kfa_<?php echo $item->kfa_code; ?>">Nama KFA</label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="text" id="nama_kfa_<?php echo $item->kfa_code; ?>" name="nama_kfa[]" required="required" class="form-control" value="<?php echo $item->kfa_name; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="kode_form_<?php echo $item->kfa_code; ?>">Kode Form</label>
                                                <div class="col-md-6 col-sm-6 ">
                                                    <input type="text" id="kode_form_<?php echo $item->kfa_code; ?>" name="kode_form[]" class="form-control" value="<?php echo $item->form_code; ?>" readonly>
                                                </div>
                                            </div>
                                            <hr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                    <div class="modal fade" id="updateLabor" tabindex="-1" aria-labelledby="updateLabor" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="updateLabor">Update Data Labor</h5>
                                                    <button type="button" class="btn btn-danger" onclick="close_modal_update_labor()" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-x"></i></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="item form-group">
                                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="modal_observ_id">ID Pemeriksaan </label>
                                                        <div class="col-md-6 col-sm-6">
                                                            <input type="text" id="modal_observ_id" name="modal_observ_id[]" required="required" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="modal_type_obs">Jenis Pemeriksaan</label>
                                                        <div class="col-md-6 col-sm-6">
                                                            <select id="modal_type_obs" name="modal_type_obs[]" required="required" class="form-control">
                                                                <option value="">-- Pilih Jenis Pemeriksaan --</option>
                                                                <option value="microscopic" <?php echo ($labor_item->type_observation == 'microscopic') ? 'selected' : ''; ?>> Mikroskopis</option>
                                                                <option value="tcm" <?php echo ($labor_item->type_observation == 'tcm') ? 'selected' : ''; ?>> Test Cepat Molekuler </option>
                                                                <option value="culture-treatment" <?php echo ($labor_item->type_observation == 'culture-treatment') ? 'selected' : ''; ?>> Biakan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label for="modal_issued" class="col-form-label col-md-3 col-sm-3 label-align">Waktu Pemeriksaan </label>
                                                        <div class="col-md-6 col-sm-6">
                                                            <input id="modal_issued" class="form-control" type="datetime-local" name="modal_issued[]">
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="cara_input" name="cara_input" value="<?php echo $labor_item->cara_input ?>">
                                                    <div class="item form-group">
                                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="modal_hasil">Hasil Pemeriksaan</label>
                                                        <div class="col-md-6 col-sm-6">
                                                            <select id="modal_hasil" name="modal_hasil[]" required="required" class="form-control">
                                                                <option value="">-- Pilih Hasil Pemeriksaan --</option>
                                                                <optgroup label="Mikroskopis">
                                                                    <hr>
                                                                    <option value="neg" <?php echo ($labor_item->hasil == 'neg') ? 'selected' : ''; ?>>Negatif</option>
                                                                    <option value="1+" <?php echo ($labor_item->hasil == '1+') ? 'selected' : ''; ?>>1+</option>
                                                                    <option value="2+" <?php echo ($labor_item->hasil == '2+') ? 'selected' : ''; ?>>2+</option>
                                                                    <option value="3+" <?php echo ($labor_item->hasil == '3+') ? 'selected' : ''; ?>>3+</option>
                                                                    <option value="1" <?php echo ($labor_item->hasil == '1-9') ? 'selected' : ''; ?>>1-9 (Range)</option>
                                                                    <option value="tidak dilakukan" <?php echo ($labor_item->hasil == 'tidak dilakukan') ? 'selected' : ''; ?>>tidak dilakukan</option>
                                                                </optgroup>

                                                                <optgroup label="Tes cepat Molekuler">
                                                                    <hr>
                                                                    <option value="neg" <?php echo ($labor_item->hasil == 'neg') ? 'selected' : ''; ?>>Negatif</option>
                                                                    <option value="rif-sen" <?php echo ($labor_item->hasil == 'rif-sen') ? 'selected' : ''; ?>>Rifampicin Sensitive</option>
                                                                    <option value="rif-res" <?php echo ($labor_item->hasil == 'rif-res') ? 'selected' : ''; ?>>Rifampicin Resistant</option>
                                                                    <option value="rif-indet" <?php echo ($labor_item->hasil == 'rif-indet') ? 'selected' : ''; ?>>Rifampicin Indeterminate</option>
                                                                    <option value="invalid" <?php echo ($labor_item->hasil == 'invalid') ? 'selected' : ''; ?>>invalid</option>
                                                                    <option value="error" <?php echo ($labor_item->hasil == 'error') ? 'selected' : ''; ?>>error</option>
                                                                    <option value="no result" <?php echo ($labor_item->hasil == 'no result') ? 'selected' : ''; ?>>no result</option>
                                                                </optgroup>
                                                                <!-- Tambahkan lebih banyak opsi sesuai kebutuhan -->
                                                                <optgroup label="Biakan">
                                                                    <hr>
                                                                    <option value="neg" <?php echo ($labor_item->hasil == 'neg') ? 'selected' : ''; ?>>Negatif</option>
                                                                    <option value="1" <?php echo ($labor_item->hasil == '1-9') ? 'selected' : ''; ?>>1-9 (Range)</option>
                                                                    <option value="1+" <?php echo ($labor_item->hasil == '1+') ? 'selected' : ''; ?>>1+</option>
                                                                    <option value="2+" <?php echo ($labor_item->hasil == '2+') ? 'selected' : ''; ?>>2+</option>
                                                                    <option value="3+" <?php echo ($labor_item->hasil == '3+') ? 'selected' : ''; ?>>3+</option>
                                                                    <option value="4+" <?php echo ($labor_item->hasil == '4+') ? 'selected' : ''; ?>>4+</option>
                                                                    <option value="ntm" <?php echo ($labor_item->hasil == 'ntm') ? 'selected' : ''; ?>>ntm</option>
                                                                    <option value="kontaminasi" <?php echo ($labor_item->hasil == 'kontaminasi') ? 'selected' : ''; ?>>kontaminasi</option>
                                                                    <option value="tidak dilakukan" <?php echo ($labor_item->hasil == 'tidak dilakukan') ? 'selected' : ''; ?>>Tidak Dilakukan</option>
                                                                    <!-- Tambahkan lebih banyak opsi sesuai kebutuhan -->
                                                                </optgroup>

                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div id="rifampicin_modal" style="display: none;">
                                                        <div class="item form-group">
                                                            <label for="issued_rifampicin_modal" class="col-form-label col-md-3 col-sm-3 label-align">Waktu Rifampicin </label>
                                                            <div class="col-md-6 col-sm-6">
                                                                <input id="issued_rifampicin_modal" class="form-control" type="datetime-local" name="issued_rifampicin_modal[]">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="item form-group">
                                                        <label for="modal_period_number" class="col-form-label col-md-3 col-sm-3 label-align">Periode Pemeriksaan (bulan) </label>
                                                        <div class="col-md-6 col-sm-6">
                                                            <select id="modal_period_number" name="modal_period_number[]" required="required" class="form-control">
                                                                <option value="">-- Pilih Periode Pemeriksaan Bulan --</option>
                                                                <option value="1" <?php echo ($labor_item->episode_number == '1') ? 'selected' : ''; ?>>1</option>
                                                                <option value="2" <?php echo ($labor_item->episode_number == '2') ? 'selected' : ''; ?>>2</option>
                                                                <option value="3" <?php echo ($labor_item->episode_number == '3') ? 'selected' : ''; ?>>3</option>
                                                                <option value="5" <?php echo ($labor_item->episode_number == '5') ? 'selected' : ''; ?>>5</option>
                                                                <option value="6" <?php echo ($labor_item->episode_number == '6') ? 'selected' : ''; ?>>6</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <button type="submit" class="btn btn-primary" onclick="updateDataLabor()">Simpan</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="x_title">
                                        <h2>Episode Perawatan</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <!-- <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="ihs_id">IHS ID
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="ihs_id" required="required" class="form-control" name="ihs_id" value="">
                                        </div>
                                    </div> -->
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="id_tb">ID-TB-03
                                        </label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="id_tb" name="id_tb" required="required" class="form-control" value="<?php echo $pasien->episode_of_care_id_tb_03 ?>">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label for="status_berobat" class="col-form-label col-md-3 col-sm-3 label-align">Status</label>
                                        <div class="col-md-6 col-sm-6">
                                            <select id="status_berobat" class="form-control" name="status_berobat">
                                                <!-- Opsi default, akan terpilih jika $pasien->status_berobat kosong -->
                                                <option value="" disabled <?= empty($pasien->episode_of_care_status) ? 'selected' : '' ?>>Pilih status Pengobatan</option>

                                                <!-- Opsi lainnya, sesuai dengan data dari database -->
                                                <option value="planned" <?= ($pasien->episode_of_care_status == 'planned') ? 'selected' : '' ?>>Episode perawatan direncanakan dimulai pada waktu yang tertulis di period_start</option>
                                                <option value="waitlist" <?= ($pasien->episode_of_care_status == 'waitlist') ? 'selected' : '' ?>>Episode perawatan dalam antrian</option>
                                                <option value="active" <?= ($pasien->episode_of_care_status == 'active') ? 'selected' : '' ?>> Episode perawatan sedang berlangsung</option>
                                                <option value="onhold" <?= ($pasien->episode_of_care_status == 'onhold') ? 'selected' : '' ?>> Episode perawatan dihentikan sementara</option>
                                                <option value="finished" <?= ($pasien->episode_of_care_status == 'finished') ? 'selected' : '' ?>> Episode perawatan selesai dilakukan</option>
                                                <option value="canceled" <?= ($pasien->episode_of_care_status == 'canceled') ? 'selected' : '' ?>>Episode perawatan dibatalkan</option>
                                                <option value="entered-in-error" <?= ($pasien->episode_of_care_status == 'entered-in-error') ? 'selected' : '' ?>>Seharusnya tidak menjadibagian dari rekam medis</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label for="type_code" class="col-form-label col-md-3 col-sm-3 label-align">Type Code</label>
                                        <div class="col-md-6 col-sm-6">
                                            <select id="type_code" class="form-control" name="type_code">
                                                <!-- Opsi default, akan terpilih jika $pasien->type_code kosong -->
                                                <option value="" disabled <?= empty($pasien->episode_of_care_type_code) ? 'selected' : '' ?>>Pilih tipe kode</option>

                                                <!-- Opsi lainnya sesuai dengan data dari database -->
                                                <option value="TB-SO" <?= ($pasien->episode_of_care_type_code == 'TB-SO') ? 'selected' : '' ?>>TB-SO</option>
                                                <option value="TB-RO" <?= ($pasien->episode_of_care_type_code == 'TB-RO') ? 'selected' : '' ?>>TB-RO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="type_diagnosis">Tipe Diagnosa</label>
                                        <div class="col-md-6 col-sm-6">
                                            <input type="text" id="type_diagnosis" name="type_diagnosis" required="required" class="form-control"
                                                value="<?php echo ($pasien->diagnosis_type == 'tb-bac') ? 'Terkonfirmasi Bakteriologis' : (($pasien->diagnosis_type == 'tb-clin') ? 'Terdiagnosis Klinis' : $pasien->diagnosis_type); ?>">
                                        </div>
                                    </div> -->

                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="type_diagnosis">Tipe Diagnosa</label>
                                        <div class="col-md-6 col-sm-6">
                                            <select id="type_diagnosis" name="type_diagnosis" required="required" class="form-control">
                                                <option value="other" <?php echo (empty($pasien->diagnosis_type) || !in_array($pasien->diagnosis_type, ['tb-bac', 'tb-clin'])) ? 'selected' : ''; ?>>
                                                    Silahkan pilih tipe diagnosa
                                                </option>
                                                <option value="tb-bac" <?php echo ($pasien->diagnosis_type == 'tb-bac') ? 'selected' : ''; ?>>
                                                    Terkonfirmasi Bakteriologis
                                                </option>
                                                <option value="tb-clin" <?php echo ($pasien->diagnosis_type == 'tb-clin') ? 'selected' : ''; ?>>
                                                    Terdiagnosis Klinis
                                                </option>
                                            </select>
                                        </div>
                                    </div>



                                    <!-- <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="location_anatomi">Lokasi Anatomi</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input type="text" id="location_anatomi" name="location_anatomi" required="required" class="form-control"
                                                value="<?php echo ($pasien->diagnosis_location_anatomi == 'PTB') ? ' TB Paru' : (($pasien->diagnosis_location_anatomi == 'EPTB') ? 'TB Ekstra Paru' : $pasien->diagnosis_location_anatomi); ?>">
                                        </div>
                                    </div> -->
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="location_anatomi">Lokasi Anatomi</label>
                                        <div class="col-md-6 col-sm-6">
                                            <select id="location_anatomi" name="location_anatomi" required="required" class="form-control">
                                                <option value="PTB" <?php echo ($pasien->diagnosis_location_anatomi == 'PTB') ? 'selected' : ''; ?>>
                                                    TB Paru
                                                </option>
                                                <option value="EPTB" <?php echo ($pasien->diagnosis_location_anatomi == 'EPTB') ? 'selected' : ''; ?>>
                                                    TB Ekstra Paru
                                                </option>
                                                <option value="other" <?php echo (!in_array($pasien->diagnosis_location_anatomi, ['PTB', 'EPTB'])) ? 'selected' : ''; ?>>
                                                    Silahkan pilih lokasi anatomi
                                                </option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="item form-group">
                                        <label for="treatment_history" class="col-form-label col-md-3 col-sm-3 label-align">Riwayat Pengobatan</label>
                                        <div class="col-md-6 col-sm-6">
                                            <select id="treatment_history" class="form-control" name="treatment_history">
                                                <!-- Cek apakah $pasien->treatment_history kosong, jika iya tampilkan "Pilih Sejarah Perawatan" -->
                                                <option value="" <?= empty($pasien->treatment_history) ? 'selected' : '' ?>>Pilih Riwayat Pengobatan</option>

                                                <!-- Tambahkan opsi dengan kondisi terpilih jika datanya ada -->
                                                <option value="new" <?= ($pasien->treatment_history == 'new') ? 'selected' : '' ?>>Kasus Baru</option>
                                                <option value="relapse" <?= ($pasien->treatment_history == 'relapse') ? 'selected' : '' ?>>Kasus Kambuh</option>
                                                <option value="failure" <?= ($pasien->treatment_history == 'failure') ? 'selected' : '' ?>>Kasus pengobatan setelah gagal</option>
                                                <option value="failure-cat1" <?= ($pasien->treatment_history == 'failure-cat1') ? 'selected' : '' ?>>Kasus pengobatan setelah gagal kategori 1</option>
                                                <option value="failure-cat2" <?= ($pasien->treatment_history == 'failure-cat2') ? 'selected' : '' ?>>Kasus pengobatan setelah gagal kategori 2</option>
                                                <option value="failure-2line" <?= ($pasien->treatment_history == 'failure-2line') ? 'selected' : '' ?>>Kasus pengobatan setelah gagal lini 2</option>
                                                <option value="loss-to-follow-up" <?= ($pasien->treatment_history == 'loss-to-follow-up') ? 'selected' : '' ?>>Kasus Setelah Lose to follow Up</option>
                                                <option value="other" <?= ($pasien->treatment_history == 'other') ? 'selected' : '' ?>>Kasus Lain</option>
                                                <option value="unknown" <?= ($pasien->treatment_history == 'unknown') ? 'selected' : '' ?>>Kasus dengan riwayat pengobatan tidak diketahui</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label for="period_start" class="col-form-label col-md-3 col-sm-3 label-align">Tanggal Mulai Pengobatan</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input id="period_start" class="form-control" type="text" name="period_start" value="<?php echo $pasien->episode_of_care_period_start ?>">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label for="period_end" class="col-form-label col-md-3 col-sm-3 label-align">Tanggal Selesai Pengobatan</label>
                                        <div class="col-md-6 col-sm-6 ">
                                            <input id="period_end" class="form-control" type="date" name="period_end" value="<?php echo date('Y-m-d', strtotime($pasien->period_end)); ?>">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label for="end_result" class="col-form-label col-md-3 col-sm-3 label-align">Hasil Akhir Pengobatan</label>
                                        <div class="col-md-6 col-sm-6">
                                            <select id="end_result" class="form-control" name="end_result">
                                                <!-- Cek apakah $pasien->end_result_treatment kosong, jika iya tampilkan "Pilih Hasil Akhir Perawatan" -->
                                                <option value="" <?= empty($pasien->end_result_treatment) ? 'selected' : '' ?>>Pilih hasil akhir pengobatan</option>
                                                <option value="cured" <?= ($pasien->end_result_treatment == 'cured') ? 'selected' : '' ?>>Cured</option>
                                                <option value="cmpl" <?= ($pasien->end_result_treatment == 'cmpl') ? 'selected' : '' ?>>Cmpl</option>
                                                <option value="failed" <?= ($pasien->end_result_treatment == 'failed') ? 'selected' : '' ?>>Failed</option>
                                                <option value="died" <?= ($pasien->end_result_treatment == 'died') ? 'selected' : '' ?>>Died</option>
                                                <option value="loss-to-follow-up" <?= ($pasien->end_result_treatment == 'loss-to-follow-up') ? 'selected' : '' ?>>Loss-to-follow up</option>
                                                <option value="not-eval" <?= ($pasien->end_result_treatment == 'not-eval') ? 'selected' : '' ?>>Not Eval</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <div class="col-md-6 col-sm-6 offset-md-3">
                                            <!-- <button class="btn btn-primary" type="button">Cancel</button>
                                                <button class="btn btn-primary" type="reset">Reset</button> -->
                                            <a href="javascript:void(0)" onclick="update('<?= $pasien->encounter_local_id ?>')" class="btn btn-success"><i class="fa fa-floppy-disk"></i> Simpan</a>
                                        </div>
                                    </div>
                                    <!-- </form> -->
                                </div>
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
        $(document).ready(function() {
            // $('#other_name').select2({
            //     placeholder: "Pilih Nama Diagnosis", // Placeholder default
            //     allowClear: true // Menambahkan tombol 'clear' untuk menghapus pilihan
            // });

            if ($('#rifampicin_manual').is(':hidden')) {
                // Nonaktifkan input jika div tidak ditampilkan
                $('#issued_rifampicin_manual').prop('disabled', true);
            }

            $('#manual_hasil').change(function() {
                var selectedValue = $(this).val();
                if (selectedValue === 'rif-sen' || selectedValue === 'rif-res' || selectedValue === 'rif-indet') {
                    $('#rifampicin_manual').show(); // Tampilkan div
                    $('#issued_rifampicin_manual').prop('disabled', false); // Aktifkan input
                } else {
                    $('#rifampicin_manual').hide(); // Sembunyikan div
                    $('#issued_rifampicin_manual').prop('disabled', true); // Nonaktifkan input
                }
            });

            document.getElementById('type_observ').addEventListener('change', function() {
                var typeObserv = this.value;
                var hasilSelect = document.getElementById('hasil');
                var rifampicinDiv = document.getElementById('rifampicin');

                // Kosongkan opsi sebelumnya
                hasilSelect.innerHTML = '<option value="">-- Pilih Hasil Pemeriksaan --</option>';

                if (typeObserv === 'microscopic') {
                    // Opsi untuk pemeriksaan 'microscopic'
                    var options = ['neg', '1-9(range)', '1+', '2+', '3+', 'tidak dilakukan'];
                } else if (typeObserv === 'tcm') {
                    // Opsi untuk pemeriksaan 'tcm'
                    //var options = ['neg', 'rif-sen', 'rif-res', 'rif-indet', 'invalid', 'error', 'no result'];
                    var options = ['neg', 'rif-sen', 'rif-res', 'rif-indet'];
                } else if (typeObserv === 'culture-treatment') {
                    // Opsi untuk pemeriksaan 'culture-treatment'
                    var options = ['neg', '1-9(range)', '1+', '2+', '3+', '4+', 'ntm', 'kontaminasi', 'tidak dilakukan'];
                } else {
                    // Opsi default jika tidak ada jenis yang cocok
                    var options = ['tidak ada hasil'];
                }

                // Tambahkan opsi ke select hasil
                options.forEach(function(optionText) {
                    var option = document.createElement('option');
                    option.value = optionText;
                    option.textContent = optionText;
                    hasilSelect.appendChild(option);
                });

                hasilSelect.addEventListener('change', function() {
                    var selectedHasil = this.value;

                    // Tampilkan atau sembunyikan div rifampicin berdasarkan hasil yang dipilih
                    if (selectedHasil === 'rif-sen' || selectedHasil === 'rif-res' || selectedHasil === 'rif-indet') {
                        rifampicinDiv.style.display = 'block'; // Tampilkan div Rifampicin
                    } else {
                        rifampicinDiv.style.display = 'none'; // Sembunyikan jika hasil bukan Rifampicin
                    }
                });
            });

        });

        $('#kode_diag_dokter').on('input', function() {
            let query = $(this).val();

            if (query.length >= 1) { // Mulai cari setelah mengetik satu huruf
                $.ajax({
                    url: '<?= site_url("DataController/getKodeDiagnosa") ?>',
                    type: 'GET',
                    data: {
                        q: query
                    },
                    dataType: 'json',
                    success: function(data) {
                        const suggestionsBox = $('#suggestions-box');
                        suggestionsBox.empty();

                        if (data.length > 0) {
                            suggestionsBox.show();
                            data.forEach(item => {
                                // Format teks yang akan ditampilkan
                                const suggestionText = `${item.id_diagnosa} | ${item.nama_diagnosa}`;
                                const suggestionItem = $('<div>')
                                    .addClass('suggestion-item')
                                    .text(suggestionText);

                                // Menangani klik pada item saran
                                suggestionItem.on('click', function() {
                                    // Mengisi input dengan kode dan nama
                                    $('#kode_diag_dokter').val(suggestionText);
                                    suggestionsBox.hide(); // Menyembunyikan saran setelah klik

                                    // Memisahkan nilai id_diagnosa dan nama_diagnosa
                                    const parts = suggestionText.split(' | ');
                                    const idDiagnosa = parts[0].trim(); // id_diagnosa
                                    const namaDiagnosa = parts[1].trim(); // nama_diagnosa

                                    // Sekarang kamu bisa menggunakan idDiagnosa dan namaDiagnosa
                                    console.log('ID Diagnosa:', idDiagnosa);
                                    console.log('Nama Diagnosa:', namaDiagnosa);

                                    // Contoh: Mengisi input lain dengan nilai terpisah
                                    $('#id_diagnosa').val(idDiagnosa);
                                    $('#nama_diagnosa').val(namaDiagnosa);
                                });

                                suggestionsBox.append(suggestionItem);
                            });
                        } else {
                            suggestionsBox.hide(); // Jika tidak ada hasil
                        }
                    }
                });
            } else {
                $('#suggestions-box').hide(); // Jika input kosong
            }
        });


        $('#kode_diag').on('input', function() {
            let query = $(this).val();

            if (query.length >= 1) { // Mulai cari setelah mengetik satu huruf
                $.ajax({
                    url: '<?= site_url("DataController/getDiag") ?>',
                    type: 'GET',
                    data: {
                        q: query
                    },
                    dataType: 'json',
                    success: function(data) {
                        const suggestionsBox = $('#suggestions-box2');
                        suggestionsBox.empty();

                        if (data.length > 0) {
                            suggestionsBox.show();
                            data.forEach(item => {
                                // Format teks yang akan ditampilkan
                                const suggestionText = `${item.id_diagnosa} | ${item.nama_diagnosa}`;
                                const suggestionItem = $('<div>')
                                    .addClass('suggestion-item')
                                    .text(suggestionText);

                                // Menangani klik pada item saran
                                suggestionItem.on('click', function() {
                                    // Mengisi input dengan kode
                                    $('#kode_diag').val(`${item.id_diagnosa} | ${item.nama_diagnosa}`);
                                    suggestionsBox.hide(); // Menyembunyikan saran setelah klik
                                });

                                suggestionsBox.append(suggestionItem);
                            });
                        } else {
                            suggestionsBox.hide(); // Jika tidak ada hasil
                        }
                    }
                });
            } else {
                $('#suggestions-box2').hide(); // Jika input kosong
            }
        });


        document.getElementById('modal_hasil').addEventListener('change', function() {
            var selectedValue = this.value;
            var rifampicinModal = document.getElementById('rifampicin_modal');

            // Jika salah satu dari 'rif-sen', 'rif-res', atau 'rif-ident' dipilih, tampilkan modal
            if (selectedValue === 'rif-sen' || selectedValue === 'rif-res' || selectedValue === 'rif-indet') {
                rifampicinModal.style.display = 'block';
            } else {
                rifampicinModal.style.display = 'none';
            }
        });

        function updateDataLabor() {
            // Gather the form data
            // var formData = $('#updateLabor').serialize(); // Serialize the form data
            var modal_observ_id = $('#modal_observ_id').val();
            var modal_type_obs = $('#modal_type_obs').val();
            var modal_issued = $('#modal_issued').val();
            var modal_hasil = $('#modal_hasil').val();
            var issued_rifampicin_modal = $('#issued_rifampicin_modal').val();
            var modal_period_number = $('#modal_period_number').val();
            // AJAX request to send the data to the server
            $.ajax({
                url: '<?= base_url("DataController/update_data_labor") ?>', // Replace with your actual update endpoint
                type: 'POST',
                data: {
                    modal_observ_id: modal_observ_id,
                    modal_type_obs: modal_type_obs,
                    modal_issued: modal_issued,
                    modal_hasil: modal_hasil,
                    issued_rifampicin_modal: issued_rifampicin_modal,
                    modal_period_number: modal_period_number
                },
                success: function(response) {
                    // Handle the response from the server
                    if (response.status == "success") {
                        Swal.fire({
                            title: "Success!",
                            text: "Data berhasil di update!",
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirect setelah user menekan OK pada Swal
                                $('#updateLabor').modal('hide');
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: 'Gagal memperbarui data pasien!'
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
        // Attach the submit event to the form


        $('#manual_type_obs').on('change', function() {
            var typeObs = $(this).val(); // Ambil value dari dropdown Jenis Pemeriksaan
            var hasilSelect = $('#manual_hasil');

            // Kosongkan opsi sebelumnya
            hasilSelect.html('<option value="">-- Pilih Hasil Pemeriksaan --</option>');

            // Jika jenis pemeriksaan dipilih, lakukan request AJAX ke server
            if (typeObs) {
                $.ajax({
                    url: '<?= base_url("DataController/getHasilPemeriksaan") ?>',
                    type: 'POST',
                    data: {
                        type_obs: typeObs
                    },
                    success: function(response) {
                        var options = JSON.parse(response);

                        // Tambahkan opsi baru ke select hasil
                        $.each(options, function(index, value) {
                            hasilSelect.append('<option value="' + value + '">' + value + '</option>');
                        });
                        $('#rifampicin_manual').hide(); // Sembunyikan div
                        $('#issued_rifampicin_manual').prop('disabled', true); // Nonaktifkan input
                    }
                });
            }
        });




        function update(id) {
            // Ambil data dari form dengan id "demo-form2"
            var nama = $('#patient_name').val();
            var nik = $('#nik').val();
            var gender = $('#gender').val();
            var ttl = $('#ttl').val();
            var prov = $('#prov').val();
            var distrik = $('#distrik').val();
            var alamat = $('#alamat').val();
            var id_diag = $('#id_diagnosa').val(); // Mengambil kode diagnosa
            var nama_diag = $('#nama_diagnosa').val(); // Mengambil kode diagnosa
            var kodeDiagPer = $('#kode_diag').val();
            var local_id = id;
            var klasifikasi = $('#klasifikasi').val();
            var enc_period_start = $('#enc_period_start').val();
            var enc_period_in_progress = $('#enc_period_in_progress').val();
            var enc_period_end = $('#enc_period_end').val();
            var type_diagnosis = $('#type_diagnosis').val();
            var location_anatomi = $('#location_anatomi').val();
            var treatment_history = $('#treatment_history').val();
            var end_result = $('#end_result').val();
            var status = $('#status').val();
            var kode_kfa = $('#kode_kfa').val();
            var nama_kfa = $('#nama_kfa').val();
            var kode_form = $('#kode_form').val();
            // var observ_id = $('#observ_id').val();
            // var type_observ = $('#type_observ').val();
            // var issued = $('#issued').val();
            // var hasil = $('#hasil').val();
            // if (issued) {
            //     issued = issued.replace("T", " ") + ":00";
            // }
            var period_number = $('#period_number').val();

            // Ambil semua inputan yang memiliki name="lid[]", "type_obs[]", dll.
            // var lids = $('input[name="lid[]"]').map(function() {
            //     return $(this).val();
            // }).get();
            // var type_obs = $('input[name="type_obs[]"]').map(function() {
            //     return $(this).val();
            // }).get();
            // var issueds = $('input[name="issued[]"]').map(function() {
            //     return $(this).val();
            // }).get();
            // var hasils = $('input[name="hasil[]"]').map(function() {
            //     return $(this).val();
            // }).get();
            // var eps_numbers = $('input[name="eps_number[]"]').map(function() {
            //     return $(this).val();
            // }).get();


            // var labor_input = $('#labor_cara_input').val();
            // var manual_observ_id = $('#manual_observ_id').val();
            // var manual_type_obs = $('#manual_type_obs').val();
            // var manual_issued = $('#manual_issued').val();
            // var manual_hasil = $('#manual_hasil').val();
            // var manual_period_number = $('#manual_period_number').val();
            // var cara_input = $('#cara_input').val();
            var ihs_id = $('#ihs_id').val();
            var id_tb = $('#id_tb').val();
            var status_berobat = $('#status_berobat').val();
            var type_code = $('#type_code').val();
            var period_start = $('#period_start').val();
            var period_end = $('#period_end').val();
            // Jalankan AJAX request
            $.ajax({
                url: '<?= base_url("DataController/edit_data") ?>', // Ganti dengan URL Controller yang sesuai
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
                    // cara_input: cara_input,
                    // labor_input: labor_input,
                    location_anatomi: location_anatomi,
                    treatment_history: treatment_history,
                    end_result: end_result,
                    status: status,
                    kode_kfa: kode_kfa,
                    nama_kfa: nama_kfa,
                    kode_form: kode_form,
                    // observ_id: observ_id,
                    // type_observ: type_observ,
                    // issued: issued,
                    // hasil: hasil,
                    id_diag: id_diag,
                    nama_diag: nama_diag,
                    kodeDiagPer: kodeDiagPer,
                    period_number: period_number,
                    // manual_observ_id: manual_observ_id,
                    // manual_type_obs: manual_type_obs,
                    // manual_issued: manual_issued,
                    // manual_hasil: manual_hasil,
                    // manual_period_number: manual_period_number,
                    // lid: lids, // Kirim array lids
                    // type_obs: type_obs, // Kirim array type_obs
                    // issueds: issueds, // Kirim array issued
                    // hasils: hasils, // Kirim array hasil
                    // eps_numbers: eps_numbers, // Kirim array eps_number
                    ihs_id: ihs_id,
                    id_tb: id_tb,
                    status_berobat: status_berobat,
                    type_code: type_code,
                    period_start: period_start,
                    period_end: period_end
                }, // Data yang akan dikirim
                success: function(response) {
                    // Callback jika request berhasil
                    if (response.status == 'success') {
                        Swal.fire({
                            title: "Success!",
                            text: "Data berhasil di update!",
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirect setelah user menekan OK pada Swal
                                window.location.href = "<?= base_url('DataController/data_terkirim') ?>";
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: 'Gagal memperbarui data pasien!'
                        });
                    }

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

        // window.onload = function() {
        //     var additionalDiagnosis = document.getElementById('additionalDiagnosis');
        //     if (additionalDiagnosis) {
        //         additionalDiagnosis.style.display = 'block';
        //     } else {
        //         additionalDiagnosis.style.display = 'none';
        //     }
        // };


        function toggleEndResult() {
            var statusBerobat = document.getElementById('status_berobat');
            var endResult = document.getElementById('end_result');
            var period_end = document.getElementById('period_end');
            var ihs_id = document.getElementById('ihs_id').value;
            var id_tb = document.getElementById('id_tb').value;

            // Disable fields jika treatment_history adalah "new"
            if (statusBerobat.value === 'active') {
                endResult.disabled = true;
                endResult.value = ""; // Reset pilihan
                period_end.disabled = true;
                period_end.value = "";
                document.getElementById('ihs_id').disabled = true;
                document.getElementById('id_tb').disabled = true;
            } else {
                endResult.disabled = false;
                period_end.disabled = false;
                document.getElementById('ihs_id').disabled = true;
                document.getElementById('id_tb').disabled = true;
            }

            // Cek jika id_tb dan ihs_id sudah ada, disable opsi "new" pada treatment_history
            if (id_tb !== "" && ihs_id !== "") {
                var options = treatmentHistory.options;
                for (var i = 0; i < options.length; i++) {
                    if (options[i].value === "new") {
                        options[i].disabled = true; // Disable opsi "new"
                    }
                }
            } else {
                // Enable opsi "new" jika id_tb atau ihs_id kosong
                var options = statusBerobat.options;
                for (var i = 0; i < options.length; i++) {
                    if (options[i].value === "new") {
                        options[i].disabled = false; // Enable opsi "new"
                    }
                }
            }
        }



        // Panggil fungsi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            toggleEndResult(); // Set kondisi awal sesuai data yang ada
        });

        // Panggil fungsi setiap kali ada perubahan pada dropdown treatment_history
        document.getElementById('status_berobat').addEventListener('change', toggleEndResult);


        document.getElementById('toggleDiagnosis').addEventListener('click', function() {
            var additionalFields = document.getElementById('additionalDiagnosis');
            var other_name = document.getElementById('other_name');
            var other_icd = document.getElementById('other_icd');
            if (additionalFields.style.display === 'none' || additionalFields.style.display === '') {
                additionalFields.style.display = 'block'; // Show the fields
                other_name.disabled = false;
                other_icd.disabled = false;
            } else {
                additionalFields.style.display = 'none'; // Hide the fields
                other_name.disabled = true;
                other_icd.disabled = true;
                other_name.value = "";
                other_icd.value = "";
            }
        });



        function add_pemeriksaan() {
            // Dapatkan elemen container di mana semua form manual akan ditempatkan
            document.getElementById('btn-update').style.display = 'block';
            var container = document.getElementById('manual-forms');


            // Buat elemen div baru untuk form pemeriksaan baru
            var newForm = document.createElement('div');
            newForm.className = 'manual-form-group';

            // Buat unique id untuk elemen-elemen form baru
            var uniqueId = Date.now();

            // Isi dari form pemeriksaan baru
            newForm.innerHTML = `
        <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="manual_observ_id_new_${uniqueId}">ID Pemeriksaan</label>
            <div class="col-md-6 col-sm-6">
                <input type="text" id="manual_observ_id_new_${uniqueId}" name="manual_observ_id_new[]" required="required" class="form-control">
            </div>
        </div>

        <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="manual_type_obs_new_${uniqueId}">Jenis Pemeriksaan</label>
            <div class="col-md-6 col-sm-6">
                <select id="manual_type_obs_new_${uniqueId}" name="manual_type_obs_new[]" required="required" class="form-control">
                    <option value="">-- Pilih Jenis Pemeriksaan --</option>
                    <option value="microscopic"> Mikroskopis</option>
                    <option value="tcm"> Test Cepat Molekuler </option>
                    <option value="culture-treatment"> Biakan</option>
                </select>
            </div>
        </div>

        <div class="item form-group">
            <label for="manual_issued_new_${uniqueId}" class="col-form-label col-md-3 col-sm-3 label-align">Waktu Pemeriksaan</label>
            <div class="col-md-6 col-sm-6">
                <input id="manual_issued_new_${uniqueId}" class="form-control" type="datetime-local" name="manual_issued_new[]">
            </div>
        </div>

        <input type="hidden" id="cara_input_new_${uniqueId}" name="cara_input_new[]">

        <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="manual_hasil_new_${uniqueId}">Hasil Pemeriksaan</label>
            <div class="col-md-6 col-sm-6">
                <select id="manual_hasil_new_${uniqueId}" name="manual_hasil_new[]" required="required" class="form-control">
                    <option value="">-- Pilih Hasil Pemeriksaan --</option>
                </select>
            </div>
        </div>

        <div id="rifampicin_${uniqueId}" style="display: none;">
            <div class="item form-group">
                <label for="issued_rifampicin_new_${uniqueId}" class="col-form-label col-md-3 col-sm-3 label-align">Waktu Rifampicin </label>
                    <div class="col-md-6 col-sm-6">
                        <input id="issued_rifampicin_new_${uniqueId}" class="form-control" type="datetime-local" name="issued_rifampicin_new[]">
                    </div>
            </div>
        </div>

        <div class="item form-group">
            <label for="manual_period_number_new_${uniqueId}" class="col-form-label col-md-3 col-sm-3 label-align">Periode Pemeriksaan (Bulan) </label>
            <div class="col-md-6 col-sm-6">
                <select id="manual_period_number_new_${uniqueId}" name="manual_period_number_new[]" required="required" class="form-control">
                    <option value="">-- Pilih Periode Pemeriksaan Bulan --</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
            </div>
        </div>
        <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align"></label>
            <div class="col-md-6 col-sm-6">
                <button type="button" class="btn btn-danger" onclick="removeForm(${uniqueId})">Batal</button> 
            </div>
        </div>
        <hr>
    `;

            // Tambahkan form baru ke dalam container
            container.appendChild(newForm);

            updateSaveButtonVisibility();

            // Tambahkan event listener ke dropdown jenis pemeriksaan yang baru ditambahkan
            addHasilPemeriksaanListener(`manual_type_obs_new_${uniqueId}`, `manual_hasil_new_${uniqueId}`);
            show_issued_rifam(`manual_type_obs_new_${uniqueId}`, `manual_hasil_new_${uniqueId}`, `rifampicin_${uniqueId}`);
        }

        function removeForm(id) {
            var formToRemove = document.getElementById(`manual_observ_id_new_${id}`).closest('.manual-form-group');
            formToRemove.remove();

            updateSaveButtonVisibility();
        }


        function updateSaveButtonVisibility() {
            // Cek apakah ada form di dalam container
            var container = document.getElementById('manual-forms');
            if (container.children.length === 0) {
                document.getElementById('btn-update').style.display = 'none'; // Sembunyikan tombol simpan jika tidak ada form
            } else {
                document.getElementById('btn-update').style.display = 'block'; // Tampilkan tombol simpan jika ada form
            }
        }

        function simpan_pemeriksaan_empty(id) {
            var local_id = id;
            var observ_id = $('#observ_id').val();
            var type_observ = $('#type_observ').val();
            var issued = $('#issued').val();
            var hasil = $('#hasil').val();
            var issued_rifampicin = $('#issued_rifampicin').val();
            var period_number = $('#period_number').val();

            $.ajax({
                url: '<?= base_url("DataController/simpan_pemeriksaan_empty") ?>', // Ganti dengan URL Controller yang sesuai
                type: 'POST', // Metode pengiriman
                data: {
                    local_id: local_id,
                    observ_id: observ_id,
                    type_observ: type_observ,
                    issued: issued,
                    hasil: hasil,
                    issued_rifampicin: issued_rifampicin,
                    period_number: period_number
                }, // Data yang akan dikirim
                success: function(response) {
                    // Callback jika request berhasil
                    if (response.status == 'success') {
                        Swal.fire({
                            title: "Success!",
                            text: "Data berhasil di update!",
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: 'Gagal memperbarui data pasien!'
                        });
                    }
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

        function simpan_pemeriksaan(id) {
            // Kumpulkan semua nilai dari form
            var local_id = id;
            var manual_observ_id_new = $("input[name='manual_observ_id_new[]']").map(function() {
                return $(this).val();
            }).get();
            var manual_type_obs_new = $("select[name='manual_type_obs_new[]']").map(function() {
                return $(this).val();
            }).get();
            var manual_issued_new = $("input[name='manual_issued_new[]']").map(function() {
                return $(this).val();
            }).get();
            var cara_input_new = $("input[name='cara_input_new[]']").map(function() {
                return $(this).val();
            }).get();
            var manual_hasil_new = $("select[name='manual_hasil_new[]']").map(function() {
                return $(this).val();
            }).get();
            var issued_rifampicin_new = $("input[name='issued_rifampicin_new[]']").map(function() {
                return $(this).val();
            }).get();
            var manual_period_number_new = $("select[name='manual_period_number_new[]']").map(function() {
                return $(this).val();
            }).get();

            // Jalankan AJAX request
            $.ajax({
                url: '<?= base_url("DataController/edit_data_pemeriksaan") ?>', // Ganti dengan URL Controller yang sesuai
                type: 'POST', // Metode pengiriman
                data: {
                    local_id: local_id,
                    'manual_observ_id_new': manual_observ_id_new,
                    'manual_type_obs_new': manual_type_obs_new,
                    'manual_issued_new': manual_issued_new,
                    // 'cara_input_new': cara_input_new,
                    'issued_rifampicin_new': issued_rifampicin_new,
                    'manual_hasil_new': manual_hasil_new,
                    'manual_period_number_new': manual_period_number_new
                }, // Data yang akan dikirim
                success: function(response) {
                    // Callback jika request berhasil
                    if (response.status == 'success') {
                        Swal.fire({
                            title: "Success!",
                            text: "Data berhasil di update!",
                            icon: "success"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: 'Gagal memperbarui data pasien!'
                        });
                    }
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

        function show_issued_rifam(type_obs, hasilId, rifampicin) {
            // Tambahkan event listener ke dropdown hasil
            document.getElementById(hasilId).addEventListener('change', function() {
                var rifamp = document.getElementById(rifampicin);
                var selectedValue = this.value; // Mendapatkan nilai yang dipilih

                // Periksa apakah nilai yang dipilih adalah salah satu dari 'rif-sen', 'rif-res', atau 'rif-indet'
                if (selectedValue === "rif-sen" || selectedValue === "rif-res" || selectedValue === "rif-indet") {
                    rifamp.style.display = 'block'; // Tampilkan elemen waktu rifampicin
                } else {
                    rifamp.style.display = 'none'; // Sembunyikan elemen waktu rifampicin
                }
            });
        }



        function addHasilPemeriksaanListener(typeObsId, hasilId) {
            document.getElementById(typeObsId).addEventListener('change', function() {
                var hasilSelect = document.getElementById(hasilId);
                var selectedValue = this.value;

                // Bersihkan opsi sebelumnya
                hasilSelect.innerHTML = '<option value="">-- Pilih Hasil Pemeriksaan --</option>';

                // Tambahkan opsi berdasarkan nilai yang dipilih
                if (selectedValue === 'microscopic') {
                    hasilSelect.innerHTML += '<option value="neg">Negatif</option>';
                    hasilSelect.innerHTML += '<option value="1+">1+</option>';
                    hasilSelect.innerHTML += '<option value="2+">2+</option>';
                    hasilSelect.innerHTML += '<option value="3+">3+</option>';
                    hasilSelect.innerHTML += '<option value="1-9 (range)">1-9 (range)</option>';
                    hasilSelect.innerHTML += '<option value="tidak dilakukan">Tidak Dilakukan</option>';
                } else if (selectedValue === 'tcm') {
                    hasilSelect.innerHTML += '<option value="neg">Negatif</option>';
                    hasilSelect.innerHTML += '<option value="rif-sen"> Rifampicin Sensitive</option>';
                    hasilSelect.innerHTML += '<option value="rif-res"> Rifampicin Resistant</option>';
                    hasilSelect.innerHTML += '<option value="rif-indet"> Rifampicin Indeterminate</option>';
                    // hasilSelect.innerHTML += '<option value="invalid"> Invalid</option>';
                    // hasilSelect.innerHTML += '<option value="error"> Error</option>';
                    // hasilSelect.innerHTML += '<option value="no result"> No Result</option>';
                } else if (selectedValue === 'culture-treatment') {
                    hasilSelect.innerHTML += '<option value="neg">Negatif</option>';
                    hasilSelect.innerHTML += '<option value="1+">1+</option>';
                    hasilSelect.innerHTML += '<option value="2+">2+</option>';
                    hasilSelect.innerHTML += '<option value="3+">3+</option>';
                    hasilSelect.innerHTML += '<option value="1-9 (range)">1-9 (range)</option>';
                    hasilSelect.innerHTML += '<option value="ntm">ntm</option>';
                    hasilSelect.innerHTML += '<option value="kontaminasi">Kontaminasi</option>';
                    hasilSelect.innerHTML += '<option value="tidak dilakukan">Tidak Dilakukan</option>';
                }
            });
        }

        // Attach the add_pemeriksaan function to the button
        document.getElementById('add-form-btn').addEventListener('click', add_pemeriksaan);




        // function updateHasil() {
        //     var typeObs = document.getElementById('manual_type_obs').value;
        //     var hasilSelect = document.getElementById('manual_hasil');

        //     // Clear previous options
        //     hasilSelect.innerHTML = '<option value="">-- Pilih Hasil Pemeriksaan --</option>';

        //     // Set hasil options based on type_obs
        //     if (typeObs === 'microscopic') {
        //         hasilSelect.innerHTML += '<option value="+1">+1</option>';
        //         hasilSelect.innerHTML += '<option value="+2">+2</option>';
        //         hasilSelect.innerHTML += '<option value="+3">+3</option>';
        //         hasilSelect.innerHTML += '<option value="neg">Negatif</option>';
        //         hasilSelect.innerHTML += '<option value="tidak dilakukan">Tidak Dilakukan</option>';
        //     } else if (typeObs === 'tcm') {
        //         hasilSelect.innerHTML += '<option value="neg">Negatif</option>';
        //         hasilSelect.innerHTML += '<option value="rif-sen">rif-sen</option>';
        //         hasilSelect.innerHTML += '<option value="rif-res">rif-res</option>';
        //         hasilSelect.innerHTML += '<option value="rif-indet">rif-indet</option>';
        //         hasilSelect.innerHTML += '<option value="invalid">invalid</option>';
        //         hasilSelect.innerHTML += '<option value="error">error</option>';
        //         hasilSelect.innerHTML += '<option value="no result">no result</option>';
        //         // Add other options relevant to 'tcm' if needed
        //     } else if (typeObs === 'culture-treatment') {
        //         hasilSelect.innerHTML += '<option value="neg">Negatif</option>';
        //         hasilSelect.innerHTML += '<option value="1-9(range)">1-9(range)</option>';
        //         hasilSelect.innerHTML += '<option value="+1">+1</option>';
        //         hasilSelect.innerHTML += '<option value="+2">+2</option>';
        //         hasilSelect.innerHTML += '<option value="+3">+3</option>';
        //         hasilSelect.innerHTML += '<option value="+4">+4</option>';
        //         hasilSelect.innerHTML += '<option value="ntm">ntm</option>';
        //         hasilSelect.innerHTML += '<option value="kontaminasi">kontaminasi</option>';
        //         hasilSelect.innerHTML += '<option value="tidak dilakukan">Tidak Dilakukan</option>';
        //         // Add other options relevant to 'culture-treatment' if needed
        //     }
        // }

        // // Trigger the updateHasil function on page load to set initial state
        // document.addEventListener('DOMContentLoaded', function() {
        //     updateHasil(); // Call this to initialize the results based on the selected type
        // });

        function update_pemeriksaan(encounterId) {
            // Send an AJAX request to get data based on the encounterId
            $.ajax({
                url: '<?= base_url("DataController/get_data_labor") ?>', // Replace with your API or PHP file path
                type: 'POST', // Use GET to fetch data
                data: {
                    id: encounterId
                }, // Pass the encounterId as a parameter
                success: function(response) {
                    var data = JSON.parse(response); // If the response is a JSON string

                    // Set the values in the input fields
                    document.getElementById('modal_observ_id').value = data.local_id; // Assuming local_id is in the response
                    document.getElementById('modal_type_obs').value = data.type_observation; // Populate select input
                    document.getElementById('modal_issued').value = data.issued; // For datetime-local
                    var hasil_lab = document.getElementById('modal_hasil').value = data.hasil;
                    if (hasil_lab == "rif-sen" || hasil_lab == "rif-res" || hasil_lab == "rif-indet") {
                        $('#rifampicin_modal').show();
                    } else {
                        $('#rifampicin_modal').hide();
                    }
                    document.getElementById('issued_rifampicin_modal').value = data.issued_rifampicin; // Assuming 'value' holds the hasil
                    document.getElementById('modal_period_number').value = data.episode_number; // Assuming 'value' holds the hasil

                    $('#updateLabor').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                    alert('Failed to retrieve data. Please try again.');
                }
            });
        }

        function hapus_pemeriksaan(local_id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data pemeriksaan ini akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika dikonfirmasi, jalankan AJAX untuk menghapus data
                    $.ajax({
                        url: '<?= base_url("DataController/hapus_pemeriksaan") ?>', // URL untuk menghapus data
                        type: 'POST', // Method HTTP
                        data: {
                            local_id: local_id
                        }, // Data yang dikirimkan (ID yang akan dihapus)
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: "Success!",
                                    text: "Data pemeriksaan berhasil di Hapus!",
                                    icon: "success"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload(); // Reload halaman setelah konfirmasi
                                    }
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: 'Gagal menghapus data pemeriksaan!'
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: 'Terjadi kesalahan: ' + error
                            });
                        }
                    });
                }
            });
        }


        function close_modal_update_labor() {
            document.getElementById('modal_observ_id').value = '';
            document.getElementById('modal_type_obs').value = ''; // Assuming this is a select input
            document.getElementById('modal_issued').value = ''; // For datetime-local
            document.getElementById('modal_hasil').value = ''; // Assuming 'hasil' holds the hasil
            document.getElementById('issued_rifampicin_modal').value = ''; // Assuming this is an input
            document.getElementById('modal_period_number').value = ''; // Assuming this is an input
            $('#updateLabor').modal('hide');
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