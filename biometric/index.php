<?php
require_once '../global-library/config.php';
require_once '../include/functions.php';

$today_date1 = date("Y-m-d H:i:s");
$today_date2 = date("Y-m-d");
$today_date3 = date("M d, Y");
$today_date4 = date("M d, Y | h:i a");
$today_month = date("m");
$today_year = date("Y");
$today_day = date("l");
$today_time = date("H");
$today_a = date("a");

//checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {

    case 'register':
        register_data();
        break;

    case 'log':
        log_data();
        break;

    case 'get_emp_details':
        get_emp_details_data();
        break;

    case 'sync_login':
        sync_login_data();
        break;

    case 'log_universal':
        log_universal_data();
        break;

    default:
        // if action is not defined or unknown
        // move to main category page
        header('Location: index.php');
}

/*
    Check User Register
*/
function register_data()
{
    include '../global-library/database.php';

    if(isset($_POST['e_id']) && isset($_POST['latitude']) && isset($_POST['longitude']) && isset($_POST['fname']) && isset($_POST['mname']) && isset($_POST['lname']) && isset($_POST['rfid']) && isset($_POST['byte']))
    {
        $e_id = $_POST['e_id'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $rfid = $_POST['rfid'];
        $byte = $_POST['byte'];

        $chk = $conn->prepare("SELECT * FROM sa_employeeDetails WHERE id_num = '$e_id' AND rfid = '$rfid'");
        $chk->execute();
        if($chk->rowCount() > 0) 
        {
            $response = array('status' => 'RFID already exists');
        } else {
            $sql = $conn->prepare("INSERT INTO sa_employeeDetails (id_num, latitude, longitude, fname, mname, lname, rfid, byte, is_sent)
                                                    VALUES ('$e_id', '$latitude', '$longitude', '$fname', '$mname', '$lname', '$rfid', '$byte', '0')");
            $sql->execute();

            $chk1 = $conn->prepare("SELECT * FROM bs_employee WHERE id_num = '$e_id' AND rfid = '$rfid' AND is_deleted != '1'");
            $chk1->execute();
            if($chk1->rowCount() > 0) 
            {
                $response = array('status' => 'RFID already exists');
            } else {
                $sql1 = $conn->prepare("INSERT INTO bs_employee (id_num, e_fname, e_mname, e_lname, e_branch, rfid, date_added, added_by)
                                                        VALUES ('$e_id', '$fname', '$mname', '$lname', '1', '$rfid', '$today_date1', '1116')");
                $sql1->execute();

                $id = $conn->lastInsertId();
                $uid = md5($id);

                $up = $conn->prepare("UPDATE bs_employee SET uid = '$uid' WHERE e_id = '$id'");
                $up->execute();

                $chk2 = $conn->prepare("SELECT * FROM bs_user WHERE e_id = '$id' AND is_deleted != '1'");
                $chk2->execute();
                if($chk2->rowCount() > 0) 
                {
                    $response = array('status' => 'RFID already exists');
                } else {
                    $username = strtolower($fname);

                    $sql2 = $conn->prepare("INSERT INTO bs_user (e_id, id_num, firstname, middlename, lastname, username, password, pass_text, title, access_level, date_added, added_by)
                                                        VALUES ('$id', '$e_id', '$fname', '$mname', '$lname', '$username', md5('1234'), '1234', 'Staff', '3', '$today_date1', '1116')");
                    $sql2->execute();

                    $id1 = $conn->lastInsertId();
                    $uid1 = md5($id1);

                    $up1 = $conn->prepare("UPDATE bs_user SET uid = '$uid1' WHERE user_id = '$id1'");
                    $up1->execute();

                    $name = $lname . ', ' . $fname . ' ' . $mname;
                    $response = array('status' => 'Successfully Register', 'name' => $name, 'rfid' => $rfid, 'byte' => $byte);
                }
            }
        }
    } else {
        $response = array('status' => 'Invalid Entry');
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}

/*
    Log Attendance
*/
function log_data()
{
	include '../global-library/database.php';

    if(isset($_POST['e_id']) && isset($_POST['latitude']) && isset($_POST['longitude']) && isset($_POST['is_log']) && isset($_POST['time']) && isset($_POST['date']))
    {
        $e_id = $_POST['e_id'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $is_log = $_POST['is_log']; // 0 = Login | 1 = Logout
        $time = $_POST['time'];
        $date = $_POST['date'];

            $datetime = $date . ' ' . $time;

            $chk = $conn->prepare("SELECT * FROM tbl_attendance WHERE id_num = '$e_id' AND latitude = '$latitude' AND longitude = '$longitude' AND a_date = '$date' AND a_time = '$time' AND a_datetime = '$datetime' AND is_log = '$is_log' AND is_deleted != '1'");
            $chk->execute();
            if($chk->rowCount() > 0){} else {
                $sql = $conn->prepare("INSERT INTO tbl_attendance (id_num, latitude, longitude, a_date, a_time, a_datetime, is_log) VALUES ('$e_id', '$latitude', '$longitude', '$date', '$time', '$datetime', '$is_log')");
                $sql->execute();
            }
    } else {}
}

/*
    Check User Register
*/
function get_emp_details_data()
{
    include '../global-library/database.php';

            $sql = $conn->prepare("SELECT * FROM sa_employeeDetails WHERE is_sent != '1'");
            $sql->execute();

            $response = array();

            if($sql->rowCount() > 0){
                while($sql_data = $sql->fetch())
                {
                    $id_num = $sql_data['id_num'];
                    $latitude = $sql_data['latitude'];
                    $longitude = $sql_data['longitude'];
                    $fname = $sql_data['fname'];
                    $mname = $sql_data['mname'];
                    $lname = $sql_data['lname'];
                    $rfid = $sql_data['rfid'];
                    $byte = $sql_data['byte'];
                    $is_rfid = $sql_data['is_rfid'];
    
                    $element = array('e_id' => $id_num, 'latitude' => $latitude, 'longitude' => $longitude, 'fname' => $fname, 'mname' => $mname, 'lname' => $lname, 'rfid' => $rfid, 'byte' => $byte, 'is_rfid' => $is_rfid);

                    $response[] = $element;
                }
            } else {
                $response = array('status' => 'No records found');
            }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}

/*
    Sync Login Data
*/
function sync_login_data()
{
    include '../global-library/database.php';

    $key = $_POST['key'];
    $hrs = $_POST['last_sync'];

    if($key == "Gerson")
    {
        $chk = $conn->prepare("SELECT * FROM tbl_attendance WHERE is_deleted != '1' ORDER BY a_datetime DESC LIMIT 1");
        $chk->execute();
        $chk_data = $chk->fetch();
            $aDateTime = $chk_data['a_datetime'];
            $lastSync = date('Y-m-d H:i:s', strtotime($aDateTime. '-' . $hrs . ' hours'));

            $sql = $conn->prepare("SELECT * FROM tbl_attendance WHERE (a_datetime BETWEEN :lastSync AND :aDateTime) AND is_deleted != '1' ORDER BY a_datetime DESC");
            $sql->bindParam(':lastSync', $lastSync, PDO::PARAM_STR);
            $sql->bindParam(':aDateTime', $aDateTime, PDO::PARAM_STR);
            $sql->execute();

        $response = array();

        if($sql->rowCount() > 0){
            while($sql_data = $sql->fetch())
            {
                $e_id = $sql_data['id_num'];
                $a_date = $sql_data['a_date'];
                $a_time = $sql_data['a_time'];
                $latitude = $sql_data['latitude'];
                $longitude = $sql_data['longitude'];
                $is_log = $sql_data['is_log'];

                $element = array('e_id' => $e_id, 'date' => $a_date, 'time' => $a_time, 'latitude' => $latitude, 'longitude' => $longitude, 'is_log' => $is_log);

                $response[] = $element;
            }
        } else {
            $response = array('status' => 'No records found');
        }
    } else {
        $response = array('status' => 'Invalid Key');
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}


/*
    Log Universal Attendance System Pitoy
*/
function log_universal_data()
{
	include '../global-library/database.php';


    function validatePostData($fields) {
        foreach ($fields as $field) {
            if (!isset($_POST[$field])) {
                return false;
            }
        }
        return true;
    }

    function insertAttendanceRecord($conn, $e_id, $latitude, $longitude, $date, $time, $datetime,
    $s1_timeIn, $s1_breakOut, $s1_breakIn, $s1_lunchOut, $s2_timeIn, $s2_breakOut, $s2_breakIn, $s2_timeOut)
    {
        $sql = $conn->prepare("INSERT INTO tbl_attendance_universal (id_num, latitude, longitude, a_date, a_time, a_datetime, 
        s1_timeIn, s1_breakOut, s1_breakIn, s1_lunchOut, s2_timeIn, s2_breakOut, s2_breakIn, s2_timeOut) VALUES (?, ?, ?, ?, ?, ?,     ?, ? , ? , ? , ? , ?, ?, ?)");
        
        $sql->execute([$e_id, $latitude, $longitude, $date, $time, $datetime, 
        $s1_timeIn, $s1_breakOut, $s1_breakIn, $s1_lunchOut, $s2_timeIn, $s2_breakOut, $s2_breakIn, $s2_timeOut]);
    }
    
    
    $inputFields = ['e_id', 'latitude', 'longitude', 'is_log', 'time', 'date', 's1_timeIn', 's1_breakOut', 's1_breakIn', 's1_timeOut', 's2_timeIn', 's2_breakOut', 's2_breakIn', 's2_timeOut'];
    

    if (validateInput($inputFields)) {
        $e_id = $_POST['e_id'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $is_log = $_POST['is_log']; // 0 = Login | 1 = Logout
        $time = $_POST['time'];
        $date = $_POST['date'];
        $s1_timeIn = $_POST['s1_timeIn'];
        $s1_breakOut = $_POST['s1_breakOut'];
        $s1_breakIn = $_POST['s1_breakIn'];
        $s1_lunchOut = $_POST['s1_lunchOut'];

        $s2_timeIn = $_POST['s2_timeIn'];   
        $s2_breakOut = $_POST['s2_breakOut'];
        $s2_breakIn = $_POST['s2_breakIn'];
        $s2_timeOut = $_POST['s2_timeOut'];

        $datetime = $date . ' ' . $time;
    
        // Use prepared statements to prevent SQL injection
        $chk = $conn->prepare("SELECT * FROM tbl_attendance WHERE id_num = ? AND latitude = ? AND longitude = ? AND a_date = ? AND a_time = ? AND a_datetime = ? AND s1_timeIn AND s1_breakOut AND s1_breakIn AND s1_lunchOut AND s2_timeIn AND s2_breakOut AND s2_breakIn AND s2_timeOut AND is_deleted != '1'");
        
        $chk->execute([$e_id, $latitude, $longitude, $date, $time, $datetime,
        
        $s1_timeIn, $s1_breakOut, $s1_breakIn, $s1_lunchOut,
        $s2_timeIn, $s2_breakOut, $s2_breakIn, $s2_timeOut]
    );
    
        if ($chk->rowCount() == 0) {
            insertAttendanceRecord($conn, $e_id, $latitude, $longitude, $is_log, $date, $time, $datetime, $s1_timeIn, $s1_breakOut, $s1_breakIn, $s1_lunchOut, $s2_timeIn, $s2_breakOut, $s2_breakIn, $s2_timeOut);
        }
    }

}

?>