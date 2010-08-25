<?php

require_once '../config.php';

$verified = false;

if (isset($_COOKIE['fcms_admin'])) {
    $verified = ($_COOKIE['fcms_admin'] == ADMIN_ID);
}

echo $verified;
