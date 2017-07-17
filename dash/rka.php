<?php

//panggil DB
include 'system/db.php';

  function rupiah($nilai, $pecahan = 0) {
    return number_format($nilai, $pecahan, ',', '.');
  }

//hapus rka 
if (@$_GET['del']) {
  $query_target = mysqli_query($koneksi,"SELECT * FROM `tb_laporan_programkegiatan` WHERE `id_programkegiatan`='".$_GET['id']."' AND `nomor_skpd`='".$_GET['skpd']."' AND `no_tahun`='$notahun'");
  while ($data = mysqli_fetch_array($query_target)) {
    mysqli_query($koneksi,"DELETE FROM `tb_target` WHERE `no_target`='".$data[2]."'");
  }
  $query_belanja = mysqli_query($koneksi,"SELECT * FROM `tb_laporan_belanja` WHERE `id_programkegiatan`='".$_GET['id']."'
   AND `nomor_skpd`='".$_GET['skpd']."' AND `no_tahun`='$notahun'");
  while ($data = mysqli_fetch_array($query_belanja)) {
    mysqli_query($koneksi,"DELETE FROM `tb_belanja` WHERE `id_belanja`='".$data[1]."'");
  }
  mysqli_query($koneksi,"DELETE FROM `tb_laporan_programkegiatan` WHERE `id_programkegiatan`='".$_GET['id']."'
   AND `nomor_skpd`='".$_GET['skpd']."' AND `no_tahun`='$notahun'");
  mysqli_query($koneksi,"DELETE FROM `tb_laporan_belanja` WHERE `id_programkegiatan`='".$_GET['id']."'
   AND `nomor_skpd`='".$_GET['skpd']."' AND `no_tahun`='$notahun'");
  header('location: lihat_data.php');
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
  window.open(
<?php 
  echo "'print.php?print=rka&id=".$_GET['id']."&skpd=".$_GET['skpd']."'";
?>

  ,'page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=750,height=600,left=50,top=50,titlebar=yes')
}
  function popup_printi(){
  window.open(
<?php 
  echo "'print.php?print=bl&id=".$_GET['id']."&skpd=".$_GET['skpd']."'";
?>

  ,'page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=750,height=600,left=50,top=50,titlebar=yes')
}
function popup_printo(){
  window.open(
<?php 
  echo "'print.php?print=btl&id=".$_GET['id']."&skpd=".$_GET['skpd']."'";
?>

  ,'page','toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=750,height=600,left=50,top=50,titlebar=yes')
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
    <div class="judul"><i class="fa fa-list-alt fa-lg"></i> RKA <?php echo $lastlogin;?></div>
    <div class="isi">
    <?php

    echo '<form action="edit.php?id='.$_GET['id'].'&skpd='.$_GET['skpd'].'" method="post">';
    if ($level=='user'){
      echo '<button class="button_keg" name="submit_mult" type="submit"><i class="fa fa-pencil fa-lg"></i> Edit Data</button>';
    }
    echo '<a href="#"  class="button_batal" style="padding: 6px" id="butdel"><i class="fa fa-trash-o fa-lg"></i> Hapus Data</a>';
    echo '<a href="#"  class="button_pro" style="padding: 6px" onClick="popup_printi()"><i class="fa fa-print fa-lg"></i> Cetak Belanja Langsung</a>';
    echo '<a href="#"  class="button_pro" style="padding: 6px" onClick="popup_printo()"><i class="fa fa-print fa-lg"></i> Cetak Belanja Tidak Langsung</a>';
    echo '<a href="#"  class="button_pro" style="padding: 6px" onClick="popup_print()"><i class="fa fa-print fa-lg"></i> Cetak RKA</a>';
    echo '<a href="lihat_data.php" class="batal_admin" style="padding: 6px;"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"></i> &nbsp;&nbsp;&nbsp;Batal</a><br/>';

   //keterangan Atas
    echo '<div class="clear"></div><center><h1>Rencana Kerja dan Anggaran</h1></center>';
    $q_ket = mysqli_query($koneksi,"SELECT `tb_programkegiatan`.*,`tb_skpd`.`nomor_skpd`,`tb_skpd`.`nama_skpd`,`tb_kegiatan`.*,`tb_program`.`nama_program`,`tb_program`.*,`tb_laporan_belanja`.`id_laporan`,`tb_laporan_belanja`.`id_programkegiatan`,`tb_laporan_belanja`.`nomor_skpd` FROM tb_laporan_belanja
    LEFT JOIN `tb_programkegiatan` ON `tb_laporan_belanja`.`id_programkegiatan` = `tb_programkegiatan`.`id_programkegiatan` 
    LEFT JOIN `tb_skpd` ON `tb_laporan_belanja`.`nomor_skpd` = `tb_skpd`.`nomor_skpd` 
    LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` 
    LEFT JOIN `tb_program` ON `tb_programkegiatan`.`no_program` = `tb_program`.`no_program` WHERE `tb_laporan_belanja`.`id_programkegiatan`='".$_GET['id']."' AND `tb_laporan_belanja`.`nomor_skpd`='".$_GET['skpd']."' GROUP BY `tb_laporan_belanja`.`id_programkegiatan`");
    while ($ket = mysqli_fetch_assoc($q_ket)){
      echo '<table class="aktifitas" cellspacing="0" cellpadding="0" width="100%" >';
        echo '<tr valign="top">';
        echo '<td style="padding-bottom: 10px" width="30%">Nama SKPD </td><td width="20%">: '.$ket['nomor_skpd'].'</td><td width="50%">'.$ket['nama_skpd'].'</td>';
        echo '</tr><tr valign="top">';
        echo '<td style="padding-bottom: 10px" width="30%">Nama Program </td><td width="20%">: '.$ket['nomor_skpd'].'.'.$ket['no_program'].'</td><td width="50%">'.$ket['nama_program'].'</td>';
        echo '</tr><tr valign="top">';
        echo '<td style="padding-bottom: 10px" width="30%">Nama Kegiatan </td><td width="20%">: '.$ket['nomor_skpd'].'.'.$ket['no_program'].'.'.$ket['no_kegiatan'].'</td><td width="50%">'.$ket['nama_kegiatan'].'</td>';
        echo '</tr>';
      echo '</table><br/>';
    }

//isian data Keterangan Keluaran Dana
    $ppas = "SELECT * FROM `tb_laporan_programkegiatan`
    LEFT JOIN `tb_programkegiatan` ON `tb_laporan_programkegiatan`.`id_programkegiatan` = `tb_programkegiatan`.`id_programkegiatan` 
    LEFT JOIN `tb_target` ON `tb_laporan_programkegiatan`.`no_target` = `tb_target`.`no_target` 
    LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` 
    LEFT JOIN `tb_program` ON `tb_programkegiatan`.`no_program` = `tb_program`.`no_program` where `tb_laporan_programkegiatan`.`nomor_skpd`='".$_GET['skpd']."' AND `tb_laporan_programkegiatan`.`no_tahun`='$notahun' AND `tb_programkegiatan`.`id_kegiatan`='".$_GET['id']."' ORDER BY `tb_programkegiatan`.`no_program` ASC";
    $sasaran = mysqli_query($koneksi,$ppas);
    $target = mysqli_query($koneksi,$ppas);
      echo '<table class="aktifitas" cellspacing="0" cellpadding="0" width="100%">';
              echo '<tr class="header-tabel">';
        echo "<td class=\"kepala-tabel\" width=\"10%\">INDIKATOR</td>";
        echo "<td class=\"kepala-tabel\" width=\"55%\"  align='center'>TOLAK UKUR KINERJA</td>";
        echo "<td class=\"kepala-tabel\" width=\"15%\"  align='center'>TARGET KINERJA</td>";
        echo '</tr>';
        echo '<tr valign="top">';
        echo '<td class="isi-tabel" style="padding-bottom: 10px"><b>KELUARAN</b></td>';
        echo '<td class="isi-tabel">';
        while ($rows = mysqli_fetch_array($sasaran)) {
          echo $rows[9]."<br />";
          echo '<input name="id_target[]" value="'.$rows[8].'" type="hidden">';
        }
        echo '</td>';

        echo '<td class="isi-tabel">';
        while ($rows = mysqli_fetch_array($target)) {
          echo $rows[10]."<br />";
        }
        echo '</td>';

        echo '</tr><tr valign="top">';
        echo '<td class="isi-tabel" style="padding-bottom: 10px"><b>MASUKAN</b></td><td class="isi-tabel">Jumlah Dana</td><td class="isi-tabel">';

        $total = mysqli_query($koneksi,"SELECT `tb_laporan_belanja`.`id_belanja`,`tb_belanja`.`id_belanja`,SUM(`tb_belanja`.`harga_satuan`*`tb_belanja`.`volume`) as totali,`tb_laporan_belanja`.`id_laporan`,`tb_laporan_belanja`.`id_programkegiatan`,`tb_laporan_belanja`.`id_laporan`,`tb_programkegiatan`.`id_programkegiatan`,`tb_programkegiatan`.`id_kegiatan`,`tb_kegiatan`.`id_kegiatan`,`tb_kegiatan`.`no_kegiatan`,`tb_laporan_belanja`.`id_belanja`,`tb_belanja`.`id_belanja`,`tb_belanja`.`volume`,`tb_belanja`.`harga_satuan` FROM tb_laporan_belanja
        LEFT JOIN `tb_programkegiatan` ON `tb_laporan_belanja`.`id_programkegiatan` = `tb_programkegiatan`.`id_programkegiatan` 
        LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja` 
        LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` WHERE `tb_programkegiatan`.`id_programkegiatan`='".$_GET['id']."'
        AND `tb_laporan_belanja`.`nomor_skpd`='".$_GET['skpd']."' AND `tb_laporan_belanja`.`no_tahun`='$notahun' ");

        while ($rows = mysqli_fetch_assoc($total)) {
          echo 'Rp. '.rupiah($rows['totali'], 2);
        }

        echo '</td>';
        echo '</tr><tr>';
        echo '<td class="isi-tabel" colspan="3" style="padding: 5px">Kelompok Sasaran Kegiatan : Seluruh Kota Banjarbaru</td>';
        echo '</tr>';
      echo '</table><br />';



//isian RKA
    echo '<table class="aktifitas" cellspacing="0" cellpadding="0" width="100%" >';
        echo '<tr class="header-tabel">';
        echo "<td rowspan=\"2\" class=\"kepala-tabel\" width=\"10%\">No Rek.</td>";
        echo "<td rowspan=\"2\" class=\"kepala-tabel\" width=\"30%\" align='center'>Urain</td>";
        echo '<td colspan="3" width=\'30%\' class="kepala-tabel" style="border-bottom: 1px solid #ddd" align="center">RINCIAN PERHITUNGAN</td>';
        echo "<td rowspan=\"2\" class=\"kepala-tabel\" width=\"20%\"  align='center'>Jumlah</td>";
        echo '</tr>';
        echo '<tr class="header-tabel">';
        echo "<td class=\"kepala-tabel\" width=\"10%\" align=\"center\">Volume</td>";
        echo "<td class=\"kepala-tabel\" width=\"5%\" align=\"center\">Satuan</td>";
        echo "<td class=\"kepala-tabel\" width=\"15%\" align=\"center\">Harga Satuan</td>";
        echo "</tr>";
    $q_rka=mysqli_query($koneksi,"SELECT * FROM tb_laporan_belanja
    LEFT JOIN `tb_ket_belanja` ON `tb_laporan_belanja`.`id_ket` = `tb_ket_belanja`.`id_ket` 
    LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja` WHERE `tb_laporan_belanja`.`id_programkegiatan`='".$_GET['id']."' AND `tb_laporan_belanja`.`nomor_skpd`='".$_GET['skpd']."' AND `tb_laporan_belanja`.`no_tahun`='$notahun' GROUP BY `tb_ket_belanja`.`id_ket` ORDER BY `tb_ket_belanja`.`id_ket` DESC");
    while ($data = mysqli_fetch_assoc($q_rka)) {

      $q_master = "SELECT * FROM tb_laporan_belanja
      LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja` WHERE `tb_laporan_belanja`.`id_ket`='".$data['id_ket']."' AND `tb_laporan_belanja`.`id_programkegiatan`='".$_GET['id']."' 
       AND `tb_laporan_belanja`.`nomor_skpd`='".$_GET['skpd']."' AND `tb_laporan_belanja`.`no_tahun`='$notahun' ORDER BY `tb_laporan_belanja`.`id_programkegiatan` ASC";
      $q_cari = mysqli_query($koneksi,"$q_master");
      // PPAS
      $total = mysqli_query($koneksi,"SELECT `tb_laporan_belanja`.`id_belanja`,`tb_belanja`.`id_belanja`,`tb_laporan_belanja`.`id_laporan`, SUM(`tb_belanja`.`harga_satuan`*`tb_belanja`.`volume`) AS totali FROM `tb_laporan_belanja`
      LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja` WHERE `tb_laporan_belanja`.`id_ket`='".$data['id_ket']."' AND `tb_laporan_belanja`.`id_programkegiatan`='".$_GET['id']."' 
       AND `tb_laporan_belanja`.`nomor_skpd`='".$_GET['skpd']."' AND `tb_laporan_belanja`.`no_tahun`='$notahun' ");
      echo '<tr>';
        echo "<td class=\"isi-tabel\"></td>";
        echo "<td class=\"isi-tabel\"><b>".$data['nama_belanja']."</b></td>";
        echo "<td class=\"isi-tabel\"></td>";
        echo "<td class=\"isi-tabel\"></td>";
        echo "<td class=\"isi-tabel\"></td>";
        echo "<td class=\"isi-tabel\" align=\"center\"><b><span style=\"float: left\">Rp. </span><span style=\"float: right\">";
        while ($cek = mysqli_fetch_assoc($total)) {
          echo rupiah($cek['totali'], 2);
        }
        echo "</span></b></td>";
      echo "</tr>";
      while ($row = mysqli_fetch_assoc($q_cari)) {
        echo '<tr align="center" valign="top">';
          echo "<td class=\"isi-tabel\" align='left'>".$row['id_ket'].".".$row['kode_belanja']."</td>";
          echo "<td class=\"isi-tabel\" align='left'>".$row['uraian']."</td>";
          echo "<td class=\"isi-tabel\">".$row['volume']."</td>";
          echo "<td class=\"isi-tabel\">".$row['satuan']."</td>";
          echo "<td class=\"isi-tabel\"><span style=\"float: left\">Rp. </span><span style=\"float: right\">".rupiah($row['harga_satuan'], 2)."</span></td>";
          echo "<td class=\"isi-tabel\"><span style=\"float: left\">Rp. </span><span style=\"float: right\">".rupiah($row['volume']*$row['harga_satuan'], 2)."</span></td>";
          echo '<input name="id_belanja[]" value="'.$row['id_belanja'].'" type="hidden">';
        echo "</tr>";
      }
    }
    echo "</table>";
    echo '</form>';

    echo '<div id="tampil_modal_save" class="menu_del" style="display: none"><div id="modal">
        <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
          <p>Apakah anda yakin ingin menghapus data ini ?</p>
        <a href="#" id="butbat"><button id="okesave" style="margin-left: 5px;background:#999;padding: 10px;color: #fff;">Batal</button></a>
        <a href="?id='.$_GET['id'].'&skpd='.$_GET['skpd'].'&del='.$_GET['id'].'"><button id="okesave">Hapus</button></a>
      </div></div>';
    
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
  $('#butdel').click(function(){
    $('.menu_del').show();
  });
  $('#butbat').click(function(){
    $('.menu_del').hide();
  });
});
</script>
  </body>
</html>