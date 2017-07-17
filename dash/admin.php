<?php

//panggil DB
include 'system/db.php';
if (empty($level == 'admin')) {
  header("location:index.php");     // dan alihkan ke index.php
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
    <div class="judul"><i class="fa fa-user fa-lg"></i> Admin Menu <?php echo $lastlogin;?></div>
    <div class="isi">
<?php
//panggil program dan kegiatan
include 'admin_core_1.php';

//data skpd
include 'admin_core_2.php';

//tahun
include 'admin_core_3.php';


//jika tidak ada set
  if (!@$_GET['set']) {
    echo '<div id="menu_admin">';
    echo '<a href="?set=1"><div class="admin_menu"><i class="fa fa-folder fa-lg"></i> Daftar Program dan Kegiatan</div></a><div class="clear"></div>
      <a href="?set=2"><div class="admin_menu"><i class="fa fa-edit fa-lg"></i> Data SKPD</div></a><div class="clear"></div>
      <a href="?set=3"><div class="admin_menu"><i class="fa fa-calendar fa-lg"></i> Data Tahun</div></a><div class="clear"></div>';
    echo '</div>';
  }
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
  $('#menu1').click(function(){
    $('#menu_admin').fadeToggle();
    $('#admin_modal').fadeToggle();
  });
  $('#kembali').click(function(){
    $('#admin_modal').fadeToggle();
    $('#menu_admin').fadeToggle();
  });
  <?php
  $q_java = mysqli_query($koneksi,"SELECT * FROM `tb_program` ORDER BY `no_program` ASC");
  while ($data = mysqli_fetch_array($q_java)) {
  echo "
  $('#buka_".$data[0]."').click(function(){
    $('#colap_".$data[0]."').fadeIn()
    $('#tutup_".$data[0]."').show();
    $('#buka_".$data[0]."').hide();
  });
  $('#tutup_".$data[0]."').click(function(){
    $('#colap_".$data[0]."').fadeOut()
    $('#buka_".$data[0]."').show();
    $('#tutup_".$data[0]."').hide();
  });
  $('#edit_".$data[0]."').click(function(){
    $('.tampil_edit_p_".$data[0]."').fadeToggle();
  });";
}
  ?>
  $('#program').click(function(){
    $('.tampil_modal_program').fadeToggle();
  });
  $('.close_pro').click(function(){
    $('.tampil_modal_program').fadeToggle();
  });
  $('#kegiatan').click(function(){
    $('.tampil_modal_kegiatan').fadeToggle();
  });
  $('.close_keg').click(function(){
    $('.tampil_modal_kegiatan').fadeToggle();
  });
  $('#skpd').click(function(){
    $('.tampil_modal_SKPD').fadeToggle();
  });
});
</script>
  </body>
</html>