<?php 
include "../../inc/koneksi.php";

if (isset($_GET['kode']) && isset($_GET['status'])) {
    $id_reservasi = $_GET['kode'];
    $status = $_GET['status'];

    // Update status reservasi di database
    $sql_update = $koneksi->query("UPDATE tb_reservasi SET status='$status' WHERE id_reservasi='$id_reservasi'");

    if ($sql_update && $status == "Diterima") {
        
        // Cari kode ID Sirkulasi terbaru
        $carikode = mysqli_query($koneksi, "SELECT id_sk FROM tb_sirkulasi ORDER BY id_sk DESC LIMIT 1");
        $datakode = mysqli_fetch_array($carikode);
        $kode = $datakode['id_sk'];

        $urut = substr($kode, 1, 3);
        $tambah = (int) $urut + 1;

        if (strlen($tambah) == 1) {
            $format = "S" . "00" . $tambah;
        } else if (strlen($tambah) == 2) {
            $format = "S" . "0" . $tambah;
        } else {
            $format = "S" . $tambah;
        }

        $idsk = $format;

        // Ambil data reservasi untuk membuat sirkulasi
        $carireservasi = mysqli_query($koneksi, "SELECT * FROM tb_reservasi WHERE id_reservasi='$id_reservasi'");
        $reservasi = mysqli_fetch_array($carireservasi);

        $idbuku = $reservasi['id_buku'];
        $idanggota = $reservasi['id_anggota'];
        $tgl_pinjam = date('Y-m-d');
        $tgl_kembali = date('Y-m-d', strtotime('+7 days', strtotime($tgl_pinjam)));

        // Periksa jumlah buku tersedia di tb_buku
        $caribuku = mysqli_query($koneksi, "SELECT * FROM tb_buku WHERE id_buku='$idbuku'");
        $ambilbuku = mysqli_fetch_array($caribuku);
        $jumlahbuku = $ambilbuku['jml_buku'];

        if ($jumlahbuku > 0) {
            $jumlahbuku -= 1;

            // Buat data di tabel tb_sirkulasi
            $sql_simpan = $koneksi->query("INSERT INTO tb_sirkulasi (id_sk, id_buku, id_anggota, tgl_pinjam, status, tgl_kembali) 
                VALUES ('$idsk', '$idbuku', '$idanggota', '$tgl_pinjam', 'PIN', '$tgl_kembali')");

            // Update jumlah buku di tb_buku
            $update_buku = $koneksi->query("UPDATE tb_buku SET jml_buku = '$jumlahbuku' WHERE id_buku='$idbuku'");

            if ($sql_simpan && $update_buku) {
                // Perbarui tb_reservasi dengan id_sirkulasi yang terhubung
                $update_reservasi = $koneksi->query("UPDATE tb_reservasi SET id_sk='$idsk' WHERE id_reservasi='$id_reservasi'");

                echo "<script>
                        alert('Reservasi berhasil diterima dan ID Sirkulasi sudah dibuat!');
                        window.location.href='../../admindashboard.php?page=MyApp/datareservasi';
                    </script>";
            } else {
                echo "<script>
                        alert('Proses gagal! Silakan coba lagi.');
                        window.location.href='../../admindashboard.php?page=MyApp/datareservasi';
                    </script>";
            }
        } else {
            echo "<script>
                    alert('Jumlah buku tidak tersedia.');
                    window.location.href='../../admindashboard.php?page=MyApp/datareservasi';
                </script>";
        }
    } else {
        echo "<script>
                alert('Reservasi berhasil ditolak.');
                window.location.href='../../admindashboard.php?page=MyApp/datareservasi';
            </script>";
    }
} else {
    echo "<script>
            alert('Parameter tidak lengkap.');
            window.location.href='../../admindashboard.php?page=MyApp/datareservasi';
        </script>";
}
?>
