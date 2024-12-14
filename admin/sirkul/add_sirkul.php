<?php
// kode 9 digit
$carikode = mysqli_query($koneksi, "SELECT id_reservasi FROM tb_reservasi ORDER BY id_reservasi DESC");
$datakode = mysqli_fetch_array($carikode);
$kode = $datakode['id_reservasi'];
$tambah = (int)$kode + 1;

$id_reservasi = str_pad($tambah, 9, "0", STR_PAD_LEFT);
?>

<section class="content-header">
    <h1>
        Reservasi Buku
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="index.php">
                <i class="fa fa-home"></i>
                <b>HOME</b>
            </a>
        </li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Tambah Reservasi</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-remove"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Id Reservasi</label>
                            <input type="text" name="id_reservasi" id="id_reservasi" class="form-control"
                                value="<?php echo $id_reservasi; ?>" readonly />
                        </div>

                        <div class="form-group">
                            <label>Nama Peminjam</label>
                            <select name="id_anggota" id="id_anggota" class="form-control select2" style="width: 100%;">
                                <option selected="selected">-- Pilih --</option>
                                <?php
                                // Fetch members from database
                                $query = "SELECT * FROM tb_anggota";
                                $hasil = mysqli_query($koneksi, $query);
                                while ($row = mysqli_fetch_array($hasil)) {
                                ?>
                                <option value="<?php echo $row['id_anggota'] ?>">
                                    <?php echo $row['id_anggota'] ?> - <?php echo $row['nama'] ?>
                                </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Buku</label>
                            <select name="id_buku" id="id_buku" class="form-control select2" style="width: 100%;">
                                <option selected="selected">-- Pilih --</option>
                                <?php
                                // Fetch books with available stock
                                $query = "SELECT * FROM tb_buku WHERE jml_buku > 0";
                                $hasil = mysqli_query($koneksi, $query);
                                while ($row = mysqli_fetch_array($hasil)) {
                                ?>
                                <option value="<?php echo $row['id_buku'] ?>">
                                    <?php echo $row['id_buku'] ?> - <?php echo $row['judul_buku'] ?>
                                </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Reservasi</label>
                            <input type="date" name="tanggal_reservasi" id="tanggal_reservasi" class="form-control" />
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <input type="submit" name="Simpan" value="Simpan" class="btn btn-info">
                        <a href="?page=MyApp/datareservasi" class="btn btn-warning">Batal</a>
                    </div>
                </form>
            </div>
            <!-- /.box -->
</section>

<?php

if (isset($_POST['Simpan'])) {
    // Capture POST data
    $id_reservasi = $_POST['id_reservasi'];
    $id_anggota = $_POST['id_anggota'];
    $id_buku = $_POST['id_buku'];
    $tanggal_reservasi = $_POST['tanggal_reservasi'];
    $status = 'Pending'; // Default status for new reservations

    // Begin transaction
    mysqli_begin_transaction($koneksi);

    try {
        // Insert into tb_reservasi
        $sql_simpan = "INSERT INTO tb_reservasi (id_reservasi, id_anggota, id_buku, tanggal_reservasi, status) VALUES (
            '$id_reservasi',
            '$id_anggota',
            '$id_buku',
            '$tanggal_reservasi',
            '$status'
        )";
        mysqli_query($koneksi, $sql_simpan);

        // Update book quantity
        $sql_update_buku = "UPDATE tb_buku SET jml_buku = jml_buku - 1 WHERE id_buku = '$id_buku'";
        mysqli_query($koneksi, $sql_update_buku);

        // Commit transaction
        mysqli_commit($koneksi);

        echo "<script>
        Swal.fire({
            title: 'Tambah Data Berhasil',
            text: '',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'admindashboard.php?page=MyApp/datareservasi';
            }
        })
        </script>";
    } catch (Exception $e) {
        // Rollback transaction
        mysqli_rollback($koneksi);

        echo "<script>
        Swal.fire({
            title: 'Tambah Data Gagal',
            text: '',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'admindashboard.php?page=MyApp/datareservasi';
            }
        })
        </script>";
    }
}
?>
