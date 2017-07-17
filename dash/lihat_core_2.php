<?php

if (!@$_GET['set']) {


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
?>