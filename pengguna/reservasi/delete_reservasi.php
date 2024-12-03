<?php
if (isset($_GET['id_reservasi'])) {
    $sql_hapus = "DELETE FROM tb_reservasi WHERE id_reservasi='" . $_GET['id_reservasi'] . "'";
    $query_hapus = mysqli_query($koneksi, $sql_hapus);

    if ($query_hapus) {
        echo "<script>
        Swal.fire({
            title: 'Reservasi berhasil dihapus!',
            text: '',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'userdashboard.php?page=reservasiuser';
            }
        })</script>";
    } else {
        echo "<script>
        Swal.fire({
            title: 'Gagal membatalkan reservasi',
            text: '',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'userdashboard.php?page=reservasiuser';
            }
        })</script>";
    }
}
?>
