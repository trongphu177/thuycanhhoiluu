<?php
    include_once '../../plugin/connect.php';
    $query = "SELECT*FROM device";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)){
        if (isset($_GET['pin_'.$row['id']])){
            $status = $_GET['pin_'.$row['id']];
            $pin = $row['id'];
            $q = "UPDATE device SET `status` = '{$status}' WHERE id = '{$pin}'";
            $r = mysqli_query($conn, $q);
        }
    }
?>