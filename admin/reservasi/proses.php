<?php 
include "../../inc/koneksi.php"; // Hubungkan ke database

// Periksa apakah parameter yang diperlukan tersedia
if (isset($_GET['kode']) && isset($_GET['status'])) {
    $id_reservasi = $_GET['kode']; // ID Reservasi dari URL
    $status = $_GET['status']; // Status baru dari URL

    // Query untuk update status di database
    $sql_update = $koneksi->query("UPDATE tb_reservasi SET status='$status' WHERE id_reservasi='$id_reservasi'");

    if ($sql_update) {
        // Jika update berhasil
        echo "<script>
            alert('Status berhasil diperbarui!');
            window.location.href='../../admindashboard.php?page=MyApp/datareservasi'; // Redirect kembali ke halaman reservasi
        </script>";
    } else {
        // Jika update gagal
        echo "<script>
            alert('Status gagal diperbarui!');
            window.location.href='../../userdashboard.php?page=reservasiuser';
        </script>";
    }
} else {
    // Jika parameter tidak lengkap
    echo "<script>
        alert('Parameter tidak lengkap!');
        window.location.href='index.php?page=reservasiuser';
    </script>";
}
?>
