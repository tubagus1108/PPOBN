<?php
require '../../mainconfig.php';
require '../../lib/check_session.php';
require '../../lib/header.php';
?>

<header class="pages theme-blue no-border text-light">
          <center style="color: #fff;font-size: 16px;font-weight: bold;padding-top:12px;">Akun Saya</center>
          <right>
                <a href="<?php echo $config['web']['base_url']; ?>pages/news" class="headerButton">
                    <em class="ri-notification-4-line"></em>
                    <span class="badge badge-danger"></span>
                </a>
            </right>
        </header>
<section class="bg-white" style="padding-top: 30px">
        <div class="profile-head">
        <div class="avatar">
            <img src="<?php echo $config['web']['base_url']; ?>dist/images/historian.png" alt="avatar" class="imaged rounded" style="width: 64px">
        </div>
        <div class="in">
            <h3 class="name"><?php echo $login['full_name']; ?></h3>
            <h5 class="subtext"><?php echo $login['level']; ?></h5>
        </div>
    </div>
</section>
<section class="full pt-2 bg-white">
    <div class="profile-stats pl-3 pr-3">
        <span href="#" class="item">
            <strong>Rp <?php echo number_format($login['balance'],0,',','.'); ?></strong> Saldo
        </span>
        <span href="#" class="item">
            <strong>Rp <?php echo number_format($login['balance_used'],0,',','.'); ?></strong> Pengeluaran
        </span>
    </div>
</section>
<div class="listview-title mt-1"></div>
<ul class="listview image-listview" style="border-top: none !important; border-bottom: none !important">
    <li><br>
        <span style="padding-left:18px;"><b>Akun</b></span>
        <a href="#" class="item" data-toggle="modal" data-target="#pengaturanAkun">
            <div class="icon-box bg-transparent">
                <i class="icon ri-user-line"></i>
            </div>
            <div class="in">
                <div>Pengaturan Akun</div>
            </div>
        </a>
    </li>
</ul>
<div class="listview-title mt-2"></div>
<ul class="listview image-listview" style="border-top: none !important; border-bottom: none !important">
    <li><br>
        <span style="padding-left:18px;"><b>Keamanan</b></span>
        <a href="#" class="item" data-toggle="modal" data-target="#ubahPassword">
            <div class="icon-box bg-transparent">
                <i class="icon ri-key-line"></i>
            </div>
            <div class="in">
                <div>Ubah Password</div>
            </div>
        </a>
    </li>
</ul>
<div class="listview-title mt-2"></div>
<ul class="listview image-listview" style="border-top: none !important; border-bottom: none !important">
    <li><br>
        <span style="padding-left:18px;"><b>Tentang</b></span>
        <a href="<?php echo $config['web']['base_url'] ?>pages/contact" class="item">
            <div class="icon-box bg-transparent">
                <i class="icon ri-phone-line"></i>
            </div>
            <div class="in">
                <div>Hubungi Kami</div>
            </div>
        </a>
    </li>
    <li>
        <a href="<?php echo $config['web']['base_url']; ?>pages/faq" class="item">
            <div class="icon-box bg-transparent">
                <i class="icon ri-questionnaire-line"></i>
            </div>
            <div class="in">
                <div>Panduan</div>
            </div>
        </a>
    </li>
    <li>
        <a href="<?php echo $config['web']['base_url']; ?>pages/tos" class="item">
            <div class="icon-box bg-transparent">
                <i class="icon ri-auction-line"></i>
            </div>
            <div class="in">
                <div>Ketentuan Layanan</div>
            </div>
        </a>
    </li>
</ul>
<section class="pt-2">
    <div class="d-flex justify-content-between align-items-center pb-3">
        <small>Version <?php echo $config['web']['versi']; ?></small>
        <small style="font-weight: 600">Created With <i class="ri ri-heart-fill"></i> By <a href="#" target="_blank">MC Project</a></small>
    </div>
    <div class="row">
        <div class="col-12">
            <a href="<?php echo $config['web']['base_url']; ?>logout" class="btn btn-block btn-primary" style="font-weight: 600">Keluar</a>
        </div>
    </div>
