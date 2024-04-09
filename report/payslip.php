<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}

	$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

	$fday = date("Y-m-01");
	$vday = date("Y-m-15");
	$lday = date("Y-m-t");

	if(isset($_POST['from']) && isset($_POST['to']) && isset($_POST['emp']))
	{
		$from = $_POST['from'];
		$to = $_POST['to'];
		$emp1 = $_POST['emp'];
		
		if($emp1 != 0)
		{
			$sql = $conn->prepare("SELECT * FROM bs_employee WHERE id_num = '$emp1' AND is_deleted != '1'");
			$sql->execute();
			$sql_data = $sql->fetch();
				$empIdNum = $sql_data['id_num'];
				$empName = $sql_data['e_lname'] . ', ' . $sql_data['e_fname'] . ' ' . $sql_data['e_mname'];

				$option1 = '<option value="' . $empIdNum . '">' . $empName . '</option>';
		} else {
				$option1 = "";
		}
	} else {

		if($today_date2 <= $vday)
		{
			$from = $fday;
			$to = $vday;
		} else {
			$from = $vday;
			$to = $lday;
		}

		$option1 = "";
	}
?>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h3>Payslip</h3>
					
					<form class="needs-validation" novalidate method="post" action="index.php?view=payslip" enctype="multipart/form-data" name="form" id="form">
						<div class="row">
							<div class="col-lg-3">
								<div class="mb-3">
									<label class="form-label">From</label>
									<input type="text" data-provide="datepicker" data-date-format="yyyy-m-d" class="form-control" name="from" value="<?php echo $from; ?>">
								</div>
							</div> <!-- end col -->

							<div class="col-lg-3">
								<div class="mb-3">
									<label class="form-label">To</label>
									<input type="text" data-provide="datepicker" data-date-format="yyyy-m-d" class="form-control" name="to" value="<?php echo $to; ?>">
								</div>
							</div> <!-- end col -->

							<div class="col-lg-3">
								<div class="mb-3">
									<label for="simpleinput" class="form-label">Employee</label>
									<select class="form-select" name="emp" data-width="100%">
										<?php echo $option1; ?>
										<?php
											$emp = $conn->prepare("SELECT * FROM bs_employee WHERE id_num != '$empIdNum' AND is_deleted != '1'");
											$emp->execute();
											while ($emp_data = $emp->fetch())
											{
										?>
												<option value="<?php echo $emp_data['id_num']; ?>"><?php echo $emp_data['e_lname']; ?>, <?php echo $emp_data['e_fname']; ?> <?php echo $emp_data['e_mname']; ?></option>
										<?php
											}
										?>
									</select>
								</div>
							</div> <!-- end col -->

							<div class="col-lg-3">
								<div class="mb-3">
									<button class="btn btn-success" type="submit" style="margin-top: 29px;">Save</button>
								</div>
							</div> <!-- end col -->
						</div>
					</form>
					<!-- end row-->
				</div>
			</div>
		</div>
	<?php
		if(isset($_POST['from']) && isset($_POST['to']) && isset($_POST['emp']))
		{
			$from1 = $_POST['from'];
			$to1 = $_POST['to'];
			$emp2 = $_POST['emp'];

			$emp3 = $conn->prepare("SELECT * FROM bs_employee WHERE id_num = '$emp2' AND is_deleted != '1'");
			$emp3->execute();
			while($emp3_data = $emp3->fetch()){
				$eId = $emp3_data['e_id'];
				$tos = $emp3_data['type_of_salary'];
			}

	?>
		<style rel="stylesheet">
			th
			{   
				text-align: center;
			}

			td
			{   
				vertical-align: super;
				text-align: center;
			}
		</style>

		<div class="col-12">
			<div class="card">
				<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered mb-0">
									<thead>
									<tr>
										<th>Date</th>
										<th>From</th>
										<th>To</th>
										<th style="color: #ec6761;">Undertime/Tardiness</th>
										<th style="color: #81b4f3;">Total mins served</th>
									</tr>
									</thead>
									
									<tbody>
								<?php
									// Function to check if a given date is a weekend (Saturday or Sunday)
									function isWeekend($date) {
										return (date('N', strtotime($date)) >= 6);
									}

									// Function to check if a given date is a holiday
									function isHoliday($date, $holidays) {
										return in_array($date, $holidays);
									}

									// Start and end dates for the loop
									$start_date = $from1;
									$end_date = $to1;

									$cal = $conn->prepare("SELECT * FROM tbl_calendar WHERE c_id = '1' AND is_deleted != '1'");
									$cal->execute();
									$cal_data = $cal->fetch();
										$cDate = $cal_data['c_date'];

										$dateArray = explode(", ", $cDate);

										// Now $dateArray contains each date as an element
										//print_r($dateArray);

									// Array of holiday dates
									//$holidays = array('2024-01-01', '2024-01-02', '2024-01-03');
									$holidays = $dateArray;
									$totalMinutes = 0;
									$totalUtd = 0;
									// Loop through each date in the range
									$current_date = $start_date;
									while (strtotime($current_date) <= strtotime($end_date))
									{
										// $from_time = '07:30';
										// $to_time = '17:30';
										$tsd3 = $conn->prepare("SELECT * FROM tr_schedule_days WHERE emp_id = '$eId' AND sch_date = '$current_date' AND shift_type = '3' AND is_deleted != '1'");
										$tsd3->execute();
										if($tsd3->rowCount() > 0){
											$tsd3Id = '1';
											$from_time = '00:00';
											$to_time = '00:00';
										} else {
											$tsd3Id = '0';

											$tsd1 = $conn->prepare("SELECT * FROM tr_schedule_days WHERE emp_id = '$eId' AND sch_date = '$current_date' AND shift_type = '1' AND is_deleted != '1'");
											$tsd1->execute();
											if($tsd1->rowCount() > 0)
											{
												while($tsd1_data = $tsd1->fetch())
												{
													$schTimeIn = date("h:i A",strtotime($tsd1_data['sch_timein'])); // Time In
													$from_time = $tsd1_data['sch_timein'];
												}
											} else {
												//$schTimeIn = "Schedule Not Set";
												$tsd22 = $conn->prepare("SELECT * FROM tr_schedule_days WHERE emp_id = '$eId' AND sch_date = '$current_date' AND shift_type = '2' AND is_deleted != '1'");
												$tsd22->execute();
												if($tsd22->rowCount() > 0)
												{
													while($tsd22_data = $tsd22->fetch())
													{
														$schTimeIn = date("h:i A",strtotime($tsd22_data['sch_timein'])); // Time Out
														$from_time = $tsd22_data['sch_timein'];
													}
												} else {
													$schTimeIn = "Schedule Not Set";

													$from_time = '00:00';
													$to_time = '00:00';
												}
											}
											
											$tsd2 = $conn->prepare("SELECT * FROM tr_schedule_days WHERE emp_id = '$eId' AND sch_date = '$current_date' AND shift_type = '2' AND is_deleted != '1'");
											$tsd2->execute();
											if($tsd2->rowCount() > 0)
											{
												while($tsd2_data = $tsd2->fetch())
												{
													$schTimeOut = date("h:i A",strtotime($tsd2_data['sch_timeout'])); // Time Out
													$to_time = $tsd2_data['sch_timeout'];
												}
											} else {
												//$schTimeOut = "Schedule Not Set";
												$tsd11 = $conn->prepare("SELECT * FROM tr_schedule_days WHERE emp_id = '$eId' AND sch_date = '$current_date' AND shift_type = '1' AND is_deleted != '1'");
												$tsd11->execute();
												if($tsd11->rowCount() > 0)
												{
													while($tsd11_data = $tsd11->fetch())
													{
														$schTimeOut = date("h:i A",strtotime($tsd11_data['sch_timeout'])); // Time In
														$to_time = $tsd11_data['sch_timeout'];
													}
												} else {
													$schTimeOut = "Schedule Not Set";
												}
											}
										}
										
										if($tos == 1)
										{
											// Example start and end times (as DateTime objects)
											$startTime = new DateTime($from_time);
											$endTime = new DateTime($to_time);

											// Calculate the interval between the two times
											$interval = $startTime->diff($endTime);

											// Extract minutes from the interval
											$eq1 = (($interval->h - 2) * 60) + $interval->i;

											// Display the result
											// echo "Total minutes: " . $eq1;
											$minutes = $eq1;
										} else {
											// Query to retrieve login/logout events
											$sql1 = $conn->prepare("SELECT * FROM tbl_attendance WHERE id_num = '$emp2' AND a_date = '$current_date' AND is_deleted != '1' ORDER BY a_datetime ASC");
											$sql1->execute();

											if ($sql1->rowCount() > 0)
											{
												$loginTime = null; $minutes = 0;
												// Loop through each row in the result set
												while ($sql1_data = $sql1->fetch()) {
													$aId = $sql1_data['a_id'];
													$aTime = $sql1_data['a_time'];
													$isLog = $sql1_data['is_log'];

													if ($isLog == 0) {
														// User has logged in, record the login time
														$loginTime = new DateTime($aTime);
													} else {
														// User has logged out, calculate and display total hours
														if ($loginTime) {
															$logoutTime = new DateTime($aTime);

															// Calculate the interval between the two times
															$interval = $loginTime->diff($logoutTime);

															// Extract minutes from the interval
															$minutes += $interval->h * 60 + $interval->i;
														}
													}
												}
											} else {
												// echo "No login/logout records found";
												$minutes = '0';
											}
										}

										// Convert times to DateTime objects
										$from_datetime = DateTime::createFromFormat('H:i', $from_time);
										$to_datetime = DateTime::createFromFormat('H:i', $to_time);

										// Calculate the difference in hours
										$interval = $from_datetime->diff($to_datetime);
										$hour = $interval->h;
										
											$breaks = 2; //NUmber of breaks
											$hours = $hour - $breaks;
											$mins = $hours * 60; // Get Total Minutes
											
										// Check if the current date is a weekend or a holiday
										if (isWeekend($current_date))
										{
											//echo $current_date . " is a weekend.\n";
											$cDateWeekEnd = date("m/d",strtotime($current_date)); // Weekend

											if($tsd3Id == 1)
											{
												if($tos == 1){
													$utd = $mins - $minutes;
													$totalUtd += $utd;
													$totalMinutes += $minutes;
													$mts = '<a style="color: #81b4f3;">' . $minutes . '</a>';
												} else {
													$mts = '';
												}
								?>
												<tr>
													<th><?php echo $cDateWeekEnd; ?></th>
													<td colspan="2"><b style="color: #ec6761;">OFF</b></td>
													<td></td>
													<td><?php echo $mts; ?></td>
												</tr>
								<?php
											} else {
												$utd = $mins - $minutes;
												$totalUtd += $utd;
												$totalMinutes += $minutes;
								?>
												<tr>
													<th><?php echo $cDateWeekEnd; ?></th>
													<td><a style="color: #ec6761;"><?php echo $schTimeIn; ?></a></td>
													<td><a style="color: #ec6761;"><?php echo $schTimeOut; ?></a></td>
													<td><a style="color: #ec6761;"><?php echo $utd; ?></a></td>
													<td><a style="color: #81b4f3;"><?php echo $minutes; ?></a></td>
												</tr>
								<?php
											}

										} else if (isHoliday($current_date, $holidays)) {
											//echo $current_date . " is a holiday.\n";
											$cDateHoliday = date("m/d",strtotime($current_date)); // Holiday

											if($tos == 1){
												$utd = $mins - $minutes;
												$totalUtd += $utd;
												$totalMinutes += $minutes;
								?>
											<tr>
												<th><?php echo $cDateHoliday; ?></th>
												<td colspan="2"><b style="color: #ec6761;">Holiday</b></td>
												<td><a style="color: #ec6761;"><?php echo $utd; ?></a></td>
												<td><a style="color: #81b4f3;"><?php echo $minutes; ?></a></td>
											</tr>
								<?php
											} else {
								?>
											<tr>
												<th><?php echo $cDateHoliday; ?></th>
												<td colspan="2"><b style="color: #ec6761;">Holiday</b></td>
												<td></td>
												<td></td>
											</tr>
								<?php
											}
										} else {
											//echo $current_date . " is a regular weekday.\n";
											$cDateWeekDay = date("m/d",strtotime($current_date)); // Weekday

											$utd = $mins - $minutes;
											$totalUtd += $utd;
											$totalMinutes += $minutes;
								?>
											<tr>
												<th><?php echo $cDateWeekDay; ?></th>
												<td><?php echo $schTimeIn; ?></td>
												<td><?php echo $schTimeOut; ?></td>
												<td><a style="color: #ec6761;"><?php echo $utd; ?></a></td>
												<td><a style="color: #81b4f3;"><?php echo $minutes; ?></a></td>
											</tr>
								<?php
											
										}
										
										// Move to the next date
										$current_date = date('Y-m-d', strtotime($current_date . ' +1 day'));
									}
								?>
											<tr>
												<th style="color: #81b4f3;">Total Mins</th>
												<td></td>
												<td></td>
												<td><a style="color: #ec6761;"><?php echo number_format($totalUtd, 0); ?></a></td>
												<td><a style="color: #81b4f3;"><?php echo number_format($totalMinutes, 0); ?></a></td>
											</tr>
											<!-- <tr>
												<th style="color: #81b4f3;">Rate/Mins</th>
												<td></td>
												<td></td>
												<td></td>
												<td><?php echo number_format($totalMinutes, 0); ?></td>
											</tr> -->
									</tbody>
								</table>
							</div>
				</div>
			</div> <!-- end card -->
		</div>
	<?php
		} else {}
	?>
	</div> <!-- end row -->

	<!-- $tsd1 = $conn->prepare("SELECT * FROM tr_schedule_days WHERE sch_date = '$current_date' AND shift_type = '1' AND is_deleted != '1'");
	$tsd1->execute();
	if($tsd1->rowCount() > 0)
	{
		while($tsd1_data = $tsd1->fetch())
		{
			$schTimeIn = date("h:i A",strtotime($tsd1_data['sch_timein'])); // Time In
		}
	} else {
		$schTimeIn = "Schedule Not Set";
	}
	
	$tsd2 = $conn->prepare("SELECT * FROM tr_schedule_days WHERE sch_date = '$current_date' AND shift_type = '2' AND is_deleted != '1'");
	$tsd2->execute();
	if($tsd2->rowCount() > 0)
	{
		while($tsd2_data = $tsd2->fetch())
		{
			$schTimeOut = date("h:i A",strtotime($tsd2_data['sch_timeout'])); // Time Out
		}
	} else {
		$schTimeOut = "Schedule Not Set";
	}
	
	$totalMins += $mins; -->