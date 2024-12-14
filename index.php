<?php
// Mulai Session
session_start();
if (isset($_SESSION["ses_level"]) && $_SESSION["ses_level"] == "Administrator") {
    header("location: admindashboard.php");
    exit;
} elseif (isset($_SESSION["ses_level"]) && $_SESSION["ses_level"] == "Pengguna") {
    header("location: userdashboard.php");
    exit;
} else {
    session_destroy();
}

// KONEKSI DB
include "inc/koneksi.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ReadByte | Perpustakaan Digital</title>
    <link rel="icon" href="dist/img/logo.png">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skin-blue.min.css">
    <!-- css for the book cards -->
    <link rel="stylesheet" href="dist/css/catalogue_style.css">

    <link rel="stylesheet" href="dist/css/custom/index.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>


</head>

<body class="hold-transition skin-blue">
    <!-- Site wrapper -->
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="index.php" class="logo">
                <span class="logo-lg">
                    <img src="dist/img/Logo.png" width="37px" alt="Logo ReadByte">
                </span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button (disembunyikan) -->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button" style="display: none;">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Tombol Daftar dan Login -->
                        <li>
                            <a href="daftar.php" class="btn btn-success btn-flat" title="Daftar Sistem">
                                <i class="glyphicon glyphicon-user"></i> <b>Daftar</b>
                            </a>
                        </li>
                        <li>
                            <a href="login.php" class="btn btn-success btn-flat" name="btnLogin" title="Masuk Sistem">
                                <i class="glyphicon glyphicon-log-in"></i> <b>Login</b>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Section Baru: Welcome Section -->
        <div class="welcome-section">
            <div class="welcome-content">
                <img src="dist/img/LogoTypoPutih.png" alt="Logo ReadByte">
                <h1>Selamat Datang</h1>
                <p>ReadByte adalah perpustakaan digital inovatif yang menyediakan akses mudah dan cepat ke ribuan buku dari berbagai genre. </p>
                <p>Dengan antarmuka yang ramah pengguna dan fitur pencarian canggih, ReadByte memudahkan Anda </p>
                <p>menemukan dan membaca buku favorit kapan saja dan di mana saja.</p>
            </div>
        </div>
        <!-- Akhir Welcome Section -->

        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <?php
                if (isset($_GET['page'])) {
                    $hal = $_GET['page'];

                    switch ($hal) {
                        case 'login':
                            header("location: login.php");
                            break;
                        case 'signin':
                            header("location: daftar.php");
                            break;
                        //Klik Halaman Home Pengguna
                        case 'admin':
                            include "home/admin.php";
                            break;
                        case 'petugas':
                            include "home/petugas.php";
                            break;

                        //Pengguna
                        case 'MyApp/data_pengguna':
                            include "admin/pengguna/data_pengguna.php";
                            break;
                        case 'MyApp/add_pengguna':
                            include "admin/pengguna/add_pengguna.php";
                            break;
                        case 'MyApp/edit_pengguna':
                            include "admin/pengguna/edit_pengguna.php";
                            break;
                        case 'MyApp/del_pengguna':
                            include "admin/pengguna/del_pengguna.php";
                            break;
                        case 'dashboard':
                            include "home/indexkatalog.php";
                            break;

                        //agt
                        case 'MyApp/data_agt':
                            include "admin/agt/data_agt.php";
                            break;
                        case 'MyApp/add_agt':
                            include "admin/agt/add_agt.php";
                            break;
                        case 'MyApp/edit_agt':
                            include "admin/agt/edit_agt.php";
                            break;
                        case 'MyApp/del_agt':
                            include "admin/agt/del_agt.php";
                            break;
                        case 'MyApp/print_agt':
                            include "admin/agt/print_agt.php";
                            break;
                        case 'MyApp/print_allagt':
                            include "admin/agt/print_allagt.php";
                            break;

                        //buku
                        case 'MyApp/data_buku':
                            include "admin/buku/data_buku.php";
                            break;
                        case 'MyApp/add_buku':
                            include "admin/buku/add_buku.php";
                            break;
                        case 'MyApp/edit_buku':
                            include "admin/buku/edit_buku.php";
                            break;
                        case 'MyApp/del_buku':
                            include "admin/buku/del_buku.php";
                            break;

                        //sirkul
                        case 'data_sirkul':
                            include "admin/sirkul/data_sirkul.php";
                            break;
                        case 'add_sirkul':
                            include "admin/sirkul/add_sirkul.php";
                            break;
                        case 'panjang':
                            include "admin/sirkul/panjang.php";
                            break;
                        case 'kembali':
                            include "admin/sirkul/kembali.php";
                            break;

                        //log
                        case 'log_pinjam':
                            include "admin/log/log_pinjam.php";
                            break;
                        case 'log_kembali':
                            include "admin/log/log_kembali.php";
                            break;

                        //laporan
                        case 'laporan_sirkulasi':
                            include "admin/laporan/laporan_sirkulasi.php";
                            break;
                        case 'MyApp/print_laporan':
                            include "admin/laporan/print_laporan.php";
                            break;

                        //default
                        default:
                            echo "<center><br><br><br><br><br><br><br><br><br>
                                <h1> Halaman tidak ditemukan !</h1></center>";
                            break;
                    }
                } else {
                    include "home/indexkatalog.php";
                }
                ?>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <strong>
                Copyright &copy;
                <a>ReadByte</a>.
            </strong>
            All rights reserved.
        </footer>

    </div>
    <!-- ./wrapper -->

    <!-- jQuery 2.2.3 -->
    <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/select2/select2.full.min.js"></script>
    <!-- DataTables -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }]
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });
    </script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $(".select2").select2();
        });
    </script>
</body>

</html>