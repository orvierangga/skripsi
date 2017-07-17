<?php
date_default_timezone_set('Asia/Jakarta');
  //buat dulu koneksi kedatabase

$dbhost = 'localhost';
$dbuser = 'root';
$dbpassword = '';
$dbname = 'db_pkl';
$koneksi = mysqli_connect($dbhost,$dbuser,$dbpassword, $dbname);

if ($_SERVER['REMOTE_ADDR']=='::1') {
	$_SERVER['REMOTE_ADDR']='127.0.0.1';
}

?>