<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

?>
<form class="needs-validation" novalidate method="post" action="process.php?action=add"  enctype="multipart/form-data" name="form" id="form">
	<div class="content">
		<!-- Start Content-->
		<div class="container-fluid">
			<div class="row">
			
				<div class="col-lg-6">
					<div class="card">
						<div class="card-body">
							<h3>Add Staff</h3>
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
									<label for="id_num" class="form-label">ID number: </label>
									<input type="text" class="form-control" id="id_num" name="id_num" placeholder="ID number" autocomplete="off" required />
									<div class="invalid-feedback">
										Please provide a valid ID number.
									</div>
								</div>
								<div class="mb-3">
									<label for="validationCustom01" class="form-label">First name: </label>
									<input type="text" class="form-control" id="validationCustom01" name="e_fname" placeholder="First name" autocomplete="off" required />
									<div class="invalid-feedback">
										Please provide a valid first name.
									</div>
								</div>
								<div class="mb-3">
									<label for="validationCustom02" class="form-label">Middle name: </label>
									<input type="text" class="form-control" id="validationCustom02" name="e_mname" placeholder="Middle name" autocomplete="off" required />
									<div class="invalid-feedback">
										Please provide a valid middle name.
									</div>
								</div>
								<div class="mb-3">
									<label for="validationCustom03" class="form-label">Last name: </label>
									<input type="text" class="form-control" id="validationCustom03" name="e_lname" placeholder="Last name" autocomplete="off" required />
									<div class="invalid-feedback">
										Please provide a valid last name.
									</div>
								</div>
								<div class="mb-3">
									<label for="validationCustom04" class="form-label">Suffix: </label>
									<input type="text" class="form-control" id="validationCustom04" name="suffix" placeholder="Suffix" autocomplete="off" required />
									<div class="invalid-feedback">
										Please provide a valid suffix.
									</div>
								</div>
								<div class="mb-3">
									<label class="form-label">Date of Birth: </label>
									<input type="text" id="basic-datepicker" class="form-control" name="dob" placeholder="Date of Birth">
									<div class="invalid-feedback">
										Please provide a valid date of birth.
									</div>
								</div>
								<div class="mb-3">
									<label for="gender" class="form-label">Gender: </label>
									<select class="form-select" name="gender" data-width="100%">
										<option value="Male">Male</option>
										<option value="Female">Female</option>
									</select>
								</div>
								<!--
								<div class="mb-3">
									<label for="rank" class="form-label">Rank: </label>
									<select class="form-select" name="rank" data-width="100%">
										<?php
											$sql = $conn->prepare("SELECT * FROM bs_ranking WHERE is_deleted != '1'");
											$sql->execute();
											while ($sql_data = $sql->fetch())
											{
										?>
												<option value="<?php echo $sql_data['r_id']; ?>"><?php echo $sql_data['rank']; ?></option>
										<?php
											}
										?>
									</select>
								</div>

								<div class="mb-3">
									<label for="e_pos" class="form-label">Position: </label>
									<select class="form-select" name="e_pos" data-width="100%">
										<?php
											$sql1 = $conn->prepare("SELECT * FROM bs_position WHERE is_deleted != '1'");
											$sql1->execute();
												while ($sql1_data = $sql1->fetch())
												{
										?>
												<option value="<?php echo $sql1_data['p_id']; ?>"><?php echo $sql1_data['p_name']; ?></option>
										<?php
												}
										?>
									</select>
								</div>
								-->
								<div class="mb-3">
									<label for="validationCustom05" class="form-label">Contact number 1: </label>
									<input type="text" class="form-control" id="validationCustom05" name="e_contact_o" placeholder="Contact number 1" onKeyUp="checkNumber(this);" autocomplete="off" required />
									<div class="invalid-feedback">
										Please provide a valid contact number 1.
									</div>
								</div>
								<div class="mb-3">
									<label for="validationCustom06" class="form-label">Contact number 2: </label>
									<input type="text" class="form-control" id="validationCustom06" name="e_contact_t" placeholder="Contact number 2" onKeyUp="checkNumber(this);" autocomplete="off" required />
									<div class="invalid-feedback">
										Please provide a valid contact number 2.
									</div>
								</div>
								<div class="mb-3">
									<label for="validationCustom07" class="form-label">Primary Address: </label>
									<textarea type="text" class="form-control" id="validationCustom07" name="e_paddress" placeholder="Primary Address" required ></textarea>
									<div class="invalid-feedback">
										Please provide a valid primary address.
									</div>
								</div>
								<div class="mb-3">
									<label for="validationCustom08" class="form-label">Secondary Address: </label>
									<textarea type="text" class="form-control" id="validationCustom08" name="e_saddress" placeholder="Secondary Address" required ></textarea>
									<div class="invalid-feedback">
										Please provide a valid secondary address.
									</div>
								</div>
							

						</div> <!-- end card-body-->
					</div> <!-- end card-->
				</div> <!-- end col-->

				<div class="col-lg-6">
					<div class="card">
						<div class="card-body">
							<h3>&nbsp;</h3>
								<div class="mb-3">
									<label for="tos" class="form-label">Type of salary: </label>
									<select class="form-select" name="tos" data-width="100%">
										<option value="0">Daily</option>
										<option value="1">Fixed</option>
									</select>
								</div>
								<div class="mb-3">
									<label for="salary" class="form-label">Salary: </label>
									<input type="text" class="form-control" id="salary" name="salary" placeholder="Salary" onKeyUp="checkNumber(this);" autocomplete="off" required />
									<div class="invalid-feedback">
										Please provide a valid salary.
									</div>
								</div>
								<div class="mb-3">
									<label for="num_hrs" class="form-label">Number of hours: </label>
									<input type="text" class="form-control" id="num_hrs" name="num_hrs" placeholder="Number of hours" onKeyUp="checkNumber(this);" autocomplete="off" required />
									<div class="invalid-feedback">
										Please provide a valid number of hours.
									</div>
								</div>
								<div class="mb-3">
									<label for="sss_num" class="form-label">SSS number: </label>
									<input type="text" class="form-control" id="sss_num" name="sss_num" placeholder="SSS number" onKeyUp="checkNumber(this);" autocomplete="off" required />
									<div class="invalid-feedback">
										Please provide a valid SSS number.
									</div>
								</div>
								<div class="mb-3">
									<label for="tin_num" class="form-label">TIN number: </label>
									<input type="text" class="form-control" id="tin_num" name="tin_num" placeholder="TIN number" onKeyUp="checkNumber(this);" autocomplete="off" required />
									<div class="invalid-feedback">
										Please provide a valid TIN number.
									</div>
								</div>
								<div class="mb-3">
									<label for="pag_num" class="form-label">Pag-ibig number: </label>
									<input type="text" class="form-control" id="pag_num" name="pag_num" placeholder="Pag-ibig number" onKeyUp="checkNumber(this);" autocomplete="off" required />
									<div class="invalid-feedback">
										Please provide a valid Pag-ibig number.
									</div>
								</div>
								<div class="mb-3">
									<label for="phil_num" class="form-label">Phil health number: </label>
									<input type="text" class="form-control" id="phil_num" name="phil_num" placeholder="Phil health number" onKeyUp="checkNumber(this);" autocomplete="off" required />
									<div class="invalid-feedback">
										Please provide a valid Phil health number.
									</div>
								</div>
								<div class="mb-3">
									<label for="validationCustom09" class="form-label">Upload profile picture</label>
									<input type="file" data-plugins="dropify" data-height="213" name="fileImage" />
								</div>
								<div class="mb-3">
									<label for="rfid" class="form-label">RFID: </label>
									<input type="password" class="form-control" id="rfid" name="rfid" placeholder="Tap your card" onKeyUp="checkNumber(this);" autocomplete="off" required />
									<div class="invalid-feedback">
										Please provide a valid RFID.
									</div>
								</div>
								<a class="btn btn-outline-dark" style="float: left;" href="index.php">Cancel</a>
								<button class="btn btn-success" type="submit" style="float: right;">Save</button>
							

						</div> <!-- end card-body-->
					</div> <!-- end card-->
				</div> <!-- end col-->

			</div>
			<!-- end row -->
		</div> <!-- container -->
	</div> <!-- content -->
</form>