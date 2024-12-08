<?php

// Ambil tanggal dikembalikan
$tgl_dikembalikan = date('Y-m-d');

// Ambil id_sirkulasi dari URL
$id_sirkulasi = $_GET['kode'];

// Ambil id_buku dari tabel tb_sirkulasi berdasarkan id_sirkulasi
$sql_buku = "SELECT id_buku FROM tb_sirkulasi WHERE id_sk = '$id_sirkulasi'";
$query_buku = mysqli_query($koneksi, $sql_buku);
$data_buku = mysqli_fetch_assoc($query_buku);
$id_buku = $data_buku['id_buku'];

// Update status pada tabel tb_sirkulasi
$sql_ubah = "UPDATE tb_sirkulasi 
             SET status='KEM', tgl_dikembalikan='$tgl_dikembalikan' 
             WHERE id_sk='$id_sirkulasi'";

$query_ubah = mysqli_query($koneksi, $sql_ubah);

// Jika update status berhasil, lanjutkan untuk menambah jumlah buku
if ($query_ubah) {
    // Update jumlah buku di tabel tb_buku
    $sql_tambah_buku = "UPDATE tb_buku 
                        SET jml_buku = jml_buku + 1 
                        WHERE id_buku = '$id_buku'";

    $query_tambah_buku = mysqli_query($koneksi, $sql_tambah_buku);

    // Jika semua berhasil
    if ($query_tambah_buku) {
        echo "<script>
        Swal.fire({title: 'Kembalikan Buku Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'admindashboard.php?page=data_sirkul';
            }
        })</script>";
    } else {
        echo "<script>
        Swal.fire({title: 'Gagal menambah jumlah buku',text: '',icon: 'error',confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'admindashboard.php?page=data_sirkul';
            }
        })</script>";
    }
} else {
    echo "<script>
    Swal.fire({title: 'Kembalikan Buku Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
    }).then((result) => {
        if (result.value) {
            window.location = 'index.php?page=data_sirkul';
        }
    })</script>";
}

?>
