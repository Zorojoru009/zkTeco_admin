<?php
require_once '../../global-library/config.php';
require_once '../../include/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");

if (isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end']))
{	
	$id = $_POST['id'];
	$title = $_POST['title'];	
	$start = $_POST['start'];
	$ed1 = $_POST['end'];
		$ed2 = $ed1 . ' 24:00:00';
		$end = date("Y-m-d H:i:s",strtotime($ed2));

	foreach ($id as $dataId)
	{
		$tr = $conn->prepare("SELECT * FROM bs_employee WHERE e_id = '$dataId'");
		$tr->execute();
		$tr_data = $tr->fetch();
		$offId = $tr_data['e_branch'];
		
		// Duty Schedule
			# Duty IN
				$din1 = $_POST['din1'];
				$din2 = $_POST['din2'];
				$duty_in = $din1 . ':' . $din2;		
			# Duty OUT
				$dout1 = $_POST['dout1'];
				$dout2 = $_POST['dout2'];
				$duty_out = $dout1 . ':' . $dout2;
			
		// Break Schedule
		/*
			# Break IN
				$bin1 = $_POST['bin1'];
				$bin2 = $_POST['bin2'];
				$break_in = $bin1 . ':' . $bin2;		
			# Break OUT
				$bout1 = $_POST['bout1'];
				$bout2 = $_POST['bout2'];
				$break_out = $bout1 . ':' . $bout2;
		*/
		
		// Shift Name
		if($title == "s"){
			$sched_type = 1; $shift_type = 1; $color = "#2196f3"; $ntitle = "1st Shift"; $bin = ""; $bout = ""; $cc = "s";
		} else if($title == "b"){
			$sched_type = 1; $shift_type = 2; $color = "#e4a93c"; $ntitle = "2nd Shift"; $bin = ""; $bout = ""; $cc = "b";
		} else if($title == "o"){
			$sched_type = 1; $shift_type = 3; $color = "#d6234b"; $ntitle = "Off Duty"; $bin = ""; $bout = ""; $cc = "o";
		}

		// Generate Code
			$year_today = date('y'); # Year
			$num_str = sprintf("%06d", mt_rand(1, 999999));
			$code = $dataId . '_' . $num_str . '_' . $year_today;
			$code_s = $dataId . '_' . $num_str . $cc . '_' . $year_today;
			$code_b = $dataId . '_' . $num_str . $cc . 'b' . '_' . $year_today;
			
		# Start insert to bs_schedule
				//include 'insert_schedule.php';
		# End insert to bs_schedule
			
			$sql = "INSERT INTO tr_schedule(office_id, emp_id, code, title, start, end, color, duty_date_from, duty_date_to, time_in, time_out, added_by, date_added) 
						VALUES ('$offId', '$dataId', '$code_s', '$ntitle', '$start', '$end', '$color', '$start', '$end', '$duty_in', '$duty_out', '$userId', '$today_date1')";	
			
		
		$query = $conn->prepare( $sql );
		if ($query == false) {
		print_r($conn->errorInfo());
		die ('Error prepare');
		}
		$sth = $query->execute();
		if ($sth == false) {
		print_r($query->errorInfo());
		die ('Error execute');
		}
			
			// Schedule Days
			$newfrom = date("Y-m-d", strtotime($start));
			$newto = date("Y-m-d", strtotime($end));
			
			$period = new DatePeriod(
				new DateTime($newfrom),
				new DateInterval('P1D'),
				new DateTime($newto)
			);

			foreach ($period as $key => $value) {
				$dd = $value->format('Y-m-d');
				//echo $dd . '<br />';
				
				$emp7 = $conn->prepare("SELECT * FROM bs_employee WHERE e_id = '$dataId' AND is_deleted != '1'");
				$emp7->execute();
				$emp7_num = $emp7->rowCount();
				if($emp7_num > 0)
				{
					while($emp7_data = $emp7->fetch())
					{					
							$in = $conn->prepare("INSERT INTO tr_schedule_days (code, office_id, emp_id, sch_date, sch_timein, sch_timeout, schedule_type, shift_type, date_added)
										VALUES ('$code_s', '$offId', '$dataId', '$dd', '$duty_in', '$duty_out', '$sched_type', '$shift_type', '$today_date1')");
							$in->execute();
							
							
					} // End While
				}else{}
			}
	}
}
header('Location: '.$_SERVER['HTTP_REFERER']);

	
?>
