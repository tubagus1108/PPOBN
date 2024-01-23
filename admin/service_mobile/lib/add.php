<?php
require '../../../mainconfig.php';
require '../../../lib/check_session_admin.php';
?>
<div id="modal-result" class="row"></div>
<form class="form-horizontal" method="POST" id="form-add">
	<div class="form-group">
		<label>Kategori</label>
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
		<label>Nama Layanan</label>
		<input type="text" class="form-control" name="service_name">
	</div>
	<div class="form-group">
		<label>Operator</label>
		<select class="form-control" name="operator">
		<option value="0">Pilih...</option>
        <?php
        $category = $model->db_query($db, "*", "service_type");
        if ($category['count'] == 1) {
	        print('<option value="'.$category['rows']['name'].'">'.$category['rows']['name'].' ('.$category['rows']['type'].')</option>');
        } else {
        foreach ($category['rows'] as $key) {
	        print('<option value="'.$key['name'].'">'.$key['name'].' ('.$key['type'].')</option>');
        }
        }
        ?>
		</select>
		<small>(*Pilih sesuai dengan kategori ex: Kategori = Pulsa, Layanan = Pulsa XL 5.000, Maka Operator Pilih = XL(Pulsa))</small>
	</div>
	<div class="form-group">
		<label>Keterangan</label>
		<textarea class="form-control" name="note"></textarea>
	</div>
	<div class="form-group">
		<label>Price</label>
		<input type="number" class="form-control" name="price">
	</div>
	<div class="form-group">
		<label>Price Agen</label>
		<input type="number" class="form-control" name="price_agen">
	</div>
	<div class="form-group">
		<label>Price Provider</label>
		<input type="number" class="form-control" name="price_provider">
	</div>
	<div class="form-group">
		<label>Bonus Poin</label>
		<input type="number" class="form-control" name="bonus_poin">
	</div>
	<div class="form-group">
		<label>API</label>
		<select class="form-control" name="provider_id">
			<option value="0">Pilih...</option>
			<option value="DIGIFLAZZ">Digiflazz</option>
		</select>
	</div>
	<div class="form-group">
		<label>ID Layanan API</label>
		<input type="number" class="form-control" name="provider_service_id">
	</div>
	<div class="form-group text-right">
		<button class="btn btn-danger" type="reset"><i class="fa fa-undo"></i> Reset</button>
		<button class="btn btn-success" name="add" type="submit"><i class="fa fa-check"></i> Submit</button>
	</div>
</form>