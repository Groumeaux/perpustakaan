<?php
	$sql = $koneksi->query("SELECT count(id_buku) as buku from tb_buku");
	while ($data= $sql->fetch_assoc()) {
		$buku=$data['buku'];
	}
    if (isset($_GET['msg']) == "reservasisukses"){
        echo "<script> alert('Reservasi Berhasil!')</script>";
    }
    function formatIsbnWithHyphens($isbn) {
        return substr($isbn, 0, 3) . '-' . substr($isbn, 3, 3) . '-' . substr($isbn, 6, 4) . '-' . substr($isbn, 10, 2) . '-' . substr($isbn, 12, 1);
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
                    $isbn = formatIsbnWithHyphens($data['isbn']);
                    if ($data['cover'] == "" || $data['cover'] == NULL){
                        $cover = "https://placehold.co/1000x800";
                    } else {
                        $cover = "images/covers/".$data['cover'];
                    }
            ?>
            <!-- Card 1 -->
            <div class="col-md-3 col-sm-6">
                <div class="panel panel-default" style="position: relative;">
                    <button class="btn btn-success" style="position: absolute; top: 5px; right: 5px; z-index: 10;" onclick="confirmAction('<?php echo $data['id_buku'] ?>')">Reservasi</button>
                    <div class="panel-heading" style="padding: 0; height: 280px; overflow: hidden;">
                        <img src="<?= $cover ?>" alt="<?= $data['cover']; ?>" class="img-responsive" style="object-fit: scale-down;width: 100%; height: 100%;">
                    </div>
                    <div class="panel-body">
                        <h4><strong><?php echo $data['judul_buku'];  ?></strong></h4>
                        <p>Oleh: <strong><?php echo $data['pengarang'];  ?></strong> (Tahun: <strong><?php echo $data['th_terbit'];  ?></strong>)</p>
                        <p>Penerbit: <strong><?php echo $data['penerbit'];  ?></strong></strong></p>
                        <p>ISBN: <strong><?php echo $isbn;  ?></strong></strong></p>
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
