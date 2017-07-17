<?php

//simpan program

if (isset($_POST['simpan_pro'])) {
  $cariprogram = mysqli_query($koneksi,"SELECT * FROM `tb_program` WHERE `no_program`='".@$_POST['noprogram']."'");
  if (mysqli_num_rows($cariprogram) == 0) {
    if ((!$_POST['noprogram']) or (!$_POST['namaprogram'])) {
      echo '<div id="tampil_modal_save"><div id="modal">
            <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
              <p>Data tidak boleh kosong!</p>
            <a href="admin.php?set=1"><button id="okesave">Oke</button></a>
          </div></div>';
    } else {
      $insertprogram = mysqli_query($koneksi,"INSERT INTO `tb_program`(`no_program`, `nama_program`) VALUES ('".$_POST['noprogram']."','".$_POST['namaprogram']."')");
      echo '<div id="tampil_modal_save"><div id="modal">
          <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
            <p>Data Berhasil di Simpan!</p>
          <a href="admin.php?set=1"><button id="okesave">Oke</button></a>
        </div></div>';
    }
    
  } else {
    echo '<div id="tampil_modal_save"><div id="modal">
          <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
            <p>Nomor Program Sudah Ada!</p>
          <a href="admin.php?set=1"><button id="okesave">Oke</button></a>
        </div></div>';
  }
}


