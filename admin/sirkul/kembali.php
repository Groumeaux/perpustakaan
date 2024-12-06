<?php
    $tgl_dikembalikan = date('Y-m-d'); 
    $idsk = $_GET['kode'];

    $getsirkul = mysqli_query($koneksi,"SELECT * FROM tb_sirkulasi WHERE id_sk='$idsk'");
    $sirkul = mysqli_fetch_array($getsirkul);
    $idbuku = $sirkul['id_buku'];
    $getbuku = mysqli_query($koneksi,"SELECT * FROM tb_buku WHERE id_buku='$idbuku'");
    $buku = mysqli_fetch_array($getbuku);
    $jumlahbuku = $buku['jml_buku'];
    $jumlahbuku = $jumlahbuku + 1;
    
    $sql_ubah = "UPDATE tb_sirkulasi 
        SET status='KEM', tgl_dikembalikan='$tgl_dikembalikan' 
        WHERE id_sk='" . $_GET['kode'] . "'";
    $sql_update_buku = "UPDATE tb_buku SET 
        jml_buku = '" . $jumlahbuku . "'
        WHERE id_buku='" . $idbuku . "'";
    $query_update = mysqli_query($koneksi, $sql_update_buku);
    $query_ubah = mysqli_query($koneksi, $sql_ubah);

    if ($query_ubah) {
        echo "<script>
        Swal.fire({title: 'Kembalikan Buku Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'admindashboard.php?page=data_sirkul';
            }
        })</script>";
        }else{
        echo "<script>
        Swal.fire({title: 'Kembalikan Buku Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'admindashboard.php?page=data_sirkul';
            }
        })</script>";
    }
	
