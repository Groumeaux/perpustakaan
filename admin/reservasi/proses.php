<?php 
include "../../inc/koneksi.php"; // Hubungkan ke database

// Periksa apakah parameter yang diperlukan tersedia
if (isset($_GET['kode']) && isset($_GET['status'])) {

// Reservasi updates
    $id_reservasi = $_GET['kode']; // ID Reservasi dari URL
    $status = $_GET['status']; // Status baru dari URL

    // Query untuk update status di database
    $sql_update = $koneksi->query("UPDATE tb_reservasi SET status='$status' WHERE id_reservasi='$id_reservasi'");

    if ($sql_update == TRUE && $status == "Diterima") {
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
        $idbuku = $reservasi['id_buku'];
        
        $caribuku = mysqli_query($koneksi, "SELECT * FROM tb_buku WHERE id_buku='$idbuku'");
        $ambilbuku = mysqli_fetch_array($caribuku);
        $jumlahbuku = $ambilbuku['jml_buku'];

        if ($jumlahbuku == 0){
            echo "<script>
            alert('Status gagal diperbarui!, Jumlah buku tidak cukup.');
            window.location.href='../../admindashboard.php?page=MyApp/datareservasi';
            </script>";
        }
        $jumlahbuku = $jumlahbuku - 1;
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
        $sql_update_buku = "UPDATE tb_buku SET 
        jml_buku = '$jumlahbuku'
        WHERE id_buku='$idbuku'";
        $query_update_buku = mysqli_query($koneksi, $sql_update_buku);
        $query_simpan = mysqli_multi_query($koneksi, $sql_simpan);

        mysqli_close($koneksi);
        // Kembali ke datareservasi
        echo "<script>
            alert('Status berhasil diperbarui!');
            window.location.href='../../admindashboard.php?page=MyApp/datareservasi';
        </script>"; 
    } else {
        // Jika update gagal
        echo "<script>
            alert('Reservasi berhasil ditolak!');
            window.location.href='../../admindashboard.php?page=MyApp/datareservasi';
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
