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
            <pagetitle>Token PLN</pagetitle>
        </a>
    </left>
    <right></right>
</header></div>

<form class="form-horizontal" method="POST" id="ajax-result" action="<?php echo $config['web']['base_url']; ?>beli/pay" onsubmit="myButton.disabled = true; return true;">
  <section class="card-section pt-2 wd-100">
      <card style="border-radius: .90rem">
          <card-body style="padding-top: 6px; padding-bottom: 6px">
            <div class="form-group">
                <div class="form-group">
                    <label>Masukkan Nomor Token</label>
                    <input type="number" class="form-control" name="data" id="phone" style="border-radius: .40rem">
                </div>
                <label>Kategori</label>
                <select style="border-radius: .40rem" class="form-control" id="oprator" name="service">
                    <option value="0">Pilih...</option>
                    <?php
                    $category = $model->db_query($db, "*", "service_type", "type = 'PLN'", "name ASC");
                    if ($category['count'] == 1) {
                      print('<option value="'.$category['rows']['code'].'">'.$category['rows']['name'].'</option>');
                  } else {
                    foreach ($category['rows'] as $key) {
                       print('<option value="'.$key['code'].'">'.$key['name'].'</option>');
                   }
               }
               ?>
           </select>
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
        $("#service").hide();
        $('#opt').hide();
        $("#oprator").change(function() {
            var oprator = $("#oprator").val();
            var phone = $("#phone").val();
            $.ajax({
                url: '<?php echo $config['web']['base_url'] ?>ajax/prabayar.php',
                data: 'oprator=' + oprator + '&type=PLN' + '&phone=' + phone,
                type: 'POST',
                dataType: 'html',
                success: function(msg) {
                    $('#opt').show();
                    $("#service").show();
                    $("#service").html(msg);
                }
            });
        });
    });
</script>

<div style="padding-top: 30px"></div>
<div class="col-lg-12">
	<div class="iq-card">
		<div class="iq-card-body">
            <div class="iq-header-title">
                <h4><i class="card-title fa fa-bell"></i> Perhatian!</h4>
            </div>
            <ul>
             <li>Masukkan Nomor Token Terlebih Dahulu Sebelum Memilih Kategori.</li>
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