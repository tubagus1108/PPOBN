<?php

if (!isset($_SESSION['login'])) {
	$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Otentikasi dibutuhkan!', 'msg' => 'Silahkan masuk keakun Anda.');
	exit(header("Location: ".$config['web']['base_url']."auth/login.php"));
}
if ($model->db_query($db, "*", "users", "id = '".$_SESSION['login']."' AND level = 'Developers' OR level = 'Admin'")['count'] == 0) {
	exit(header("Location: ".$config['web']['base_url']."logout.php"));
}