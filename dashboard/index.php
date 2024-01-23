<?php
    require '../mainconfig.php';
    if (isset($_SESSION['login'])) {
        require '../lib/is_login.php';
    } else {
        header("Location: ".$config['web']['base_url']."public");
    }

    $ua = $_SERVER['HTTP_USER_AGENT'];
    if(preg_match('#Mozilla/4.05 [fr] (Win98; I)#',$ua) || preg_match('/Java1.1.4/si',$ua) || preg_match('/MS FrontPage Express/si',$ua) || preg_match('/HTTrack/si',$ua) || preg_match('/IDentity/si',$ua) || preg_match('/HyperBrowser/si',$ua) || preg_match('/Lynx/si',$ua)) 
    {
    header('Location:https://mycoding.id');
    die();
    }
    
    require '../lib/header.php';
    if (isset($_SESSION['login'])) {
    $query ="SELECT * FROM carousel ORDER BY id DESC";
    $result = mysqli_query($db,$query);
    $no = 1;
?>

<!-- page header and toolbox -->
<div class="header-large-title pt-3">
    <span class="subtitle">Saldo</span>
        <h3 class="title mt-0">Rp
          <?php echo number_format($login['balance'],0,',','.'); ?> 
        </h3>
</div>

<section class="card-section pt-2 wd-100">
      <card style="border-radius: .90rem">
          <card-body class="p-0">
              <menu>
                  <a style="text-decoration:none" href="javascript:;" onclick="javascript:location.href='<?php echo $config['web']['base_url']; ?>deposit/new'" class="item">
                      <div class="col">
                          <menu-icon class="ri-wallet-fill"></menu-icon>
                      <span>Isi Saldo</span>
                      </div>
                  </a>
                  <a style="text-decoration:none" href="javascript:;" onclick="javascript:location.href='<?php echo $config['web']['base_url']; ?>staff/transfer'" class="item">
                      <div class="col">
                          <menu-icon class="ri-exchange-funds-fill"></menu-icon>
                          <span>Kirim Saldo</span>
                      </div>
                  </a>
                  <div class="col border-left-dotted-blue">
                  <a href="javascript:;" onclick="javascript:location.href='<?php echo $config['web']['base_url']; ?>pages/contact'" class="item">
                      <div class="col">
                          <menu-icon class="ri-customer-service-2-line"></menu-icon>
                          <span>Bantuan</span>
                      </div>
                  </a>
                  </div>
              </menu>
          </card-body>
      </card>
</section>
<?php
if (mysqli_num_rows($result) == 0) {

} else { ?>
<style type="text/css">
    .carousel-item {
        position: relative;
        display: none;
        float: left;
        width: 100%;
        margin-right: -100%;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        transition: -webkit-transform .6s ease-in-out;
        transition: transform .6s ease-in-out;
        transition: transform .6s ease-in-out,-webkit-transform .6s ease-in-out;
    }
</style>

<section class="pt-2 wd-100">
    <div id="carouselExampleCaptions" style="border-radius: 9px;" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php
                for($i=0; $i<mysqli_num_rows($result);$i++){
                    echo '<li data-target="#carouselExampleCaptions" data-slide-to="'.$i.'"';
                    if($i==0){echo'class="active"';}echo'></li>';
                }
            ?>
        </ol>

        <div class="carousel-inner">
           <?php
               if(mysqli_num_rows($result) > 0) {
                    foreach ($result as $key => $value) {
                        $active = ($key == 0) ? 'active' : '';
                        echo'<div class="carousel-item '.$active.'">';

                        echo'<a style="text-decoration:none"  href="'.$config['web']['base_url'].'halaman/informasi/'.$value['id'].'"><img src="'.$config['web']['base_url'].'dist/images/banner/'.$value['file'].'" class="d-block w-100" style="border-radius: 9px; max-width:100%;" alt="'.$value['created_at'].'"></a></div>';
                    }
                }
            ?>
        </div>

        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>

        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>

    </div>
</section>
<? } ?>

<section class="pt-3 mt-3 wd-100">
    <div class="col-lg-12 pull-left" style="margin: 15px 0;">
		<b>Prabayar</b>
	</div>
    <div class="row mt-3">
        <div class="_1ekcz mt-1" style="width: 100%;">
            <div class="_24EoF">
                <a style="text-decoration:none" href="javascript:;" onclick="javascript:location.href='<?php echo $config['web']['base_url']; ?>beli/pulsa'">
                    <div class="avatar avatar-40 no-shadow border-0">
                        <div class="overlay gradient-primary"><img class="img-fluid" src="<?php echo $config['web']['base_url']; ?>dist/images/smartphone.png" alt="Pulsa Reguler" style="height: 30px;"></div>
                    </div>
                    <br />
                    <span title="Pulsa">Pulsa</span>
                </a>
            </div>
            <div class="_24EoF">
                <a style="text-decoration:none" href="javascript:;" onclick="javascript:location.href='<?php echo $config['web']['base_url']; ?>beli/paket-data'">
                    <div class="avatar avatar-40 no-shadow border-0">
                        <div class="overlay gradient-primary"><img class="img-fluid" src="<?php echo $config['web']['base_url']; ?>dist/images/wifi(1).png" alt="Paket Data" style="height: 30px;"></div>
                    </div>
                    <br />
                    <span title="Paket Data">Data</span>
                </a>
            </div>
            <div class="_24EoF">
                <a style="text-decoration:none" href="javascript:;" onclick="javascript:location.href='<?php echo $config['web']['base_url']; ?>beli/paket-telponsms'">
                    <div class="avatar avatar-40 no-shadow border-0">
                        <div class="overlay gradient-primary"><img class="img-fluid" src="<?php echo $config['web']['base_url']; ?>dist/images/chatting.png" alt="Paket SMS & Telpon" style="height: 30px;"></div>
                    </div>
                    <br />
                    <span title="Paket Telpon">Telp & SMS</span>
                </a>
            </div>
            <div class="_24EoF">
                <a style="text-decoration:none" href="javascript:;" onclick="javascript:location.href='<?php echo $config['web']['base_url']; ?>beli/e-money'">
                    <div class="avatar avatar-40 no-shadow border-0">
                        <div class="overlay gradient-primary"><img class="img-fluid" src="<?php echo $config['web']['base_url']; ?>dist/images/tap.png" alt="Saldo E-Money" style="height: 30px;"></div>
                    </div>
                    <br />
                    <span title="Saldo E-Money">E-Money</span>
                </a>
            </div>
            <div class="_24EoF">
                <a style="text-decoration:none" href="javascript:;" onclick="javascript:location.href='<?php echo $config['web']['base_url']; ?>beli/token-listrik'">
                    <div class="avatar avatar-40 no-shadow border-0">
                        <div class="overlay gradient-primary"><img class="img-fluid" src="<?php echo $config['web']['base_url']; ?>dist/images/wireless.png" alt="Token PLN" style="height: 30px;"></div>
                    </div>
                    <br />
                    <span title="Token PLN">PLN</span>
                </a>
            </div>
            <div class="_24EoF">
                <a style="text-decoration:none" href="javascript:;" onclick="javascript:location.href='<?php echo $config['web']['base_url']; ?>beli/voucher-game'">
                    <div class="avatar avatar-40 no-shadow border-0">
                        <div class="overlay gradient-primary"><img class="img-fluid" src="<?php echo $config['web']['base_url']; ?>dist/images/video-game.png" alt="Voucher Games" style="height: 30px;"></div>
                    </div>
                    <br />
                    <span title="Voucher Games">Games</span>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-12 pull-left" style="margin: 15px 0;">
		<b>Pascabayar</b>
	</div>
    <div class="row mt-3">
        <div class="_1ekcz mt-1" style="width: 100%;">
            <div class="_24EoF">
                <a style="text-decoration:none" href="javascript:;" onclick="javascript:location.href='<?php echo $config['web']['base_url']; ?>tagihan/pln'">
                    <div class="avatar avatar-40 no-shadow border-0">
                        <div class="overlay gradient-primary"><img class="img-fluid" src="<?php echo $config['web']['base_url']; ?>dist/images/wireless.png" alt="Paket Data" style="height: 30px;"></div>
                    </div>
                    <br />
                    <span title="PLN Pascabayar">PLN</span>
                </a>
            </div>
            <div class="_24EoF">
                <a style="text-decoration:none" href="javascript:;" onclick="javascript:location.href='<?php echo $config['web']['base_url']; ?>tagihan/bpjs'">
                    <div class="avatar avatar-40 no-shadow border-0">
                        <div class="overlay gradient-primary"><img class="img-fluid" src="<?php echo $config['web']['base_url']; ?>dist/images/bpjs.png" alt="Paket SMS & Telpon" style="height: 30px;"></div>
                    </div>
                    <br />
                    <span title="BPJS">BPJS</span>
                </a>
            </div>
            <div class="_24EoF">
                <a style="text-decoration:none" href="javascript:;" onclick="javascript:location.href='<?php echo $config['web']['base_url']; ?>tagihan/pdam'">
                    <div class="avatar avatar-40 no-shadow border-0">
                        <div class="overlay gradient-primary"><img class="img-fluid" src="<?php echo $config['web']['base_url']; ?>dist/images/clean-water.png" alt="Token PLN" style="height: 30px;"></div>
                    </div>
                    <br />
                    <span title="PDAM">PDAM</span>
                </a>
            </div>
            <div class="_24EoF">
                <a style="text-decoration:none" href="javascript:;" onclick="javascript:location.href='<?php echo $config['web']['base_url']; ?>tagihan/gas'">
                    <div class="avatar avatar-40 no-shadow border-0">
                        <div class="overlay gradient-primary"><img class="img-fluid" src="<?php echo $config['web']['base_url']; ?>dist/images/pgn1.png" alt="Gas" style="height: 30px;"></div>
                    </div>
                    <br />
                    <span title="PGN">PGN</span>
                </a>
            </div>
            <div class="_24EoF">
                <a style="text-decoration:none" href="javascript:;" onclick="javascript:location.href='<?php echo $config['web']['base_url']; ?>tagihan/finance'">
                    <div class="avatar avatar-40 no-shadow border-0">
                        <div class="overlay gradient-primary"><img class="img-fluid" src="<?php echo $config['web']['base_url']; ?>dist/images/bill.png" alt="Finance" style="height: 30px;"></div>
                    </div>
                    <br />
                    <span title="Finance">Finance</span>
                </a>
            </div>
            <div class="_24EoF">
                <a style="text-decoration:none" href="javascript:;" onclick="javascript:location.href='<?php echo $config['web']['base_url']; ?>tagihan/internet'">
                    <div class="avatar avatar-40 no-shadow border-0">
                        <div class="overlay gradient-primary"><img class="img-fluid" src="<?php echo $config['web']['base_url']; ?>dist/images/bill.png" alt="Internet" style="height: 30px;"></div>
                    </div>
                    <br />
                    <span title="Internet">Internet</span>
                </a>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $('#informasi').modal('show');
    function baca_informasi() {
    	$.ajax({
    		 type: "GET",
    		 url: "<?php echo $config['web']['base_url']; ?>ajax/read.php"
    	});
    }
</script>

<?php }
    require '../lib/footer.php';
?>