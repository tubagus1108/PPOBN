<?php
require '../mainconfig.php';
require '../lib/check_session.php';
if ($_POST) {
	require '../lib/is_login.php';
	$input_data = array('method', 'phone', 'amount');
	if (check_input($_POST, $input_data) == false) {
		$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Input tidak sesuai."});</script>');
	} else {
		$validation = array(
			'method' => input_request($_POST['method'], $db),
			'amount' => input_request($_POST['amount'], $db),
		);
		if (check_empty($validation) == true) {
			$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Input tidak boleh kosong."});</script>');
		} else {
			$method = $model->db_query($db, "*", "deposit_methods", "id = '".input_request($_POST['method'],$db)."' AND status = '1'");
			$deposit_request = $model->db_query($db, "*", "deposits", "user_id = '".$login['id']."' AND status = 'Pending'");
			if ($method['count'] == 0) {
				$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Metode Deposit tidak ditemukan"});</script>');
			} else {
				if ($_POST['amount'] < $method['rows']['min_amount']) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Minimal deposit Rp '.number_format($method['rows']['min_amount'],0,',','.').'"});</script>');
				} elseif ($method['rows']['payment'] == 'pulsa' AND empty($_POST['phone'])) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Nomor pengirim tidak boleh kosong."});</script>');
				} elseif ($deposit_request['count'] >= 10) {
					$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Anda tidak dapat membuat permintaan deposit lagi, karena Anda memiliki 10 permintaan berstatus Pending."});</script>');
				} else {
					$post_amount = input_request($_POST['amount'],$db);
					if ($method['rows']['payment'] == 'bank' AND $method['rows']['type'] == 'auto') {
						$post_amount = input_request($_POST['amount'],$db) + rand(000,999);
						$cek_bonus = ($method['rows']['bonus']/100) * $post_amount;
						$bonus = ($post_amount + $cek_bonus);
					} elseif ($method['rows']['payment'] == 'bank' AND $method['rows']['type'] == 'manual') {
					    $post_amount = input_request($_POST['amount'],$db);
						$cek_bonus = ($method['rows']['bonus']/100) * $post_amount;
						$bonus = ($post_amount + $cek_bonus);
					} else {
					    $post_amount = input_request($_POST['amount'],$db) + rand(000,999);
					    $cek_bonus = 0;
					}
					$input_post = array(
						'user_id' => $login['id'],
						'payment' => $method['rows']['payment'],
						'type' => $method['rows']['type'],
						'method_name' => $method['rows']['name'],
						'post_amount' => $post_amount,
						'amount' => $post_amount * $method['rows']['rate'] + $cek_bonus,
						'note' => $method['rows']['note'],
						'phone' => input_request($_POST['phone'],$db),
						'status' => 'Pending',
						'created_at' => date('Y-m-d H:i:s')
					);
					$deposit_type = ($input_post['type'] == 'auto') ? 'Otomatis' : 'Manual';
					$insert = $model->db_insert($db, "deposits", $input_post);
					if ($insert == true) {
					    //$model->db_insert($db, "notify_wa", array('user' => $login['username'], 'nomor' => $login['nomor'], 'msg' => 'Halo, '.$login['full_name'].'. Anda telah melakukan *Permintaan Deposit* di *'.$config['web']['title'].'* '.$tab_1.' Berikut detail deposit anda: '.$tab_2.' Deposit ID: '.$insert.' '.$tab_1.' Metode Deposit: '.$input_post['method_name'].' '.$tab_1.' Jumlah Transfer: Rp '.number_format($input_post['post_amount'],0,',','.').' '.$tab_1.' Saldo Diterima: Rp '.number_format($input_post['amount'],0,',','.').' '.$tab_1.' Catatan: '.$tab_1.' '.$input_post['note'].' '.$tab_2.' Terima kasih telah melakukan transaksi di '.$config['web']['title'].' ^_^ '.$tab_1.'Ima Pedia.', 'status' => 'Pending', 'type' => 'Deposit'));
						$_SESSION['result'] = array('alert' => 'success', 'title' => 'Berhasil!', 'msg' => '<script>Swal.fire({type: "success",title: "Berhasil!",text: "Permintaan Deposit berhasil dibuat"});</script>');
						header("Location: ".$config['web']['base_url']."deposit/history");
					} else {
						$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => '<script>Swal.fire({type: "error",title: "Gagal!",text: "Permintaan Deposit gagal dibuat."});</script>');
					}
				}
			}
		}
	}
}
require '../lib/header.php';
?>
<div style="padding-top: 30px"></div>
<div class="offset-lg-3 col-lg-6">
<div class="iq-card">
    <div class="iq-card-header d-flex justify-content-between">
        <div class="iq-header-title">
        <h4 class="card-title"><i class="fa fa-wallet"></i> Isi Saldo</h4>
        </div>
    </div>
