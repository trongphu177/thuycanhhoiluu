<?php 
    include_once '../plugin/connect.php';
    $temp = '';
    $hum = '';
    $light = '';
	$tds = '';
    $rain = '';
    $ph = '';
    
    if (isset($_GET['temp'])) {
        $temp = $_GET['temp'];
        $temp_query = "INSERT INTO temperature (value, date) VALUES ({$temp}, now());";
        $temp_result = mysqli_query($conn, $temp_query);
    }

    if (isset($_GET['hum'])) {
        $hum = $_GET['hum'];
        $hum_query = "INSERT INTO humidity (value, date) VALUES ({$hum}, now());";
        $hum_result = mysqli_query($conn, $hum_query);
    }

    if (isset($_GET['light'])) {
        $light = $_GET['light'];
        $light_query = "INSERT INTO light (value, date) VALUES ({$light}, now());";
        $light_result = mysqli_query($conn, $light_query);
    }
	
 	if (isset($_GET['tds'])) {
        $tds = $_GET['tds'];
        $tds_query = "INSERT INTO tds (value, date) VALUES ({$tds}, now());";
        $tds_result = mysqli_query($conn, $tds_query);
    }
	
	if (isset($_GET['rain'])) {
        $rain = $_GET['rain'];
        $rain_query = "INSERT INTO rain (value, date) VALUES ({$rain}, now());";
        $rain_result = mysqli_query($conn, $rain_query);
    }

    if (isset($_GET['ph'])) {
        $ph = $_GET['ph'];
        $ph_query = "INSERT INTO ph (value, date) VALUES ({$ph}, now());";
        $ph_result = mysqli_query($conn, $ph_query);
    }

?>