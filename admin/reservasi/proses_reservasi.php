<?php
include "../../inc/koneksi.php"; // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_reservasi = $_POST['id_reservasi'];
    $action = $_POST['action'];

    if ($action == 'accept') {
        $sql = "UPDATE tb_reservasi SET status = 'Diterima' WHERE id_reservasi = $id_reservasi";
    } elseif ($action == 'reject') {
        $sql = "UPDATE tb_reservasi SET status = 'Ditolak' WHERE id_reservasi = $id_reservasi";
    }

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>
            alert('Reservasi berhasil diperbarui!');
            window.location.href = 'data_reservasi.php';
        </script>";
    } else {
        echo "<script>
            alert('Terjadi kesalahan. Coba lagi!');
            window.location.href = 'data_reservasi.php';
        </script>";
    }
}
?>
