<?php
require '../../mainconfig.php';
require '../../lib/check_session.php';
require '../../lib/is_login.php';
// query list for paging
if (isset($_GET['search']) AND isset($_GET['status'])) {
	if (!empty($_GET['search']) AND !empty($_GET['status'])) {
		$query_list = "SELECT * FROM orders_mobile WHERE user = '".$login['username']."' AND id LIKE '%".protect_input($_GET['search'])."%' AND status LIKE '%".protect_input($_GET['status'])."%' ORDER BY id DESC"; // edit
	} else if (!empty($_GET['search'])) {
		$query_list = "SELECT * FROM orders_mobile WHERE user = '".$login['username']."' AND id LIKE '%".protect_input($_GET['search'])."%' ORDER BY id DESC"; // edit
	} else if (!empty($_GET['status'])) {
		$query_list = "SELECT * FROM orders_mobile WHERE user = '".$login['username']."' AND status LIKE '%".protect_input($_GET['status'])."%' ORDER BY id DESC"; // edit		
	} else {
		$query_list = "SELECT * FROM orders_mobile WHERE user = '".$login['username']."' ORDER BY id DESC"; // edit
	}
} else {
	$query_list = "SELECT * FROM orders_mobile WHERE user = '".$login['username']."' ORDER BY id DESC"; // edit
}
$records_per_page = 30; // edit

$starting_position = 0;
if(isset($_GET["page"])) {
	$starting_position = ($_GET["page"]-1) * $records_per_page;
}
$new_query = $query_list." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query);
$total = mysqli_num_rows($new_query);
// 
require '../../lib/header.php';
?>

<?php
if ($total == 0) { ?>
<section class="wd-100 pt-3">
    <center><img src="<?php echo $config['web']['base_url']; ?>dist/images/Bank note_Monochromatic.png" style="width:500px;"></center>
    <center><b>Tidak Dapat Menemukan Data Transaksi</b></center>
</section>
<? } else { ?>
	<div class="row">
        <div class="col-md-12 grid-margin stretch-card">
	        <div class="card">
		        <div class="card-body">
			        <center style="color: #12as1;font-size: 16px;font-weight: bold;padding-top:12px;">Riwayat Transaksi Prabayar</center><br>
									<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
										<div class="row">
                                        	<div class="form-group col-lg-5">
                                        		<label>Filter Status</label>
                                        		<select class="form-control" name="status">
                                        			<option value="">Semua</option>
                                                   	<option value="Pending" >Pending</option>
                                                    <option value="Success" >Success</option>
                                                    <option value="Error" >Error</option>
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
								    <font color= "red">Geser jika lihat dari HP</font>
									<div class="table-responsive">
										<table class="table">
										<thead>
												<tr>
													<th>ID</th>
													<th>TANGGAL/WAKTU</th>
													<th style="max-width: 200px;">LAYANAN</th>
													<th>NOMOR PELANGGAN</th>
													<th>SN (KETERANGAN)</th>
													<th>HARGA</th>
													<th>STATUS</th>
													<th>REFUND</th>
													<th>STRUK</th>
												</tr>
										</thead>
										<tbody>
										<?php	
										while ($data_query = mysqli_fetch_assoc($new_query)) {
										if($data_query['status'] == "Pending") {
											$label = "warning";
										} else if($data_query['status'] == "Canceled" OR $data_query['status'] == "Error") {
											$label = "danger";
										} else if($data_query['status'] == "Success") {
											$label = "success";
										}
										?>
                                        	<tr>
												<td><?php echo $data_query['id'] ?></td>
												<td><?php echo $data_query['date']; ?> <?php echo $data_query['time']; ?></td>
												<td><?php echo $data_query['service']; ?></td>
												<td><?php echo $data_query['phone']; ?></td>
												<td><?php echo $data_query['catatan']; ?></td>
												<td>Rp. <?php echo number_format($data_query['price'],0,',','.') ?></td>
												<td><span class="btn btn-outline-<?php echo $label; ?> btn-pill btn-elevate btn-elevate-air"><?php echo $data_query['status'] ?></span></td>
												<td><?php echo $data_query['refund'] == "1" ? 'Yes' : 'No' ?></td>
												<td align="center"><a href="<?php echo $config['web']['base_url'] ?>pembelian/berhasil/<?php echo $data_query['poid']; ?>"<i class="fa fa-receipt fa-5x"></i></td>
											</tr>
                                        </tbody>
										<?php
										}
										?>
										</table>
										<?php
                                        require '../../lib/pagination.php';
                                        }
                                        ?>
								</div>
							</div>
						</div>
					</div>
				</div>
<?php
require '../../lib/footer.php';
?>