<?php
//Simpan SKPD
if (isset($_POST['simpan_skpd'])) {
  $cek_skpd = mysqli_query($koneksi,"SELECT * FROM `tb_skpd` WHERE `nomor_skpd`='".$_POST['noskpd']."'");
  if (mysqli_num_rows($cek_skpd)=='0') {
    $sandi = md5(md5($_POST['sandiskpd']));
    if ((!$_POST['noskpd']) or (!$_POST['namaskpd']) or (!$_POST['sandiskpd']) or (!$_POST['email']) or (!$_POST['alamat']) or (!$_POST['telepon'])) {
      echo '<div id="tampil_modal_save"><div id="modal">
      <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
        <p>Data tidak boleh kosong!</p>
        <a href="?set=2"><button id="okesave">Oke</button></a>
      </div></div>';
    } else {
      mysqli_query($koneksi,"INSERT INTO `tb_skpd`(`nomor_skpd`, `nama_skpd`, `sandi_skpd`, `email`, `alamat`, `telepon`, `fax`, `level`)
      VALUES ('".$_POST['noskpd']."','".$_POST['namaskpd']."','$sandi','".$_POST['email']."','".$_POST['alamat']."','".$_POST['telepon']."','".$_POST['fax']."','user')");
      echo '<div id="tampil_modal_save"><div id="modal">
      <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
        <p>Data Berhasil di Simpan!</p>
        <a href="?set=2"><button id="okesave">Oke</button></a>
      </div></div>';
    }
  } else {
    echo '<div id="tampil_modal_save"><div id="modal">
    <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
      <p>Nomor SKPD Sudah ada!</p>
      <a href="?set=2"><button id="okesave">Oke</button></a>
    </div></div>';
  }
}

//edit SKPD
if (isset($_POST['update_skpd'])) {
  if ((!$_POST['namaskpd']) or (!$_POST['email']) or (!$_POST['alamat']) or (!$_POST['telepon'])) {
    header("location: ?set=2&modal=kosong");
  } else {
    mysqli_query($koneksi,"UPDATE `tb_skpd` SET `nama_skpd`='".$_POST['namaskpd']."',`email`='".$_POST['email']."',`alamat`='".$_POST['alamat']."',`telepon`='".$_POST['telepon']."',`fax`='".$_POST['fax']."' WHERE `nomor_skpd`='".$_GET['es']."'");
    header("location: ?set=2&s=true");
  }
}

//Hapus SKPD
if (isset($_POST['hapus_skpd'])) {
  mysqli_query($koneksi,"DELETE FROM `tb_skpd` WHERE `nomor_skpd`='".$_GET['d']."'");
  header("location: ?set=2&ed=true");
}

//ganti sandi SKPD
  if (isset($_POST['simpan_sandi'])) {
    if ((!$_POST['newpass']) or (!$_POST['connewpas'])){
      header("location: ?set=2&modal=kosong");
    } else {
      $newpass=md5(md5($_POST['newpass']));
      $connewpas=md5(md5($_POST['connewpas']));
      if ($newpass==$connewpas) {
        $query_insert=mysqli_query($koneksi,"UPDATE `tb_skpd` SET `sandi_skpd`='$newpass' WHERE `nomor_skpd`='".$_POST['user']."'");
        header("location: ?set=2&s=true");
      } else {
        header("location: ?set=2&modal=gagal");
      }
    }
  }

if (@$_GET['set']=='2') {
  $aktifitas = mysqli_query($koneksi,"SELECT * FROM `tb_skpd` WHERE `level`='user' order by `nomor_skpd` ASC");
  echo '<center><h1>Semua SKPD</h1></center>';
  echo '<p>Daftar Satuan Kerja Perangkat Daerah di Sistem Prioritas Plafon Anggaran Sementara dan Rencana Kerja Anggaran</p><div class="clear" />';
  echo '<a href="#" id="skpd"><button class="button_pro"><i class="fa fa-plus-square fa-lg"></i> &nbsp;&nbsp;&nbsp;Tambah SKPD</button></a>';
  echo '<a href="?set=2&modal=sandi"><button class="button_keg"><i class="fa fa-key fa-lg"></i> &nbsp;&nbsp;&nbsp;Ganti Sandi</button></a>';
  echo '<a href="admin.php"><button class="batal_admin"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"></i> &nbsp;&nbsp;&nbsp;Batal</button></a>';
  echo '<div class="clear" />';
  echo '<table class="aktifitas" cellspacing="0" cellpadding="0" >
    <tr class="header-tabel" align="center">
      <td class="kepala-tabel" width="10%">Nomor SKPD</td>
      <td class="kepala-tabel" width="35%">Nama SKPD</td>
      <td class="kepala-tabel" width="10%">Email</td>
      <td class="kepala-tabel" width="20%">Alamat</td>
      <td class="kepala-tabel" width="10%">Telepon</td>
      <td class="kepala-tabel" width="15%">Action</td>
    </tr>';
  
  while ($data = mysqli_fetch_array($aktifitas)) {
    echo '<tr class="pointer-tabel">';
      echo "<td class='isi-tabel'>".$data[0]."</td>";
      echo "<td class='isi-tabel'>".$data[1]."</td>";
      echo "<td class='isi-tabel'>".$data[3]."</td>";
      echo "<td class='isi-tabel'>".$data[4]."</td>";
      echo "<td class='isi-tabel'>".$data[5]."</td>";
      echo "<td class='isi-tabel' style='padding: 5px'><a href='?set=2&es=".$data[0]."'><i class='fa fa-pencil fa-lg'></i> Edit</a> &nbsp;&nbsp;
      <a href='?set=2&d=".$data[0]."' style='color: #ea6153'><i class='fa fa-trash-o fa-lg'></i> Hapus</a></td>";
    echo "</tr>";            
  }
  echo '</table>';

//modal simpan SKPD
  echo '<div id="tampil_modal_save" class="tampil_modal_SKPD" style="display: none; padding-top: 10px"><div class="modal_save">
    <div class="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Tambah Satuan Kerja Perangkat Daerah</div>';
      echo '<form method="post">
      Nomor SKPD: <br/><input class="masuk" autocomplete="off" placeholder="Nomor SKPD" name="noskpd" type="text"><br />
      Nama SKPD: <br/><input class="masuk" autocomplete="off" placeholder="Nama Satuan Kerja Perangkat Daerah" name="namaskpd" type="text"><br />
      Sandi SKPD: <br/><input class="masuk" autocomplete="off" placeholder="Kata Sandi" name="sandiskpd" type="password"><br />
      Email: <br/><input class="masuk" autocomplete="off" placeholder="Email@domain.com" name="email" type="text"><br />
      Alamat: <br/><input class="masuk" autocomplete="off" placeholder="Alamat" name="alamat" type="text"><br />
      Telepon: <br/><input class="masuk" autocomplete="off" placeholder="Telepon (08xxxx)" name="telepon" type="text"><br />
      Fax: <br/><input class="masuk" autocomplete="off" placeholder="Fax (123xxxx)" name="fax" type="text"><br />
      <button class="save" type="submit" name="simpan_skpd" style="background:#2980b9;padding: 10px;color: #fff;float: left;" href="?set=1"><i class="fa fa-save fa-lg"></i> Simpan</button>
      <a href="?set=2" style="margin-left: 5px;background:#999;padding: 11px;color: #fff;float: left;"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"></i> Batal</a>
    </form>
    </div></div>';
}

//modal ganti sandi SKPD
if (@$_GET['modal']=='sandi') {
  echo '<div id="tampil_modal_save" class="tampil_modal_sandi" padding-top: 5em"><div class="modal_save">
    <div class="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Ganti Sandi Satuan Kerja Perangkat Daerah</div>';
      echo '<form method="post">';/* Koding Menampilkan Program */
          echo 'Satuan Kerja Perangkat Daerah:<br />';
            echo '<select name="user">';
              echo '<option name="combo" value="null">-- Pilih SKPD --</option>';
                $user = mysqli_query($koneksi,"SELECT * FROM `tb_skpd` WHERE `level`='user' ORDER BY `tb_skpd`.`nomor_skpd` ASC ");
                while ($rows = mysqli_fetch_array($user)) {
                  echo "<option name=\"combo\" value=\"".$rows['0']."\">".$rows['0'].' '.$rows['1']."</option>";
                }
          echo '</select>';

          echo'<b>Kata Sandi Baru:</b>
          <input class="masuk" type="password" autocomplete="off" placeholder="Kata Sandi Baru" name="newpass"><br/>';

          echo'<b>Ulangi Kata Sandi Baru:</b>
          <input class="masuk" type="password" autocomplete="off" placeholder="Ulangi Kata Sandi Baru" name="connewpas"><br/>';
      echo '<button class="save" type="submit" name="simpan_sandi" style="background:#2980b9;padding: 10px;color: #fff;float: left;" href="?set=1"><i class="fa fa-save fa-lg"></i> Simpan</button>
      <a href="?set=2" style="margin-left: 5px;background:#999;padding: 11px;color: #fff;float: left;"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"></i> Batal</a>
    </form>
    </div></div>';
}

//modal Edit
if (@$_GET['es']) {
  $query_program = mysqli_query($koneksi,"SELECT * FROM `tb_skpd` WHERE `nomor_skpd`='".$_GET['es']."' ORDER BY `nomor_skpd` ASC");
  while ($data = mysqli_fetch_array($query_program)) {
    echo '<div id="tampil_modal_save" style="padding-top: 5em"><div class="modal_save">
    <div class="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Edit Satuan Kerja Perangkat Daerah</div>';
    echo '<form method="post">
      Nomor SKPD: <br/><input class="masuk" autocomplete="off" placeholder="Nomor SKPD" name="noskpd" type="text" value="'.$data[0].'" disabled><br />
      Nama SKPD: <br/><input class="masuk" autocomplete="off" placeholder="Nama Satuan Kerja Perangkat Daerah" name="namaskpd" type="text" value="'.$data[1].'"><br />
      Email: <br/><input class="masuk" autocomplete="off" placeholder="Email@domain.com" name="email" type="email" value="'.$data[3].'"><br />
      Alamat: <br/><input class="masuk" autocomplete="off" placeholder="Alamat" name="alamat" type="text" value="'.$data[4].'"><br />
      Telepon: <br/><input class="masuk" autocomplete="off" placeholder="Telepon (08xxxx)" name="telepon" type="text" value="'.$data[5].'"><br />
      Fax: <br/><input class="masuk" autocomplete="off" placeholder="Fax (123xxxx)" name="fax" type="text" value="'.$data[6].'"><br />
      <button class="save" type="submit" name="update_skpd" style="background:#2980b9;padding: 10px;color: #fff;float: left;" href="?set=1"><i class="fa fa-save fa-lg"></i> Simpan</button>
      <a href="?set=2" style="margin-left: 5px;background:#999;padding: 11px;color: #fff;float: left;"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"></i> Batal</a>
    </form>
    </div></div>';
  }
}

//jika sukses edit
if (@$_GET['s']=='true') {
  echo '<div id="tampil_modal_save"><div id="modal">
    <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
      <p>Data Berhasil di Ubah!</p>
      <a href="?set=2"><button id="okesave">Oke</button></a>
    </div></div>';
}

//Konfirmasi Hapus
if (@$_GET['d']) {
  echo '<div id="tampil_modal_save"><div id="modal">
    <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
      <p>Apakah Anda yakin ingin menghapus data ini ?</p>
      <form method="post">
        <button class="save" type="submit" name="hapus_skpd" style="background:#ea6153;padding: 10px;color: #fff;float: left;"><i class="fa fa-trash-o fa-lg"></i> Hapus</button>
      </form>
      <a href="?set=2" style="margin-left: 5px;background:#999;padding: 11px;color: #fff;float: left;"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"></i> Batal</a>
    </div></div>';
}

//jika sukses Hapus
if (@$_GET['ed']=='true') {
  echo '<div id="tampil_modal_save"><div id="modal">
    <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
      <p>Data Berhasil di Hapus!</p>
      <a href="?set=2"><button id="okesave">Oke</button></a>
    </div></div>';
}

//jika gagal sandi
if (@$_GET['modal']=='gagal') {
  echo '<div id="tampil_modal_save"><div id="modal">
          <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Error</div>
            <p>Konfirmasi kata sandi tidak cocok !</p>
          <a href="?set=2"><button id="okesave">Oke</button></a>
        </div></div>';
}

//jika inputan sandi kosong
if (@$_GET['modal']=='kosong') {
  echo '<div id="tampil_modal_save"><div id="modal">
      <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
        <p>Data tidak boleh kosong!</p>
        <a href="?set=2"><button id="okesave">Oke</button></a>
      </div></div>';
}