<?php
    include_once '../../plugin/connect.php';

    $old = '';
    $new = '';

    $query = "SELECT*FROM mode WHERE id = 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
       if (isset($_GET['last'])) {
            $old = $row['value'];
            if ($old == 1)
                $new = 0;
            if ($old == 0)
                $new = 1;
            echo $new;
            $query = "UPDATE mode SET `value` = '{$new}' WHERE id = 1";
            $result = mysqli_query($conn, $query);
        }
?>