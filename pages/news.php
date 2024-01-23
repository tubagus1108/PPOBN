<?php
require '../mainconfig.php';
require '../lib/check_session.php';
require '../lib/header.php';
?>
<div style="padding-top:30px;"></div>

<?php
$news = $model->db_query($db, "*", "news", null);
if ($news['count'] == 0) { ?>
<section class="wd-100 pt-3">
    <center><img src="<?php echo $config['web']['base_url']; ?>dist/images/ReminderNote _Monochromatic.png" style="width:500px;"></center>
    <center><b>Tidak Ada Berita / Informasi Saat Ini</b></center>
</section>
<? } else { ?>
                <?php
                    $news = $model->db_query($db, "*", "news", null, "id DESC");
                    if ($news['count'] == 1) { ?>
                    <div class="col-lg-6 offset-lg-3">
                        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
	                <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h5 class="card-title"><?php echo nl2br($news['rows']['subject']); ?></h5>
                        </div>
                        <div class="iq-card-header-toolbar d-flex align-items-center">
                            <small class="text-muted">
                                <?php echo format_date(substr($news['rows']['created_at'], 0, -9)).", ".substr($value['created_at'], -8) ?>                            
                            </small>&nbsp;
                        </div>
                    </div>
                    <blockquote class="blockquote mb-0 card-body">
                        <p style="font-size:14px;"><?php echo nl2br($news['rows']['content']); ?></p>
                    </blockquote>
                    </div>
                </div>
                    <?php
                    } else {
	                    foreach ($news['rows'] as $key => $value) {
                    ?>
                    <div class="col-lg-6 offset-lg-3">
                        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h5 class="card-title"><?php echo nl2br($value['subject']); ?></h5>
                        </div>
                        <div class="iq-card-header-toolbar d-flex align-items-center">
                            <small class="text-muted">
                                <?php echo format_date(substr($value['created_at'], 0, -9)).", ".substr($value['created_at'], -8) ?>                            
                            </small>&nbsp;
                        </div>
                    </div>
                    <blockquote class="blockquote mb-0 card-body">
                    <p style="font-size:14px;"><?php echo nl2br($value['content']); ?></p>
                    </blockquote>
                    </div>
                    </div>
                    <?php
	                   }
                    }
                    ?>
    </div>
<?php
}
require '../lib/footer.php';
?>