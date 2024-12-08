<?php
if (isset($_GET['kode'])) {
    
    $sql_cek = "SELECT * FROM tb_sirkulasi WHERE id_sk='" . $_GET['kode'] . "'";
    $query_cek = mysqli_query($koneksi, $sql_cek);
    $data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);
    
    $tgl_kembali_baru = date('Y-m-d', strtotime('+7 days', strtotime($data_cek['tgl_kembali'])));
    
    $sql_ubah = "UPDATE tb_sirkulasi SET 
        tgl_kembali='$tgl_kembali_baru'
        WHERE id_sk='" . $_GET['kode'] . "'";
    $query_ubah = mysqli_query($koneksi, $sql_ubah);
    
    if ($query_ubah) {
        echo "<script>
        Swal.fire({
            title: 'Perpanjang Berhasil',
            text: '',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'admindashboard.php?page=data_sirkul';
            }
        })</script>";
    } else {
        echo "<script>
        Swal.fire({
            title: 'Perpanjang Gagal',
            text: '',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'index.php?page=data_sirkul';
            }
        })</script>";
    }
}
?>
