<?php
    include_once '../../plugin/connect.php';

    $mode = '';
    $max = [];
    $min = [];

    $query = "SELECT*FROM mode";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $mode = $row['value'];

    /* Chuỗi Chế Độ Thủ Công */
    if ($mode == 1) {
        $query = "SELECT*FROM device ORDER BY id ASC";
        $result = mysqli_query($conn, $query);
        echo $mode;
        while ($row = mysqli_fetch_assoc($result)){
            echo $row['code'];
        }
    } 
    
    /* Chuỗi Chế Độ Tự động */

    elseif ($mode == 0) {
        $query = "SELECT*FROM setpoint ORDER BY id ASC";
        $result = mysqli_query($conn, $query);
        $i = 0;
        while ($row = mysqli_fetch_assoc($result)):
            $max[$i] = $row['max'];
            $min[$i] = $row['min'];
            $i+=1;
        endwhile;
        echo $mode."T".$min[0]."-".$max[0]."H".$min[1]."-".$max[1]."L".$min[2]."-".$max[2]."S".$min[3]."-".$max[3]."P".$min[4]."-".$max[4];
        //$query = "SELECT*FROM rain ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        echo "E".$row['value'];
    }

?>