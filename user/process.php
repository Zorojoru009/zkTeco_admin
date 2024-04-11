<?php
require_once '../global-library/config.php';
require_once '../include/functions.php';
require_once '../global-library/include.php';

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
	
	$uid = (string) $_POST['uid'];
	$fname = (string) $_POST['fname'];
	$mname = (string) $_POST['mname'];
	$lname = (string) $_POST['lname'];
	$role = (string) $_POST['role'];
	$name = (string) ($fname . ' ' . $lname);
	$user_count =  (int) $_POST['user_count'];
    $zk = new ZKLibrary('192.168.1.205', 4370, 'TCP');

    $requester_path = isset($_POST['requester_path']) ? $_POST['requester_path'] : null;
    try {
        // Connect to device
        $zk->connect();

        // Log for debugging
        echo 'Connected to device<br>';
        echo 'Name: ' . $name . '<br>';
        echo 'User ID: ' . $uid . '<br>';
        echo 'Role: ' . $role . '<br>';

        // Set user data
       $zk->setUser('', $uid, $name, '', $role);

		$users = $zk->getUser();
		$user_count++;
		$user_count_update = $conn->prepare("UPDATE bs_user_count SET user_count = '$user_count' WHERE sl_id = '1'");
		$user_count_update->execute();

		print_r($users);
        // JavaScript code to set feedback
        echo '<script>setFeedbackRequest(0);</script>';
        echo '<script>window.onload = function() {
            console.log("JavaScript code executed");
            // window.location.href = "' . $requester_path . '";
        }</script>';
    } catch (Throwable $e) {
        // Handle errors
        echo 'Caught Throwable: ' . $e->getMessage() . '<br>';

        // JavaScript code to set feedback
        echo '<script>setFeedbackRequest(1);</script>';
        echo '<script>window.onload = function() {
            console.log("JavaScript code executed");
            // window.location.href = "' . $requester_path . '";
        }</script>';
    }
}


/*
	Upload an image and return the uploaded image name
*/
function uploadimage($inputName, $uploadDir)
{
	$image     = $_FILES[$inputName];
	$imagePath = '';
	$thumbnailPath = '';

	// if a file is given
	if (trim($image['tmp_name']) != '') {
		$ext = substr(strrchr($image['name'], "."), 1); //$extensions[$image['type']];

		// generate a random new file name to avoid name conflict
		$imagePath = md5(rand() * time()) . ".$ext";

		list($width, $height, $type, $attr) = getimagesize($image['tmp_name']);

		// make sure the image width does not exceed the
		// maximum allowed width
		if (LIMIT_IMAGE_WIDTH && $width > MAX_IMAGE_WIDTH) {
			$result    = createThumbnail($image['tmp_name'], $uploadDir . $imagePath, MAX_IMAGE_WIDTH);
			$imagePath = $result;
		} else {
			$result = move_uploaded_file($image['tmp_name'], $uploadDir . $imagePath);
		}

		if ($result) {
			// create thumbnail
			$thumbnailPath =  md5(rand() * time()) . ".$ext";
			$result = createThumbnail($uploadDir . $imagePath, $uploadDir . $thumbnailPath, THUMBNAIL_WIDTH);

			// create thumbnail failed, delete the image
			if (!$result) {
				unlink($uploadDir . $imagePath);
				$imagePath = $thumbnailPath = '';
			} else {
				$thumbnailPath = $result;
			}
		} else {
			// the image cannot be upload / resized
			$imagePath = $thumbnailPath = '';
		}

	}


	return array('image' => $imagePath, 'thumbnail' => $thumbnailPath);
}


