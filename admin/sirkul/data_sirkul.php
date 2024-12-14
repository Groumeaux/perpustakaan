<section class="content-header">
	<h1>
		Sirkulasi Buku
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
							<th>ID SKL</th>
							<th>Buku</th>
							<th>Peminjam</th>
							<th>Tgl Pinjam</th>
							<th>Jatuh Tempo</th>
							<th>Denda</th>
							<th>Kelola</th>
						</tr>
					</thead>
					<tbody>

						<?php
						$no = 1;
						$sql = $koneksi->query("SELECT s.id_sk, b.judul_buku,
				  a.id_anggota,
				  a.nama,
				  s.tgl_pinjam, 
				  s.tgl_kembali
                  from tb_sirkulasi s inner join tb_buku b on s.id_buku=b.id_buku
				  inner join tb_anggota a on s.id_anggota=a.id_anggota where status='PIN' order by tgl_pinjam desc");
						while ($data = $sql->fetch_assoc()) {
						?>

							<tr>
								<td>
									<?php echo $no++; ?>
								</td>
								<td>
									<?php echo $data['id_sk']; ?>
								</td>
								<td>
									<?php echo $data['judul_buku']; ?>
								</td>
								<td>
									<?php echo $data['id_anggota']; ?>
									-
									<?php echo $data['nama']; ?>
								</td>
								<td>
									<?php $tgl = $data['tgl_pinjam'];
									echo date("d/M/Y", strtotime($tgl)) ?>
								</td>
								<td>
									<?php $tgl = $data['tgl_kembali'];
									echo date("d/M/Y", strtotime($tgl)) ?>
								</td>

								<?php

								$u_denda = 1000;

								$tgl1 = date("Y-m-d");
								$tgl2 = $data['tgl_kembali'];

								$pecah1 = explode("-", $tgl1);
								$date1 = $pecah1[2];
								$month1 = $pecah1[1];
								$year1 = $pecah1[0];

								$pecah2 = explode("-", $tgl2);
								$date2 = $pecah2[2];
								$month2 = $pecah2[1];
								$year2 =  $pecah2[0];

								$jd1 = GregorianToJD($month1, $date1, $year1);
								$jd2 = GregorianToJD($month2, $date2, $year2);

								$selisih = $jd1 - $jd2;
								$denda = $selisih * $u_denda;
								?>

								<td>
									<?php if ($selisih <= 0) { ?>
										<span class="label label-primary">Masa Peminjaman</span>
									<?php } elseif ($selisih > 0) { ?>
										<span class="label label-danger">
											Rp.
											<?= $denda ?>
										</span>
										<br> Terlambat :
										<?= $selisih ?>
										Hari
								</td>
							<?php } ?>

							<td>
								<a href="?page=panjang&kode=<?php echo $data['id_sk']; ?>" onclick="return confirm('Perpanjang Data Ini ?')" title="Perpanjang" class="btn btn-success">
									<i class="glyphicon glyphicon-upload"></i>
								</a>
								<a href="?page=kembali&kode=<?php echo $data['id_sk']; ?>" onclick="return confirm('Kembalikan Buku Ini ?')" title="Kembalikan" class="btn btn-danger">
									<i class="glyphicon glyphicon-download"></i>
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
	<h4> *Note
		<br> Masa peminjaman buku adalah <span style="color:red; font-weight:bold;">7 hari</span> dari tanggal peminjaman.
		<br> Jika buku dikembalikan lebih dari masa peminjaman, maka akan dikenakan <span style="color:red; font-weight:bold;">denda</span>
		<br> sebesar <span style="color:red; font-weight:bold;">Rp 1.000/hari</span>.
	</h4>
</section>

<section class="content-header">
    <h1>
        Permohonan Perpanjangan
    </h1>
</section>
<section class="content">
    <div class="box box-warning">
        <!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Request</th>
                            <th>ID Sirkul</th>
                            <th>Nama Anggota</th>
                            <th>Buku</th>
                            <th>Alasan Perpanjangan</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tanggal Kembali</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sql = $koneksi->query("SELECT 
                            req.id_req, 
                            a.nama,
                            b.judul_buku,
                            req.req_msg,
							sirkul.tgl_pinjam,
							sirkul.tgl_kembali,
                            req.id_sk
                            FROM tb_requests req
                            INNER JOIN tb_sirkulasi sirkul 
                            ON sirkul.id_sk=req.id_sk 
                            INNER JOIN tb_anggota a
                            ON sirkul.id_anggota=a.id_anggota
                            INNER JOIN tb_buku b 
                            ON sirkul.id_buku = b.id_buku
                            ORDER BY id_req DESC");
                        while ($data = $sql->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $data['id_req']; ?></td>
                                <td><?php echo $data['id_sk']; ?></td>
                                <td><?php echo $data['nama']; ?></td>
                                <td><?php echo $data['judul_buku']; ?></td>
                                <td><?php echo $data['req_msg'] ?></td>
								<td>
									<?php 
										$tgl = $data['tgl_pinjam'];
										echo date("d/M/Y", strtotime($tgl)) 
									?>
								</td>
                                <td>
									<?php 
										$tgl = $data['tgl_kembali'];
										echo date("d/M/Y", strtotime($tgl)) 
									?>
								</td>
                                <td>
									<div class="container" style="height: 100%;width: 120px; display: flex; justify-content: center; align-items: center;">
										<div class="btn-group">
											<form action="admindashboard.php?page=perpanjang" method="POST">
												<input type="hidden" name="sk" value="<?php echo $data['id_sk']; ?>"></input>
												<input type="hidden" name="req" value="<?php echo $data['id_req']; ?>"></input>
												<button type="submit" name="diterima" class="glyphicon glyphicon-ok btn btn-sm btn-success">Terima</button>
											</form>
											<form action="admindashboard.php?page=perpanjang" method="POST">
												<input type="hidden" name="sk" value="<?php echo $data['id_sk']; ?>"></input>
												<input type="hidden" name="req" value="<?php echo $data['id_req']; ?>"></input>
												<button type="submit" name="ditolak" class="glyphicon glyphicon-remove btn btn-sm btn-danger">Tolak</button>
											</form>
										</div>
									</div>
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
