<?php
require '../mainconfig.php';
if (isset($_SESSION['login'])) {
	exit(header("Location: ".$config['web']['base_url']));
}
if (isset($_GET['code']) AND isset($_GET['validasi'])) {
	$data_target = $model->db_query($db, "*", "verifikasi_kode",  "kode = '".$_GET['code']."' AND validasi = '".$_GET['validasi']."'");
	if ($data_target['count'] == 0) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal', 'msg' => 'Data Tidak Ditemukan');
		exit(header("Location: ".$config['web']['base_url']."auth/login"));
	} else {
		$user_data = $model->db_query($db, "*", "users",  "username = '".$data_target['rows']['user']."'");
		if ($_POST) {
			$input_name = array('password', 'c_password','kode');
			if (check_input($_POST, $input_name) == false) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Input tidak sesuai.');
			} else {
				$validation = array(
				    'password' => input_request($_POST['password'], $db),
				    'c_password' => input_request($_POST['c_password'], $db),
					'kode' => input_request($_POST['kode'], $db),
				);
				if (check_empty($validation) == true) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Input tidak boleh kosong.');
				} else if ($data_target['rows']['status'] == "1") {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Sudah tidak dapat melakukan reset password menggunakan link atau kode ini');
				} else if (strlen($validation['password']) < 5 ) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Password minimal 5 karakter.');
			} else if (strlen($validation['password']) > 15 ) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Password maksimal 15 karakter.');
				} else if ($validation['kode'] != $data_target['rows']['kode']) {
				    $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kode Verifikasi Salah');
				} else if (strlen($validation['kode']) > 6){
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Kode Verifikasi tidak boleh melebihi 6 Karakter.');
				} else if($validation['c_password'] != $validation['password']) {
				    $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Konfirmasi password tidak sama');
				} else {
					$input_post = array(
						'password' => $validation['password'],
					);
                    $insert = $model->db_update($db, "users", array('password' => password_hash($input_post['password'], PASSWORD_DEFAULT)), "username = '".$data_target['rows']['user']."'");
					if ($insert == true) {
						$_SESSION['result'] = array('alert' => 'success', 'title' => 'Berhasil!.', 'msg' => 'Password telah direset, silakan masuk.');
						$model->db_update($db, "verifikasi_kode", array('status' => 1), "kode = '".$validation['kode']."'");
						$model->db_insert($db, "notify_wa", array('user' => $data_target['rows']['user'], 'nomor' => $user_data['rows']['nomor'], 'msg' => 'Selamat, Password anda berhasil diubah! '.$tab_2.'Silakan masuk untuk memulai transaksi di *'.$config['web']['title'].'* '.$tab_1.'Terima Kasih. '.$tab_2.'*~ BEST REGARDS ~*', 'status' => 'Pending', 'type' => 'Verifikasi'));
					} else {
						$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Reset Password Gagal.');
					}
				}
			}
		}
	}
}
require '../lib/header_auth.php';
?>
<div class="form-body">
        <div class="row">
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Reset Password</h3>
                        <p>Nikmati kemudahan bertransaksi di <?php echo $config['web']['title']; ?></p>
                        
                        <?php
                        if (isset($_SESSION['result'])) {
                        ?>
                        <div class="alert alert-warning alert-dismissible fade show " role="alert">
                            <i class="simple-icon-exclamation"></i> <?php echo $_SESSION['result']['msg'] ?><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <?php
                            unset($_SESSION['result']);
                        }
                        ?>
                        <form method="POST">
                            <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                            <input class="form-control" autocapitalize="none" type="text" placeholder="Username" value="<?php echo $data_target['rows']['user'] ?>" readonly>
                            <input class="form-control" type="password" name="password" placeholder="Password Baru" required>
                            <input class="form-control" type="password" name="c_password" placeholder="Konfirmasi Password Baru" required>
                            <input class="form-control" type="text" name="kode" placeholder="Kode Verifikasi" required>
                            <div class="form-button">
                                <button type="submit" class="ibtn">Submit</button>
                            </div>
                        </form>
                        <div class="other-links">
                            <a href="<?php echo $config['web']['base_url']; ?>auth/login">Kembali ke Halaman Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="<?php echo $config['web']['base_url']; ?>dist/js/jquery.min.js"></script>
<script src="<?php echo $config['web']['base_url']; ?>dist/js/popper.min.js"></script>
<script src="<?php echo $config['web']['base_url']; ?>dist/js/bootstrap.min.js"></script>
<script src="<?php echo $config['web']['base_url']; ?>dist/js/main.js"></script>
</body>
</html>