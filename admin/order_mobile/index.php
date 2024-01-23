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
			                            <h4 class="card-title"> Data Pesanan</h4>
										<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
										    <div class="row">
                                        		<div class="form-group col-lg-5">
                                        			<label>Filter Status</label>
                                        			<select class="form-control" name="status">
														<option value="">Semua</option>
														<option value="Pending">Pending</option>
														<option value="Processing">Processing</option>
														<option value="Error">Error</option>
														<option value="Partial">Partial</option>
														<option value="Success">Success</option>
													</select>
                                        		</div>
                                        		<div class="form-group col-lg-5">
                                        			<label>Kata Kunci Cari</label>
                                        			<input type="text" class="form-control" name="search" placeholder="Kata Kunci..." value="">
                                        		</div>
                                        		<div class="form-group col-lg-2">
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
														<th>TANGGAL/WAKTU</th>
														<th>PENGGUNA</th>
														<th>LAYANAN</th>
														<th style="max-width: 100px;">DATA</th>
														<th>HARGA</th>
														<th>PROVIDER ORDER ID</th>
														<th>NO REFERENSI / SN</th>
														<th>STATUS</th>
													</tr>
											</thead>
											<tbody>
											<?php
											while ($data_query = mysqli_fetch_assoc($new_query)) {
											if($data_query['status'] == "Pending") {
												$label = "warning";
											} else if($data_query['status'] == "Processing") {
												$label = "info";
											} else if($data_query['status'] == "Error" OR $data_query['status'] == "Partial") {
												$label = "danger disabled";
											} else if($data_query['status'] == "Success") {
												$label = "success disabled";
											}
											?>
												<tr>
													<td><?php echo $data_query['id'] ?></td>
													<td><?php echo $data_query['date']; ?> / <?php echo $data_query['time']; ?></td>
													<td><?php echo htmlspecialchars($data_query['user']) ?></td>
													<td><?php echo htmlspecialchars($data_query['service']) ?></td>
													<td><?php echo htmlspecialchars($data_query['phone']) ?></td>
													<td>Rp <?php echo number_format($data_query['price'],0,',','.') ?></td>
													<td><?php echo $data_query['oid'] ?></td>
													<td><?php echo $data_query['catatan']; ?></td>
													<td><div class="btn-group mb-2">
														<button data-toggle="dropdown" class="btn btn-<?php echo $label ?> btn-sm dropdown-toggle" aria-haspopup="true" aria-expanded="false"><?php echo $data_query['status'] ?> </button>
														<div class="dropdown-menu">
															<a class="dropdown-item" href="javascript:;" onclick="update_data('<?php echo $config['web']['base_url'] ?>admin/order_mobile/lib/status.php?id=<?php echo $data_query['id'] ?>&status=Success')">Success</a>
															<a class="dropdown-item" href="javascript:;" onclick="update_data('<?php echo $config['web']['base_url'] ?>admin/order_mobile/lib/status.php?id=<?php echo $data_query['id'] ?>&status=Error')">Error</a>
															<a class="dropdown-item" href="javascript:;" onclick="update_data('<?php echo $config['web']['base_url'] ?>admin/order_mobile/lib/status.php?id=<?php echo $data_query['id'] ?>&status=Partial')">Partial</a>
															<a class="dropdown-item" href="javascript:;" onclick="update_data('<?php echo $config['web']['base_url'] ?>admin/order_mobile/lib/status.php?id=<?php echo $data_query['id'] ?>&status=Processing')">Processing</a>
															<a class="dropdown-item" href="javascript:;" onclick="update_data('<?php echo $config['web']['base_url'] ?>admin/order_mobile/lib/status.php?id=<?php echo $data_query['id'] ?>&status=Pending')">Pending</a>
														</div>
													</div></td>
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