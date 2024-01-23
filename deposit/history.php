<?php
require '../mainconfig.php';
require '../lib/check_session.php';
// query list for paging
if (isset($_GET['search']) AND isset($_GET['status'])) {
	if (!empty($_GET['search']) AND !empty($_GET['status'])) {
		$query_list = "SELECT * FROM deposits WHERE user_id = '".$_SESSION['login']."' AND method_name LIKE '%".protect_input($_GET['search'])."%' AND status LIKE '%".protect_input($_GET['status'])."%' ORDER BY id DESC"; // edit
	} else if (!empty($_GET['search'])) {
		$query_list = "SELECT * FROM deposits WHERE user_id = '".$_SESSION['login']."' AND method_name LIKE '%".protect_input($_GET['search'])."%' ORDER BY id DESC"; // edit
	} else if (!empty($_GET['status'])) {
		$query_list = "SELECT * FROM deposits WHERE user_id = '".$_SESSION['login']."' AND status LIKE '%".protect_input($_GET['status'])."%' ORDER BY id DESC"; // edit		
	} else {
		$query_list = "SELECT * FROM deposits WHERE user_id = '".$_SESSION['login']."' ORDER BY id DESC"; // edit
	}
} else {
	$query_list = "SELECT * FROM deposits WHERE user_id = '".$_SESSION['login']."' ORDER BY id DESC"; // edit
}
$new_quelist = mysqli_query($db, $query_list);
$data_querys = mysqli_fetch_assoc($new_quelist);
if (isset($_POST['upload'])) {
	    
	    $ekstensi_diperbolehkan	= array('png','jpg', 'jpeg');
		$nama = $_FILES['file']['name'];
		$x = explode('.', $nama);
		$ekstensi = strtolower(end($x));
		$ukuran	= $_FILES['file']['size'];
		$file_tmp = $_FILES['file']['tmp_name'];
		
		$input_post = array(
		    'file' => $_FILES['file']['name'],
		); 
		if (check_empty($input_post) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Input Tidak Boleh Kosong"});</script>');
		} elseif(in_array($ekstensi, $ekstensi_diperbolehkan) !== true) {
		    $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Ekstensi File Tidak Diperbolehkan"});</script>');
		} elseif($ukuran > 5044070) {
		    $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Ukuran File Terlalu Besar"});</script>');
		} else {
			if ($model->db_update($db, "deposits", $input_post, "id = '".$data_querys['id']."'") == true) {
			    move_uploaded_file($file_tmp, '../dist/images/bukti/'.$nama);
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "success",title: "Berhasil!",text: "Berhasil Upload Bukti Transfer"});</script>');
			} else {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Database Error"});</script>');
			}
		}
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
require '../lib/header.php';
?>

<?php
if ($total == 0) { ?>
<section class="wd-100 pt-3">
    <center><img src="<?php echo $config['web']['base_url']; ?>dist/images/Bank note_Monochromatic.png" style="width:500px;"></center>
    <center><b>Tidak Dapat Menemukan Data Pengisian Saldo</b></center>
</section>
<? } else { ?>
	<div class="row">
        <div class="col-md-12 grid-margin stretch-card">
	        <div class="card">
		        <div class="card-body">
			        <center style="color: #12as1;font-size: 16px;font-weight: bold;padding-top:12px;">Riwayat Pengisian Saldo</center><br>
									<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
										<div class="row">
                                        	<div class="form-group col-lg-5">
                                        		<label>Filter Status</label>
                                        		<select class="form-control" name="status">
                                        			<option value="">Semua</option>
                                                   	<option value="Pending" >Pending</option>
                                                    <option value="Processing" >Processing</option>
                                                    <option value="Success" >Success</option>
                                                    <option value="Error" >Error</option>
                                                    <option value="Partial" >Partial</option>
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
													<th>PEMBAYARAN</th>
													<th>JENIS</th>
													<th>JENIS SALDO</th>
													<th>METODE</th>
													<th>JUMLAH BAYAR</th>
													<th>SALDO DITERIMA</th>
													<th style="max-width: 200px;">KETERANGAN</th>
													<th>BUKTI TRANSFER</th>
													<th>STATUS</th>
												</tr>
										</thead>
										<tbody>
										<?php	
										while ($data_query = mysqli_fetch_assoc($new_query)) {
										if($data_query['status'] == "Pending") {
											$label = "warning";
										} else if($data_query['status'] == "Canceled") {
											$label = "danger";
										} else if($data_query['status'] == "Success") {
											$label = "success";
										}
										?>
                                        	<tr>
												<td><?php echo $data_query['id'] ?></td>
												<td><?php echo format_date(substr($data_query['created_at'], 0, -9)).", ".substr($data_query['created_at'], -8) ?></td>
												<td><?php echo $data_query['payment'] == "bank" ? 'Transfer Bank' : 'Transfer Pulsa' ?></td>
												<td><?php echo $data_query['type'] == "auto" ? 'Otomatis' : 'Manual' ?></td>
												<td><?php echo $data_query['tipe_saldo']; ?></td>
												<td><?php echo $data_query['method_name'] ?></td>
												<td>Rp <?php echo number_format($data_query['post_amount'],0,',','.') ?></td>
												<td>Rp <?php echo number_format($data_query['amount'],0,',','.') ?></td>
												<td><?php echo $data_query['note'] ?></td>
												<td><? if ($data_query['file'] == "" AND $data_query['method_name'] !== "BCA") { ?> <form method="post" class="form-control" enctype="multipart/form-data"><input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>"><div class="form-group"><input type="file" name="file" required><button type="submit" name="upload" class="btn btn-primary btn-sm">Upload</button></div></form><br> <? } elseif ($data_query['method_name'] !== "BCA" AND $data_query['file'] == true) { ?> <a href="<?php echo $config['web']['base_url'] ?>dist/images/bukti/<?= $data_query['file'] ?>"><img src="<?php echo $config['web']['base_url'] ?>dist/images/bukti/<?= $data_query['file'] ?>" style="max-width:100px;"></a> <? } else { ?> Otomatis <? } ?></td>
												<td><span class="btn btn-outline-<?php echo $label; ?> btn-pill btn-elevate btn-elevate-air"><?php echo $data_query['status'] ?></span></td>
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