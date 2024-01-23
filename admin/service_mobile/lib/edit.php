<?php
require '../../../mainconfig.php';
require '../../../lib/check_session_admin.php';

if (!isset($_GET['id'])) {
	$result_msg = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Permintaan tidak diterima.');
} else {
	$data_target = $model->db_query($db, "*", "services_pulsa", "id = '".mysqli_real_escape_string($db, $_GET['id'])."'");
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
		<label>Type</label>
		<select class="form-control" name="category_id">
		<option value="0">Pilih salah satu...</option>
        <option value="Pulsa">Pulsa</option>
        <option value="Data">Data</option>
        <option value="E-Money">E-Money</option>
        <option value="Paket SMS dan Telpon">Paket SMS dan Telpon</option>
        <option value="PLN">PLN</option>
		</select>
	</div>
	<div class="form-group">
		<label>Kategori</label>
		<select class="form-control" name="operator">
			<option value="0">Pilih...</option>
        <?php
        $category = $model->db_query($db, "*", "service_type");
        if ($category['count'] == 1) {
	        $selected = ($data_target['rows']['oprator'] == $category['rows']['name']) ? 'selected' : '';
	        print('<option value="'.$category['rows']['name'].'" '.$selected.'>'.$data_target['rows']['name'].'</option>');
        } else {
            foreach ($category['rows'] as $key) {
	        $selected = ($data_target['rows']['oprator'] == $key['name']) ? 'selected' : '';
	        print('<option value="'.$key['name'].'" '.$selected.'>'.$key['name'].'</option>');
        }
    }
    ?>
		</select>
	</div>
	<div class="form-group">
		<label>Nama Layanan</label>
		<input type="text" class="form-control" name="service_name" value="<?php echo $data_target['rows']['service'] ?>">
	</div>
	<div class="form-group">
		<label>Keterangan</label>
		<textarea class="form-control" name="note"><?php echo $data_target['rows']['note'] ?></textarea>
	</div>
	<div class="form-group">
		<label>Harga</label>
		<input type="number" class="form-control" name="price" value="<?php echo $data_target['rows']['price'] ?>">
	</div>
	<div class="form-group">
		<label>Harga Agen</label>
		<input type="number" class="form-control" name="price_agen" value="<?php echo $data_target['rows']['price_agen'] ?>">
	</div>
	<div class="form-group">
		<label>Price Provider</label>
		<input type="number" class="form-control" name="price_provider" value="<?php echo $data_target['rows']['price_provider'] ?>">
	</div>
	<div class="form-group">
		<label>Bonus Poin</label>
		<input type="number" class="form-control" name="bonus_poin" value="<?php echo $data_target['rows']['bonus_poin'] ?>">
	</div>
	<div class="form-group">
		<label>API</label>
		<select class="form-control" name="provider_id">
			<option value="DIGIFLAZZ">Digiflazz</option>
		</select>
	</div>
	<div class="form-group">
		<label>ID Layanan API</label>
		<input type="text" class="form-control" name="provider_service_id" value="<?php echo $data_target['rows']['pid'] ?>">
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