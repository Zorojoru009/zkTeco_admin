<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}
?>
				<footer class="footer">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-6">
								<?php echo $sett_data['year_developed']; ?> &copy; <?php echo $sett_data['system_title']; ?>
							</div>
							<div class="col-md-6">
								<div class="text-md-end">
									Powered by: <?php echo $sett_data['developer']; ?> | <a href="https://tridentechnology.com/" target="_blank" ><?php echo $sett_data['website']; ?></a>
								</div>
							</div>
						</div>
					</div>
				</footer>