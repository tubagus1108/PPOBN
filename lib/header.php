<?php
if (isset($_SESSION['login']) AND $config['web']['maintenance'] == 1) {
	exit(file_get_contents("mt.php"));
}
 
require 'is_login.php';
require 'csrf_token.php';
?>
<!doctype html>
<html lang="id">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <meta name="description" content="<?php echo $config['web']['title']; ?> Adalah Sebuah Platform Bisnis Yang Menyediakan Berbagai Layanan Multi Media Marketing Yang Bergerak Terutama Di Indonesia. Dengan Bergabung Bersama Kami, Anda Dapat Menjadi Penyedia Jasa Sosial Media Atau Reseller Sosial Media Seperti Jasa Penambah Followers, Likes, Views, Subscribe, Dll. Saat Ini Tersedia Berbagai Layanan Untuk Sosial Media Terpopuler Seperti Instagram, Facebook, Twitter, Youtube, Dll. Dan Kamipun Juga Menyediakan Panel Pulsa & PPOB Seperti Pulsa All Operator, Paket Data, Saldo Gojek/Grab, Token PLN, All Voucher Game Online, Akun Premium, Dll.">
	<meta name="keywords" content="Panel Smm, Panel All Sosmed, Panel Pedia">
	<meta name="author" content="MC Project">
	<meta name="Geo.Placename" content="Indonesia">
    <meta name="Geo.Country" content="Id">
	<meta content="<?php echo $config['web']['base_url']; ?>" name="start_url" />
    <meta content="<?php echo $config['web']['title']; ?>" name="application-name" />
    <meta content="<?php echo $config['web']['title']; ?>" name="apple-mobile-web-app-title" />
    <meta content="<?php echo $config['web']['title']; ?>" name="msapplication-tooltip" />
    <meta content="#0072B5" name="theme_color" />
    <meta content="#0072B5" name="theme-color" />
    <meta content="#FFFFFF" name="background_color" />
    <meta content="#0072B5" name="msapplication-navbutton-color" />
    <meta content="#0072B5" name="msapplication-TileColor" />
    <meta content="#0072B5" name="apple-mobile-web-app-status-bar-style" />
    <meta content="true" name="mssmarttagspreventparsing" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="yes" name="mobile-web-app-capable" />
    <meta content="yes" name="apple-touch-fullscreen" />
    <base href="../" />

    <title><?php echo $config['web']['title']; ?> - Panel PPOB Termurah, Cepat, dan Terpercaya</title>

    <!-- include common vendor stylesheets & fontawesome -->
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['base_url']; ?>dist/css/bootstrap.min.css?rgs=1625461439">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['base_url']; ?>dist/css/typography.css?rgs=1625461439">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['base_url']; ?>dist/css/style.css?rgs=1625461439">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['base_url']; ?>dist/css/responsive.css?rgs=1625461439">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['base_url']; ?>dist/css/nectstyle.css?rgs=1625461439">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['base_url']; ?>dist/css/custom.css?rgs=1625461439">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/regular.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/brands.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/solid.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/1beeb971eb.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <style type="text/css">.hide{display:none!important}.show{display:block!important}</style>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- include vendor stylesheets used in "Dashboard" page. see "/views//pages/partials/dashboard/@vendor-stylesheets.hbs" -->


    <!-- include fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600&display=swap">



    <!-- ace.css -->
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['base_url'] ?>dist/css/ace.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['base_url'] ?>dist/css/dashboard.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['base_url'] ?>dist/css/sim-card.css">

    <!-- favicon -->
    <link rel="icon" type="image/png" href="/favicon.png"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
    <!-- "Dashboard" page styles, specific to this page for demo only -->
    <style>
    [class~=avatar]{border-radius:12.5pc;}[class~=avatar],[class~=_24EoF] span,[class~=avatar] [class~=overlay],.avatar .overlay{overflow:hidden;}[class~=avatar] [class~=overlay],.avatar .overlay{height:100%;}[class~=avatar] [class~=overlay],.avatar .overlay{width:100%;}[class~=avatar]{display:inline-block;}[class~=avatar] [class~=overlay],.avatar .overlay{border-radius:50%;}[class~=_24EoF] span{font-size:11px;}[class~=avatar]{margin-left:1;}[class~=avatar] [class~=overlay],.avatar .overlay{opacity:.9;}[class~=avatar]{margin-bottom:1;}a{text-decoration:none;}[class~=_24EoF] span{font-weight:500;}.avatar .overlay,[class~=avatar] [class~=overlay]{z-index:0;}[class~=avatar]{margin-right:auto;}[class~=avatar]{margin-top:1;}[class~=_24EoF] span{color:#000;}.avatar .overlay,[class~=avatar] [class~=overlay]{position:absolute;}[class~=_24EoF] span{display:block;}[class~=avatar]{background-color:#fff;}[class~=avatar]{border-left-width:.125pc;}[class~=avatar]{border-bottom-width:.125pc;}[class~=avatar]{border-right-width:.125pc;}[class~=avatar]{border-top-width:.125pc;}[class~=_24EoF] span{margin-top:6pt;}[class~=avatar]{border-left-style:solid;}[class~=avatar] [class~=overlay],.avatar .overlay{left:0;}[class~=avatar]{border-bottom-style:solid;}[class~=avatar]{border-right-style:solid;}.avatar .overlay,[class~=avatar] [class~=overlay]{top:0;}[class~=avatar]{border-top-style:solid;}[class~=avatar]{border-left-color:#fff;}[class~=_24EoF] span{line-height:1.35em;}[class~=avatar]{border-bottom-color:#fff;}[class~=avatar]{border-right-color:#fff;}[class~=avatar]{border-top-color:#fff;}[class~=avatar]{border-image:none;}[class~=avatar]{vertical-align:top;}._24EoF,[class~=avatar]{text-align:center;}[class~=avatar]{box-shadow:0 .3125pc .104166667in rgba(0,0,0,.1);}[class~=avatar]{-webkit-box-shadow:0 3.75pt 7.5pt rgba(0,0,0,.1);}[class~=avatar]{-moz-box-shadow:0 3.75pt .104166667in rgba(0,0,0,.1);}[class~=avatar]{-ms-box-shadow:0 5px 7.5pt rgba(0,0,0,.1);}[class~=avatar]{position:relative;}[class~=_24EoF] span{-webkit-transition:color .1s;}.avatar-40{height:.46875in;}[class~=_24EoF] span{-o-transition:color .1s;}[class~=_24EoF] span{transition:color .1s;}.avatar-40{line-height:37.5pt;}.avatar-40{vertical-align:middle;}.avatar-40{width:2.8125pc;}[class~=gradient-primary]{background:#0072B5;}[class~=gradient-primary]{background:-moz-linear-gradient(top,#0072B5 0%,#1e88ff 100%);}[class~=gradient-primary]{background:-webkit-gradient(left top,left bottom,color-stop(0%,#0072B5),color-stop(100%,#1e88ff));}[class~=gradient-primary]{background:-webkit-linear-gradient(top,#0072B5 0%,#1e88ff 100%);}[class~=_24EoF] span{white-space:nowrap;}[class~=gradient-primary]{background:-o-linear-gradient(top,#0072B5 0%,#1e88ff 100%);}[class~=gradient-primary]{background:-ms-linear-gradient(top,#0072B5 0%,#1e88ff 100%);}[class~=gradient-primary]{background:linear-gradient(to bottom,#333333 0%,#0072B5 100%);}[class~=avatar][class~=no-shadow]{box-shadow:none;}[class~=avatar][class~=no-shadow]{-webkit-box-shadow:none;}._24EoF{display:inline-block;}._24EoF{width:18%;}[class~=_24EoF] span{-o-text-overflow:ellipsis;}[class~=_24EoF] span{text-overflow:ellipsis;}._24EoF{padding-left:0;}._24EoF{padding-bottom:.5pc;}a:hover{text-decoration:none;}._24EoF{padding-right:0;}._24EoF{padding-top:.104166667in;}._24EoF{border-bottom-width:1.5pt;}[class~=avatar][class~=no-shadow]{-moz-box-shadow:none;}._24EoF{border-bottom-style:solid;}._24EoF{border-bottom-color:transparent;}._24EoF{border-image:none;}[class~=avatar][class~=no-shadow]{-ms-box-shadow:none;}._24EoF{vertical-align:top;}._24EoF{-webkit-transition:background-color .1s;}._24EoF{-o-transition:background-color .1s;}._24EoF{transition:background-color .1s;}[class~=_1ekcz]{-ms-flex-pack:justify;}[class~=_1ekcz]{justify-content:space-between;}[class~=_1ekcz]{-ms-flex-wrap:wrap;}[class~=_1ekcz]{flex-wrap:wrap;}
    </style>
    <style type="text/css">
        .preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background-color: #fff;
        }
        .preloader .loading {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%,-50%);
        font: 14px arial;
    }
    </style>
    <script>
        function MyCustomFunction(){
            $("#submit").text("Mohon Menunggu...");
            $(this).submit('loading').delay(60000).queue(function () {
            });
        }
    </script>
    <script type="text/javascript">
        
        function confirm_order(type, url) {
			$('#modal-order').modal('show');
			if (type == 'c_order') {
				$('#modal-title-order').html('<h5>Order Confirmation</h5>');
			} else {
				$('#modal-title-order').html('Empty');
			}
        	$.ajax({
        		type: "GET",
        		url: url,
        		beforeSend: function() {
        			$('#modal-detail-body-order').html('Sedang memuat...');
        		},
        		success: function(result) {
        			$('#modal-detail-body-order').html(result);
        		},
        		error: function() {
        			$('#modal-detail-body-order').html('Terjadi kesalahan.');
        		}
        	});
        	$('#modal-detail-order').modal();
        }
    	</script>
    	<script type="text/javascript">
        function modal_open(type, url) {
			$('#modal').modal('show');
			if (type == 'add') {
				$('#modal-title').html('<i class="fa fa-plus-square"></i> Tambah Data');
			} else if (type == 'edit') {
				$('#modal-title').html('<i class="fa fa-edit"></i> Ubah Data');
			} else if (type == 'delete') {
				$('#modal-title').html('<i class="fa fa-trash"></i> Hapus Data');
			} else if (type == 'detail') {
				$('#modal-title').html('<i class="fa fa-search"></i> Detail Data');
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
    	<style>
        .body-container {
            background-image: linear-gradient(#6baace, #264783);
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        .carousel-item>div {
            height: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        /* these rules are used to make sure in mobile devices, tab panes are not all the same height (for example 'forgot' pane is not as tall as 'signup' pane) */

        @media (max-width: 1199.98px) {
        .tab-sliding .tab-pane:not(.active) {
          max-height: 0 !important;
        }

        .tab-sliding .tab-pane.active {
          min-height: 80vh;
          max-height: none !important;
        }
      }
    </style>
<style type="text/css">
.block { position: absolute; width: 100%; height: 100%; background: rgba(0,0,0,.5); z-index: 9999; }

element {
    display: block;
    padding-right: 17px;
}
.modal.action-sheet-order {
    z-index: 9999;
}
.modal-open .modal {
    overflow-x: hidden;
    overflow-y: auto;
}
.modal {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1050;
    display: none;
    width: 100%;
    height: 100%;
    overflow: hidden;
    outline: 0;
}
.fade {
    transition: none;
}
.fade {
    transition: opacity 0.15s linear;
}
.modal.action-sheet-order.show .modal-dialog {
    transform: translate(0, 0);
}
.modal.action-sheet-order .modal-dialog {
    padding: 0;
    margin: 0;
    bottom: 0;
    position: fixed;
    width: 100%;
    min-width: 100%;
    z-index: 1200;
    transform: translate(0, 100%);
}

</style>
<script>
$(document).ready(function(){
$(".preloader").fadeOut();
})
</script>
  </head>

<body class="iq-page-menu-horizontal" >
    <?php if (isset($_SESSION['login'])) { ?>
    <div class="preloader">
        <div class="loading">
            <img src="<?php echo $config['web']['base_url']; ?>dist/images/loader-unscreen.gif" width="500">
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="modal" id="modal-detail" data-backdrop-bg="bgc-grey-tp4" data-blur="true" tabindex="-1" role="dialog" aria-labelledby="exampleModal2Label" data-keyboard="false" data-backdrop="static" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content border-0 shadow radius-1">
                  <div class="modal-header">
                    <h5 class="modal-title text-primary-d2" id="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body modal-scroll" id="modal-detail-body">
                  <div class="modal-footer bgc-default-l5">
                    <button type="button" class="btn btn-lighter-grey px-4" data-dismiss="modal">
                      Close
                    </button>
                  </div>
                </div>
              </div>
            </div>
        </div>

<div class="modal fade modalbox"  id="modal-order" id="modal-detail-order" tabindex="-1" data-backdrop="static" role="dialog" style="display: none;" aria-hidden="true">
              <div class="modal-dialog" role="document" style="top:30%;">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modal-title-order"></h5>
                        <a href="javascript:;" data-dismiss="modal">Close</a>
                  </div>
                  <div class="modal-body p-0" id="modal-detail-body-order">

                  <div class="modal-footer bgc-default-l5">
                    <button type="button" class="btn btn-lighter-grey px-4" data-dismiss="modal">
                      Close
                    </button>
                  </div>
                </div>
              </div>
            </div>
    </div>

        <header class="no-border text-light">
            <left>
                <a href="<?php echo $config['web']['base_url']; ?>" class="headerButton">
                    <icon-box>
                      <em class="ri-wallet-3-fill" style="color: #0072B5"></em>
                    </icon-box>
                    <pagetitle><?php echo $config['web']['title']; ?></pagetitle>
                </a>
            </left>
            <right>
                <a href="javascript:;" onclick="javascript:location.href='<?php echo $config['web']['base_url']; ?>pages/news'" class="headerButton">
                    <em class="ri-notification-4-line"></em>
                    <span class="badge badge-danger"></span>
                </a>
            </right>
        </header>
      <!-- <nav class="navbar navbar-expand-lg navbar-fixed navbar-blue">
        <div class="navbar-inner">

          <div class="navbar-intro justify-content-xl-between">

             <button type="button" class="btn btn-burger burger-arrowed static collapsed ml-2 d-flex d-xl-none" data-toggle-mobile="sidebar" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle sidebar">
              <span class="bars"></span>
            </button> 

            <a class="navbar-brand text-white" href="#">
              <span>Rp <?php echo number_format($login['balance'],0,',','.'); ?></span>
            </a>

           <button type="button" class="btn btn-burger mr-2 d-none d-xl-flex" data-toggle="sidebar" data-target="#sidebar" aria-controls="sidebar" aria-expanded="true" aria-label="Toggle sidebar">
              <span class="bars"></span>
            </button>

          </div>



        </div>
      </nav> -->

        <!-- <div id="sidebar" class="sidebar sidebar-fixed expandable sidebar-light">
          <div class="sidebar-inner">

            <div class="ace-scroll flex-grow-1" data-ace-scroll="{}">

              <div class="sidebar-section my-2">

              </div>

              <ul class="nav has-active-border active-on-right">


                <li class="nav-item-caption">
                  <span class="fadeable pl-3">MAIN</span>
                  <span class="fadeinable mt-n2 text-125">&hellip;</span>

                </li>


                <li class="nav-item active">

                  <a href="/" class="nav-link">
                    <i class="nav-icon fa fa-tachometer-alt"></i>
                    <span class="nav-text fadeable">
               	  <span>Dashboard</span>
                    </span>
                  </a>

                  <b class="sub-arrow"></b>

                </li>

                <li class="nav-item">

                  <a href="html/cards.html" class="nav-link">
                    <i class="nav-icon far fa-window-restore"></i>
                    <span class="nav-text fadeable">
               	  <span>Info & Promo</span>
                    </span>


                  </a>

                  <b class="sub-arrow"></b>

                </li>


                <li class="nav-item">

                  <a href="html/gallery.html" class="nav-link">
                    <i class="nav-icon far fa-image"></i>
                    <span class="nav-text fadeable">
               	  <span>Mutasi Saldo & Riwayat Pesanan</span>
                    </span>


                  </a>

                  <b class="sub-arrow"></b>

                </li>



              </ul>

            </div>


            <div class="sidebar-section">
              <div class="sidebar-section-item fadeable-bottom">
                <div class="fadeinable">

                  <div class="pos-rel">
                    <img alt="<?php echo $login['full_name']; ?> Photo" src="<?php echo $config['web']['base_url']; ?>dist/images/incognito.png" width="42" class="px-1px radius-round mx-2 border-2 brc-default-m2" />
                    <span class="bgc-success radius-round border-2 brc-white p-1 position-tr mr-1 mt-2px"></span>
                  </div>
                </div>
                <div class="fadeable hideable w-100 bg-transparent shadow-none border-0">
                  <div id="sidebar-footer-bg" class="d-flex align-items-center bgc-white shadow-sm mx-2 mt-2px py-2 radius-t-1 border-x-1 border-t-2 brc-primary-m3">
                    <div class="d-flex mr-auto py-1">
                      <div class="pos-rel">
                        <img alt="<?php echo $login['full_name']; ?> Photo" src="<?php echo $config['web']['base_url']; ?>dist/images/incognito.png" width="42" class="px-1px radius-round mx-2 border-2 brc-default-m2" />
                        <span class="bgc-success radius-round border-2 brc-white p-1 position-tr mr-1 mt-2px"></span>
                      </div>

                      <div>
                        <span class="text-blue-d1 font-bolder"><?php echo $login['username']; ?></span>
                        <div class="text-80 text-grey">
                          <?php echo $login['level']; ?>
                        </div>
                      </div>
                    </div>

                    <a href="<?php echo $config['web']['base_url']; ?>user/settings" class="d-style btn btn-outline-primary btn-h-light-primary btn-a-light-primary border-0 p-2 mr-2px ml-4" title="Settings">
                      <i class="fa fa-cog text-150 text-blue-d2 f-n-hover"></i>
                    </a>

                  </div>
                </div>
              </div>
            </div> 

          </div>
        </div> -->

         <div class="content-page p-0">
            <div class="container-fluid">
                <div class="row content-body" style="display: block">
                    
        <? } ?>
              <div class="col-md-12">
                        <?php
                            if (isset($_SESSION['result'])) {
                        ?>
                            <?php echo $_SESSION['result']['msg'] ?>
                        <?php
                        unset($_SESSION['result']);
                        }
                    ?>
                    </div>