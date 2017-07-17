<?php
//Simpan Tahun
if (isset($_POST['simpan_tahun'])) {
  $cek_tahun = mysqli_query($koneksi,"SELECT * FROM `tb_tahun` WHERE `tahun`='".$_POST['tahun']."'");
  if (mysqli_num_rows($cek_tahun)=='0') {
    if ((!$_POST['tahun'])) {
      echo '<div id="tampil_modal_save"><div id="modal">
      <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
        <p>Data tidak boleh kosong!</p>
        <a href="?set=3"><button id="okesave">Oke</button></a>
      </div></div>';
    } else {
      mysqli_query($koneksi,"INSERT INTO `tb_tahun`(`tahun`) VALUES ('".$_POST['tahun']."')");
      echo '<div id="tampil_modal_save"><div id="modal">
      <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
        <p>Data Berhasil di Simpan!</p>
        <a href="?set=3"><button id="okesave">Oke</button></a>
      </div></div>';
    }
  } else {
    echo '<div id="tampil_modal_save"><div id="modal">
    <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
      <p>Tahun Kerja Sudah ada!</p>
      <a href="?set=3"><button id="okesave">Oke</button></a>
    </div></div>';
  }
}

//edit SKPD
if (isset($_POST['update_tahun'])) {
  mysqli_query($koneksi,"UPDATE `tb_tahun` SET `tahun`='".$_POST['tahun']."' WHERE `no_tahun`='".$_GET['es']."'");
  header("location: ?set=3");
}

//Hapus SKPD
if (isset($_POST['hapus_tahun'])) {
  $cek = mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM `tb_tahun` ORDER BY `tahun` ASC"));
  if ($cek == 1) {
    echo '<div id="tampil_modal_save" style="z-index: 99;"><div id="modal">
    <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
      <p>Gagal menghapus tahun!</p>
      <p>Alasan : Tahun hanya satu</p>
      <a href="?set=3"><button id="okesave">Oke</button></a>
    </div></div>';
  } else {
    mysqli_query($koneksi,"DELETE FROM `tb_tahun` WHERE `no_tahun`='".$_GET['dt']."'");
  }
}


if (@$_GET['set']=='3') {
  $aktifitas = mysqli_query($koneksi,"SELECT * FROM `tb_tahun` ORDER BY `tb_tahun`.`tahun` ASC ");
  echo '<center><h1>Semua Tahun</h1></center>';
  echo '<p>Daftar Tahun di Sistem Prioritas Plafon Anggaran Sementara dan Rencana Kerja Anggaran</p><div class="clear" />';
  echo '<a href="#" id="skpd"><button class="button_pro"><i class="fa fa-plus-square fa-lg"></i> &nbsp;&nbsp;&nbsp;Tambah Tahun</button></a>';
  echo '<a href="admin.php"><button class="batal_admin"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"></i> &nbsp;&nbsp;&nbsp;Batal</button></a>';
  echo '<div class="clear" />';
  echo '<table class="aktifitas" cellspacing="0" cellpadding="0" >
    <tr class="header-tabel" align="center">
      <td class="kepala-tabel" width="85%">Tahun Tersimpan</td>
      <td class="kepala-tabel" width="15%">Action</td>
    </tr>';
  
  while ($data = mysqli_fetch_array($aktifitas)) {
    echo '<tr class="pointer-tabel">';
      echo "<td class='isi-tabel'>".$data[1]."</td>";
      echo "<td class='isi-tabel' style='padding: 5px'><a href='?set=3&es=".$data[0]."'><i class='fa fa-pencil fa-lg'></i> Edit</a> &nbsp;&nbsp;
      <a href='?set=3&dt=".$data[0]."' style='color: #ea6153'><i class='fa fa-trash-o fa-lg'></i> Hapus</a></td>";
    echo "</tr>";            
  }
  echo '</table>';

//modal simpan SKPD
  echo '<div id="tampil_modal_save" class="tampil_modal_SKPD" style="display: none; padding-top: 5em"><div class="modal_save">
    <div class="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Tambah Tahun</div>';
      echo '<form method="post">
      Tahun: <br/><input class="masuk" autocomplete="off" placeholder="Tahun" name="tahun" type="text"><br />
      <button class="save" type="submit" name="simpan_tahun" style="background:#2980b9;padding: 10px;color: #fff;float: left;" href="?set=1"><i class="fa fa-save fa-lg"></i> Simpan</button>
      <a href="?set=3" style="margin-left: 5px;background:#999;padding: 11px;color: #fff;float: left;"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"></i> Batal</a>
    </form>
    </div></div>';
}

//modal Edit
if (@$_GET['es']) {
  $query_program = mysqli_query($koneksi,"SELECT * FROM `tb_tahun` WHERE `no_tahun`='".$_GET['es']."'");
  while ($data = mysqli_fetch_array($query_program)) {
    echo '<div id="tampil_modal_save" style="padding-top: 5em"><div class="modal_save">
    <div class="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Edit Satuan Kerja Perangkat Daerah</div>';
    echo '<form method="post">
      Tahun Kerja: <br/><input class="masuk" autocomplete="off" placeholder="Tahun Kerja" name="tahun" type="text" value="'.$data[1].'"><br />
      <button class="save" type="submit" name="update_tahun" style="background:#2980b9;padding: 10px;color: #fff;float: left;"><i class="fa fa-save fa-lg"></i> Simpan</button>
      <a href="?set=3" style="margin-left: 5px;background:#999;padding: 11px;color: #fff;float: left;"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"></i> Batal</a>
    </form>
    </div></div>';
  }
}

//modal Hapus
if (@$_GET['dt']) {
  $query_program = mysqli_query($koneksi,"SELECT * FROM `tb_tahun` WHERE `no_tahun`='".$_GET['dt']."'");
  while ($data = mysqli_fetch_array($query_program)) {
  echo '<div id="tampil_modal_save"><div id="modal">
    <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
      <p>Apakah Anda yakin ingin menghapus tahun '.$data[1].' ini ?</p>
      <form method="post">
        <button class="save" type="submit" name="hapus_tahun" style="background:#ea6153;padding: 10px;color: #fff;float: left;"><i class="fa fa-trash-o fa-lg"></i> Hapus</button>
      </form>
      <a href="?set=3" style="margin-left: 5px;background:#999;padding: 11px;color: #fff;float: left;"><i class="fa fa-plus fa-lg" style="  -webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);-ms-transform: rotate(45deg);-o-transform: rotate(45deg);transform: rotate(45deg);"></i> Batal</a>
    </div></div>';
  }
}

?>