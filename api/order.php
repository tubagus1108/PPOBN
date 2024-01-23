<?php
// Copyright www.everyonestore.web.id (Whatsapp : 081262012747)
require("../mainconfig.php");
header("Content-Type: application/json");

if (isset($_POST['api_key']) AND isset($_POST['action'])) {
	$post_key = $db->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['api_key'],ENT_QUOTES)))));
	$post_action = $db->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['action'],ENT_QUOTES)))));
	if (empty($post_key) || empty($post_action)) {
		$array = array("error" => 'Api Key atau Aksi tidak boleh kosong');
	} else {
		$check_user = $db->query("SELECT * FROM users WHERE api_key = '$post_key'");
		$data_user = mysqli_fetch_assoc($check_user);
		if (mysqli_num_rows($check_user) == 1) {
			$username = $data_user['username'];
			$user_id = $data_user['id'];
			if ($post_action == "order") {
				if (isset($_POST['service']) AND isset($_POST['target']) AND isset($_POST['quantity'])) {
					$post_service = $db->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['service'],ENT_QUOTES)))));
					$post_link = $db->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['target'],ENT_QUOTES)))));
					$post_quantity = $db->real_escape_string(trim(stripslashes(strip_tags(htmlspecialchars($_POST['quantity'],ENT_QUOTES)))));
					if (empty($post_service) || empty($post_link) || empty($post_quantity)) {
						$array = array("error" => 'Masih ada data yang kosong!');
					} else {
						$check_service = $db->query("SELECT * FROM services WHERE sid = '$post_service' AND status = 'Active'");
						$data_service = mysqli_fetch_assoc($check_service);
						if (mysqli_num_rows($check_service) == 0) {
							$array = array('status' => false, 'data' => array('msg' => 'Layanan tidak ditemukan!'));
						} else {
							$oid = random_number(5);
							$rate = $data_service['price'] / 1000;
							$price = $rate*$post_quantity;
							$total_profit = ($data_service['profit'] / 1000) * $post_quantity;
							$service = $data_service['service'];
							$category = $data_service['category'];
							$provider = $data_service['provider'];
							$pid = $data_service['pid'];
							
							if ($post_quantity < $data_service['min']) {
								$array = array("error" => 'Minimal pesanan '.$data_service['min'].'');
							} else if ($post_quantity > $data_service['max']) {
								$array = array("error" => 'Maksimal pesanan '.$data_service['max'].'');
							} else if ($data_user['balance'] < $price) {
								$array = array("error" => "Saldo anda tidak cukup!");
							} else {
								$check_provider = $db->query("SELECT * FROM provider WHERE name = '$provider'");
								$data_provider = mysqli_fetch_assoc($check_provider);
								$provider_key = $data_provider['api_key'];
								$provider_link = $data_provider['api_url_order'];
								$provider_apiid = $data_provider['api_id'];
	
								if ($provider == "MANUAL") {
									$api_postdata = "";
								} else if ($provider == "IRVANKEDE") {

			                            $api_postdata = "api_id=$provider_apiid&api_key=$provider_key&service=$pid&target=$post_link&quantity=$post_quantity";
			                        
									$ch = curl_init();
									curl_setopt($ch, CURLOPT_URL, $provider_link);
									curl_setopt($ch, CURLOPT_POST, 1);
									curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
									curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
									$chresult = curl_exec($ch);
									curl_close($ch);
									$json_result = json_decode($chresult, true);
								} else if ($provider == "WSTORE") {

			                            $api_postdata = "api_id=$provider_apiid&api_key=$provider_key&service=$pid&target=$post_link&quantity=$post_quantity";
			                        
									$ch = curl_init();
									curl_setopt($ch, CURLOPT_URL, $provider_link);
									curl_setopt($ch, CURLOPT_POST, 1);
									curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
									curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
									$chresult = curl_exec($ch);
									curl_close($ch);
									$json_result = json_decode($chresult, true);
								} else if ($provider == "MEDANPEDIA") {
								    
			                        $api_postdata = "api_id=$provider_apiid&api_key=$provider_key&service=$pid&target=$post_link&quantity=$post_quantity";
			                      
									$ch = curl_init();
									curl_setopt($ch, CURLOPT_URL, $provider_link);
									curl_setopt($ch, CURLOPT_POST, 1);
									curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
									curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
									$chresult = curl_exec($ch);
									curl_close($ch);
									$json_result = json_decode($chresult, true);
								} else if ($provider == "JAP") {

			                            $api_postdata = "key=$provider_key&action=add&service=$pid&link=$post_link&quantity=$post_quantity";
			                        
									$ch = curl_init();
									curl_setopt($ch, CURLOPT_URL, $provider_link);
									curl_setopt($ch, CURLOPT_POST, 1);
									curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
									curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
									$chresult = curl_exec($ch);
									curl_close($ch);
									$json_result = json_decode($chresult, true);
								} else if ($provider == "PEAKER") {

			                            $api_postdata = "key=$provider_key&action=add&service=$pid&link=$post_link&quantity=$post_quantity";
			                        
									$ch = curl_init();
									curl_setopt($ch, CURLOPT_URL, $provider_link);
									curl_setopt($ch, CURLOPT_POST, 1);
									curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
									curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
									$chresult = curl_exec($ch);
									curl_close($ch);
									$json_result = json_decode($chresult, true);
								} else if ($provider == "SMMHEART") {

			                       $api_postdata = "key=$provider_key&action=add&service=$pid&link=$post_link&quantity=$post_quantity";
			                        
									$ch = curl_init();
									curl_setopt($ch, CURLOPT_URL, $provider_link);
									curl_setopt($ch, CURLOPT_POST, 1);
									curl_setopt($ch, CURLOPT_POSTFIELDS, $api_postdata);
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
									curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
									$chresult = curl_exec($ch);
									curl_close($ch);
									$json_result = json_decode($chresult, true);
								}
								
								if ($provider == "IRVANKEDE" AND $json_result['status'] == FALSE) {
									$array = array("error" => $json_result['data']);
								} else if ($provider == "WSTORE" AND $json_result['status'] == FALSE) {
									$array = array("error" => $json_result['data']);
								} else if ($provider == "MEDANPEDIA" AND $json_result['status'] == FALSE) {
									$array = array("error" => $json_result['data']);
								} else if ($provider == "JAP" AND $json_result['error'] == true) {
								    $array = array("error" => $json_result['error']);
								} else if ($provider == "PEAKER" AND $json_result['error'] == true) {
								    $array = array("error" => $json_result['error']);
								} else if ($provider == "SMMHEART" AND $json_result['error'] == true) {
								    $array = array("error" => $json_result['error']);
								} else {
									if ($provider == "IRVANKEDE") {
										$poid = $json_result['data']['id'];
									} else if ($provider == "WSTORE") {
										$poid = $json_result['data']['id'];
									} else if ($provider == "MEDANPEDIA") {
										$poid = $json_result['data']['id'];
									} else if ($provider == "JAP") {
									    $poid = $json_result['order'];
									} else if ($provider == "PEAKER") {
									    $poid = $json_result['order'];
									} else if ($provider == "SMMHEART") {
									    $poid = $json_result['order'];
									} else if ($provider == "MANUAL") {
										$poid = random_number(5);
									}
									$update_user = $db->query("UPDATE users SET balance = balance-$price WHERE username = '$username'");
									if ($update_user == TRUE) {
										$insert_order = $db->query("INSERT INTO orders (id, user_id, category, service_name, data, quantity, price, profit, remains, provider, provider_order_id, is_api, created_at) VALUES ('$oid','$user_id', '$category', '$service', '$post_link', '$post_quantity', '$price', '$total_profit', '$post_quantity', '$provider', '$poid', '1', '".date('Y-m-d H:i:s')."')");
										if ($insert_order == TRUE) {
											$array = array("order_id" => "$oid");
										} else {
											$array = array("error" => "Terjadi Kesalahan (Db_Err!");
										}
									} else {
										$array = array("error" => "Terjadi Kesalahan (Conn");
									}
								}
							}
						}
					}
				} else {
					$array = array("error" => "Input Tidak Sesuai!");
				}
			} else {
				$array = array("error" => "Aksi Salah!");
			}
		} else {
			$array = array("error" => "Api Key Tidak Terdaftar!");
		}
	}
} else {
	$array = array("error" => "Permintaan Tidak Sesuai!");
}
$print = json_encode($array);
print_r($print);