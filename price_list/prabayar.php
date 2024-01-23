<?php
require("../mainconfig.php");
require("../lib/header.php");
// query list for paging
if (isset($_GET['search']) AND isset($_GET['category'])) {
	if (!empty($_GET['search']) AND !empty($_GET['category'])) {
		$query_list = "SELECT * FROM services_pulsa WHERE service LIKE '%".protect_input($_GET['search'])."%' AND oprator LIKE '%".protect_input($_GET['category'])."%' AND status = 'Active' ORDER BY price ASC"; // edit
	} else if (!empty($_GET['search'])) {
		$query_list = "SELECT * FROM services_pulsa WHERE service LIKE '%".protect_input($_GET['search'])."%' AND status = 'Active' ORDER BY price ASC"; // edit
	} else if (!empty($_GET['category'])) {
		$query_list = "SELECT * FROM services_pulsa WHERE oprator LIKE '%".protect_input($_GET['category'])."%' AND status = 'Active' ORDER BY price ASC"; // edit		
	} else {
		$query_list = "SELECT * FROM services_pulsa WHERE status = 'Active' ORDER BY oprator ASC"; // edit
	}
} else {
	$query_list = "SELECT * FROM services_pulsa WHERE status = 'Active' ORDER BY oprator ASC"; // edit
}
$records_per_page = 30; // edit

$starting_position = 0;
if(isset($_GET["page"])) {
	$starting_position = ($_GET["page"]-1) * $records_per_page;
}
$new_query = $query_list." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query);
$data_rows = mysqli_num_rows($new_query);
//     
?>
	<div class="row">
        <div class="col-md-12 grid-margin stretch-card">
	        <div class="card">
		        <div class="card-body">
                        <center style="color: #12as1;font-size: 16px;font-weight: bold;padding-top:12px;">Daftar Harga</center>
                                        <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
										    <div class="row">
                                        		<div class="form-group col-lg-5">
                                        			<label>Filter Kategori</label>
                                        			<select class="form-control" name="category">
														<option value="">Semua</option>
														<?php
														$check_cat = mysqli_query($db, "SELECT * FROM service_type ORDER BY name ASC");
														while ($data_cat = mysqli_fetch_assoc($check_cat)) {
														?>
														<option value="<?php echo $data_cat['code']; ?>"><?php echo $data_cat['name']; ?> (<?php echo $data_cat['type']; ?>)</option>
														<?php
														}
														?>								    
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
														<th>KATEGORI</th>
														<th>LAYANAN</th>
														<th>HARGA</th>
														<th>STATUS</th>
													</tr>
												</thead>
												<tbody>
												<?php
												$old_provider = "";
												if($data_rows >= 1){
												while ($data_query = mysqli_fetch_assoc($new_query)) {
												    if ($data_query['status'] == "Active") {
												        $status = "Normal";
												    } else {
												        $status = "Gangguan";
												    }
												    if($data_query['oprator'] <> $old_provider){
					                                   $old_provider = $data_query['oprator'];
					                            ?> 
				                                <tr> 
					                                <th colspan="4"><center style="color: #12as1;font-size: 14px;font-weight: bold;padding-top:12px;"><?php echo($data_query['oprator']) ;  ?></center> </th>
				                                </tr> 
				                                <?php 
				                                } 
				                                ?> 
													<tr>
														<td><?php echo $data_query['id']; ?></td>
														<td><?php echo $data_query['oprator']; ?></td>
														<td><?php echo $data_query['service']; ?></td>
														<td>Rp <?php echo number_format($data_query['price'],0,',','.'); ?></td>
														<?php if ($data_query['status'] == "Not Active") { ?><td class="btn btn-outline-danger btn-pill btn-elevate btn-elevate-air"><?php echo $status; ?></td><? } else { ?><td class="btn btn-outline-success btn-pill btn-elevate btn-elevate-air"><?php echo $status; ?></td> <? } ?>
														</tr>
												<?php
												}
												}
												?>
										</tbody>	
										</table>
										<?php include("../lib/pagination.php"); ?>
										</div>
										</div>
									</div>
							</div>
						</div>
						<!-- end row -->
<?php
require("../lib/footer.php");
?>