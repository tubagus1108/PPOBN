<?php

$query_list = "SELECT * FROM carousel ORDER BY id DESC"; // edit

$records_per_page = 30; // edit

$new_query = $query_list;
$new_query = mysqli_query($db, $new_query); 
// 
if (isset($_POST['add'])) {
	
	    $ekstensi_diperbolehkan	= array('png','jpg', 'jpeg');
		$nama = $_FILES['file']['name'];
		$x = explode('.', $nama);
		$ekstensi = strtolower(end($x));
		$ukuran	= $_FILES['file']['size'];
		$file_tmp = $_FILES['file']['tmp_name'];
		
		$validation = array(
		    'title' => $_POST['title'],
		    'subject' => $_POST['subject'],
		    'label' => $_POST['label'],
		    'content' => $_POST['content'],
			'file' => $_FILES['file']['name']
		);
		if (check_empty($validation) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Input tidak boleh kosong.');
		} elseif(in_array($ekstensi, $ekstensi_diperbolehkan) !== true) {
		    $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Ekstensi file tidak diperbolehkan.');
		} elseif($ukuran > 5044070) {
		    $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Ukuran file terlalu besar.');
		} else {
			$input_post = array(
			    'title' => input_request($_POST['title'], $db),
			    'subject' => input_request($_POST['subject'], $db),
			    'label' => input_request($_POST['label'], $db),
			    'catatan' => input_request($_POST['content'], $db),
				'file' => $_FILES['file']['name'],
 				'created_at' => date('Y-m-d H:i:s')
			);
			if ($model->db_insert($db, "carousel", $input_post) == true) {
			    move_uploaded_file($file_tmp, '../../dist/images/banner/'.$nama);
				$_SESSION['result'] = array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Tambah data berhasil.');
			} else {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Tambah data gagal.');
			}
		}
	} else if (isset($_POST['edit'])) {
	    
	    $ekstensi_diperbolehkan	= array('png','jpg', 'jpeg');
		$nama = $_FILES['file']['name'];
		$x = explode('.', $nama);
		$ekstensi = strtolower(end($x));
		$ukuran	= $_FILES['file']['size'];
		$file_tmp = $_FILES['file']['tmp_name'];
		
		$input_post = array(
		        'title' => input_request($_POST['title'], $db),
			    'subject' => input_request($_POST['subject'], $db),
			    'label' => input_request($_POST['label'], $db),
			    'catatan' => input_request($_POST['content'], $db),
				'file' => $_FILES['file']['name'],
 				'created_at' => date('Y-m-d H:i:s')
		);
		if (check_empty($input_post) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Input tidak boleh kosong.');
		} elseif(in_array($ekstensi, $ekstensi_diperbolehkan) !== true) {
		    $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Ekstensi file tidak diperbolehkan.');
		} elseif($ukuran > 5044070) {
		    $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Ukuran file terlalu besar.');
		} else {
			if ($model->db_update($db, "carousel", $input_post, "id = '".$_POST['id']."'") == true) {
			    move_uploaded_file($file_tmp, '../../dist/images/banner/'.$nama);
				$_SESSION['result'] = array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Ubah data berhasil.');
			} else {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Ubah data gagal.');
			}
		}
	}else if (isset($_POST['delete'])) {
	$check_data = $model->db_query($db, "*", "carousel", "id = '".$_POST['id']."'");
	if ($check_data['count'] == 0) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Data tidak ditemukan.');
	} else {
		if ($model->db_delete($db, "carousel", "id = '".$_POST['id']."'") == true) {
			$_SESSION['result'] = array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Hapus data berhasil.');
		} else {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Hapus data gagal.');
		}
	}
}