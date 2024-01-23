<style>
	.container_custom {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 5px;
        cursor: pointer;
        font-size: 12px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        font-weight:normal;
        background-color:#f1f1f1;
        max-width:100%;
        outline:0;
        padding-top:9px;
        padding-bottom:9px;
        border-radius:4px;
    }
    
    card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 0;
        border-radius: 6px;
        box-shadow: 0 3px 6px 0 rgba(0, 0, 0, 0.1), 0 1px 3px 0 rgba(0, 0, 0, 0.08);
    }
card card-body {
    padding: 24px 16px;
    padding-top: 24px;
    padding-bottom: 24px;
    line-height: 1.4em;
}
.p-3 {
    padding: 1rem !important;
}
.align-items-center {
    -ms-flex-align: center !important;
    align-items: center !important;
}

.justify-content-between {
    -ms-flex-pack: justify !important;
    justify-content: space-between !important;
}

.d-flex {
    display: -ms-flexbox !important;
    display: flex !important;
}
.mt-2, .my-2 {
    margin-top: .5rem !important;
}
element {
    display: inline-flex;
}
*, ::after, ::before {
    box-sizing: border-box;
}
element {
    display: grid;
    padding-left: 8px;
}
*, ::after, ::before {
    box-sizing: border-box;
}
element {
    color: #000;
}
a {
    color: var(--iq-primary);
}
a, button, input, btn {
    outline: medium none !important;
}
a, .btn {
    -webkit-transition: all 0.5s ease-out 0s;
    -moz-transition: all 0.5s ease-out 0s;
    -ms-transition: all 0.5s ease-out 0s;
    -o-transition: all 0.5s ease-out 0s;
    transition: all 0.5s ease-out 0s;
}
a {
    color: #50b5ff;
    text-decoration: none;
    background-color: transparent;
}
</style>

			
<?php
require '../mainconfig.php';
require '../lib/is_login.php';
error_reporting(0);
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if(isset($_POST['oprator']) && isset($_POST['type']) && isset($_POST['phone'])) {
        if(!isset($_POST['oprator'])) exit("No direct script access allowed!");
        if(!isset($_POST['phone'])) exit("No direct script access allowed!");
        $post_phone = mysqli_real_escape_string($db, $_POST['phone']);
        $post_type = $_POST['type'];
        $post_oprator = mysqli_real_escape_string($db, $_POST['oprator']);
        $search = mysqli_query($db, "SELECT * FROM services_pulsa WHERE type = '$post_type' AND oprator = '$post_oprator' AND status = 'Active' ORDER BY price ASC");
        if(mysqli_num_rows($search) == 0) {
            print '<div class="alert alert-danger">Layanan tidak tersedia.</div>';
        } else {
            while($row = mysqli_fetch_assoc($search)) { ?>

            <a href="javascript:;" onclick="confirm_order('c_order','<?php echo $config['web']['base_url']; ?>prabayar/confirm-prepaid/<?php echo $row['sid']; ?>/<?php echo $post_phone; ?>')" style="color: #000; text-decoration:none">
            <card class="mt-2">
                        <card-body class="p-3 d-flex justify-content-between align-items-center">
                        
                            <div style="display: inline-flex;">
                            <input type="hidden" name="service" id="service" value="<?php echo $row['sid']; ?>">
                            <div style="display: grid; padding-left: 8px">
                            <div style="font-weight: 500"><b><?php echo $row['service']; ?></b></div></div></div><span><b>Rp. <?php if (isset($_SESSION['login']['user_verif']) == 1) { ?> <?php echo number_format($row['price_agen'],0,',','.'); ?> <? } else { ?> <?php echo number_format($row['price'],0,',','.'); ?> <? } ?></b></span>
                        
                        </card-body>
            </card>
            </a>

        <?
            }
        }
    } else {
        print '<div class="alert alert-danger">Error</div>';
    }
} else {
    exit("No direct script access allowed!");
} ?>