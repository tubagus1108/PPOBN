<?php
require '../mainconfig.php';
if (isset($_SESSION['login'])) {
	exit(header("Location: ".$config['web']['base_url']));
}
if ($_POST) {
	$data = array('full_name', 'username', 'password', 'confirm_password', 'nomor', 'email');
	if (check_input($_POST, $data) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Input tidak sesuai.');
	} else {
		$validation = array(
			'full_name' => input_request($_POST['full_name'], $db),
			'username' => input_request($_POST['username'], $db),
			'password' => input_request($_POST['password'], $db),
			'confirm_password' => input_request($_POST['confirm_password'], $db),
			'nomor' => input_request($_POST['nomor'], $db),
			'email' => input_request($_POST['email'], $db)
		);
		
		if(!preg_match('/[^+0-9]/',$validation['nomor'])){
        
         if(substr($validation['nomor'], 0, 3)=='62'){
             $nomor_hp = $validation['nomor'];
         }
         
         elseif(substr($validation['nomor'], 0, 1)=='0'){
             $nomor_hp = '62'.substr($validation['nomor'], 1);
         }
     }
		$email = $validation['email'];
		if (check_empty($validation) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Input tidak boleh kosong.');
		} else {
			if ($validation['password'] <> $validation['confirm_password']) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Konfirmasi password tidak sesuai.');
			} else if (strlen($validation['username']) < 5 OR strlen($validation['password']) < 5) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Username/Password minimal 5 karakter.');
			} else if (strlen($validation['username']) > 15 OR strlen($validation['password']) > 15) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Username/Password maksimal 15 karakter.');
			} else if (strlen($validation['full_name']) > 15 OR strlen($validation['password']) > 15) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Nama Lengkap maksimal 15 karakter.');
			} else if (strlen($validation['email']) > 50 ) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Email maksimal 50 karakter.');
			} else {
				$input_post = array(
					'level' => 'Member',
					'username' => strtolower($validation['username']),
					'password' => password_hash($validation['password'], PASSWORD_DEFAULT),
					'full_name' => $validation['full_name'],
					'email' => $validation['email'],
					'nomor' => $nomor_hp,
					'balance' => 0,
					'api_key' => str_rand(30),
					'status' => 1,
					'created_at' => date('Y-m-d H:i:s'),
				);
	            if ($model->db_query($db, "username", "users", "username = '".mysqli_real_escape_string($db, $input_post['username'])."'")['count'] > 0) {
				    $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Username sudah terdaftar.');
	            } elseif ($model->db_query($db, "username", "users", "email = '".mysqli_real_escape_string($db, $input_post['email'])."'")['count'] > 0) {
				    $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Email sudah terdaftar.'); 
				} else {
				    if ($model->db_query($db, "username", "users", "username = '".mysqli_real_escape_string($db, $input_post['username'])."'")['count'] > 0) {
					    $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Username sudah terdaftar.');
				    } else {
					    if ($model->db_insert($db, "users", $input_post) == true) {
						    $_SESSION['result'] = array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Terima Kasih telah mendaftar.<br />Anda akan dialihkan ke halaman login dalam 3 detik... <META HTTP-EQUIV=Refresh CONTENT=\'3; URL=/auth/login\'>');
					        $model->db_insert($db, "notify_wa", array('user' => $input_post['username'], 'nomor' => $input_post['nomor'], 'msg' => 'Terima Kasih sudah mendaftar!! '.$tab_2.'Silahkan masuk untuk memulai transaksi di *'.$config['web']['title'].'* '.$tab_1.'Semoga harimu menyenangkan ^_^. '.$tab_2.'Grup WhatsApp : https://chat.whatsapp.com/FdE81EKHpKjJxwJuDeCsgj '.$tab_2.'*~ BEST REGARDS ~*', 'status' => 'Pending', 'type' => 'Register'));
					    } else {
						    $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Member gagal didaftarkan.');
					    }
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
                        <h3>Daftar</h3>
                        <p>Nikmati kemudahan bertransaksi di <?php echo $config['web']['title']; ?></p>
                        <div class="page-links">
                            <div class="page-links">
                            <a href="<?php echo $config['web']['base_url']; ?>auth/login">Masuk</a>
                            <a href="<?php echo $config['web']['base_url']; ?>auth/register.php" class="active">Daftar Member</a>
                        </div>
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
                            <input class="form-control" type="text" name="full_name" placeholder="Nama Lengkap" required>
                            <input class="form-control" autocapitalize="none" type="text" name="username" placeholder="Username" required>
                            <input class="form-control" type="email" name="email" placeholder="Email" required>
                            <input class="form-control" type="number" name="nomor" placeholder="Nomor WhatsApp (Aktif)" required>
                            <input class="form-control" type="password" name="password" placeholder="Password" required>
                            <input class="form-control" type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
                            <div class="form-button">
                                <button type="submit" class="ibtn">Daftar</button>
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