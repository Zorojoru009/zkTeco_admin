<?php
require_once '../../global-library/config.php';
require_once '../../include/functions.php';

checkUser();

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">	
	<title>Attendance</title>
	<script type="text/javascript" src="<?php echo WEB_ROOT; ?>calendar/attendance/js/script.js"> </script>	
	<link rel="stylesheet" type="text/css" href="<?php echo WEB_ROOT; ?>calendar/attendance/css/calendar.css" />	
	<script language=JavaScript>m='%3Cscript%20language%3DJavaScript%3E%3C%21--%0D%0A%0D%0Avar%20message%3D%22Right-Click%20Disabled.%20Source%20code%20viewing%20not%20allowed.%21%22%3B%0D%0A%0D%0Afunction%20clickIE%28%29%20%20%7Bif%20%28document.all%29%20%7Balert%28message%29%3Breturn%20false%3B%7D%7D%0D%0Afunction%20clickNS%28e%29%20%7Bif%20%0D%0A%28document.layers%7C%7C%28document.getElementById%26%26%21document.all%29%29%20%7B%0D%0Aif%20%28e.which%3D%3D2%7C%7Ce.which%3D%3D3%29%20%7Balert%28message%29%3Breturn%20false%3B%7D%7D%7D%0D%0Aif%20%28document.layers%29%20%0D%0A%7Bdocument.captureEvents%28Event.MOUSEDOWN%29%3Bdocument.onmousedown%3DclickNS%3B%7D%0D%0Aelse%7Bdocument.onmouseup%3DclickNS%3Bdocument.oncontextmenu%3DclickIE%3B%7D%0D%0A%0D%0Adocument.oncontextmenu%3Dnew%20Function%28%22return%20false%22%29%0D%0A%0D%0A//%20--%3E%3C/script%3E';d=unescape(m);document.write(d);</script>
</head>

<?php

