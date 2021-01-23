<?php
    include_once '../../plugin/connect.php';
    $pin_code = array();

    $query = "SELECT * FROM device;";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)):
        $pin_status[$row['id']] = $row['status']; 
    endwhile;
    
    foreach ($pin_status as $key => $value) {
        echo $key. ':' . $value . ',';
    }
?>