<?php
    require_once("config.php");
    if ($_SERVER['REMOTE_ADDR'] != $serverIP || !isset($_GET['ckey'])) {
        exit();
    }

    $ckey = urldecode($_GET['ckey']);
    
    $bodyObj = array(
        "ckey" => $ckey,
        "time" => time(),
    );
    $body = json_encode($bodyObj);

    $hash = hash_hmac('sha256', $body, $hmacKey);
    echo $hash . bin2hex($body)
?>