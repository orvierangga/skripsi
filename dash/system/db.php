<?php
date_default_timezone_set('Asia/Jakarta');
session_start();
  //buat dulu koneksi kedatabase

$dbhost = 'localhost';
$dbuser = 'root';
$dbpassword = '';
$dbname = 'db_pkl';
$koneksi = mysqli_connect($dbhost,$dbuser,$dbpassword,$dbname);

$nouser=$_SESSION['username'];
$notahun=$_SESSION['notahun'];
$tahun=$_SESSION['tahun'];
if (empty($nouser)) {
  header("location:../error.php");     // dan alihkan ke index.php
}
$query=mysqli_query($koneksi,"select * from tb_skpd where nomor_skpd='".$nouser."'");
$nolog=mysqli_query($koneksi,"select * from tb_log where nomor_skpd='".$nouser."'");
if ((mysqli_num_rows($nolog) == 0) or (mysqli_num_rows($nolog) == 1)) {
	$login=mysqli_query($koneksi,"select * from tb_log left join tb_skpd on tb_log.nomor_skpd=tb_skpd.nomor_skpd where tb_log.nomor_skpd='$nouser' order by no_log desc limit 0, 1");
} else {
	$login=mysqli_query($koneksi,"select * from tb_log left join tb_skpd on tb_log.nomor_skpd=tb_skpd.nomor_skpd where tb_log.nomor_skpd='$nouser' order by no_log desc limit 1, 1");
}
while ($data = mysqli_fetch_array($query)) {
	$saya=$data[1];
	$level = $data[7];
}
while ($data= mysqli_fetch_array($login)) {
	$lastlogin = '<span style="font-size:14px; font-weight: normal; float: right">Terakhir Masuk: '.date('Y-M-d H:i:s').' WIB<br>Masuk Sebagai: <b>'.$data[7].' ('.$tahun.')</b></span>';
}

?>