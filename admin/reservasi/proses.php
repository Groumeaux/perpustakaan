<?php 
include "../../inc/koneksi.php"; // Hubungkan ke database

// Periksa apakah parameter yang diperlukan tersedia
if (isset($_GET['kode']) && isset($_GET['status'])) {

// Reservasi updates
    $id_reservasi = $_GET['kode']; // ID Reservasi dari URL
    $status = $_GET['status']; // Status baru dari URL

    // Query untuk update status di database
    $sql_update = $koneksi->query("UPDATE tb_reservasi SET status='$status' WHERE id_reservasi='$id_reservasi'");

    if ($sql_update) {
        // Jika update berhasil
        
        // Block ambil id
        $carikode = mysqli_query($koneksi,"SELECT id_sk FROM tb_sirkulasi order by id_sk desc");
        $datakode = mysqli_fetch_array($carikode);
        $kode = $datakode['id_sk'];
        $urut = substr($kode, 1, 3);
        $tambah = (int) $urut + 1;

        if (strlen($tambah) == 1) {
            $format = "S" . "00" . $tambah;
        } else if (strlen($tambah) == 2) {
            $format = "S" . "0" . $tambah;
        } else if (strlen($tambah) == 3) { // Gunakan else if di sini
            $format = "S" . $tambah; // Tambahkan titik koma
        }

        // id sirkulasi after formatting
        $idsk = $format;
        
        // query data dari tb_reservasi
        $idreservasi = $_GET['kode'];
        $carireservasi = mysqli_query($koneksi, "SELECT * FROM tb_reservasi WHERE id_reservasi='$idreservasi'");
        $reservasi = mysqli_fetch_array($carireservasi);
        // date stuffs
        $tgl_p = date('Y-m-d');
        $tgl_k=date('Y-m-d', strtotime('+7 days', strtotime($tgl_p)));
        
        echo $reservasi['id_buku'];
        echo $reservasi['id_anggota'];

        $sql_simpan = "INSERT INTO tb_sirkulasi (id_sk,id_buku,id_anggota,tgl_pinjam,status,tgl_kembali) VALUES (
            '".$idsk."',
            '".$reservasi['id_buku']."',
            '".$reservasi['id_anggota']."',
            '".$tgl_p."',
            'PIN',
            '".$tgl_k."');";
        $sql_simpan .= "INSERT INTO log_pinjam (id_buku,id_anggota,tgl_pinjam) VALUES (
            '".$reservasi['id_buku']."',
            '".$reservasi['id_anggota']."',
            '".$tgl_p."')";   
        $query_simpan = mysqli_multi_query($koneksi, $sql_simpan);

        mysqli_close($koneksi);
        // Kembali ke datareservasi
        echo "<script>
            alert('Status berhasil diperbarui! Sirkul telah diperbarui!');
            window.location.href='../../admindashboard.php?page=MyApp/datareservasi';
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
