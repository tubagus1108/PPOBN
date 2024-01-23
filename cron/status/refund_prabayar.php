<?php
require("../../mainconfig.php");

$check_order = $db->query("SELECT * FROM orders_mobile WHERE status IN ('Error') AND refund = '0'");

if (mysqli_num_rows($check_order) == 0) {
	die("Pesanan Berstatus Error Tidak Ditemukan.");
} else {
	while($data_order = mysqli_fetch_assoc($check_order)) {
		$o_oid = $data_order['oid'];
		$o_poid = $data_order['poid'];
		$layanan = $data_order['service'];

		    $priceone = $data_order['price'];
		    $refund = $priceone;
		    $buyer = $data_order['user'];

			$update_user = $db->query("UPDATE users SET balance = balance+$refund, balance_used = balance_used-$refund WHERE username = '$buyer'");
    		$update_order = $db->query("UPDATE orders_mobile SET refund = '1'  WHERE oid = '$o_oid'");
    		if ($update_order == TRUE) {
    			echo "===============<br>Pengembalian Dana Top Up<br><br>Kode Pesanan : $o_oid<br>Nama Pengguna : $buyer<br>Rp $refund<br>===============<br>";
    		} else {
    			echo "Gagal Menampilkan Data Pengembalian Dana Top Up.<br />";
    		}
	}
}
?>