<head>
<link href="../css/fonts.css" rel="stylesheet">
<style type="text/css">
  .header-tabel {
    background-color: #000;
    color: #fff;
  }
  .isi-tabel {
    padding: 5px;
  }
  .kepala-tabel {
    padding: 5px;
  }
  table [boder] {
    border: 1px solid #000;
  }
  table tr {
    border: 1px solid #000;
  }
  table[border="1"] tr td {
    border: 0;
    border-left: 1px solid #000;
    border-top: 1px solid #000;
  }
  body {
    padding: 0;
    margin: 0;
  }
</style>
</head>
<body onload="javascript:window.print()">
<br />
<br />
<br />
<br />
<br />
<?php
include 'system/db.php';

  function rupiah($nilai, $pecahan = 0) {
    return number_format($nilai, $pecahan, ',', '.');
  }

if (@$_GET['print']=='rka'){

    //keterangan Atas
    echo '<table class="aktifitas" cellspacing="0" cellpadding="0" width="100%" border="1"><tr>
    <td rowspan="2" width="60px" height="75px" align="center" valign="middle"><img src="../css/logo.png" /></td>';
    echo '<td valign="top" align="center"><b>RENCANA KERJA DAN ANGGARAN<br />SATUAN KERJA PERANGKAT DAERAH</b></td></tr>';
    echo '<tr><td valign="top" align="center"><font size="2px"><b>PEMERINTAH KOTA BANJARBARU</b><br />Tahun Anggaran : '.$tahun.'</font></td></tr></table>';
    $q_ket = mysqli_query($koneksi,"SELECT `tb_programkegiatan`.*,`tb_skpd`.`nomor_skpd`,`tb_skpd`.`nama_skpd`,`tb_kegiatan`.*,`tb_program`.`nama_program`,`tb_program`.*,`tb_laporan_belanja`.`id_laporan`,`tb_laporan_belanja`.`id_programkegiatan`,`tb_laporan_belanja`.`nomor_skpd` FROM tb_laporan_belanja
    LEFT JOIN `tb_programkegiatan` ON `tb_laporan_belanja`.`id_programkegiatan` = `tb_programkegiatan`.`id_programkegiatan` 
    LEFT JOIN `tb_skpd` ON `tb_laporan_belanja`.`nomor_skpd` = `tb_skpd`.`nomor_skpd` 
    LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` 
    LEFT JOIN `tb_program` ON `tb_programkegiatan`.`no_program` = `tb_program`.`no_program` WHERE `tb_laporan_belanja`.`id_programkegiatan`='".$_GET['id']."' AND `tb_laporan_belanja`.`nomor_skpd`='".$_GET['skpd']."' GROUP BY `tb_laporan_belanja`.`id_programkegiatan`");
    while ($ket = mysqli_fetch_assoc($q_ket)) {
      echo '<table class="atas" cellspacing="0" cellpadding="0" width="100%" border="1">';
        echo '<tr valign="middle">';
        echo '<td style="padding: 5px"><span style="width: 150px; float: left">Nama SKPD </span><span style="width: 150px; float: left">: '.$ket['nomor_skpd'].'</span><span style="width: 50%; float: left">'.$ket['nama_skpd'].'</span><br/>';
        echo '<span style="width: 150px; float: left">Nama Program </span><span style="width: 150px; float: left">: '.$ket['nomor_skpd'].'.'.$ket['no_program'].'</span><span style="width: 50%; float: left">'.$ket['nama_program'].'</span><br/>';
        echo '<span style="width: 150px; float: left">Nama Kegiatan </span><span style="width: 150px; float: left">: '.$ket['nomor_skpd'].'.'.$ket['no_program'].'.'.$ket['no_kegiatan'].'</span><span style="width: 50%; float: left">'.$ket['nama_kegiatan'].'</span><br/>';
        echo '</td></tr>';
      echo '</table>';
    }

//isian data Keterangan Keluaran Dana
    $ppas = "SELECT * FROM `tb_laporan_programkegiatan`
    LEFT JOIN `tb_programkegiatan` ON `tb_laporan_programkegiatan`.`id_programkegiatan` = `tb_programkegiatan`.`id_programkegiatan` 
    LEFT JOIN `tb_target` ON `tb_laporan_programkegiatan`.`no_target` = `tb_target`.`no_target` 
    LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` 
    LEFT JOIN `tb_program` ON `tb_programkegiatan`.`no_program` = `tb_program`.`no_program` where `tb_laporan_programkegiatan`.`nomor_skpd`='".$_GET['skpd']."' AND `tb_laporan_programkegiatan`.`no_tahun`='$notahun' AND `tb_programkegiatan`.`id_kegiatan`='".$_GET['id']."' ORDER BY `tb_programkegiatan`.`no_program` ASC";
    $sasaran = mysqli_query($koneksi,$ppas);
    $target = mysqli_query($koneksi,$ppas);
      echo '<table class="aktifitas" cellspacing="0" cellpadding="0" width="100%" border="1">';
        echo '<tr>';
        echo '<td colspan="3" style="padding: 5px" align="center"><b>INDIKATOR DAN TOLAK UKUR KINERJA</b></td>';
        echo '</tr>';
        echo '<tr class="header-tabel">';
        echo "<td class=\"kepala-tabel\" width=\"10%\">INDIKATOR</td>";
        echo "<td class=\"kepala-tabel\" width=\"70%\"  align='center'>TOLAK UKUR KINERJA</td>";
        echo "<td class=\"kepala-tabel\" width=\"20%\"  align='center'>TARGET KINERJA</td>";
        echo '</tr>';
        echo '<tr valign="top">';
        echo '<td class="isi-tabel" style="padding-bottom: 10px"><b>KELUARAN</b></td>';
        echo '<td class="isi-tabel">';
        while ($rows = mysqli_fetch_array($sasaran)) {
          echo $rows[9]."<br />";
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
        echo '<td colspan="3" style="padding: 5px">Kelompok Sasaran Kegiatan : Seluruh Kota Banjarbaru</td>';
        echo '</tr><tr>';
        echo '<td colspan="3" style="padding: 5px" align="center"><b>RINCIAN ANGGARAN BELANJA MENURUT PROGRAM DAN PER KEGIATAN SATUAN KERJA PERANGAT DAERAH</b></td>';
        echo '</tr>';
      echo '</table>';


//isian RKA
    echo '<table class="aktifitas" cellspacing="0" cellpadding="0" width="100%" border="1">';
        echo '<tr class="header-tabel">';
        echo "<td rowspan=\"2\" class=\"kepala-tabel\" width=\"10%\">No Rek.</td>";
        echo "<td rowspan=\"2\" class=\"kepala-tabel\" width=\"30%\" align='center'>Urain</td>";
        echo '<td colspan="3" width=\'30%\' class="kepala-tabel" align="center">RINCIAN PERHITUNGAN</td>';
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
          echo "<td class=\"isi-tabel\"><span style=\"float: left\">Rp. </span><span style=\"float: right\">".rupiah($row['harga_satuan'])."</span></td>";
          echo "<td class=\"isi-tabel\"><span style=\"float: left\">Rp. </span><span style=\"float: right\">".rupiah($row['volume']*$row['harga_satuan'], 2)."</span></td>";
          echo '<input name="id_belanja[]" value="'.$row['id_belanja'].'" type="hidden">';
        echo "</tr>";
      }
    }
    echo "</table>";

}

