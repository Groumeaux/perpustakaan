<?php
    if (isset($_POST['submitrequest'])){
        $id_sk = $_POST['sk'];
        $request_msg = $_POST['msg'];

        $querysirkul = mysqli_query($koneksi,"SELECT * FROM tb_sirkulasi WHERE id_sk='$id_sk'");
        $sirkul = mysqli_fetch_array($querysirkul);
        
        $idanggota = $sirkul['id_anggota'];
        $idsk = $sirkul['id_sk'];
        $status = "Pending";

        $sql = "INSERT INTO tb_requests (req_msg, id_sk, req_status) VALUES
        ('$request_msg',
        '$idsk',
        '$status')";
        $query = mysqli_query($koneksi, $sql);

        if ($query){
            echo "<script>
        Swal.fire({
            title: 'Permohonan Perpanjangan Berhasil Dikirim!',
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
                title: 'Terjadi Kesalahan',
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