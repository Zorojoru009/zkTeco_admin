<?php
require_once '../global-library/config.php';
require_once '../include/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {

	case 'get_location' :
        get_location_data();
        break;
	
    case 'add' :
        add_data();
        break;
		
	case 'add7' :
        add7_data();
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
    Get Location Data
*/
function get_location_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	
	if (isset($_POST['lat']) && isset($_POST['long'])) {
		$latitude = $_POST['lat'];
		$longitude = $_POST['long'];

		$ltn = $conn->prepare("UPDATE tbl_location SET latitude = '$latitude', longitude = '$longitude', is_active = '1' WHERE l_id = '1'");
		$ltn->execute();

		// You can use the coordinates as needed, for example, store them in a database.
		// For demonstration purposes, let's just echo the coordinates.
		//echo "Latitude: $latitude, Longitude: $longitude";

	} else {
		//echo "Error: Latitude and longitude not provided.";
		$latitude = 0;
		$longitude = 0;
	}
	
	$url = "index.php?error=Location Pinned.";
	echo "<meta http-equiv=\"refresh\" content=\"1;URL=$url\">";
}

/*
    Add Data
*/
function add_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	
	$rfid = $_POST['rfid'];
	$latitude = $_POST['lat'];
	$longitude = $_POST['long'];
	$is_log = $_POST['is_log']; // 0 = Login | 1 = Logout
	$time = date("H:i:s");
	$date = date("Y-m-d");

	$datetime = $date . ' ' . $time;

	$chk = $conn->prepare("SELECT * FROM bs_employee WHERE rfid = '$rfid' AND is_deleted != '1'");
	$chk->execute();
	if($chk->rowCount() > 0)
	{
		while($chk_data = $chk->fetch())
		{
			$id_num = $chk_data['id_num'];

			$att = $conn->prepare("SELECT * FROM tbl_attendance WHERE id_num = '$id_num' AND a_date = '$today_date2' ORDER BY a_id DESC LIMIT 1");
			$att->execute();
			if($att->rowCount() > 0)
			{
				while($att_data = $att->fetch())
				{
					if($att_data['is_log'] == $is_log)
					{
						if($att_data['is_log'] == 1)
						{
							header("Location: index.php?error=ID number already logout! Data entry failed."); 
						} else {
							header("Location: index.php?error=ID number already login! Data entry failed."); 
						}
						
					} else {
						$sql = $conn->prepare("INSERT INTO tbl_attendance (id_num, latitude, longitude, a_date, a_time, a_datetime, is_log) VALUES ('$id_num', '$latitude', '$longitude', '$date', '$time', '$datetime', '$is_log')");
						$sql->execute();

						if($is_log == 1)
						{
							header("Location: index.php?error=Logout successfully."); 
						} else {
							header("Location: index.php?error=Login successfully."); 
						}
					}
				}
			} else {
				$sql = $conn->prepare("INSERT INTO tbl_attendance (id_num, latitude, longitude, a_date, a_time, a_datetime, is_log) VALUES ('$id_num', '$latitude', '$longitude', '$date', '$time', '$datetime', '$is_log')");
				$sql->execute();

				if($is_log == 1)
				{
					header("Location: index.php?error=Logout successfully."); 
				} else {
					header("Location: index.php?error=Login successfully."); 
				}
			}
		}
	} else {
		header("Location: index.php?error=RFID does not exist! Data entry failed.");  
	}

	//header("Location: ../index.php?id=$rfid&error=Out successfully.");
}

