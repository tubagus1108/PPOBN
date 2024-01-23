<?php
require '../mainconfig.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	if (!isset($_POST['method']) AND !isset($_POST['amount'])) {
		exit("No direct script access allowed!");
	}
	if (empty($_POST['method'])) {
		exit('0');
	}
	$method = $model->db_query($db, "*", "deposit_methods", "id = '".mysqli_real_escape_string($db, $_POST['method'])."'");
	if ($method['count'] == 0) {
		print('0');
	} else {
	    $post_amount = ($method['rows']['rate']*$_POST['amount']);
	    $cek_bonus = ($method['rows']['bonus']/100 * $post_amount);
	    if ($method['rows']['bonus'] == true) {
		    print($cek_bonus + $post_amount);
	    } else {
	        print($post_amount);
	    }
	}
} else {
	exit("No direct script access allowed!");
}