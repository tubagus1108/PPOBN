<?php
require '../lib/is_login.php';
require '../lib/csrf_token.php';
require '../mainconfig.php';
$_SESSION['informasi'] = 0;
header("location:/");