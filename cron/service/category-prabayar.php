<?php
   require_once("../../mainconfig.php");

    $check_provider = mysqli_query($db, "SELECT * FROM provider WHERE name = 'DIGIFLAZZ'");
    $data_provider = mysqli_fetch_assoc($check_provider);

    $p_apiid = $data_provider['api_id'];
    $p_apikey = $data_provider['api_key'];

    $url = "https://api.digiflazz.com/v1/price-list";
    $sign = md5("$p_apiid+$p_apikey+pricelist");

    $data = array( 
        'cmd' => "prepaid",
	    'username' => $p_apiid,
	    'sign' => $sign
    );
    $header = array(
    'Content-Type: application/json',
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);
    // echo $response;
    // die;
    $result = json_decode($response);
    // print_r($result);

$indeks=0; 
$i = 1;
// get data service
foreach($result->data as $data) {

$category = $data->category;
$brand = $data->brand;
$indeks++; 
$i++;
// end get data service 

$cek_kategori = mysqli_query($db, "SELECT * FROM service_type WHERE code = '$brand' AND name = '$brand' AND type = '$category'");
$data_services = mysqli_fetch_assoc($cek_kategori);
if (mysqli_num_rows($cek_kategori) > 0) {
    echo "Kategori Sudah Ada Di Database => $brand \n <br>";
} else {

$insert = mysqli_query($db, "INSERT INTO service_type (code, name, type) VALUES ('$brand','$brand','$category')"); //Memasukan Kepada Database (OPTIONAL)
if ($insert == TRUE) {
echo"===============<br>Kategori Prabayar Berhasil Di Tambahkan<br><br>Nama Kategori : $brand<br>Kode Kategori : $brand<br>Server : $category<br>Tipe : Pascabayar<br>===============<br>";
} else {
    echo "Gagal Menampilkan Data Kategori Prabayar.<br />";
}
}
}
?>