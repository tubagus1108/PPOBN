<?php
require '../../../mainconfig.php';
require '../../../lib/check_session_admin.php';
?>
<div id="modal-result" class="row"></div>
<form class="form-horizontal" method="POST" id="form-add" enctype="multipart/form-data">
    <div class="form-group">
		<label>Subject</label>
		<input class="form-control" name="subject">
	</div>
    <div class="form-group">
		<label>Title</label>
		<input class="form-control" name="title">
	</div>
    <div class="form-group">
		<label>Catatan</label>
		<textarea class="form-control" name="content" rows="5"></textarea>
	</div>
	<div class="form-group">
		<label>Label</label>
		<select class="form-control" name="label">
		    <option value="">--- Pilih Label Promo ---</option>
		    <option value="Promo">Promo</option>
		    <option value="Info">Info</option>
		    <option value="Maintenance">Maintance</option>
		</select>
	</div>
	<div class="form-group">
        <label class="mr-sm-2">Gambar Konten</label>
            <input name="file" type="file">
    </div>
	<div class="form-group text-right">
		<button class="btn btn-danger" type="reset"><i class="fa fa-undo"></i> Reset</button>
		<button class="btn btn-success" name="add" type="submit"><i class="fa fa-check"></i> Submit</button>
	</div>
</form>