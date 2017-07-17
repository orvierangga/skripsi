 <?php   
  echo '<div class="navigasi">';
    echo '<div class="judul_nav">Navigasi <span style="float:right"><i class="fa fa-th-list fa-lg"></i></span></div>';
      echo '<a href="index.php"><div class="blok"><i class="fa fa-home fa-lg"></i> Beranda</div></a>';
      echo '<a href="lihat_data.php"><div class="blok"><i class="fa fa-list-alt fa-lg"></i> Lihat Data</div></a>';
      

        if (empty($level == 'admin')) {
          echo '<a href="input_data.php"><div class="blok"><i class="fa fa-pencil fa-lg"></i> Masukkan Data</div></a>';  
        }
      
      //echo '<a href="aktifitas.php"><div class="blok"><i class="fa fa-rss fa-lg"></i> Aktivitas Saya</div></a>';
      echo '<a href="pengaturan.php"><div class="blok"><i class="fa fa-gear fa-lg"></i> Pengaturan</div></a>';
      if ($level == 'admin') {
        echo '<a href="input_ppas.php"><div class="blok"><i class="fa fa-pencil fa-lg"></i> Masukkan Data PPAS</div></a>'; 
        echo '<a href="admin.php"><div class="blok"><i class="fa fa-user fa-lg"></i> Admin Menu</div></a>';  
      }
      echo '<a href="bantuan.php"><div class="blok"><i class="fa fa-info-circle fa-lg"></i> Bantuan</div></a>';
      echo '<a id="btn" href="#btn"><div class="blok"><i class="fa fa-sign-out fa-lg"></i> Keluar</div></a>';
    echo '</div>';


    echo '<div id="tampil_modal">';
      echo '<div id="modal">';
        echo '<div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Confirmation</div>';
          echo '<p>Apakah anda ingin keluar ?</p>';
        echo '<button id="oke">Tidak</button> <a href="keluar.php"><button id="yes">Ya</button></a>';
    echo '</div>';
  echo '</div>';

?>