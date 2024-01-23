<?php
require '../mainconfig.php';
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	if (!isset($_POST['payment']) OR !isset($_POST['type'])) {
		exit("No direct script access allowed!");
	}
	if (empty($_POST['payment']) OR empty($_POST['type'])) {
		exit('<option value="0">Pilih Jenis Pembayaran & Permintaan...</option>');
	}
	$method = $model->db_query($db, "*", "deposit_methods", "payment = '".mysqli_real_escape_string($db, $_POST['payment'])."' AND type = '".mysqli_real_escape_string($db, $_POST['type'])."' AND status = '1'");
	if ($method['count'] == 0) {
		print('<option value="0">Metode Deposit tidak ditemukan...</option>');
	} else {
		print('<option value="0">Pilih...</option>');
		if ($method['count'] == 1) {
		    if ($method['rows']['bonus'] == true) {
			    print('<option value="'.$method['rows']['id'].'">'.$method['rows']['name'].' (Minimal Rp. '.number_format($method['rows']['min_amount'],0,',','.').') (Bonus '.$method['rows']['bonus'].'%)</option>');
		    } else {
		        print('<option value="'.$method['rows']['id'].'">'.$method['rows']['name'].'</option>');
		    }
		} else {
			foreach ($method['rows'] as $key) {
			    if ($key['bonus'] == true) {
				    print('<option value="'.$key['id'].'">'.$key['name'].' (Minimal Rp. '.number_format($key['min_amount'],0,',','.').') (Bonus '.$key['bonus'].'%)</option>');
			    } else {
			        print('<option value="'.$key['id'].'">'.$key['name'].' (Minimal Rp. '.number_format($key['min_amount'],0,',','.').')</option>'); 
			    }
			}
		}
	}
} else {
	exit("No direct script access allowed!");
}