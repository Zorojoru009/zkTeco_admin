<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}
?>
	<script language="JavaScript" type="text/javascript" src="<?php echo WEB_ROOT;?>global-library/common.js"></script>
	<!-- Confirm Submission of Form !-->
	<script LANGUAGE="JavaScript">
	<!--
		// Nannette Thacker http://www.shiningstar.net
		function confirmSubmit()
		{
			var agree=confirm("Make sure all informations are correct. Changes are not allowed once submitted. Please confirm to continue.");
			if (agree)
			return true ;
		else
			return false ;
		}
		
		// Nannette Thacker http://www.shiningstar.net
		function confirmDelete()
		{
			var agree=confirm("Are you sure you want to permanently delete this item? Please confirm to continue.");
			if (agree)
			return true ;
		else
			return false ;
		}
	// -->
	</script>		