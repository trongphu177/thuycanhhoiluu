<?php
    include_once 'header.php';
    include_once 'sidebar.php';
    include_once 'navbar.php';
    switch ($menu) {
        case 'temp':
           include_once '../sensor/temp/includes/in_temp.php';
            break;
        case 'hum':
            include_once '../sensor/hum/includes/in_hum.php';
            break;
		case 'tds':
           include_once '../sensor/tds/includes/in_tds.php';
            break;
        case 'control':
            include_once '../device/includes/control.php';
            break;
        case 'light':
            include_once '../sensor/light/includes/in_light.php';
            break;
        case 'ph':
            include_once '../sensor/ph/includes/in_ph.php';
            break;
        default:
            header('Location: ../index.php');
            break;
    };
    include_once 'footer.php';
?>