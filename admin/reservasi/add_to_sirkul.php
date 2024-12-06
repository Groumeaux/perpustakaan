<?php
include "../../inc/koneksi.php";

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

?>