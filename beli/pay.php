<?php
require '../mainconfig.php';
require '../lib/check_session.php';
if ($_POST) {
	require '../lib/is_login.php';
	$balance_now = $login['balance'];
	$input_data = array('service', 'phone');
	if (check_input($_POST, $input_data) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Input tidak sesuai!",text: "silakan coba lagi!"});</script>.');
		header("Location: /");
	} else {
		$validation = array(
			'service' => $_POST['service'],
			'phone' => $_POST['phone'],
		);
		if (check_empty($validation) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Input tidak boleh kosong!",text: "Mohon mengisi semua input!"});</script>.');
			header("Location: /");
		} else {
			$service = $model->db_query($db, "*", "services_pulsa", "sid = '".mysqli_real_escape_string($db, $_POST['service'])."' AND status = 'Active'");
			if ($service['count'] == 0) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Layanan tidak ditemukan!",text: "Silakan hubungi admin!"});</script>');
				header("Location: /");
			} else {
                if ($login['user_verif'] == 1) {
    				$total_price = $service['rows']['price_agen'];
                } else {
                    $total_price = $service['rows']['price'];
                }
				$total_price_provider = $service['rows']['price_provider'];
				$bonus_points = $service['rows']['bonus_poin'];
				$provider = $model->db_query($db, "*", "provider", "name = '".$service['rows']['provider']."'");
				if ($provider['count'] == 0) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Maaf saat ini layanan tidak tersedia!",text: "silakan kontak Admin!"});</script>');
					header("Location: /");
				} elseif ($login['balance'] < $total_price) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Saldo Kamu tidak cukup untuk membuat pesanan!",text: "Silakan lakukan pengisian saldo!"});</script>');
					header("Location: /");
				} else {
					if ($service['rows']['provider'] == 'DIGIFLAZZ') {
					    $oid = random_number(3).random_number(4);
					    $sign = md5("kuxodooEaQyo".$provider['rows']['api_key'].$oid);
                        $post_api = array("username" => "kuxodooEaQyo","buyer_sku_code" => $service['rows']['pid'],"customer_no"=> $_POST['phone'],"ref_id" => $oid,"sign" => $sign);
                        $data_string = json_encode($post_api);

                        $ch = curl_init($provider['rows']['api_url_order']);                                                                      
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
                            'Content-Type: application/json',                                                                                
                            'Content-Length: ' . strlen($data_string))                                                                       
                        );                                                                                                                   
                        $chresult = curl_exec($ch);
                        curl_close($ch);
                        $result = json_decode($chresult, true);
						if (isset($result['error']) AND $result['error'] != true) {
							$provider_order_id = $oid;
						}
					}
					if ($service['rows']['provider'] == 'DIGIFLAZZ' AND $result['data']['status'] != 'Pending') {
						$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "'.$result['data']['message'].'"});</script>');
						header("Location: /");
					} else {
						$input_post = array(
						    'oid' => $oid,
						    'poid' => $oid,
							'user' => $login['username'],
							'saldo_akhir' => $balance_now,
							'service' => $service['rows']['service'],
							'price' => $total_price,
							'price_provider' => $total_price_provider,
							'phone' => input_request($_POST['phone'],$db),
							'status' => 'Pending',
							'date' => date('Y-m-d'),
							'time' => date('H:i:s'),
							'place_from' => 'WEB',
							'catatan' => 'Sedang diproses',
							'provider' => 'DIGIFLAZZ',
							'operator' => input_request($_POST['operator'], $db)
						);
						$insert = $model->db_insert($db, "orders_mobile", $input_post);
						if ($insert == true) {
						    $model->db_update($db, "users", array('balance' => $login['balance'] - $total_price), "id = '".$login['id']."'");
							$model->db_update($db, "users", array('balance_used' => $login['balance_used'] + $total_price), "id = '".$login['id']."'");
							$model->db_update($db, "users", array('points' => $login['points'] + $bonus_points), "id = '".$login['id']."'");
							$model->db_insert($db, "balance_logs", array('user_id' => $login['id'], 'type' => 'minus', 'amount' => $total_price, 'note' => 'Membuat Pesanan. ID Pesanan: '.$insert.'.', 'created_at' => date('Y-m-d H:i:s')));
							$_SESSION['result'] = array('alert' => 'success', 'title' => '<script>Swal.fire({type: "success",title: "Berhasil membuat pesanan!",text: "Order ID: '.$oid.'!"});</script>');
							header("Location: ".$config['web']['base_url']."pembelian/berhasil/$oid");
						} else {
							$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Pesanan gagal dibuat!",text: "silakan coba lagi!"});</script>.');
							header("Location: /");
						}
					}
				}
			}
		}
	}
}
require '../lib/csrf_token.php';
?>