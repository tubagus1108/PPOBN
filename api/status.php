<?php
// Copyright www.everyonestore.web.id (Whatsapp : 081262012747)
require("../mainconfig.php");
header("Content-Type: application/json");

if (isset($_POST['api_key']) AND isset($_POST['action'])) {
	$post_key = $db->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['api_key'],ENT_QUOTES)))));
	$post_action = $db->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['action'],ENT_QUOTES)))));
	if (empty($post_key) || empty($post_action)) {
		$array = array("error" => "Incorrect request");
	} else {
		$check_user = mysqli_query($db, "SELECT * FROM users WHERE api_key = '$post_key'");
		$data_user = mysqli_fetch_assoc($check_user);
		if (mysqli_num_rows($check_user) == 1) {
			$username = $data_user['id'];
			if ($post_action == "status") {
				if (isset($_POST['trx_id'])) {
					$post_oid = $db->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['trx_id'],ENT_QUOTES)))));
					$check_order = mysqli_query($db, "SELECT * FROM orders WHERE id = '$post_oid' AND user_id = '$username'");
					$data_order = mysqli_fetch_array($check_order);
					if (mysqli_num_rows($check_order) == 0) {
						$array = array("error" => "Order not found");
					} else {
						$array = array(
							"data" => array(
								"target" => $data_order['link'], "start_count" => $data_order['start_count'], "remains" => $data_order['remains'], "status" => $data_order['status']
						));
					}
				} else {
					$array = array("error" => "Incorrect request");
				}
			} else {
				$array = array("error" => "Wrong action");
			}
		} else {
			$array = array("error" => "Invalid API key");
		}
	}
} else {
	$array = array("error" => "Incorrect request");
}

$print = json_encode($array);
print_r($print);