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
            <pagetitle>Saldo E-Money</pagetitle>
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
                    <label>Masukkan Nomor HP</label>
                    <input ttype="number" class="form-control" name="data" id="phone" style="border-radius: .40rem">
                </div>
                <div id="kategori">
                  <label>Kategori</label>
                  <select style="border-radius: .40rem" class="form-control" id="oprator" name="service">
                    <option value="0">Pilih...</option>
                    <?php
                    $category = $model->db_query($db, "*", "service_type", "type = 'E-Money'", "name ASC");
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
        $("#kategori").hide();
        $("#phone").keyup(function() {
            var phone= $(this).val();
            var phone = phone.length;
            if (phone > 5) {
                $("#kategori").show();
            } else if (phone < 5) {
                $("#kategori").hide();
            } 
        });
        $("#service").hide();
        $("#oprator").change(function() {
            var oprator = $("#oprator").val();
            var phone = $("#phone").val();
            $.ajax({
                url: '<?php echo $config['web']['base_url'] ?>ajax/prabayar.php',
                data: 'oprator=' + oprator + '&type=E-money' + '&phone=' + phone,
                type: 'POST',
                dataType: 'html',
                success: function(msg) {
                    $("#service").show();
                    $("#service").html(msg);
                }
            });
        });
    });
</script>
<?php
require '../lib/footer.php';
?>