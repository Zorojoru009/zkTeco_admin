<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}

	$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

	if(isset($_POST['edate']) && isset($_POST['emp']))
	{
		$edate1 = $_POST['edate'];
		$emp1 = $_POST['emp'];
		
		if($emp1 != 0)
		{
			$sql1 = $conn->prepare("SELECT * FROM bs_employee WHERE id_num = '$emp1' AND is_deleted != '1'");
			$sql1->execute();
			$sql1_data = $sql1->fetch();
				$emp1Id = $sql1_data['id_num'];
				$emp1Name = $sql1_data['e_lname'] . ', ' . $sql1_data['e_fname'] . ' ' . $sql1_data['e_mname'];
		} else {
				$emp1Id = 0;
				$emp1Name = "All Employee";
		}
	} else {
		$edate1 = $today_date2;
			$emp1Id = 0;
			$emp1Name = "All Employee";
	}

?>
<style rel="stylesheet">
td
{   
	vertical-align: super;
}
</style>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h3>Employee Log</h3>
					
					<form class="needs-validation" novalidate method="post" action="index.php?view=employee-log" enctype="multipart/form-data" name="form" id="form">
						<div class="row">
							<div class="col-lg-3">
								<div class="mb-3">
									<label class="form-label">Date</label>
									<input type="text" id="basic-datepicker" class="form-control" name="edate" value="<?php echo $edate1; ?>">
								</div>
							</div> <!-- end col -->

							<div class="col-lg-3">
								<div class="mb-3">
									<label for="simpleinput" class="form-label">Employee</label>
									<select class="form-select" name="emp" data-width="100%">
										<option value="<?php echo $emp1Id; ?>"><?php echo $emp1Name; ?></option>
										<?php
											$emp = $conn->prepare("SELECT * FROM bs_employee WHERE id_num != '$emp1Id' AND is_deleted != '1'");
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
		if(isset($_POST['edate']) && isset($_POST['emp']))
		{
			$edate = $_POST['edate'];
			$emp = $_POST['emp'];

			if($emp != 0)
			{
				$empQ = "AND id_num = '$emp'";
			} else {
				$empQ = "";
			}

			$sql = $conn->prepare("SELECT * FROM bs_employee WHERE is_deleted != '1' $empQ");
			$sql->execute();
	?>
		<div class="col-12">
			<div class="card">
				<div class="card-body">
				<?php
					if($sql->rowCount() > 0)
					{
						$ctr = 1;
						while($sql_data = $sql->fetch())
						{
							$idNum = $sql_data['id_num'];
				?>
							<div class="responsive-table-plugin">
								<div class="table-rep-plugin">
									<div class="table-responsive" data-pattern="priority-columns">
										<table id="tech-companies-<?php echo $ctr++; ?>" class="table table-striped">
											<thead>
											<tr>
												<th><?php echo $sql_data['e_lname']; ?>, <?php echo $sql_data['e_fname']; ?> <?php echo $sql_data['e_mname']; ?></th>
												<th data-priority="1">Date | Time</th>
												<th data-priority="3">Status</th>
											</tr>
											</thead>
											
											<tbody>
											<?php
												$att = $conn->prepare("SELECT * FROM tbl_attendance WHERE id_num = '$idNum' AND a_date = '$edate' AND is_deleted != '1' ORDER BY a_datetime ASC");
												$att->execute();

												if($att->rowCount() > 0)
												{
													while($att_data = $att->fetch())
													{
														$aDateTime = date("M d, Y | h:i a",strtotime($att_data['a_datetime']));

														if($att_data['is_log'] != 1)
														{
															$isLog = "Logged In";
															$bgColor = "#5ac172";
														} else {
															$isLog = "Logged Out";
															$bgColor = "#ec6761";
														}
											?>
														<tr>
															<th></th>
															<td><?php echo $aDateTime; ?></td>
															<td style="color: <?php echo $bgColor; ?>;"><?php echo $isLog; ?></td>
														</tr>
											<?php
													}
												} else {}
											?>
											</tbody>
										</table>
									</div> <!-- end .table-responsive -->

								</div> <!-- end .table-rep-plugin-->
							</div> <!-- end .responsive-table-plugin-->
				<?php

						}
					} else {}
				?>
						</div> <!-- end .table-rep-plugin-->
					</div> <!-- end .responsive-table-plugin-->
				</div>
			</div> <!-- end card -->
		</div>
	<?php
		} else {}
	?>
	</div> <!-- end row -->