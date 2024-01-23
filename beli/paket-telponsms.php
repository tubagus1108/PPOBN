<?php
require '../mainconfig.php';
require '../lib/check_session.php';
require '../lib/csrf_token.php';

if (isset($_SESSION['login']) AND $config['web']['maintenance'] == 1) {
	exit("<center><h1>SORRY, WEBSITE IS UNDER MAINTENANCE!</h1></center>");
}
require '../lib/header.php';
?>

<div class="header-large-title pt-5"><header class="no-border text-light">
    <left>
        <a href="/" class="headerButton">
            <em class="ri-arrow-left-s-line"></em>
            <pagetitle>Paket Telpon & SMS</pagetitle>
        </a>
    </left>
    <right></right>
</header></div>

<form class="form-horizontal" method="POST" id="ajax-result" action="<?php echo $config['web']['base_url']; ?>beli/pay" onsubmit="myButton.disabled = true; return true;">
  <section class="card-section pt-2 wd-100">
    <card style="border-radius: .90rem">
      <card-body style="padding-top: 6px; padding-bottom: 6px">
        <div class="form-group">
          <label>Masukkan Nomor HP</label>
          <input type="number" class="form-control" name="data" id="phone" style="border-radius: .40rem">
      </div>
  </card-body>
</card>
</section>
<section class="wd-100 pt-3">
    <div id="service"></div>
</section>
</form>
</div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $('#opt').hide();
    $("#phone").keyup(function() {
      var phone = $("#phone").val();
      $.ajax({
        url: '<?php echo $config['web']['base_url'] ?>ajax/detect.php',
        data: 'phone=' + phone + '&type=Paket SMS dan Telpon',
        type: 'POST',
        dataType: 'html',
        beforeSend: function(msg) {
          $("#service").html("Sedang Memuat...");
      },
      success: function(msg) {
          $('#load').hide();
          $('#opt').show();
          $("#service").html(msg);
      },
      error: function(msg) {
          $("#service").html("Terjadi Kesalahan...");
      }
  });
  });
});
</script>
<script type="text/javascript" src="<?php echo $config['web']['base_url']; ?>dist/js/sim-card.min.js"></script>

<div style="padding-top: 30px"></div>
<div class="col-lg-12">
	<div class="iq-card">
		<div class="iq-card-body">
          <div class="iq-header-title">
            <h4><i class="card-title fa fa-bell"></i> Perhatian!</h4>
        </div>
        <ul>
         <li>Masukkan Nomor HP Terlebih Dahulu.</li>
         <li>Pastikan Tujuan Pesanan Valid.</li>
         <li>Apabila Tidak Ada Perubahan Status, Silakan Hubungi Admin.</li>
         <li>Buka Halaman Riwayat Untuk Melihat Status Transaksi.</li>
     </ul>
 </div>
</div>
</div>
</div    

<?php
require '../lib/footer.php';
?>