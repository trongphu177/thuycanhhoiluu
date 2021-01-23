<?php
    include_once '../../../plugin/connect.php';
    $start = date("Y-m-d 00:00:00");
    $end = date("Y-m-d 23:59:59");

    // GET MIN TEMP, DATE
    $query = "SELECT value, date FROM temperature WHERE date BETWEEN '{$start}' AND '{$end}'";
    $result = mysqli_query($conn, $query);

    $min = 100;
    $min_date = '';

    while ($get = mysqli_fetch_assoc($result)):
        if ($get['value'] < $min) {
            $min = $get['value'];
            $min_date = $get['date'];
        }
    endwhile;

    $min_date = date("H:i:s", strtotime($min_date));

    // GET MAX TEMP, DATE
    $query = "SELECT value, date FROM temperature WHERE date BETWEEN '{$start}' AND '{$end}'";
    $result = mysqli_query($conn, $query);

    $max = -100;
    $max_date = '';

    while ($get = mysqli_fetch_assoc($result)):
        if ($get['value'] > $max) {
            $max = $get['value'];
            $max_date = $get['date'];
        }
    endwhile;

    $max_date = date("H:i:s", strtotime($max_date));

    // GET AVERAGE TEMP
    $query = "SELECT AVG(value) AS ave FROM temperature WHERE date BETWEEN '{$start}' AND '{$end}'";
    $result = mysqli_query($conn, $query);
    $get = mysqli_fetch_assoc($result);
    $ave = $get['ave'];
    $ave = number_format($ave, 1);

    if($min == 100){
        $min = '';
    }
    if($max == -100){
        $max = '';
    }

    echo $max.','.$max_date.','.$min.','.$min_date.','.$ave;


?>