<?php
   require_once("../../mainconfig.php");

    $check_provider = mysqli_query($db, "SELECT * FROM provider WHERE name = 'DIGIFLAZZ'");
    $data_provider = mysqli_fetch_assoc($check_provider);

    $p_apiid = $data_provider['api_id'];
    $p_apikey = $data_provider['api_key'];

    $url = "https://api.digiflazz.com/v1/price-list";
    $sign = md5("$p_apiid+$p_apikey+pricelist");

    $data = array( 
        'cmd' => "pasca",
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

$type = $data->brand;
$category = $data->category;
$produk_name = $data->product_name;
$indeks++; 
$i++;
// end get data service 

$cek_kategori = mysqli_query($db, "SELECT * FROM service_cat_pasca WHERE code = '$produk_name' AND name = '$produk_name' AND type = '$type'");
$data_services = mysqli_fetch_assoc($cek_kategori);
if (mysqli_num_rows($cek_kategori) > 0) {
    echo "Kategori Sudah Ada Di Database => $produk_name \n <br>";
} else {

$insert = mysqli_query($db, "INSERT INTO service_cat_pasca (code, name, type) VALUES ('$produk_name','$produk_name','$type')"); //Memasukan Kepada Database (OPTIONAL)
if ($insert == TRUE) {
echo"===============<br>Kategori Pascabayar Berhasil Di Tambahkan<br><br>Nama Kategori : $produk_name<br>Kode Kategori : $produk_name<br>Server : $type<br>Tipe : Pascabayar<br>===============<br>";
} else {
    echo "Gagal Menampilkan Data Kategori Pascabayar.<br />";
}
}
}
?>