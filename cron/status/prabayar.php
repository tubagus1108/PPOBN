<?php
require "../../mainconfig.php";

$check_order = mysqli_query(
    $db,
    "SELECT * FROM orders_mobile WHERE status IN ('','Pending','Processing') AND provider = 'DIGIFLAZZ'"
);

if (mysqli_num_rows($check_order) == 0) {
    die("Pesanan Pending Tidak Ditemukan.");
} else {
    while ($data_order = mysqli_fetch_assoc($check_order)) {
        $o_oid = $data_order['oid'];
        $o_poid = $data_order['poid'];
        $phone = $data_order['phone'];
        $username = $data_order['user'];
        $service = $data_order['service'];
        $o_provider = $data_order['provider'];
    
        
        $check_user = $model->db_query($db, "*", "users", "BINARY username = '".$username."'");

        if ($o_provider == "MANUAL") {
            echo "Pesanan Manual<br />";
        } else {
            $check_provider = mysqli_query(
                $db,
                "SELECT * FROM provider WHERE name = 'DIGIFLAZZ'"
            );
            $data_provider = mysqli_fetch_assoc($check_provider);

            $p_id = $data_provider['api_id'];
            $p_apikey = $data_provider['api_key'];
            $p_link = $data_provider['api_url_order'];

            $check_service = mysqli_query(
                $db,
                "SELECT * FROM services_pulsa WHERE service LIKE '$service'"
            );
            $data_service = mysqli_fetch_assoc($check_service);
            $pid = $data_service['pid'];

            if ($o_provider == "DIGIFLAZZ") {
                $sign = md5($p_id . $p_apikey . $o_poid);
                //$postdata = "username=$p_id&buyer_sku_code=$pid&customer_no=$phone&ref_id=$o_poid&sign=$sign";
                $postdata = [
                    "username" => $p_id,
                    "buyer_sku_code" => $pid,
                    "customer_no" => $phone,
                    "ref_id" => $o_poid,
                    "sign" => $sign,
                ];
            } else {
                die("System error!");
            }

            $data_string = json_encode($postdata);

            $ch = curl_init($p_link);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string),
            ]);
            $chresult = curl_exec($ch);
            curl_close($ch);
            $json_result = json_decode($chresult, true);

            if ($o_provider == "DIGIFLAZZ") {
                $u_status2 = $json_result['data']['status'];
                $u_catatan = $json_result['data']['sn'];

                if ($u_status2 == "Sukses") {
                    $u_status = "Success";
                } elseif ($u_status2 == "Gagal") {
                    $u_status = 'Error';
                }
                $update_order = mysqli_query(
                    $db,
                    "UPDATE orders_mobile SET status = '$u_status', catatan = '$u_catatan' WHERE oid = '$o_oid'"
                );
                if ($update_order == true) {
                    //$model->db_insert($db, "notify_wa", array('user' => $check_user['rows']['username'], 'nomor' => $check_user['rows']['nomor'], 'msg' => 'Berikut Status Pesanan Prabayar Terbaru Anda '.$tab_2.'Transaksi ID : '.$o_oid.''.$tab_1.'Nama Layanan: '.$service.''.$tab_1.'Status : '.$u_status.''.$tab_1.'SN / Catatan : '.$u_catatan.''.$tab_2.' Terima kasih telah bertransaksi di *'.$config['web']['title'].'* Semoga hari mu menyenangkan '.$check_user['full_name'].' '.$tab_2.'Salam, '.$tab_1.'Jeremy & Team', 'status' => 'Pending', 'type' => 'Status'));
                    echo "===============<br>Status Pulsa Berhasil Di Update<br><br>ID Provider : $o_oid<br>Status : $u_status<br>Keterangan : $u_catatan<br>===============<br>";
                }
            } else {
                echo "Gagal Menampilkan Data Status Pulsa.";
            }
        }
    }
}
