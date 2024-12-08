<!-- Section Content -->
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
        <div class="box-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Reservasi</th>
                            <th>Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Actions</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        // Mengambil data anggota saat ini
                        $queryanggota = mysqli_query($koneksi, "SELECT * FROM tb_anggota WHERE nama='$data_nama'");
                        $takeanggota = mysqli_fetch_assoc($queryanggota);
                        $idanggota = $takeanggota['id_anggota'];

                        $no = 1;

                        // Mengambil data reservasi dengan menggabungkan tabel reservasi, buku, dan sirkulasi
                        $sql = $koneksi->query("SELECT 
                                s.id_reservasi, 
                                b.judul_buku,
                                s.tanggal_reservasi, 	
                                sk.tgl_kembali,
                                s.status
                            FROM tb_reservasi s 
                            INNER JOIN tb_buku b ON s.id_buku = b.id_buku
                            LEFT JOIN tb_sirkulasi sk ON sk.id_sk = s.id_sk
                            WHERE s.id_anggota = '$idanggota'
                            ORDER BY s.tanggal_reservasi DESC
                        ");

                        while ($data = $sql->fetch_assoc()) {
                            $tgl_kembali = $data['tgl_kembali'];
                            $today = date("Y-m-d");

                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $data['id_reservasi']; ?></td>
                                <td><?php echo $data['judul_buku']; ?></td>

                                <!-- Tanggal peminjaman -->
                                <td><?php echo date("d/M/Y", strtotime($data['tanggal_reservasi'])); ?></td>

                                <!-- Tanggal pengembalian -->
                                <td>
                                    <?php 
                                    if ($tgl_kembali) {
                                        echo date("d/M/Y", strtotime($tgl_kembali));

                                        // Kondisi untuk mengecek jatuh tempo
                                        if ($tgl_kembali <= $today) {
                                            echo "<span style='color: red; font-weight: bold;'> (Sudah Jatuh Tempo!)</span>";
                                        }
                                    } else {
                                        echo "-";
                                    }
                                    ?>
                                </td>

                                <!-- Actions untuk membatalkan reservasi -->
                                <td>
                                    <?php if ($data['status'] == "Pending"): ?>
                                        <a href="?page=reservasiuser/delete_reservasi&id_reservasi=<?php echo $data['id_reservasi']; ?>" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Batalkan reservasi ini?')" 
                                           title="Batalkan">
                                            <i class="glyphicon glyphicon-remove"></i> Batalkan
                                        </a>
                                    <?php else: ?>
                                        <span>-</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Status reservasi -->
                                <td><?php echo $data['status']; ?></td>
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
