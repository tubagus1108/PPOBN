<?php
require '../mainconfig.php';
require '../lib/check_session.php';
require '../lib/header.php';

$orders = mysqli_query($db, "SELECT SUM(orders.price) AS tamount, count(orders.id) AS tcount, orders.user_id, users.full_name FROM orders JOIN users ON orders.user_id = users.id WHERE MONTH(orders.created_at) = '".date('m')."' AND YEAR(orders.created_at) = '".date('Y')."' GROUP BY orders.user_id ORDER BY tamount DESC LIMIT 5");
$orders_mobile = mysqli_query($db, "SELECT SUM(orders_mobile.price) AS tamount, count(orders_mobile.id) AS tcount, orders_mobile.user, users.full_name FROM orders_mobile JOIN users ON orders_mobile.user = users.username WHERE MONTH(orders_mobile.date) = '".date('m')."' AND YEAR(orders_mobile.date) = '".date('Y')."' GROUP BY user ORDER BY tamount DESC LIMIT 5");
$orders_pascabayar = mysqli_query($db, "SELECT SUM(orders_pascabayar.price) AS tamount, count(orders_pascabayar.id) AS tcount, orders_pascabayar.user, users.full_name FROM orders_pascabayar JOIN users ON orders_pascabayar.user = users.username WHERE MONTH(orders_pascabayar.date) = '".date('m')."' AND YEAR(orders_pascabayar.date) = '".date('Y')."' GROUP BY user ORDER BY tamount DESC LIMIT 5");
$deposits = mysqli_query($db, "SELECT SUM(deposits.amount) AS tamount, count(deposits.id) AS tcount, deposits.user_id, users.full_name FROM deposits JOIN users ON deposits.user_id = users.id WHERE MONTH(deposits.created_at) = '".date('m')."' AND YEAR(deposits.created_at) = '".date('Y')."' AND deposits.status = 'Success' GROUP BY deposits.user_id ORDER BY tamount DESC LIMIT 5");
?>
<div class="row">
	<div class="col-lg-12 text-center" style="margin: 15px 0;">
		<h3 class="text-uppercase"><i class="fa fa-trophy fa-fw"></i> Pengguna Teratas</h3>
		<p>Dibawah ini merupakan top 10 pengguna dengan total pemesanan dan deposit tertinggi bulan ini.<br />Terimakasih telah menjadi pelanggan setia kami!</p>
	</div>
	<div class="col-md-6 grid-margin stretch-card">
	        <div class="card">
		        <div class="card-body">
                    <h4 class="card-title"> 10 Pengguna dengan Pesanan Terbanyak</h4>
						<div class="table-responsive">
							<table class="table">
								<tr>
									<th>PERINGKAT</th>
									<th>NAMA</th>
									<th>TOTAL</th>
								</tr>
                                <?php
                                $no = 1;
                                while($data = mysqli_fetch_array($orders)) {
                                if ($no == 1) {
                                ?> 
								<tr class="table-warning">
									<td><?php echo $no ?></td>
									<td><span class="badge badge-warning" style="margin-right: 5px;"><i class="fas fa-crown"></i></span><?php echo $data['full_name'] ?></td>
									<td>Rp <?php echo number_format($data['tamount'],0,',','.') ?> (<?php echo number_format($data['tcount'],0,',','.') ?>)</td>
								</tr>
                                <?php
                                } else { 
                                ?>
								<tr>
									<td><?php echo $no ?></td>
									<td><?php echo $data['full_name'] ?></td>
									<td>Rp <?php echo number_format($data['tamount'],0,',','.') ?> (<?php echo number_format($data['tcount'],0,',','.') ?>)</td>
								</tr>

                                <?php 
                                }
                                ?>
                                <?php
	                                $no++;
                                }
                                ?>
										</table>
									</div>
								</div>
							</div>
						</div>
		<div class="col-md-6 grid-margin stretch-card">
	        <div class="card">
		        <div class="card-body">
                    <h4 class="card-title"> 10 Pengguna dengan Deposit Terbanyak</h4>
						<div class="table-responsive">
							<table class="table">
											<tr>
												<th>PERINGKAT</th>
												<th>NAMA</th>
												<th>TOTAL</th>
											</tr>
											<?php
                                            $no = 1;
                                            while($data = mysqli_fetch_array($deposits)) {
                                            if ($no == 1) {
                                            ?> 
											<tr class="table-warning">
												<td><?php echo $no ?></td>
												<td><span class="badge badge-warning" style="margin-right: 5px;"><i class="fas fa-crown"></i></span><?php echo $data['full_name'] ?></td>
												<td>Rp <?php echo number_format($data['tamount'],0,',','.') ?> (<?php echo number_format($data['tcount'],0,',','.') ?>)</td>
											</tr>
                                            <?php
                                            } else { 
                                            ?>
											<tr>
												<td><?php echo $no ?></td>
												<td><?php echo $data['full_name'] ?></td>
												<td>Rp <?php echo number_format($data['tamount'],0,',','.') ?> (<?php echo number_format($data['tcount'],0,',','.') ?>)</td>
											</tr>
                                            <?php 
                                            }
                                            ?>
                                            <?php
	                                            $no++;
                                            }
                                            ?>
										</table>
									</div>
								</div>
							</div>
						</div>
						
			<div class="col-lg-12 text-center" style="margin: 15px 0;">
		        <h3 class="text-uppercase"><i class="fas fa-award fa-fw"></i>LAYANAN TERATAS</h3>
		        <p>Dibawah ini merupakan top 10 pengguna dengan total pemesanan dan deposit tertinggi bulan ini.<br />Terimakasih telah menjadi pelanggan setia kami!</p>
        	</div>
			<div class="col-md-12 grid-margin stretch-card">
	        <div class="card">
		        <div class="card-body">
                    <h4 class="card-title">TOP 10 Service</h4>
						<div class="table-responsive">
							<table class="table">
								<tr>
										<th>No.</th>
									    <th>Nama Layanan</th>
									    <th>Total Pembelian</th>
								</tr>
                                                <?php
                                                $tmonth = date("m");
                                                $tyear = date("Y");
                                                $query_order = "SELECT service_name, SUM(price) AS price FROM orders WHERE MONTH(created_at) = '$tmonth' AND YEAR(created_at) = '$tyear'  GROUP BY service_name, service_name ORDER BY price DESC LIMIT 20"; // edit
                                                $new_query = $query_order;
                                                $new_query = mysqli_query($db, $new_query);

                                                $no = 1;
                                                while ($data_order = mysqli_fetch_assoc($new_query)) {
                                                $service = $data_order['service_name'];

                                                $totalservice = mysqli_query($db, "SELECT * FROM orders WHERE MONTH(created_at) = '$tmonth' AND YEAR(created_at) = '$tyear'AND service_name = '$service'");
                                                $count_service = mysqli_num_rows($totalservice);
                                                ?> 
											<tr>
											    <?php
											    if ($no == 1) { ?>
												<td><?php echo $no ?></td>
												<td><span class="badge badge-warning" style="margin-right: 5px;"><i class="fas fa-award"></i></span><?php echo $data_order['service_name'] ?></td>
												<td><?php echo number_format($count_service,0,',','.') ?> Pesanan Sebesar Rp. <?php echo number_format($data_order['price'],0,',','.'); ?></td>
												<? } else { ?>
												<td><?php echo $no ?></td>
												<td><span class="badge badge-warning" style="margin-right: 5px;"></span><?php echo $data_order['service_name'] ?></td>
												<td><?php echo number_format($count_service,0,',','.') ?> Pesanan Sebesar Rp. <?php echo number_format($data_order['price'],0,',','.'); ?></td>
												<? } ?>
											</tr>

                                            <?php
                                            	$no++;
                                            }
                                            ?>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
<?php
require '../lib/footer.php';
?>