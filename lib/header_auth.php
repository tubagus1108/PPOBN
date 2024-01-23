<?php
if (isset($_SESSION['login']) AND $config['web']['maintenance'] == 1) {
	exit("<center><h1>SORRY, WEBSITE IS UNDER MAINTENANCE!</h1></center>");
}
 
require 'is_login.php';
require 'csrf_token.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $config['web']['title']; ?> Adalah Sebuah Platform Bisnis Yang Menyediakan Berbagai Layanan MultI Media Marketing Yang Bergerak Terutama Di Indonesia. Dengan Bergabung Bersama Kami, Anda Dapat Menjadi Penyedia Jasa Sosial Media Atau Reseller Sosial Media Seperti Jasa Penambah Followers, Likes, Views, Subscribe, Dll. Saat Ini Tersedia Berbagai Layanan Untuk Sosial Media Terpopuler Seperti Instagram, Facebook, Twitter, Youtube, Dll. Dan Kamipun Juga Menyediakan Panel Pulsa & PPOB Seperti Pulsa All Operator, Paket Data, Saldo Gojek/Grab, Token PLN, All Voucher Game Online, Akun Premium, Dll.">
	<meta name="keywords" content="Panel Smm, Panel All Sosmed, Panel Pedia, Panel SMM & PPOB, Pulsa">
	<meta name="author" content="MC Project">
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
    <title><?php echo $config['web']['title']; ?> - Masuk</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['base_url']; ?>dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['base_url']; ?>dist/css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['base_url']; ?>dist/css/iofrm-style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $config['web']['base_url']; ?>dist/css/iofrm-theme10.css">
    <link rel="icon" type="image/png" href="<?php echo $config['web']['base_url']; ?>dist/images/logo.png" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
</head>
<body>