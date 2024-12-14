<?php

    if(isset($_GET['kode'])){
        $sql_cek = "SELECT * FROM tb_buku WHERE id_buku='".$_GET['kode']."'";
        $query_cek = mysqli_query($koneksi, $sql_cek);
        $data_cek = mysqli_fetch_array($query_cek,MYSQLI_BOTH);
    }

	function formatIsbnWithHyphens($isbn) {
		return substr($isbn, 0, 3) . '-' . substr($isbn, 3, 1) . '-' . substr($isbn, 4, 4) . '-' . substr($isbn, 8, 4) . '-' . substr($isbn, 12, 1);
	}
	$formattedIsbn = formatIsbnWithHyphens($data_cek['isbn']);
?>

<section class="content-header">
	<h1>
		Master Data
		<small>Data Buku</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<a href="index.php">
				<i class="fa fa-home"></i>
				<b>HOME</b>
			</a>
		</li>
	</ol>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<!-- general form elements -->
			<div class="box box-success">
				<div class="box-header with-border">
					<h3 class="box-title">Ubah buku</h3>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<form action="" method="post" enctype="multipart/form-data">
					<div class="box-body">

						<div class="form-group">
							<label>Id Buku</label>
							<input type='text' class="form-control" name="id_buku" value="<?php echo $data_cek['id_buku']; ?>"
							 readonly/>
						</div>

						<div class="form-group">
							<label>Judul Buku</label>
							<input type='text' class="form-control" name="judul_buku" value="<?php echo $data_cek['judul_buku']; ?>"
							/>
						</div>

						<div class="form-group">
							<label>Pengarang</label>
							<input type='text' class="form-control" name="pengarang" value="<?php echo $data_cek['pengarang']; ?>"
							/>
						</div>

						<div class="form-group">
							<label>Penerbit</label>
							<input class="form-control" name="penerbit" value="<?php echo $data_cek['penerbit']; ?>"
							/>
						</div>

						<div class="form-group">
							<label>Th Terbit</label>
							<input class="form-control" name="th_terbit" value="<?php echo $data_cek['th_terbit']; ?>">
						</div>

						<div class="form-group">
							<label>ISBN</label>
							<input class="form-control" name="isbn" value="<?php echo $data_cek['isbn']; ?>">
						</div>

						<div class="form-group">
							<label>Jumlah Buku</label>
							<input class="form-control" name="jumlahbuku" value="<?php echo $data_cek['jml_buku']; ?>">
						</div>

						<div class="form-group">
							<label>Cover Image</label>
							<input type="file" name="file" id="file">
							<p style="opacity: 0.5 ;color: gray; font-size: 14px;">Format yang diterima : jpg, jpeg, atau png</p>
						</div>

					</div>
					<!-- /.box-body -->

					<div class="box-footer">
						<input type="submit" name="Ubah" value="Ubah" class="btn btn-success">
						<a href="?page=MyApp/data_buku" class="btn btn-warning">Batal</a>
					</div>
				</form>
			</div>
			<!-- /.box -->
</section>

<?php

if (isset ($_POST['Ubah'])){
    //mulai proses ubah

	// Get rid of hyphens
	$isbn = str_replace('-', '', $_POST['isbn']);

	if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
		// proses cover buku
		$targetDir = "images/covers/";

		// File information
		$fileNameBefore = basename($_FILES['file']['name']);
		$targetFilePath = $targetDir . $fileNameBefore;
		$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
	
		// Validate file type
		$allowedTypes = ['jpg', 'jpeg', 'png'];
		if (in_array(strtolower($fileType), $allowedTypes)) {
			// Move the uploaded file to the directory
			if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
				$filename = $fileNameBefore;
			} else {
				echo 
				"<script>
					Swal.fire({
						title: 'Upload Gagal!',
						text: 'Terjadi kesalahan, coba lagi.',
						icon: 'error',
						confirmButtonText: 'OK'
					});
				</script>";
			}
		} else {
			echo 
			"<script>
                Swal.fire({
                    title: 'Upload Cover Gagal!',
                    text: 'Tolong upload Gambar dengan format jpg, jpeg, atau png!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>";
		}

		$sql_ubah = "UPDATE tb_buku SET
        judul_buku='".$_POST['judul_buku']."',
        pengarang='".$_POST['pengarang']."',
        penerbit='".$_POST['penerbit']."',
        th_terbit='".$_POST['th_terbit']."',
		isbn = '".$isbn."',
		cover = '".$filename."',
		jml_buku = '".$_POST['jumlahbuku']."'
        WHERE id_buku='".$_POST['id_buku']."'";
    	$query_ubah = mysqli_query($koneksi, $sql_ubah);
	} else {
		$sql_ubah = "UPDATE tb_buku SET
        judul_buku='".$_POST['judul_buku']."',
        pengarang='".$_POST['pengarang']."',
        penerbit='".$_POST['penerbit']."',
        th_terbit='".$_POST['th_terbit']."',
		isbn = '".$isbn."',
		jml_buku = '".$_POST['jumlahbuku']."'
        WHERE id_buku='".$_POST['id_buku']."'";
    	$query_ubah = mysqli_query($koneksi, $sql_ubah);
	}
	
    if ($query_ubah) {
        echo "<script>
        Swal.fire({title: 'Ubah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'admindashboard.php?page=MyApp/data_buku';
            }
        })</script>";
        }else{
        echo "<script>
        Swal.fire({title: 'Ubah Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
        }).then((result) => {
            if (result.value) {
                window.location = 'admindashboard.php?page=MyApp/data_buku';
            }
        })</script>";
    }
}

