<?php
require '../mainconfig.php';
if (isset($_SESSION['login'])) {
	exit(header("Location: ".$config['web']['base_url']));
}
if ($_POST) {
	$data = array('email', 'username');
	if (check_input($_POST, $data) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Input tidak sesuai.');
	} else {
		$validation = array(
			'email' => input_request($_POST['email'], $db),
			'username' => input_request($_POST['username'], $db),
		);
		$valid = md5($validasi);
		if (check_empty($validation) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Input tidak boleh kosong.');
		} else if (strlen($validation['username']) < 5) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Username minimal 5 karakter.');
		} else if (strlen($validation['username']) > 15) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Username maksimal 15 karakter.');
		} else if (strlen($validation['email']) > 50 ) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Email maksimal 50 karakter.');
		} else {
			$check_user = $model->db_query($db, "*", "users", "username = '".mysqli_real_escape_string($db, $_POST['username'])."' AND email = '".mysqli_real_escape_string($db, $_POST['email'])."'");
			if ($check_user['count'] == 0) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Username / Email tidak ditemukan!');
			} else {
				$input_post = array(
				    'user' => $validation['username'],
				    'validasi' => $valid,
					'kode' => str_rand(6),
					'status' => 0,
					'created_at' => date('Y-m-d H:i:s'),
				);
				$link = ''.$config['web']['base_url'].'/reset/password/'.$input_post['kode'].'/'.$input_post['validasi'].'';
					    if ($model->db_insert($db, "verifikasi_kode", $input_post) == true) {
					        $model->db_insert($db, "notify_wa", array('user' => $check_user['rows']['username'], 'nomor' => $check_user['rows']['nomor'], 'msg' => 'Halo, '.$check_user['rows']['full_name'].'. Permintaan reset password anda berhasil dibuat'.$tab_2.'Kode Verifikasi: *'.$input_post['kode'].'*'.$tab_1.'Link Reset Password: '.$link.''.$tab_2.'Jika ada kendala Silakan Hubungi Admin.'.$tab_1.'Terima kasih. '.$tab_2.'*~ BEST REGARDS ~*', 'status' => 'Pending', 'type' => 'Login'));
						    $_SESSION['result'] = array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Silakan cek pesan pada whatsapp anda untuk memperbarui password anda.');
					    } else {
						    $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Terjadi kesalahan.');
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
                            <input class="form-control" autocapitalize="none" type="text" name="username" placeholder="Username" required>
                            <input class="form-control" type="email" name="email" placeholder="Email" required>

                            <div class="form-button">
                                <button type="submit" class="ibtn">Reset Password</button>
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