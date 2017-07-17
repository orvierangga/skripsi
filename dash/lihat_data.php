<?php

//panggil DB
include 'system/db.php';
  function rupiah($nilai, $pecahan = 0) {
    return number_format($nilai, $pecahan, ',', '.');
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
<script type="text/javascript">
var s5_taf_parent = window.location;
function popup_print(){
window.open(<?php
echo "'print.php?print=";
if (@$_GET['set']=='1') {
  echo 'pd';
}
if (@$_GET['set']=='2'){
  echo 'da';
}
if (!@$_GET['set']) {
  echo 'pdda';
}
if (@$_GET['skpd']) {
  echo '&skpd='.$_GET['skpd'];
}
echo "'"?>,'page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=no,width=750,height=600,left=50,top=50,titlebar=no')
}
</script>
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
    <div class="judul"><i class="fa fa-list-alt fa-lg"></i> Lihat Data <?php echo $lastlogin;?></div>
    <div class="isi">
    <?php
    echo '<a href="?set=2" class="button_keg" style="padding: 6px"><i class="fa fa-folder fa-lg"></i> Pagu Dana</a>
    <a href="?set=1" class="button_keg" style="padding: 6px"><i class="fa fa-folder fa-lg"></i> Dana Anggaran</a>
    <a href="lihat_data.php" class="button_keg" style="padding: 6px"><i class="fa fa-folder fa-lg"></i> Pagu dan Anggaran Dana</a>
    <a href="#" class="button_pro" style="padding: 6px" onClick="popup_print()"><i class="fa fa-print fa-lg"></i> Cetak Data</a>

    <div class="clear" />';
      echo '<center><h1>Prioritas Plafon Anggaran Sementara</h1></center>';

      //hanya pagu dana
      include 'lihat_core_1.php';

      //pagu dana dan anggaran dana
      include 'lihat_core_2.php';

      //hanya anggaran dana
      include 'lihat_core_3.php';
    ?>
    </div>
    </div>
  </section>

<?php
//panggil Footer
include 'system/footer.php';

?>
<script type="text/javascript">
  $(document).ready(function(){
  $('table tr').click(function(){
    window.location = $(this).attr('href');
    return false;
  });
  });
</script>

  </body>
</html>
