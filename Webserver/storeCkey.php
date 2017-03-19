<?php
    require_once("config.php");
    if ($_SERVER['REMOTE_ADDR'] != $serverIP || !isset($_GET['ckey'])) {
        exit();
    }

    $ckey = urldecode($_GET['ckey']);
    $hash = hash_hmac('sha256', $ckey, $hmacKey);
    echo $hash . bin2hex($ckey)
?>