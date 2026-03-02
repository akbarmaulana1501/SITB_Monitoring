<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php base_url() ?>./resources/template/production/images/logoIHC.png" type="image/ico" />

    <title>Login</title>

    <!-- Bootstrap -->
    <link href="<?php base_url() ?>./resources/template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php base_url() ?>./resources/template/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php base_url() ?>./resources/template/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php base_url() ?>./resources/template/vendors/animate.css/animate.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php base_url() ?>./resources/template/build/css/custom.min.css" rel="stylesheet">
</head>
<style>
    /* Container utama login */
    .login_container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 90vh;
        /* Penuh layar */
        background-color: #f7f7f7;
    }

    /* Wrapper untuk form login */
    .login_wrapper {
        background: white;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
    }

    /* Logo */
    .logo_container {
        text-align: center;
        margin-bottom: 20px;
    }

    /* Judul form login */
    .login_title {
        text-align: center;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    /* Grup input */
    .input_group {
        margin-bottom: 20px;
    }

    /* Input styling */
    .form-control {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    /* Tombol submit */
    .submit_container {
        text-align: center;
    }

    .btn-dark {
        background-color: #343a40;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        width: 100%;
    }

    .btn-dark:hover {
        background-color: #23272b;
    }

    /* Clearfix untuk mengatur layout */
    .clearfix {
        clear: both;
    }

    /* Responsif */
    @media (max-width: 768px) {
        .login_wrapper {
            padding: 30px;
        }
    }
</style>

<body class="login">
    <div class="login_container">
        <div class="login_wrapper">
            <form id="loginForm">
                <!-- Logo -->
                <div class="logo_container">
                    <img src="<?php echo base_url(); ?>resources/template/production/images/logoIHC.png" alt="Logo IHC" width="50%">
                </div>

                <!-- Judul Form -->
                <h1 class="login_title">Login</h1>

                <!-- Input Username -->
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Username" required id="username" name="username">
                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                </div>

                <!-- Input Password -->
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" required id="pass" name="pass">
                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                </div>

                <div class="text-right mb-3">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#lupaPasswordModal">Lupa Password?</a>
                </div>

                <!-- Tombol Login -->
                <div class="submit_container">
                    <button type="submit" class="btn btn-dark btn-block">Login</button>
                </div>

                <div class="clearfix"></div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <!-- <div class="modal fade" id="lupaPasswordModal" tabindex="-1" aria-labelledby="lupaPasswordLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lupaPasswordLabel">Lupa Password?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p>Hubungi kami via email, atau whatsApp yang berikut ini :</p>
                    <form id="resetPasswordForm">
                        <div class="mb-3">
                            <div class="input-group">
                                <input type="email" class="form-control" id="email" name="email" value="akilnmuharram@gmail.com" readonly>
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" id="no_hp" name="no_hp" value="082390588461" readonly>
                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->

    <div class="modal fade" id="lupaPasswordModal" tabindex="-1" aria-labelledby="lupaPasswordLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lupaPasswordLabel">Lupa Password?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p>Masukan Username dan nomor HP anda :</p>
                    <form id="resetPasswordForm">
                        <div class="mb-3">
                            <!-- <label for="email" class="form-label">Email</label> -->
                            <div class="input-group">
                                <input type="text" class="form-control" id="reset_unsername" name="reset_unsername" placeholder="Username">
                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <!-- <label for="no_hp" class="form-label">Nomor HP</label> -->
                            <div class="input-group">
                                <input type="number" class="form-control" id="no_hp" name="no_hp" placeholder="Nomor Handphone">
                                <span class="input-group-text"><i class="fa fa-phone"></i></span>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-success" type="submit">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Ketika form login di-submit
            $('#loginForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah submit default form

                // Ambil data form
                var username = $('#username').val();
                var password = $('#pass').val();

                // Kirim data menggunakan AJAX
                $.ajax({
                    url: '<?php echo base_url('LoginController/login'); ?>', // Endpoint di controller CI
                    type: 'POST',
                    data: {
                        username: username,
                        password: password
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            // Jika login sukses, arahkan ke halaman dashboard
                            if (response.role == "PTB") {
                                Swal.fire({
                                    title: "Success!",
                                    text: "Berhasil Login!",
                                    icon: "success"
                                }).then(function() {
                                    window.location.href = '<?= base_url(); ?>./AdminController/dashboard';
                                });
                            } else if (response.role == "kperawat") {
                                Swal.fire({
                                    title: "Success!",
                                    text: "Berhasil Login!",
                                    icon: "success"
                                }).then(function() {
                                    window.location.href = '<?= base_url(); ?>./PerawatController/dashboard';
                                });
                            } else if (response.role == "direktur") {
                                Swal.fire({
                                    title: "Success!",
                                    text: "Berhasil Login!",
                                    icon: "success"
                                }).then(function() {
                                    window.location.href = '<?= base_url(); ?>./DirekturController/dashboard';
                                });
                            }
                        } else {
                            // Jika gagal, tampilkan pesan error
                            Swal.fire({
                                title: "Gagal!",
                                text: response.message,
                                icon: "error"
                            }); // Bisa diganti dengan pesan di area login
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan pada server.');
                    }
                });
            });
        });
    </script>
    <script>
        document.getElementById("no_hp").addEventListener("keydown", function(e) {
            // Cegah karakter minus (-), e, dan + agar tidak bisa diketik
            if (["-", "e", "E", "+"].includes(e.key)) {
                e.preventDefault();
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#resetPasswordForm').on('submit', function(e) {
                e.preventDefault(); // Mencegah reload halaman
                var username = $('#reset_unsername').val();
                var no_hp = $('#no_hp').val();
                $.ajax({
                    url: '<?php echo base_url() ?>./LoginController/reset_password',
                    type: 'POST',
                    data: {
                        username:username,
                        no_hp:no_hp
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Data berhasil dikirim.',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#lupaPasswordModal').modal('hide');
                                    $('#resetPasswordForm')[0].reset(); // Reset form
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message || 'Gagal mengirim data.',
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan Server',
                            text: 'Terjadi kesalahan: ' + error,
                        });
                    }
                });
            });
        });
    </script>



</body>

</html>