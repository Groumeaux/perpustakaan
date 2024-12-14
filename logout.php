<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Logout</title>
    <!-- Link ke SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="dist/css/custom/login.css">
	<link rel="stylesheet" href="dist/css/custom/popuplogout.css">
    <!-- Tambahkan CSS kustom -->
    <style>
    </style>
</head>
<body>
    <script>
        // SweetAlert2 untuk konfirmasi logout dengan tampilan kustom
        Swal.fire({
            title: 'Konfirmasi Logout',
            text: 'Apakah Anda yakin ingin keluar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Logout',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                // Arahkan ke proses logout jika user memilih "Ya, Logout"
                window.location = 'process_logout.php';
            } else {
                // Arahkan kembali ke halaman utama jika user memilih "Tidak"
                window.location = 'index.php';
            }
        });
    </script>
</body>
</html>