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
    <div class="judul"><i class="fa fa-info-circle fa-lg"></i> Bantuan <?php echo $lastlogin;?></div>
    <div class="isi">
    <h2 class="help">Bagaimana melihat rekap data PPAS dan RKA saya ?</h2>
      <p>Anda bisa melihat data rekap PPAS dan RKA anda dengan cara sebagai berikut:</p>
      <p>1. Pilih "Lihat data" pada Navigasi di samping kiri</p>
      <p>2. Disana anda langsung disediakan data rekap PPAS SKPD anda</p>
      <p>3. Untuk melihat RKA anda, anda bisa mengklik kegiatan yang ada di rekapan PPAS tersebut.</p>


      <h2 class="help">Bagaimana saya bisa memasukkan data ?</h2>
      <p>Anda bisa memasukkan data kegiatan rencana kerja anda di bagian menu "Masukkan Data". dan langkah selanjutnya :</p>
      <p>1. Pilih Nama Program</p>
      <p>2. Pilih Nama Kegiatan</p>
      <p>3. Masukkan sasaran dari Kegiatan. <br><span style="color: #999; font-size: 10px">Contoh: Tersedianya Jasa Surat Menyurat</span></p>
      <p>4. Masukkan target dari sasaran. <br><span style="color: #999; font-size: 10px">Contoh: 100%</span></p>
      <p>5. Masukkan dana dari kegiatan yang diselenggarakan. (Hanya angka saja)<br><span style="color: #999; font-size: 10px">Contoh: 12000000</span></p>
      <p><span style="color: #999; font-size: 12px">Catatan: Anda bisa memasukkan beberapa data pada kegiatan.</span></p>

      <h2 class="help">Bagaimana mengganti sandi saya ?</h2>
      <p>Anda bisa memasukkan di bagian menu "Pengaturan". dan langkah selanjutnya :</p>
      <p>1. Masukan kata sandi lama</p>
      <p>2. Masukan kata sandi baru</p>
      <p>3. Masukkan kembali kata sandi baru.</p>
      <p>4. Klik "Ganti Sandi".</p>

      <h2 class="help">Saya salah memilih tahun anggaran ?</h2>
      <p>1. Anda bisa memasukkan di bagian menu "Pengaturan". dan langkah selanjutnya :</p>
      <p>2. Pilih menu "Ganti Tahun".</p>
      <p>3. Pilih tahun yang anda inginkan, lalu tekan "ganti tahun".</p>
      <?php if ($level == 'admin') { ?>
      <h2 class="help">Fungsi Admin menu ?</h2>
      <p>Fungsi dari admin menu adalah menu khusus untuk admin yang mana didalamnya terdapat menu untuk :</p>
      <p>1. Masukkan data PPAS</p>
      <p>2. Menambah Daftar Program dan Kegiatan</p>
      <p>3. Menambah / Menghapus data SKPD</p>
      <p>4. Menambah / Menghapus data Tahun</p>

      <h2 class="help">Bagaimana memasukkan data PPAS ?</h2>
      <p>Untuk menambahkan data PPAS anda dapat memasukkannya didalam <b>Admin Menu</b>, dan pilih <b>Masukkan data PPAS</b>. langkah selanjutnya :</p>
      <p>1. Pilihlah nama SKPD yang akan anda masukkan data PPAsnya.</p>
      <p>2. Pilih program apa yang akan anda masukkan data PPASnya.</p>
      <p>3. Pilih kegiatan apa yang anda masukkan data PPAS.</p>
      <p>4. Masukkan nilai uang Belanja Langsung. (Hanya angka)</p>
      <p>5. Masukkan nilai uang Belanja tidak Langsung. (Hanya angka)</p>

      <h2 class="help">Bagaimana memasukkan data Program dan Kegiatan ?</h2>
      <p>Untuk menambahkan data Program dan Kegiatan anda dapat memasukkannya didalam <b>Admin Menu</b>, dan pilih <b>Daftar Program dan Kegiatan</b>. langkah selanjutnya :</p>
      <p>1. Pilihlah Tambah program (Jika program tidak ada). Dan masukkan data Program data</p>
      <p>2. Pilih Tambah Kegiatan.</p>
      <p>2.1. Pilih Program mana yang akan anda masukkan kegiatan tersebut.</p>
      <p>4. Masukkan nilai uang Belanja Langsung. (Hanya angka)</p>
      <p>5. Masukkan nilai uang Belanja tidak Langsung. (Hanya angka)</p>
      <?php } ?>
    </div>
    </div>
  </section>

<?php
//panggil Footer
include 'system/footer.php';

?>

  </body>
</html>