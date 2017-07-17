  <div class="preload-wrapper">
    <div id="preloader_1">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
  </div>
<script type="text/javascript" src="../jquery-1.11.2.min.js"></script>
<script type="text/javascript">
function confirm_delete() {
  return confirm('Hapus data ini?');
}
</script>
<script language='javascript'>
function validAngka(a)
{
  if(!/^[0-9.]+$/.test(a.value))
  {
  a.value = a.value.substring(0,a.value.length-1000);
  }
}

$(document).ready(function(){
	$('#btn').click(function(){
      $('#tampil_modal').fadeToggle();
    });
    $('#oke, #tutup').click(function(){
      $('#tampil_modal').fadeToggle();
    });
    $('#oke').click(function(){
      $('#tampil_modal_error').fadeToggle()
    });
    $('#okesave').click(function(){
      $('#tampil_modal_save').fadeToggle()
    });
});
$(window).load(function() { $(".preload-wrapper").fadeOut("slow"); })
</script>