if (@$_GET['print']=='bl'){

    //keterangan Atas
    echo '<table class="aktifitas" cellspacing="0" cellpadding="0" width="100%" border="1"><tr>
    <td rowspan="2" width="60px" height="75px" align="center" valign="middle"><img src="../css/logo.png" /></td>';
    echo '<td valign="top" align="center"><b>RENCANA KERJA DAN ANGGARAN<br />SATUAN KERJA PERANGKAT DAERAH</b></td></tr>';
    echo '<tr><td valign="top" align="center"><font size="2px"><b>PEMERINTAH KOTA BANJARBARU</b><br />Tahun Anggaran : '.$tahun.'</font></td></tr></table>';
    $q_ket = mysqli_query($koneksi,"SELECT `tb_programkegiatan`.*,`tb_skpd`.`nomor_skpd`,`tb_skpd`.`nama_skpd`,`tb_kegiatan`.*,`tb_program`.`nama_program`,`tb_program`.*,`tb_laporan_belanja`.`id_laporan`,`tb_laporan_belanja`.`id_programkegiatan`,`tb_laporan_belanja`.`nomor_skpd` FROM tb_laporan_belanja
    LEFT JOIN `tb_programkegiatan` ON `tb_laporan_belanja`.`id_programkegiatan` = `tb_programkegiatan`.`id_programkegiatan` 
    LEFT JOIN `tb_skpd` ON `tb_laporan_belanja`.`nomor_skpd` = `tb_skpd`.`nomor_skpd` 
    LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` 
    LEFT JOIN `tb_program` ON `tb_programkegiatan`.`no_program` = `tb_program`.`no_program` WHERE `tb_laporan_belanja`.`id_programkegiatan`='".$_GET['id']."' AND `tb_laporan_belanja`.`nomor_skpd`='".$_GET['skpd']."' GROUP BY `tb_laporan_belanja`.`id_programkegiatan`");
    while ($ket = mysqli_fetch_assoc($q_ket)) {
      echo '<table class="atas" cellspacing="0" cellpadding="0" width="100%" border="1">';
        echo '<tr valign="middle">';
        echo '<td style="padding: 5px"><span style="width: 150px; float: left">Nama SKPD </span><span style="width: 150px; float: left">: '.$ket['nomor_skpd'].'</span><span style="width: 50%; float: left">'.$ket['nama_skpd'].'</span><br/>';
        echo '<span style="width: 150px; float: left">Nama Program </span><span style="width: 150px; float: left">: '.$ket['nomor_skpd'].'.'.$ket['no_program'].'</span><span style="width: 50%; float: left">'.$ket['nama_program'].'</span><br/>';
        echo '<span style="width: 150px; float: left">Nama Kegiatan </span><span style="width: 150px; float: left">: '.$ket['nomor_skpd'].'.'.$ket['no_program'].'.'.$ket['no_kegiatan'].'</span><span style="width: 50%; float: left">'.$ket['nama_kegiatan'].'</span><br/>';
        echo '</td></tr>';
      echo '</table>';
    }

//isian data Keterangan Keluaran Dana
    $ppas = "SELECT * FROM `tb_laporan_programkegiatan`
    LEFT JOIN `tb_programkegiatan` ON `tb_laporan_programkegiatan`.`id_programkegiatan` = `tb_programkegiatan`.`id_programkegiatan` 
    LEFT JOIN `tb_target` ON `tb_laporan_programkegiatan`.`no_target` = `tb_target`.`no_target` 
    LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` 
    LEFT JOIN `tb_program` ON `tb_programkegiatan`.`no_program` = `tb_program`.`no_program` where `tb_laporan_programkegiatan`.`nomor_skpd`='".$_GET['skpd']."' AND `tb_laporan_programkegiatan`.`no_tahun`='$notahun' AND `tb_programkegiatan`.`id_kegiatan`='".$_GET['id']."' ORDER BY `tb_programkegiatan`.`no_program` ASC";
    $sasaran = mysqli_query($koneksi,$ppas);
    $target = mysqli_query($koneksi,$ppas);
      echo '<table class="aktifitas" cellspacing="0" cellpadding="0" width="100%" border="1">';
        echo '<tr>';
        echo '<td colspan="3" style="padding: 5px" align="center"><b>INDIKATOR DAN TOLAK UKUR KINERJA</b></td>';
        echo '</tr>';
        echo '<tr class="header-tabel">';
        echo "<td class=\"kepala-tabel\" width=\"10%\">INDIKATOR</td>";
        echo "<td class=\"kepala-tabel\" width=\"70%\"  align='center'>TOLAK UKUR KINERJA</td>";
        echo "<td class=\"kepala-tabel\" width=\"20%\"  align='center'>TARGET KINERJA</td>";
        echo '</tr>';
        echo '<tr valign="top">';
        echo '<td class="isi-tabel" style="padding-bottom: 10px"><b>KELUARAN</b></td>';
        echo '<td class="isi-tabel">';
        while ($rows = mysqli_fetch_array($sasaran)) {
          echo $rows[9]."<br />";
        }
        echo '</td>';

        echo '<td class="isi-tabel">';
        while ($rows = mysqli_fetch_array($target)) {
          echo $rows[10]."<br />";
        }
        echo '</td>';

        echo '</tr><tr valign="top">';
        echo '<td class="isi-tabel" style="padding-bottom: 10px"><b>MASUKAN</b></td><td class="isi-tabel">Jumlah Dana</td><td class="isi-tabel">';

        $total = mysqli_query($koneksi,"SELECT `tb_laporan_belanja`.`id_belanja`,`tb_belanja`.`id_belanja`,`tb_laporan_belanja`.`id_laporan`, SUM(`tb_belanja`.`harga_satuan`*`tb_belanja`.`volume`) AS totali FROM `tb_laporan_belanja`
      LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja` WHERE `tb_laporan_belanja`.`id_ket`='1' AND `tb_laporan_belanja`.`id_programkegiatan`='".$_GET['id']."' 
       AND `tb_laporan_belanja`.`nomor_skpd`='".$_GET['skpd']."' AND `tb_laporan_belanja`.`no_tahun`='$notahun' ");

        while ($rows = mysqli_fetch_assoc($total)) {
          echo 'Rp. '.rupiah($rows['totali'], 2);
        }

        echo '</td>';
        echo '</tr><tr>';
        echo '<td colspan="3" style="padding: 5px">Kelompok Sasaran Kegiatan : Seluruh Kota Banjarbaru</td>';
        echo '</tr><tr>';
        echo '<td colspan="3" style="padding: 5px" align="center"><b>RINCIAN ANGGARAN BELANJA MENURUT PROGRAM DAN PER KEGIATAN SATUAN KERJA PERANGAT DAERAH</b></td>';
        echo '</tr>';
      echo '</table>';


//isian RKA
    echo '<table class="aktifitas" cellspacing="0" cellpadding="0" width="100%" border="1">';
        echo '<tr class="header-tabel">';
        echo "<td rowspan=\"2\" class=\"kepala-tabel\" width=\"10%\">No Rek.</td>";
        echo "<td rowspan=\"2\" class=\"kepala-tabel\" width=\"30%\" align='center'>Urain</td>";
        echo '<td colspan="3" width=\'30%\' class="kepala-tabel" align="center">RINCIAN PERHITUNGAN</td>';
        echo "<td rowspan=\"2\" class=\"kepala-tabel\" width=\"20%\"  align='center'>Jumlah</td>";
        echo '</tr>';
        echo '<tr class="header-tabel">';
        echo "<td class=\"kepala-tabel\" width=\"10%\" align=\"center\">Volume</td>";
        echo "<td class=\"kepala-tabel\" width=\"5%\" align=\"center\">Satuan</td>";
        echo "<td class=\"kepala-tabel\" width=\"15%\" align=\"center\">Harga Satuan</td>";
        echo "</tr>";
    $q_rka=mysqli_query($koneksi,"SELECT * FROM tb_laporan_belanja
    LEFT JOIN `tb_ket_belanja` ON `tb_laporan_belanja`.`id_ket` = `tb_ket_belanja`.`id_ket` 
    LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja` WHERE `tb_laporan_belanja`.`id_programkegiatan`='".$_GET['id']."' AND `tb_laporan_belanja`.`nomor_skpd`='".$_GET['skpd']."' AND `tb_laporan_belanja`.`no_tahun`='$notahun' AND `tb_ket_belanja`.`id_ket`='1' GROUP BY `tb_ket_belanja`.`id_ket` ORDER BY `tb_ket_belanja`.`id_ket` DESC");
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
          echo "<td class=\"isi-tabel\"><span style=\"float: left\">Rp. </span><span style=\"float: right\">".rupiah($row['harga_satuan'])."</span></td>";
          echo "<td class=\"isi-tabel\"><span style=\"float: left\">Rp. </span><span style=\"float: right\">".rupiah($row['volume']*$row['harga_satuan'], 2)."</span></td>";
          echo '<input name="id_belanja[]" value="'.$row['id_belanja'].'" type="hidden">';
        echo "</tr>";
      }
    }
    echo "</table>";

}


