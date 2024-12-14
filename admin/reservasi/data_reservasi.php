<?php // Pastikan session dimulai di awal file
if (isset($_GET['page']) && $_GET['page'] == 'ubah_status') {
    $id_reservasi = $_GET['kode'];
    $status = $_GET['status'];

    // Query untuk update status
    $sql_update = $koneksi->query("UPDATE tb_reservasi SET status='$status' WHERE id_reservasi='$id_reservasi'");

    if ($sql_update) {
        echo "<script>
            alert('Status berhasil diperbarui!');
            window.location.href='?page=reservasi';
        </script>";
    } else {
        echo "<script>
            alert('Status gagal diperbarui!');
            window.location.href='?page=reservasi';
        </script>";
    }
}
?>

<section class="content-header">
    <h1>
        Reservasi Admin
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
                            <th>Nama Anggota</th>
                            <th>Buku</th>
                            <th>Tgl Pinjam</th>
                            <?php if ($_SESSION['ses_level'] == 'Administrator'): ?>
                                <th>Actions</th>
                            <?php endif; ?>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $sql = $koneksi->query("SELECT 
                            s.id_reservasi, 
                            a.nama,
                            b.judul_buku,
                            s.tanggal_reservasi,
                            s.status
                            FROM tb_reservasi s 
                            INNER JOIN tb_buku b 
                            ON s.id_buku=b.id_buku 
                            INNER JOIN tb_anggota a
                            ON s.id_anggota=a.id_anggota
                            ORDER BY tanggal_reservasi DESC");
                        while ($data = $sql->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $data['id_reservasi']; ?></td>
                                <td><?php echo $data['nama']; ?></td>
                                <td><?php echo $data['judul_buku']; ?></td>
                                <td><?php echo date("d/M/Y", strtotime($data['tanggal_reservasi'])); ?></td>
                                <?php if ($_SESSION['ses_level'] == 'Administrator'): ?>
                                <td>
                                <?php if ($data['status'] == 'Diterima' || $data['status'] == 'Ditolak'): ?>
                                    <span class="badge" style="background-color: <?php echo ($data['status'] == 'Diterima') ? 'green' : 'red'; ?>; color: white;">
                                        <?php echo $data['status']; ?>
                                    </span>
                                <?php else: ?>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="actionMenu" data-toggle="dropdown" aria-expanded="false">
                                            Action <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="actionMenu">
                                            <li>
                                                <a href="admin/reservasi/proses.php?kode=<?php echo $data['id_reservasi']; ?>&status=Diterima" 
                                                onclick="return confirm('Setujui reservasi ini?')" 
                                                title="Setujui">
                                                    <i class="glyphicon glyphicon-ok"></i> Setuju
                                                </a>
                                            </li>
                                            <li>
                                                <a href="admin/reservasi/proses.php?kode=<?php echo $data['id_reservasi']; ?>&status=Ditolak" 
                                                onclick="return confirm('Tolak reservasi ini?')" 
                                                title="Tolak">
                                                    <i class="glyphicon glyphicon-remove"></i> Tolak
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                </td>

                                <?php endif; ?>
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
</section>
