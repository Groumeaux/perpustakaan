<?php
    include "../../inc/koneksi.php";
    session_start();
    if (isset($_GET['book'])) {
        $book_id = $_GET['book'];
        $nama = $_SESSION["ses_nama"];
        $queryanggota = mysqli_query($koneksi, "SELECT * FROM tb_anggota WHERE nama='$nama'");
        if (!$queryanggota) {
            die("Query failed: " . mysqli_error($koneksi));
        }

        $takeanggota = mysqli_fetch_assoc($queryanggota);
        if (!$takeanggota) {
            die("Fetch failed: " . mysqli_error($koneksi));
        }

        $idanggota = $takeanggota['id_anggota'];
        $pending = "Pending";
        $tanggal = date('Y-m-d');

        $insert_to_reservasi = mysqli_query($koneksi, "INSERT INTO tb_reservasi (id_anggota, id_buku, tanggal_reservasi, status)
        VALUES (
            '$idanggota',
            '$book_id',
            '$tanggal',
            '$pending'
        )");

        if (!$insert_to_reservasi) {
            die("Insert failed: " . mysqli_error($koneksi));
        }

        header("location: ../../userdashboard.php?msg=reservasisukses");
    }
?>
