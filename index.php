<?php
require_once 'global-library/config.php';
require_once 'include/functions.php';

	if(isset($_SESSION['user_id']))
	{ $userId = $_SESSION['user_id']; }else{ header('Location: login.php'); exit; }
	
	checkUser();
	
	$pg = $conn->prepare("UPDATE bs_page SET page_name = 'Dashboard' WHERE p_id = '1'");
	$pg->execute();
	
	$content = 'home.php';
	$pageTitle = $sett_data['system_title'];
	$script = array('main.js');

	require_once './include/template.php';
	
?>
<html>
<head>
<link rel="shortcut icon" href="../assets/images/favicon.ico">
        
		<!-- App css -->
<link href="../assets/css/config/default/bootstrap.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
<link href="../assets/css/config/default/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

<link href="../assets/css/config/default/bootstrap-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" disabled="disabled" />
<link href="../assets/css/config/default/app-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" disabled="disabled" />

<!-- icons -->
<link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor = "#FDE2B8">
</body>
</html>