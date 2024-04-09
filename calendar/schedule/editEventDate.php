<?php
require_once '../../global-library/config.php';
require_once '../../include/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");

if (isset($_POST['Event'][0]) && isset($_POST['Event'][1]) && isset($_POST['Event'][2])){
	
	
	$id = $_POST['Event'][0];
	$start = $_POST['Event'][1];
	$end = $_POST['Event'][2];
	
	$rw = $conn->prepare("SELECT * FROM tr_schedule WHERE ns_id = '$id'");
	$rw->execute();
	$rw_gt = $rw->fetch();
	$scode = $rw_gt['code'];
	$offid = $rw_gt['office_id'];
	$empid = $rw_gt['emp_id'];
	$duty_in = $rw_gt['time_in'];
	$duty_out = $rw_gt['time_out'];	
	$ddf = $rw_gt['duty_date_from'];
	$ddt = $rw_gt['duty_date_to'];
	$title = $rw_gt['title'];
	
	$date7 = new DateTime($ddt);
	$date7->modify('-1 day');
	$ndte = $date7->format('Y-m-d') . "\n";
	
	// Shift Name
	if($title == "1st Shift"){
		$sched_type = 1; $shift_type = 1; $color = "#2196f3"; $ntitle = "1st Shift"; $bin = ""; $bout = ""; $cc = "s";
	} else if($title == "2nd Shift"){
		$sched_type = 1; $shift_type = 2; $color = "#e4a93c"; $ntitle = "2nd Shift"; $bin = ""; $bout = ""; $cc = "b";
	} else if($title == "Off Duty"){
		$sched_type = 1; $shift_type = 3; $color = "#d6234b"; $ntitle = "Off Duty"; $bin = ""; $bout = ""; $cc = "o";
	}
	
	//$sched_type = 1; $shift_type = 3; $color = "#0071c5"; $ntitle = "Straight Shift";
	
		
	$newfrom = date("Y-m-d", strtotime($start));
	$newto = date("Y-m-d", strtotime($end));
	$del = $conn->prepare("DELETE FROM tr_schedule_days WHERE code = '$scode' AND emp_id = '$empid' AND (sch_date BETWEEN '$ddf' and '$ndte')");
	$del->execute();
	
	$period = new DatePeriod(
		new DateTime($newfrom),
		new DateInterval('P1D'),
		new DateTime($newto)
	);

	foreach ($period as $key => $value) {
		$dd = $value->format('Y-m-d');
		//echo $dd . '<br />';
		
		$emp7 = $conn->prepare("SELECT * FROM bs_employee WHERE e_id = '$empid' AND is_deleted != '1'");
		$emp7->execute();
		$emp7_num = $emp7->rowCount();
		if($emp7_num > 0)
		{
			while($emp7_data = $emp7->fetch())
			{
		
		
					$in = $conn->prepare("INSERT INTO tr_schedule_days (code, office_id, emp_id, sch_date, sch_timein, sch_timeout, schedule_type, shift_type, date_added)
								VALUES ('$scode', '$offid', '$empid', '$dd', '$duty_in', '$duty_out', '$sched_type', '$shift_type', '$today_date1')");
					$in->execute();
			} // End While
		}else{}
	}

	$sql = "UPDATE tr_schedule SET start = '$start', end = '$end', duty_date_from = '$start', duty_date_to = '$end', 
				modified_by = '$userId', date_modified = '$today_date1' WHERE code = '$scode' AND emp_id = '$empid' AND duty_date_from = '$ddf' AND duty_date_to = '$ddt'";

	
	$query = $conn->prepare( $sql );
	if ($query == false) {
	 print_r($conn->errorInfo());
	 die ('Error prepare');
	}
	$sth = $query->execute();
	if ($sth == false) {
	 print_r($query->errorInfo());
	 die ('Error execute');
	}else{
		die ('OK');
	}
	
	

}
//header('Location: '.$_SERVER['HTTP_REFERER']);

	
?>
