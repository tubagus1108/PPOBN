<?php
date_default_timezone_set('Asia/Jakarta');
ini_set('memory_limit', '128M');
error_reporting(0);

/* CONFIG */
$config['web'] = array(
	'maintenance' => 0, // 1 = yes, 0 = no
	'title' => 'Kincai Payment',
	'meta' => array(
		'description' => 'Platform bisnis yang menyediakan berbagai Layanan Multi Payment, Produk Digital PPOB, Saldo E-Money Lokal & Global, Voucher Games, dan Pulsa All Operator.',
		'keywords' => 'PPOB, Voucher, Games, Topup',
		'author' => 'Kincai Payment'
	),
	'base_url' => 'https://domain.com/', //domain dengan slash (/)
	'register_url' => 'https://domain.com/auth/register', //url registrasi
	'versi' => '1.0.0'
);

$config['register'] = array(
	'price' => array(
		'member' => 10000,
		'reseller' => 30000,
	),
	'bonus' => array(
		'member' => 0,
		'reseller' => 0,
	)
);

$tab_1 = '';
$tab_2 = '';

$config['db'] = array(
	'host' => 'localhost',
	'name' => 'nama_database',
	'username' => 'user_database',
	'password' => 'pass_database'
);
/* END CONFIG */

require 'lib/db.php';
require 'lib/model.php';
require 'lib/function.php';
require 'lib/SimCardDetector.php';
require 'lib/whatsapp.php';

$whatsapp = new whatsappapi();
session_start();
$model = new Model();

?>