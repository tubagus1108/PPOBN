<?php
require '../../mainconfig.php';
require '../../lib/check_session_admin.php';
require '../../lib/header_admin.php';
?>
	<div class="row">
        <div class="col-md-12 grid-margin stretch-card">
	        <div class="card">
		        <div class="card-body">
			        <h4 class="card-title"> Kelola Halaman</h4>
										<div class="table-responsive">
										<table class="table" id="dataTableExample">
											<thead>
												<tr>
													<th width="50%">HALAMAN</th>
													<th>AKSI</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>Kontak</td>
													<td><a href="<?php echo $config['web']['base_url'] ?>admin/page/edit.php?id=1" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a></td>
												</tr>
												<tr>
													<td>Ketentuan Layanan</td>
													<td><a href="<?php echo $config['web']['base_url'] ?>admin/page/edit.php?id=2" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a></td>
												</tr>
												<tr>
													<td>Pertanyaan Umum</td>
													<td><a href="<?php echo $config['web']['base_url'] ?>admin/page/edit.php?id=3" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a></td>
												</tr>
											</tbody>
										</table>
										</div>
									</div>
								</div>
							</div>
						</div>
<?php
require '../../lib/footer.php';
?>