if (@$_GET['print']=='btl'){

    //keterangan Atas
    echo '<table class="aktifitas" cellspacing="0" cellpadding="0" width="100%" border="1"><tr>
    <td rowspan="2" width="60px" height="75px" align="center" valign="middle"><img src="../css/logo.png" /></td>';
    echo '<td valign="top" align="center"><b>RENCANA KERJA DAN ANGGARAN<br />SATUAN KERJA PERANGKAT DAERAH</b></td></tr>';
    echo '<tr><td valign="top" align="center"><font size="2px"><b>PEMERINTAH KOTA BANJARBARU</b><br />Tahun Anggaran : '.$tahun.'</font></td></tr></table>';
    $q_ket = mysqli_query($koneksi,"SELECT `tb_programkegiatan`.*,`tb_skpd`.`nomor_skpd`,`tb_skpd`.`nama_skpd`,`tb_kegiatan`.*,`tb_program`.`nama_program`,`tb_program`.*,`tb_laporan_belanja`.`id_laporan`,`tb_laporan_belanja`.`id_programkegiatan`,`tb_laporan_belanja`.`nomor_skpd` FROM tb_laporan_belanja
    LEFT JOIN `tb_programkegiatan` ON `tb_laporan_belanja`.`id_programkegiatan` = `tb_programkegiatan`.`id_programkegiatan` 
    LEFT JOIN `tb_skpd` ON `tb_laporan_belanja`.`nomor_skpd` = `tb_skpd`.`nomor_skpd` 
    LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` 
    LEFT JOIN `tb_program` ON `tb_programkegiatan`.`no_program` = `tb_program`.`no_program` WHERE `tb_laporan_belanja`.`id_programkegiatan`='".$_GET['id']."' AND `tb_laporan_belanja`.`nomor_skpd`='".$_GET['skpd']."' GROUP BY `tb_laporan_belanja`.`id_programkegiatan`");
    while ($ket = mysqli_fetch_assoc($q_ket)) {
      echo '<table class="atas" cellspacing="0" cellpadding="0" width="100%" border="1">';
        echo '<tr valign="middle">';
        echo '<td style="padding: 5px"><span style="width: 150px; float: left">Nama SKPD </span><span style="width: 150px; float: left">: '.$ket['nomor_skpd'].'</span><span style="width: 50%; float: left">'.$ket['nama_skpd'].'</span><br/>';
        echo '<span style="width: 150px; float: left">Nama Program </span><span style="width: 150px; float: left">: '.$ket['nomor_skpd'].'.'.$ket['no_program'].'</span><span style="width: 50%; float: left">'.$ket['nama_program'].'</span><br/>';
        echo '<span style="width: 150px; float: left">Nama Kegiatan </span><span style="width: 150px; float: left">: '.$ket['nomor_skpd'].'.'.$ket['no_program'].'.'.$ket['no_kegiatan'].'</span><span style="width: 50%; float: left">'.$ket['nama_kegiatan'].'</span><br/>';
        echo '</td></tr>';
      echo '</table>';
    }

//isian data Keterangan Keluaran Dana
    $ppas = "SELECT * FROM `tb_laporan_programkegiatan`
    LEFT JOIN `tb_programkegiatan` ON `tb_laporan_programkegiatan`.`id_programkegiatan` = `tb_programkegiatan`.`id_programkegiatan` 
    LEFT JOIN `tb_target` ON `tb_laporan_programkegiatan`.`no_target` = `tb_target`.`no_target` 
    LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` 
    LEFT JOIN `tb_program` ON `tb_programkegiatan`.`no_program` = `tb_program`.`no_program` where `tb_laporan_programkegiatan`.`nomor_skpd`='".$_GET['skpd']."' AND `tb_laporan_programkegiatan`.`no_tahun`='$notahun' AND `tb_programkegiatan`.`id_kegiatan`='".$_GET['id']."' ORDER BY `tb_programkegiatan`.`no_program` ASC";
    $sasaran = mysqli_query($koneksi,$ppas);
    $target = mysqli_query($koneksi,$ppas);
      echo '<table class="aktifitas" cellspacing="0" cellpadding="0" width="100%" border="1">';
        echo '<tr>';
        echo '<td colspan="3" style="padding: 5px" align="center"><b>INDIKATOR DAN TOLAK UKUR KINERJA</b></td>';
        echo '</tr>';
        echo '<tr class="header-tabel">';
        echo "<td class=\"kepala-tabel\" width=\"10%\">INDIKATOR</td>";
        echo "<td class=\"kepala-tabel\" width=\"70%\"  align='center'>TOLAK UKUR KINERJA</td>";
        echo "<td class=\"kepala-tabel\" width=\"20%\"  align='center'>TARGET KINERJA</td>";
        echo '</tr>';
        echo '<tr valign="top">';
        echo '<td class="isi-tabel" style="padding-bottom: 10px"><b>KELUARAN</b></td>';
        echo '<td class="isi-tabel">';
        while ($rows = mysqli_fetch_array($sasaran)) {
          echo $rows[9]."<br />";
        }
        echo '</td>';

        echo '<td class="isi-tabel">';
        while ($rows = mysqli_fetch_array($target)) {
          echo $rows[10]."<br />";
        }
        echo '</td>';

        echo '</tr><tr valign="top">';
        echo '<td class="isi-tabel" style="padding-bottom: 10px"><b>MASUKAN</b></td><td class="isi-tabel">Jumlah Dana</td><td class="isi-tabel">';
        $total = mysqli_query($koneksi,"SELECT `tb_laporan_belanja`.`id_belanja`,`tb_belanja`.`id_belanja`,`tb_laporan_belanja`.`id_laporan`, SUM(`tb_belanja`.`harga_satuan`*`tb_belanja`.`volume`) AS totali FROM `tb_laporan_belanja`
      LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja` WHERE `tb_laporan_belanja`.`id_ket`='2' AND `tb_laporan_belanja`.`id_programkegiatan`='".$_GET['id']."' 
       AND `tb_laporan_belanja`.`nomor_skpd`='".$_GET['skpd']."' AND `tb_laporan_belanja`.`no_tahun`='$notahun' ");
        /*$total = mysqli_query($koneksi,"SELECT `tb_laporan_belanja`.`id_belanja`,`tb_belanja`.`id_belanja`,SUM(`tb_belanja`.`harga_satuan`*`tb_belanja`.`volume`) as totali,`tb_laporan_belanja`.`id_laporan`,`tb_laporan_belanja`.`id_programkegiatan`,`tb_laporan_belanja`.`id_laporan`,`tb_programkegiatan`.`id_programkegiatan`,`tb_programkegiatan`.`id_kegiatan`,`tb_kegiatan`.`id_kegiatan`,`tb_kegiatan`.`no_kegiatan`,`tb_laporan_belanja`.`id_belanja`,`tb_belanja`.`id_belanja`,`tb_belanja`.`volume`,`tb_belanja`.`harga_satuan`,`tb_laporan_belanja`.`id_ket` FROM tb_laporan_belanja
        LEFT JOIN `tb_programkegiatan` ON `tb_laporan_belanja`.`id_programkegiatan` = `tb_programkegiatan`.`id_programkegiatan` 
        LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja` 
        LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` WHERE `tb_programkegiatan`.`id_programkegiatan`='".$_GET['id']."'
        AND `tb_laporan_belanja`.`nomor_skpd`='".$_GET['skpd']."' AND `tb_laporan_belanja`.`no_tahun`='$notahun' AND `tb_laporan_belanja`.`id_belanja`='2'");*/

        while ($rows = mysqli_fetch_assoc($total)) {
          echo 'Rp. '.rupiah($rows['totali'], 2);
        }

        echo '</td>';
        echo '</tr><tr>';
        echo '<td colspan="3" style="padding: 5px">Kelompok Sasaran Kegiatan : Seluruh Kota Banjarbaru</td>';
        echo '</tr><tr>';
        echo '<td colspan="3" style="padding: 5px" align="center"><b>RINCIAN ANGGARAN BELANJA MENURUT PROGRAM DAN PER KEGIATAN SATUAN KERJA PERANGAT DAERAH</b></td>';
        echo '</tr>';
      echo '</table>';


//isian RKA
    echo '<table class="aktifitas" cellspacing="0" cellpadding="0" width="100%" border="1">';
        echo '<tr class="header-tabel">';
        echo "<td rowspan=\"2\" class=\"kepala-tabel\" width=\"10%\">No Rek.</td>";
        echo "<td rowspan=\"2\" class=\"kepala-tabel\" width=\"30%\" align='center'>Urain</td>";
        echo '<td colspan="3" width=\'30%\' class="kepala-tabel" align="center">RINCIAN PERHITUNGAN</td>';
        echo "<td rowspan=\"2\" class=\"kepala-tabel\" width=\"20%\"  align='center'>Jumlah</td>";
        echo '</tr>';
        echo '<tr class="header-tabel">';
        echo "<td class=\"kepala-tabel\" width=\"10%\" align=\"center\">Volume</td>";
        echo "<td class=\"kepala-tabel\" width=\"5%\" align=\"center\">Satuan</td>";
        echo "<td class=\"kepala-tabel\" width=\"15%\" align=\"center\">Harga Satuan</td>";
        echo "</tr>";
    $q_rka=mysqli_query($koneksi,"SELECT * FROM tb_laporan_belanja
    LEFT JOIN `tb_ket_belanja` ON `tb_laporan_belanja`.`id_ket` = `tb_ket_belanja`.`id_ket` 
    LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja` WHERE `tb_laporan_belanja`.`id_programkegiatan`='".$_GET['id']."' AND `tb_laporan_belanja`.`nomor_skpd`='".$_GET['skpd']."' AND `tb_laporan_belanja`.`no_tahun`='$notahun' AND `tb_ket_belanja`.`id_ket`='2' GROUP BY `tb_ket_belanja`.`id_ket` ORDER BY `tb_ket_belanja`.`id_ket` DESC");
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
          echo "<td class=\"isi-tabel\"><span style=\"float: left\">Rp. </span><span style=\"float: right\">".rupiah($row['harga_satuan'])."</span></td>";
          echo "<td class=\"isi-tabel\"><span style=\"float: left\">Rp. </span><span style=\"float: right\">".rupiah($row['volume']*$row['harga_satuan'], 2)."</span></td>";
          echo '<input name="id_belanja[]" value="'.$row['id_belanja'].'" type="hidden">';
        echo "</tr>";
      }
    }
    echo "</table>";

}


