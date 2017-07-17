<?php

//panggil DB

include 'system/db.php';
if ($level=='user') {
  header("location:../error.php");     // dan alihkan ke index.php
}

if(isset($_POST['simpan_ppas'])){
  if ((!$_GET['skpd']) or (!$_GET['p']) or (!$_GET['k']) or (!($_GET['skpd'])=='null') or (!($_GET['p'])=='null') or (!($_GET['k'])=='null')) {
    echo '<div id="tampil_modal_save"><div id="modal">
          <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Error</div>
            <p>Data SKPD, program, dan kegiatan harus di pilih!</p>
          <a href="input_ppas.php"><button id="okesave">Oke</button></a>
        </div></div>';
  } else {
    if ((!$_POST['bl']) or (!$_POST['btl'])) {
      echo '<div id="tampil_modal_save"><div id="modal">
      <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
        <p>Data tidak boleh kosong!</p>
        <a href="input_ppas.php"><button id="okesave">Oke</button></a>
      </div></div>';
    } else {
      $cari = mysqli_query($koneksi,"select * from tb_programkegiatan where no_program='".$_GET['p']."' and id_kegiatan='".$_GET['k']."'");
      while ($rows = mysqli_fetch_array($cari)) {
        mysqli_query($koneksi,"INSERT INTO `tb_ppas`(`nomor_skpd`, `id_programkegiatan`, `belanja_tidak_langsung`, `belanja_langsung`, `no_tahun`) VALUES ('".$_GET['skpd']."','".$rows[0]."','".$_POST['btl']."','".$_POST['bl']."','$notahun')");
        echo '<div id="tampil_modal_save"><div id="modal">
      <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
        <p>Data Berhasil di Simpan!</p>
        <a href="?skpd='.$_GET['skpd'].'&p='.$_GET['p'].'&k='.$_GET['k'].'"><button id="okesave">Oke</button></a>
      </div></div>';
      }
    }
  }
}

