<?php
require '../mainconfig.php';
if (isset($_SESSION['login'])) {
	exit(header("Location: ".$config['web']['base_url']));
}
if (isset($_GET['id']) AND isset($_GET['aktifasi'])) {
	$data_target = $model->db_query($db, "*", "users",  "code_v = '".$_GET['id']."' AND code_v2 = '".$_GET['aktifasi']."'");
	if ($data_target['count'] == 0) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal', 'msg' => 'Data Tidak Ditemukan');
		exit(header("Location: ".$config['web']['base_url']."auth/login"));
	} else {
		$user_data = $model->db_query($db, "*", "users",  "id = '".$data_target['rows']['user_id']." AND code_v = '".mysqli_real_escape_string($_GET['id'], $db)."' AND code_v2 = '".mysqli_real_escape_string($_GET['aktifasi'], $db)."'");
		if ($_POST) {
			$input_name = array('username','verifikasi');
			if (check_input($_POST, $input_name) == false) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Input tidak sesuai.');
			} else {
				$validation = array(
				    'username' => input_request($_POST['username'], $db),
					'verif' => input_request($_POST['verifikasi'], $db),
				);
				if (check_empty($validation) == true) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Input tidak boleh kosong.');
				} else if ($data_target['rows']['status'] == "1") {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Akun sudah Aktif sebelumnya');
				} else if ($validation['verif'] != $data_target['rows']['code_v']) {
				    $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kode Verifikasi Salah');
				} else if (strlen($validation['verfikasi']) > 6){
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kode Verifikasi tidak boleh melebihi 6 Karakter.');
				} else {
					$input_post = array(
						'status' => "1",
					);
                    $insert = $model->db_update($db, "users", $input_post, "code_v = '".$_GET['id']."'");
					if ($insert == true) {
						$_SESSION['result'] = array('alert' => 'success', 'title' => 'Berhasil!.', 'msg' => 'Akun berhasil diaktifkan, Silakan masuk untuk melanjutkan.');
						$model->db_insert($db, "notify_wa", array('user' => $data_target['rows']['username'], 'nomor' => $data_target['rows']['nomor'], 'msg' => 'Selamat, Akun anda berhasil diaktifkan! '.$tab_1.'Silakan masuk untuk memulai transaksi di *'.$config['web']['title'].'* '.$tab_1.'Terima Kasih. '.$tab_2.'*~ BEST REGARDS ~*', 'status' => 'Pending', 'type' => 'Verifikasi'));
					} else {
						$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Verifikasi Gagal.');
					}
				}
			}
		}
	}
}
require '../lib/header_auth.php';
?>
<div class="forny-form">
        <div class="mb-8 text-center forny-logo">
            <img src="<?php echo $config['web']['base_url']; ?>assets/images/logo.jpg" style="border-radius: 9px; width:180px; height:150px;">
        </div>
        <div class="text-center">
            <h4>Log in to your account.</h4>
        </div>
        <div class="col-md-12">
                        <?php
                            if (isset($_SESSION['result'])) {
                        ?>
                      <div class="alert alert-<?php echo $_SESSION['result']['alert'] ?> alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;
                          </span>
                        </button>
                        <div class="alert-text">
                          <strong><?php echo $_SESSION['result']['title'] ?>.
                          </strong> 
                          <br>
                          <?php echo $_SESSION['result']['msg'] ?>
                          </div>
                      </div>
                      <?php
                        unset($_SESSION['result']);
                        }
                    ?>
                    </div>
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="16" viewBox="0 0 24 16">
                                <g transform="translate(0)">
                                    <path d="M23.983,101.792a1.3,1.3,0,0,0-1.229-1.347h0l-21.525.032a1.169,1.169,0,0,0-.869.4,1.41,1.41,0,0,0-.359.954L.017,115.1a1.408,1.408,0,0,0,.361.953,1.169,1.169,0,0,0,.868.394h0l21.525-.032A1.3,1.3,0,0,0,24,115.062Zm-2.58,0L12,108.967,2.58,101.824Zm-5.427,8.525,5.577,4.745-19.124.029,5.611-4.774a.719.719,0,0,0,.109-.946.579.579,0,0,0-.862-.12L1.245,114.4,1.23,102.44l10.422,7.9a.57.57,0,0,0,.7,0l10.4-7.934.016,11.986-6.04-5.139a.579.579,0,0,0-.862.12A.719.719,0,0,0,15.977,110.321Z" transform="translate(0 -100.445)"/>
                                </g>
                            </svg>
                        </span>
                </div>
                <input required  class="form-control" name="username" type="text" value="<?php echo $data_target['rows']['username']; ?>" readonly>
            </div>
        </div>
        <div class="form-group password-field">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="24" viewBox="0 0 16 24">
                        <g transform="translate(0)">
                            <g transform="translate(5.457 12.224)">
                            <path d="M207.734,276.673a2.543,2.543,0,0,0-1.749,4.389v2.3a1.749,1.749,0,1,0,3.5,0v-2.3a2.543,2.543,0,0,0-1.749-4.389Zm.9,3.5a1.212,1.212,0,0,0-.382.877v2.31a.518.518,0,1,1-1.035,0v-2.31a1.212,1.212,0,0,0-.382-.877,1.3,1.3,0,0,1-.412-.955,1.311,1.311,0,1,1,2.622,0A1.3,1.3,0,0,1,208.633,280.17Z" transform="translate(-205.191 -276.673)"/>
                            </g>
                            <path d="M84.521,9.838H82.933V5.253a4.841,4.841,0,1,0-9.646,0V9.838H71.7a1.666,1.666,0,0,0-1.589,1.73v10.7A1.666,1.666,0,0,0,71.7,24H84.521a1.666,1.666,0,0,0,1.589-1.73v-10.7A1.666,1.666,0,0,0,84.521,9.838ZM74.346,5.253a3.778,3.778,0,1,1,7.528,0V9.838H74.346ZM85.051,22.27h0a.555.555,0,0,1-.53.577H71.7a.555.555,0,0,1-.53-.577v-10.7a.555.555,0,0,1,.53-.577H84.521a.555.555,0,0,1,.53.577Z" transform="translate(-70.11)"/>
                        </g>
                    </svg>
                </span>
            </div>
            <input required  class="form-control" name="verifikasi" type="number">

        </div>
    </div>
    <div>
        <button type="submit" class="btn btn-primary btn-block">Verifikasi</button>
    </div>
</form>
    </div>
</div>

</div>

<script src="<?php echo $config['web']['base_url']; ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo $config['web']['base_url']; ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo $config['web']['base_url']; ?>assets/js/main.js"></script>
    <script src="<?php echo $config['web']['base_url']; ?>assets/js/demo.js"></script>
    
</body>

</html>