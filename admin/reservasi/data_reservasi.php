<?php
include "inc/koneksi.php"; // Koneksi ke database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Data Reservasi | Admin</title>
    <link rel="icon" href="../dist/img/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- Include Bootstrap, FontAwesome, Ionicons -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
</head>
<body class="hold-transition skin-green sidebar-mini">
    <div class="wrapper">


        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <section class="content-header">
                <h1>Data Reservasi</h1>
                <ol class="breadcrumb">
                    <li><a href="../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Data Reservasi</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Daftar Reservasi</h3>
                    </div>
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID Reservasi</th>
                                    <th>Nama Anggota</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Reservasi</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Ambil data reservasi dari database
                                $sql = "SELECT 
                                            tb_reservasi.id_reservasi, 
                                            tb_anggota.nama AS nama_anggota, 
                                            tb_buku.judul_buku AS judul_buku, 
                                            tb_reservasi.tanggal_reservasi, 
                                            tb_reservasi.status
                                        FROM tb_reservasi
                                        JOIN tb_anggota ON tb_reservasi.id_anggota = tb_anggota.id_anggota
                                        JOIN tb_buku ON tb_reservasi.id_buku = tb_buku.id_buku";
                                $query = mysqli_query($koneksi, $sql);

                                while ($data = mysqli_fetch_array($query)) {
                                    echo "<tr>
                                        <td>{$data['id_reservasi']}</td>
                                        <td>{$data['nama_anggota']}</td>
                                        <td>{$data['judul_buku']}</td>
                                        <td>{$data['tanggal_reservasi']}</td>
                                        <td>{$data['status']}</td>
                                        <td>
                                            <form action='admin/reservasi/proses_reservasi.php' method='POST' style='display:inline-block;'>
                                                <input type='hidden' name='id_reservasi' value='{$data['id_reservasi']}'>
                                                <button type='submit' name='action' value='accept' class='btn btn-success btn-sm'>Terima</button>
                                            </form>
                                            <form action='proses_reservasi.php' method='POST' style='display:inline-block;'>
                                                <input type='hidden' name='id_reservasi' value='{$data['id_reservasi']}'>
                                                <button type='submit' name='action' value='reject' class='btn btn-danger btn-sm'>Tolak</button>
                                            </form>
                                        </td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="../dist/js/app.min.js"></script>
    <script>
        $(function() {
            $("#example1").DataTable();
        });

        
    </script>
</body>
</html>
