<?php

require_once '../config.php';

$verified = false;

if (isset($_POST['password'])) {
    $verified = ($_POST['password'] == ADMIN_PASS);
    
    if ($verified) {
        setcookie('fcms_admin', ADMIN_ID, 0, BASE_PATH);
    }
}

echo $verified;
