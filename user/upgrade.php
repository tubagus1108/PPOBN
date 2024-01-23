<?php
require '../mainconfig.php';
require '../lib/check_session.php';
require '../lib/is_login.php';
if (isset($_POST['submit'])) {
	    
	    $ekstensi_diperbolehkan	= array('png','jpg', 'jpeg');
		$nama = $_FILES['file']['name'];
		$x = explode('.', $nama);
		$ekstensi = strtolower(end($x));
		$ukuran	= $_FILES['file']['size'];
		$file_tmp = $_FILES['file']['tmp_name'];
		
		$input_post = array(
		    'full_name' => input_request($_POST['full_name'], $db),
		    'alamat' => input_request($_POST['alamat'], $db),
		    'file' => $_FILES['file']['name'],
		);
		if (check_empty($input_post) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Input Tidak Boleh Kosong"});</script>');
		} elseif(in_array($ekstensi, $ekstensi_diperbolehkan) !== true) {
		    $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Ekstensi File Tidak Diperbolehkan"});</script>');
		} elseif($ukuran > 5044070) {
		    $_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Ukuran File Terlalu Besar"});</script>');
		} else {
			if ($model->db_update($db, "users", $input_post, "id = '".$login['id']."'") == true) {
			    move_uploaded_file($file_tmp, '../dist/images/ktp/'.$nama);
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "success",title: "Berhasil!",text: "Mohon Hubungi Admin Untuk Melanjutkan Verifikasi"});</script>');
				header("Location: ".$config['web']['base_url']."pages/contact");
			} else {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Database Error"});</script>');
			}
		}
	}
require '../lib/header.php';
?>
<?php if ($login['user_verif'] == 1) {
header("Location: /");
} else { ?>
<div class="header-large-title pt-5"><header class="no-border text-light">
                        <left>
                <a href="/" class="headerButton">
                    <em class="ri-arrow-left-s-line"></em>
                                        <pagetitle>User - Upgrade</pagetitle>
                </a>
            </left>
            <right></right>
                    </header></div>
            <form class="form-horizontal" method="POST" id="ajax-result" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
                  <section class="card-section pt-2 wd-100">
                      <card style="border-radius: .90rem">
                          <card-body style="padding-top: 6px; padding-bottom: 6px">
                                <div class="form-group">
                                        <div class="form-group">
                                            <label>Nama Lengkap</label>
                                            <input type="text" class="form-control" name="full_name" style="border-radius: .40rem">
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat Lengkap</label>
                                            <textarea type="text" class="form-control" name="alamat" style="border-radius: .40rem;" rows="1"></textarea>
                                        </div>
                                        <label>Upload KTP</label>
                                            <input name="file" type="file" required>
                                            <div class="form-button">
                                            <button type="submit" name="submit" class="btn btn-primary btn-sm">Submit</button>
                                        </div>
	                                </div>
                          </card-body>
                      </card>
                  </section>
            </form>
        </div>
    </div>
</div>     
<? } ?>
<?php
require '../lib/footer.php';
?>