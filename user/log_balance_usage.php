<?php
require '../mainconfig.php';
require '../lib/check_session.php';
// query list for paging

$query_list = "SELECT * FROM balance_logs WHERE user_id = '".$_SESSION['login']."' ORDER BY id DESC"; // edit
$records_per_page = 30; // edit
$starting_position = 0;
if(isset($_GET["page"])) {
	$starting_position = ($_GET["page"]-1) * $records_per_page;
}
$new_query = $query_list." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query); 
$total = mysqli_num_rows($new_query);
// 
require '../lib/header.php';
?>
<?php
if ($total == 0) { ?>
<section class="wd-100 pt-3">
    <center><img src="<?php echo $config['web']['base_url']; ?>dist/images/Bank note_Monochromatic.png" style="width:500px;"></center>
    <center><b>Tidak Dapat Menemukan Data Log Saldo</b></center>
</section>
<? } else { ?>
						<div class="row">
							<div class="col-md-12 grid-margin stretch-card">
								<div class="card">
								    <div class="card-body">
									<center style="color: #12as1;font-size: 16px;font-weight: bold;padding-top:12px;">Log Saldo</center>
									<div class="table-responsive">
										<table class="table" >
											<thead>
												<tr>
													<th>ID</th>
													<th>TANGGAL/WAKTU</th>
													<th>TIPE</th>
													<th>JUMLAH SALDO</th>
													<th>KETERANGAN</th>
												</tr>
											</thead>
											<tbody>
										<?php	
										while ($data_query = mysqli_fetch_assoc($new_query)) {
										if ($data_query['type'] == 'minus') {
											$label = "danger";
											$balance_type = "KURANG"; 
										} else {
											$label = "success";
											$balance_type = "TAMBAH";
										}
										?>
                                        	<tr class="table-<?php echo $label; ?>">
												<td><?php echo $data_query['id'] ?></td>
												<td><?php echo format_date(substr($data_query['created_at'], 0, -9)).", ".substr($data_query['created_at'], -8) ?></td>
												<td><?php echo $balance_type ?></td>
												<td><?php echo number_format($data_query['amount'],0,',','.') ?></td>
												<td><?php echo $data_query['note'] ?></td>
											</tr>
                                        </tbody>
										<?php
										}
										?>
										</table>
										<?php
                                    	require '../lib/pagination.php';
                                        }
                                    	?>
									</div>
								</div>
							</div>
						</div>
					</div>
<?php
require '../lib/footer.php';
?>