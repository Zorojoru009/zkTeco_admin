<?php 

require_once '../global-library/config.php';
require_once '../include/functions.php';


checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
	
    case 'changeIp' :
        changeIp();
        break;
    
	   
    default :
        // if action is not defined or unknown
        // move to main category page
        // header('Location: index.php');
}


function changeIp(){
    include '../global-library/database.php';
    $ip = $_POST['ip'];

    $updateApi = $conn->prepare("UPDATE bs_config SET ip = '$ip' WHERE il_id = '1' ");
    $updateApi->execute();

    header("location: index.php?feedbackMessage=changeIpSuccess");
}


?>