if (@$_GET['print']=='da') {

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
      
      echo '<center><h3>Plafon Anggaran Sementara Berdasarkan Program/Kegiatan</h3></center>';
      echo '<table class="aktifitas" cellspacing="0" cellpadding="0" border="1">
          <tr class="header-tabel" href="#">
            <td class="kepala-tabel" width=\'11%\'>Kode</td>
            <td class="kepala-tabel" width="25%">Nama Program/Kegiatan</td>
            <td class="kepala-tabel" width="25%">Sasaran</td>
            <td class="kepala-tabel" width=\'9%\'>Target</td>
            <td class="kepala-tabel" width=\'15%\'>Pagu Dana</td>
          </tr>';

      if ($level=='admin') {
      //ini All
        while ($skpd = mysqli_fetch_array($group)) {
          echo '<tr href="#" style="background-color: #ffe372">';
          echo "<td class='isi-tabel' width='11%'><b>".$skpd[4]."</b></td>";
          echo "<td colspan='5' class='isi-tabel'><b>".$skpd[6]."</b></td>";
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



            //cari gruoup anggaran dana
            if ($data_rka['id_ket']=='1') {
              $ket_belanja = 'belanja_langsung';
            }
            if ($data_rka['id_ket']=='2') {
              $ket_belanja = 'belanja_tidak_langsung';
            }

            //penerapan cari dana anggaran
            $q_dana = mysqli_query($koneksi,"SELECT SUM($ket_belanja),`nomor_skpd`,`no_tahun` FROM `tb_ppas` WHERE `nomor_skpd`='".$skpd[4]."' AND `no_tahun`='$notahun' GROUP BY `nomor_skpd`");
              echo '<tr href="#">';
                echo "<td class=\"isi-tabel\"></td>";
                echo "<td class=\"isi-tabel\"><b>".$data_rka['nama_belanja']."</b></td>";
                echo "<td class=\"isi-tabel\"></td>";
                echo "<td class=\"isi-tabel\"></td>";

                //dana anggaran
                echo "<td class=\"isi-tabel\">";

                while ($dana = mysqli_fetch_array($q_dana)) {
                  echo '<b><span style="float: left">Rp. </span><span style="float: right">'.rupiah($dana[0], 2).'</span></b>';
                }

                echo "</td>";
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
          $q_program = mysqli_query($koneksi,"SELECT * FROM tb_ppas 
            LEFT JOIN `tb_programkegiatan` ON `tb_ppas`.`id_programkegiatan`=`tb_programkegiatan`.`id_programkegiatan` 
            LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan`  
            LEFT JOIN `tb_program` ON `tb_programkegiatan`.`no_program`= `tb_program`.`no_program`
            where `tb_ppas`.`nomor_skpd`='".$skpd[4]."'  AND `tb_ppas`.`no_tahun`='$notahun' GROUP BY `tb_programkegiatan`.`no_program` ORDER BY `tb_programkegiatan`.`no_program` ASC");
          while ($program = mysqli_fetch_array($q_program)) {

            echo '<tr valign="top" href="#">';
            echo "<td class='isi-tabel'><b>".$program[1].".".$program[7]."</b></td>";
            echo "<td class='isi-tabel'><b>".$program[13]."</b></td>";
            echo "<td class='isi-tabel'></td>";
            echo "<td class='isi-tabel'></td>";
            echo "<td class='isi-tabel'></td>";
            echo "</tr>";


            //cari kegiatan dan pengelompokannya
            $q_kegiatan = mysqli_query($koneksi,"SELECT * FROM tb_ppas 
            LEFT JOIN `tb_programkegiatan` ON `tb_ppas`.`id_programkegiatan`=`tb_programkegiatan`.`id_programkegiatan` 
            LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan`  
            LEFT JOIN `tb_program` ON `tb_programkegiatan`.`no_program`= `tb_program`.`no_program`
             where `tb_ppas`.`nomor_skpd`='".$skpd[4]."' AND `tb_ppas`.`no_tahun`='$notahun' AND `tb_programkegiatan`.`no_program`='".$program[7]."' GROUP BY `tb_programkegiatan`.`id_kegiatan` ORDER BY `tb_programkegiatan`.`no_program` ASC");
            while ($kegiatan = mysqli_fetch_array($q_kegiatan)) {

              //cari target dan pengelompokkannya
              $query_master = "SELECT * FROM tb_ppas LEFT JOIN `tb_programkegiatan` ON `tb_ppas`.`id_programkegiatan`=`tb_programkegiatan`.`id_programkegiatan` LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` LEFT JOIN `tb_program` ON `tb_programkegiatan`.`no_program`= `tb_program`.`no_program` LEFT JOIN `db_pkl`.`tb_laporan_programkegiatan` ON `tb_programkegiatan`.`id_programkegiatan` = `tb_laporan_programkegiatan`.`id_programkegiatan` LEFT JOIN `tb_target` ON `tb_laporan_programkegiatan`.`no_target` = `tb_target`.`no_target` 
               where `tb_ppas`.`nomor_skpd`='".$skpd[4]."' AND `tb_ppas`.`no_tahun`='$notahun' AND `tb_programkegiatan`.`id_kegiatan`='".$kegiatan[8]."' ORDER BY `tb_programkegiatan`.`no_program` ASC";
              $q_sasaran = mysqli_query($koneksi,$query_master);
              $q_target = mysqli_query($koneksi,$query_master);
              $q_dana = mysqli_query($koneksi,$query_master);
              $validasi = mysqli_query($koneksi,$query_master);

              while ($rows = mysqli_fetch_array($validasi)) {
                if (!$rows[20] AND !$rows[21]) {
                    echo '<tr class="pointer-tabel-link" valign="top" href="#">';
                } else {
                  echo '<tr class="pointer-tabel-link" valign="top" href="#">';
                  #echo '<tr class="pointer-tabel-link" valign="top" href="rka.php?id='.$kegiatan[2].'&skpd='.$kegiatan[1].'">';
                }
              }
              echo "<td class='isi-tabel'>".$kegiatan[1].".".$kegiatan[7].".".$kegiatan[10]."</td>";
              echo "<td class='isi-tabel'>".$kegiatan[11]."</td>";
              echo "<td class='isi-tabel'>";

              while ($rows = mysqli_fetch_array($q_sasaran)) {
                echo '<div class="master">'.$rows[20]."</div>";
              }
              
              echo "</td>";
              echo "<td class='isi-tabel'>";

              while ($rows = mysqli_fetch_array($q_target)) {
                echo '<div class="master">'.$rows[21]."</div>";
              }

              echo "</td>";


              //dana tersedia

              $cari_dana = mysqli_query($koneksi,"SELECT `nomor_skpd`, `id_programkegiatan`, SUM(`belanja_tidak_langsung`+`belanja_langsung`), `no_tahun` FROM `tb_ppas` WHERE `nomor_skpd`='".$kegiatan[1]."' AND `id_programkegiatan`='".$kegiatan[2]."' AND `no_tahun`='".$kegiatan[5]."'");
              echo "<td class='isi-tabel'>";
              if (mysqli_num_rows($cari_dana)=='0') {
                echo '<div class="master"><span style="float: left">Rp. </span><span style="float: right">0,00</span></div>';
              } else {
                while ($data = mysqli_fetch_array($cari_dana)) {
                  echo '<div class="master"><span style="float: left">Rp. </span><span style="float: right">'.rupiah($data[2], 2).'</span></div>';
                }
              }

              echo "</td>";

              echo "</tr>";
            }
          }
        }


        // selain admin
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

            //cari gruoup anggaran dana
            if ($data_rka['id_ket']=='1') {
              $ket_belanja = 'belanja_langsung';
            }
            if ($data_rka['id_ket']=='2') {
              $ket_belanja = 'belanja_tidak_langsung';
            }

            //penerapan cari dana anggaran
            $q_dana = mysqli_query($koneksi,"SELECT SUM($ket_belanja),`nomor_skpd`,`no_tahun` FROM `tb_ppas` WHERE `nomor_skpd`='".$nouser."' AND `no_tahun`='$notahun' GROUP BY `nomor_skpd`");
              echo '<tr href="#">';
                echo "<td class=\"isi-tabel\"></td>";
                echo "<td class=\"isi-tabel\"><b>".$data_rka['nama_belanja']."</b></td>";
                echo "<td class=\"isi-tabel\"></td>";
                echo "<td class=\"isi-tabel\"></td>";

                //dana anggaran
                echo "<td class=\"isi-tabel\" align=>";

                while ($dana = mysqli_fetch_array($q_dana)) {
                  echo '<b><span style="float: left">Rp. </span><span style="float: right">'.rupiah($dana[0], 2).'</span></b>';
                }

                echo "</td>";
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
          $q_program = mysqli_query($koneksi,"SELECT * FROM tb_ppas 
            LEFT JOIN `tb_programkegiatan` ON `tb_ppas`.`id_programkegiatan`=`tb_programkegiatan`.`id_programkegiatan` 
            LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan`  
            LEFT JOIN `tb_program` ON `tb_programkegiatan`.`no_program`= `tb_program`.`no_program`
            where `tb_ppas`.`nomor_skpd`='".$nouser."'  AND `tb_ppas`.`no_tahun`='$notahun' GROUP BY `tb_programkegiatan`.`no_program` ORDER BY `tb_programkegiatan`.`no_program` ASC");
          while ($program = mysqli_fetch_array($q_program)) {

            echo '<tr valign="top" href="#">';
            echo "<td class='isi-tabel'><b>".$program[1].".".$program[7]."</b></td>";
            echo "<td class='isi-tabel'><b>".$program[13]."</b></td>";
            echo "<td class='isi-tabel'></td>";
            echo "<td class='isi-tabel'></td>";
            echo "<td class='isi-tabel'></td>";
            echo "</tr>";


            //cari kegiatan dan pengelompokannya
            $q_kegiatan = mysqli_query($koneksi,"SELECT * FROM tb_ppas 
            LEFT JOIN `tb_programkegiatan` ON `tb_ppas`.`id_programkegiatan`=`tb_programkegiatan`.`id_programkegiatan` 
            LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan`  
            LEFT JOIN `tb_program` ON `tb_programkegiatan`.`no_program`= `tb_program`.`no_program`
             where `tb_ppas`.`nomor_skpd`='".$nouser."' AND `tb_ppas`.`no_tahun`='$notahun' AND `tb_programkegiatan`.`no_program`='".$program[7]."' GROUP BY `tb_programkegiatan`.`id_kegiatan` ORDER BY `tb_programkegiatan`.`no_program` ASC");
            while ($kegiatan = mysqli_fetch_array($q_kegiatan)) {

              //cari target dan pengelompokkannya
              $query_master = "SELECT * FROM tb_ppas LEFT JOIN `tb_programkegiatan` ON `tb_ppas`.`id_programkegiatan`=`tb_programkegiatan`.`id_programkegiatan` LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` LEFT JOIN `tb_program` ON `tb_programkegiatan`.`no_program`= `tb_program`.`no_program` LEFT JOIN `db_pkl`.`tb_laporan_programkegiatan` ON `tb_programkegiatan`.`id_programkegiatan` = `tb_laporan_programkegiatan`.`id_programkegiatan` LEFT JOIN `tb_target` ON `tb_laporan_programkegiatan`.`no_target` = `tb_target`.`no_target` 
               where `tb_ppas`.`nomor_skpd`='".$nouser."' AND `tb_ppas`.`no_tahun`='$notahun' AND `tb_programkegiatan`.`id_kegiatan`='".$kegiatan[8]."' ORDER BY `tb_programkegiatan`.`no_program` ASC";
              $q_sasaran = mysqli_query($koneksi,$query_master);
              $q_target = mysqli_query($koneksi,$query_master);
              $q_dana = mysqli_query($koneksi,$query_master);
              $validasi = mysqli_query($koneksi,$query_master);

              while ($rows = mysqli_fetch_array($validasi)) {
                if (!$rows[20] AND !$rows[21]) {
                    echo '<tr class="pointer-tabel-link" valign="top" href="#">';
                } else {
                  echo '<tr class="pointer-tabel-link" valign="top" href="#">';
                  #echo '<tr class="pointer-tabel-link" valign="top" href="rka.php?id='.$kegiatan[2].'&skpd='.$kegiatan[1].'">';
                }
              }
              echo "<td class='isi-tabel'>".$kegiatan[1].".".$kegiatan[7].".".$kegiatan[10]."</td>";
              echo "<td class='isi-tabel'>".$kegiatan[11]."</td>";
              echo "<td class='isi-tabel'>";

              while ($rows = mysqli_fetch_array($q_sasaran)) {
                echo '<div class="master">'.$rows[20]."</div>";
              }
              
              echo "</td>";
              echo "<td class='isi-tabel'>";

              while ($rows = mysqli_fetch_array($q_target)) {
                echo '<div class="master">'.$rows[21]."</div>";
              }

              echo "</td>";


              //dana tersedia

              $cari_dana = mysqli_query($koneksi,"SELECT `nomor_skpd`, `id_programkegiatan`, SUM(`belanja_tidak_langsung`+`belanja_langsung`), `no_tahun` FROM `tb_ppas` WHERE `nomor_skpd`='".$kegiatan[1]."' AND `id_programkegiatan`='".$kegiatan[2]."' AND `no_tahun`='".$kegiatan[5]."'");
              echo "<td class='isi-tabel'>";
              if (mysqli_num_rows($cari_dana)=='0') {
                echo '<div class="master"><span style="float: left">Rp. </span><span style="float: right">0,00</span></div>';
              } else {
                while ($data = mysqli_fetch_array($cari_dana)) {
                  echo '<div class="master"><span style="float: left">Rp. </span><span style="float: right">'.rupiah($data[2], 2).'</span></div>';
                }
              }

              echo "</td>";

              echo "</tr>";
            }
          }
      }


  }

