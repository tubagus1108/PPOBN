<?php
require '../../../mainconfig.php';
require '../../../lib/check_session_admin.php';

if (!isset($_GET['id'])) {
	$result_msg = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Permintaan tidak diterima.');
} else {
	$data_target = $model->db_query($db, "*", "carousel", "id = '".mysqli_real_escape_string($db, $_GET['id'])."'");
	if ($data_target['count'] == 0) {
		$result_msg = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Data tidak ditemukan.');
		require '../../lib/result.php';
		exit();
	} else {
?>
<div id="modal-result" class="row"></div>
<form class="form-horizontal" method="POST" id="form-add" enctype="multipart/form-data">
	<div class="form-group">
		<input type="hidden" class="form-control" name="id" value="<?php echo $data_target['rows']['id'] ?>" readonly>
	</div>
	<div class="form-group">
		<label>Subject</label>
		<input class="form-control" name="subject" value="<?php echo $data_target['rows']['subject'] ?>">
	</div>
    <div class="form-group">
		<label>Title</label>
		<input class="form-control" name="title" value="<?php echo $data_target['rows']['title'] ?>">
	</div>
	<div class="form-group">
		<label>Label</label>
		<select class="form-control" name="label">
			<option value="0">Pilih...</option>
			<option value="Info" <?php echo ($data_target['rows']['type'] == 'Info') ? 'selected' : '' ?>>Info</option>
			<option value="Promo" <?php echo ($data_target['rows']['type'] == 'Promo') ? 'selected' : '' ?>>Promo</option>
			<option value="Maintenance" <?php echo ($data_target['rows']['type'] == 'Maintenance') ? 'selected' : '' ?>>Maintenance</option>
		</select>
	</div>
	<div class="form-group">
		<label>Catatan</label>
		<textarea class="form-control" name="content" rows="5" value="<?php echo $data_target['rows']['catatan'] ?>"></textarea>
	</div>
	<div class="form-group">
        <label class="mr-sm-2">Gambar Konten</label>
            <input name="file" type="file" value="<?php echo $data_target['rows']['image'] ?>">
    </div>
	<div class="form-group text-right">
			<button class="btn btn-danger" type="reset"><i class="fa fa-undo"></i> Reset</button>
			<button class="btn btn-success" name="edit" type="submit"><i class="fa fa-check"></i> Submit</button>
	</div>
</form>
<?php
	}
}
require '../../../lib/result.php';