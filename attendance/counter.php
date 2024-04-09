<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}

	$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
?>

<div class="container-fluid page__container page-section">
	<div class="row col-lg-12">
		
	<style>
  .switch {
    position: relative;
    top: 35%;
    left: 8%;
    width: 90%;
    height: 70px;
    text-align: center;
    margin: -30px 0 0 -75px;
    background: #5ac172;
    transition: all 0.2s ease;
    border-radius: 25px;
  }
  .switch span {
    position: absolute;
    width: 20px;
    height: 4px;
    top: 50%;
    left: 50%;
    margin: -2px 0px 0px -4px;
    background: #fff;
    display: block;
    transform: rotate(-45deg);
    transition: all 0.2s ease;
  }
  .switch span:after {
    content: "";
    display: block;
    position: absolute;
    width: 4px;
    height: 12px;
    margin-top: -8px;
    background: #fff;
    transition: all 0.2s ease;
  }
  input[type=radio] {
    display: none;
  }
  .switch label {
    cursor: pointer;
    color: rgba(0,0,0,0.2);
    width: 60px;
    line-height: 50px;
    transition: all 0.2s ease;
  }
  label[for=yes] {
    position: absolute;
	font-size: 30px;
	top: 15%;
    left: 0px;
	width: 150px;
    height: 90px;
  }
  label[for=no] {
    position: absolute;
	font-size: 30px;
	top: 15%;
    right: 0px;
	width: 150px;
	height: 90px;
  }
  #no:checked ~ .switch {
    background: #ec6761;
  }
  #no:checked ~ .switch span {
    background: #fff;
    margin-left: -8px;
  }
  #no:checked ~ .switch span:after {
    background: #fff;
    height: 20px;
    margin-top: -8px;
    margin-left: 8px;
  }
  #yes:checked ~ .switch label[for=yes] {
    color: #fff;
  }
  #no:checked ~ .switch label[for=no] {
    color: #fff;
  }
	</style>

	<div class="content">
		<!-- Start Content-->
		<div class="container-fluid">
			<div class="row">
			
				<div class="col-lg-6">
					<div class="card">
						<div class="card-body">
							<div class="dropdown float-end">
								<?php
									$loc = $conn->prepare("SELECT * FROM tbl_location");
									$loc->execute();
  									$loc_data = $loc->fetch();

									if($loc_data['is_active'] != 1){
								?>
									<button type="submit" class="btn btn-soft-danger waves-effect rounded-pill waves-light" style="float: right;" onclick="getLocation()">
										<i class="mdi mdi-map-marker"></i>
									</button>
								<?php
									} else {
								?>
								<?php
									}
								?>
								
							</div>
							<h3>Attendance</h3>
							<p class="sub-header"></p>
						<?php
							if($errorMessage == 'Added successfully.')
							{
						?>
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<i class="mdi mdi-check-all me-2"></i> <strong><?php echo $errorMessage; ?></strong>
							</div>
						<?php
							}
							else if($errorMessage == 'ID number already login! Data entry failed.')
							{
						?>	
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<i class="mdi mdi-block-helper me-2"></i> <strong><?php echo $errorMessage; ?></strong>
							</div>
						<?php								
							} else if($errorMessage == 'ID number already logout! Data entry failed.')
							{
						?>	
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<i class="mdi mdi-block-helper me-2"></i> <strong><?php echo $errorMessage; ?></strong>
							</div>
						<?php								
							} else if($errorMessage == 'RFID does not exist! Data entry failed.')
							{
						?>	
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<i class="mdi mdi-block-helper me-2"></i> <strong><?php echo $errorMessage; ?></strong>
							</div>
						<?php								
							} else if($errorMessage == 'Location Pinned.')
							{
						?>	
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<i class="mdi mdi-check-all me-2"></i> <strong><?php echo $errorMessage; ?></strong>
							</div>
						<?php								
							} else if($errorMessage == 'Logout successfully.')
							{
						?>	
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<i class="mdi mdi-check-all me-2"></i> <strong><?php echo $errorMessage; ?></strong>
							</div>
						<?php								
							} else if($errorMessage == 'Login successfully.')
							{
						?>	
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								<i class="mdi mdi-check-all me-2"></i> <strong><?php echo $errorMessage; ?></strong>
							</div>
						<?php								
							} else {}
						?>
						<br />
							<form class="needs-validation" novalidate method="post" action="process.php?action=add"  enctype="multipart/form-data" name="form" id="form">
								<div class="mb-3">
									<center>
										<div class="form-group">
											<div class="toggle-radio">
											<input type="radio" name="is_log" id="yes" value="0" checked>
											<input type="radio" name="is_log" id="no" value="1" >
											<div class="switch">
												<label for="yes"><b>IN</b></label>
												<label for="no"><b>OUT</b></label>
												<span></span>
											</div>
											</div>
										</div>
									</center>
								</div>
								<div class="mb-3">
									<label for="validationCustom02" class="form-label">Tap ID: </label>
									<input type="text" class="form-control" id="validationCustom02" name="rfid" placeholder="Tap ID" autocomplete="off" required />
									<div class="invalid-feedback">
										Please provide a valid ID.
									</div>
								</div>
								
								<input type="hidden" name="lat" value="<?php echo $loc_data['latitude']; ?>">
								<input type="hidden" name="long" value="<?php echo $loc_data['longitude']; ?>">
								<button class="btn btn-success" type="submit" style="float: right;">Save</button>
							</form>

						</div> <!-- end card-body-->
					</div> <!-- end card-->
				</div> <!-- end col-->

			</div>
			<!-- end row -->
		</div> <!-- container -->
	</div> <!-- content -->
	
		<div class="col-lg-6" >
		
		<?php 
			if(isset($_GET['id']))
			{ 
				$id = $_GET['id'];
				
				$id_num = $conn->prepare("SELECT * FROM bs_employee WHERE rfid = '$id' AND is_deleted != '1'");
				$id_num->execute();
				$id_num_data = $id_num->fetch();
					
					$name = $id_num_data['e_fname'] . ', ' . $id_num_data['e_mname'] . ' ' . $id_num_data['e_lname'];
				
					if ($id_num_data['image']) {
						$image = WEB_ROOT . 'assets/images/employee/' . $id_num_data['image'];
					} else {
						$image = WEB_ROOT . 'assets/images/employee/noimage.png';
					}
					
					if($errorMessage == 'In successfully.'){
						$bColor = "#77c13a;";
					} else if($errorMessage == 'Out successfully.'){
						$bColor = "#d9534f;";
					} else if($errorMessage == "You're already logged in"){
						$bColor = "#4aa2ee;";
					} else if($errorMessage == "You're already logged out"){
						$bColor = "#4aa2ee;";
					} else {}
		?>
		<div class="col-lg-4	">
			<div class="card">
				<div class="col-sm-12 col-md-12 card-group-row__col">
					<div class="card card-sm card-group-row__card" style="border: solid 5px <?php echo $bColor; ?>">
						<div class="position-relative">
							<div class="card-img-top">
								<img src="<?php echo $image; ?>"
									class="card-img-top card-img-cover"
									alt="">
							</div>
						</div>
						<div class="card-body d-flex">
							<div class="flex">
								<small class="text-muted"><?php echo $today_date4; ?></small>
								<h5 class="card-title m-0"><?php echo $name; ?></h5>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
			}else{}
		?>
	</div>
</div>

<script>
	function getLocation() {
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(savePosition);
		} else {
			alert("Geolocation is not supported by this browser.");
		}
	}

	function savePosition(position) {
		var latitude = position.coords.latitude;
		var longitude = position.coords.longitude;

		// Send the coordinates to a PHP script using AJAX with POST method
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				// Redirect to a new page after saving to the database
				window.location.href = "process.php?action=get_location";
			}
		};
		xhttp.open("POST", "process.php?action=get_location", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("lat=" + latitude + "&long=" + longitude);
	}
</script>