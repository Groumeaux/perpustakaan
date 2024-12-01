<section class="content-header">
	<h1>
		Reservasi
		<small>Saya</small>
	</h1>
	<ol class="breadcrumb">
		<li>
			<a href="index.php">
				<i class="fa fa-home"></i>
				<b>Si Perpustakaan</b>
			</a>
		</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="box box-primary">
		<div class="box-header with-border">
			<a href="?page=add_sirkul" title="Tambah Data" class="btn btn-primary">
				<i class="glyphicon glyphicon-plus"></i> Tambah Data</a>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class="table-responsive">
				<table id="example1" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th>ID Reservasi</th>
							<th>Buku</th>
							<th>Tgl Pinjam</th>
							<th>Actions</th>
                            <th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						$sql = $koneksi->query("SELECT 
                        s.id_reservasi, 
                        b.judul_buku,
                        s.tanggal_reservasi,
                        s.status
                        from tb_reservasi s inner join tb_buku b on s.id_buku=b.id_buku order by tanggal_reservasi desc");
						while ($data = $sql->fetch_assoc()) {
						?>
							<tr>
								<td>
									<?php echo $no++; ?>
								</td>
								<td>
									<?php echo $data['id_reservasi']; ?>
								</td>
								<td>
									<?php echo $data['judul_buku']; ?>
								</td>
								<td>
									<?php $tgl = $data['tanggal_reservasi'];
									echo date("d/M/Y", strtotime($tgl)) ?>
								</td>
                                <td>
                                    <?php 
                                        if ($data['status'] == "Diterima"){    
                                    ?>
                                    -
                                    <?php
                                        }else {
                                    ?>
                                    <!-- Dropdown Button -->
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="actionMenu" data-toggle="dropdown" aria-expanded="false">
                                            Action <span class="caret"></span>
                                        </button>
                                        <!-- Dropdown Menu -->
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="actionMenu">
                                            <li>
                                                <a href="?page=panjang&kode=<?php echo $data['id_reservasi']; ?>" 
                                                onclick="return confirm('Perpanjang Data Ini ?')" 
                                                title="Perpanjang">
                                                    <i class="glyphicon glyphicon-upload"></i> Perpanjang
                                                </a>
                                            </li>
                                            <li>
                                                <a href="?page=kembali&kode=<?php echo $data['id_reservasi']; ?>" 
                                                onclick="return confirm('Kembalikan Buku Ini ?')" 
                                                title="Kembalikan">
                                                    <i class="glyphicon glyphicon-download"></i> Kembalikan
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                </td>
                                <td>
									<?php echo $data['status']; ?>
								</td>
							</tr>
						<?php
						}
						?>
					</tbody>

				</table>
			</div>
		</div>
	</div>
</section>