//simpan kegiatan
if (isset($_POST['simpan_keg'])) {
  if ($_POST['no_program'] == 'null') {
    echo '<div id="tampil_modal_save"><div id="modal">
            <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
              <p>Pilih Program!</p>
            <a href="admin.php?set=1"><button id="okesave">Oke</button></a>
          </div></div>';
  } else {

//validasi kosong
    if ((!$_POST['namakegiatan']) or (!$_POST['nokegiatan'])) {
      echo '<div id="tampil_modal_save"><div id="modal">
            <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
              <p>Data tidak boleh kosong!</p>
            <a href="admin.php?set=1"><button id="okesave">Oke</button></a>
          </div></div>';
    } else {


      $cari_id_kegiatan = mysqli_query($koneksi,"SELECT * FROM `tb_programkegiatan` LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan`
        WHERE `tb_programkegiatan`.`no_program`='".$_POST['no_program']."' AND `tb_kegiatan`.`no_kegiatan`='".$_POST['nokegiatan']."'");
      if (mysqli_num_rows($cari_id_kegiatan) == 0) {
        $insertkegiatan = mysqli_query($koneksi,"INSERT INTO `tb_kegiatan`(`no_kegiatan`, `nama_kegiatan`) VALUES ('".$_POST['nokegiatan']."','".$_POST['namakegiatan']."')");
        $cari_id_kegiatan = mysqli_query($koneksi,"SELECT * FROM `tb_kegiatan` ORDER BY `tb_kegiatan`.`id_kegiatan` DESC limit 0,1");
        while ($cek = mysqli_fetch_array($cari_id_kegiatan)) {
          $insertprogramkegiatan = mysqli_query($koneksi,"INSERT INTO `tb_programkegiatan`(`no_program`, `id_kegiatan`) VALUES ('".$_POST['no_program']."','".$cek[0]."')");
          echo '<div id="tampil_modal_save"><div id="modal">
            <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
              <p>Data Berhasil di Simpan!</p>
            <a href="?set=1"><button id="okesave">Oke</button></a>
          </div></div>';
        }
      } else {
        echo '<div id="tampil_modal_save"><div id="modal">
          <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
            <p>Nomor Kegiatan Sudah Ada di dalam Program yang anda pilih!</p>
            <a href="admin.php?set=1"><button id="okesave">Oke</button></a>
        </div></div>';
      }
    }
  }
}

//edit kegiatan
if (isset($_POST['update_keg'])) {
  if ($_POST['no_program'] == 'null') {
    echo '<div id="tampil_modal_save"><div id="modal">
            <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
              <p>Pilih Program!</p>
            <a href="admin.php?set=1"><button id="okesave">Oke</button></a>
          </div></div>';
  } else {
  	mysqli_query($koneksi,"UPDATE `tb_programkegiatan` SET `no_program`='".$_POST['no_program']."' WHERE `id_kegiatan`='".$_GET['k']."'");
    $insertkegiatan = mysqli_query($koneksi,"UPDATE `tb_kegiatan` SET `no_kegiatan`='".$_POST['nokegiatan']."',`nama_kegiatan`='".$_POST['namakegiatan']."' WHERE `id_kegiatan`='".$_GET['k']."'");
    echo '<div id="tampil_modal_save"><div id="modal">
      <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
        <p>Data Berhasil di Simpan!</p>
        <a href="?set=1"><button id="okesave">Oke</button></a>
      </div></div>';
    header("location: ?set=1&succed=true");
  }
}

//edit program
if (isset($_POST['update_pro'])) {
  $updateprogram = mysqli_query($koneksi,"UPDATE `tb_program` SET `nama_program`='".$_POST['namaprogram']."' WHERE `no_program`='".$_GET['p']."'");
  header("location: ?set=1&succed=true");
}

//hapus program
if (isset($_POST['hapus_pro'])) {
  $cariprogram_dulu = mysqli_query($koneksi,"SELECT * FROM `tb_programkegiatan` WHERE `no_program`='".$_GET['dp']."'");
  if (mysqli_num_rows($cariprogram_dulu) == 0){
    while ($del = mysqli_fetch_array($cariprogram_dulu)) {

      //hapus target
      $cari_target_di_laporan = mysqli_query($koneksi,"SELECT * FROM tb_laporan_programkegiatan LEFT JOIN `tb_target` 
      ON `tb_laporan_programkegiatan`.`no_target` = `tb_target`.`no_target`  WHERE `tb_laporan_programkegiatan`.`id_programkegiatan`='".$del[0]."'");
      while ($data = mysqli_fetch_array($cari_target_di_laporan)) {
        mysqli_query($koneksi,"DELETE FROM `tb_target` WHERE `no_target`='".$data[2]."'");
      }

      //  hapus belanja
      $cari_belanja = mysqli_query($koneksi,"SELECT * FROM `tb_laporan_belanja`
      LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja`  WHERE `tb_laporan_belanja`.`id_programkegiatan`='".$del[0]."'");
      while ($data = mysqli_fetch_array($cari_belanja)) {
        mysqli_query($koneksi,"DELETE FROM `tb_belanja` WHERE `id_belanja`='".$data[1]."'");
      }

      //hapus_laporan_belanja
      mysqli_query($koneksi,"DELETE FROM `tb_laporan_belanja` WHERE `id_programkegiatan`='".$del[0]."'");

      //hapus_laporan_programkegiatan
      mysqli_query($koneksi,"DELETE FROM `tb_laporan_programkegiatan` WHERE `id_programkegiatan`='".$del[0]."'");

      //hapus program
      mysqli_query($koneksi,"DELETE FROM `tb_program` WHERE `no_program`='".$_GET['dp']."'");

      header("location: ?set=1&del=sukses");
    }
  } else {
    while ($del = mysqli_fetch_array($cariprogram_dulu)) {
      //hapuskegiatan 
      mysqli_query($koneksi,"DELETE FROM `tb_kegiatan` WHERE `id_kegiatan`='".$del[2]."'");
      //hapusprogramkegiatan 
      mysqli_query($koneksi,"DELETE FROM `tb_programkegiatan` WHERE `no_program`='".$_GET['dp']."'");
      //hapusprogram 
      mysqli_query($koneksi,"DELETE FROM `tb_program` WHERE `no_program`='".$_GET['dp']."'");
      //hapus target
      $cari_target_di_laporan = mysqli_query($koneksi,"SELECT * FROM tb_laporan_programkegiatan LEFT JOIN `tb_target` 
      ON `tb_laporan_programkegiatan`.`no_target` = `tb_target`.`no_target`  WHERE `tb_laporan_programkegiatan`.`id_programkegiatan`='".$del[0]."'");
      while ($data = mysqli_fetch_array($cari_target_di_laporan)) {
        mysqli_query($koneksi,"DELETE FROM `tb_target` WHERE `no_target`='".$data[2]."'");
      }
      //  hapus belanja
      $cari_belanja = mysqli_query($koneksi,"SELECT * FROM `tb_laporan_belanja`
      LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja`  WHERE `tb_laporan_belanja`.`id_programkegiatan`='".$del[0]."'");
      while ($data = mysqli_fetch_array($cari_belanja)) {
        mysqli_query($koneksi,"DELETE FROM `tb_belanja` WHERE `id_belanja`='".$data[1]."'");
      }
      //hapus_laporan_programkegiatan 
      mysqli_query($koneksi,"DELETE FROM `tb_laporan_programkegiatan` WHERE `id_programkegiatan`='".$del[0]."'");
      //hapus_laporan_belanjar 
      mysqli_query($koneksi,"DELETE FROM `tb_laporan_belanja` WHERE `id_programkegiatan`='".$del[0]."'");

      header("location: ?set=1&del=sukses");
    }
  }
}

//hapus kegiatan
if (isset($_POST['hapus_keg'])) {
  $carikegiatan_dulu = mysqli_query($koneksi,"SELECT * FROM `tb_programkegiatan` WHERE `id_kegiatan`='".$_GET['dk']."'");
  if (mysqli_num_rows($carikegiatan_dulu) == 0){
    while ($del = mysqli_fetch_array($carikegiatan_dulu)) {

      //hapus target
      $cari_target_di_laporan = mysqli_query($koneksi,"SELECT * FROM tb_laporan_programkegiatan LEFT JOIN `tb_target` 
      ON `tb_laporan_programkegiatan`.`no_target` = `tb_target`.`no_target`  WHERE `tb_laporan_programkegiatan`.`id_programkegiatan`='".$del[0]."'");
      while ($data = mysqli_fetch_array($cari_target_di_laporan)) {
        mysqli_query($koneksi,"DELETE FROM `tb_target` WHERE `no_target`='".$data[2]."'");
      }

      //  hapus belanja
      $cari_belanja = mysqli_query($koneksi,"SELECT * FROM `tb_laporan_belanja`
      LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja`  WHERE `tb_laporan_belanja`.`id_programkegiatan`='".$del[0]."'");
      while ($data = mysqli_fetch_array($cari_belanja)) {
        mysqli_query($koneksi,"DELETE FROM `tb_belanja` WHERE `id_belanja`='".$data[1]."'");
      }

      //hapus_laporan_belanja
      mysqli_query($koneksi,"DELETE FROM `tb_laporan_belanja` WHERE `id_programkegiatan`='".$del[0]."'");

      //hapus_laporan_programkegiatan
      mysqli_query($koneksi,"DELETE FROM `tb_laporan_programkegiatan` WHERE `id_programkegiatan`='".$del[0]."'");

      //hapuskegiatan 
      mysqli_query($koneksi,"DELETE FROM `tb_kegiatan` WHERE `id_kegiatan`='".$del[2]."'");

      header("location: ?set=1&del=sukses");
    }
  } else {
    while ($del = mysqli_fetch_array($carikegiatan_dulu)) {
      //hapuskegiatan 
      mysqli_query($koneksi,"DELETE FROM `tb_kegiatan` WHERE `id_kegiatan`='".$del[2]."'");
      //hapusprogramkegiatan 
      mysqli_query($koneksi,"DELETE FROM `tb_programkegiatan` WHERE `id_kegiatan`='".$_GET['dk']."'");
      //hapus target
      $cari_target_di_laporan = mysqli_query($koneksi,"SELECT * FROM tb_laporan_programkegiatan LEFT JOIN `tb_target` 
      ON `tb_laporan_programkegiatan`.`no_target` = `tb_target`.`no_target`  WHERE `tb_laporan_programkegiatan`.`id_programkegiatan`='".$del[0]."'");
      while ($data = mysqli_fetch_array($cari_target_di_laporan)) {
        mysqli_query($koneksi,"DELETE FROM `tb_target` WHERE `no_target`='".$data[2]."'");
      }
      //  hapus belanja
      $cari_belanja = mysqli_query($koneksi,"SELECT * FROM `tb_laporan_belanja`
      LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja`  WHERE `tb_laporan_belanja`.`id_programkegiatan`='".$del[0]."'");
      while ($data = mysqli_fetch_array($cari_belanja)) {
        mysqli_query($koneksi,"DELETE FROM `tb_belanja` WHERE `id_belanja`='".$data[1]."'");
      }
      //hapus_laporan_programkegiatan 
      mysqli_query($koneksi,"DELETE FROM `tb_laporan_programkegiatan` WHERE `id_programkegiatan`='".$del[0]."'");
      //hapus_laporan_belanja
      mysqli_query($koneksi,"DELETE FROM `tb_laporan_belanja` WHERE `id_programkegiatan`='".$del[0]."'");

      header("location: ?set=1&del=sukses");
    }
  }
}




	if (@$_GET['set']=='1') {
        $q_program = mysqli_query($koneksi,"SELECT * FROM `tb_program` ORDER BY `no_program` ASC");
          
          echo '<h1 class="help" align="center">Program & Kegiatan</h1>';
            echo '<div class="clear" />';
            echo '<a href="#" id="program"><button class="button_pro"><i class="fa fa-plus-square fa-lg"></i> &nbsp;&nbsp;&nbsp;Tambah Program</button></a> <a href="#" id="kegiatan"><button class="button_keg"><i class="fa fa-plus-square fa-lg"></i> &nbsp;&nbsp;&nbsp;Tambah Kegiatan</button></a>';
            echo '<a href="admin.php"><button class="batal_admin"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"></i> &nbsp;&nbsp;&nbsp;Batal</button></a>';
            echo '<div class="clear" />';
             echo '<table class="aktifitas" cellspacing="0" cellpadding="0">
            <tr class="header-tabel">
              <td class="kepala-tabel" width=\'20%\'>Kode</td>
              <td class="kepala-tabel" width="59%">Nama Program dan Kegiatan</td>
              <td class="kepala-tabel" width=\'21%\'>Action</td>
            </tr>';
            while ($data = mysqli_fetch_array($q_program)) {
              $q_master = "SELECT * FROM tb_programkegiatan
              LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` WHERE `tb_programkegiatan`.`no_program`='".$data[0]."' ORDER BY `tb_kegiatan`.`no_kegiatan` ASC";
              $q_k_kegiatan = mysqli_query($koneksi,$q_master);
              $q_kegiatan = mysqli_query($koneksi,$q_master);
              $q_hapus = mysqli_query($koneksi,$q_master);

              echo '<tr valign="top">';
                echo "<td class='isi-tabel'><b>X.XX.XX.".$data[0]."</b></td>";
                echo "<td class='isi-tabel'><b>".$data[1]."</b></td>";
                echo "<td class='isi-tabel'><a href='#' id='tutup_".$data[0]."' style='display: none'><i class='fa fa-chevron-up fa-lg'></i> Tutup </a><a href='#' id='buka_".$data[0]."'><i class='fa fa-chevron-down fa-lg'></i> Buka </a> &nbsp;
                <a href='?set=1&p=".$data[0]."' id='edit_".$data[0]."''><i class='fa fa-pencil fa-lg'></i> Edit</a> &nbsp;
                <a href='?set=1&dp=".$data[0]."' style='color: #ea6153'><i class='fa fa-trash-o fa-lg'></i> Hapus</a></td>";
              echo '</tr>';

              echo '<tr valign="top" id="colap_'.$data[0].'" style="display: none">';
              echo "<td class='isi-tabel'>";
                while ($row = mysqli_fetch_array($q_k_kegiatan)) {
                  echo '<div class="master" style="padding-left: 15px;">X.XX.XX.'.$row[1].'.'.$row[4].'</div>';
                }
                echo "</td>";

                echo "<td class='isi-tabel'>";
                
                while ($row = mysqli_fetch_array($q_kegiatan)) {
                  if ($q_kegiatan == 0) {
                    echo '<p>** Tidak Ada Data **</p>';
                  } else {
                    echo '<div class="master" style="padding-left: 15px;">'.$row[5].'</div>';
                  }
                }

                echo "</td>";
                echo "<td class='isi-tabel'>";
                while ($row = mysqli_fetch_array($q_hapus)) {
                  echo '<div class="master" style="padding-left: 85px;"><a href="?set=1&k='.$row[3].'"><i class="fa fa-pencil fa-lg"></i> Edit</a> &nbsp;&nbsp;
                  <a href="?set=1&dk='.$row[3].'" style="color: #ea6153"><i class="fa fa-trash-o fa-lg"></i> Hapus</a></div>';
                }
                echo"</td>";
              echo "</tr>";
            }
            echo '</table>';
        echo '</div>';

        //modal simpan program
        echo '<div id="tampil_modal_save" class="tampil_modal_program" style="display: none"><div class="modal_save">
          <div class="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Tambah Program</div>';
          echo '<form method="post">
              Nomor Program: <br/><input class="masuk" autocomplete="off" placeholder="Nomor Program" name="noprogram" type="text">
              Nama Program: <br/><input class="masuk" autocomplete="off" placeholder="Nama Program" name="namaprogram" type="text">
              <button class="save" type="submit" name="simpan_pro" style="background:#2980b9;padding: 10px;color: #fff;float: left;"><i class="fa fa-save fa-lg"></i> Simpan</button>
              <a href="#" class="close_pro" style="margin-left: 5px;background:#999;padding: 11px;color: #fff;float: left;"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"></i> Batal</a>
            </form>
        </div>
        </div>';


        //modal simpan kegiatan
        echo '<div id="tampil_modal_save" class="tampil_modal_kegiatan" style="display: none"><div class="modal_save">
          <div class="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Tambah Kegiatan</div>
            <form method="post">Pilih Program: <br />';
              echo '<select name="no_program" class="masuk" style="width:97%">';
          echo '<option name="combo" value="null">Pilih Program</option>';
          $cari_program = mysqli_query($koneksi,"SELECT * FROM `tb_program` ORDER BY `no_program` ASC");
          while ($data = mysqli_fetch_array($cari_program)) {
            echo '<option name="combo" value="'.$data[0].'">'.$data[1].'</option>';
          }
          echo '</select>';
          echo 'Nomor Kegiatan: <br /><input class="masuk" autocomplete="off" placeholder="Nomor Kegiatan" name="nokegiatan" type="text">
              Nama Kegiatan: <br /><input class="masuk" autocomplete="off" placeholder="Nama Kegiatan" name="namakegiatan" type="text">
              <button class="save" type="submit" name="simpan_keg" style="background:#2980b9;padding: 10px;color: #fff;float: left;"><i class="fa fa-save fa-lg"></i> Simpan</button>
              <a href="#" class="close_keg" style="margin-left: 5px;background:#999;padding: 11px;color: #fff;float: left;"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"></i> Batal</a>
            </form>
        </div></div>';
      }

//jika ada set update program
      if (@$_GET['p']) {
        $query_program = mysqli_query($koneksi,"SELECT * FROM `tb_program` WHERE `no_program`='".$_GET['p']."' ORDER BY `no_program` ASC");
        while ($data = mysqli_fetch_array($query_program)) {
          echo '<div id="tampil_modal_save" class="tampil_modal_program"><div class="modal_save">
          <div class="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Edit Program</div>';
          echo '<form method="post">
              Nomor Program: <br/><input class="masuk" autocomplete="off" placeholder="Nomor Program" name="noprogram" type="text" value="'.$data[0].'" disabled>
              Nama Program: <br/><input class="masuk" autocomplete="off" placeholder="Nama Program" name="namaprogram" type="text" value="'.$data[1].'">
              <button class="save" type="submit" name="update_pro" style="background:#2980b9;padding: 10px;color: #fff;float: left;" href="?set=1"><i class="fa fa-save fa-lg"></i> Simpan</button>
              <a href="?set=1" style="margin-left: 5px;background:#999;padding: 11px;color: #fff;float: left;"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"></i> Batal</a>
            </form>
        </div></div>';
        }
      }

//jika ada set update kegiatan
      if (@$_GET['k']) {
      	$query_kegiatan = mysqli_query($koneksi,"SELECT * FROM tb_programkegiatan
		LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan`
		WHERE `tb_programkegiatan`.`id_kegiatan`='".$_GET['k']."'");
      	while ($cek = mysqli_fetch_array($query_kegiatan)) {
          echo '<div id="tampil_modal_save" class="tampil_modal_program"><div class="modal_save">
          <div class="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Edit Kegiatan</div>';
          echo '<form method="post">Pilih Program: <br />';
          echo '<select name="no_program" class="masuk" style="width:97%">';
            echo '<option name="combo" value="null">Pilih Program</option>';
            $cari_program = mysqli_query($koneksi,"SELECT * FROM `tb_program` ORDER BY `no_program` ASC");
            while ($data = mysqli_fetch_array($cari_program)) {
            	if ($cek[1] == $data[0]) {
            		echo '<option name="combo" value="'.$data[0].'" selected>'.$data[1].'</option>';
            	} else {
            		echo '<option name="combo" value="'.$data[0].'">'.$data[1].'</option>';
            	}
            }
            echo '</select>';
            echo 'Nomor Kegiatan: <br /><input class="masuk" autocomplete="off" placeholder="Nomor Kegiatan" name="nokegiatan" type="text" value="'.$cek[4].'">
              Nama Kegiatan: <br /><input class="masuk" autocomplete="off" placeholder="Nama Kegiatan" name="namakegiatan" type="text" value="'.$cek[5].'">
              <button class="save" type="submit" name="update_keg" style="background:#2980b9;padding: 10px;color: #fff;float: left;"><i class="fa fa-save fa-lg"></i> Simpan</button>
              <a href="?set=1" style="margin-left: 5px;background:#999;padding: 11px;color: #fff;float: left;"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"></i> Batal</a>
            </form>
        </div></div>';
    	}
      }

//jika ada set hapus program
      if (@$_GET['dp']) {
          echo '<div id="tampil_modal_save" class="tampil_modal_program"><div class="modal_save">
          <div class="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Hapus Program</div>';
          echo '<p>Menghapus Program dapat menghapus semua data yang berhubungan program.</p><p> Apakah Anda yakin hapus program ini ?</p>';
          echo '<form method="post">
          	  <button class="save" type="submit" name="hapus_pro" style="background:#ea6153;padding: 10px;color: #fff;float: left;"><i class="fa fa-trash-o fa-lg"></i> Hapus</button>
            </form>';
          echo '<a href="?set=1" style="margin-left: 5px;background:#999;padding: 11px;color: #fff;float: left;"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"></i> Batal</a>';
        echo '</div></div>';
      }

//jika ada set hapus kegiatan
      if (@$_GET['dk']) {
          echo '<div id="tampil_modal_save" class="tampil_modal_program"><div class="modal_save">
          <div class="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Hapus Program</div>';
          echo '<p>Menghapus Kegiatan dapat menghapus semua data yang berhubungan kegiatan.</p>
          <p> Apakah Anda yakin hapus kegiatan ini ?</p>';
          echo '<form method="post">
          	  <button class="save" type="submit" name="hapus_keg" style="background:#ea6153;padding: 10px;color: #fff;float: left;"><i class="fa fa-trash-o fa-lg"></i> Hapus</button>
            </form>';
          echo '<a href="?set=1" style="margin-left: 5px;background:#999;padding: 11px;color: #fff;float: left;"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"></i> Batal</a>';
        echo '</div></div>';
      }

//jika sukses edit
       if (@$_GET['succed']=='true') {
        echo '<div id="tampil_modal_save"><div id="modal">
        <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
          <p>Data Berhasil di Ubah!</p>
        <a href="admin.php?set=1"><button id="okesave">Oke</button></a>
      </div></div>';
       }

//jika sukses hapus
       if (@$_GET['del']=='sukses') {
        echo '<div id="tampil_modal_save"><div id="modal">
        <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
          <p>Data Berhasil di Hapus!</p>
        <a href="admin.php?set=1"><button id="okesave">Oke</button></a>
      </div></div>';
       }

?>