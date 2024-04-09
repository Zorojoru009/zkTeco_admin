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

b
{
	color: #ec6761;
}
</style>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h3>List of Activity</h3>
					<table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap" style="width: 100%;">
						<thead>
						<tr>
							<th>#</th>
							<th>Module</th>
							<th>Action</th>
							<th>Description</th>
							<th>Action by</th>
							<th>Log Date</th>
						</tr>
						</thead>
					
						<tbody>
					<?php
						$sql = $conn->prepare("SELECT * FROM tr_log ORDER BY log_action_date DESC");
						$sql->execute();
						
						if($sql->rowCount() > 0)
						{
							$ctr = 1;
							while($sql_data = $sql->fetch())
							{
								$actionBy = $sql_data['action_by'];

								$lad = date("M d, Y | h:i a",strtotime($sql_data['log_action_date']));

								$usr = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$actionBy' AND is_deleted != '1'");
								$usr->execute();
								$usr_data = $usr->fetch();
									$usrName = $usr_data['lastname'] . ', ' . $usr_data['firstname'] . ' ' . $usr_data['middlename'];
					?>
							<tr>
								<td><?php echo $ctr++; ?></td>
								<td><?php echo $sql_data['module']; ?></td>
								<td><?php echo $sql_data['action']; ?></td>
								<td><?php echo $sql_data['description']; ?></td>
								<td><?php echo $usrName; ?></td>
								<td><?php echo $lad; ?></td>
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