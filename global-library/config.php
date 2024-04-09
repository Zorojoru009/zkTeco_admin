<?php
ini_set('max_execution_time', 2400); //in seconds
ini_set('display_errors', 'On');
//ob_start("ob_gzhandler");
error_reporting(E_ALL ^ E_DEPRECATED);
// start the session
session_start();

date_default_timezone_set("Asia/Manila");
$today_date1 = date("Y-m-d H:i:s");
$today_date2 = date("Y-m-d");
$today_date3 = date("M d, Y");
$today_date4 = date("M d, Y | h:i a");
$today_month = date("m");
$today_year = date("Y");
$today_day = date("l");
$today_time = date("H");
$today_a = date("a");

// database connection config
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'db_tridentbio';

try {
    $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
}
catch(PDOException $e)
    { echo "Connection failed: " . $e->getMessage(); }

/*
// database connection config
$dbHost_live = '35.213.175.236';
$dbUser_live = 'uuseag7n60cgz';
$dbPass_live = '9lasdl8ouxgc';
$dbName_live = 'dbymgvbcdzfqgv';

try {
    $conn_live = new PDO("mysql:host=$dbHost_live;dbname=$dbName_live", $dbUser_live, $dbPass_live);
    // set the PDO error mode to exception
    $conn_live->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
}
catch(PDOException $e)
    { echo "Connection failed: " . $e->getMessage(); }
*/

$link  = mysqli_connect("$dbHost","$dbUser","$dbPass","$dbName");

if(isset($_SESSION['user_id'])){ $userId = $_SESSION['user_id']; }else{ $userId = ""; }

# Get user details
$user = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$userId'");
$user->execute();
$user_data = $user->fetch();

# Get setting details
$sett = $conn->prepare("SELECT * FROM bs_setting");
$sett->execute();
$sett_data = $sett->fetch();

// setting up the web root and server root for this website application
$thisFile = str_replace('\\', '/', __FILE__);
$docRoot = '/zkTeco_admin/';

$srvRoot  = str_replace('global-library/config.php', '', $thisFile);
$webRoot  = '/zkTeco_admin/';

define('WEB_ROOT', $webRoot);
define('SRV_ROOT', $srvRoot);

# User Image
if(isset($_SESSION['user_id'])){
	if ($user_data['thumbnail']) 
	{ $user_image = WEB_ROOT . 'assets/images/users/' . $user_data['thumbnail']; } else { $user_image = WEB_ROOT . 'assets/images/users/noimage.png'; }	
}

// do we need to limit the image width?  setting this value to 'true' is recommended
define('LIMIT_IMAGE_WIDTH',     true);

// do we need to limit the employee image width?  setting this value to 'true' is recommended
define('LIMIT_EMPLOYEE_WIDTH',     true);

// do we need to limit the employee image width?  setting this value to 'true' is recommended
define('LIMIT_PRODUCT_WIDTH',     true);

// all file image width must not exceed 300 pixels
define('MAX_IMAGE_WIDTH', 300);

// all file image width must not exceed 300 pixels
define('MAX_PRODUCT_WIDTH', 1300);

// all employee image width must not exceed 300 pixels
define('MAX_EMPLOYEE_WIDTH', 300);

// all category image width must not 
// exceed 75 pixels
define('MAX_CATEGORY_IMAGE_WIDTH', 75);

// the width for writer thumbnail
define('THUMBNAIL_WIDTH',         175);

/*if (!get_magic_quotes_gpc()) {
	if (isset($_POST)) {
		foreach ($_POST as $key => $value) {
			$_POST[$key] =  trim(addslashes($value));
		}
	}

	if (isset($_GET)) {
		foreach ($_GET as $key => $value) {
			$_GET[$key] = trim(addslashes($value));
		}
	}
}*/

/*
    since all page will require a database access and the common library is also used by all
    it's logical to load these library here.
*/
require_once 'database.php';
//require_once 'common.php';


?>