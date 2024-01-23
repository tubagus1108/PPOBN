<?php
// query list for paging
if (isset($_GET['search']) AND isset($_GET['category'])) {
	if (!empty($_GET['search']) AND !empty($_GET['category'])) {
		$query_list = "SELECT * FROM services_pulsa WHERE service LIKE '%".protect_input($_GET['search'])."%' AND sid LIKE '%".protect_input($_GET['search_sid'])."%' AND type LIKE '%".protect_input($_GET['category'])."%' ORDER BY price DESC"; // edit
	} else if (!empty($_GET['search'])) {
		$query_list = "SELECT * FROM services_pulsa WHERE service LIKE '%".protect_input($_GET['search'])."%' ORDER BY price DESC"; // edit
	} else if (!empty($_GET['category'])) {
		$query_list = "SELECT * FROM services_pulsa WHERE type LIKE '%".protect_input($_GET['category'])."%' ORDER BY price DESC"; // edit
	} else if (!empty($_GET['search_sid'])) {
	    $query_list = "SELECT * FROM services_pulsa WHERE sid LIKE '%".protect_input($_GET['search_sid'])."%' ORDER BY price DESC"; // edit
	} else {
		$query_list = "SELECT * FROM services_pulsa ORDER BY price DESC"; // edit
	}
} else {
	$query_list = "SELECT * FROM services_pulsa ORDER BY price DESC"; // edit
}
$records_per_page = 30; // edit

$starting_position = 0;
if(isset($_GET["page"])) {
	$starting_position = ($_GET["page"]-1) * $records_per_page;
}
$new_query = $query_list." LIMIT $starting_position, $records_per_page";
$new_query = mysqli_query($db, $new_query); 
// 
if (isset($_POST['add'])) {
	$input_name = array('category_id', 'service_name', 'operator', 'note', 'price', 'price_agen', 'price_provider', 'provider_id', 'provider_service_id');
	if (check_input($_POST, $input_name) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Input tidak sesuai.');
	} else {
		$empty = array(
			'category_id' => input_request($_POST['category_id'], $db),
			'service_name' => input_request($_POST['service_name'], $db),
			'operator' => input_request($_POST['operator'], $db),
			'provider_id' => input_request($_POST['provider_id'], $db),
			'provider_service_id' => input_request($_POST['provider_service_id'], $db),
		);
		if (check_empty($empty) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Input tidak boleh kosong.');
		} else {
			$input_post = array(
				'type' => input_request($_POST['category_id'], $db),
				'service' => input_request($_POST['service_name'], $db),
				'oprator' => input_request($_POST['operator'], $db),
				'price' => input_request($_POST['price'], $db),
				'price_agen' => input_request($_POST['price_agen'], $db),
				'price_provider' => input_request($_POST['price_provider'], $db),
				'bonus_poin' => input_request($_POST['bonus_poin'], $db),
				'provider' => input_request($_POST['provider_id'], $db),
				'pid' => input_request($_POST['provider_service_id'], $db),
				'sid' => input_request($_POST['provider_service_id'], $db),
				'status' => 'Active',
				'note' => input_request($_POST['note'], $db),
			);
			if ($model->db_query($db, "service", "services_pulsa", "BINARY service = '".$input_post['service']."'")['count'] > 0) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Nama Layanan sudah terdaftar.');
			} else {
				if ($model->db_insert($db, "services_pulsa", $input_post) == true) {
					$_SESSION['result'] = array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Tambah data berhasil.');
				} else {
					die(mysqli_error($db));
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Tambah data gagal.');
				}
			}
		}
	}
} else if (isset($_POST['edit'])) {
	$input_name = array('category_id', 'service_name', 'operator', 'note', 'price', 'price_agen', 'price_provider', 'provider_id', 'provider_service_id');
	$check_data = $model->db_query($db, "*", "services_pulsa", "id = '".mysqli_real_escape_string($db, $_POST['id'])."'");
	if (check_input($_POST, $input_name) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Input tidak sesuai.');
	} else if ($check_data['count'] == 0) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Data tidak ditemukan.');
	} else {
		$empty = array(
			'category_id' => $_POST['category_id'],
			'service_name' => $_POST['service_name'],
			'operator' => $_POST['operator'],
			'provider_id' => $_POST['provider_id'],
			'provider_service_id' => $_POST['provider_service_id'],
		);
		if (check_empty($empty) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Input tidak boleh kosong.');
		} else {
			$input_post = array(
				'type' => input_request($_POST['category_id'], $db),
				'service' => input_request($_POST['service_name'], $db),
				'oprator' => input_request($_POST['operator'], $db),
				'price' => input_request($_POST['price'], $db),
				'price_agen' => input_request($_POST['price_agen'], $db),
				'bonus_poin' => input_request($_POST['bonus_poin'], $db),
				'price_provider' => input_request($_POST['price_provider'], $db),
				'provider' => input_request($_POST['provider_id'], $db),
				'pid' => input_request($_POST['provider_service_id'], $db),
				'sid' => input_request($_POST['provider_service_id'], $db),
				'note' => input_request($_POST['note'], $db),
			);
			if ($input_post['service'] <> $check_data['rows']['service'] AND $model->db_query($db, "service", "services_pulsa", "BINARY service = '".$input_post['service']."'")['count'] > 0) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Nama Layanan sudah terdaftar.');
			} else {
				if ($model->db_update($db, "services_pulsa", $input_post, "id = '".$_POST['id']."'") == true) {
					$_SESSION['result'] = array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Ubah data berhasil.');
				} else {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Ubah data gagal.');
				}
			}
		}
	}
} else if (isset($_POST['delete'])) {
	$check_data = $model->db_query($db, "*", "services_pulsa", "id = '".$_POST['id']."'");
	if ($check_data['count'] == 0) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Data tidak ditemukan.');
	} else {
		if ($model->db_delete($db, "services_pulsa", "id = '".$_POST['id']."'") == true) {
			$_SESSION['result'] = array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => 'Layanan berhasil dihapus.');
		} else {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Hapus data gagal.');
		}
	}
}