//update
if(isset($_POST['update_ppas'])){
  if ((!$_GET['skpd']) or (!$_GET['p']) or (!$_GET['k']) or (!($_GET['skpd'])=='null') or (!($_GET['p'])=='null') or (!($_GET['k'])=='null')) {
    echo '<div id="tampil_modal_save"><div id="modal">
          <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Error</div>
            <p>Data SKPD, program, dan kegiatan harus di pilih!</p>
          <a href="input_ppas.php"><button id="okesave">Oke</button></a>
        </div></div>';
  } else {
    if ((!$_POST['bl']) or (!$_POST['btl'])) {
      echo '<div id="tampil_modal_save"><div id="modal">
      <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
        <p>Data tidak boleh kosong!</p>
        <a href="input_ppas.php"><button id="okesave">Oke</button></a>
      </div></div>';
    } else {
      $cari = mysqli_query($koneksi,"select * from tb_programkegiatan where no_program='".$_GET['p']."' and id_kegiatan='".$_GET['k']."'");
      while ($rows = mysqli_fetch_array($cari)) {
        mysqli_query($koneksi,"UPDATE `tb_ppas` SET `belanja_tidak_langsung`='".$_POST['btl']."',`belanja_langsung`='".$_POST['bl']."' WHERE `id_ppas`='".$_POST['id']."'");
        echo '<div id="tampil_modal_save"><div id="modal">
      <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
        <p>Data Berhasil di Simpan!</p>
        <a href="?skpd='.$_GET['skpd'].'&p='.$_GET['p'].'&k='.$_GET['k'].'"><button id="okesave">Oke</button></a>
      </div></div>';
      }
    }
  }
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
    <div class="judul"><i class="fa fa-pencil fa-lg"></i> Input Data PPAS<?php echo $lastlogin ?></div>
    <div class="isi">
      <?php
        echo '<form method="GET">';
        /* Koding Menampilkan SKPD */
        echo '<table><tr><td width="20%">';
        echo 'Nama SKPD</td><td width="80%">:';
            echo '<select name="skpd" class="input_data" onchange="this.form.submit()">';
              echo '<option name="combo" value="null">-- Pilih SKPD --</option>';
                $skpd = mysqli_query($koneksi,"SELECT * FROM `tb_skpd` ORDER BY `tb_skpd`.`nomor_skpd` ASC");
                
                while ($rows = mysqli_fetch_array($skpd)) {
                if ($_GET['skpd']==$rows['0']) {
                    echo "<option name=\"combo\" value=\"".$rows['0']."\" selected>".$rows['0'].' '.$rows['1']."</option>";
                  } else {  
                    echo "<option name=\"combo\" value=\"".$rows['0']."\">".$rows['0'].' '.$rows['1']."</option>";
                  }
                }
          echo '</select></td></tr>';


        /* Koding Menampilkan Program */
        echo '<tr><td width="20%">Nama Program</td><td width="80%">:';
            echo '<select name="p" class="input_data" onchange="this.form.submit()">';
              echo '<option name="combo" value="null">-- Pilih Program --</option>';
                $program = mysqli_query($koneksi,"select * from tb_program order by nama_program ASC");
                
                while ($rows = mysqli_fetch_array($program)) {
                if ($_GET['p']==$rows['0']) {
                    echo "<option name=\"combo\" value=\"".$rows['0']."\" selected>".$rows['0'].' '.$rows['1']."</option>";
                  } else {  
                    echo "<option name=\"combo\" value=\"".$rows['0']."\">".$rows['0'].' '.$rows['1']."</option>";
                  }
                }
          echo '</select></td></tr>';

          /* Koding Menampilkan Kegiatan */
          echo '<tr><td width="20%">Nama Kegiatan</td><td width="80%">:';
            echo '<select name="k" class="input_data" onchange="this.form.submit()">';
              echo '<option name="combo" value="null">-- Pilih Kegiatan --</option>';
                $kegiatan = mysqli_query($koneksi,"SELECT * FROM tb_programkegiatan
                  LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan`  where no_program='".$_GET['p'].
                  "'");
                while ($rows = mysqli_fetch_array($kegiatan)) {
                if ($_GET['k']==$rows['0']) {
                    echo "<option name=\"combo\" value=\"".$rows['0']."\" selected>".$_GET['p'].'.'.$rows['4'].' '.$rows['5']."</option>";
                  } else {  
                    echo "<option name=\"combo\" value=\"".$rows['0']."\">".$_GET['p'].'.'.$rows['4'].' '.$rows['5']."</option>";
                  }
                }
          echo '</select></td></tr>';
        echo '</form>';

        $cari_pk = mysqli_query($koneksi,"select * from tb_programkegiatan where no_program='".@$_GET['p']."' and id_kegiatan='".@$_GET['k']."'");
        while ($data = mysqli_fetch_array($cari_pk)) {
          $cari_data = mysqli_query($koneksi,"SELECT * FROM `tb_ppas` WHERE `id_programkegiatan`='".$data[0]."' AND `nomor_skpd`='".$_GET['skpd']."' AND `no_tahun`='$notahun'");
          if (mysqli_num_rows($cari_data)==0) {
            echo '<form id="id_form" method="post">';
            // Pembuatan Dana PPAS
            echo '<tr><td width="20%">Belanja Langsung</td><td width="80%">:
            <input class="input_data" onkeyup="validAngka(this)" autocomplete="off" placeholder="Dana Kegiatan" name="bl" type="text">
            </td></tr>
            <tr><td width="20%">Belanja Tidak Langsung</td><td width="80%">:
            <input class="input_data" onkeyup="validAngka(this)" autocomplete="off" placeholder="Dana Kegiatan" name="btl" type="text">
            </td></tr>
            </table>';
            //simpan dana PPAS
            echo '<br /><button class="save" type="submit" name="simpan_ppas" style="float: left"><i class="fa fa-save fa-lg"></i> Simpan</button>
            <a href="index.php" class="button_batal" style="margin-top: 0; padding-bottom: 12px; margin-left: 2px; float: left;"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);
      -moz-transform: rotate(45deg);
      -ms-transform: rotate(45deg);
      -o-transform: rotate(45deg);
      transform: rotate(45deg);"></i> Batal</a><div class="clear"></div>';
            echo '</form>';
          } else {
            while ($row = mysqli_fetch_array($cari_data)) {
              echo '<form id="id_form" method="post">';
              // Pembuatan Dana PPAS
              echo '<tr><td width="20%">Belanja Langsung</td><td width="80%">:
              <input class="input_data" onkeyup="validAngka(this)" autocomplete="off" placeholder="Dana Kegiatan" name="bl" type="text" Value="'.$row[4].'">
              </td></tr>
              <tr><td width="20%">Belanja Tidak Langsung</td><td width="80%">:
              <input class="input_data" onkeyup="validAngka(this)" autocomplete="off" placeholder="Dana Kegiatan" name="btl" type="text"  Value="'.$row[3].'">
              </td></tr>
              <input class="input_data" onkeyup="validAngka(this)" autocomplete="off" placeholder="Dana Kegiatan" name="id" type="hidden"  Value="'.$row[0].'">
              </table>';
              //simpan dana PPAS
              echo '<br /><button class="save" type="submit" name="update_ppas" style="float: left"><i class="fa fa-save fa-lg"></i> Simpan</button>
              <a href="index.php" class="button_batal" style="margin-top: 0; padding-bottom: 12px; margin-left: 2px; float: left;"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);
        -moz-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        -o-transform: rotate(45deg);
        transform: rotate(45deg);"></i> Batal</a><div class="clear"></div>';
              echo '</form>';
            }
          }
        }
        if (((!@$_GET['p']) OR (!@$_GET['k'])) OR ((@$_GET['p']=='null') OR (@$_GET['k']=='null'))){
          echo '<form id="id_form" method="post">';
            // Pembuatan Dana PPAS
            echo '<tr><td width="20%">Belanja Langsung</td><td width="80%">:
            <input class="input_data" onkeyup="validAngka(this)" autocomplete="off" placeholder="Dana Kegiatan" name="bl" type="text" disabled>
            </td></tr>
            <tr><td width="20%">Belanja Tidak Langsung</td><td width="80%">:
            <input class="input_data" onkeyup="validAngka(this)" autocomplete="off" placeholder="Dana Kegiatan" name="btl" type="text" disabled>
            </td></tr>
            </table>';
            //simpan dana PPAS
            echo '<br /><button class="save" type="submit" name="simpan_ppas" style="float: left"><i class="fa fa-save fa-lg"></i> Simpan</button>
            <a href="index.php" class="button_batal" style="margin-top: 0; padding-bottom: 12px; margin-left: 2px; float: left;"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);
      -moz-transform: rotate(45deg);
      -ms-transform: rotate(45deg);
      -o-transform: rotate(45deg);
      transform: rotate(45deg);"></i> Batal</a><div class="clear"></div>';
            echo '</form>';
        }
        echo '<p><span style="color: #999;">Catatan: Anda Harus memilih skpd, nama program, dan kegiatan agar bisa menginput data dana yang akan di pakai <br/>Pastikan nama skpd, nama program, dan kegiatan sesuai dengan data yang anda masukan.</span><br/>Data anda bisa lihat di lihat data > pagu dana</p>';
      ?>
    </div>
    </div>
  </section>

<?php
//panggil Footer
include 'system/footer.php';

?>
  </body>
</html>
