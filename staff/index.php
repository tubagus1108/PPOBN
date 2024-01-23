<?php
require '../mainconfig.php';
require '../lib/check_session.php';
require '../lib/is_login.php';
if ($login['level'] == 'Member') {
	$_SESSION['result'] = array('alert' => 'danger', 'title' => 'Gagal!', 'msg' => 'Hak Akses tidak sah.');
	exit(header("Location: ".$config['web']['base_url']));
}
require '../lib/header.php';
?>
<div class="row">
		    <div class="col-sm-12 col-lg-12">
		        <div class="row">
		        <div class="col-lg-12 text-center">
			        <h3 class="text-uppercase"><i class="fa fa-cube fa-fw"></i> Staff Menu</h3>
				</div>
				<div class="col-12" style="margin-top: 10px;">
	                <div class="card text-center">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <th>
                                        <a href="" class="text-primary">
                                            <a href="<?php echo $config['web']['base_url'] ?>staff/add_member" class="btn-loading"><img src="https://www.flaticon.com/svg/static/icons/svg/1647/1647547.svg" height="50" width="50">
                                            <a href="<?php echo $config['web']['base_url'] ?>staff/add_member" class="btn-loading"><h5 class="text-primary">Tambah Member</h5>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="" class="text-danger">
                                            <a href="<?php echo $config['web']['base_url'] ?>staff/add_reseller" class="btn-loading"><img src="https://www.flaticon.com/svg/static/icons/svg/1647/1647561.svg" height="50" width="50">
                                            <a href="<?php echo $config['web']['base_url'] ?>staff/add_reseller" class="btn-loading"><h5 class="text-primary">Tambah Reseller</h5>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="" class="text-primary">
                                            <a href="<?php echo $config['web']['base_url'] ?>staff/balance_transfer" class="btn-loading"><img src="https://www.flaticon.com/svg/static/icons/svg/1060/1060688.svg" height="50" width="50">
                                            <a href="<?php echo $config['web']['base_url'] ?>staff/balance_transfer" class="btn-loading"><h5 class="text-primary">Transfer Saldo</h5>
                                        </a>
                                    </th>
                                    <th>
                                        <a href="" class="text-primary">
                                            <a href="<?php echo $config['web']['base_url'] ?>staff/balance_mobile" class="btn-loading"><img src="https://www.flaticon.com/svg/static/icons/svg/1060/1060688.svg" height="50" width="50">
                                            <a href="<?php echo $config['web']['base_url'] ?>staff/balance_mobile" class="btn-loading"><h5 class="text-primary">Transfer Saldo Mobile</h5>
                                        </a>
                                    </th>
                                </tr>
                            </tbody>
                        </table>
	                </div>
	            </div>
	        </div>
	   </div>
                </div>
<?php
require '../lib/footer.php';
?>