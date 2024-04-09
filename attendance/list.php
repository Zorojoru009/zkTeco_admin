<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

$sql = $conn->prepare("SELECT * FROM bs_employee WHERE is_deleted != '1'");
$sql->execute();

?>
	<div class="row">
		<div class="col-sm-12">
			<div class="white-box">
				<h3 class="box-title m-b-0">Students 
					<form method="post" action="index.php?view=add">
						&nbsp; <input type="submit" name="submit" value="Add New" class="btn btn-success pull-right m-t-10 font10">
					<form>					
				</h3>
				<p class="text-muted m-b-30">Display list of Students</p>
					<?php
						if($errorMessage == 'Deleted successfully')
						{
					?>
							<div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 
								<b><?php echo $errorMessage; ?></b>
							</div>
					<?php
						}else if($errorMessage == 'Department already exist! Data entry failed.')
						{
					?>
							<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 
								<b><?php echo $errorMessage; ?></b>
							</div>
					<?php
						}else if($errorMessage == 'Added successfully')
						{
					?>
							<div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> 
								<b><?php echo $errorMessage; ?></b>
							</div>
					<?php
						}else{}
					?>
				<div class="table-responsive">				
					<table id="myTable" class="table table-striped">
						<thead>
							<tr>
								<th>ID Number</th>
								<th>Student Name</th>
								<th>Image</th>
								<th>Action</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>ID Number</th>
								<th>Student Name</th>
								<th>Image</th>
								<th>Action</th>
							</tr>
						</tfoot>
						<tbody>
							
							<?php
								if($sql->rowCount() > 0)
								{
									while($sql_data = $sql->fetch())
									{
										if ($sql_data['s_thumbnail']) {
											$image = WEB_ROOT . 'images/employee/' . $sql_data['s_thumbnail'];
										} else {
											$image = WEB_ROOT . 'images/employee/noimage.png';
										}	
										
										$name = $sql_data['e_lname'] . ', ' . $sql_data['e_fname'] . ' ' . $sql_data['e_mname'];
										
							?>
										<tr>
											<td><?php echo $sql_data['id_num']; ?></td>
											<td><?php echo $name; ?></td>
											<td><img src="<?php echo $image; ?>" style="width: 80px;" /></td>
											<td>
												<a href="index.php?view=modify&id=<?php echo $sql_data['uid']; ?>" class="btn btn-info waves-effect waves-light"><i class="fa fa-edit m-l-5"></i> <span>Edit</span></a>
												&nbsp;
												<a href="process.php?action=delete&id=<?php echo $sql_data['uid']; ?>" class="btn btn-danger waves-effect waves-light" onClick="return confirmDelete()"><i class="fa fa-trash m-l-5"></i> <span>Delete</span></a>
											</td>
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