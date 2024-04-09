<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}

	$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

	$id = $_GET['id'];

	$sql = $conn->prepare("SELECT * FROM bs_user WHERE uid = '$id' AND is_deleted != '1'");
	$sql->execute();
	$sql_data = $sql->fetch();
	
	$branch = $sql_data['branch'];
	
	if($branch != '0'){
		$brh7 = $conn->prepare("SELECT * FROM tbl_branch WHERE b_id = '$branch' AND is_deleted != '1'");
		$brh7->execute();
		$brh7_data = $brh7->fetch();
		
		$bId7 = $brh7_data['b_id'];
		$bName7 = $brh7_data['b_name'];
	} else {
		$bId7 = '0';
		$bName7 = 'Select Branch';
	}

?>
	<div class="container-fluid page__container page-section pb-0">
		<h1 class="h2 mb-0">Edit Account</h1>

		<ol class="breadcrumb p-0 m-0">
			<li class="breadcrumb-item"><a href="<?php echo WEB_ROOT; ?>">Account</a></li>

			<li class="breadcrumb-item active">

				Edit Account

			</li>

		</ol>

	</div>
	
	<style>
		input[type=radio] {
			width: 10%;
			height: 30px;
		}
	</style>
	
	<form class="form-horizontal" method="post" action="process.php?action=modify_account" enctype="multipart/form-data" name="form" id="form">
	<div class="container-fluid page__container page-section">

		<div class="row mb-32pt">
			<div class="col-lg-8">
				<div class="flex"
					 style="max-width: 100%">
					<?php
						if($errorMessage == 'Modified successfully')
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
					?>
					
						<div class="form-group">
							<label class="form-label"
								   for="exampleInputuname">ID Number:</label>
							<input type="text"
								   class="form-control"
								   id="exampleInputuname" name="idnum"
								   placeholder="Enter your ID number .." value="<?php echo $sql_data['id_num']; ?>" autocomplete=off readonly >
						</div>
						<div class="form-group">
							<label class="form-label"
								   for="exampleInputuname">First Name:</label>
							<input type="text"
								   class="form-control"
								   id="exampleInputuname" name="fname"
								   placeholder="Enter your First Name .." value="<?php echo $sql_data['firstname']; ?>" value="<?php echo $sql_data['firstname']; ?>" autocomplete=off required >
						</div>
						<div class="form-group">
							<label class="form-label"
								   for="exampleInputuname">Middle Name:</label>
							<input type="text"
								   class="form-control"
								   id="exampleInputuname" name="mname"
								   placeholder="Enter your Middle Name .." value="<?php echo $sql_data['middlename']; ?>" autocomplete=off >
						</div>
						<div class="form-group">
							<label class="form-label"
								   for="exampleInputuname">Last Name:</label>
							<input type="text"
								   class="form-control"
								   id="exampleInputuname" name="lname"
								   placeholder="Enter your Last Name .." value="<?php echo $sql_data['lastname']; ?>" autocomplete=off required >
						</div>
						<div class="form-group">
							<label class="form-label"
								   for="exampleInputuname">Contact Number:</label>
							<input type="text"
								   class="form-control"
								   id="exampleInputuname" name="contactno"
								   placeholder="Enter your Contact Number .." value="<?php echo $sql_data['contactno']; ?>" autocomplete=off required >
						</div>
						<div class="form-group">
							<label class="form-label"
								   for="exampleInputuname">Permanent Address:</label>
							<textarea type="text"
								   class="form-control"
								   id="exampleInputuname" name="address"
								   placeholder="Enter your Permanent Address .." autocomplete=off required ><?php echo $sql_data['address']; ?></textarea>
						</div>
						<div class="form-group">
							<label class="form-label"
								   for="exampleInputuname">Current Address:</label>
							<textarea type="text"
								   class="form-control"
								   id="exampleInputuname" name="caddress"
								   placeholder="Enter your Current Address .." autocomplete=off required ><?php echo $sql_data['caddress']; ?></textarea>
						</div>
						<div class="form-group">
							<div class="custom-file">
								<input type="file"
									   id="file"
									   class="custom-file-input" name="fileImage">
								<label for="file"
									   class="custom-file-label">Choose Profile Picture</label>
							</div>
						</div>
						
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<a class="btn btn-outline-dark" href="<?php echo WEB_ROOT; ?>index.php">Cancel</a>
						<button type="submit" class="btn btn-success" style="float: right;">Save</button>
					
				</div>
			</div>
			<div class="col-lg-4">
				<div class="flex"
					 style="max-width: 100%">
					<div class="page-separator">
						<div class="page-separator__text">Image</div>
					</div>
					<?php
						if ($sql_data['image']) {
							$image = WEB_ROOT . 'assets/images/user/' . $sql_data['image'];
						} else {
							$image = WEB_ROOT . 'assets/images/user/noimagelarge.png';
						}
					?>
					<img src="<?php echo $image; ?>" style="width: 100%;"/>
					
					<br /><br />
					<?php
						if($errorMessage == 'Modified successfully.')
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
						else if($errorMessage == 'Incorrect Old Password.')
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
						}else if($errorMessage == 'Your password and confirmation must match.')
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
					?>
					<!-- Password -->
					<div class="page-separator">
						<div class="page-separator__text">Change Password</div>
					</div>
					<!--
					<div class="form-group">
						<label class="form-label">Date</label>
						<input id="flatpickrSample01"
							   type="hidden"
							   class="form-control flatpickr-input"
							   data-toggle="flatpickr" name="satdate"
							   value="<?php echo date('Y-m-d', strtotime('last saturday', strtotime('next saturday'))); ?>">
					</div>
					-->
					
					<div class="col-lg-12 d-flex align-items-center" style="margin-top: -15px;">
						<input type="radio" onclick="passshow1();" name="changepass" id="optionsRadios1" value="passno" checked="" />
						<label class="form-label" style="vertical-align: top; font-size: 15px; margin-top: 8px;">&nbsp;NO</label>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" onclick="passshow2();" name="changepass" id="optionsRadios2" value="passyes" />
						<label class="form-label" style="vertical-align: top; font-size: 15px; margin-top: 8px;">&nbsp;YES</label>
					</div>
						   
					<div id="passdiv" style="display:none" >
						<div class="row mb-32pt">
							<div class="col-lg-12 align-items-center">
								<div class="form-group">
									<label class="form-label"
										   for="exampleInputuname">Old Password:</label>
									<input type="password"
										   class="form-control"
										   id="exampleInputuname" name="oldpass"
										   placeholder="Enter your old password .." autocomplete=off />
								</div>
							</div>
							<div class="col-lg-12 align-items-center">
								<div class="form-group">
									<label class="form-label"
										   for="exampleInputuname">New Password:</label>
									<input type="password"
										   class="form-control"
										   id="exampleInputuname" name="newpass"
										   placeholder="Enter your new password .." autocomplete=off />
								</div>
							</div>
							<div class="col-lg-12 align-items-center">
								<div class="form-group">
									<label class="form-label"
										   for="exampleInputuname">Confirm New Password:</label>
									<input type="password"
										   class="form-control"
										   id="exampleInputuname" name="cnewpass"
										   placeholder="Confirm new password .." autocomplete=off />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</form>
	
<script type="text/javascript">
	function passshow1(){
	  document.getElementById('passdiv').style.display ='none';
	}
	function passshow2(){
	  document.getElementById('passdiv').style.display = 'block';
	}
</script>