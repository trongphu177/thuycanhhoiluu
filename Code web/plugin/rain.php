<?php
	include_once '../plugin/connect.php';
	$query = "SELECT * FROM rain ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $rain = $row['value'];
    echo $rain;

?>