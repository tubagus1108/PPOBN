<?php
require '../mainconfig.php';
require '../lib/check_session.php';
require '../lib/is_login.php';
require '../lib/csrf_token.php';

if (!isset($_GET['action'])) {
	$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Input tidak sesuai!",text: "Silakan coba lagi!"});</script>');
	exit(header("Location: ".$config['web']['base_url']."user/settings/"));
} elseif (in_array($_GET['action'], array('profile','password', 'api_key')) == false) {
	$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Input tidak sesuai!",text: "Silakan coba lagi!"});</script>');
	exit(header("Location: ".$config['web']['base_url']."user/settings/"));
}

if ($_GET['action'] == 'profile') {
	if ($_POST) {
		$input_data = array('full_name', 'password');
		if (check_input($_POST, $input_data) == false) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Input tidak sesuai!",text: "Mohon mengisi semua input!"});</script> ');
		} else {
		    $p_full_name = input_request($_POST['full_name'],$db);
		    $p_password = input_request($_POST['password'],$db);
		    $p_nomor = input_request($_POST['nomor'],$db);
		    if(!preg_match('/[^+0-9]/',$p_nomor)){
        
                if(substr($p_nomor, 0, 3)=='62'){
                    $nomor_hp = $p_nomor;
                }
         
                elseif(substr($p_nomor, 0, 1)=='0'){
                    $nomor_hp = '62'.substr($p_nomor, 1);
            }
        }
			$input_post = array(
				'full_name' => $p_full_name,
				'password' => $p_password,
			);
			if (check_empty($input_post) == true) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Input tidak boleh kosong!",text: "Mohon mengisi semua input!"});</script>');
			} else {
				if (password_verify($input_post['password'], $login['password']) == false) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Password Salah!",text: "Silahkan coba lagi!"});</script>');
				} elseif (strlen($input_post['full_name']) < 5) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Nama Lengkap minimal 5 karakter."});</script>');
				} elseif (strlen($input_post['full_name']) > 15) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Nama Lengkap maksimal 15 karakter."});</script>');
				} else {
					if ($model->db_update($db, "users", array('full_name' => $input_post['full_name'], 'nomor' => $nomor_hp), "id = '".$login['id']."'")) {
						$_SESSION['result'] = array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => '<script>Swal.fire({type: "success",title: "Berhasil!",text: "Profil telah diubah!"});</script>');
					} else {
						$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Profil gagal diubah!"});</script>.');
					}
				}
			}
		}
	}
	exit(header("Location: ".$config['web']['base_url']."user/settings/"));
} elseif ($_GET['action'] == 'password') {
	if ($_POST) {
		$input_data = array('password', 'new_password', 'new_password2');
		if (check_input($_POST, $input_data) == false) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Input tidak sesuai."});</script>');
		} else {
		    $p_password = input_request($_POST['password'],$db);
		    $p_new_password = input_request($_POST['new_password'],$db);
		    $p_new_password2 = input_request($_POST['new_password2'],$db);
			$input_post = array(
				'password' => $p_password,
				'new_password' => $p_new_password,
				'new_password2' => $p_new_password2,
			);
			if (check_empty($input_post) == true) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Input tidak boleh kosong."});</script>');
			} else {
				if (password_verify($input_post['password'], $login['password']) == false) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Password salah, silahkan coba lagi."});</script>');
				} elseif (strlen($input_post['password']) < 5) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Password minimal 5 karakter."});</script>');
				} elseif (strlen($input_post['new_password']) < 5) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Password baru minimal 5 karakter."});</script>');
				} elseif (strlen($input_post['new_password']) > 13) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Password baru maksimal 12 karakter."});</script>');
				} elseif ($input_post['new_password'] <> $input_post['new_password2']) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Konfirmasi Password baru salah."});</script>.');
				} else {
					if ($model->db_update($db, "users", array('password' => password_hash($input_post['new_password'], PASSWORD_DEFAULT)), "id = '".$login['id']."'")) {
						$_SESSION['result'] = array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => '<script>Swal.fire({type: "success",title: "Berhasil!",text: "Password telah diubah"});</script>');
					} else {
						$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Password gagal diubah."});</script>');
					}
				}
			}
		}
	}
	exit(header("Location: ".$config['web']['base_url']."user/settings/"));
} elseif ($_GET['action'] == 'api_key') {
	$model->db_update($db, "users", array('api_key' => str_rand(30)), "id = '".$login['id']."'");
	$_SESSION['result'] = array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => '<script>Swal.fire({type: "success",title: "Berhasil!",text: "API Key berhasil dibuat ulang."});</script>');
	exit(header("Location: ".$config['web']['base_url']."api/documentation.php"));
}
?>