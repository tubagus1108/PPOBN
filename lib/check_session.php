<?php
if (!isset($_SESSION['login'])) {
	$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Otentikasi dibutuhkan!', 'msg' => 'Silahkan masuk keakun Anda.');
	exit(header("Location: ".$config['web']['base_url']."auth/login.php"));
}