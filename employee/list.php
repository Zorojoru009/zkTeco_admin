<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

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
					<h3>List of Staff</h3>
					<form method="post" action="index.php?view=add" style="float: right;">
						<a href="<?php echo WEB_ROOT; ?>all-calendar/schedule/index.php?id=<?php echo $userId; ?>" class="btn btn-secondary rounded-pill waves-effect waves-light"><i class="fe-calendar"></i> <span></span></a>
						&nbsp;
						<button type="submit" class="btn btn-soft-success waves-effect rounded-pill waves-light" href="index.php?view=add">
							<i class="mdi mdi-plus-thick"></i>
						</button>
					</form>
					<p class="text-muted font-14 mb-3"><br /></p>
					<?php
						if($errorMessage == 'Deleted successfully.')
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
					<table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap" style="width: 100%;">
						<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Contact</th>
							<th>Image</th>
							<th>Action</th>
						</tr>
						</thead>
					
						<tbody>
						<?php
							$sql = $conn->prepare("SELECT * FROM bs_employee WHERE is_deleted != '1' ORDER BY e_fname ASC");
							$sql->execute();
							
							if($sql->rowCount() > 0)
							{
								$ctr = 1;
								while($sql_data = $sql->fetch())
								{
									$name = $sql_data['e_lname'] . ', ' . $sql_data['e_fname'] . ' ' . $sql_data['e_mname'];
									
									if ($sql_data['thumbnail']) {
										$image = WEB_ROOT . 'assets/images/profile-picture/' . $sql_data['thumbnail'];
									} else {
										$image = WEB_ROOT . 'assets/images/profile-picture/noimage.png';
									}
						?>
								<tr>
									<td><?php echo $sql_data['e_id']; ?></td>
									<td><?php echo $name; ?></td>
									<td><?php echo $sql_data['e_contact_o']; ?></td>																				
									<td><img src="<?php echo $image; ?>" alt="image" class="img-fluid avatar-lg rounded" style="object-fit: cover;"/></td>
									<td>
										<a href="<?php echo WEB_ROOT; ?>calendar/schedule/index.php?id=<?php echo $sql_data['e_id']; ?>" class="btn btn-secondary rounded-pill waves-effect waves-light"><i class="fe-calendar"></i> <span></span></a>
										<a href="index.php?view=modify&id=<?php echo $sql_data['uid']; ?>" class="btn btn-soft-info rounded-pill waves-effect waves-light"><i class="mdi mdi-pencil"></i></a>
										&nbsp;
										<a href="process.php?action=delete&id=<?php echo $sql_data['uid']; ?>" class="btn btn-danger rounded-pill waves-effect waves-light <?php echo $disabled; ?>" onClick="return confirmDelete()">
											<span class="btn-label"><i class="mdi mdi-close-thick"></i></span>Delete
										</a>
									</td>
								</tr>
						<?php
								}
							} else {}
						?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div> <!-- end row -->