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

?>
<form class="needs-validation" novalidate method="post" action="process.php?action=modify"  enctype="multipart/form-data" name="form" id="form">
	<div class="content">
		<!-- Start Content-->
		<div class="container-fluid">
			<div class="row">
			
				<div class="col-lg-6">
					<div class="card">
						<div class="card-body">
							<h3>Modify User</h3>
							<!-- <p class="sub-header"><br /></p> -->
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
								else if($errorMessage == 'Modified successfully.')
								{
							?>
								<div class="alert alert-success alert-dismissible fade show" role="alert">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									<i class="mdi mdi-check-all me-2"></i> <strong><?php echo $errorMessage; ?></strong>
								</div>
							<?php
								}
								else if($errorMessage == 'Data already exist! Data entry failed.')
								{
							?>	
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									<i class="mdi mdi-block-helper me-2"></i> <strong><?php echo $errorMessage; ?></strong>
								</div>
							<?php								
								} else {}
							?>
						
							<div class="mb-3">
								<label for="validationCustom01" class="form-label">First name: </label>
								<input type="text" class="form-control" id="validationCustom01" name="fname" placeholder="First name" value="<?php echo $sql_data['firstname']; ?>" autocomplete="off" required />
								<div class="invalid-feedback">
									Please provide a valid first name.
								</div>
							</div>
							<div class="mb-3">
								<label for="validationCustom02" class="form-label">Middle name: </label>
								<input type="text" class="form-control" id="validationCustom02" name="mname" placeholder="Middle name" value="<?php echo $sql_data['middlename']; ?>" autocomplete="off" />
								<div class="invalid-feedback">
									Please provide a valid middle name.
								</div>
							</div>
							<div class="mb-3">
								<label for="validationCustom03" class="form-label">Last name: </label>
								<input type="text" class="form-control" id="validationCustom03" name="lname" placeholder="Last name" value="<?php echo $sql_data['lastname']; ?>" autocomplete="off" required />
								<div class="invalid-feedback">
									Please provide a valid last name.
								</div>
							</div>
							<div class="mb-3">
								<label for="validationCustom04" class="form-label">Contact number: </label>
								<input type="text" class="form-control" id="validationCustom04" name="contactnum" onKeyUp="checkNumber(this);" placeholder="Contact number" value="<?php echo $sql_data['contactno']; ?>" autocomplete="off" required />
								<div class="invalid-feedback">
									Please provide a valid contact number.
								</div>
							</div>
							<div class="mb-3">
								<label for="validationCustom05" class="form-label">Address</label>
								<textarea type="text" class="form-control" id="validationCustom05" name="address" placeholder="Address" required ><?php echo $sql_data['address']; ?></textarea>
								<div class="invalid-feedback">
									Please provide a valid address.
								</div>
							</div>
							<div class="mb-3">
								<label for="validationCustom07" class="form-label">Upload profile picture</label>
								<input type="file" data-plugins="dropify" data-height="300" name="fileImage" />
							</div>

						</div> <!-- end card-body-->
					</div> <!-- end card-->
				</div> <!-- end col-->

				<div class="col-lg-6">
					<div class="row">

						<div class="col-lg-12">
							<div class="card">
								<div class="card-body">
									<h3>User Access</h3>
									<!-- <p class="sub-header"><br /></p> -->
									<div class="mb-3">
									<?php
										if($sql_data['is_user'] == 1){ $is_user = 'selected'; }else{ $is_user = ''; }
										if($sql_data['is_user_add'] == 1){ $is_user_add = 'selected'; }else{ $is_user_add = ''; }
										if($sql_data['is_user_edit'] == 1){ $is_user_edit = 'selected'; }else{ $is_user_edit = ''; }
										if($sql_data['is_user_delete'] == 1){ $is_user_delete = 'selected'; }else{ $is_user_delete = ''; }
									?>
										<label for="validationCustom08" class="form-label"><b style="color:#00b14f; margin-left: 55px;">Modules</b><b style="color:#00b14f; margin-left: 126px;">Allowed Access</b></label>
										<select multiple="multiple" class="multi-select" id="my_multi_select1" name="my_multi_select1[]" data-plugin="multiselect">
											<option value="is_user" <?php echo $is_user; ?>>1. User</option>
												<option value="is_user_add" <?php echo $is_user_add; ?>>&nbsp;&nbsp;&nbsp;1a. Add User</option>
												<option value="is_user_edit" <?php echo $is_user_edit; ?>>&nbsp;&nbsp;&nbsp;1b. Edit User</option>
												<option value="is_user_delete" <?php echo $is_user_delete; ?>>&nbsp;&nbsp;&nbsp;1c. Delete User</option>
										</select>										
									</div>
									
									<input type="hidden" name="id" value="<?php echo $id; ?>">
									<a class="btn btn-outline-dark" style="float: left;" href="index.php">Cancel</a>
									<button class="btn btn-success" type="submit" style="float: right;">Save</button>

								</div> <!-- end card-body-->
							</div> <!-- end card-->
						</div> <!-- end col-->

						<div class="col-lg-12">
							<div class="card">
								<div class="card-body">
								<?php
									if ($sql_data['image']) {
										$image = WEB_ROOT . 'assets/images/user/' . $sql_data['image'];
									} else {
										$image = WEB_ROOT . 'assets/images/user/noimage.png';
									}	
								?>
									<img src="<?php echo $image; ?>" alt="image" class="img-fluid rounded" style="height: 300%; object-fit: scale-down;" />
								</div>
							</div>
						</div>

					</div>
				</div>

			</div>
			<!-- end row -->
		</div> <!-- container -->
	</div> <!-- content -->
</form>