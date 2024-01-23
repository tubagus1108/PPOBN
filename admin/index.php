<?php

require '../mainconfig.php';
require '../lib/check_session_admin.php';
require '../lib/header_admin.php';
?>
<div class="row">
    <div class="col-lg-12 text-center" style="margin: 5px;">
		<h3 class="text-uppercase"><i class="fa fa-user-circle-o fa-fw"></i> Informasi Panel</h3>
	</div>
	<div class="col-sm-12 col-lg-6">
	    <div class="row">
		    <div class="col-12" style="margin-top: 10px;">
		        <div class="row">
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h5>Rp <?php echo number_format($model->db_query($db, "SUM(balance) as total", "users", "level = 'Member' OR level = 'Reseller' OR level = 'Agen'")['rows']['total'],0,',','.') ?> (<?php echo number_format($model->db_query($db, "*", "users", "level = 'Member'")['count'],0,',','.') ?>)</h5>

                <p>Total Saldo Pengguna</p>
              </div>
              <div class="icon">
                <i class="ri-wallet-2-fill"></i>
              </div>
              <a href="<?php echo $config['web']['base_url']; ?>admin/user" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h5>Rp <?php echo number_format($model->db_query($db, "SUM(amount) as total", "deposits")['rows']['total'],0,',','.') ?> (<?php echo number_format($model->db_query($db, "*", "deposits")['count'],0,',','.') ?>)</h5>

                <p>Total Deposit</p>
              </div>
              <div class="icon">
                <i class="ri-coins-fill"></i>
              </div>
              <a href="<?php echo $config['web']['base_url']; ?>admin/deposit" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h5>Rp <?php echo number_format($model->db_query($db, "SUM(price) as total", "orders_pascabayar")['rows']['total'],0,',','.') ?> (<?php echo number_format($model->db_query($db, "*", "orders_pascabayar")['count'],0,',','.') ?>)</h5>
                <p>Total Pesanan Pascabayar</p>
              </div>
              <div class="icon">
                <i class="ri-shopping-bag-3-fill"></i>
              </div>
              <a href="<?php echo $config['web']['base_url']; ?>admin/order_pascabayar" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h5>Rp <?php echo number_format($model->db_query($db, "SUM(price) as total", "orders_mobile")['rows']['total'],0,',','.') ?> (<?php echo number_format($model->db_query($db, "*", "orders_mobile")['count'],0,',','.') ?>)</h5>

                <p>Total Pesanan Prabayar</p>
              </div>
              <div class="icon">
                <i class="ri-shopping-cart-fill"></i>
              </div>
              <a href="<?php echo $config['web']['base_url']; ?>admin/order_mobile" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h5>Rp <?php echo number_format($model->db_query($db, "SUM(price) as total", "orders")['rows']['total'],0,',','.') ?> (<?php echo number_format($model->db_query($db, "*", "orders")['count'],0,',','.') ?>)</h5>

                <p>Total Pesanan Social Media</p>
              </div>
              <div class="icon">
                <i class="ri-shopping-cart-fill"></i>
              </div>
              <a href="<?php echo $config['web']['base_url']; ?>admin/order" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-6 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h5><?php echo number_format($model->db_query($db, "*", "users", "level = 'Member'")['count'],0,',','.') ?></h5>
                <p>Total Member</p>
              </div>
              <div class="icon">
                <i class="ri-user-5-fill"></i>
              </div>
              <a href="<?php echo $config['web']['base_url']; ?>admin/user" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        
        <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Grafik 7 Hari Terakhir (Pesanan Social Media)</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                </div>
                <div class="card-body">
                <div class="chart">
                  <div id="order-sosmed" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            
				<div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Grafik 7 Hari Terakhir (Pesanan Prabayar)</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                </div>
                <div class="card-body">
                <div class="chart">
                  <div id="order-prabayar" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            
					</div>
				</div>
			</div>
	   <div class="col-sm-12 col-lg-6">
	            <div class="row">
	                <div class="col-lg-12 text-center" style="margin-top: 10px;">
	                    <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Grafik 7 Hari Terakhir (Pesanan Pascabayar)</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                </div>
                <div class="card-body">
                <div class="chart">
                  <div id="order-pascabayar" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            
	                    <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Grafik 7 Hari Terakhir (Deposit User)</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                </div>
                <div class="card-body">
                <div class="chart">
                  <div id="deposit" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
                </div>
              </div>
              <!-- /.card-body -->
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
require '../lib/footer_admin.php';
?>