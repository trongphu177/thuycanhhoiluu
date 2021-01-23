<?php
    define('DB_HOST','localhost');
    define('DB_USER','admin1');
    define('DB_PASS','admin');
    define('DB','abc');
    error_reporting(0);
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB);
    mysqli_set_charset($conn, "utf8");
?>