<?php
require ("mainconfig.php");

//Update semua pengguna ke status aktif
$u = mysqli_query($db, "UPDATE users SET status = '1' ORDER by id");
if ($u == true) {
    echo "berhasil";
} else {
    echo "gagal";
}

?>