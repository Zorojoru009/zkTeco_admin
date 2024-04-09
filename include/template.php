<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}

$self = WEB_ROOT . 'index.php';

	function word_split($str,$words=15) {
		$arr = preg_split("/[\s]+/", $str,$words+1);
		$arr = array_slice($arr,0,$words);
		return join(' ',$arr);
	}		
		
?>

<!DOCTYPE html>
<html lang="en">

	<head>

        <meta charset="utf-8" />
<title><?php echo $pageTitle; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
<meta content="Coderthemes" name="author" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	
	<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/include/global-css.php'); ?>
	<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/include/misc-js.php'); ?>	

    </head>
	<body class="loading" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "sidebar": { "color": "light", "size": "default", "showuser": true}, "topbar": {"color": "light"}, "showRightSidebarOnPageLoad": true}'>

		<!-- Begin page -->
        <div id="wrapper">
			<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/include/header.php'); ?>
			
			<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/include/left-menu.php'); ?>
				<div class="content-page">
					<?php require_once $content; ?>
				</div>	
            <!-- drawer -->
            <?php 
				$pge = $conn->prepare("SELECT * FROM bs_page WHERE is_deleted != '1'");
				$pge->execute();
				$pge_data = $pge->fetch();
					$page = $pge_data['page_name'];
				/*	
				if($page == '2'){} else {
					include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/include/footer.php');
				}
				*/
				include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/include/footer.php');
			?>
            <!-- // END drawer -->
        </div>
		<?php //include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/include/right-menu.php'); ?>
		
        <?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/include/global-js.php'); ?>
    </body>

</html>