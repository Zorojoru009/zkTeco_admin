<?php
require_once '../global-library/config.php';
require_once '../include/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
	
    case 'add' :
        add_data();
        break;
		
	case 'modify' :
        modify_data();
        break;
        
    case 'delete' :
        delete_data();
        break;

	case 'calendar' :
		calendar_data();
		break;
    
    case 'deleteImage' :
        deleteImage();
        break;
    
	   
    default :
        // if action is not defined or unknown
        // move to main category page
        header('Location: index.php');
}


/*
    Add Data
*/
function add_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];

	$hdate = $_POST['hdate'];

	$sql = $conn->prepare("INSERT INTO tbl_calendar (c_date, is_deleted) VALUES ('$hdate', '0')");
	$sql->execute();

	$id = $conn->lastInsertId();

	header("Location: index.php?view=modify&id=$id&error=Added successfully.");
}

/*
    Modify Data
*/
function modify_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	
    $id = $_POST['id'];
    
	$hdate = $_POST['hdate'];
	
	$sql = $conn->prepare("UPDATE tbl_calendar SET c_date = '$hdate' WHERE c_id = '$id'");
	$sql->execute();

	header("Location: index.php?view=modify&id=$id&error=Modified successfully.");
}

/*
    Remove Data
*/
function delete_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	
    if(isset($_POST['id']))
	{ $id = $_POST['id']; }else{ $id = $_GET['id']; }	

    // delete the category. set is_deleted to 1 as deleted;    
	$sql = $conn->prepare("UPDATE tbl_calendar SET is_deleted = '1' WHERE c_id = '$id'");
	$sql->execute();

	header("Location: index.php?error=Deleted successfully.");
}

?>