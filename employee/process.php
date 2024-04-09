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
	
	$id_num = $_POST['id_num'];
	$e_fname = mysqli_real_escape_string($link, $_POST['e_fname']);
	$e_mname = mysqli_real_escape_string($link, $_POST['e_mname']); 	
	$e_lname = mysqli_real_escape_string($link, $_POST['e_lname']);
	$suffix = mysqli_real_escape_string($link, $_POST['suffix']);
	$dob = $_POST['dob'];
	$gender = $_POST['gender'];
	$e_contact_o = $_POST['e_contact_o'];
	$e_contact_t = $_POST['e_contact_t'];
	$e_paddress = mysqli_real_escape_string($link, $_POST['e_paddress']);
	$e_saddress = mysqli_real_escape_string($link, $_POST['e_saddress']);
	$tos = $_POST['tos'];
	$salary = $_POST['salary'];
	$num_hrs = $_POST['num_hrs'];
	$sss_num = $_POST['sss_num'];
	$tin_num = $_POST['tin_num'];
	$pag_num = $_POST['pag_num'];
	$phil_num = $_POST['phil_num'];
	$rfid = $_POST['rfid'];

	$eq1 = $salary / $num_hrs;
	$spm = $eq1 / 60;

	if($tos != 1){
		$tosN = "Daily";
	} else {
		$tosN = "Fixed";
	}

	$images = uploadimage('fileImage', SRV_ROOT . 'assets/images/profile-picture/');

	$mainImage = $images['image'];
	$thumbnail = $images['thumbnail'];

	$chk = $conn->prepare("SELECT * FROM bs_employee WHERE e_fname = '$e_fname' AND e_lname = '$e_lname' AND id_num = '$id_num' AND rfid = '$rfid' AND is_deleted != '1'");
	$chk->execute();
	if($chk->rowCount() > 0)
	{
		header('Location: index.php?view=add&error=Data already exist! Data entry failed.');              
	}else{
        
		$sql = $conn->prepare("INSERT INTO bs_employee (id_num, e_fname, e_mname, e_lname, suffix, birth_date, gender,
														e_contact_o, e_contact_t, e_paddress, e_saddress, e_branch,
														type_of_salary, salary, number_of_hours, salary_per_mins, 
														sss_num, tin_num, pag_num, phil_num, rfid, 
														image, thumbnail,
														date_added, added_by)
												VALUES ('$id_num', '$e_fname', '$e_mname', '$e_lname', '$suffix', '$dob', '$gender',
														'$e_contact_o', '$e_contact_t', '$e_paddress', '$e_saddress', '1',
														'$tos', '$salary', '$num_hrs', '$spm', 
														'$sss_num', '$tin_num', '$pag_num', '$phil_num', '$rfid',
														'$mainImage', '$thumbnail', 
														'$today_date1', '$userId')");
		$sql->execute();

		$id = $conn->lastInsertId();
		$uid = md5($id);

		$up = $conn->prepare("UPDATE bs_employee SET uid = '$uid' WHERE e_id = '$id'");
		$up->execute();

		$chk1 = $conn->prepare("SELECT * FROM bs_user WHERE firstname = '$e_fname' AND lastname = '$e_lname' AND id_num = '$id_num' AND is_deleted != '1'");
		$chk1->execute();
		if($chk1->rowCount() > 0)
		{
			header('Location: index.php?view=add&error=Data already exist! Data entry failed.');              
		}else{

			$username = strtolower($e_fname);

			$sql1 = $conn->prepare("INSERT INTO bs_user (e_id, firstname, middlename, lastname, username, password, pass_text, title, access_level,
														contactno, address,
														image, thumbnail,
														date_added, added_by)
												VALUES ('$id', '$e_fname', '$e_mname', '$e_lname', '$username', md5('1234'), '1234', 'Staff', '3',
														'$e_contact_o', '$e_paddress',
														'$mainImage', '$thumbnail',
														'$today_date1', '$userId')");
			$sql1->execute();

			$id1 = $conn->lastInsertId();
			$uid1 = md5($id1);

			$up1 = $conn->prepare("UPDATE bs_user SET uid = '$uid1' WHERE user_id = '$id1'");
			$up1->execute();

			$keyword = 'ID Number: ' . $id_num . ' <br />First Name: ' . $e_fname . ' <br />Middle Name: ' . $e_mname . ' <br />Last Name: ' . $e_lname . ' <br />Suffix: ' . $suffix . ' <br />Date of birth: ' . $dob . ' <br />Gender: ' . $gender;
			$keyword .= ' <br />Contact No. 1: ' . $e_contact_o . ' <br />Contact No. 2: ' . $e_contact_t . ' <br />Primary Address: ' . $e_paddress . ' <br />Secondary Address: ' . $e_saddress;
			$keyword .= ' <br />Type of Salary: ' . $tosN . ' <br />Salary: ' . $salary . ' <br />Number of Hours: ' . $num_hrs;
			$keyword .= ' <br />SSS No.: ' . $sss_num . ' <br />TIN No.: ' . $tin_num . ' <br />Pag-ibig No.: ' . $pag_num . ' <br />Phil Health No.: ' . $phil_num;  

			$log = $conn->prepare("INSERT INTO tr_log (module, action, description, action_by, log_action_date)
											VALUES ('Employee', 'Employee Added', '$keyword', '$userId', '$today_date1')");
			$log->execute();	
			
			header('Location: index.php?view=add&error=Added successfully.');
		}
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
    
	$id_num = $_POST['id_num'];
	$e_fname = mysqli_real_escape_string($link, $_POST['e_fname']);
	$e_mname = mysqli_real_escape_string($link, $_POST['e_mname']); 	
	$e_lname = mysqli_real_escape_string($link, $_POST['e_lname']);
	$suffix = mysqli_real_escape_string($link, $_POST['suffix']);
	$dob = $_POST['dob'];
	$gender = $_POST['gender'];
	$e_contact_o = $_POST['e_contact_o'];
	$e_contact_t = $_POST['e_contact_t'];
	$e_paddress = mysqli_real_escape_string($link, $_POST['e_paddress']);
	$e_saddress = mysqli_real_escape_string($link, $_POST['e_saddress']);
	$tos = $_POST['tos'];
	$salary = $_POST['salary'];
	$num_hrs = $_POST['num_hrs'];
	$sss_num = $_POST['sss_num'];
	$tin_num = $_POST['tin_num'];
	$pag_num = $_POST['pag_num'];
	$phil_num = $_POST['phil_num'];
	$rfid = $_POST['rfid'];

	$eq1 = $salary / $num_hrs;
	$spm = $eq1 / 60;

	if($tos != 1){
		$tosN = "Daily";
	} else {
		$tosN = "Fixed";
	}

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
	
	$chk = $conn->prepare("SELECT * FROM bs_employee WHERE id_num = '$id_num' AND e_fname = '$e_fname' AND e_lname = '$e_lname' AND rfid = '$rfid' AND uid != '$id' AND is_deleted != '1'");
	$chk->execute();
	if($chk->rowCount() > 0)
	{
		header("Location: index.php?view=modify&id=$id&error=Data already exist! Data entry failed.");
	}else{

		$sql = $conn->prepare("UPDATE bs_employee SET id_num = '$id_num', e_fname = '$e_fname', e_mname = '$e_mname', e_lname = '$e_lname', suffix = '$suffix', birth_date = '$dob', gender = '$gender',
														e_contact_o = '$e_contact_o', e_contact_t = '$e_contact_t', e_paddress = '$e_paddress', e_saddress = '$e_saddress', e_branch = '1',
														type_of_salary = '$tos', salary = '$salary', number_of_hours = '$num_hrs', salary_per_mins = '$spm', 
														sss_num = '$sss_num', tin_num = '$tin_num', pag_num = '$pag_num', phil_num = '$phil_num', rfid = '$rfid', 
														image = $mainImage, thumbnail = $thumbnail,
														date_modified = '$today_date1', modified_by = '$userId' WHERE uid = '$id'");
		$sql->execute();

		$emp = $conn->prepare("SELECT * FROM bs_employee WHERE uid = '$id' AND is_deleted != '1'");
		$emp->execute();
		$emp_data = $emp->fetch();
			$eId = $emp_data['e_id'];

		$sql1 = $conn->prepare("UPDATE bs_user SET firstname = '$e_fname', middlename = '$e_mname', lastname = '$e_lname',
													contactno = '$e_contact_o', address = '$e_paddress',
													image = $mainImage, thumbnail = $thumbnail,
													date_modified = '$today_date1', modified_by = '$userId' WHERE e_id = '$eId'");
		$sql1->execute();

		$keyword = 'ID Number: ' . $id_num . ' <br />First Name: ' . $e_fname . ' <br />Middle Name: ' . $e_mname . ' <br />Last Name: ' . $e_lname . ' <br />Suffix: ' . $suffix . ' <br />Date of birth: ' . $dob . ' <br />Gender: ' . $gender;
		$keyword .= ' <br />Contact No. 1: ' . $e_contact_o . ' <br />Contact No. 2: ' . $e_contact_t . ' <br />Primary Address: ' . $e_paddress . ' <br />Secondary Address: ' . $e_saddress;
		$keyword .= ' <br />Type of Salary: ' . $tosN . ' <br />Salary: ' . $salary . ' <br />Number of Hours: ' . $num_hrs;
		$keyword .= ' <br />SSS No.: ' . $sss_num . ' <br />TIN No.: ' . $tin_num . ' <br />Pag-ibig No.: ' . $pag_num . ' <br />Phil Health No.: ' . $phil_num;  

		$log = $conn->prepare("INSERT INTO tr_log (module, action, description, action_by, log_action_date)
										VALUES ('Employee', 'Employee Modified', '$keyword', '$userId', '$today_date1')");
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

	$chk = $conn->prepare("SELECT * FROM bs_employee WHERE uid = '$id'");
	$chk->execute();
	$chk_data = $chk->fetch();
		$id_num = $chk_data['id_num'];
		$e_fname = $chk_data['e_fname'];
		$e_mname = $chk_data['e_mname']; 	
		$e_lname = $chk_data['e_lname'];
		$suffix = $chk_data['suffix'];
		$dob = $chk_data['birth_date'];
		$gender = $chk_data['gender'];
		$e_contact_o = $chk_data['e_contact_o'];
		$e_contact_t = $chk_data['e_contact_t'];
		$e_paddress = $chk_data['e_paddress'];
		$e_saddress = $chk_data['e_saddress'];
		$tos = $chk_data['type_of_salary'];
		$salary = $chk_data['salary'];
		$num_hrs = $chk_data['number_of_hours'];
		$sss_num = $chk_data['sss_num'];
		$tin_num = $chk_data['tin_num'];
		$pag_num = $chk_data['pag_num'];
		$phil_num = $chk_data['phil_num'];

		if($tos != 1){
			$tosN = "Daily";
		} else {
			$tosN = "Fixed";
		}

	$deleted = _deleteImage($id);
	
    // delete the category. set is_deleted to 1 as deleted;    
	$sql = $conn->prepare("UPDATE bs_employee SET is_deleted = '1', date_deleted = '$today_date1', deleted_by = '$userId' WHERE uid = '$id'");
	$sql->execute();
	
	$keyword = 'ID Number: ' . $id_num . ' <br />First Name: ' . $e_fname . ' <br />Middle Name: ' . $e_mname . ' <br />Last Name: ' . $e_lname . ' <br />Suffix: ' . $suffix . ' <br />Date of birth: ' . $dob . ' <br />Gender: ' . $gender;
	$keyword .= ' <br />Contact No. 1: ' . $e_contact_o . ' <br />Contact No. 2: ' . $e_contact_t . ' <br />Primary Address: ' . $e_paddress . ' <br />Secondary Address: ' . $e_saddress;
	$keyword .= ' <br />Type of Salary: ' . $tosN . ' <br />Salary: ' . $salary . ' <br />Number of Hours: ' . $num_hrs;
	$keyword .= ' <br />SSS No.: ' . $sss_num . ' <br />TIN No.: ' . $tin_num . ' <br />Pag-ibig No.: ' . $pag_num . ' <br />Phil Health No.: ' . $phil_num;  

	$log = $conn->prepare("INSERT INTO tr_log (module, action, description, action_by, log_action_date)
											VALUES ('Employee', 'Employee Deleted', '$keyword', '$userId', '$today_date1')");
	$log->execute();	
        
	header("Location: index.php?error=Deleted successfully.");
}

function _deleteImage($id)
{
	include '../global-library/database.php';
	// we will return the status
	// whether the image deleted successfully
	$deleted = false;
	
	$sql = $conn->prepare("SELECT image, thumbnail FROM bs_employee WHERE uid = '$id'");
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