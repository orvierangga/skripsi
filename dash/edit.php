<?php

//panggil DB
error_reporting(0);
include 'system/db.php';
if ($level=='admin') {
  header("location:../error.php");     // dan alihkan ke index.php
}
if(isset($_POST['submit'])){
  if (!@$_GET['id']) {
    echo '<div id="tampil_modal_save"><div id="modal">
          <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Error</div>
            <p>Id program dan kegiatan tidak ditemukan. Coba lagi!</p>
          <a href="master_data.php"><button id="okesave">Oke</button></a>
        </div></div>';
  } else {
    $idtarget = $_POST['id_target'];
    $sasaran = $_POST['sasaran'];
    $target = $_POST['target'];
    $N = count($idtarget);
    for($i=0; $i < $N; $i++){
      $result = mysqli_query($koneksi,"UPDATE `tb_target` SET `nama_target`='$sasaran[$i]',`satuan`='$target[$i]' WHERE `no_target`='$idtarget[$i]'");  
    }

    //rka
    $idbelanja = $_POST['id_belanja'];
    $norek = $_POST['norek'];
    $uraian = $_POST['uraian'];
    $volume = $_POST['volume'];
    $satuan = $_POST['satuan'];
    $danasatuan = $_POST['danasatuan'];
    $N_B = count($idbelanja);
    for($i=0; $i < $N_B; $i++){
      $result = mysqli_query($koneksi,"UPDATE `tb_belanja` SET `kode_belanja`='$norek[$i]',`uraian`='$uraian[$i]',`volume`='$volume[$i]',`satuan`='$satuan[$i]',`harga_satuan`='$danasatuan[$i]' WHERE `id_belanja`='$idbelanja[$i]'");  
    }

//Indikator
   foreach (@$_POST['rows'] as $key => $count){
      $sasaran = $_POST['sasaran_'.$count];
      $target = $_POST['target_'.$count];

      $insert_target = mysqli_query($koneksi,"INSERT INTO `tb_target`(`nama_target`, `satuan`) VALUES ('$sasaran','$target')");
      $cari_target = mysqli_query($koneksi,"SELECT * FROM `tb_target` ORDER BY `tb_target`.`no_target` DESC limit 0,1");
      while ($cari_rows = mysqli_fetch_array($cari_target)) {
          $query_2 = "INSERT INTO `tb_laporan_programkegiatan`(`id_programkegiatan`, `no_target`, `no_tahun`, `nomor_skpd`) VALUES ('".$_GET['id']."','".$cari_rows[0]."','$notahun','$nouser')";
          mysqli_query($koneksi,$query_2) or die(mysql_error());
      }

    }

    //Belanja Langsung
    foreach (@$_POST['rows_2'] as $key => $hitung ){
      //rka
      $norek = $_POST['norek_'.$hitung];
      $uraian = $_POST['uraian_'.$hitung];
      $volume = $_POST['volume_'.$hitung];
      $satuan = $_POST['satuan_'.$hitung];
      $danasatuan = $_POST['danasatuan_'.$hitung];
      $validasi_bl = mysqli_query($koneksi,"SELECT * FROM `tb_laporan_belanja`
      LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja` WHERE `tb_laporan_belanja`.`id_ket`='1' AND `tb_laporan_belanja`.`nomor_skpd`='$nouser' AND `tb_laporan_belanja`.`id_programkegiatan`='".$_GET['id']."' AND `tb_belanja`.`kode_belanja`='".$norek."'");
      if (mysqli_num_rows($validasi_bl) <= 0) {
        $insert_rka = mysqli_query($koneksi,"INSERT INTO `tb_belanja`(`kode_belanja`, `uraian`, `volume`, `satuan`, `harga_satuan`) VALUES ('$norek','$uraian','$volume','$satuan','$danasatuan')");
        $cari_belanja = mysqli_query($koneksi,"SELECT * FROM `tb_belanja` ORDER BY `tb_belanja`.`id_belanja` DESC LIMIT 0,1");
        while ($data = mysqli_fetch_array($cari_belanja)) {
          $query_1 = "INSERT INTO `tb_laporan_belanja`(`id_laporan`, `id_belanja`, `id_ket`, `id_programkegiatan`, `nomor_skpd`, `no_tahun`) VALUES ('','".$data[0]."','1','".$_GET['id']."','$nouser','$notahun')";
          mysqli_query($koneksi,$query_1) or die(mysql_error());
        }
      } else {
        echo '<div id="tampil_modal_save"><div id="modal">
            <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
            <p>Nomor kode belanja langsung untuk program dan kegiatan ini sudah ada!.</p>
            <a href="rka.php?id='.$_GET['id'].'&skpd='.$_GET['skpd'].'"><button id="okesave">Oke</button></a>
            </div></div>';
      }
      
    }

    
    //Belanja tidak Langsung
    foreach (@$_POST['rows_3'] as $key => $total ){
      //rka
      $t_norek = $_POST['t_norek_'.$total];
      $t_uraian = $_POST['t_uraian_'.$total];
      $t_volume = $_POST['t_volume_'.$total];
      $t_satuan = $_POST['t_satuan_'.$total];
      $t_danasatuan = $_POST['t_danasatuan_'.$total];
      $validasi_btl = mysqli_query($koneksi,"SELECT * FROM `tb_laporan_belanja`
      LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja` WHERE `tb_laporan_belanja`.`id_ket`='2' AND `tb_laporan_belanja`.`nomor_skpd`='$nouser' AND `tb_laporan_belanja`.`id_programkegiatan`='".$_GET['id']."' AND `tb_belanja`.`kode_belanja`='".$t_norek."'");
      if (mysqli_num_rows($validasi_btl) <= 0) {
        $insert_rka = mysqli_query($koneksi,"INSERT INTO `tb_belanja`(`kode_belanja`, `uraian`, `volume`, `satuan`, `harga_satuan`) VALUES ('$t_norek','$t_uraian','$t_volume','$t_satuan','$t_danasatuan')");
        $cari_belanja = mysqli_query($koneksi,"SELECT * FROM `tb_belanja` ORDER BY `tb_belanja`.`id_belanja` DESC LIMIT 0,1");
        while ($data = mysqli_fetch_array($cari_belanja)) {
          $query_2 = "INSERT INTO `tb_laporan_belanja`(`id_laporan`, `id_belanja`, `id_ket`, `id_programkegiatan`, `nomor_skpd`, `no_tahun`) VALUES ('','".$data[0]."','2','".$_GET['id']."','$nouser','$notahun')";
          mysqli_query($koneksi,$query_2) or die(mysql_error());
        }
      } else {
        echo '<div id="tampil_modal_save"><div id="modal">
            <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
            <p>Nomor kode belanja tidak langsung untuk program dan kegiatan ini sudah ada!.</p>
            <a href="rka.php?id='.$_GET['id'].'&skpd='.$_GET['skpd'].'"><button id="okesave">Oke</button></a>
            </div></div>';
      }
    }
    
    #header('location: rka.php?id='.$_GET['id'].'&skpd='.$_GET['skpd'].'');
  } 
}

//hapus target
if (@$_GET['deltar']){
  echo '<div id="tampil_modal_save"><div id="modal">
            <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
            <p>Nomor kode belanja tidak langsung untuk program dan kegiatan ini sudah ada!.</p>
            <a href="rka.php?id='.$_GET['id'].'&skpd='.$_GET['skpd'].'"><button id="okesave">Oke</button></a>
            </div></div>';
  mysqli_query($koneksi,"DELETE FROM `tb_laporan_programkegiatan` WHERE `no_target`='".$_GET['deltar']."' AND `nomor_skpd`='".$_GET['skpd']."' AND `no_tahun`='$notahun'");
  $validasi = mysqli_query($koneksi,"SELECT * FROM `tb_laporan_belanja` WHERE `id_programkegiatan`='".$_GET['idpro']."'");
  while ($data = mysqli_fetch_array($validasi)) {
    mysqli_query($koneksi,"DELETE FROM `tb_belanja` WHERE `id_belanja`='".$data[1]."'");
  }
  mysqli_query($koneksi,"DELETE FROM `tb_laporan_belanja` WHERE `id_programkegiatan`='".$_GET['idpro']."' AND `nomor_skpd`='".$_GET['skpd']."' AND `no_tahun`='$notahun'");
  mysqli_query($koneksi,"DELETE FROM `tb_target` WHERE `no_target`='".$_GET['deltar']."'");
  header('location: lihat_data.php');
}

//hapus target
if (@$_GET['delbel']){
  mysqli_query($koneksi,"DELETE FROM `tb_laporan_belanja` WHERE `id_belanja`='".$_GET['delbel']."' AND `nomor_skpd`='".$_GET['skpd']."' AND `no_tahun`='$notahun'");
  mysqli_query($koneksi,"DELETE FROM `tb_belanja` WHERE `id_belanja`='".$_GET['delbel']."'");
  header('location: rka.php?id='.$_GET['id'].'&skpd='.$_GET['skpd'].'');
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
    <div class="judul"><i class="fa fa-pencil fa-lg"></i> Edit Data <?php echo $lastlogin ?></div>
    <div class="isi">
      <?php
        
        $q_ket = mysqli_query($koneksi,"SELECT `tb_programkegiatan`.*,`tb_skpd`.`nomor_skpd`,`tb_skpd`.`nama_skpd`,`tb_kegiatan`.*,`tb_program`.`nama_program`,`tb_program`.*,`tb_laporan_belanja`.`id_laporan`,`tb_laporan_belanja`.`id_programkegiatan`,`tb_laporan_belanja`.`nomor_skpd` FROM tb_laporan_belanja
        LEFT JOIN `tb_programkegiatan` ON `tb_laporan_belanja`.`id_programkegiatan` = `tb_programkegiatan`.`id_programkegiatan` 
        LEFT JOIN `tb_skpd` ON `tb_laporan_belanja`.`nomor_skpd` = `tb_skpd`.`nomor_skpd` 
        LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` 
        LEFT JOIN `tb_program` ON `tb_programkegiatan`.`no_program` = `tb_program`.`no_program` WHERE `tb_laporan_belanja`.`id_programkegiatan`='".$_GET['id']."' AND `tb_laporan_belanja`.`nomor_skpd`='".$nouser."' GROUP BY `tb_laporan_belanja`.`id_programkegiatan`");
        while ($ket = mysql_fetch_assoc($q_ket)) {
          echo '<table class="aktifitas" cellspacing="0" cellpadding="0" width="100%" >';
            echo '<tr valign="top">';
            echo '<td style="padding-bottom: 10px" width="15%">Nama Program </td><td width="85%">: '.$ket['nomor_skpd'].'.'.$ket['no_program'].' '.$ket['nama_program'].'</td>';
            echo '</tr><tr valign="top">';
            echo '<td style="padding-bottom: 10px" width="15%">Nama Kegiatan </td><td width="85%">: '.$ket['nomor_skpd'].'.'.$ket['no_program'].'.'.$ket['no_kegiatan'].' '.$ket['nama_kegiatan'].'</td>';
            echo '</tr>';
          echo '</table>';
        }


        echo '<form id="id_form" method="post">';
        
        // Pembuatan tabel PPAS
        echo '<table class="aktifitas" cellspacing="0" cellpadding="0" width="100%" >';
        echo '<tr class="header-tabel" align="center">';
        echo '<td class="kepala-tabel" width="55%">Tolak Ukur Kinerja Keluaran</td>';
        echo '<td class="kepala-tabel" width="35%">Target</td>';
        echo '<td class="kepala-tabel" width="10%">Action</td>';
        echo '</tr>';
        //sini masuk addnya

        $edittarget=$_POST['id_target'];
        $N = count($edittarget);
        for($i=0; $i < $N; $i++) {
          $result = mysqli_query($koneksi,"SELECT `tb_target`.*,`tb_laporan_programkegiatan`.* FROM tb_target
          LEFT JOIN `tb_laporan_programkegiatan` ON `tb_target`.`no_target` = `tb_laporan_programkegiatan`.`no_target` 
          WHERE `tb_target`.`no_target`='$edittarget[$i]' ORDER BY `tb_target`.`no_target` ASC");
          while($row = mysqli_fetch_array($result)) {
            echo '<tr class="records">';
            echo '<input class="masuk" name="id_target[]" value="'.$row[0].'" type="hidden">';
            echo '<td><input class="masuk" autocomplete="off" placeholder="Sasaran Kegiatan" name="sasaran[]" type="text" value="'.$row[1].'"></td>';
            echo '<td><input class="masuk" autocomplete="off" placeholder="Target Kegiatan" name="target[]" type="text" value="'.$row[2].'"></td>';
            echo '<td><a href="?idpro='.$row[4].'&skpd='.$_GET['skpd'].'&deltar='.$row[0].'" style="color: #ea6153"><i class="fa fa-minus-square fa-lg"></i> Hapus</a></td>';
            echo '</tr>';
          }
        }

        echo '<tbody id="container">

        </tbody>';
        echo '</table>';
        echo '<a href="#" class="button_pro" id="add_btn" name="add_btn" style="float: right"><i class="fa fa-plus-square fa-lg"></i> Indikator</a>';
        echo '<div class="clear"></div>';
        // end tabel PPAS


        // Pembuatan tabel RKA
        
        echo '<br><br><br><table class="aktifitas" cellspacing="0" cellpadding="0" width="100%" >';
        echo '<tr class="header-tabel">';
        echo "<td rowspan=\"2\" class=\"kepala-tabel\" width=\"10%\">No Rek.</td>";
        echo "<td rowspan=\"2\" class=\"kepala-tabel\" width=\"35%\" align='center'>Urain</td>";
        echo '<td colspan="3" width=\'35%\' class="kepala-tabel" style="border-bottom: 1px solid #ddd" align="center">RINCIAN PERHITUNGAN</td>';
        echo "<td rowspan=\"2\" class=\"kepala-tabel\" width=\"10%\"  align='center'>Action</td>";
        echo '</tr>';
        echo '<tr class="header-tabel">';
        echo "<td class=\"kepala-tabel\" width=\"10%\" align=\"center\">Volume</td>";
        echo "<td class=\"kepala-tabel\" width=\"10%\" align=\"center\">Satuan</td>";
        echo "<td class=\"kepala-tabel\" width=\"10%\" align=\"center\">Harga Satuan</td>";
        echo "</tr>";

        //sini masuk belanja tidak langsung
        echo '<tr style="background: #ddd;">';
        echo '<td colspan="6" width=\'35%\' class="kepala-tabel" style="border-bottom: 1px solid #ddd" align="center">BELANJA TIDAK LANGSUNG</td>';
        echo '</tr>';

        //pendapatan id_belanja
        $edittable=$_POST['id_belanja'];


        $N = count($edittable);
        for($i=0; $i < $N; $i++) {
          $result = mysqli_query($koneksi,"SELECT * FROM tb_laporan_belanja
          LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja` WHERE `tb_belanja`.`id_belanja`='$edittable[$i]' AND `tb_laporan_belanja`.`id_ket`='2' ORDER BY `tb_belanja`.`kode_belanja` ASC");
          while($row = mysqli_fetch_array($result)) {
            echo '<tr>';
            echo '<input class="masuk" name="id_belanja[]" value="'.$row[6].'" type="hidden">';
            echo '<td><input class="masuk" autocomplete="off" placeholder="No. Rek" name="norek[]" type="text" value="'.$row[7].'"></td>';
            echo '<td><input class="masuk" autocomplete="off" placeholder="Uraian" name="uraian[]" type="text" value="'.$row[8].'"></td>';
            echo '<td><input class="masuk" onkeyup="validAngka(this)" autocomplete="off" placeholder="Volume" name="volume[]" type="text" value="'.$row[9].'"></td>';
            echo '<td><input class="masuk" autocomplete="off" placeholder="Satuan" name="satuan[]" type="text" value="'.$row[10].'"></td>';
            echo '<td><input class="masuk" onkeyup="validAngka(this)" autocomplete="off" placeholder="Dana Satuan" name="danasatuan[]" type="text" value="'.$row[11].'"></td>';
            echo '<td><a class="remove_item_2" href="?delbel='.$row[1].'&id='.$_GET['id'].'&skpd='.$_GET['skpd'].'" style="color: #ea6153"><i class="fa fa-minus-square fa-lg"></i> Hapus</a></td>';
            echo '</tr>';
          }
        }

        echo '<tbody id="container_3">
        </tbody>';

        echo '<td><br /></td>';
        echo '</tr>';
        //sini masuk belanja langsung
        echo '<tr style="background: #ddd;">';
        echo '<td colspan="6" width=\'35%\' class="kepala-tabel" style="border-bottom: 1px solid #ddd" align="center">BELANJA LANGSUNG</td>';
        echo '</tr>';

        for($i=0; $i < $N; $i++) {
          $result = mysqli_query($koneksi,"SELECT * FROM tb_laporan_belanja
          LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja` WHERE `tb_belanja`.`id_belanja`='$edittable[$i]' AND `tb_laporan_belanja`.`id_ket`='1' ORDER BY `tb_belanja`.`kode_belanja` ASC");
          while($row = mysqli_fetch_array($result)) {
            echo '<tr>';
            echo '<input class="masuk" name="id_belanja[]" value="'.$row[6].'" type="hidden">';
            echo '<td><input class="masuk" autocomplete="off" placeholder="No. Rek" name="norek[]" type="text" value="'.$row[7].'"></td>';
            echo '<td><input class="masuk" autocomplete="off" placeholder="Uraian" name="uraian[]" type="text" value="'.$row[8].'"></td>';
            echo '<td><input class="masuk" onkeyup="validAngka(this)" autocomplete="off" placeholder="Volume" name="volume[]" type="text" value="'.$row[9].'"></td>';
            echo '<td><input class="masuk" autocomplete="off" placeholder="Satuan" name="satuan[]" type="text" value="'.$row[10].'"></td>';
            echo '<td><input class="masuk" onkeyup="validAngka(this)" autocomplete="off" placeholder="Dana Satuan" name="danasatuan[]" type="text" value="'.$row[11].'"></td>';
            echo '<td><a class="remove_item_2" href="?delbel='.$row[1].'&id='.$_GET['id'].'&skpd='.$_GET['skpd'].'" style="color: #ea6153" onclick="return confirm(\'Hapus data ini?\')"><i class="fa fa-minus-square fa-lg"></i> Hapus</a></td>';
            echo '</tr>';
          }
        }
        echo '<tbody id="container_2">
        </tbody>';

        echo '<tr>';
        echo '</table>';
        
        echo '<div style="float: right"><a href="#" class="button_pro" id="tambah_btn" name="tambah_btn"><i class="fa fa-plus-square fa-lg"></i> Belanja Langsung</a> <a href="#" class="button_keg" id="tambah_button" name="tambah_button"><i class="fa fa-plus-square fa-lg"></i> Belanja Tidak Langsung</a></div><div class="clear"></div>';
        //simpan PPAS dan RKAnya
        echo '<br /><button class="save" type="submit" name="submit" style="float: left"><i class="fa fa-save fa-lg"></i> Simpan</button>
         <a href="rka.php?id='.$_GET['id'].'&skpd='.$_GET['skpd'].'" class="button_batal" style="margin-top: 0; padding-bottom: 12px; margin-left: 2px; float: left;"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -o-transform: rotate(45deg);
  transform: rotate(45deg);"></i> Batal</a><div class="clear"></div>';
        echo '</form>';
        echo '<p><span style="color: #999;">Catatan: Pastikan nama program dan kegiatan sesuai dengan data yang anda masukan.</span></p>'
      ?>
    </div>
    </div>
  </section>

<?php
//panggil Footer
include 'system/footer.php';

?>

<script type="text/javascript">
      $(document).ready(function() {
            var count = 0;
            var hitung = 0;
            var total = 0;
            $("#add_btn").click(function(){
                    count += 1;
                $('#container').append(
                             '<tr class="records">'
                         + '<td><input class="masuk" autocomplete="off" placeholder="Sasaran Kegiatan" id="sasaran_' + count + '" name="sasaran_' + count + '" type="text"></td>'
                         + '<td><input class="masuk" autocomplete="off" placeholder="Target Kegiatan" id="target_' + count + '" name="target_' + count + '" type="text"></td>'
                         + '<td><a class="remove_item" href="#" style="color: #ea6153"><i class="fa fa-minus-square fa-lg"></i> Hapus</a>'
                         + '<input id="rows_' + count + '" name="rows[]" value="'+ count +'" type="hidden"></td></tr>'
                    );
                });
 
                $( document ).on( "click", "a.remove_item", function (ev) {
                if (ev.type == 'click') {
                $(this).parents(".records").fadeOut();
                        $(this).parents(".records").remove();
            }
            });

                //Belanja Langsung
            $("#tambah_btn").click(function(){
                    hitung += 1;
                $('#container_2').append(
                             '<tr class="records_2">'
                         + '<td><input class="masuk" autocomplete="off" placeholder="No. Rek" id="norek_' + hitung + '" name="norek_' + hitung + '" type="text"></td>'
                         + '<td><input class="masuk" autocomplete="off" placeholder="Uraian" id="uraian_' + hitung + '" name="uraian_' + hitung + '" type="text"></td>'
                         + '<td><input class="masuk" onkeyup="validAngka(this)" autocomplete="off" placeholder="Volume" id="volume_' + hitung + '" name="volume_' + hitung + '" type="text"></td>'
                         + '<td><input class="masuk" autocomplete="off" placeholder="Satuan" id="satuan_' + hitung + '" name="satuan_' + hitung + '" type="text"></td>'
                         + '<td><input class="masuk" onkeyup="validAngka(this)" autocomplete="off" placeholder="Dana Satuan" id="danasatuan_' + hitung + '" name="danasatuan_' + hitung + '" type="text"></td>'
                         + '<td><a class="remove_item_2" href="#" style="color: #ea6153"><i class="fa fa-minus-square fa-lg"></i> Hapus</a>'
                         + '<input id="rows_2_' + hitung + '" name="rows_2[]" value="'+ hitung +'" type="hidden"></td></tr>'
                    );
                });
 
                $( document ).on( "click", "a.remove_item_2", function (ev) {
                if (ev.type == 'click') {
                $(this).parents(".records_2").fadeOut();
                        $(this).parents(".records_2").remove();
            }
            });

                //belanja tidak langsung
            $("#tambah_button").click(function(){
                    total += 1;
                $('#container_3').append(
                             '<tr class="records_3">'
                         + '<td><input class="masuk" autocomplete="off" placeholder="No. Rek" id="t_norek_' + total + '" name="t_norek_' + total + '" type="text"></td>'
                         + '<td><input class="masuk" autocomplete="off" placeholder="Uraian" id="t_uraian_' + total + '" name="t_uraian_' + total + '" type="text"></td>'
                         + '<td><input class="masuk" onkeyup="validAngka(this)" autocomplete="off" placeholder="Volume" id="t_volume_' + total + '" name="t_volume_' + total + '" type="text"></td>'
                         + '<td><input class="masuk" autocomplete="off" placeholder="Satuan" id="t_satuan_' + total + '" name="t_satuan_' + total + '" type="text"></td>'
                         + '<td><input class="masuk" onkeyup="validAngka(this)" autocomplete="off" placeholder="Dana Satuan" id="t_danasatuan_' + total + '" name="t_danasatuan_' + total + '" type="text"></td>'
                         + '<td><a class="remove_item_3" href="#" style="color: #ea6153"><i class="fa fa-minus-square fa-lg"></i> Hapus</a>'
                         + '<input id="rows_3_' + total + '" name="rows_3[]" value="'+ total +'" type="hidden"></td></tr>'
                    );
                });
 
                $( document ).on( "click", "a.remove_item_3", function (ev) {
                if (ev.type == 'click') {
                $(this).parents(".records_3").fadeOut();
                        $(this).parents(".records_3").remove();
            }
            });

        });
    </script>

  </body>
</html>
