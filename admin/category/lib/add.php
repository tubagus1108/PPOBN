<?php
require '../../../mainconfig.php';
require '../../../lib/check_session_admin.php';
?>
<div id="modal-result" class="row"></div>
<form class="form-horizontal" method="POST" id="form-add">
	<div class="form-group">
		<label>Nama Kategori</label>
		<input type="text" class="form-control" name="name">
	</div>
	<label>Type</label>
	<select style="border-radius: .40rem" class="form-control" name="type">
        <option value="0">Pilih salah satu...</option>
        <option value="Pulsa">Pulsa</option>
        <option value="Data">Data</option>
        <option value="E-Money">E-Money</option>
        <option value="Paket SMS dan Telpon">Paket SMS dan Telpon</option>
        <option value="PLN">PLN</option>
	</select><br>
	<div class="form-group text-right">
		<button class="btn btn-danger" type="reset"><i class="fa fa-undo"></i> Reset</button>
		<button class="btn btn-success" name="add" type="submit"><i class="fa fa-check"></i> Submit</button>
	</div>
</form>