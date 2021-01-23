<?php
    include_once '../../plugin/connect.php';

    $id = '';
    $max = '';
    $min = '';

    $query = "SELECT*FROM setpoint";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
       if (isset($_POST['id']) && isset($_POST['max']) && isset($_POST['min'])) {
            $id = $_POST['id'];
            $max = $_POST['max'];
            $min = $_POST['min'];
            $query = "UPDATE setpoint SET `max` = '{$max}', `min` = '{$min}' WHERE id = '{$id}'";
            $result = mysqli_query($conn, $query);
        }
    echo $id."-".$max."-".$min;
?>