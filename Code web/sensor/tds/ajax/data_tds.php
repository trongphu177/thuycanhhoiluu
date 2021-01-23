<?php
    include_once '../../../plugin/connect.php';
    $query = "SELECT * FROM tds ORDER BY id DESC";
    $result = mysqli_query($conn, $query);
    $number = 1;
    while ($row = mysqli_fetch_assoc($result)):
        echo "<tr>";
        echo "<td>{$number}</td>";
        echo "<td>{$row['value']}ppm</td>";
        echo "<td>".date('d/m/Y', strtotime($row['date']))."</td>";
        echo "<td>".date('H:i:s', strtotime($row['date']))."</td>";
        echo "</tr>";
        $number += 1;
    endwhile;
?>