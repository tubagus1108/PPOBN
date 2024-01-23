<?php
require '../../mainconfig.php';
require '../../lib/check_session.php';
require '../../lib/is_login.php';
if (!isset($_GET['id'])) {
	exit("No direct script access allowed!");
}
$data_target = $model->db_query($db, "*", "orders_mobile", "id = '".mysqli_real_escape_string($db, $_GET['id'])."' AND user = '".$login['username']."'");
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
<!-- Feedback modal -->
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
    border-bottom: 1px solid #dee2e6;
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
<card style="border-radius: .90rem">
    <center>
    <div class="card-detail">
        <?php if ($data_target['rows']['operator'] == "TELKOMSEL") { ?>
            <img src="<?php echo $config['web']['base_url']; ?>dist/images/simcard/telkomsel.png" class="text-center p-1px mt-n5 mx-auto" style="width:100px; height:70px;" />
        <? } elseif ($data_target['rows']['operator'] == "XL") { ?>
            <img src="<?php echo $config['web']['base_url']; ?>dist/images/simcard/XL.png" class="text-center p-1px mt-n5 mx-auto" style="width:100px; height:70px;" >
        <? } elseif ($data_target['rows']['operator'] == "AXIS") { ?>
            <img src="<?php echo $config['web']['base_url']; ?>dist/images/simcard/axis.png" class="text-center p-1px  mt-n5 mx-auto" style="width:100px; height:70px;" >
        <? } elseif ($data_target['rows']['operator'] == "INDOSAT") { ?>
            <img src="<?php echo $config['web']['base_url']; ?>dist/images/simcard/indosat.png" class="text-center p-1px mt-n5 mx-auto" style="width:100px; height:70px;" >
        <? } elseif ($data_target['rows']['operator'] == "TRI") { ?>
            <img src="<?php echo $config['web']['base_url']; ?>dist/images/simcard/three.png" class="text-center p-1px mt-n5 mx-auto" style="width:100px; height:70px;" >
        <? } elseif ($data_target['rows']['operator'] == "by.u") { ?>
            <img src="<?php echo $config['web']['base_url']; ?>dist/images/simcard/by-u.png" class="text-center p-1px mt-n5 mx-auto" style="width:100px; height:70px;" >
        <? } elseif ($data_target['rows']['operator'] == "GO PAY") { ?>
            <img src="<?php echo $config['web']['base_url']; ?>dist/images/e-money/gopays.png" class="text-center p-1px mt-n5 mx-auto" style="width:100px; height:70px;" >
        <? } elseif ($data_target['rows']['operator'] == "OVO") { ?>
            <img src="<?php echo $config['web']['base_url']; ?>dist/images/e-money/ovo.png" class="text-center p-1px mt-n5 mx-auto" style="width:100px; height:70px;" >
        <? } elseif ($data_target['rows']['operator'] == "DANA") { ?>
            <img src="<?php echo $config['web']['base_url']; ?>dist/images/e-money/dana.png" class="text-center p-1px mt-n5 mx-auto" style="width:100px; height:70px;" >
        <? } elseif ($data_target['rows']['operator'] == "SHOPEE PAY") { ?>
            <img src="<?php echo $config['web']['base_url']; ?>dist/images/e-money/shopee-pay.png" class="text-center p-1px mt-n5 mx-auto" style="width:100px; height:70px;" >
        <? } elseif ($data_target['rows']['operator'] == "GRAB") { ?>
            <img src="<?php echo $config['web']['base_url']; ?>dist/images/e-money/grab.png" class="text-center p-1px mt-n5 mx-auto" style="width:100px; height:70px;" >
        <? } elseif ($data_target['rows']['operator'] == "PLN") { ?>
            <img src="<?php echo $config['web']['base_url']; ?>dist/images/e-money/pln.png" class="text-center p-1px mt-n5 mx-auto" style="width:100px; height:70px;" >
        <? } ?>
    </div>
    </center>
    <card-body style="padding-top: 6px; padding-bottom: 6px">
    <div class="text-center pt-0 px-3">
        <p class="text-secondary-d3 text-125 mt-2" style="margin-top:-20px;">
            <b><?php echo $data_target['rows']['service']; ?></b>
        </p>
    </div>
    <div class="text-105">
        <span>Nomor HP <b><p class="text-right"><?php echo $data_target['rows']['phone']; ?></p></b></span><br>
        <span>Harga <b><p class="text-right">Rp. <?php echo number_format($data_target['rows']['price'],0,',','.'); ?></p></b></span><br>
        <span>Status <p class="text-right"><?php echo $data_target['rows']['status']; ?></p></span>
    </div>
    </card-body>
