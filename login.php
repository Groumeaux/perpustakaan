<?php
session_start();
include "inc/koneksi.php"; 
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login | SI Perpustakaan</title>
	<link rel="icon" href="dist/img/logo.png">
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<h3>
				<font color="green">
					<b>Sistem Informasi Perpustakaan</b>
				</font>
			</h3>
			</a>
		</div>
		<!-- /.login-logo -->
		<div class="login-box-body">
			<center>
				<img src="dist/img/logo.png" width=160px />
			</center>
			<br>
			<p class="login-box-msg">Login System</p>
			<form action="#" method="post">
				<div class="form-group has-feedback">
					<input type="text" class="form-control" name="username" placeholder="Username" required>
					<span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback">
					<input type="password" class="form-control" name="password" placeholder="Password" required>
					<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				</div>
				<div class="row">
					<div class="col-xs-4 col-md-offset-4 text-center">
						<button type="submit" class="btn btn-success btn-block btn-flat" name="btnLogin" title="Masuk Sistem">
							<b>Masuk</b>
						</button>
					</div>
				</div>
				<div class="row" style="padding-top: 15px;">
					<div class="col-md-10 col-md-offset-1 text-center">
						<p style="opacity: 0.5 ;color: gray; font-size: 14px;">
							Belum mempunyai akun?<a href="daftar.php" style="color: blue; text-decoration: underline;">Daftar disini!</a>
						</p>
					</div>
				</div>
			</form>
		</div>
		<!-- /.login-box-body -->
	</div>
	<!-- /.login-box -->

	<!-- jQuery 2.2.3 -->
	<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
	<!-- Bootstrap 3.3.6 -->
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<!-- iCheck -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
	<!-- sweet alert -->


	
</body>

</html>
<?php
	if (isset($_GET['page'])) {
		$hal = $_GET['page'];
		
		switch ($hal) {
				//Klik Halaman Home Pengguna
			case 'admin':
				include "home/admin.php";
				break;
			case 'petugas':
				include "home/petugas.php";
				break;
			
			case 'login':
				header("location: login.php");
				break;
			case 'signin':
				header("location: daftar.php");
				break;

			default:
				echo "<center><br><br><br><br><br><br><br><br><br>
		<h1> Halaman tidak ditemukan !</h1></center>";
				break;
		}
	}
?>

<?php 
include "inc/koneksi.php";

		if (isset($_POST['btnLogin'])) {  
			$username=mysqli_real_escape_string($koneksi,$_POST['username']);
			$password=mysqli_real_escape_string($koneksi,md5($_POST['password']));
			$sql_login = "SELECT * FROM tb_pengguna WHERE BINARY username='$username' AND password= '$password'";
			$query_login = mysqli_query($koneksi, $sql_login);
			$data_login = mysqli_fetch_array($query_login,MYSQLI_BOTH);
			$jumlah_login = mysqli_num_rows($query_login);
			
            if ($jumlah_login == 1 ){
			  $namapengguna = $data_login["nama_pengguna"];
			  $findanggota = mysqli_query($koneksi, "SELECT * FROM tb_anggota WHERE nama='$namapengguna'");
			  $anggota = mysqli_fetch_array($findanggota);
			  $id_anggota = $anggota['id_anggota'];
			  $_SESSION["ses_id_anggota"]=$id_anggota;
              $_SESSION["ses_id"]=$data_login["id_pengguna"];
              $_SESSION["ses_nama"]=$data_login["nama_pengguna"];
              $_SESSION["ses_username"]=$data_login["username"];
              $_SESSION["ses_password"]=$data_login["password"];
              $_SESSION["ses_level"]=$data_login["level"];
				
              echo "<script>
                    Swal.fire({title: 'Login Berhasil',
						text: '',
						icon: 'success',
						confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.value) {
                            window.location = 'index.php';
                        }
                    })</script>";
              }else{
              echo "<script>
                    Swal.fire({title: 'Login Gagal',
						text: '',
						icon: 'error',
						confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.value) {
                            window.location = 'login.php';
                        }
                    })</script>";
                }
			  }
?>