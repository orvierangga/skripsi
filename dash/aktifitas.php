<?php

//panggil DB
include 'system/db.php';
      if (empty($level == 'admin')) {
        $aktifitas=mysqli_query($koneksi,"select * from tb_log left join tb_skpd on tb_log.nomor_skpd=tb_skpd.nomor_skpd where tb_log.nomor_skpd='$nouser' order by no_log desc");
      } else {
        $aktifitas=mysqli_query($koneksi,"select * from tb_log left join tb_skpd on tb_log.nomor_skpd=tb_skpd.nomor_skpd order by no_log desc");
      }
if (isset($_POST['Cari'])) {
  $nomor_com = $_POST['skpd'];
  if ($nomor_com == '*') {
    $aktifitas=mysqli_query($koneksi,"select * from tb_log left join tb_skpd on tb_log.nomor_skpd=tb_skpd.nomor_skpd order by no_log desc");
  } else {
    $aktifitas=mysqli_query($koneksi,"select * from tb_log left join tb_skpd on tb_log.nomor_skpd=tb_skpd.nomor_skpd where tb_log.nomor_skpd='$nomor_com' order by no_log desc");
    $skpd = mysqli_query($koneksi,"select * from tb_log left join tb_skpd on tb_log.nomor_skpd=tb_skpd.nomor_skpd where tb_log.nomor_skpd='$nomor_com' order by no_log desc limit 0,1");
  }
}


echo '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Badan Perencanaan Pembangunan Daerah</title>
    <link href="../css/styles.css" rel="stylesheet">
    <link href="../css/fonts.css" rel="stylesheet">
  </head>
  <body>';

  echo '<header>';

include 'system/header.php';

?>
  </header>

  <section>
    <div class="content">
    <div class="judul"><i class="fa fa-rss fa-lg"></i> Aktifitas <?php echo $lastlogin;?></div>
    <div class="isi">
      <?php
        if ($level == 'admin') {
          echo '<form method="POST" action="">';
            echo '<select name="skpd" class="search_com">';

              echo '<option selected="" value="*">-- Semua SKPD --</option>';
                $query = "select * from tb_skpd order by nomor_skpd ASC";
                $result = mysqli_query($koneksi,$query);
                while ($rows = mysqli_fetch_array($result)) {
                  if ($_POST['skpd']==$rows['0']) {
                    echo "<option name=\"combo\" value=\"".$rows['0']."\" selected>".$rows['1']."</option>";
                  } else {
                    echo "<option name=\"combo\" value=\"".$rows['0']."\">".$rows['1']."</option>";
                  }
                }
                            
          echo '</select>';
          echo '<input type="submit" value="Search" name="Cari" class="search" />';
          echo '</form>';

          if (isset($_POST['Cari'])) {
            if ($nomor_com == '*') {
              echo '<center><h1>Semua SKPD</h1></center>';
            } else {
              while ($data = mysqli_fetch_array($skpd)) {
                echo "<center><h1>".$data[7]."</h1></center>";
              }
            }
          } else {
            echo '<center><h1>Semua SKPD</h1></center>';
          }
        }
        echo '<p>Aktifitas yang dilakukan user kepada sistem informasi Badan Perencanaan Daerah Banjarabaru</p>';
      ?>
      <!--<select style="width:400px">
        <option name="me">Instansi saya</option>
        <option>Semua Instansi</option>
      </select>-->
      <table class="aktifitas" cellspacing="0" cellpadding="0" >
        <tr class="header-tabel">
          <td class="kepala-tabel">Nama SKPD</td>
          <td class="kepala-tabel">Aktifitas</td>
          <td class="kepala-tabel">Browser</td>
          <td class="kepala-tabel">Alamat IP</td>
          <td class="kepala-tabel">Waktu</td>
        </tr>
        <?php
            while ($data = mysqli_fetch_array($aktifitas)) {
              echo '<tr class="pointer-tabel">';
                  echo "<td class='isi-tabel' width='40%'>".$data[7]."</td>";
                  echo "<td class='isi-tabel' width='15%'>".$data[3]."</td>";
                  echo "<td class='isi-tabel' width='15%'>".$data[2]."</td>";
                  echo "<td class='isi-tabel' width='10%'>".$data[5]."</td>";
                  echo "<td class='isi-tabel' width='20%'>".date('Y-M-d H:i:s', $data[4])." WIB</td>";
                echo "</tr>";
              
              
            }

          ?>
        <!-- Pakai Saya
          <?php
            while ($data = mysqli_fetch_array($aktifitas)) {
              
              if ($data[6] == $saya) {
                echo '<tr class="pointer-tabel-saya">';
                  echo "<td class='isi-tabel'>".$data[1]."</td>";
                  echo "<td class='isi-tabel'>Saya</td>";
                  echo "<td class='isi-tabel'>".$data[3]."</td>";
                  echo "<td class='isi-tabel'>".substr($data[2], 0, 15)."...</td>";
                  echo "<td class='isi-tabel'>".date('Y-M-d H:i:s', $data[4])."</td>";
                echo "</tr>";
              } else {
                echo '<tr class="pointer-tabel">';
                  echo "<td class='isi-tabel'>".$data[1]."</td>";
                  echo "<td class='isi-tabel'>".$data[6]."</td>";
                  echo "<td class='isi-tabel'>".$data[3]."</td>";
                  echo "<td class='isi-tabel'>".substr($data[2], 0, 15)."...</td>";
                  echo "<td class='isi-tabel'>".date('Y-M-d H:i:s', $data[4])."</td>";
                echo "</tr>";
              }
              
              
            }

          ?>-->
      </table>
    </div>
    </div>
  </section>

<?php
//panggil Footer
include 'system/footer.php';

?>

  </body>
</html>