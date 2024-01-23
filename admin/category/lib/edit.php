<?php
require '../../../mainconfig.php';
require '../../../lib/check_session_admin.php';

if (!isset($_GET['id'])) {
	$result_msg = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Permintaan tidak diterima.');
} else {
	$data_target = $model->db_query($db, "*", "service_type", "id = '".mysqli_real_escape_string($db, $_GET['id'])."'");
	if ($data_target['count'] == 0) {
		$result_msg = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Data tidak ditemukan.');
	} else {
?>
<div id="modal-result" class="row"></div>
<form class="form-horizontal" method="POST" id="form-add">
	<div class="form-group">
		<input type="hidden" class="form-control" name="id" value="<?php echo $data_target['rows']['id'] ?>" readonly>
	</div>
	<div class="form-group">
		<label>Nama Kategori</label>
		<input type="text" class="form-control" name="name" value="<?php echo $data_target['rows']['name'] ?>">
	</div>
	<div class="form-group">
		<label>Status</label>
		<select class="form-control" name="type">
			<option value="<?php echo $data_target['rows']['type']; ?>" <?php echo ($data_target['rows']['type'] == $data_target['rows']['type']) ? 'selected' : '' ?>><?php echo $data_target['rows']['type']; ?> (Dipilih)</option>
			<option value="0" disabled>-------------------------</option>
			<option value="Pulsa">Pulsa</option>
            <option value="Data">Data</option>
            <option value="E-Money">E-Money</option>
            <option value="Paket SMS dan Telpon">Paket SMS dan Telpon</option>
            <option value="PLN">PLN</option>
		</select>
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