<form class="form-horizontal" method="post" id="ajax-result">
    <div class="iq-card-body">
	<input type="hidden" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
	<div class="form-group">
		<label>Jenis Pembayaran <font color= "red">(Pengisian Saldo Via Pulsa Silakan Hubungi Admin)</font></label>
			<select class="form-control" name="payment" id="payment">
				<option value="0">Pilih...</option>
				<option value="bank">Transfer Bank/E-Wallet</option>
			</select>
	</div>
	<div class="form-group">
		<label>Jenis Permintaan</label><br />
			<label><input type="radio" name="type" value="auto"> Otomatis</label><br />
			<label><input type="radio" name="type" value="manual"> Manual</label>
	</div>
	<div class="form-group">
		<label>Metode Pembayaran</label>
			<select class="form-control" name="method" id="method">
				<option value="0">Pilih Jenis Pembayaran & Permintaan...</option>
			</select>
	</div>
	<div class="form-group hide" id="phone">
		<label>Nomor Pengirim</label>
		<input type="number" class="form-control" name="phone" placeholder="08123456789">
	</div>
	<div class="form-group">
		<label>Jumlah</label>
		<input type="number" class="form-control" name="amount" placeholder="" id="post-amount"><small class="text-danger" id="min-amount"></small>
	</div>
	<div class="form-group">
		<label>Saldo Diterima</label><input type="number" class="form-control" id="amount" readonly>
	</div>
    <div class="iq-card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-block btn-primary">Submit</button>
                                    </div>
                                    <div class="col-6">
                                        <button type="reset" class="btn btn-block btn-danger">Reset</button>
                                    </div>
                                </div>
                            </div>
</form>
								</div>
							</div>
</div>
<div style="padding-top: 10px"></div>
<div class="offset-lg-3 col-lg-6">
	<div class="iq-card">
		<div class="iq-card-body">
        <div class="iq-header-title">
            <h4 class="card-title"><i class="fa fa-wallet"></i>Cara Isi Saldo</h4>
        </div>
<h4>Langkah-langkah:</h4>
<ul>
	<li>Pilih jenis pembayaran yang Anda inginkan, tersedia 2 opsi: <b>Transfer Bank</b> & <b>Transfer Pulsa</b>.</li>
	<li>Pilih jenis permintaan yang Anda inginkan, tersedia 2 opsi:
		<ul>
			<li><b>Otomatis:</b> Pembayaran Anda akan dikonfirmasi secara otomatis oleh sistem dalam 5-10 menit setelah melakukan pembayaran.</li>
			<li><b>Manual:</b> Anda harus melakukan konfirmasi pembayaran pada Admin, agar permintaan deposit Anda dapat diterima.</li>
		</ul>
	</li>
	<li>Pilih metode pembayaran yang Anda inginkan.</li>
	<li>Masukkan jumlah deposit.</li>
	<li>Jika Anda memilih jenis pembayaran <b>Transfer Pulsa</b>, Anda diharuskan menginput nomor HP yang digunakan untuk transfer pulsa.</li>
</ul>
<h4>Penting:</h4>
<ul>
	<li>Anda hanya dapat memiliki maksimal 3 permintaan deposit Pending, jadi jangan melakukan <i>spam</i> dan segera lunasi pembayaran.</li>
	<li>Jika permintaan deposit tidak dibayar dalam waktu lebih dari 24 jam, maka permintaan deposit akan otomatis dibatalkan.</li>
</ul>
									</div>
								</div>
							</div>
					</div>
<script type="text/javascript">
$(document).ready(function() {
	function get_methods(payment, type) {
		$.ajax({
			type: "POST",
			url: "<?php echo $config['web']['base_url'] ?>ajax/deposit-get-method.php",
			data: "payment=" + payment + "&type=" + type,
			dataType: "html",
			success: function(data) {
				$('#method').html(data);
			}, error: function() {
				$('#ajax-result').html('<font color="red">Terjadi kesalahan! Silahkan refresh halaman.</font>');
			}
		});
	}
	$('input[type=radio][name=type]').change(function() {
		get_methods($('#payment').val(), this.value);
	});
	$('#payment').change(function() {
		get_methods($('#payment').val(), $('input[type=radio][name=type]:checked').val());
		if ($('#payment').val() == 'pulsa') {
			$('#phone').removeClass('hide');
		} else {
			$('#phone').addClass('hide');
		}
	});
	$('#method').change(function() {
		var method = $('#method').val();
		$.ajax({
			type: "POST",
			url: "<?php echo $config['web']['base_url'] ?>ajax/deposit-select-method.php",
			data: "method=" + method,
			dataType: "html",
			success: function(data) {
				$('#min-amount').html(data);
			}, error: function() {
				$('#ajax-result').html('<font color="red">Terjadi kesalahan! Silahkan refresh halaman.</font>');
			}
		});
	});
	$('#post-amount').keyup(function() {
		var method = $('#method').val();
		var amount = $('#post-amount').val();
		$.ajax({
			type: "POST",
			url: "<?php echo $config['web']['base_url'] ?>ajax/deposit-get-amount.php",
			data: "method=" + method + "&amount=" + amount,
			dataType: "html",
			success: function(data) {
				$('#amount').val(data);
			}, error: function() {
				$('#ajax-result').html('<font color="red">Terjadi kesalahan! Silahkan refresh halaman.</font>');
			}
		});
	});
});
</script>
<?php
require '../lib/footer.php';
?>