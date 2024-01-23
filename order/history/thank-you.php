<?php
require '../../mainconfig.php';
require '../../lib/check_session.php';
require '../../lib/is_login.php';
require '../../lib/header.php';
if (!isset($_GET['id'])) {
	exit("No direct script access allowed!");
}
$data_target = $model->db_query($db, "*", "orders_mobile", "oid = '".mysqli_real_escape_string($db, $_GET['id'])."' AND user = '".$login['username']."'");
if ($data_target['count'] == 0) {
	$result_msg = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Data tidak ditemukan.');
	require '../../lib/result.php';
	exit();
}
if($data_target['rows']['status'] == "Pending") {
	$label = "warning";
} else if($data_target['rows']['status'] == "Processing") {
	$label = "info";
} else if($data_target['rows']['status'] == "Error") {
	$label = "danger";
} else if($data_target['rows']['status'] == "Partial") {
	$label = "danger";
} else if($data_target['rows']['status'] == "Success") {
	$label = "success";
}
?>
<style type="text/css">
.card-detail {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: start;
    align-items: flex-start;
    -ms-flex-pack: justify;
    justify-content: space-between;
    padding: 1rem 1rem;
    padding-top: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #292b2d;
    border-top-left-radius: calc(.3rem - 1px);
    border-top-right-radius: calc(.3rem - 1px);
}
p {
    margin-top: -23px;
    margin-bottom: 1rem;
}
.bgc-h-secondary-l4:hover, .bgc-secondary-l4 {
    background-color: #ffff !important;
}
.card-body > a.item::after {
    background-image: url("data:image/svg+xml,%0A%3Csvg width='10px' height='16px' viewBox='0 0 10 16' version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'%3E%3Cg id='Page-1' stroke='none' stroke-width='1' fill='none' fill-rule='evenodd' stroke-linecap='round' stroke-linejoin='round'%3E%3Cg id='Listview' transform='translate(-112.000000, -120.000000)' stroke='%23A1A1A2' stroke-width='2.178'%3E%3Cpolyline id='Path' points='114 122 120 128 114 134'%3E%3C/polyline%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: center center;
    width: 16px;
    height: 16px;
    content: "";
    position: absolute;
    right: 12px;
    opacity: 0.5;
    top: 50%;
    margin-top: -8px;
}
a, button, input, btn {
    outline: medium none !important;
}
a, .btn {
    -webkit-transition: all 0.5s ease-out 0s;
    -moz-transition: all 0.5s ease-out 0s;
    -ms-transition: all 0.5s ease-out 0s;
    -o-transition: all 0.5s ease-out 0s;
    transition: all 0.5s ease-out 0s;
}
a {
    text-decoration: none;
}
.alert {
    border-radius: .1875rem;
    color: #09090b;
    background-color: #1797c6;
    text-align: center;
}
.text-center {
    text-align: center !important;
}
</style>
<div class="header-large-title pt-5">
<header class="no-border text-light">
    <center style="color: #fff;font-size: 16px;font-weight: bold;padding-top:12px;">Thank You</center>
</header>
</div>

<section class="card-section pt-2 wd-100">
    <card style="border-radius: .90rem">
    <center>
    <div class="card-detail">
        <img src="https://cdn.dribbble.com/users/129972/screenshots/3964116/75_smile.gif" class="text-center p-1px mt-n5 mx-auto" style="width:140px; height:120px;border-radius: 50%;" />
    </div>
    <div class="text-center pt-0 px-3">
        <p class="text-secondary-d3 text-125 mt-2" style="margin-top:-20px;">
            <b>Pembelian Berhasil!</b>
        </p>
    </div>
    </center>
        <card-body style="padding-top: 6px; padding-bottom: 6px">
            <div class="text-105">
                <span>Layanan <b><p class="text-right"><?php echo $data_target['rows']['service'] ?></p></b></span><br>
                <span>Nomor HP <b><p class="text-right"><?php echo $data_target['rows']['phone'] ?></p></b></span><br>
                <span>SN <b><p class="text-right"><?php echo $data_target['rows']['catatan']; ?></p></b></span><br>
                <span>Harga <b><p class="text-right">Rp. <?php echo number_format($data_target['rows']['price'],0,',','.'); ?></p></b></span><br>
                <span>Status <b><p class="text-right"><?php echo $data_target['rows']['status']; ?></p></b></span>
            </div>
            <hr><br>
            <p>Terima Kasih Telah Melakukan Pembelian di <b><?php echo $config['web']['title']; ?></b>.</p>
        </card-body>
    </card>
    <br>
</section>

<?php
require '../../lib/footer.php';
?>