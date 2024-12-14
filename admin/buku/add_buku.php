<?php
//kode 9 digit
  
$carikode = mysqli_query($koneksi,"SELECT id_buku FROM tb_buku order by id_buku desc");
$datakode = mysqli_fetch_array($carikode);
$kode = $datakode['id_buku'];
$urut = substr($kode, 1, 3);
$tambah = (int) $urut + 1;

if (strlen($tambah) == 1) {
    $format = "B" . "00" . $tambah;
} else if (strlen($tambah) == 2) {
    $format = "B" . "0" . $tambah;
} else if (strlen($tambah) == 3) {
    $format = "B" . $tambah;
}
?>

<section class="content-header">
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
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Tambah Buku</h3>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<form action="" method="post" enctype="multipart/form-data">
					<div class="box-body">
						<div class="form-group">
							<label>ID Buku</label>
							<input type="text" name="id_buku" id="id_buku" class="form-control" value="<?php echo $format; ?>"
						>
						</div>

						<div class="form-group">
							<label>Judul Buku</label>
							<input type="text" name="judul_buku" id="judul_buku" class="form-control" placeholder="Judul Buku">
						</div>

						<div class="form-group">
							<label>Pengarang</label>
							<input type="text" name="pengarang" id="pengarang" class="form-control" placeholder="Nama Pengarang">
						</div>

						<div class="form-group">
							<label>Penerbit</label>
							<input type="text" name="penerbit" id="penerbiit" class="form-control" placeholder="Penerbit">
						</div>

						<div class="form-group">
							<label>Tahun Terbit</label>
							<input type="number" name="th_terbit" id="th_terbit" class="form-control" placeholder="Tahun Terbit">
						</div>

						<div class="form-group">
							<label>ISBN</label>
							<input type="number" name="isbn" id="isbn" class="form-control" placeholder="No ISBN">
						</div>

						<div class="form-group">
							<label>Jumlah Buku</label>
							<input type="number" name="jumlahbuku" id="jumlahbuku" class="form-control" placeholder="Jumlah Buku">
						</div>

						<div class="form-group">
							<label>Cover Image</label>
							<input type="file" name="file" id="file">
							<p style="opacity: 0.5 ;color: gray; font-size: 14px;">Format yang diterima : jpg, jpeg, atau png</p>
						</div>

					</div>
					<!-- /.box-body -->

					<div class="box-footer">
						<input type="submit" name="Simpan" value="Simpan" class="btn btn-info">
						<a href="?page=MyApp/data_buku" class="btn btn-warning">Batal</a>
					</div>
				</form>
			</div>
			<!-- /.box -->
</section>

<?php

    if (isset ($_POST['Simpan'])){
		
	// Process cover image
		// Directory where images will be saved
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

		$isbn = str_replace('-', '', $_POST['isbn']);
        $sql_simpan = "INSERT INTO tb_buku (id_buku,judul_buku,pengarang,penerbit,th_terbit,isbn,cover,jml_buku) VALUES (
           	'".$_POST['id_buku']."',
			'".$_POST['judul_buku']."',
			'".$_POST['pengarang']."',
			'".$_POST['penerbit']."',
			'".$_POST['th_terbit']."',
			'".$isbn."',
			'".$filename."',
			'".$_POST['jumlahbuku']."'
			)";
        $query_simpan = mysqli_query($koneksi, $sql_simpan);
        mysqli_close($koneksi);

    if ($query_simpan){

		echo "<script>
		Swal.fire({title: 'Tambah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
		}).then((result) => {
			if (result.value) {
				window.location = 'admindashboard.php?page=MyApp/data_buku';
			}
		})</script>";
		}else{
		echo "<script>
		Swal.fire({title: 'Tambah Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
		}).then((result) => {
			if (result.value) {
				window.location = 'admindashboard.php?page=MyApp/add_buku';
			}
		})</script>";
    }
  }
    
