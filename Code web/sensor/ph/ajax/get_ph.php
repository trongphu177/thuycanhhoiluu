<?php
    include_once '../../../plugin/connect.php';
    if (isset($_GET['last'])) {
        $start = date("Y-m-d 00:00:00");
        $end = date("Y-m-d 23:59:59");
        $query = "SELECT value FROM ph WHERE date BETWEEN '{$start}' AND '{$end}' ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($conn, $query);
        $result = mysqli_fetch_assoc($result);
        $result = $result['value'];
        echo $result;
    }
?>