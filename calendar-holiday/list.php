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
					<h3>List of Holiday</h3>
					<!-- <form method="post" action="index.php?view=add">
						<button type="submit" class="btn btn-soft-success waves-effect rounded-pill waves-light" style="float: right;" href="index.php?view=add">
							<i class="mdi mdi-plus-thick"></i>
						</button>
					</form> -->
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
							<th>Date</th>
							<th>Action</th>
						</tr>
						</thead>
					
						<tbody>
						<?php
							$sql = $conn->prepare("SELECT * FROM tbl_calendar WHERE is_deleted != '1' ORDER BY c_date ASC");
							$sql->execute();
							
							if($sql->rowCount() > 0)
							{
								$ctr = 1;
								while($sql_data = $sql->fetch())
								{
									//$cDate = date("M d, Y",strtotime($sql_data['c_date']));
									$cDate = $sql_data['c_date'];

									$dateArray = explode(", ", $cDate);

									// Convert each date to a different format
									$formattedDates = array();
									foreach ($dateArray as $date) {
										$dateTime = new DateTime($date);
										$formattedDates[] = $dateTime->format('M d, Y'); // Adjust the format as needed
									}

						?>
								<tr>
									<td><?php echo $ctr++; ?></td>
									<td><?php echo implode(", ", $formattedDates); ?></td>
									<td>
										<a href="index.php?view=modify&id=<?php echo $sql_data['c_id']; ?>" class="btn btn-soft-info rounded-pill waves-effect waves-light"><i class="mdi mdi-pencil"></i></a>
										<!-- &nbsp;
										<a href="process.php?action=delete&id=<?php echo $sql_data['c_id']; ?>" class="btn btn-danger rounded-pill waves-effect waves-light" onClick="return confirmDelete()">
											<span class="btn-label"><i class="mdi mdi-close-thick"></i></span>Delete
										</a> -->
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