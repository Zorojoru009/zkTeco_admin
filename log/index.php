<?php
require_once '../global-library/config.php';
require_once '../include/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$pg = $conn->prepare("UPDATE bs_page SET page_name = 'Activity Logs' WHERE p_id = '1'");
$pg->execute();

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';
	
switch ($view) {
	case 'list' :
		$content 	= 'list.php';		
		$pageTitle 	= $sett_data['system_title'];
		break;

	default :
		$content 	= 'list.php';		
		$pageTitle 	= $sett_data['system_title'];
}


$script    = array('category.js');

require_once '../include/template.php';
?>
