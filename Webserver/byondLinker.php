<?php
    require_once("config.php");
    require_once("util.php");

    if (!isset($_GET['token'])) {
        exit();
    }

    $token = $_GET['token'];

    $providedHash = substr($token, 0, 64); // SHA256 = 64
    $body = substr($token, 64, strlen($token));
    $body = hex2bin($body);

    $correctHash = hash_hmac('sha256', $body, $hmacKey);
    if(!hash_compare($providedHash, $correctHash)) {
        die("Invalid token");
    } else {
        $bodyObj = json_decode($body);
        $time = $bodyObj->time;
        $ckey = $bodyObj->ckey;
        if (time() - $time > 15) {
            die("Token has expired");
        }

        print("Token is valid. User authenticated as " . $ckey);
    }
?>