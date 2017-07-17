<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Badan Perencanaan Pembangunan Daerah</title>
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/fonts.css" rel="stylesheet">
    <script type="text/javascript" src="jquery-1.11.2.min.js"></script>
  </head>
  <body class="muka" style="color: #fff">
  <header>
  <br>
    <center><h1>Lupa Kata Sandi</h1></center>
    <div id="tampil_modal">
    <div id="modal">
      <div id="modal_atas"><i class="fa fa-info-circle fa-lg"></i> Informasi</div>
        <p>Untuk mengetahui email SKPD anda. Silahkan hubungi Admin Badan Perencanaan Pembangunan Untuk mendapatkan Hak Akses Anda Lagi.</p>
      <button id="oke">Oke</button>
      
    </div>
    </div>

  </div>
  <div class="forget">
  <div class="t_forget"></div>
  <div class="clear"></div>
      <p>Untuk mengetahui email dan lupa kata sandi SKPD anda. Silahkan hubungi Admin Badan Perencanaan Pembangunan Untuk mendapatkan Hak Akses Anda Lagi.</p>
      <br>
      <p align="center"><a href="index.php"><i class="fa fa-home fa-lg"></i>  Beranda</a></p>
    </div>


  </header>

<script type="text/javascript" src="../jquery-1.11.2.min.js"></script>
<script>
$(document).ready(function(){
  $('#btn').click(function(){
      $('#tampil_modal').fadeToggle();
    });
    $('#oke, #tutup').click(function(){
      $('#tampil_modal').fadeToggle();
    });
});
</script>

  </body>
</html>