<?php
require '../mainconfig.php';
require '../lib/check_session.php';
require '../lib/header.php';

if (!isset($_GET['id'])) {
	exit("No direct script access allowed!");
}
$data_target = $model->db_query($db, "*", "carousel", "id = '".mysqli_real_escape_string($db, $_GET['id'])."'");
if ($data_target['count'] == 0) {
	$result_msg = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Data tidak ditemukan.');
	require '../../lib/result.php';
	exit();
}
?>
<style type="text/css">
.dtu-grid{display:grid;grid-template-columns:repeat(3,1fr);grid-gap:10px;padding-left:0}@media only screen and (max-width:576px){.logo img{width:7em}.wrapper-home{padding-top:0}.header{justify-content:center}.header-home .header{justify-content:space-between}.header-sl{display:none}.header-home .header-sl{display:none}.promo-details-banner{position:relative;padding-bottom:90%}.promo-details-banner img{position:absolute;width:100%;height:100%;object-fit:cover;object-position:top}.periode-promo img{height:2em}.periode-promo span:nth-child(2) div:nth-child(1){font-size:.85em}.periode-promo span:nth-child(2) div:nth-child(2){font-size:.9em;line-height:1}.promo-details .ccc-rct{display:none}.ccc-title{font-size:1.375em;line-height:1;padding-bottom:.5em}.ccc-text{font-size:.875em}.promo-details .carousel-cover-cpt{position:relative;background:#fff!important;color:var(--darktext);padding:1em}.promo-title{padding:.25em .75em}.triple-promote .promoted-item{width:25%;margin:auto .375em}.multiple-promote{grid-template-columns:repeat(3,33.33%);padding:0 1em}.multiple-promote .promoted-item{padding:0 .35em}.promo-head{display:block}.periode-promo{justify-content:center;padding-bottom:1em}.snk-promo{display:flex;justify-content:center}.promoted{background:0 0;color:#fff}.header-home{background:0 0;-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none}.banner-cover.container,.content-white .container{padding:0;margin:0}.white-wrapper{padding-top:0;padding-bottom:1em}.big-banner{display:none}.small-banner{display:block}.grid-wrap{grid-template-columns:repeat(3,33.33%)}.direct-col{padding:1em 0}.direct-content{padding:1em 15px 3em;padding-top:0}.redeem-text{background:0 0;padding:0;padding-left:1em}.thank-wrapper{padding:0 1em 4em}.thank-snk.container{width:unset;margin:2em -15px 0}.thank-body{padding:2em 0 1em}.tb-thank-cc{display:block}.thank-cc-col{width:100%}.modal-dialog{margin:1rem}.content-pay{padding:0 1em 3em}.text-page{padding:0 1em 1em}.promo-snk{padding:2em 1em}.dtl-item{font-size:var(--fsmall)}.direct-inner{display:block}.direct-it-first,.direct-it-second{width:100%}.direct-it-second{padding-left:0}.dc-images{max-width:11em;max-height:11em}.direct-title{padding:1em 0 .5em;text-align:center}.dtu-grid{grid-template-columns:repeat(2,1fr)}.modal-ewall .modal-dialog{max-width:unset}.wrapper-kode-voucher{border-radius:0;margin-left:-1em;margin-right:-1em}.ribbon img{width:4em}}
</style>
<img src="<?= $config['web']['base_url']; ?>dist/images/banner/<?php echo $data_target['rows']['file']; ?>" class="d-block w-100" style="max-width:100%;margin-top: 56px;">
<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h5 class="card-title"><?= $data_target['rows']['label'] ?></h5>
                        </div>
                        <div class="iq-card-header-toolbar d-flex align-items-center">
                            <small class="text-muted">
                                <?php echo format_date(substr($data_target['rows']['created_at'], 0, -9)).", ".substr($data_target['rows']['created_at'], -8) ?>                            
                            </small>&nbsp;
                        </div>
                    </div>
                    <blockquote class="blockquote mb-0 card-body">
                    <p style="font-size:14px;"><?= nl2br($data_target['rows']['catatan']) ?></p>
                    </blockquote>
                    </div>

<?php
require '../lib/footer.php';
?>