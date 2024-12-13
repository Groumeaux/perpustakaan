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
                        $no = 1;

                        // Mengambil data reservasi dengan menggabungkan tabel reservasi, buku, dan sirkulasi
                        $sql = $koneksi->query("SELECT 
                                s.id_reservasi, 
                                b.judul_buku,
                                s.tanggal_reservasi, 	
                                sk.tgl_kembali,
                                s.status,
                                sk.id_sk
                            FROM tb_reservasi s 
                            INNER JOIN tb_buku b ON s.id_buku = b.id_buku
                            LEFT JOIN tb_sirkulasi sk ON sk.id_sk = s.id_sk
                            WHERE s.id_anggota = '$data_id_anggota'
                            ORDER BY s.status ASC, s.tanggal_reservasi ASC
                        ");

                        while ($data = $sql->fetch_assoc()) {
                            $tgl_kembali = $data['tgl_kembali'];
                            $today = date("Y-m-d");

                            $ambilperpanjangan = mysqli_query($koneksi, "SELECT sirkul.id_sk, req.id_sk, req.req_status
                                FROM tb_sirkulasi AS sirkul
                                LEFT JOIN tb_requests AS req ON sirkul.id_sk = req.id_sk
                                WHERE sirkul.id_sk = '". $data['id_sk'] ."'");
                            $ambilreq = mysqli_fetch_array($ambilperpanjangan);
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
                                    $status = $ambilreq['req_status'];
                                    if ($tgl_kembali && $status != "Pending") {
                                        echo date("d/M/Y", strtotime($tgl_kembali));
                                        
                                        $diff = (strtotime($tgl_kembali) - strtotime($today)) / (60 * 60 * 24);

                                        if ($diff == 0 && $data['status'] == "Diterima") {
                                            $jatuhtempo = TRUE;
                                            echo "<span style='color: red; font-weight: bold;'> (Sudah Jatuh Tempo!)</span>";
                                        }
                                        elseif ($diff > 0 && $diff <= 3 && $data['status'] == "Diterima") {
                                            $jatuhtempo = TRUE;
                                            echo "<span style='color: red; font-weight: bold;'> (Jatuh Tempo " . $diff . " Hari Lagi!)</span>";
                                        }
                                        elseif ($diff < 0 && $data['status'] == "Diterima") {
                                            $jatuhtempo = TRUE;
                                            echo "<span style='color: red; font-weight: bold;'> (Sudah Lewat Jatuh Tempo!)</span>";
                                        }else {
                                            $jatuhtempo = FALSE;
                                            echo "-";
                                        }
                                    } elseif ($status == "Pending"){
                                        $jatuhtempo = FALSE;
                                        echo date("d/M/Y", strtotime($tgl_kembali));
                                        echo "<span style='color: gray; font-weight: bold;'> (Menunggu persetujuan perpanjangan...)</span>";
                                    } else {
                                        $jatuhtempo = FALSE;
                                        echo "-";
                                    }
                                    ?>
                                </td>

                                <!-- Actions untuk membatalkan reservasi -->
                                <td>
                                    <?php if ($data['status'] == "Pending"){ ?>
                                        <a href="?page=reservasiuser/delete_reservasi&id_reservasi=<?php echo $data['id_reservasi']; ?>" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Batalkan reservasi ini?')" 
                                           title="Batalkan">
                                            <i class="glyphicon glyphicon-remove"></i> Batalkan
                                        </a>
                                    <?php }elseif ($data['status'] == "Diterima" && $jatuhtempo){ ?>
                                        <!-- Button to trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#<?php echo $data['id_sk']; ?>">
                                            Perpanjang
                                        </button>
                                        <div class="modal fade" id="<?php echo $data['id_sk']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        <h4 class="modal-title" id="myModalLabel">Alasan Perpanjangan Peminjaman Buku</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="userdashboard.php?page=reservasiuser/perpanjang">
                                                            <input type="hidden" name="sk" value="<?php echo $data['id_sk']; ?>"></input>
                                                            <div class="form-group">
                                                                <textarea class="form-control" name="msg" id="textarea" maxlength="500" placeholder="Type here..." style="width: 550px; height: 240px;"></textarea>
                                                                <p style="opacity: 0.5 ;color: gray; font-size: 14px;">Maksimal panjang pesan : 500 karakter</p>
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" name="submitrequest" class="btn btn-primary">Submit</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php 
                                        } else { 
                                    ?>
                                        <span>-</span>
                                    <?php
                                    }
                                    ?>
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