/*
    Modify Data
*/
function modify_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	
    $id = $_POST['id'];
    
	$fname = mysqli_real_escape_string($link, $_POST['fname']);
	$mname = mysqli_real_escape_string($link, $_POST['mname']); 	
	$lname = mysqli_real_escape_string($link, $_POST['lname']);
	$contactnum = $_POST['contactnum'];
	$address = mysqli_real_escape_string($link, $_POST['address']);
	
	$images = uploadimage('fileImage', SRV_ROOT . 'assets/images/profile-picture/');

	$mainImage = $images['image'];
	$thumbnail = $images['thumbnail'];
	
	// if uploading a new image
	// remove old image
	if ($mainImage != '') {
		_deleteImage($id);

		$mainImage = "'$mainImage'";
		$thumbnail = "'$thumbnail'";
	} else {
		// if we're not updating the image
		// make sure the old path remain the same
		// in the database
		$mainImage = 'image';
		$thumbnail = 'thumbnail';
	}
	
	$chk = $conn->prepare("SELECT * FROM bs_user WHERE firstname = '$fname' AND lastname = '$lname' AND uid != '$id' AND is_deleted != '1'");
	$chk->execute();
	if($chk->rowCount() > 0)
	{
		header("Location: index.php?view=modify&id=$id&error=Data already exist! Data entry failed.");
	}else{
    
		$sql = $conn->prepare("UPDATE bs_user SET firstname = '$fname', middlename = '$mname', lastname = '$lname', contactno = '$contactnum', address = '$address',
													image = $mainImage, thumbnail = $thumbnail, date_modified = '$today_date1', modified_by = '$userId' WHERE uid = '$id'");
		$sql->execute();

		$acs = $conn->prepare("UPDATE bs_user SET is_user = '0', is_user_add = '0', is_user_edit = '0', is_user_delete = '0'
														WHERE uid = '$id'");
		$acs->execute();
			
		if(isset($_POST['my_multi_select1']))
		{
			$op_access = $_POST['my_multi_select1']; 
			foreach ($op_access as $access)
			{
				$acs7 = $conn->prepare("UPDATE bs_user SET $access = '1' WHERE uid = '$id'");
				$acs7->execute();
			}	
		}	
		
		$keyword = 'First Name: ' . $fname . '<br /> Middle Name: ' . $mname . '<br /> Last Name: ' . $lname . '<br /> Contact Number: ' . $contactnum . '<br /> Address: ' . $address;
		
		$log = $conn->prepare("INSERT INTO tr_log (module, action, description, action_by, log_action_date)
												VALUES ('User', 'User Modified', '$keyword', '$userId', '$today_date1')");
		$log->execute();
		
		header("Location: index.php?view=modify&id=$id&error=Modified successfully.");
	
	}
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

	$chk = $conn->prepare("SELECT * FROM bs_user WHERE uid = '$id'");
	$chk->execute();
	$chk_data = $chk->fetch();
		$fname = $chk_data['firstname'];
		$mname = $chk_data['middlename'];
		$lname = $chk_data['lastname'];
		$contactnum = $chk_data['contactno'];
		$address = $chk_data['address'];
	
	$deleted = _deleteImage($id);
	
    // delete the category. set is_deleted to 1 as deleted;    
	$sql = $conn->prepare("UPDATE bs_user SET is_deleted = '1', date_deleted = '$today_date1', deleted_by = '$userId' WHERE uid = '$id'");
	$sql->execute();
	
	$keyword = 'First Name: ' . $fname . '<br /> Middle Name: ' . $mname . '<br /> Last Name: ' . $lname . '<br /> Contact Number: ' . $contactnum . '<br /> Address: ' . $address;

	$log = $conn->prepare("INSERT INTO tr_log (module, action, description, action_by, log_action_date)
											VALUES ('User', 'User Deleted', '$keyword', '$userId', '$today_date1')");
	$log->execute();	
        
	header("Location: index.php?error=Deleted successfully.");
}

function _deleteImage($id)
{
	include '../global-library/database.php';
	// we will return the status
	// whether the image deleted successfully
	$deleted = false;
	
	$sql = $conn->prepare("SELECT image, thumbnail FROM bs_user WHERE uid = '$id'");
	$sql->execute();

	if ($sql->rowCount() > 0) {
		$sql_data = $sql->fetch();		

		if ($sql_data['image'] && $sql_data['thumbnail']) {
			// remove the image file
			$deleted = @unlink(SRV_ROOT . "assets/images/profile-picture/$sql_data[image]");
			$deleted = @unlink(SRV_ROOT . "assets/images/profile-picture/$sql_data[thumbnail]");
		}
	}

	return $deleted;
}

?>