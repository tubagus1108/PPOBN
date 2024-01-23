<?php

if (isset($_SESSION['login']) AND $config['web']['maintenance'] == 1) {
	exit("<center><h1>SORRY, WEBSITE IS UNDER MAINTENANCE!</h1></center>");
}

require 'is_login.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $config['web']['title']; ?> - Admin Panel</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $config['web']['base_url']; ?>plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?php echo $config['web']['base_url']; ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo $config['web']['base_url']; ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo $config['web']['base_url']; ?>plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $config['web']['base_url']; ?>assets/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo $config['web']['base_url']; ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo $config['web']['base_url']; ?>plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo $config['web']['base_url']; ?>plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  
  <style type="text/css">.hide{display:none!important}.show{display:block!important}</style>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <script>
        function MyCustomFunction(){
            $("#submit").text("Loading...");
            $(this).submit('loading').delay(60000).queue(function () {
                // $(this).button('reset');
            });
        }
    </script>
		<script type="text/javascript">
        function modal_open(type, url) {
			$('#modal').modal('show');
			if (type == 'add') {
				$('#modal-title').html('<h5>Tambah Data</h5>');
			} else if (type == 'edit') {
				$('#modal-title').html('<h5>Ubah Data</h5>');
			} else if (type == 'delete') {
				$('#modal-title').html('<h5>Hapus Data</h5>');
			} else if (type == 'detail') {
				$('#modal-title').html('<h5>Detail Data</h5>');
			} else {
				$('#modal-title').html('Empty');
			}
        	$.ajax({
        		type: "GET",
        		url: url,
        		beforeSend: function() {
        			$('#modal-detail-body').html('Sedang memuat...');
        		},
        		success: function(result) {
        			$('#modal-detail-body').html(result);
        		},
        		error: function() {
        			$('#modal-detail-body').html('Terjadi kesalahan.');
        		}
        	});
        	$('#modal-detail').modal();
        }
		function update_data(url) {
			$('#modal-delete').modal('hide');
			$.ajax({
				type: "GET",
				url: url,
				dataType: "html",
				success: function($data) {
					$('#body-result').html($data);
					$('#datatable').DataTable().ajax.reload();
				}, error: function() {
					$('#body-result').html('<div class="alert alert-danger alert-dismissable"><b>Respon:</b> Gagal!<br /><b>Pesan:</b> Terjadi kesalahan!</div>');
				},
				beforeSend: function() {
					$('#body-result').html('<div class="progress progress-striped active"><div style="width: 100%" class="progress-bar progress-bar-primary"></div></div>');
				}
			});
		}
    	</script>
        <style type="text/css">
            .block { position: absolute; width: 100%; height: 100%; background: rgba(0,0,0,.5); z-index: 9999; }
        </style>
        
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="modal fade" id="modal" id="modal-detail" data-keyboard="false" data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="modal-title"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="modal-detail-body"></div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
			
    <?php
        if (isset($_SESSION['login'])) {
    ?>
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?php echo $config['web']['base_url']; ?>dist/images/logo.png" alt="Logo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Admin Panel</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="<?php echo $config['web']['base_url']; ?>dist/images/logo.png" alt="Admin Panel" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo $config['web']['base_url']; ?>dist/images/contact.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $login['username']; ?></a>
        </div>
      </div>
      <!-- SidebarSearch Form -->
        <a href="<?php echo $config['web']['base_url']; ?>logout" class="btn btn-block btn-sm btn-danger" style="text-decoration:none;">Logout</a>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $config['web']['base_url']; ?>admin" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard Admin</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $config['web']['base_url']; ?>" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard Pengguna</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?php echo $config['web']['base_url']; ?>admin/user" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Kelola Pengguna
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Kelola Layanan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $config['web']['base_url'] ?>admin/category" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kategori PPOB</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $config['web']['base_url'] ?>admin/category_sosmed" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kategori Sosmed</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $config['web']['base_url'] ?>admin/service_mobile" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Layanan PPOB</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $config['web']['base_url'] ?>admin/service" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Layanan Sosmed</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $config['web']['base_url'] ?>admin/provider" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Provider</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Kelola Deposit
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $config['web']['base_url'] ?>admin/deposit" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Permintaan Deposit</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $config['web']['base_url'] ?>admin/deposit_method" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Metode Deposit</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tree"></i>
              <p>
                Kelola Pesanan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="<?php echo $config['web']['base_url'] ?>admin/order" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pesanan Sosmed</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $config['web']['base_url'] ?>admin/order_mobile" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pesanan Prabayar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $config['web']['base_url'] ?>admin/order_pascabayar" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pesanan Pascabayar</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Lainnya
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $config['web']['base_url'] ?>admin/order_prabayar/report" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Keuntungan Prabayar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $config['web']['base_url'] ?>admin/order_pascabayar/report" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Keuntungan Pascabayar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $config['web']['base_url'] ?>admin/news" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Berita dan Informasi</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $config['web']['base_url'] ?>admin/carousel" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Banner</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo $config['web']['base_url'] ?>admin/log/login" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Riwayat Masuk
                  </p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
		</div>
		<div class="page-wrapper">
			<div class="page-content">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                            if (isset($_SESSION['result'])) {
                        ?>
                      <div class="alert alert-<?php echo $_SESSION['result']['alert'] ?> alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;
                          </span>
                        </button>
                        <div class="alert-text">
                          <strong><?php echo $_SESSION['result']['title'] ?>.
                          </strong> 
                          <br>
                          <?php echo $_SESSION['result']['msg'] ?>
                          </div>
                      </div>
                      <?php
                        unset($_SESSION['result']);
                        }
                    ?>
                    
                    </div>
                </div>
                <?
        }
        ?>