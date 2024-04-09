<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}
?>
	<link rel="shortcut icon" href="<?php echo WEB_ROOT; ?>assets/images/favicon.ico">

    <!-- App css -->
	<link href="<?php echo WEB_ROOT; ?>assets/css/config/default/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
	<link href="<?php echo WEB_ROOT; ?>assets/css/config/default/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

	<link href="<?php echo WEB_ROOT; ?>assets/css/config/default/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled="disabled" />
	<link href="<?php echo WEB_ROOT; ?>assets/css/config/default/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled="disabled" />

	<!-- icons -->
	<link href="<?php echo WEB_ROOT; ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
	
	<!-- third party css -->
	<link href="<?php echo WEB_ROOT; ?>assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo WEB_ROOT; ?>assets/libs/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo WEB_ROOT; ?>assets/libs/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo WEB_ROOT; ?>assets/libs/datatables.net-select-bs5/css//select.bootstrap5.min.css" rel="stylesheet" type="text/css" />
	<!-- third party css end -->
	
	<!-- quill css -->
	<link href="<?php echo WEB_ROOT; ?>assets/libs/quill/quill.core.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo WEB_ROOT; ?>assets/libs/quill/quill.snow.css" rel="stylesheet" type="text/css" />
	
	<!-- Plugins css -->
	<link href="<?php echo WEB_ROOT; ?>assets/libs/mohithg-switchery/switchery.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo WEB_ROOT; ?>assets/libs/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo WEB_ROOT; ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo WEB_ROOT; ?>assets/libs/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo WEB_ROOT; ?>assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />

	<!-- Plugins css -->
	<link href="<?php echo WEB_ROOT; ?>assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo WEB_ROOT; ?>assets/libs/dropify/css/dropify.min.css" rel="stylesheet" type="text/css" />
	
	<!-- Custom box css -->
    <link href="<?php echo WEB_ROOT; ?>assets/libs/custombox/custombox.min.css" rel="stylesheet">
	
	<style>
		/* width */
		::-webkit-scrollbar {
		  width: 5px;
		}

		/* Track */
		::-webkit-scrollbar-track {
		  <!-- box-shadow: inset 0 0 5px grey; -->
		  border-radius: 10px;
		}
		 
		/* Handle */
		::-webkit-scrollbar-thumb {
		  background: #606876; 
		  border-radius: 10px;
		}

		/* Handle on hover */
		::-webkit-scrollbar-thumb:hover {
		  background: #606876; 
		}
	</style>
	<!--
	<script type="text/javascript">
        // Disable right-clicking on the webpage
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });
    </script>
	-->

	<!-- Plugins css -->
	<link href="<?php echo WEB_ROOT; ?>assets/libs/spectrum-colorpicker2/spectrum.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo WEB_ROOT; ?>assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo WEB_ROOT; ?>assets/libs/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo WEB_ROOT; ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />

	<!-- Responsive Table css -->
	<link href="<?php echo WEB_ROOT; ?>assets/libs/admin-resources/rwd-table/rwd-table.min.css" rel="stylesheet" type="text/css" />

