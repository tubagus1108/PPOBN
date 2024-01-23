<style>
a {
    color: #50b5ff;
    text-decoration: none;
    background-color: transparent;
}
</style>
			
<?php
require '../../mainconfig.php';
error_reporting(0);
$order_id = random_number(3).random_number(4);
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(isset($_POST['data']) && isset($_POST['type'])) {
        if(!isset($_POST['data'])) exit("No direct script access allowed!");
        if(!isset($_POST['type']) || !in_array($_POST['type'],['GAS'])) exit("No direct script access allowed!");
        if(empty($_POST['data'])) print '<div class="alert alert-info">Mohon masukan nomor pelanggan.</div>';
    
        $post_type = $_POST['type'];
        $post_phone = mysqli_real_escape_string($db, $_POST['data']);
    
        $search = mysqli_query($db, "SELECT * FROM services_pascabayar WHERE type = '$post_type' AND status = 'Active' ORDER BY id ASC");
        $service = mysqli_fetch_assoc($search);
        if ($login['user_verif'] == 1) {
            $admin = $service['price_agen'];
        } else {
            $admin = $service['price'];
        }
        if(mysqli_num_rows($search) == 0) {
            print '<div class="alert alert-danger">Layanan tidak tersedia.</div>';
        } else {
        $cek_provider = mysqli_query($db, "SELECT * FROM provider WHERE name = 'DIGIFLAZZ'");
        $provider = mysqli_fetch_assoc($cek_provider);
        
        $api_id = $provider['api_id'];
        $api_key = $provider['api_key'];
        $api_link = $provider['api_url_order'];
        
        
        $post_api = array('commands' => 'inq-pasca', 'username' => $api_id, // konstan
            'buyer_sku_code' => $service['pid'],
            'customer_no' => $post_phone,
            'ref_id' => $order_id,
            'sign' => md5("$api_id$api_key$order_id"),
            );
        $data = json_encode($post_api);
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
            <center><img src="<?php echo $config['web']['base_url']; ?>dist/images/nodata.png" style="width:500px;"></center>
            <center style="margin-top:-50px;"><b>Ups, <?php echo $chresult['data']['message']; ?>.</b></center>
        <? } else { ?>

            <div class="row mt-4">
                <div class="col-12 col-lg-12">
                  <div class="card dcard mb-4">
                    <div class="card-body px-4 px-lg-5">

                      <div class="text-center">
                        <span class="text-dark-m3 text-140">
                            Detail Tagihan
                        </span>
                        <br />
                        <span class="text-dark-l2 text-90">
                        <b><?php echo $config['web']['title']; ?></b>
                    </span>
                      </div>
                      <div class="mt-4">
                        <div class="row text-600 text-95 text-secondary-d3 brc-green-l1 py-25 border-y-2">

                          <div class="col-12 col-sm-12">
                            <b>Informasi Pelanggan</b>
                          </div>
                        </div>

                        <div class="text-95 text-dark-m3">
                          <div class="row mb-2 mb-sm-0 py-25">

                            <div class="col-7 col-sm-5">
                              <b>Nomor Pelanggan</b>
                            </div>
                            
                            <div class="col-5 col-sm-2 text-secondary-d3 text-600">
                              <b><?php echo $chresult['data']['customer_no']; ?></b>
                            </div>
                            
                          </div>
                          
                          <div class="row mb-2 mb-sm-0 py-25">

                            <div class="col-7 col-sm-5">
                              <b>Nama Pelanggan</b>
                            </div>

                            <div class="col-5 col-sm-2 text-secondary-d3 text-600">
                              <b><?php echo $customer_name; ?></b>
                            </div>
                          </div>
                          
                          <div class="row mb-2 mb-sm-0 py-25">

                            <div class="col-7 col-sm-5">
                              <b>Alamat</b>
                            </div>
                            
                            <div class="col-5 col-sm-2 text-secondary-d3 text-600">
                              <b><?php echo $chresult['data']['desc']['alamat']; ?></b>
                            </div>
                            
                          </div>
                          
                          <div class="row mb-2 mb-sm-0 py-25">

                            <div class="col-7 col-sm-5">
                              <b>Meter Awal</b>
                            </div>
                            
                            <div class="col-5 col-sm-2 text-secondary-d3 text-600">
                              <b><?php echo $chresult['data']['desc']['detail']['meter_awal']; ?></b>
                            </div>
                            
                          </div>
                          <div class="row mb-2 mb-sm-0 py-25">

                            <div class="col-7 col-sm-5">
                              <b>Meter Akhir</b>
                            </div>
                            
                            <div class="col-5 col-sm-2 text-secondary-d3 text-600">
                              <b><?php echo $chresult['data']['desc']['detail']['meter_akhir']; ?></b>
                            </div>
                            
                          </div>
                          
                          <div class="row mb-2 mb-sm-0 py-25">

                            <div class="col-7 col-sm-5">
                              <b>Lembar Tagihan</b>
                            </div>
                            
                            <div class="col-5 col-sm-2 text-secondary-d3 text-600">
                              <b><?php echo $chresult['data']['desc']['lembar_tagihan']; ?></b>
                            </div>
                            
                          </div>
                        <div class="row text-600 text-95 text-secondary-d3 brc-green-l1 py-25 border-y-2">
                          <div class="col-12 col-sm-12">
                            <b>Detail Pembayaran</b>
                          </div>
                        </div>
                          <div class="row mb-2 mb-sm-0 py-25">
                            <div class="col-7 col-sm-5">
                              <b>Jumlah Tagihan</b>
                            </div>

                            <div class="col-5 col-sm-2 text-secondary-d3 text-600">
                              <b>Rp. <?php echo number_format($price,0,',','.'); ?></b>
                            </div>
                          </div>
                          
                          <div class="row mb-2 mb-sm-0 py-25">

                            <div class="col-7 col-sm-5">
                              <b>Biaya Transaksi</b>
                            </div>
                            
                            <div class="col-5 col-sm-2 text-secondary-d3 text-600">
                              <b>Rp. <?php echo number_format($admin,0,',','.'); ?></b>
                            </div>
                            
                          </div>
                        </div>

                        <div class="row border-b-2 brc-green-l1"></div>


                        <div class="row mt-4">
                          <div class="col-12 col-sm-7 mt-2 mt-lg-0">
                            <div class="row my-3 align-items-center bgc-green-d3 p-2 radius-1">
                              <div class="col-7 text-left text-white text-110">
                                Total bayar
                              </div>

                              <div class="col-5">
                                <span class="text-150 text-right text-white">
                                 Rp. <?php echo number_format($price+$admin,0,',','.'); ?>
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>

                        <hr class="brc-secondary-l3 border-t-2" />

                        <div class="text-center text-secondary-d3 text-105">
                            <form method="POST" action="<?php echo $config['web']['base_url']; ?>tagihan/bayar-tagihan.php">
                                <input type="hidden" name="nomor_pelanggan" value="<?php echo $chresult['data']['customer_no']; ?>">
                                <input type="hidden" name="service" value="<?php echo $service['pid']; ?>">
                                    <button type="submit" class="btn btn-blue py-2 text-600 letter-spacing-1 btn-block">
                                        Lanjutkan Pembayaran
                                    </button>
                            </form>
                        </div>

                      </div>

                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

        <?
        }
            }
    } else {
        print '<div class="alert alert-danger">Error</div>';
    }
} else {
    exit("No direct script access allowed!");
} ?>