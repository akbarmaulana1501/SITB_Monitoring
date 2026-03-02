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
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <ul class="nav side-menu">
                                <li><a href="<?= base_url() ?>./dataController/data_terkirim"><i class="fa fa-edit"></i> Data Pasien</a></li>
                                <li><a href="<?= base_url() ?>./dataController/data_gagal"> <i class="fa fa-desktop"></i> Log Pengiriman</a></li>
                                <!-- <li><a href="<?= base_url() ?>./dataController/get_log"><i class="fa fa-desktop"></i> Log Pengiriman</a></li> -->
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
                                    <img src="<?php base_url() ?>../resources/template/production/images/user.png" alt="">Hai, Admin
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="javascript:;"> Edit Profile</a>
                                    <a class="dropdown-item" href="javascript:;"> Edit Password</a>
                                    <!-- <a class="dropdown-item" href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                    </a> -->
                                    <!-- <a class="dropdown-item" href="javascript:;">Help</a> -->
                                    <a class="dropdown-item" href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <h3>Log Pengiriman</h3>
                        <!-- Check if log data exists -->
                        <?php if (!empty($log)): ?>
                            <?php foreach ($log as $log): ?>
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Log ID: <?php echo $log['ihs_id']; ?></h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <p><strong>ID TB:</strong> <?php echo $log['id_tb']; ?></p>
                                        <p><strong>Status:</strong> <?php echo $log['status']; ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No log data available.</p>
                        <?php endif; ?>
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
    <script src="<?php base_url() ?>../resources/template./vendors/Flot/jquery.flot.pie.js"></script>
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

    <!-- Custom Theme Scripts -->
    <script src="<?php base_url() ?>../resources/template/build/js/custom.min.js"></script>

</body>

</html>