/* draws a calendar */
function draw_calendar($month,$year)
{
	include '../../global-library/database.php';
	
	$empId = $_POST['eid'];
		
	$emp = $conn->prepare("SELECT * FROM bs_employee WHERE user_id = '$empId'");
	$emp->execute();
	$emp_data = $emp->fetch();
	
	$employee = $emp_data['lastname'] . ',&nbsp;' . $emp_data['firstname'];
	$empIdnum = $emp_data['rfid_num'];
	
	
	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	/* table headings */
	$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$calendar.= '<td class="calendar-day">';
			/* add in the day number */
			$calendar.= '<div class="day-number">'.$list_day.'</div>';

			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/		

			
			/* Select attendance logs from the database. LOG IN */		

			$sql_in = $conn->prepare("SELECT * FROM tr_schedule_days WHERE DAY(sch_date) = $list_day AND MONTH(sch_date) = $month AND YEAR(sch_date) = $year AND emp_id = '$empId'
											ORDER BY sch_id ASC");
			$sql_in->execute();
			$sql_in_num = $sql_in->rowCount();			
			while($sql_in_data = $sql_in->fetch())
			{	
				if($sql_in_num > 0) /* If there's record, display time login */
				{					
					if($sql_in_data['shift_type'] == '1'){
						$log_time_in_am = date("h:i A", strtotime($sql_in_data['sch_timein']));	
						$log_time_out_am = date("h:i A", strtotime($sql_in_data['sch_timeout']));
						
						$calendar.= str_repeat('<p class=logging style="color: #2196f3;">&nbsp; 1st Shift</p>',1);
						$calendar.= str_repeat('<p class=logging style="text-indent: 20px;">&nbsp; IN - ' . $log_time_in_am . '</p>',1);
						$calendar.= str_repeat('<p class=logging style="text-indent: 20px;">&nbsp; OUT - ' . $log_time_out_am . '</p>',1);
					} else if($sql_in_data['shift_type'] == '2'){
						$log_time_in_pm = date("h:i A", strtotime($sql_in_data['sch_timein']));	
						$log_time_out_pm = date("h:i A", strtotime($sql_in_data['sch_timeout']));
						
						$calendar.= str_repeat('<p class=logging style="color: #e4a93c;">&nbsp; 2nd Shift</p>',1);
						$calendar.= str_repeat('<p class=logging style="text-indent: 20px;">&nbsp; IN &nbsp;-&nbsp;' . $log_time_in_pm . '</p>',1);
						$calendar.= str_repeat('<p class=logging style="text-indent: 20px;">&nbsp; OUT &nbsp;-&nbsp;' . $log_time_out_pm . '</p>',1);
					} else {
						$calendar.= str_repeat('<b><p class=logging style="font-size: 20px; color: #d6234b;">&nbsp; Day off</p></b>',1);
					}
					
					/*
					$log_time_in_pm = date("h:i A", strtotime($sql_in_data['g_user_atimein']));	
					
					if($sql_in_data['g_user_atimeout'] != "")
					{
						$log_time_out_pm = date("h:i A", strtotime($sql_in_data['g_user_atimeout']));
					}else{
						$log_time_out_pm = "";
					}
					
					$log_time_in_am = date("h:i A", strtotime($sql_in_data['sch_timein']));	
					$log_time_out_am = date("h:i A", strtotime($sql_in_data['sch_timeout']));
					
					$calendar.= str_repeat('<p class=logging>&nbsp; AM IN &nbsp;-&nbsp;' . $log_time_in_am . '</p>',1);
					$calendar.= str_repeat('<p class=logging>&nbsp; AM OUT &nbsp;-&nbsp;' . $log_time_out_am . '</p>',1);
					
					$calendar.= str_repeat('<p class=logging>&nbsp; PM IN &nbsp;-&nbsp;' . $log_time_in_pm . '</p>',1);
					$calendar.= str_repeat('<p class=logging>&nbsp; PM OUT &nbsp;-&nbsp;' . $log_time_out_pm . '</p>',1);
					*/
				}				
				else /* If no record, display No Login */
				{
					$calendar .= '<p class=logging>No Record</p>';
				}
					
			}												
			
			
		$calendar.= '</td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	$calendar.= '</table>';
	
	/* all done, return result */
	return $calendar;
}
/* If button submitted, proceed */
if(isset($_POST['submit']))
{
	$empId = $_POST['eid'];
	$mth = $_POST['month'];
	$yr = $_POST['year'];
	
	$dateObj   = DateTime::createFromFormat('!m', $mth);
	$monthName = $dateObj->format('F');
	
	$dt = $monthName . ' ' . $yr;
	
	$emp = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$empId'");
	$emp->execute();
	$emp_data = $emp->fetch();
	
	$employee = $emp_data['lastname'] . ',&nbsp;' . $emp_data['firstname'];
	$empIdnum = $emp_data['user_id'];
	
	if($today_a == 'am')
	{
		$shift = "AND shift_type = '1'";
	} else {
		$shift = "AND shift_type = '2'";
	}
	
		$sql7 = $conn->prepare("SELECT * FROM tr_schedule_days WHERE emp_id = '$empIdnum' $shift AND sch_date = '$today_date2' AND is_deleted != '1'");
		$sql7->execute();
		
		if($sql7->rowCount() > 0){
			while($sql7_data = $sql7->fetch()){
				$duty_in = date("h:i A", strtotime($sql7_data['sch_timein']));
				$duty_out = date("h:i A", strtotime($sql7_data['sch_timeout']));
			}
		} else {
			$duty_in = "00:00";
			$duty_out = "00:00";
		}
		
	
	
	echo '<table border=0 width=1070 align=center><tr><td valign=top style=float:left><h4>' . utf8_encode($employee) . '<br />' . $mth . '</h4></td><td align=center><b>IN: ' . $duty_in . ' &nbsp;|&nbsp; OUT: ' . $duty_out . '</b></td><td valign=top style=float:right><h3>' . $dt . '</h3></td></tr></table>';
	echo draw_calendar($mth,$yr);
	echo '<br /><center><a type="button" class="btn btn-default" href="' . WEB_ROOT . '">Cancel</a></center>';
}else{}
?>
