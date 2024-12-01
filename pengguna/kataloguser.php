<?php
	$sql = $koneksi->query("SELECT count(id_buku) as buku from tb_buku");
	while ($data= $sql->fetch_assoc()) {
	
		$buku=$data['buku'];
	}
    if (isset($_GET['msg']) == "reservasisukses"){
        echo "<script> alert('Reservasi Berhasil!')</script>";
    }
?>

<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		Katalog Buku
	</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="container">
        <div class="row">
            <?php
                $no = 1;
                $sql = $koneksi->query("SELECT * from tb_buku");
                while ($data= $sql->fetch_assoc()) {
            ?>
            <!-- Card 1 -->
            <div class="col-md-3 col-sm-6">
                <div class="panel panel-default" style="position: relative;">
                    <button class="btn btn-success" style="position: absolute; top: 5px; right: 5px; z-index: 10;" onclick="confirmAction('<?php echo $data['id_buku'] ?>')">Button</button>
                    <div class="panel-heading" style="padding: 0; height: 280px; overflow: hidden;">
                        <img src="https://placehold.co/1000x800" alt="Book Cover 1" class="img-responsive" style="width: 100%; height: 100%;">
                    </div>
                    <div class="panel-body">
                        <h4>Book Name: <strong><?php echo $data['judul_buku'];  ?></strong></h4>
                        <p>Author: <strong><?php echo $data['pengarang'];  ?></strong> (Published: <strong><?php echo $data['th_terbit'];  ?></strong>)</p>
                        <p>Publisher: <strong><?php echo $data['penerbit'];  ?></strong></strong></p>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </div>

    <script>
        function confirmAction(idbuku) {
            var confirmation = confirm("Apakah anda yakin ingin mereservasi buku " + idbuku + "?");
            if (confirmation) {
                window.location.href = "pengguna/reservasi/add_reservasi.php?book=" + encodeURIComponent(idbuku);
            } else {
                alert("Reservasi dibatalkan.");
            }
        }
    </script>
