<?php
require ("../../mainconfig.php");

$check_provider = mysqli_query($db, "SELECT * FROM provider WHERE name = 'DIGIFLAZZ'");
$data_provider = mysqli_fetch_assoc($check_provider);

$p_id = $data_provider['api_id'];
$p_apikey = $data_provider['api_key'];

$sign = md5($p_id . $p_apikey . "pricelist");
$apibase = "https://api.digiflazz.com/v1/price-list";
$postdata = array(
    "cmd" => "prepaid",
    "username" => $p_id,
    "sign" => $sign
);
$data_string = json_encode($postdata);

$ch = curl_init("https://api.digiflazz.com/v1/price-list");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string)
));
$chresult = curl_exec($ch);
curl_close($ch);
$infoapi2 = json_decode($chresult, true);
$i = 0;
foreach ($infoapi2['data'] as $infoapi)
{
    $post_name = $infoapi['product_name'];
    $post_category = $infoapi['category'];
    
    $post_brand = $infoapi['brand'];
    $post_seller_name = $infoapi['seller_name'];
    $post_buyer_sku_code = $infoapi['buyer_sku_code'];
    $post_desc = $infoapi['desc'];
    $post_price = $infoapi['price'];
    
    $target = array('Paket SMS & Telpon','');
    $replace = array('Paket SMS dan Telpon','');
    
    $category = str_replace($target,$replace,$post_category);
    
    $persen_member = (5/100) * $infoapi['price'];
    $persen_agen = (5/100) * $infoapi['price'];
    $post_price3 = $infoapi['price'] + $persen_agen;
    $post_price2 = $infoapi['price'] + $persen_member; 
    
    
    $i++;
    $cek = $db->query("SELECT * FROM services_pulsa WHERE sid = '$post_buyer_sku_code' AND provider = 'DIGIFLAZZ'");
    if (mysqli_num_rows($cek) == 1)
    {
        $cek = $cek->fetch_array(MYSQLI_ASSOC);

        if (ucwords(strtolower($cek['status'])) == "Active" AND $cek['price_provider'] == $post_price AND $cek['sid'] == $post_buyer_sku_code AND $cek['service'] == $post_name)
        {
            echo "<font color='blue'>DATA MASIH YANG SAMA : $post_buyer_sku_code -> " . $cek['sid'] . " || $post_name -> " . $cek['service'] . " || $post_price2 -> " . $cek['price'] . " <br /></font>";
        }
        else
        {
            $update = mysqli_query($db, "UPDATE services_pulsa SET price='$post_price2', price_agen = '$post_price3', price_provider = '$post_price', status = 'Active' WHERE sid = '$post_buyer_sku_code' AND provider = 'DIGIFLAZZ'");
            if ($update == true)
            {
                echo "<font color='green'><b>[up] Data berbeda dan udah di update</b></font> > Service ID = " . $post_buyer_sku_code . " | status " . ucwords(strtolower($cek['status'])) . " > Active, harga Pusat {$cek['price_provider']} > $post_price2 <br \>";
            }
            else
            {
                echo "<font color='red'><b>[up] Gagal update Layanan</b></font> > Service ID = " . $post_buyer_sku_code . " , Name = " . $post_name . " <br \>";
            }
        }
    }
    else
    {
        $i++;
        $insert = $db->query("INSERT INTO services_pulsa (sid, pid, type, oprator, service, note, price, price_agen, status, provider, price_provider) VALUES ('$post_buyer_sku_code', '$post_buyer_sku_code', '$category', '$post_brand', '$post_name', '$post_desc', '$post_price2', '$post_price3', 'Active', 'DIGIFLAZZ', '$post_price')");
        if ($insert == true)
        {
            echo "<font color='green'><b>[+] Sukses Menambahkan Layanan</b></font> > Service ID = " . $post_buyer_sku_code . " , Name = " . $post_name . ", Price = " . $post_price2 . " <br \>";
        }
        else
        {
            echo "GAGAL MEMASUKAN DATA <br \>";
        }
    }
}