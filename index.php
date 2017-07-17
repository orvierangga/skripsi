<?php

session_start();
//panggil DB
include 'system/db.php';

function getBrowser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }

    // check if we have a number
    if ($version==null || $version=="") {$version="?";}

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
} 

// now try it
$ua=getBrowser();
// Loginnya

  if (isset($_POST['login'])) {
    $username=$_POST['username'];   //tangkap data yg di input dari form login input username
    $password=md5(md5($_POST['password']));   //tangkap data yg di input dari form login input password
    $no_tahun=$_POST['tahun'];
    if ($no_tahun == 'null') {
      echo '<div id="tampil_modal_error"><div id="modal">
        <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
          <p>Pilih Tahun Kerja.</p>
        <button id="oke">Oke</button>
        
      </div></div>';
    } else {
      $ceking = mysqli_query($koneksi,"select * from tb_skpd where nomor_skpd='$username'");
      if (mysqli_num_rows($ceking) > 0) {
        $data = mysqli_fetch_array($ceking);
        $query=mysqli_query($koneksi,"select * from tb_skpd where nomor_skpd='".$data[0]."' and sandi_skpd='$password'");
        $xxx=mysqli_num_rows($query);
        if($xxx==TRUE){     // melakukan pemeriksaan kecocokan dengan percabangan.
          $query_tahun=mysqli_query($koneksi,"select * from tb_tahun where no_tahun = '$no_tahun'");
          while ($datas=mysqli_fetch_array($query_tahun)) {
            $_SESSION['notahun']=$datas[0];
            $_SESSION['tahun']=$datas[1];
          }
          $_SESSION['username']=$username;  //jika cocok, buat session dengan nama sesuai dengan username
          $log=mysqli_query($koneksi,"INSERT INTO `tb_log`(`nomor_skpd`, `browser`, `aktifitas`, `waktu`, `ip_addres`) VALUES ('$username','" . $ua['name'] . " " . $ua['version'] . "','Masuk ke sistem',".time().",'".$_SERVER['REMOTE_ADDR']."')");
          header("location:dash/index.php");     // dan alihkan ke index.php
          }else{          //jika tidak tampilkan pesan gagal login
            echo '<div id="tampil_modal_error"><div id="modal">
          <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
            <p>Nomor SKPD atau Password Tidak Cocok.</p>
          <button id="oke">Oke</button>
          </div></div>';
          }
      } else {
          echo '<div id="tampil_modal_error"><div id="modal">
          <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
            <p>Nomor SKPD atau Password Tidak Cocok.</p>
          <button id="oke">Oke</button>
          </div></div>';
      }
    }
  }
if (isset($_SESSION['username'])) {
  header("location:dash/index.php");     // dan alihkan ke index.php
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Badan Perencanaan Pembangunan Daerah</title>
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/fonts.css" rel="stylesheet">
    <style type="text/css">
    body {
      color: #fff;
    }
    </style>

    <script type="text/javascript" src="jquery-1.11.2.min.js"></script>
  </head>
  <body style="background: #333">
  <header>
  <div class="muka">  
    <div class="menu">
      <h1><center>Selamat Datang di Sistem Informasi Rencana Kerja dan Anggaran Daerah Kota Banjarbaru!</center></h1>
    <div id='teks_depan'>
      <p>Assalamu'alaikum Wr. Wb.</p>
      <p>Kami menyambut baik diterbitkannya website Badan Perencanaan Pembangunan Daerah Kota Banjarbaru. Diharapkan website ini dapat menjadi media informasi bagi semua pihak untuk mengenal lebih dalam tentang Kota Banjarbaru.</p>
      <p>Pada tahun 2013 pelaksanaan otonomi daerah di Kota Banjarbaru telah berusia tiga belas tahun.  Selama tiga belas tahun berkiprah, telah begitu banyak prestasi pembangunan yang diraih oleh pemerintah, masyarakat maupun swasta, meliputi berbagai aspek kehidupan.</p>
      <p>Oleh karena itu sudah sepatutnya kita mensyukuri karunia Allah SWT ini, sekaligus melakukan introspeksi dan meningkatkan kinerja pembangunan untuk mewujudkan Kota Banjarbaru "MANDIRI DAN TERDEPAN DALAM PELAYANAN".</p>
      <p>Kami menyampaikan terima kasih dan penghargaan yang setinggi-tingginya kepada semua pihak yang telah membantu pelaksanaan pembangunan di Kota Banjarbaru.</p>

      <p>Wassalamualaikum Wr. Wb</p>
    </div>
    </div>
  <div class="login">
  <div class="t_login"></div>
  <div class="clear"></div>

  <center><h2>Masuk Sistem</h2></center>
      <form method="post">
        <b>Nomor SKPD:</b>
        <input class="masuk" type="text" autocomplete="off" placeholder="Nomor SKPD" name="username"><br/>
        <b>Kata Sandi:</b>
        <input class="masuk" type="password" autocomplete="off" placeholder="Kata Sandi" name="password"><br/>
        <b>Tahun:</b><br>
        <?php 
        echo '<select name="tahun" class="input_data" style="width: 100px; margin-left: 0px;">';
          echo '<option value="null">Tahun</option>';
                  $tahun = mysqli_query($koneksi,"select * from tb_tahun order by tahun ASC");
                  while ($rows = mysqli_fetch_array($tahun)) {
                    echo "<option value=\"".$rows['0']."\">".$rows['1']."</option>";
                  }
        echo '</select>'; 
        ?>
        <br>
        <input name="login" type="submit" class="reply" value="Masuk"> <a href="forget.php">Lupa Kata Sandi ?</a>
      </form>
    </div>

  </div>
  </header>

<script type="text/javascript" src="jquery-1.11.2.min.js"></script>
<script>
$(document).ready(function(){
  $('#oke').click(function(){
      $('#tampil_modal_error').fadeToggle()
    });
});
</script>

  </body>
</html>