<?php
//panggil DB
include 'system/db.php';

//ganti tahun
  if (isset($_POST['g_tahun'])) {
    if ($_POST['tahun']=='null') {
      echo '<div id="tampil_modal_save"><div id="modal">
          <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Error</div>
            <p>Pilih Tahun !</p>
          <a href="Pengaturan.php"><button id="okesave">Oke</button></a>
        </div></div>';
    } else {
      $no_tahun=$_POST['tahun'];
      $query_tahun=mysqli_query($koneksi,"select * from tb_tahun where no_tahun = '$no_tahun'");
      while ($datas=mysqli_fetch_array($query_tahun)) {
        $_SESSION['notahun']=$datas[0];
        $_SESSION['tahun']=$datas[1];
        echo '<div id="tampil_modal_save"><div id="modal">
          <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
            <p>Data Tahun Berhasil di Ubah.</p>
          <a href="pengaturan.php"><button id="okesave">Oke</button></a>
        </div></div>';
      }
    }
  }

//ganti sandi
  if (isset($_POST['g_sandi'])) {
    if ((!$_POST['oldpass']) or (!$_POST['newpass']) or (!$_POST['connewpas'])){
      echo '<div id="tampil_modal_save"><div id="modal">
          <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Error</div>
            <p>Inputan kata sandi tidak boleh kosong !</p>
          <a href="Pengaturan.php"><button id="okesave">Oke</button></a>
        </div></div>';
    } else {
      $oldpass=md5(md5($_POST['oldpass']));
      $newpass=md5(md5($_POST['newpass']));
      $connewpas=md5(md5($_POST['connewpas']));
      $q_cari = mysqli_query($koneksi,"SELECT `sandi_skpd` FROM `tb_skpd` WHERE `sandi_skpd`='$oldpass'");
      while ($data = mysqli_fetch_array($q_cari)) {
        if ($newpass==$connewpas) {
          $query_insert=mysqli_query($koneksi,"UPDATE `tb_skpd` SET `sandi_skpd`='$newpass' WHERE `nomor_skpd`='$nouser'");
          echo '<div id="tampil_modal_save"><div id="modal">
          <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
            <p>Kata Sandi Berhasil di Ubah. Silahkan Login Kembali.</p>
          <a href="keluar.php"><button id="okesave">Oke</button></a>
        </div></div>';
        } else {
          echo '<div id="tampil_modal_save"><div id="modal">
          <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Error</div>
            <p>Konfirmasi kata sandi tidak cocok !</p>
          <a href="pengaturan.php"><button id="okesave">Oke</button></a>
        </div></div>';
        }
      }
      }
  }

