<?php
    $ambiluser = mysqli_query($koneksi, "SELECT * FROM tb_anggota WHERE id_anggota = '$data_id_anggota'");
    $user = mysqli_fetch_array($ambiluser);
    if ($user['profile_image'] == "" || $user['profile_image'] == NULL ){
        $profileimage = "https://via.placeholder.com/150";
    } else {
        $profileimage = "images/profiles/".$user['profile_image'];
    }
?>


<!-- Profile header -->
<section class="content-header">
    <div class="row" style="display: flex; align-items: center;">
        <div class="col-sm-3">
            <h1 class="m-0">Profil</h1> 
        </div>
    </div>
</section>

<!-- Edit user profile card -->
<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-default" style="padding: 20px; margin-top: 20px;">
        <div class="panel-body">
          <div class="text-center" style="margin-bottom: 20px; position: relative;">
            <img 
              id="profileImage"
              src="<?php echo $profileimage; ?>" 
              alt="Profile Picture" 
              class="img-circle img-responsive center-block" 
              style="object-fit: cover; width: 150px; height: 150px; cursor: pointer;">
            <button 
              class="btn btn-primary btn-xs" 
              style="position: absolute; top: 1px; right: 175px; border-radius: 50%; width: 30px; height: 30px; padding: 0; text-align: center; font-size: 18px;" 
              onclick="document.getElementById('fileInput').click()">
              +
            </button>
            <form action="" method="post" enctype="multipart/form-data">  
            <button 
                type="submit"
                class="btn btn-primary btn-sm" 
                style="position: absolute; top: 10px; right: 10px;" 
                name="editprofil">
                Simpan
            </button>
            <input 
              id="fileInput"
              name = "imginput"
              type="file" 
              style="display: none;" 
              accept="image/*"
              onchange="previewImage(event)">
            <h3 style="margin-top: 10px;"><?php echo $user['nama'];?></h3>
          </div>
          <div class="text-left" style="margin-top: 20px;">
              <div class="form-group row">
                <label for="iduser" class="col-md-3 control-label"><strong>ID:</strong></label>
                <div class="col-md-9">
                  <input type="text" name="id_anggota" class="form-control" id="id" value="<?php echo $user['id_anggota'];?>" style="display: none;">
                  <input type="text" class="form-control" id="id" value="<?php echo $user['id_anggota'];?>" disabled>
                </div>
              </div>
              <div class="form-group row">
                <label for="nama" class="col-md-3 control-label"><strong>Name:</strong></label>
                <div class="col-md-9">
                  <input type="text" name="nama" class="form-control" id="nama" value="<?php echo $user['nama'];?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="gender" class="col-md-3 control-label"><strong>Gender:</strong></label>
                <div class="col-md-9">
                  <select class="form-control" name="gender" id="gender">
                    <option value="Laki-laki" <?php echo($user['jekel']=='Laki-laki')? 'selected' : '' ;?>>Laki-laki</option>
                    <option value="Perempuan" <?php echo($user['jekel']=='Perempuan')? 'selected' : '' ;?>>Perempuan</option>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="city" class="col-md-3 control-label"><strong>City:</strong></label>
                <div class="col-md-9">
                  <input type="text" name="kota" class="form-control" id="city" value="<?php echo $user['kelas'];?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="phone" class="col-md-3 control-label"><strong>Phone Number:</strong></label>
                <div class="col-md-9">
                  <input type="text" name="nohp" class="form-control" id="phone" value="<?php echo $user['no_hp'];?>">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
if (isset ($_POST['editprofil'])){
    
    $iduser = $_POST['id_anggota'];
    $nama = $_POST['nama'];
    $jekel = $_POST['gender'];
    $kota = $_POST['kota'];
    $nohp = $_POST['nohp'];

    if (isset ($_FILES['imginput']) && $_FILES['imginput']['error'] == UPLOAD_ERR_OK){
        $targetDir = "images/profiles/";

        $fileNameBefore = basename($_FILES['imginput']['name']);
        $targetFilePath = $targetDir . $fileNameBefore;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Validate file type
        $allowedTypes = ['jpg', 'jpeg', 'png'];
        if (in_array(strtolower($fileType), $allowedTypes)) {
            // Move the uploaded file to the directory
            if (move_uploaded_file($_FILES['imginput']['tmp_name'], $targetFilePath)) {
                $filename = $fileNameBefore;
            }
        }
        $sql_ubah_profil = "UPDATE tb_anggota SET
        nama = '$nama',
        jekel = '$jekel',
        kelas = '$kota',
        no_hp = '$nohp',
        profile_image = '$filename' 
        WHERE id_anggota = '$iduser'
        ";
    }else{
        $sql_ubah_profil = "UPDATE tb_anggota SET
        nama = '$nama',
        jekel = '$jekel',
        kelas = '$kota',
        no_hp = '$nohp'
        WHERE id_anggota = '$iduser'
        ";
    }
    $namapengguna = $data_nama;
    $id_pengguna = null;
    if ($stmt = $koneksi->prepare("SELECT id_pengguna FROM tb_pengguna WHERE nama_pengguna = ?")) {
        $stmt->bind_param("s", $namapengguna); 
        $stmt->execute(); 
        $stmt->bind_result($id_pengguna); 
        $stmt->fetch(); 
        $stmt->close(); 
    }

    $array_nama = explode(" ", $nama);
    $username = $array_nama[0];

    $sql_pengguna = "UPDATE tb_pengguna SET 
    nama_pengguna='$nama', 
    username='$username' 
    WHERE id_pengguna='$id_pengguna'";

    $querysimpanperubahan = mysqli_query($koneksi, $sql_ubah_profil);
    $changeusername = mysqli_query($koneksi, $sql_pengguna);
    
    if ($querysimpanperubahan && $changeusername){
        $nama_pengguna = null;
        if ($stmt = $koneksi->prepare("SELECT nama_pengguna FROM tb_pengguna WHERE id_pengguna = ?")) {
            $stmt->bind_param("s", $id_pengguna); 
            $stmt->execute(); 
            $stmt->bind_result($nama_pengguna); 
            $stmt->fetch(); 
            $stmt->close(); 
        }
        $_SESSION["ses_nama"] = $nama_pengguna;
        echo "<script>
            Swal.fire({title: 'Data User Berhasil Diubah',text: '',icon: 'success',confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    window.location = 'userdashboard.php?edit=edited';
                }
            })</script>";
    }else{
        echo "<script>
            Swal.fire({title: 'Ubah Data User Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
            }).then((result) => {
                if (result.value) {
                    window.location = 'userdashboard.php?page=profil';
                }
            })</script>";
    }
}
?>
