<?php
    if (isset($_POST['diterima'])){
        // perpnajang block 
        $sql_cek = "SELECT * FROM tb_sirkulasi WHERE id_sk='" . $_POST['sk'] . "'";
        $query_cek = mysqli_query($koneksi, $sql_cek);
        $data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);
        
        $tgl_kembali_baru = date('Y-m-d', strtotime('+7 days', strtotime($data_cek['tgl_kembali'])));
        
        $sql_ubah = "UPDATE tb_sirkulasi SET 
            tgl_kembali='$tgl_kembali_baru'
            WHERE id_sk='" . $_POST['sk'] . "'";
        $query_ubah = mysqli_query($koneksi, $sql_ubah);

        $sql_hapus = "DELETE FROM tb_requests WHERE id_req='".$_POST['req']."'";
        $query_hapus = mysqli_query($koneksi, $sql_hapus);

        if ($query_ubah && $query_hapus){
            echo "<script>
            Swal.fire({
                title: 'Request Perpanjangan Diterima!',
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
                title: 'Perpanjang gagal!',
                text: '',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    window.location = 'index.php?page=data_sirkul';
                }
            })</script>";
        }
    } elseif (isset($_POST['ditolak'])){
        $sql_hapus = "DELETE FROM tb_requests WHERE id_req='".$_POST['req']."'";
        $query_hapus = mysqli_query($koneksi, $sql_hapus);
        if ($query_hapus){
            echo "<script>
            Swal.fire({
                title: 'Request Perpanjangan Diterima!',
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
                title: 'Perpanjang gagal!',
                text: '',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    window.location = 'index.php?page=data_sirkul';
                }
            })</script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                title: 'Perpanjang gagal!',
                text: '',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    window.location = 'index.php?page=data_sirkul';
                }
            })</script>";
    }







    
?>