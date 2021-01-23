<?php
    include_once '../../plugin/connect.php';

    $code = '';
    $pin = '';

    $query = "SELECT*FROM device";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        if (isset($_GET['btn_'.$row['id']])) {
            $code = $_GET['btn_'.$row['id']];
            $pin = $row['id'];
            if ($code == 'on')
                $code = 1;
            if ($code == 'off')
                $code = 0;
            $query = "UPDATE device SET `code` = '{$code}' WHERE id = '{$pin}'";
            $result = mysqli_query($conn, $query);
        }
    }
?>