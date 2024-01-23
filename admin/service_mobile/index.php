<?php
require '../../mainconfig.php';
require '../../lib/check_session_admin.php';
require 'lib/ajax_table.php';
require '../../lib/header_admin.php';
?>
	            <div class="row">
		            <div class="col-md-12 grid-margin stretch-card">
						<div class="card">
							<div class="card-body">
								<a href="javascript:;" onclick="modal_open('add', '<?php echo $config['web']['base_url'] ?>admin/service_mobile/lib/add.php');" class="btn btn-success" style="margin-bottom: 15px"><i class="fa fa-plus-square"></i> Tambah</a>
								<div class="card-box">
									<h4 class="card-title"> Data Layanan</h4>
									<br>
										<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
										    <div class="row">
                                        		<div class="form-group col-lg-3">
                                        			<label>Filter Kategori</label>
                                        			<select class="form-control" name="category">
														<option value="">Semua</option>
														<?php
														$check_cat = mysqli_query($db, "SELECT * FROM service_type ORDER BY name ASC");
														while ($data_cat = mysqli_fetch_assoc($check_cat)) {
														?>
														<option value="<?php echo $data_cat['id']; ?>"><?php echo $data_cat['name']; ?></option>
														<?php
														}
														?>		
													</select>
                                        		</div>
                                        		<div class="form-group col-lg-3">
                                        			<label>Cari Nama Layanan</label>
                                        			<input type="text" class="form-control" name="search" placeholder="Kata Kunci..." value="">
                                        		</div>
                                        		<div class="form-group col-lg-3">
                                        			<label>Cari ID Layanan</label>
                                        			<input type="text" class="form-control" name="search_sid" placeholder="Kata Kunci..." value="">
                                        		</div>
                                        		<div class="form-group col-lg-3">
                                        			<label>Submit</label>
                                        			<button type="submit" class="btn btn-block btn-dark">Filter</button>
                                        		</div>
                                        	</div>
								        </form>
										<div class="table-responsive">
										<table class="table">
											<thead>
												<tr>
													<th>ID</th>
													<th>KATEGORI</th>
													<th>NAMA LAYANAN</th>
													<th>HARGA</th>
													<th>HARGA AGEN</th>
													<th>BONUS POIN</th>
													<th>PROVIDER</th>
													<th>STATUS</th>
													<th>AKSI</th>
												</tr>
											</thead>
											<tbody>
											<?php
											while ($data_query = mysqli_fetch_assoc($new_query)) {
											$label = ($data_query['status'] == "Active") ? 'success' : 'danger';
											?>
												<tr>
													<td><?php echo $data_query['sid'] ?></td>
													<td><?php echo $data_query['type'] ?></td>
													<td><?php echo $data_query['service'] ?></td>
													<td>Rp <?php echo number_format($data_query['price'],0,',','.') ?></td>
													<td>Rp <?php echo number_format($data_query['price_agen'],0,',','.') ?></td>
													<td>Rp <?php echo number_format($data_query['bonus_poin'],0,',','.') ?></td>
													<td><?php echo $data_query['provider'] ?></td>
													<td><div class="btn-group mb-2">
														<button data-toggle="dropdown" class="btn btn-<?php echo $label ?> btn-sm dropdown-toggle" aria-haspopup="true" aria-expanded="false"><?php echo $data_query['status'] == "Active" ? 'Active' : 'Nonactive' ?> </button>
														<div class="dropdown-menu">
															<a class="dropdown-item" href="javascript:;" onclick="update_data('<?php echo $config['web']['base_url'] ?>admin/service_mobile/lib/status.php?id=<?php echo $data_query['id'] ?>&status=Active')">Active</a>
															<a class="dropdown-item" href="javascript:;" onclick="update_data('<?php echo $config['web']['base_url'] ?>admin/service_mobile/lib/status.php?id=<?php echo $data_query['id'] ?>&status=Not Active')">Nonactive</a>
														</div>
													</div></td>
													<td><a href="javascript:;" onclick="modal_open('edit', '<?php echo $config['web']['base_url'] ?>admin/service_mobile/lib/edit.php?id=<?php echo $data_query['id'] ?>')" class="btn btn-sm bg-gradient-yellow">Ubah</a> <a href="javascript:;" onclick="modal_open('delete', '<?php echo $config['web']['base_url'] ?>admin/service_mobile/lib/delete.php?id=<?php echo $data_query['id'] ?>')" class="btn btn-sm bg-gradient-red">Hapus</a></td>
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
	</div>
<?php
require '../../lib/footer_admin.php';
?>