//ganti profile
  if (isset($_POST['update_user'])) {
    mysqli_query($koneksi,"UPDATE `tb_skpd` SET `email`='".$_POST['email']."',`alamat`='".$_POST['alamat']."',`telepon`='".$_POST['telepon']."',`fax`='".$_POST['fax']."' WHERE `nomor_skpd`='".$nouser."'");
    echo '<div id="tampil_modal_save"><div id="modal">
    <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
      <p>Profile Berhasil di ubah!</p>
      <a href="pengaturan.php"><button id="okesave">Oke</button></a>
    </div></div>';
  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Badan Perencanaan Pembangunan Daerah</title>
    <link href="../css/styles.css" rel="stylesheet">
    <link href="../css/fonts.css" rel="stylesheet">
  </head>
  <body>

  <header>
<?php
//panggil header
include 'system/header.php';

?>
  </header>

  <section>
    <div class="content">
    <div class="judul"><i class="fa fa-gear fa-lg"></i> Pengaturan <?php echo $lastlogin;?></div>
    <div class="isi">
        <?php 

        echo '<div id="menu_sandi" style="display: none">';
          echo '<form method="post">';
          echo '<b>Kata Sandi Lama:</b>
          <input class="masuk" type="password" autocomplete="off" placeholder="Kata Sandi Lama" name="oldpass"><br/>';

          echo'<b>Kata Sandi Baru:</b>
          <input class="masuk" type="password" autocomplete="off" placeholder="Kata Sandi Baru" name="newpass"><br/>';

          echo'<b>Ulangi Kata Sandi Baru:</b>
          <input class="masuk" type="password" autocomplete="off" placeholder="Ulangi Kata Sandi Baru" name="connewpas"><br/>';
          echo '<input name="g_sandi" type="submit" class="save" value="Ganti Kata Sandi" style="float: left"> <a href="#" id="batal_1"><p class="button_batal">Batal</p></a>';
          echo '</form>';
        echo '</div>';



        echo '<div id="menu_tahun" style="display: none">';
        echo '<form method="post">';
        echo '<br><b>Tahun:</b></br>';
        echo '<select name="tahun" class="input_data" style="width: 100px; margin-left: 0px;">';
          echo '<option value="null">Tahun</option>';
                  $tahun = mysqli_query($koneksi,"select * from tb_tahun order by tahun ASC");
                  while ($rows = mysqli_fetch_array($tahun)) {
                    if ($notahun == $rows[0]) {
                      echo "<option value=\"".$rows['0']."\" selected>".$rows['1']."</option>";
                    } else {
                      echo "<option value=\"".$rows['0']."\">".$rows['1']."</option>";
                    }
                    
                  }
        echo '</select><div class="clear"></div>'; 
        echo '<input name="g_tahun" type="submit" class="save" value="Ganti Tahun" style="float: left"> <a href="#" id="batal_2"><p class="button_batal">Batal</p></a></form>';
        echo '</div>';


        $query_profile = mysqli_query($koneksi,"SELECT * FROM `tb_skpd` WHERE `nomor_skpd`='".$nouser."' ORDER BY `nomor_skpd` ASC");
        while ($data = mysqli_fetch_array($query_profile)) {
          echo '<div id="menu_profile" style="display: none">';
            echo '<form method="post">
            Nama SKPD: <br/><input class="masuk" autocomplete="off" placeholder="Nama Satuan Kerja Perangkat Daerah" name="namaskpd" type="text" value="'.$data[1].'" disabled><br />
            Email: <br/><input class="masuk" autocomplete="off" placeholder="Email@domain.com" name="email" type="email" value="'.$data[3].'"><br />
            Alamat: <br/><input class="masuk" autocomplete="off" placeholder="Alamat" name="alamat" type="text" value="'.$data[4].'"><br />
            Telepon: <br/><input class="masuk" autocomplete="off" placeholder="Telepon (08xxxx)" name="telepon" type="text" value="'.$data[5].'"><br />
            Fax: <br/><input class="masuk" autocomplete="off" placeholder="Fax (123xxxx)" name="fax" type="text" value="'.$data[6].'"><br />
            <button class="save" type="submit" name="update_user" style="background:#2980b9;padding: 10px;color: #fff;float: left;" href="#"><i class="fa fa-save fa-lg"></i> Simpan</button>
            <a href="#" id="batal_3" style="margin-left: 5px;background:#999;padding: 11px;color: #fff;float: left;"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"></i> Batal</a>
          </form>';
          echo '</div>';
        }

        echo '<div id="menu">';
        echo '<a href="#" id="menu_1"><div class="admin_menu"><i class="fa fa-key fa-lg"></i> Ganti Kata Sandi</div></a><div class="clear"></div>';
        echo '<a href="#" id="menu_2"><div class="admin_menu"><i class="fa fa-calendar fa-lg"></i> Ganti Tahun</div></a><div class="clear"></div>';
        echo '<a href="#" id="menu_3"><div class="admin_menu"><i class="fa fa-user fa-lg"></i> Edit Profile</div></a><div class="clear"></div>';
        echo '</div>';
        ?>
    </div>
    </div>
  </section>

<?php
//panggil Footer
include 'system/footer.php';

?>
<script>
$(document).ready(function(){
  $('#menu_1').click(function(){
    $('#menu').hide();
    $('#menu_sandi').fadeToggle();
  });
  $('#menu_2').click(function(){
    $('#menu_tahun').fadeToggle();
    $('#menu').hide();
  });
  $('#menu_3').click(function(){
    $('#menu_profile').fadeToggle();
    $('#menu').hide();
  });
  $('#batal_1').click(function(){
    $('#menu_sandi').hide();
    $('#menu').fadeToggle();
  });
  $('#batal_2').click(function(){
    $('#menu_tahun').hide();
    $('#menu').fadeToggle();
  });
  $('#batal_3').click(function(){
    $('#menu_profile').hide();
    $('#menu').fadeToggle();
  });
});
</script>
  </body>
</html>