<?php
require_once '../../global-library/config.php';
require_once '../../include/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");

if (isset($_POST['delete']) && isset($_POST['id'])){
	
	
	$id = $_POST['id'];
	
	$gt = $conn->prepare("SELECT * FROM tr_schedule WHERE ns_id = '$id'");
	$gt->execute();
	$rw_gt = $gt->fetch();
	$scode = $rw_gt['code'];
	$empId = $rw_gt['emp_id'];
	$ddf = $rw_gt['duty_date_from'];
	$ddt = $rw_gt['duty_date_to'];
	
	$date7 = new DateTime($ddt);
	$date7->modify('-1 day');
	$ndte = $date7->format('Y-m-d') . "\n";
	
	$del = $conn->prepare("DELETE FROM tr_schedule_days WHERE code = '$scode' AND emp_id = '$empId' AND (sch_date BETWEEN '$ddf' and '$ndte')");
	$del->execute();
	
	$sql = "DELETE FROM tr_schedule WHERE code = '$scode' AND emp_id = '$empId' AND duty_date_from = '$ddf' AND duty_date_to = '$ddt'";
	$query = $conn->prepare( $sql );
	if ($query == false) {
	 print_r($conn->errorInfo());
	 die ('Error prepare');
	}
	$res = $query->execute();
	if ($res == false) {
	 print_r($query->errorInfo());
	 die ('Error execute');
	}
	
}else{}

//header('Location: index.php');
header('Location: '.$_SERVER['HTTP_REFERER']);

	
?>
