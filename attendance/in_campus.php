<?php
require_once '../global-library/config.php';
require_once '../include/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	function word_split($str,$words=15) {
		$arr = preg_split("/[\s]+/", $str,$words+1);
		$arr = array_slice($arr,0,$words);
		return join(' ',$arr);
	}
	
$sql = $conn->prepare("SELECT * FROM tbl_gate WHERE (g_date_added BETWEEN '$today_date2' and '$today_date2') AND is_mout != '1' AND is_aout != '1' AND is_deleted != '1' ORDER BY g_date_added ASC");
$sql->execute();

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="ASCription" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
    <title>Log Report</title>
    <!-- The styles -->
	<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/include/global-css.php'); ?>
	<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/include/misc-js.php'); ?>
	<style rel="stylesheet">

		.tdlabel
		{   
		   color: #000 !important;
		   font-family: Arial !important;
		   font-weight: bold !important;
		   font-size:14px !important;
		   padding: 10px;
		   border: solid 1px #c3c3c3;
		}
		.tddata
		{   
		   color: #000 !important;
		   font-family: Arial !important;  
		   font-size:13px !important;
		   padding: 10px;
		}
		
		img {
		  border-radius: 50%;
		  object-fit: cover;
		}
		
		tr:nth-child(even) {background-color: #f2f2f2;}
		
	</style>
</head>

<body>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="white-box">
				<h3 class="box-title m-b-0">Log Report - In Campus</h3>
				<p class="text-muted m-b-30"><?php echo $today_date4; ?></p>
				<br />
				<div>				
					<table style="width:100%; padding:17px;" cellpadding="17" cellspacing="17">
						<thead style="position: sticky; top: 0;">
							<tr>
								<th class="tdlabel" style="width:auto;" colspan="3"></th>
								<th class="tdlabel" style="width:auto; text-align: center;">&nbsp;IN</th>
								<th class="tdlabel" style="width:auto;"></th>
							</tr>
							<tr>
								<th class="tdlabel" style="width:20px;">&nbsp;#</th>
								<th class="tdlabel" style="width:auto;">&nbsp;ID Number</th>
								<th class="tdlabel" style="width:auto;">&nbsp;Name</th>
								<th class="tdlabel" style="width:auto; text-align: center;">&nbsp;Date | Time</th>
								<th class="tdlabel" style="width:auto; text-align: center;">&nbsp;Added By</th>
							</tr>
						</thead>
						<tbody>
							
							<?php
								if($sql->rowCount() > 0)
								{
									$ctr = 1;
									while($sql_data = $sql->fetch())
									{
										$rfNum = $sql_data['g_rfid_num'];
										$addedBy = $sql_data['g_added_by'];
										
										$mmIn = $sql_data['is_min'];
										$mmOut = $sql_data['is_mout'];
										
										if($mmIn == '1' && $mmOut != '1'){
											$gateIn = $sql_data['g_date_min'];
										} else {
											$gateIn = $sql_data['g_date_ain'];
										}
										
										$dateIn = date("M d, Y | h:i a", strtotime($gateIn));
										
										$user = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$addedBy' AND is_deleted != '1'");
										$user->execute();
										$user_data = $user->fetch();
										
										$stt = $conn->prepare("SELECT * FROM bs_user WHERE rfid_num = '$rfNum' AND is_deleted != '1'");
										$stt->execute();
										$stt_data = $stt->fetch();
										
										if ($stt_data['thumbnail']) {
											$image = WEB_ROOT . 'assets/images/user/' . $stt_data['thumbnail'];
										} else {
											$image = WEB_ROOT . 'assets/images/user/noimage.png';
										}
							?>
										<tr style="border: solid 1px #c3c3c3; position: sticky; top: 85px;">
											<td class="tddata">&nbsp;<b><?php echo $ctr++; ?>.</b></td>
											<td class="tddata">&nbsp;<b><?php echo $stt_data['id_num']; ?></b></td>
											<td class="tddata">&nbsp;
												<div class="avatar"><img src="<?php echo $image; ?>" alt="<?php echo $stt_data['lastname']; ?>" class="avatar-img rounded-circle"></div>&nbsp;&nbsp;
												<?php echo $stt_data['lastname']; ?>, <?php echo $stt_data['firstname']; ?> <?php echo $stt_data['middlename']; ?></td>
											<td class="tddata" style="text-align: center;">&nbsp;<?php echo $dateIn; ?></td>
											<td class="tddata" style="text-align: center;"><?php echo $user_data['lastname']; ?>, <?php echo $user_data['firstname']; ?><?php echo $user_data['middlename']; ?></td>
										</tr>
							<?php
									} // End While
								}else{}
							?>
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>