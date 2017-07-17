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
  window.open(
<?php 
  echo "'print.php?print=rka&id=".$_GET['id']."&skpd=".$_GET['skpd']."'";
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
    <div class="judul"><i class="fa fa-list-alt fa-lg"></i> Lihat Data <?php echo $lastlogin;?></div>
    <div class="isi">
    <?php
    echo '<a href="#"  class="button_pro" style="padding: 6px" onClick="popup_print()"><i class="fa fa-print fa-lg"></i> Cetak Data</a><br/>';
      echo '<center><h1>Prioritas Plafon Anggaran Sementara</h1></center>';

      if ($level == 'admin') {
        echo '<form method="GET">';
        // Koding Menampilkan SKPD 
          echo '<select name="skpd" class="input_data" onchange="this.form.submit()" style="width: 97%">';
          echo '<option name="combo" value="all">-- Semua SKPD --</option>';
          $cari_skpd = mysqli_query($koneksi,"SELECT `tb_laporan_programkegiatan`.*,`tb_skpd`.* FROM `tb_laporan_programkegiatan` LEFT JOIN `tb_skpd` ON `tb_laporan_programkegiatan`.`nomor_skpd` = `tb_skpd`.`nomor_skpd` WHERE `tb_laporan_programkegiatan`.`no_tahun`='$notahun' GROUP BY `tb_laporan_programkegiatan`.`nomor_skpd` ");
          while ($data_cari_skpd = mysqli_fetch_array($cari_skpd)) {
            if ($_GET['skpd']==$data_cari_skpd['4']) {
              echo '<option name="combo" value="'.$data_cari_skpd[4].'" selected>'.$data_cari_skpd[6].'</option>';
            } else {
              echo '<option name="combo" value="'.$data_cari_skpd[4].'">'.$data_cari_skpd[6].'</option>';
            }
          }
          echo '</select>';
          echo '</form>';
      }

      if (!@$_GET['skpd']) {
        $group = mysqli_query($koneksi,"SELECT `tb_laporan_programkegiatan`.*,`tb_skpd`.* FROM `tb_laporan_programkegiatan`
        LEFT JOIN `tb_skpd` ON `tb_laporan_programkegiatan`.`nomor_skpd` = `tb_skpd`.`nomor_skpd` where `tb_laporan_programkegiatan`.`no_tahun`='$notahun' GROUP BY `tb_laporan_programkegiatan`.`nomor_skpd` ORDER BY `tb_laporan_programkegiatan`.`no_tabel` ASC");
      }
      if (@$_GET['skpd']) {
        $group = mysqli_query($koneksi,"SELECT `tb_laporan_programkegiatan`.*,`tb_skpd`.* FROM `tb_laporan_programkegiatan`
        LEFT JOIN `tb_skpd` ON `tb_laporan_programkegiatan`.`nomor_skpd` = `tb_skpd`.`nomor_skpd` where `tb_laporan_programkegiatan`.`nomor_skpd`='".$_GET['skpd']."'  AND `tb_laporan_programkegiatan`.`no_tahun`='$notahun' GROUP BY `tb_laporan_programkegiatan`.`nomor_skpd` ORDER BY `tb_laporan_programkegiatan`.`no_tabel` ASC");
      }
      if (@$_GET['skpd']=='all') {
        $group = mysqli_query($koneksi,"SELECT `tb_laporan_programkegiatan`.*,`tb_skpd`.* FROM `tb_laporan_programkegiatan`
        LEFT JOIN `tb_skpd` ON `tb_laporan_programkegiatan`.`nomor_skpd` = `tb_skpd`.`nomor_skpd` where `tb_laporan_programkegiatan`.`no_tahun`='$notahun' GROUP BY `tb_laporan_programkegiatan`.`nomor_skpd` ORDER BY `tb_laporan_programkegiatan`.`no_tabel` ASC");
      }
      

      echo '<table class="aktifitas" cellspacing="0" cellpadding="0">
          <tr class="header-tabel" href="#">
            <td class="kepala-tabel" width=\'11%\'>Kode</td>
            <td class="kepala-tabel" width="30%">Nama Program/Kegiatan</td>
            <td class="kepala-tabel" width="30%">Sasaran</td>
            <td class="kepala-tabel" width=\'9%\'>Target</td>
            <td class="kepala-tabel" width=\'20%\'>Jumlah Dana</td>
          </tr>';

      if ($level=='admin') {
      //ini All
        while ($skpd = mysqli_fetch_array($group)) {
          echo '<tr href="#" style="background-color: #ffe372">';
          echo "<td class='isi-tabel' width='11%'><b>".$skpd[4]."</b></td>";
          echo "<td colspan='4' class='isi-tabel'><b>".$skpd[6]."</b></td>";
          echo "</tr>";

            // Group Tidak langsung dan langsung
            $q_rka=mysqli_query($koneksi,"SELECT * FROM `tb_laporan_belanja`
            LEFT JOIN `tb_ket_belanja` ON `tb_laporan_belanja`.`id_ket` = `tb_ket_belanja`.`id_ket` 
            LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja` WHERE `tb_laporan_belanja`.`nomor_skpd`='".$skpd[4]."' AND `tb_laporan_belanja`.`no_tahun`='$notahun' GROUP BY `tb_ket_belanja`.`id_ket` ORDER BY `tb_ket_belanja`.`id_ket` DESC");
            
          //ket belanja
            while ($data_rka = mysqli_fetch_assoc($q_rka)) {
            
              // Group Tidak langsung dan langsung
            $q_total=mysqli_query($koneksi,"SELECT `tb_laporan_belanja`.`id_laporan`,`tb_laporan_belanja`.`id_belanja`,`tb_laporan_belanja`.`id_ket`,`tb_belanja`.`id_belanja`,SUM(`tb_belanja`.`volume`*`tb_belanja`.`harga_satuan`) as totalbelanja,`tb_laporan_belanja`.`nomor_skpd`,`tb_laporan_belanja`.`no_tahun` FROM tb_laporan_belanja
            LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja` where `tb_laporan_belanja`.`nomor_skpd`='".$skpd[4]."'  AND `tb_laporan_belanja`.`no_tahun`='$notahun' AND `tb_laporan_belanja`.`id_ket`='".$data_rka['id_ket']."'");

              echo '<tr href="#">';
                echo "<td class=\"isi-tabel\"></td>";
                echo "<td class=\"isi-tabel\"><b>".$data_rka['nama_belanja']."</b></td>";
                echo "<td class=\"isi-tabel\"></td>";
                echo "<td class=\"isi-tabel\"></td>";
                echo "<td class=\"isi-tabel\" align=\"center\"><b><span style=\"float: left\">Rp. </span><span style=\"float: right\">";
                while ($data_total_rka = mysqli_fetch_assoc($q_total)) {
                  echo rupiah($data_total_rka['totalbelanja'], 2);
                }
                
                echo "</span></b></td>";
              echo "</tr>";
            }

            echo '<tr href="#">';
              echo "<td class=\"isi-tabel\">&nbsp;</td>";
              echo "<td class=\"isi-tabel\">&nbsp;</td>";
              echo "<td class=\"isi-tabel\">&nbsp;</td>";
              echo "<td class=\"isi-tabel\">&nbsp;</td>";
              echo "<td class=\"isi-tabel\">&nbsp;</td>";
            echo '</tr>';
          //cari program dulu
          $q_program = mysqli_query($koneksi,"SELECT * FROM `tb_laporan_programkegiatan`
          LEFT JOIN `tb_programkegiatan` ON `tb_laporan_programkegiatan`.`id_programkegiatan` = `tb_programkegiatan`.`id_programkegiatan` 
          LEFT JOIN `tb_target` ON `tb_laporan_programkegiatan`.`no_target` = `tb_target`.`no_target` 
          LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` 
          LEFT JOIN `tb_program` ON `tb_programkegiatan`.`no_program` = `tb_program`.`no_program` where `tb_laporan_programkegiatan`.`nomor_skpd`='".$skpd[4]."'  AND `tb_laporan_programkegiatan`.`no_tahun`='$notahun' GROUP BY `tb_programkegiatan`.`no_program` ORDER BY `tb_programkegiatan`.`no_program` ASC");
          while ($program = mysqli_fetch_array($q_program)) {

            echo '<tr valign="top" href="#">';
            echo "<td class='isi-tabel'><b>".$program[4].".".$program[14]."</b></td>";
            echo "<td class='isi-tabel'><b>".$program[15]."</b></td>";
            echo "<td class='isi-tabel'></td>";
            echo "<td class='isi-tabel'></td>";
            echo "<td class='isi-tabel'></td>";
            echo "</tr>";


            //cari kegiatan dan pengelompokannya
            $q_kegiatan = mysqli_query($koneksi,"SELECT * FROM `tb_laporan_programkegiatan`
            LEFT JOIN `tb_programkegiatan` ON `tb_laporan_programkegiatan`.`id_programkegiatan` = `tb_programkegiatan`.`id_programkegiatan` 
            LEFT JOIN `tb_target` ON `tb_laporan_programkegiatan`.`no_target` = `tb_target`.`no_target` 
            LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` 
            LEFT JOIN `tb_program` ON `tb_programkegiatan`.`no_program` = `tb_program`.`no_program` where `tb_laporan_programkegiatan`.`nomor_skpd`='".$skpd[4]."' AND `tb_laporan_programkegiatan`.`no_tahun`='$notahun' AND `tb_programkegiatan`.`no_program`='".$program[14]."' GROUP BY `tb_programkegiatan`.`id_kegiatan` ORDER BY `tb_programkegiatan`.`no_program` ASC");
            while ($kegiatan = mysqli_fetch_array($q_kegiatan)) {

              //cari target dan pengelompokkannya
              $query_master = "SELECT * FROM `tb_laporan_programkegiatan`
              LEFT JOIN `tb_programkegiatan` ON `tb_laporan_programkegiatan`.`id_programkegiatan` = `tb_programkegiatan`.`id_programkegiatan` 
              LEFT JOIN `tb_target` ON `tb_laporan_programkegiatan`.`no_target` = `tb_target`.`no_target` 
              LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` 
              LEFT JOIN `tb_program` ON `tb_programkegiatan`.`no_program` = `tb_program`.`no_program` where `tb_laporan_programkegiatan`.`nomor_skpd`='".$skpd[4]."' AND `tb_laporan_programkegiatan`.`no_tahun`='$notahun' AND `tb_programkegiatan`.`id_kegiatan`='".$kegiatan[7]."' ORDER BY `tb_programkegiatan`.`no_program` ASC";
              $q_sasaran = mysqli_query($koneksi,$query_master);
              $q_target = mysqli_query($koneksi,$query_master);
              $q_dana = mysqli_query($koneksi,$query_master);


              echo '<tr class="pointer-tabel-link" valign="top" href="rka.php?id='.$kegiatan[1].'&skpd='.$kegiatan[4].'">';
              echo "<td class='isi-tabel'>".$kegiatan[4].".".$kegiatan[14].".".$kegiatan[12]."</td>";
              echo "<td class='isi-tabel'>".$kegiatan[13]."</td>";
              echo "<td class='isi-tabel'>";

              while ($rows = mysqli_fetch_array($q_sasaran)) {
                echo '<div class="master">'.$rows[9]."</div>";
              }
              
              echo "</td>";
              echo "<td class='isi-tabel'>";

              while ($rows = mysqli_fetch_array($q_target)) {
                echo '<div class="master">'.$rows[10]."</div>";
              }

              echo "</td>";
              echo "<td class='isi-tabel'>";

              $total = mysqli_query($koneksi,"SELECT `tb_laporan_belanja`.`id_belanja`,`tb_belanja`.`id_belanja`,SUM(`tb_belanja`.`harga_satuan`*`tb_belanja`.`volume`) as totali,`tb_laporan_belanja`.`id_laporan`,`tb_laporan_belanja`.`id_programkegiatan`,`tb_laporan_belanja`.`id_laporan`,`tb_programkegiatan`.`id_programkegiatan`,`tb_programkegiatan`.`id_kegiatan`,`tb_kegiatan`.`id_kegiatan`,`tb_kegiatan`.`no_kegiatan`,`tb_laporan_belanja`.`id_belanja`,`tb_belanja`.`id_belanja`,`tb_belanja`.`volume`,`tb_belanja`.`harga_satuan` FROM tb_laporan_belanja
              LEFT JOIN `tb_programkegiatan` ON `tb_laporan_belanja`.`id_programkegiatan` = `tb_programkegiatan`.`id_programkegiatan` 
              LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja` 
              LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` WHERE `tb_programkegiatan`.`id_kegiatan`='".$kegiatan[11]."'
              AND `tb_laporan_belanja`.`id_programkegiatan`='".$kegiatan[1]."' 
              AND `tb_laporan_belanja`.`nomor_skpd`='".$skpd[4]."' AND `tb_laporan_belanja`.`no_tahun`='$notahun' ");

              while ($rows = mysqli_fetch_assoc($total)) {
                echo '<div class="master"><span style="float: left">Rp. </span><span style="float: right">'.rupiah($rows['totali'], 2).'</span></div>';
              }

              echo "</td>";
              echo "</tr>";
            }
          }
        }
      } else {

            // Group Tidak langsung dan langsung
            $q_rka=mysqli_query($koneksi,"SELECT * FROM `tb_laporan_belanja`
            LEFT JOIN `tb_ket_belanja` ON `tb_laporan_belanja`.`id_ket` = `tb_ket_belanja`.`id_ket` 
            LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja` WHERE `tb_laporan_belanja`.`nomor_skpd`='".$nouser."' AND `tb_laporan_belanja`.`no_tahun`='$notahun' GROUP BY `tb_ket_belanja`.`id_ket` ORDER BY `tb_ket_belanja`.`id_ket` DESC");
            
          //ket belanja
            while ($data_rka = mysqli_fetch_assoc($q_rka)) {
            
              // Group Tidak langsung dan langsung
            $q_total=mysqli_query($koneksi,"SELECT `tb_laporan_belanja`.`id_laporan`,`tb_laporan_belanja`.`id_belanja`,`tb_laporan_belanja`.`id_ket`,`tb_belanja`.`id_belanja`,SUM(`tb_belanja`.`volume`*`tb_belanja`.`harga_satuan`) as totalbelanja,`tb_laporan_belanja`.`nomor_skpd`,`tb_laporan_belanja`.`no_tahun` FROM tb_laporan_belanja
            LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja` where `tb_laporan_belanja`.`nomor_skpd`='".$nouser."'  AND `tb_laporan_belanja`.`no_tahun`='$notahun' AND `tb_laporan_belanja`.`id_ket`='".$data_rka['id_ket']."'");

              echo '<tr href="#">';
                echo "<td class=\"isi-tabel\"></td>";
                echo "<td class=\"isi-tabel\"><b>".$data_rka['nama_belanja']."</b></td>";
                echo "<td class=\"isi-tabel\"></td>";
                echo "<td class=\"isi-tabel\"></td>";
                echo "<td class=\"isi-tabel\" align=\"center\"><b><span style=\"float: left\">Rp. </span><span style=\"float: right\">";
                while ($data_total_rka = mysqli_fetch_assoc($q_total)) {
                  echo rupiah($data_total_rka['totalbelanja'], 2);
                }
                
                echo "</span></b></td>";
              echo "</tr>";
            }

            echo '<tr href="#">';
              echo "<td class=\"isi-tabel\">&nbsp;</td>";
              echo "<td class=\"isi-tabel\">&nbsp;</td>";
              echo "<td class=\"isi-tabel\">&nbsp;</td>";
              echo "<td class=\"isi-tabel\">&nbsp;</td>";
              echo "<td class=\"isi-tabel\">&nbsp;</td>";
            echo '</tr>';
        //cari program dulu
          $q_program = mysqli_query($koneksi,"SELECT * FROM `tb_laporan_programkegiatan`
          LEFT JOIN `tb_programkegiatan` ON `tb_laporan_programkegiatan`.`id_programkegiatan` = `tb_programkegiatan`.`id_programkegiatan` 
          LEFT JOIN `tb_target` ON `tb_laporan_programkegiatan`.`no_target` = `tb_target`.`no_target` 
          LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` 
          LEFT JOIN `tb_program` ON `tb_programkegiatan`.`no_program` = `tb_program`.`no_program` where `tb_laporan_programkegiatan`.`nomor_skpd`='".$nouser."' AND `tb_laporan_programkegiatan`.`no_tahun`='$notahun' GROUP BY `tb_programkegiatan`.`no_program` ORDER BY `tb_programkegiatan`.`no_program` ASC");
          while ($program = mysqli_fetch_array($q_program)) {

            echo '<tr valign="top" href="#">';
            echo "<td class='isi-tabel'><b>".$program[4].".".$program[14]."</b></td>";
            echo "<td class='isi-tabel'><b>".$program[15]."</b></td>";
            echo "<td class='isi-tabel'></td>";
            echo "<td class='isi-tabel'></td>";
            echo "<td class='isi-tabel'></td>";
            echo "</tr>";


            //cari kegiatan dan pengelompokannya
            $q_kegiatan = mysqli_query($koneksi,"SELECT * FROM `tb_laporan_programkegiatan`
            LEFT JOIN `tb_programkegiatan` ON `tb_laporan_programkegiatan`.`id_programkegiatan` = `tb_programkegiatan`.`id_programkegiatan` 
            LEFT JOIN `tb_target` ON `tb_laporan_programkegiatan`.`no_target` = `tb_target`.`no_target` 
            LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` 
            LEFT JOIN `tb_program` ON `tb_programkegiatan`.`no_program` = `tb_program`.`no_program` where `tb_laporan_programkegiatan`.`nomor_skpd`='".$nouser."' AND `tb_laporan_programkegiatan`.`no_tahun`='$notahun' AND `tb_programkegiatan`.`no_program`='".$program[14]."' GROUP BY `tb_programkegiatan`.`id_kegiatan` ORDER BY `tb_laporan_programkegiatan`.`id_programkegiatan` ASC");
            while ($kegiatan = mysqli_fetch_array($q_kegiatan)) {

              //cari target dan pengelompokkannya
              $query_master = "SELECT * FROM `tb_laporan_programkegiatan`
              LEFT JOIN `tb_programkegiatan` ON `tb_laporan_programkegiatan`.`id_programkegiatan` = `tb_programkegiatan`.`id_programkegiatan` 
              LEFT JOIN `tb_target` ON `tb_laporan_programkegiatan`.`no_target` = `tb_target`.`no_target` 
              LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` 
              LEFT JOIN `tb_program` ON `tb_programkegiatan`.`no_program` = `tb_program`.`no_program` where `tb_laporan_programkegiatan`.`nomor_skpd`='".$nouser."' AND `tb_laporan_programkegiatan`.`no_tahun`='$notahun' AND `tb_programkegiatan`.`id_kegiatan`='".$kegiatan[7]."' ORDER BY `tb_programkegiatan`.`no_program` ASC";
              $q_sasaran = mysqli_query($koneksi,$query_master);
              $q_target = mysqli_query($koneksi,$query_master);


              echo '<tr class="pointer-tabel-link" valign="top" href="rka.php?id='.$kegiatan[1].'&skpd='.$kegiatan[4].'">';
              echo "<td class='isi-tabel'>".$kegiatan[4].".".$kegiatan[14].".".$kegiatan[12]."</td>";
              echo "<td class='isi-tabel'>".$kegiatan[13]."</td>";
              echo "<td class='isi-tabel'>";

              while ($rows = mysqli_fetch_array($q_sasaran)) {
                echo '<div class="master">'.$rows[9]."</div>";
              }
              
              echo "</td>";
              echo "<td class='isi-tabel'>";

              while ($rows = mysqli_fetch_array($q_target)) {
                echo '<div class="master">'.$rows[10]."</div>";
              }

              echo "</td>";
              echo "<td class='isi-tabel'>";

              $total = mysqli_query($koneksi,"SELECT `tb_laporan_belanja`.`id_belanja`,`tb_belanja`.`id_belanja`,SUM(`tb_belanja`.`harga_satuan`*`tb_belanja`.`volume`) as totali,`tb_laporan_belanja`.`id_laporan`,`tb_laporan_belanja`.`id_programkegiatan`,`tb_laporan_belanja`.`id_laporan`,`tb_programkegiatan`.`id_programkegiatan`,`tb_programkegiatan`.`id_kegiatan`,`tb_kegiatan`.`id_kegiatan`,`tb_kegiatan`.`no_kegiatan`,`tb_laporan_belanja`.`id_belanja`,`tb_belanja`.`id_belanja`,`tb_belanja`.`volume`,`tb_belanja`.`harga_satuan` FROM tb_laporan_belanja
              LEFT JOIN `tb_programkegiatan` ON `tb_laporan_belanja`.`id_programkegiatan` = `tb_programkegiatan`.`id_programkegiatan` 
              LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja` 
              LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` WHERE `tb_programkegiatan`.`id_kegiatan`='".$kegiatan[11]."'
              AND `tb_laporan_belanja`.`id_programkegiatan`='".$kegiatan[1]."' 
              AND `tb_laporan_belanja`.`nomor_skpd`='$nouser' AND `tb_laporan_belanja`.`no_tahun`='$notahun' ");

              while ($rows = mysqli_fetch_assoc($total)) {
                echo '<div class="master"><span style="float: left">Rp. </span><span style="float: right">'.rupiah($rows['totali'], 2).'</span></div>';
              }

              echo "</td>";

              echo "</tr>";
            }
          }
      }
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