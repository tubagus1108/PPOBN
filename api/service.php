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
			$username = $data_user['username'];
			if ($post_action == "service"){
			    //INI LAYANAN
			    $querys = mysqli_query($db, "SELECT * FROM services WHERE status = 'Active' ORDER BY sid ASC");
		        $exe = mysqli_query($querys);
				while($row = mysqli_fetch_array($querys)){
				    $array = "-";
				    $datas[] = array('sid' => $row['sid'], 'category' => $row['category'], 'service' => $row['service'], 'note' => $row['note'], 'min' => $row['min'], 'max' => $row['max'], 'status' => $row['status'], 'price' => $row['price']);
                }
                echo json_encode(array('status' => 'success', 'result' => $datas));

			} else {
				$array = array("error" => "Wrong action");
			}
} else {
    $array = array("error" => "API Key tidak terdaftar / Pengguna tidak ditemukan"); 
    }
}
} else {
    $array = array("error" => "Terjadi kesalahan!");  
}
$print = json_encode($array);
print_r($print);