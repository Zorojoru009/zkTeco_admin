<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

	$eid = $_GET['eid'];

?>

	<div class="container-fluid page__container page-section pb-0">
		<h1 class="h2 mb-0">Calendar</h1>

		<ol class="breadcrumb p-0 m-0">
			<li class="breadcrumb-item"><a href="<?php echo WEB_ROOT; ?>">Home</a></li>
			
			<li class="breadcrumb-item active">

				Calendar

			</li>

		</ol>

	</div>
	
	<form class="form-horizontal" method="post" action="<?php echo WEB_ROOT; ?>calendar/attendance/index.php"  enctype="multipart/form-data" name="form" id="form">
	<div class="container-fluid page__container page-section">

		<div class="row mb-32pt">
			
			<div class="col-lg-8">
				<div class="flex"
					 style="max-width: 100%">
					<?php
						if($errorMessage == 'Added successfully')
						{
					?>
							<div class="alert alert-soft-success alert-dismissible fade show"
								 role="alert">
								<button type="button"
										class="close"
										data-dismiss="alert"
										aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<div class="d-flex flex-wrap align-items-start">
									<div class="mr-8pt">
										<i class="material-icons">access_time</i>
									</div>
									<div class="flex"
										 style="min-width: 180px">
										<small class="text-black-100">
											<strong>Well done!</strong> <?php echo $errorMessage; ?>
										</small>
									</div>
								</div>
							</div>
					<?php
						}
						else if($errorMessage == 'Data already exist! Data entry failed.')
						{
					?>							
							<div class="alert alert-soft-danger alert-dismissible fade show"
								 role="alert">
								<button type="button"
										class="close"
										data-dismiss="alert"
										aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<div class="d-flex flex-wrap align-items-start">
									<div class="mr-8pt">
										<i class="material-icons">access_time</i>
									</div>
									<div class="flex"
										 style="min-width: 180px">
										<small class="text-black-100">
											<strong>Oh snap!</strong> <?php echo $errorMessage; ?>
										</small>
									</div>
								</div>
							</div>
					<?php								
						}else{}
						
						$today_month = date("m");
						
						$monthnum = date("F",strtotime('2023-' . $today_month));
					?>
						<div class="form-group">
							<label class="form-label"
								   for="select01">Month:</label>
							<select id="select01"
									data-toggle="select"
									class="form-control" name="month">
								<option value="<?php echo $today_month; ?>"><?php echo $monthnum; ?></option>
								<?php
									for($x1=1; $x1<=12; $x1++)
									{
										$cts1 = strlen($x1);
										if($cts1 != 2){ $y1 = 0 . $x1; }else{ $y1 = $x1; }
										
										$monthnum7 = date("F",strtotime('2023-' . $y1));
								?>
										<option value="<?php echo $y1; ?>"><?php echo $monthnum7; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label class="form-label"
								   for="exampleInputuname">Year:</label>
							<input type="text"
								   class="form-control"
								   id="exampleInputuname" name="year"
								   placeholder="Enter Year .." value="2023" autocomplete=off required />
						</div>
						
						<input type="hidden" name="eid" value="<?php echo $eid; ?>" />
						<a class="btn btn-outline-dark" href="<?php echo WEB_ROOT; ?>">Cancel</a>
						<button type="submit" name="submit"
								class="btn btn-success" style="float: right;">Save</button>
					
				</div>
			</div>
			
		</div>
	</div>
	</form>