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

	$depId = $sql_data['dep_id'];
	$batch = $sql_data['batch'];
	
	$dep7 = $conn->prepare("SELECT * FROM tbl_department WHERE dep_id = '$depId' AND is_deleted != '1'");
	$dep7->execute();
	if($dep7->rowCount() > 0)
	{
		$dep7_data = $dep7->fetch();
		$depId7 = $dep7_data['dep_id'];
		$depName7 = $dep7_data['dep_name'];
	} else {
		$depId7 = 0;
		$depName7 = 'Choose Department';
	}
	
	$bth7 = $conn->prepare("SELECT * FROM tbl_batch WHERE b_id = '$batch' AND is_deleted != '1'");
	$bth7->execute();
	if($bth7->rowCount() > 0)
	{
		$bth7_data = $bth7->fetch();
		$batch7 = $bth7_data['b_id'];
		$batchName7 = $bth7_data['year_from'] . ' - ' . $bth7_data['year_to'];
	} else {
		$batch7 = 0;
		$batchName7 = 'Choose Batch';
	}

?>

	<div class="row">
		<div class="col-md-8">
			<div class="white-box">
				<h3 class="box-title m-b-0">Student</h3>
				<p class="text-muted m-b-30 font-13"> Modify Student </p>
					<?php
						if($errorMessage == 'Modified successfully')
						{
					?>
							<div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 
								<b><?php echo $errorMessage; ?></b>
							</div>
					<?php
						}
						else if($errorMessage == 'Student already exist! Data entry failed.')
						{
					?>							
							<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 
								<b><?php echo $errorMessage; ?></b>
							</div>
					<?php								
						}else{}
					?>
							
				<form class="form-horizontal" method="post" action="process.php?action=modify" enctype="multipart/form-data" name="form" id="form">
					<div class="form-group">
						<label for="exampleInputuname" class="col-sm-3 control-label">Batch</label>
						<div class="col-sm-9">
							<div class="input-group">
								<div class="input-group-addon"><i class="ti-layers"></i></div>
								<select class="form-control select2" name="batch">
									<option value="<?php echo $batch7; ?>"><?php echo $batchName7; ?></option>
									<?php
										$bth = $conn->prepare("SELECT * FROM tbl_batch WHERE is_deleted != '1'");
										$bth->execute();
										if($bth->rowCount() > 0)
										{
											while($bth_data = $bth->fetch())
											{
									?>
											<option value="<?php echo $bth_data['b_id']; ?>"><?php echo $bth_data['year_from']; ?> - <?php echo $bth_data['year_to']; ?></option>
									<?php
											}
										} else {}
										
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputuname" class="col-sm-3 control-label">Department</label>
						<div class="col-sm-9">
							<div class="input-group">
								<div class="input-group-addon"><i class="ti-layers"></i></div>
								<select class="form-control select2" name="department">
									<option value="<?php echo $depId7; ?>"><?php echo $depName7; ?></option>
										<?php
											$dep = $conn->prepare("SELECT * FROM tbl_department WHERE dep_parent_id = '0' AND is_deleted != '1' ORDER BY dep_name");
											$dep->execute();
											while($dep_data = $dep->fetch())
											{
												$depName = $dep_data['dep_name'];
												$depId = $dep_data['dep_id'];
										?>
												<optgroup label="<?php echo $depName; ?>">
												<?php
													// Get Department											
													$dep7 = $conn->prepare("SELECT * FROM tbl_department WHERE dep_parent_id = '$depId' AND is_deleted != '1' ORDER BY dep_name");
													$dep7->execute();
													if($dep7->rowCount() > 0)
													{
														while($dep7_data = $dep7->fetch())
														{
															$depName7 = $dep7_data['dep_name'];
												?>
															<option value="<?php echo $dep7_data['dep_id']; ?>"><?php echo $depName7; ?></option>
												<?php
														} // End While
													}else{}
												?>
												</optgroup>
										<?php
											} // End While
										?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputuname" class="col-sm-3 control-label">First Name</label>
						<div class="col-sm-9">
							<div class="input-group">
								<div class="input-group-addon"><i class="icon-arrow-right"></i></div>
								<input type="text" class="form-control" id="exampleInputuname" placeholder="First Name" name="fname" value="<?php echo $sql_data['firstname']; ?>" autocomplete=off required /> </div>
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputuname" class="col-sm-3 control-label">Middle Name</label>
						<div class="col-sm-9">
							<div class="input-group">
								<div class="input-group-addon"><i class="icon-arrow-right"></i></div>
								<input type="text" class="form-control" id="exampleInputuname" placeholder="Middle Name" name="mname" value="<?php echo $sql_data['middlename']; ?>" autocomplete=off required /> </div>
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputuname" class="col-sm-3 control-label">Last Name</label>
						<div class="col-sm-9">
							<div class="input-group">
								<div class="input-group-addon"><i class="icon-arrow-right"></i></div>
								<input type="text" class="form-control" id="exampleInputuname" placeholder="Last Name" name="lname" value="<?php echo $sql_data['lastname']; ?>" autocomplete=off required /> </div>
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputuname" class="col-sm-3 control-label">ID Number</label>
						<div class="col-sm-9">
							<div class="input-group">
								<div class="input-group-addon"><i class="icon-arrow-right"></i></div>
								<input type="text" class="form-control" id="exampleInputuname" placeholder="ID Number" name="idnum" value="<?php echo $sql_data['id_num']; ?>" autocomplete=off required /> </div>
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputuname" class="col-sm-3 control-label">Password</label>
						<div class="col-sm-9">
							<div class="input-group">
								<div class="input-group-addon"><i class="icon-arrow-right"></i></div>
								<input type="password" class="form-control" id="exampleInputuname" placeholder="Password" name="password" value="<?php echo $sql_data['pass_text']; ?>" autocomplete=off required /> </div>
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputuname" class="col-sm-3 control-label">Quote</label>
						<div class="col-sm-9">
							<div class="input-group">
								<div class="input-group-addon"><i class="icon-arrow-right"></i></div>
								<textarea type="text" class="form-control" id="exampleInputuname" placeholder="Quote" name="quote" autocomplete=off required ><?php echo $sql_data['quote']; ?></textarea> </div>
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputuname" class="col-sm-3 control-label">Image Upload</label>
						<div class="col-sm-9">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-image"></i></div>
								<input class="input-file uniform_on" name="fileImage" id="fileInput" type="file" />
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputuname" class="col-sm-3 control-label">Hobbies</label>
						<div class="col-sm-9">
							<div class="input-group">
								<div class="input-group-addon"><i class="icon-arrow-right"></i></div>
								<textarea type="text" class="form-control" id="exampleInputuname" placeholder="Hobbies" name="hobby" autocomplete=off required ><?php echo $sql_data['hobby']; ?></textarea> </div>
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputuname" class="col-sm-3 control-label">Hobby Video Upload</label>
						<div class="col-sm-9">
							<div class="input-group">
								<div class="input-group-addon"><i class="fa fa-image"></i></div>
								<input class="input-file uniform_on" name="my_video" id="fileInput" type="file" />
							</div>
						</div>
					</div>
					<div class="form-group m-b-0">
						<div class="col-sm-offset-3 col-sm-9">
							<input name="id" type="hidden" value="<?php echo $id; ?>">
							<button type="submit" class="btn btn-success waves-effect waves-light m-r-10" onClick="return confirmSubmit()">Submit</button>
							<button type="button" class="btn btn-inverse waves-effect waves-light" onClick="window.location.href='index.php';">Cancel</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="row">
				<?php
					$sql77 = $conn->prepare("SELECT * FROM bs_user WHERE uid = '$id' AND is_deleted != '1'");
					$sql77->execute();
					
					if($sql77->rowCount() > 0)
					{
						while($sql77_data = $sql77->fetch())
						{
							if ($sql77_data['thumbnail']) {
								$image = WEB_ROOT . 'images/user/' . $sql77_data['thumbnail'];
							} else {
								$image = WEB_ROOT . 'images/user/noimage.png';
							}
							
							if($sql77_data['is_pp_approved'] == 1){
								$color7 = 'border: solid 3px #2ecc71;';
							} else if($sql77_data['is_pp_approved'] == 2){
								$color7 = 'border: solid 3px #e74a25;';
							} else {
								$color7 = 'border: solid 3px #0283cc;';
							}
				?>
					<div class="col-md-12">
						<div class="white-box"  style="<?php echo $color7; ?>">
							<?php
								if($errorMessage == 'Approve successfully.')
								{
							?>
									<div class="alert alert-success alert-dismissable">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 
										<b><?php echo $errorMessage; ?></b>
									</div>
							<?php
								}
								else if($errorMessage == 'Disapprove successfully.')
								{
							?>							
									<div class="alert alert-danger alert-dismissable">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 
										<b><?php echo $errorMessage; ?></b>
									</div>
							<?php								
								}else{}
							?>
							<?php 
							if($sql77_data['is_pp_approved'] == 1){
							?>
								<center><a href="process.php?action=ppdisapprove&id=<?php echo $id; ?>" class="btn btn-danger btn-sm waves-effect waves-light"><i class="fa fa-times m-l-5"></i> <span>Disapprove</span></a></center>
							<?php
							} else if($sql77_data['is_pp_approved'] == 2){
							?>
								<center><a href="process.php?action=ppapprove&id=<?php echo $id; ?>" class="btn btn-success btn-sm waves-effect waves-light"><i class="fa fa-check m-l-5"></i> <span>Approve</span></a></center>
							<?php
							} else {
							?>
							<a href="process.php?action=ppapprove&id=<?php echo $id; ?>" class="btn btn-success btn-sm waves-effect waves-light"><i class="fa fa-check m-l-5"></i> <span>Approve</span></a>
							<a href="process.php?action=ppdisapprove&id=<?php echo $id; ?>" class="btn btn-danger btn-sm waves-effect waves-light" style="float: right;"><i class="fa fa-times m-l-5"></i> <span>Disapprove</span></a>
							<?php
							}
							?>
							<br /><br />
							<img src="<?php echo $image; ?>" style="width: 300px;"/>
						</div>
					</div>
				<?php
						}
					} else {}
				?>
			</div>
		</div>
		
		<?php
			$sql7 = $conn->prepare("SELECT * FROM tbl_video WHERE user_uid = '$id' AND is_deleted != '1'");
			$sql7->execute();
			
			if($sql7->rowCount() > 0)
			{
				while($sql7_data = $sql7->fetch())
				{
					if ($sql7_data['vid_url']) {
						$video7 = '<video width="300" controls><source src="' . WEB_ROOT . 'videos/' . $sql7_data['vid_url'] . '" type="video/mp4" style="width: 300px;"> </video>';
						//$video = WEB_ROOT . 'videos/' . $sql7_data['vid_url'];
					} else {
						$video7 = '<img src="' . WEB_ROOT . 'videos/approvevid.png" style="width: 300px;"/>';
						//$video = WEB_ROOT . 'videos/novideo.png';
					}
					
					if($sql7_data['is_approved'] == 1){
						$color = 'border: solid 3px #2ecc71;';
					} else if($sql7_data['is_approved'] == 2){
						$color = 'border: solid 3px #e74a25;';
					} else {
						$color = 'border: solid 3px #0283cc;';
					}
		?>
		<div class="col-md-4">
			<div class="row">
				
					<div class="col-md-12">
						<div class="white-box" style="<?php echo $color; ?>">
							<?php
								if($errorMessage == 'Approve successfully')
								{
							?>
									<div class="alert alert-success alert-dismissable">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 
										<b><?php echo $errorMessage; ?></b>
									</div>
							<?php
								}
								else if($errorMessage == 'Disapprove successfully')
								{
							?>							
									<div class="alert alert-danger alert-dismissable">
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 
										<b><?php echo $errorMessage; ?></b>
									</div>
							<?php								
								}else{}
							?>
							<?php 
							if($sql7_data['is_approved'] == 1){
							?>
								<center><a href="process.php?action=disapprove&id=<?php echo $id; ?>&vid=<?php echo $sql7_data['vid_id']; ?>" class="btn btn-danger btn-sm waves-effect waves-light"><i class="fa fa-times m-l-5"></i> <span>Disapprove</span></a></center>
							<?php
							} else if($sql7_data['is_approved'] == 2){
							?>
								<center><a href="process.php?action=approve&id=<?php echo $id; ?>&vid=<?php echo $sql7_data['vid_id']; ?>" class="btn btn-success btn-sm waves-effect waves-light"><i class="fa fa-check m-l-5"></i> <span>Approve</span></a></center>
							<?php
							} else {
							?>
							<a href="process.php?action=approve&id=<?php echo $id; ?>&vid=<?php echo $sql7_data['vid_id']; ?>" class="btn btn-success btn-sm waves-effect waves-light"><i class="fa fa-check m-l-5"></i> <span>Approve</span></a>
							<a href="process.php?action=disapprove&id=<?php echo $id; ?>&vid=<?php echo $sql7_data['vid_id']; ?>" class="btn btn-danger btn-sm waves-effect waves-light" style="float: right;"><i class="fa fa-times m-l-5"></i> <span>Disapprove</span></a>
							<?php
							}
							?>
							<br /><br />
							<?php echo $video7; ?>
						</div>
					</div>
				
			</div>
		</div>
		<?php
				}
			} else {}
		?>
	</div>