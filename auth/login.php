<?php
require '../mainconfig.php';
error_reporting(E_ALL);
$ip_client = get_client_ip();
if (isset($_SESSION['login'])) {
	exit(header("Location: ".$config['web']['base_url']));
}
if ($_POST) {
	$data = array('username', 'password');
	if (check_input($_POST, $data) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Input tidak sesuai.');
	} else {
		$input_post = array(
			'username' => mysqli_real_escape_string($db, trim($_POST['username'])),
			'password' => mysqli_real_escape_string($db, trim($_POST['password'])),
		);
		if (check_empty($input_post) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Input tidak boleh kosong!, Mohon mengisi semua input!');
            } else if (strlen($input_post['username']) < 5 OR strlen($input_post['password']) < 5) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Username/Password minimal 5 karakter.');
			} else if (strlen($input_post['username']) > 15 OR strlen($input_post['password']) > 15) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Username/Password maksimal 15 karakter.');
		} else {
			$check_user = $model->db_query($db, "*", "users", "BINARY username = '".$input_post['username']."'");
			if ($check_user['count'] == 1) {
				if (password_verify($input_post['password'], $check_user['rows']['password']) == true) {
					$model->db_insert($db, "login_logs", array('user_id' => $check_user['rows']['id'], 'ip_address' => get_client_ip(), 'created_at' => date('Y-m-d H:i:s')));
					$_SESSION['login'] = $check_user['rows']['id'];
					$_SESSION['informasi'] = 1;
					$model->db_insert($db, "notify_wa", array('user' => $check_user['rows']['username'], 'nomor' => $check_user['rows']['nomor'], 'msg' => 'Halo, '.$check_user['rows']['full_name'].'. Anda telah melakukan login ke '.$config['web']['base_url'].' (Dengan IP: '.$ip_client.') '.$tab_2.'Abaikan pesan ini jika itu memang anda.'.$tab_1.'Jika ada kendala Silakan Hubungi Admin.' .$tab_1.'Terima kasih. '.$tab_2.'*~ BEST REGARDS ~*', 'status' => 'Pending', 'type' => 'Login'));
					exit(header("Location: ".$config['web']['base_url']));
				} else {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Username atau Password Salah!, Silakan coba lagi.');
				}
			} else {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Akun tidak terdaftar, Silakan mendaftar.');
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
                        <h3>Masuk ke akun Anda</h3>
                        <p>Nikmati kemudahan bertransaksi di <?php echo $config['web']['title']; ?></p>
                        <div class="page-links">
                            <a href="<?php echo $config['web']['base_url']; ?>auth/login" class="active">Masuk</a>
                            <a href="<?php echo $config['web']['base_url']; ?>auth/register.php">Daftar Member</a>
                        </div>
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
                            <input class="form-control" type="password" name="password" placeholder="Password" required>
                            <div class="form-button">
                                <button type="submit" class="ibtn">Login</button> <a href="reset-password">Forget password?</a>
                            </div>
                        </form>
                        <div class="other-links">
                            <a href="<?php echo $config['web']['base_url']; ?>">Ke Halaman Utama</a>
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