if (@$_GET['print']=='pdda') {


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
      
      echo '<center><h3>Plafon Anggaran Sementara Berdasarkan Program/Kegiatan</h3></center>';
      echo '<table class="aktifitas" cellspacing="0" cellpadding="0" border="1">
          <tr class="header-tabel" href="#">
            <td class="kepala-tabel" width=\'11%\'>Kode</td>
            <td class="kepala-tabel" width="25%">Nama Program/Kegiatan</td>
            <td class="kepala-tabel" width="25%">Sasaran</td>
            <td class="kepala-tabel" width=\'9%\'>Target</td>
            <td class="kepala-tabel" width=\'15%\'>Pagu Dana</td>
            <td class="kepala-tabel" width=\'15%\'>Dana Anggaran</td>
          </tr>';

      if ($level=='admin') {
      //ini All
        while ($skpd = mysqli_fetch_array($group)) {
          echo '<tr href="#" style="background-color: #ffe372">';
          echo "<td class='isi-tabel' width='11%'><b>".$skpd[4]."</b></td>";
          echo "<td colspan='5' class='isi-tabel'><b>".$skpd[6]."</b></td>";
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

            //cari gruoup anggaran dana
            if ($data_rka['id_ket']=='1') {
              $ket_belanja = 'belanja_langsung';
            }
            if ($data_rka['id_ket']=='2') {
              $ket_belanja = 'belanja_tidak_langsung';
            }

            //penerapan cari dana anggaran
            $q_dana = mysqli_query($koneksi,"SELECT SUM($ket_belanja),`nomor_skpd`,`no_tahun` FROM `tb_ppas` WHERE `nomor_skpd`='".$skpd[4]."' AND `no_tahun`='$notahun' GROUP BY `nomor_skpd`");

              echo '<tr href="#">';
                echo "<td class=\"isi-tabel\"></td>";
                echo "<td class=\"isi-tabel\"><b>".$data_rka['nama_belanja']."</b></td>";
                echo "<td class=\"isi-tabel\"></td>";
                echo "<td class=\"isi-tabel\"></td>";
                echo "<td class=\"isi-tabel\">";

                while ($dana = mysqli_fetch_array($q_dana)) {
                  echo '<b><span style="float: left">Rp. </span><span style="float: right">'.rupiah($dana[0], 2).'</span></b>';
                }
                
                echo "</td>";
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


              //dana tersedia

              $cari_dana = mysqli_query($koneksi,"SELECT `nomor_skpd`, `id_programkegiatan`, SUM(`belanja_tidak_langsung`+`belanja_langsung`), `no_tahun` FROM `tb_ppas` WHERE `nomor_skpd`='".$kegiatan[4]."' AND `id_programkegiatan`='".$kegiatan[1]."' AND `no_tahun`='".$kegiatan[3]."'");
              echo "<td class='isi-tabel'>";
              if (mysqli_num_rows($cari_dana)=='0') {
                echo '<div class="master"><span style="float: left">Rp. </span><span style="float: right">0,00</span></div>';
              } else {
                while ($data = mysqli_fetch_array($cari_dana)) {
                  echo '<div class="master"><span style="float: left">Rp. </span><span style="float: right">'.rupiah($data[2], 2).'</span></div>';
                }
              }

              echo "</td>";

              //end dana tersedia

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


        // selain admin
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

            //cari gruoup anggaran dana
            if ($data_rka['id_ket']=='1') {
              $ket_belanja = 'belanja_langsung';
            }
            if ($data_rka['id_ket']=='2') {
              $ket_belanja = 'belanja_tidak_langsung';
            }

            //penerapan cari dana anggaran
            $q_dana = mysqli_query($koneksi,"SELECT SUM($ket_belanja),`nomor_skpd`,`no_tahun` FROM `tb_ppas` WHERE `nomor_skpd`='".$nouser."' AND `no_tahun`='$notahun' GROUP BY `nomor_skpd`");

              echo '<tr href="#">';
                echo "<td class=\"isi-tabel\"></td>";
                echo "<td class=\"isi-tabel\"><b>".$data_rka['nama_belanja']."</b></td>";
                echo "<td class=\"isi-tabel\"></td>";
                echo "<td class=\"isi-tabel\"></td>";
                echo "<td class=\"isi-tabel\">";

                while ($dana = mysqli_fetch_array($q_dana)) {
                  echo '<b><span style="float: left">Rp. </span><span style="float: right">'.rupiah($dana[0], 2).'</span></b>';
                }

                echo "</td>";
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


              //dana tersedia

              $cari_dana = mysqli_query($koneksi,"SELECT `nomor_skpd`, `id_programkegiatan`, SUM(`belanja_tidak_langsung`+`belanja_langsung`), `no_tahun` FROM `tb_ppas` WHERE `nomor_skpd`='".$kegiatan[4]."' AND `id_programkegiatan`='".$kegiatan[1]."' AND `no_tahun`='".$kegiatan[3]."'");
              echo "<td class='isi-tabel'>";
              if (mysqli_num_rows($cari_dana)=='0') {
                echo '<div class="master"><span style="float: left">Rp. </span><span style="float: right">0,00</span></div>';
              } else {
                while ($data = mysqli_fetch_array($cari_dana)) {
                  echo '<div class="master"><span style="float: left">Rp. </span><span style="float: right">'.rupiah($data[2], 2).'</span></div>';
                }
              }

              echo "</td>";

              //end dana tersedia

              echo "<td class='isi-tabel'>";

              $total = mysqli_query($koneksi,"SELECT `tb_laporan_belanja`.`id_belanja`,`tb_belanja`.`id_belanja`,SUM(`tb_belanja`.`harga_satuan`*`tb_belanja`.`volume`) as totali,`tb_laporan_belanja`.`id_laporan`,`tb_laporan_belanja`.`id_programkegiatan`,`tb_laporan_belanja`.`id_laporan`,`tb_programkegiatan`.`id_programkegiatan`,`tb_programkegiatan`.`id_kegiatan`,`tb_kegiatan`.`id_kegiatan`,`tb_kegiatan`.`no_kegiatan`,`tb_laporan_belanja`.`id_belanja`,`tb_belanja`.`id_belanja`,`tb_belanja`.`volume`,`tb_belanja`.`harga_satuan` FROM tb_laporan_belanja
              LEFT JOIN `tb_programkegiatan` ON `tb_laporan_belanja`.`id_programkegiatan` = `tb_programkegiatan`.`id_programkegiatan` 
              LEFT JOIN `tb_belanja` ON `tb_laporan_belanja`.`id_belanja` = `tb_belanja`.`id_belanja` 
              LEFT JOIN `tb_kegiatan` ON `tb_programkegiatan`.`id_kegiatan` = `tb_kegiatan`.`id_kegiatan` WHERE `tb_programkegiatan`.`id_kegiatan`='".$kegiatan[11]."'
              AND `tb_laporan_belanja`.`id_programkegiatan`='".$kegiatan[1]."' 
              AND `tb_laporan_belanja`.`nomor_skpd`='".$nouser."' AND `tb_laporan_belanja`.`no_tahun`='$notahun' ");

              while ($rows = mysqli_fetch_assoc($total)) {
                echo '<div class="master"><span style="float: left">Rp. </span><span style="float: right">'.rupiah($rows['totali'], 2).'</span></div>';                
              }

              echo "</td>";

              echo "</tr>";
            }
          }
      }


  }


  if (@$_GET['print']=='pd') {

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
      
      echo '<center><h3>Plafon Anggaran Sementara Berdasarkan Program/Kegiatan</h3></center>';
      echo '<table class="aktifitas" cellspacing="0" cellpadding="0" border="1">
          <tr class="header-tabel" href="#">
            <td class="kepala-tabel" width=\'11%\'>Kode</td>
            <td class="kepala-tabel" width="30%">Nama Program/Kegiatan</td>
            <td class="kepala-tabel" width="30%">Sasaran</td>
            <td class="kepala-tabel" width=\'9%\'>Target</td>
            <td class="kepala-tabel" width=\'20%\'>Dana Anggaran</td>
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


  }

    ?>
</body>