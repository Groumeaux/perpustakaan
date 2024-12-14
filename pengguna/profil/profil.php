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
            <h1 class="m-0" style="margin-left: 525px;">Profil</h1> 
        </div>
    </div>
</section>

<!-- User profile card -->
<section>
<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-default" style="padding: 20px; margin-top: 20px;">
        <div class="panel-body">
          <button 
            class="btn btn-primary btn-sm" 
            style="position: absolute; top: 10px; right: 10px;" >
            <a href="?page=profiledit" style="color: white;">Edit</a>
          </button>
          <div class="text-center" style="margin-bottom: 20px;">
            <img 
              src="<?php echo $profileimage; ?>" 
              alt="Profile Picture" 
              class="img-circle img-responsive center-block" 
              style="object-fit: cover; width: 150px; height: 150px;">
            <h3 style="margin-top: 10px;"><?php echo $user['nama'];?></h3>
          </div>
          <div class="text-left" style="margin-top: 20px;">
            <p style="padding-bottom: 18px;"><strong>ID:</strong> <?php echo $user['id_anggota'];?></p>
            <p style="padding-bottom: 18px;"><strong>Name:</strong> <?php echo $user['nama'];?></p>
            <p style="padding-bottom: 18px;"><strong>Gender:</strong> <?php echo $user['jekel'];?></p>
            <p style="padding-bottom: 18px;"><strong>City:</strong> <?php echo $user['kelas'];?></p>
            <p style="padding-bottom: 18px;"><strong>Phone Number:</strong> <?php echo $user['no_hp'];?></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>

