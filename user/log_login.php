<?php
require '../mainconfig.php';
require '../lib/check_session.php';
// query list for paging
if (isset($_GET['search'])) {
	if (!empty($_GET['search'])) {
		$query_list = "SELECT * FROM login_logs WHERE user_id = '".$_SESSION['login']."' AND ip_address LIKE '%".protect_input($_GET['search'])."%' ORDER BY id DESC"; // edit
	} else {
		$query_list = "SELECT * FROM login_logs WHERE user_id = '".$_SESSION['login']."' ORDER BY id DESC"; // edit
	}
} else {
	$query_list = "SELECT * FROM login_logs WHERE user_id = '".$_SESSION['login']."' ORDER BY id DESC"; // edit
}
$records_per_page = 30; // edit

$starting_position = 0;
if(isset($_GET["page"])) {
	$starting_position = ($_GET["page"]-1) * $records_per_page;
}
$new_query = $query_list." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query); 
// 
require '../lib/header.php';
?>
						<div class="row">
							<div class="col-md-12 grid-margin stretch-card">
								<div class="card">
								    <div class="card-body">
									<h4 class="card-title"><i class="fa fa-file"></i> Log Masuk</h4>
									<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
										<div class="row">
                                        	<div class="form-group col-lg-5">
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
													<th>ALAMAT IP</th>
												</tr>
											</thead>
											<tbody>
										<?php	
										while ($data_query = mysqli_fetch_assoc($new_query)) {
										?>
                                        	<tr class="table-<?php echo $label; ?>">
												<td><?php echo $data_query['id'] ?></td>
												<td><?php echo format_date(substr($data_query['created_at'], 0, -9)).", ".substr($data_query['created_at'], -8) ?></td>
												<td><?php echo $data_query['ip_address'] ?></td>
											</tr>
                                        </tbody>
										<?php
										}
										?>
										</table>
										<?php
                                    	require '../lib/pagination.php';
                                    	?>
									</div>
								</div>
							</div>
						</div>
					</div>
<?php
require '../lib/footer.php';
?>