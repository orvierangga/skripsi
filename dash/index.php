<?php
//panggil DB
include 'system/db.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Badan Perencanaan Pembangunan Daerah</title>
    <link href="../css/styles.css" rel="stylesheet">
    <link href="../css/fonts.css" rel="stylesheet">
  </head>
  <body>

  <header>
<?php
//panggil header
include 'system/header.php';

?>
  </header>

  <section>
    <div class="content">
    <div class="judul"><i class="fa fa-home fa-lg"></i> Beranda <?php echo $lastlogin ?></div>
    <div class="isi">
    <h1><center>Selamat Datang di Sistem Informasi Rencana Kerja dan Anggaran Daerah Kota Banjarbaru!</center></h1>
      <p>Assalamu'alaikum Wr. Wb.</p>
      <p>Kami menyambut baik diterbitkannya website Badan Perencanaan Pembangunan Daerah Kota Banjarbaru. Diharapkan website ini dapat menjadi media informasi bagi semua pihak untuk mengenal lebih dalam tentang Kota Banjarbaru.</p>
      <p>Untuk semua Satuan Kerja Perangkat Daerah yang sudah terdaftar disistem ini. Diharapkan untuk mengganti Kata Sandi Default: (123) tersebut</p>

      <p>Wassalamualaikum Wr. Wb</p>
      <p><b>Regard,</b></p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p><b>Admin</b></p>
    </div>
    </div>
  </section>

<?php
//panggil Footer
include 'system/footer.php';

?>
  </body>
</html>