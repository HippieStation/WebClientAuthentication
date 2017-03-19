<?php
    require_once("config.php");
    require_once("util.php");

    if (!isset($_GET['token'])) {
        exit();
    }

    $token = $_GET['token'];

    $providedHash = substr($token, 0, 64); // SHA256 = 64
    $ckey = substr($token, 64, strlen($token));
    $ckey = hex2bin($ckey);

    $correctHash = hash_hmac('sha256', $ckey, $hmacKey);
    if(!hash_compare($providedHash, $correctHash)) {
        die("Invalid token");
    } else {
        print("Correct token");
    }
?>