<?php
require '../../../mainconfig.php';
require '../../../lib/check_session_admin.php';

if (!isset($_GET['id'])) {
	$result_msg = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Permintaan tidak diterima.');
} else {
	$data_target = $model->db_query($db, "*", "users", "id = '".mysqli_real_escape_string($db, $_GET['id'])."'");
	if ($data_target['count'] == 0) {
		$result_msg = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Data tidak ditemukan.');
	} else {
?>
<div id="modal-result" class="row"></div>
<form class="form-horizontal" method="POST" id="form">
	<div class="form-group">
		<input type="hidden" class="form-control" name="id" value="<?php echo $data_target['rows']['id'] ?>" readonly>
	</div>
	<div class="form-group">
		<label>Hak Akses</label>
		<select class="form-control" name="level">
			<option value="0">Pilih...</option>
			<option value="Member" <?php echo ($data_target['rows']['level'] == 'Member') ? 'selected' : '' ?>>Member</option>
			<option value="Developers" <?php echo ($data_target['rows']['level'] == 'Developers') ? 'selected' : '' ?>>Developers</option>
		</select>
	</div>
	<div class="form-group">
		<label>Username</label>
		<input type="text" class="form-control" value="<?php echo $data_target['rows']['username'] ?>" readonly>
	</div>
	<div class="form-group">
		<label>Password <small class="text-danger">*Kosongkan jika tidak diubah.</small></label>
		<input type="password" class="form-control" name="password">
	</div>
	<div class="form-group">
		<label>Nama Lengkap</label>
		<input type="text" class="form-control" name="full_name" value="<?php echo $data_target['rows']['full_name'] ?>">
	</div>
	<div class="form-group">
	    <label>Alamat Lengkap</label>
	    <input type="text" class="form-control" value="<?php echo $data_target['rows']['alamat'] ?>" disabled>
	</div>
	<div class="form-group">
		<label>Email</label>
		<input type="text" name="email" class="form-control" value="<?php echo $data_target['rows']['email'] ?>">
	</div>
	<div class="form-group">
		<label>Nomor HP</label>
		<input type="number" name="nomor" class="form-control" value="<?php echo $data_target['rows']['nomor'] ?>">
	</div>
	<div class="form-group">
		<label>Saldo</label>
		<input type="number" class="form-control" name="balance" value="<?php echo $data_target['rows']['balance'] ?>">
	</div>
    <div class="form-group">
        <?php if ($data_target['rows']['file'] == "") { ?> <? } else { ?><label>KTP</label><br><a href="<?php echo $config['web']['base_url'] ?>dist/images/ktp/<?= $data_target['rows']['file'] ?>"><img src="<?php echo $config['web']['base_url'] ?>dist/images/ktp/<?php echo $data_target['rows']['file'] ?>" style="max-width:200px;"><? } ?></a>
    </div>
	<div class="form-group">
		<label>Status</label>
		<select class="form-control" name="status">
			<option value="<?php echo $data_target['rows']['status']; ?>" <?php echo ($data_target['rows']['status'] == '1') ? 'selected' : '' ?>>Active</option>
			<option value="1">Active</option>
			<option value="0">Not Active</option>
		</select>
	</div>
	<div class="form-group">
		<label>Verifikasi</label>
		<select class="form-control" name="verifikasi">
			<option value="<?php echo $data_target['rows']['user_verif']; ?>" <?php echo ($data_target['rows']['user_verif'] == '1') ? 'selected' : '' ?>>Verifikasi</option>
			<option value="1">Verifikasi</option>
			<option value="0">Tidak Memverifikasi</option>
		</select>
	</div>
	<div class="form-group text-right">
			<button class="btn btn-danger" type="reset"> Reset</button>
			<button class="btn btn-success" name="edit" type="submit"> Submit</button>
	</div>
</form>
<?php
	}
}
require '../../../lib/result.php';