</section>
</div>

<div class="modal fade modalbox" id="pengaturanAkun" tabindex="-1" data-backdrop="static" role="dialog" style="display: none;" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Pengaturan Akun</h5>
				<a href="javascript:;" data-dismiss="modal">Close</a>
			</div>
			<div class="modal-body p-0">
			    <section class="pt-2 pb-3 bg-white">
                    <div class="profile-info">
                        <div class="bio">
                            Kamu bergabung dengan kami pada <?php echo $login['created_at']; ?>. Terima kasih sudah bersama kami.
                        </div>
                        <div class="link">
                            <a href="#">Email: <?php echo $login['email']; ?></a><br/>
                            <a href="#">No. Telepon: <?php echo $login['nomor']; ?></a>
                        </div>
                    </div>
                </section>
	            <form method="POST" action="<?php echo $config['web']['base_url'] ?>user/post-settings.php?action=profile">
	                <div class="iq-card-body">
	                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
	                    <div class="form-group row">
	                        <label class="col-xl-3 col-lg-3 col-form-label bold" style="font-size: 13px">Nama Lengkap</label>
	                        <div class="col-lg-9 col-xl-9">
	                            <input type="text" class="form-control form-control-md" name="full_name" value="<?php echo $login['full_name'] ?>" required>
	                        </div>
	                    </div>
	                    <div class="form-group row">
	                        <label class="col-xl-3 col-lg-3 col-form-label" style="font-size: 13px">Nomor HP</label>
	                        <div class="col-lg-9 col-xl-9">
	                            <input type="number" class="form-control" name="nomor" value="<?php echo $login['nomor'] ?>" required>
	                        </div>
	                    </div>
	                    <div class="form-group row">
	                        <label class="col-xl-3 col-lg-3 col-form-label" style="font-size: 13px">Password</label>
	                        <div class="col-lg-9 col-xl-9">
	                            <input type="password" class="form-control" name="password"><small class="text-danger">*Password dibutuhkan untuk mengubah profil.</small>
	                        </div>
	                    </div>
	                </div>
	                <div class="iq-card-body">
	                    <div class="row">
	                        <div class="col-12">
	                            <button type="submit" class="btn btn-block btn-primary">Simpan</button>
	                        </div>
	                    </div>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade modalbox" id="ubahPassword" tabindex="-1" data-backdrop="static" role="dialog" style="display: none;" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Ubah Password</h5>
				<a href="javascript:;" data-dismiss="modal">Close</a>
			</div>
			<div class="modal-body p-0">
	            <form method="POST" action="<?php echo $config['web']['base_url'] ?>user/post-settings.php?action=password">
	                <div class="iq-card-body">
	                    <input type="hidden" id="csrf_token" name="csrf_token" value="<?php echo $config['csrf_token'] ?>">
	                    <div class="form-group row">
	                        <label class="col-xl-3 col-lg-3 col-form-label bold" style="font-size: 13px">Kata Sandi Lama</label>
	                        <div class="col-lg-9 col-xl-9">
	                            <input type="password" class="form-control form-control-md" name="password">
	                        </div>
	                    </div>
	                    <div class="form-group row">
	                        <label class="col-xl-3 col-lg-3 col-form-label" style="font-size: 13px">Kata Sandi Baru</label>
	                        <div class="col-lg-9 col-xl-9">
	                            <input type="password" class="form-control" name="new_password">
	                        </div>
	                    </div>
	                    <div class="form-group row">
	                        <label class="col-xl-3 col-lg-3 col-form-label" style="font-size: 13px">Konfirmasi Kata Sandi</label>
	                        <div class="col-lg-9 col-xl-9">
	                            <input type="password" class="form-control" name="new_password2">
	                        </div>
	                    </div>
	                </div>
	                <div class="iq-card-body">
	                    <div class="row">
	                        <div class="col-12">
	                            <button type="submit" class="btn btn-block btn-primary">Perbarui</button>
	                        </div>
	                    </div>
	                </div>
	            </form>
			</div>
		</div>
	</div>
</div>
<?php
require '../../lib/footer.php';
?>