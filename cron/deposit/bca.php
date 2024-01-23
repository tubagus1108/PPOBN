<?php
error_reporting(E_ALL);
require("../../mainconfig.php");
$tglcek = date("Y-m-d");
$check = mysqli_query($db,"SELECT * FROM deposits WHERE type = 'auto' AND method_name = 'BCA' AND status = 'Pending'");

if (mysqli_num_rows($check) == 0) {
    	die("Deposite Checking not found.");
} else {
    while($deposit_data = mysqli_fetch_assoc($check)) {
        $user_id = $deposit_data['user_id'];
        $code = $deposit_data['id'];
        $getbalance = $deposit_data['post_amount'];
        $get_balance = $deposit_data['amount'];
        $tipe_saldo = $deposit_data['type_balance'];
        $created_at = $deposit_data['created_at'];
        
        $check_user = $model->db_query($db, "*", "users", "BINARY id = '".$user_id."'");    
        
if(date("Y-m-d", strtotime($created_at)) != $tglcek){
    $cancel = $db->query("UPDATE deposits SET status = 'Error' WHERE id = '$code'");
} else {
$data = array(
            "search"  => array(
                    "date"            => array(
                            "from"    => date("Y-m-d")." 00:00:00",
                            "to"      => date("Y-m-d")." 23:59:59"
                            ),
                    "service_code"    => "bca",
                    "account_number"  => "1950688871",
                    "amount"          => $getbalance.".00"
            )
);

$ch = curl_init();
curl_setopt_array($ch, array(
    CURLOPT_URL             => "https://api.cekmutasi.co.id/v1/bank/search",
    CURLOPT_POST            => true,
    CURLOPT_POSTFIELDS      => http_build_query($data),
    CURLOPT_HTTPHEADER      => ["Api-Key: 3719a99815c4649e26284e133d132fde615efa8eb269e", "Accept: application/json"], // tanpa tanda kurung
    CURLOPT_RETURNTRANSFER  => true,
    CURLOPT_HEADER          => false,
    CURLOPT_IPRESOLVE		=> CURL_IPRESOLVE_V4,
));
$respon = curl_exec($ch);
curl_close($ch);
echo $respon;

if(json_decode($respon,true)['response'][0]['account_number'] == '1950688871'){
            $update = $db->query("UPDATE deposits SET status = 'Success' WHERE id = '$code'");
            $update = $db->query("UPDATE users SET balance = balance+$get_balance WHERE id = '$user_id'");
}
        if ($update == TRUE) {
            echo "Berhasil menambahkan saldo ke $code <br>";
        } else {
            echo "gagal <br>";
        }
}
    }
}
?>