<section class="content-header">
	<h1>
		Reservasi
		<small><?php echo $data_nama; ?></small>
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
						$queryanggota = mysqli_query($koneksi, "SELECT * FROM tb_anggota WHERE nama='$data_nama'");
						$takeanggota = mysqli_fetch_assoc($queryanggota);
						$idanggota = $takeanggota['id_anggota'];

						$no = 1;
						$sql = $koneksi->query("SELECT 
                        s.id_reservasi, 
                        b.judul_buku,
                        s.tanggal_reservasi,
                        s.status
                        from tb_reservasi s inner join tb_buku b on s.id_buku=b.id_buku WHERE s.id_anggota = '$idanggota' order by tanggal_reservasi desc");
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
                                        if ($data['status'] == "Diterima" || $data['status'] == "Ditolak"){    
                                    ?>
                                    -
                                    <?php
                                        } elseif ($data['status'] == "Pending") {
                                    ?>
                                    <!-- Batal reservasi -->
                                    <a href="?page=reservasiuser/delete_reservasi&id_reservasi=<?php echo $data['id_reservasi']; ?>" 
										   class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Batalkan reservasi ini?')" 
                                           title="Batalkan">
                                            <i class="glyphicon glyphicon-remove"></i> Batalkan Reservasi
                                        </a>
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
