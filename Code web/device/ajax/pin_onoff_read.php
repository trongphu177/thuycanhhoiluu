<?php
    include_once '../../plugin/connect.php';
    $pin_code = array();

    $query = "SELECT * FROM mode WHERE id = 1;";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    echo "0:".$row['value'].",";

    $query = "SELECT * FROM device;";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)):
        $pin_code[$row['id']] = $row['code']; 
    endwhile;
    
    foreach ($pin_code as $key => $value) {
        echo $key. ':' . $value . ',';
    }
?>