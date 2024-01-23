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
									    <h4 class="card-title"> Data Pengguna</h4><br>
									    <a href="javascript:;" onclick="modal_open('add', '<?php echo $config['web']['base_url'] ?>admin/user/lib/add.php');" class="btn btn-success" style="margin-bottom: 15px"><i class="fa fa-plus-square"></i> Tambah</a>
										<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
										    <div class="row">
                                        		<div class="form-group col-lg-5">
                                        			<label>Filter Status</label>
                                        			<select class="form-control" name="status">
														<option value="">Semua</option>
														<option value="1">Active</option>
														<option value="0">Nonactive</option>
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
										    <p style="font-size:15px;color:red;">*Jika KTP sudah diupload silakan klik ubah untuk memverifikasi user (Klik Gambar Untuk Melihat).</p>
										<table class="table">
											<thead>
												<tr>
													<th>ID</th>
													<th>USERNAME</th>
													<th>NAMA</th>
													<th>NOMOR HANDPHONE</th>
													<th>SALDO</th>
													<th>TANGGAL</th>
													<th>KTP</th>
													<th>STATUS</th>
													<th>VERIFIKASI</th>
													<th>AKSI</th>
												</tr>
											</thead>
											<tbody>
											<?php
											while ($data_query = mysqli_fetch_assoc($new_query)) {
											$label = ($data_query['status'] == 1) ? 'success' : 'danger';
											$labels = ($data_query['user_verif'] == 1) ? 'success' : 'danger';
											?>
												<tr>
													<td><?php echo $data_query['id'] ?></td>
													<td><?php echo htmlspecialchars($data_query['username']) ?></td>
													<td><?php echo htmlspecialchars($data_query['full_name']) ?></td>
													<td><?php echo htmlspecialchars($data_query['nomor']) ?></td>
													<td>Rp <?php echo number_format($data_query['balance'],0,',','.') ?></td>
													<td><?php echo $data_query['created_at']; ?></td>
													<td><?php if ($data_query['file'] == "") { ?> Belum Upload KTP <? } else { ?><a href="<?php echo $config['web']['base_url'] ?>dist/images/ktp/<?= $data_query['file'] ?>"><img src="<?php echo $config['web']['base_url'] ?>dist/images/ktp/<?php echo $data_query['file'] ?>" style="max-width:100px;"></a><? } ?></td>
													<td><div class="btn-group mb-2">
														<button class="btn btn-outline-<?php echo $label; ?> btn-pill btn-elevate btn-elevate-air" aria-haspopup="true" aria-expanded="false"><?php echo $data_query['status'] == "1" ? 'Active' : 'Nonactive' ?> </button>
													</div></td>
													<td><div class="btn-group mb-2">
														<button class="btn btn-outline-<?php echo $labels; ?> btn-pill btn-elevate btn-elevate-air" aria-haspopup="true" aria-expanded="false"><?php echo $data_query['user_verif'] == "1" ? 'Verifikasi' : 'Belum Terverifikasi' ?> </button>
													</div></td>
													<td><a href="javascript:;" onclick="modal_open('edit', '<?php echo $config['web']['base_url'] ?>user/ubah/<?php echo $data_query['id'] ?>')" class="btn btn-sm bg-gradient-yellow">Ubah</a> <a href="javascript:;" onclick="modal_open('delete', '<?php echo $config['web']['base_url'] ?>user/hapus/<?php echo $data_query['id'] ?>')" class="btn btn-sm bg-gradient-red">Hapus</a></td>
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