/*
    Add Data
*/
function add7_data()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	
	$today_day = date("l");
	$today_time = date("H");
	$today_a = date("a");
	
	$time = $_POST['time'];
	$rfidnum = $_POST['rfidnum'];
	
	$chk = $conn->prepare("SELECT * FROM bs_user WHERE rfid_num = '$rfidnum' AND is_deleted != '1'");
	$chk->execute();
	if($chk->rowCount() > 0)
	{
		if($today_time < 11){
			$ttin = "is_min";
			$ttin7 = "g_date_min";
			
			$ttt = "is_mout";
			$ttt7 = "g_date_mout";
			
		} else {
			$ttin = "is_ain";
			$ttin7 = "g_date_ain";
			
			$ttt = "is_aout";
			$ttt7 = "g_date_aout";
		}
		
		$chk1 = $conn->prepare("SELECT * FROM tbl_gate WHERE g_rfid_num = '$rfidnum' AND g_date_added = '$today_date2' AND $ttt = '0' AND is_deleted != '1'");
		$chk1->execute();
		if($chk1->rowCount() > 0)
		{
			$chk1_data = $chk1->fetch();
			$isAin = $chk1_data['is_ain'];
			
			if($time == "in")
			{
				if($today_a == 'am')
				{
					header("Location: ../index.php?id=$rfidnum&error=You're already logged in");
					
				} else {
					
					if($isAin == 1){
						header("Location: ../index.php?id=$rfidnum&error=You're already logged in");
						
					} else {
						$sql7 = $conn->prepare("UPDATE tbl_gate SET is_ain = '1', g_date_ain = '$today_date1', g_added_by = '$userId', is_deleted = '0' 
											WHERE g_rfid_num = '$rfidnum' AND g_date_added = '$today_date2'");
						$sql7->execute();
						
						header("Location: ../index.php?id=$rfidnum&error=In successfully.");
					}
				}
				
			} else {
				/*
				if($today_day == "Monday"){
					if($today_time < 11){
						$timeIn = $usr_data['mm_in'];
						$timeOut = $usr_data['mm_out'];
					} else {
						$timeIn = $usr_data['ma_in'];
						$timeOut = $usr_data['ma_out'];
					}
					
				} else if($today_day == "Tuesday"){
					if($today_time <= 11){
						$timeIn = $usr_data['tm_in'];
						$timeOut = $usr_data['tm_out'];
					} else {
						$timeIn = $usr_data['ta_in'];
						$timeOut = $usr_data['ta_out'];
					}
					
				} else if($today_day == "Wednesday"){
					if($today_time < 11){
						$timeIn = $usr_data['wm_in'];
						$timeOut = $usr_data['wm_out'];
					} else {
						$timeIn = $usr_data['wa_in'];
						$timeOut = $usr_data['wa_out'];
					}
					
				} else if($today_day == "Thursday"){
					if($today_time < 11){
						$timeIn = $usr_data['thm_in'];
						$timeOut = $usr_data['thm_out'];
					} else {
						$timeIn = $usr_data['tha_in'];
						$timeOut = $usr_data['tha_out'];
					}
					
				} else if($today_day == "Friday"){
					if($today_time < 11){
						$timeIn = $usr_data['fm_in'];
						$timeOut = $usr_data['fm_out'];
					} else {
						$timeIn = $usr_data['fa_in'];
						$timeOut = $usr_data['fa_out'];
					}
					
				} else if($today_day == "Saturday"){
					if($today_time < 11){
						$timeIn = $usr_data['sm_in'];
						$timeOut = $usr_data['sm_out'];
					} else {
						$timeIn = $usr_data['sa_in'];
						$timeOut = $usr_data['sa_out'];
					}
					
				} else {}
				*/
				
				$sql7 = $conn->prepare("UPDATE tbl_gate SET $ttt = '1', $ttt7 = '$today_date1', g_added_by = '$userId', is_deleted = '0' 
										WHERE g_rfid_num = '$rfidnum' AND g_date_added = '$today_date2'");
				$sql7->execute();
				
				header("Location: ../index.php?id=$rfidnum&error=Out successfully.");    
			}
		}else {
			if($time == "out"){
				header("Location: ../index.php?id=$rfidnum&error=You're already logged out");
			} else {
				$usr = $conn->prepare("SELECT * FROM bs_user WHERE rfid_num = '$rfidnum' AND is_deleted != '1'");
				$usr->execute();
				$usr_data = $usr->fetch();
				$accLevel = $usr_data['access_level'];
				$branch = $usr_data['branch'];
				
					if($today_day == "Monday"){
						$mtimeIn = $usr_data['mm_in'];
						$mtimeOut = $usr_data['mm_out'];
						$atimeIn = $usr_data['ma_in'];
						$atimeOut = $usr_data['ma_out'];
						
					} else if($today_day == "Tuesday"){
						$mtimeIn = $usr_data['tm_in'];
						$mtimeOut = $usr_data['tm_out'];
						$atimeIn = $usr_data['ta_in'];
						$atimeOut = $usr_data['ta_out'];
						
					} else if($today_day == "Wednesday"){
						$mtimeIn = $usr_data['wm_in'];
						$mtimeOut = $usr_data['wm_out'];
						$atimeIn = $usr_data['wa_in'];
						$atimeOut = $usr_data['wa_out'];
						
					} else if($today_day == "Thursday"){
						$mtimeIn = $usr_data['thm_in'];
						$mtimeOut = $usr_data['thm_out'];
						$atimeIn = $usr_data['tha_in'];
						$atimeOut = $usr_data['tha_out'];
						
					} else if($today_day == "Friday"){
						$mtimeIn = $usr_data['fm_in'];
						$mtimeOut = $usr_data['fm_out'];
						$atimeIn = $usr_data['fa_in'];
						$atimeOut = $usr_data['fa_out'];
						
					} else if($today_day == "Saturday"){
						$mtimeIn = $usr_data['sm_in'];
						$mtimeOut = $usr_data['sm_out'];
						$atimeIn = $usr_data['sa_in'];
						$atimeOut = $usr_data['sa_out'];
						
					} else if($today_day == "Sunday"){
						$mtimeIn = $usr_data['sum_in'];
						$mtimeOut = $usr_data['sum_out'];
						$atimeIn = $usr_data['sua_in'];
						$atimeOut = $usr_data['sua_out'];
						
					} else {}
					
					$sql = $conn->prepare("INSERT INTO tbl_gate (g_access_level, g_day, g_rfid_num, g_branch, g_user_mtimein, g_user_mtimeout, g_user_atimein, g_user_atimeout, $ttin, $ttin7, g_date_added, g_added_by, is_deleted)
														VALUES ('$accLevel', '$today_day', '$rfidnum', '$branch', '$mtimeIn', '$mtimeOut', '$atimeIn', '$atimeOut', '1', '$today_date1', '$today_date2', '$userId', '0')");
					$sql->execute();
				
				header("Location: ../index.php?id=$rfidnum&error=In successfully.");
			}
		}
	} else {
		
		header("Location: ../index.php?error=Card Invalid.");
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
    
	$batch = $_POST['batch'];
	$department = $_POST['department'];
    $fname = $_POST['fname'];
	$mname = $_POST['mname']; 	
	$lname = $_POST['lname'];
	$idnum = $_POST['idnum'];
	$password = $_POST['password'];
	$quote = $_POST['quote'];
	$hobby = $_POST['hobby'];
	
	$images = uploadimage('fileImage', SRV_ROOT . 'images/user/');

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
	
	$videos = uploadvideo('my_video');
	$mainVideo = $videos['video'];
	
	$chk = $conn->prepare("SELECT * FROM bs_user WHERE firstname = '$fname' AND middlename = '$mname' AND lastname = '$lname' AND uid != '$id' AND is_deleted != '1'");
	$chk->execute();
	if($chk->rowCount() > 0)
	{
		header("Location: index.php?view=modify&id=$id&error=Student already exist! Data entry failed.");
	}else{
    
		$sql = $conn->prepare("UPDATE bs_user SET batch = '$batch', id_num = '$idnum', dep_id = '$department', firstname = '$fname', middlename = '$mname', lastname = '$lname', username = '$idnum', password = md5('$password'), pass_text = '$password', quote = '$quote', hobby = '$hobby',
						image = $mainImage, thumbnail = $thumbnail WHERE uid = '$id'");
		$sql->execute();
		
		if($mainVideo != ''){
		$sql7 = $conn->prepare("INSERT INTO tbl_video (vid_url, user_uid) VALUES('$mainVideo', '$id')");
		$sql7->execute();
		} else {}
               
		header("Location: index.php?view=modify&id=$id&error=Modified successfully");
	
	}
}

/*
    Remove Data
*/
function delete_data()
{
	include '../global-library/database.php';	
    if(isset($_POST['id']))
	{ $id = $_POST['id']; }else{ $id = $_GET['id']; }	
	
    // delete the category. set is_deleted to 1 as deleted;    
	$sql = $conn->prepare("UPDATE bs_user SET is_deleted = '1' WHERE uid = '$id'");
	$sql->execute();
        
	header("Location: index.php?error=Deleted successfully");
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
			$deleted = @unlink(SRV_ROOT . "images/user/$sql_data[image]");
			$deleted = @unlink(SRV_ROOT . "images/user/$sql_data[thumbnail]");
		}
	}

	return $deleted;
}

?>