</card>
<br>
<center class="alert alert-info"><b>Terima Kasih Telah Menggunakan Layanan Kami. <br>Ini Dapat Digunakan Sebagai Bukti Pembayaran Yang Sah.</b></center>
<br>
<div class="card ccard bgc-black-tp10 mt-4 mt-md-0 overflow-hidden">
                  <div class="card-body p-0">
                    <div class="accordion" id="accordionExample4">
                      <div class="card border-0 -l5">
                        <div class="card-header border-0 bgc-transparent mb-0" id="headingOne4">
                          <h2 class="card-title bgc-transparent text-black-d2 brc-white">
                            <a class="d-style btn btn-white  btn-brc-tp btn-h-outline-green btn-a-outline-green accordion-toggle border-l-3 radius-0 collapsed" href="#collapseOne4" data-toggle="collapse" aria-expanded="false" aria-controls="collapseOne4">
                              <b>Detail Transaksi</b>
                              <!-- the toggle icon -->
                              <span class="v-collapsed px-3px  d-inline-block brc-black-l1 border-1 mr-3 text-center position-rc">
                                <i class="fa fa-angle-down toggle-icon w-2 mx-1px text-90"></i>
                                </span>
                              <span class="v-n-collapsed px-3px  d-inline-block bgc-black mr-3 text-center position-rc">
                                <i class="fa fa-angle-down toggle-icon w-2 mx-1px text-white text-90 pt-1px"></i>
                              </span>
                            </a>
                          </h2>
                        </div>

                        <div id="collapseOne4" class="collapse" aria-labelledby="headingOne4" data-parent="#accordionExample4">
                          <div class="card-body pt-1 text-dark-m1 border-l-3 brc-white -l5">
                            Saldo Yang Terpakai <p class="text-right"><b>Rp. <?php echo number_format($data_target['rows']['price'],0,',','.'); ?></b></p>
                            Tanggal <p class="text-right"><b><?php echo $data_target['rows']['date']; ?></b></p>
                            Waktu <p class="text-right"><b><?php echo $data_target['rows']['time']; ?></b></p>
                            No Refensi <p class="text-right"><b><?php echo $data_target['rows']['oid']; ?></b></p><hr>
                            No SN <p class="text-right"><b><?php echo $data_target['rows']['catatan']; ?></b></p>
                            Harga <p class="text-right"><b>Rp. <?php echo number_format($data_target['rows']['price'],0,',','.'); ?></b></p><hr>
                            Total Pembelian <p class="text-right"><b>Rp. <?php echo number_format($data_target['rows']['price'],0,',','.'); ?></b></p>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div><!-- /.card -->
<div class="card ccard" style="margin-top:20px;">
    <div class="card-body">
        <a href="<?php echo $config['web']['base_url']; ?>pages/contact" style="text-decoration: none;" class="item d-flex flex-wrap align-items-center my-2 bgc-secondary-l4 bgc-h-secondary-l3 radius-1 p-25 d-style">
            <span class="mr-25 w-4 h-4 overflow-hidden text-center border-1 brc-secondary-m2  d-zoom-2">
                <img alt="Cs" src="<?php echo $config['web']['base_url']; ?>dist/images/call-center-agent.png" class="h-4 w-4" />
            </span>
            <span class="text-black-d3 text-90 text-600">
                <b>Butuh Bantuan?</b><br><br>
                <p>Kunjungi Pusat Bantuan <?php echo $config['web']['title']; ?>, Yuk!</p>
            </span>
        </a>
    </div>
</div>
