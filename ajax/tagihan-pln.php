<style>
	.container_custom {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 5px;
        cursor: pointer;
        font-size: 12px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        font-weight:normal;
        background-color:#f1f1f1;
        max-width:100%;
        outline:0;
        padding-top:9px;
        padding-bottom:9px;
        border-radius:4px;
    }
    
    card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 0;
        border-radius: 6px;
        box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.1), 0 1px 3px 0 rgba(0, 0, 0, 0.08);
    }
card card-body {
    padding: 24px 16px;
    padding-top: 24px;
    padding-bottom: 24px;
    line-height: 1.4em;
}
.p-3 {
    padding: 1rem !important;
}
.align-items-center {
    -ms-flex-align: center !important;
    align-items: center !important;
}

.justify-content-between {
    -ms-flex-pack: justify !important;
    justify-content: space-between !important;
}

.d-flex {
    display: -ms-flexbox !important;
    display: flex !important;
}
.mt-2, .my-2 {
    margin-top: .5rem !important;
}
element {
    display: inline-flex;
}
*, ::after, ::before {
    box-sizing: border-box;
}
element {
    display: grid;
    padding-left: 8px;
}
*, ::after, ::before {
    box-sizing: border-box;
}
element {
    color: #000;
}
a {
    color: var(--iq-primary);
}
a, button, input, btn {
    outline: medium none !important;
}
a, .btn {
    -webkit-transition: all 0.5s ease-out 0s;
    -moz-transition: all 0.5s ease-out 0s;
    -ms-transition: all 0.5s ease-out 0s;
    -o-transition: all 0.5s ease-out 0s;
    transition: all 0.5s ease-out 0s;
}
a {
    color: #50b5ff;
    text-decoration: none;
    background-color: transparent;
}
</style>
			
<?php
require '../mainconfig.php';
$order_id = random_number(3).random_number(4);
error_reporting(0);
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(isset($_POST['data']) && isset($_POST['type'])) {
        if(!isset($_POST['data'])) exit("No direct script access allowed!");
        if(!isset($_POST['type']) || !in_array($_POST['type'],['PLN'])) exit("No direct script access allowed!");
        if(empty($_POST['data'])) print '<div class="alert alert-info">Mohon masukan nomor pelanggan.</div>';
    
        $post_type = $_POST['type'];
        $post_phone = mysqli_real_escape_string($db, $_POST['data']);
    
        $search = mysqli_query($db, "SELECT * FROM services_pascabayar WHERE type = '$post_type' AND status = 'Active' ORDER BY id ASC");
        $service = mysqli_fetch_assoc($search);
        if(mysqli_num_rows($search) == 0) {
            print '<div class="alert alert-danger">Layanan tidak tersedia.</div>';
        } else {
        $cek_provider = mysqli_query($db, "SELECT * FROM provider WHERE name = 'DIGIFLAZZ'");
        $provider = mysqli_fetch_assoc($cek_provider);
        
        $api_id = $provider['api_id'];
        $api_key = $provider['api_key'];
        $api_link = $provider['api_url_order'];
        
        
        $data = json_encode(array(
            'commands' => 'inq-pasca',
            'username' => $api_id, // konstan
            'buyer_sku_code' => $service['pid'],
            'customer_no' => $post_phone,
            'ref_id' => $order_id,
            'sign' => md5("$api_id$api_key$order_id"),
            ));
        $header = array(
            'Content-Type: application/json',
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.digiflazz.com/v1/transaction');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        $chresult = json_decode($result, true);
        
        $customer_name = $chresult['data']['customer_name'];
        $sn = $chresult['data']['sn'];
        $price = $chresult['data']['selling_price'];
        $fee = $chresult['data']['admin'];
        $lembar = $chresult['data']['desc']['lembar_tagihan'];
                
            
        if ($chresult['data']['status'] == "Gagal") { ?>
           <div class="alert alert-danger">Ups, <?php echo $chresult['data']['message']; ?>.</div>
        <? } else { ?>

            <p><?php echo $customer_name; ?></p>

        <?
        }
            }
    } else {
        print '<div class="alert alert-danger">Error</div>';
    }
} else {
    exit("No direct script access allowed!");
} ?>