<?php
require '../../mainconfig.php';
require '../../lib/check_session_admin.php';
require 'lib/ajax_table.php';
require '../../lib/header_admin.php';
?>
	<div class="row">
        <div class="col-md-12 grid-margin stretch-card">
	        <div class="card">
		        
							<a href="javascript:;" onclick="modal_open('add', '<?php echo $config['web']['base_url'] ?>admin/carousel/lib/add.php');" class="btn btn-success" style="margin-bottom: 15px"><i class="fa fa-plus-square"></i> Tambah</a>
								<div class="card-body">
			        <h4 class="card-title"> Berita & Informasi (Banner) </h4>
										<div class="table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th>ID</th>
													<th style="max-width: 100px;">TANGGAL/WAKTU</th>
													<th>TITLE</th>
													<th>SUBJECT</th>
													<th>LABEL</th>
													<th>CONTENT</th>
													<th>IMAGE</th>
													<th>AKSI</th>
												</tr>
											</thead>
											<tbody>
											<?php
											while ($data_query = mysqli_fetch_assoc($new_query)) {
											?>
												<tr>
													<td><?php echo $data_query['id'] ?></td>
													<td><?php echo format_date(substr($data_query['created_at'], 0, -9)).", ".substr($data_query['created_at'], -8) ?></td>
													<td><?php echo $data_query['title']; ?></td>
													<td><?php echo $data_query['subject']; ?></td>
													<td><?php echo $data_query['label']; ?></td>
													<td><?php echo nl2br($data_query['catatan']) ?></td>
													<td><a href="<?php echo $config['web']['base_url']; ?>dist/images/banner/<?php echo $data_query['file']; ?>" target="_blank"><img src="<?php echo $config['web']['base_url']; ?>dist/images/banner/<?php echo $data_query['file']; ?>" style="border-radius: 9px; widht:150px; height:50px;"></a></td>
													<td><a href="javascript:;" onclick="modal_open('edit', '<?php echo $config['web']['base_url'] ?>admin/carousel/lib/edit.php?id=<?php echo $data_query['id'] ?>')" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a> <a href="javascript:;" onclick="modal_open('delete', '<?php echo $config['web']['base_url'] ?>admin/carousel/lib/delete.php?id=<?php echo $data_query['id'] ?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>
												</tr>
											<?php
											}
											?>
											</tbody>	
										</table>
										<?php include("../../lib/pagination.php"); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
require '../../lib/footer_admin.php';
?>