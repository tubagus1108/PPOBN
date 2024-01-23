<footer class="main-footer">
    <strong>Copyright &copy; 2021-<?php echo date('Y'); ?> <a href=""><?php echo $config['web']['title']; ?></a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo $config['web']['base_url']; ?>plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo $config['web']['base_url']; ?>plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo $config['web']['base_url']; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo $config['web']['base_url']; ?>plugins/chart.js/Chart.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $config['web']['base_url']; ?>plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo $config['web']['base_url']; ?>plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo $config['web']['base_url']; ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo $config['web']['base_url']; ?>plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo $config['web']['base_url']; ?>plugins/moment/moment.min.js"></script>
<script src="<?php echo $config['web']['base_url']; ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo $config['web']['base_url']; ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo $config['web']['base_url']; ?>plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo $config['web']['base_url']; ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $config['web']['base_url']; ?>assets/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $config['web']['base_url']; ?>assets/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo $config['web']['base_url']; ?>assets/js/pages/dashboard.js"></script>
<script type="text/javascript">
Morris.Area({
	element: 'order-sosmed',
	data: [
<?php
$date_list = array();
for ($i = 6; $i > -1; $i--) {
	$date_list[] = date('Y-m-d', strtotime('-'.$i.' days'));
}

for ($i = 0; $i < count($date_list); $i++) {
	$get_order_success = $model->db_query($db, "*", "orders", "status = 'Success' AND DATE(created_at) = '".$date_list[$i]."'");
	$get_order_pending = $model->db_query($db, "*", "orders", "status = 'Pending' AND DATE(created_at) = '".$date_list[$i]."'");
	$get_order_gagal = $model->db_query($db, "*", "orders", "status = 'Error' AND DATE(created_at) = '".$date_list[$i]."'");
	print("{ y: '".format_date($date_list[$i])."', a: ".$get_order_success['count'].", b: ".$get_order_pending['count'].", c: ".$get_order_gagal['count']." }, ");
}
?>
	],
	xkey: 'y',
	ykeys: ['a', 'b', 'c'],
	labels: ['Sukses', 'Pending', 'Gagal'],
	lineColors: ['#2abf72', '#f5ee1b', '#e60b25'],
	gridLineColor: '#6cabeb',
	pointSize: 0,
	lineWidth: 0,
	resize: true,
	parseTime: false
});
</script>
<script type="text/javascript">
Morris.Area({
	element: 'order-prabayar',
	data: [
<?php
$date_list = array();
for ($i = 6; $i > -1; $i--) {
	$date_list[] = date('Y-m-d', strtotime('-'.$i.' days'));
}

for ($i = 0; $i < count($date_list); $i++) {
	$get_order_success = $model->db_query($db, "*", "orders_mobile", "status = 'Success' AND DATE(date) = '".$date_list[$i]."'");
	$get_order_pending = $model->db_query($db, "*", "orders_mobile", "status = 'Pending' AND DATE(date) = '".$date_list[$i]."'");
	$get_order_gagal = $model->db_query($db, "*", "orders_mobile", "status = 'Error' AND DATE(date) = '".$date_list[$i]."'");
	print("{ y: '".format_date($date_list[$i])."', a: ".$get_order_success['count'].", b: ".$get_order_pending['count'].", c: ".$get_order_gagal['count']." }, ");
}
?>
	],
	xkey: 'y',
	ykeys: ['a', 'b', 'c'],
	labels: ['Sukses', 'Pending', 'Gagal'],
	lineColors: ['#2abf72', '#f5ee1b', '#e60b25'],
	gridLineColor: '#6cabeb',
	pointSize: 0,
	lineWidth: 0,
	resize: true,
	parseTime: false
});
</script>

<script type="text/javascript">
Morris.Area({
	element: 'order-pascabayar',
	data: [
<?php
$date_list = array();
for ($i = 6; $i > -1; $i--) {
	$date_list[] = date('Y-m-d', strtotime('-'.$i.' days'));
}

for ($i = 0; $i < count($date_list); $i++) {
	$get_order_success = $model->db_query($db, "*", "orders_pascabayar", "status = 'Success' AND DATE(created_at) = '".$date_list[$i]."'");
	$get_order_pending = $model->db_query($db, "*", "orders_pascabayar", "status = 'Pending' AND DATE(created_at) = '".$date_list[$i]."'");
	$get_order_error = $model->db_query($db, "*", "orders_pascabayar", "status = 'Error' AND DATE(created_at) = '".$date_list[$i]."'");
	print("{ y: '".format_date($date_list[$i])."', a: ".$get_order_success['count'].", b: ".$get_order_pending['count'].", c: ".$get_order_error['count']." }, ");
}
?>
	],
	xkey: 'y',
	ykeys: ['a', 'b', 'c'],
	labels: ['Sukses', 'Pending', 'Gagal'],
	lineColors: ['#2abf72', '#f5ee1b', '#e60b25'],
	gridLineColor: '#6cabeb',
	pointSize: 0,
	lineWidth: 0,
	resize: true,
	parseTime: false
});
</script>

<script type="text/javascript">
Morris.Area({
	element: 'deposit',
	data: [
<?php
$date_list = array();
for ($i = 6; $i > -1; $i--) {
	$date_list[] = date('Y-m-d', strtotime('-'.$i.' days'));
}

for ($i = 0; $i < count($date_list); $i++) {
	$get_order = $model->db_query($db, "*", "deposits", "status = 'Success' AND DATE(created_at) = '".$date_list[$i]."'");
	print("{ y: '".format_date($date_list[$i])."', a: ".$get_order['count']." }, ");
}
?>
	],
	xkey: 'y',
	ykeys: ['a'],
	labels: ['Deposit'],
	lineColors: ['#2abf72'],
	gridLineColor: '#6cabeb',
	pointSize: 0,
	lineWidth: 0,
	resize: true,
	parseTime: false
});
</script>
</body>
</html>