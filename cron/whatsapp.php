<?php
error_reporting(0);
require("../mainconfig.php");

$notice = mysqli_query($db, "SELECT * FROM notify_wa WHERE status IN ('Pending', '') ORDER BY rand() LIMIT 20");
if (mysqli_num_rows($notice) == 0) {
  die("Tidak ada pesan yang harus dikirim.");
} else {
    while ($notif = mysqli_fetch_array($notice)) {
        $msg = $notif['msg'];
        $nomor = $notif['nomor'];
        $id = $notif['id'];
        $user = $notif['user'];
        $whatsapp->sendMessage($nomor, $msg);
        if ($whatsapp == true) {
            mysqli_query($db, "UPDATE notify_wa SET status = 'Success' WHERE id = '$id' AND nomor = '$nomor'");
            echo "Berhasil mengirim pesan kepada $user <br /> Nomor Penerima: $nomor <br /> Pesan: $msg <br />";
        } else {
            echo "Gagal Mengirim Pesan (Terjadi Kesalahan)";
        }
    }
}