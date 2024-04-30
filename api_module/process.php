    <?php


    // Check if the AJAX request contains the function name


    require_once '../global-library/config.php';
    require_once '../include/functions.php';
    include '../global-library/database.php';
    require_once '../global-library/include.php';

    $input = file_get_contents('php://input');

    // Decode the JSON data
    $data_post = json_decode($input, true);


    if (isset($data_post['action'])) {
        echo "action entered";

        // Call the PHP function based on the function name received
        switch ($data_post['action']) {

            case 'postAttendanceData':
                // Call your PHP function here
                $result = postAttendanceData(); // Assuming your_php_function() returns some result
                // Return the result
                echo json_encode($result); // You can encode the result in JSON format for better handling in JavaScript
                break;
            case 'getAttendance':
                // Call your PHP function here
                $result = getAttendance(); // Assuming your_php_function() returns some result
                    // Return the result
                echo json_encode($result); // You can encode the result in JSON format for better handling in JavaScript
                    break;
            
            case 'postUserData':
                echo 'postUser';
                // Call your PHP function here
                $result = postUserData(); // Assuming your_php_function() returns some result
                // Return the result
                echo json_encode($result); // You can encode the result in JSON format for better handling in JavaScript
                break;

            case 'initializeBranch':
                // Call your PHP function here
                $result = initializeBranch(); // Assuming your_php_function() returns some result
                // Return the result
                echo json_encode($result); // You can encode the result in JSON format for better handling in JavaScript
                break;
            // Add more cases if you have multiple PHP functions to call
            // case 'another_php_function_name':
            //     // Call another PHP function
            default:
                // Handle invalid function name
                echo "Invalid function name";
                break;
        }
    }else{
        print_r($data);
        echo "action else entered";
    }


    // Example PHP function

    function getAttendance() {
        require_once '../global-library/config.php';
        require_once '../include/functions.php';
        include '../global-library/database.php';
        require_once '../global-library/include.php';
        // Your PHP function code here 
        echo 'Library Loaded</br>';
    
        echo 'Requesting for connection</br>';
    
        echo 'Connected</br>';
        // $zk->testVoice();
        // $zk->setUser('', '12335', 'kevin', '', '4');    
        // $users = $zk->getUser();

        $zk = new ZKLibrary('192.168.1.205', 4370, 'UDP');
        $zk->connect();

        $users_attendance = $zk->getAttendance();
        echo "Get attendance Success";
        // $attendance_json = json_encode($users_attendance);

        foreach ($users_attendance as $attendance){
            $id_num = $attendance[1];
            $log_type = $attendance[2];
            $date = $attendance[3];
        
            // Prepare and execute the SELECT query with placeholders
            $check = $conn->prepare("SELECT * FROM tbl_attendance WHERE id_num = ? AND log_type = ? AND date_time = ?");
            $check->execute([$id_num, $log_type, $date]);
            $check_data = $check->fetch();
            // Check if any rows were returned
            if(!$check_data) { // If no rows returned
                // Prepare the INSERT query with placeholders
                $insertAttendance = $conn->prepare("INSERT INTO tbl_attendance (id_num, log_type, date_time) VALUES (?, ?, ?)");
            
                // Execute the INSERT query with values
                $insertAttendance->execute([$id_num, $log_type, $date]);
            }else{
                echo "exists";
            }
        }
        // print_r($users);
        // print_r($users_attendance);
        // DBService::saveUsersToDB($users);
        // $users = $zk->getUser();
    }


    
function postAttendanceData() {

require_once '../global-library/config.php';
require_once '../include/functions.php';
include '../global-library/database.php';
require_once '../global-library/include.php';
// Your PHP function code here 

       
// URL to which the POST request will be sent
$currentDateTime = date('Y-m-d H:i:s');
// Data to be sent in the POST request
// $get_attendance = $conn->prepare("SELECT * FROM tbl_attendance WHERE    ");
$oneWeekAgo = date('Y-m-d H:i:s', strtotime('-1 week'));

$get_attendance = $conn->prepare("SELECT * FROM tbl_attendance WHERE date_time >= :oneWeekAgo AND is_sent = '0'");
$get_attendance->bindParam(":oneWeekAgo", $oneWeekAgo, PDO::PARAM_STR);

// Execute the query
$get_attendance->execute(); 
$users_attendance = $get_attendance->fetchAll(PDO::FETCH_ASSOC);
$config = $conn->prepare("SELECT * FROM bs_config WHERE il_id = '1'");
$config->execute();
$config_data = $config->fetch();
$branch_number =  $config_data['branch_number'];
$url = $config_data['api'] . '/biometric/index.php';

if ($users_attendance) {
    // Fetch the results
    // Output data of each row
    foreach ($users_attendance as $attendance) {

        if($attendance['is_sent'] == 0){
            $id_num = $attendance['id_num'];
            $log_type = $attendance['log_type'];
            $date_time = $attendance['date_time'];
            $al_id = $attendance['al_id'];
            
            // Output your data here
            $data = array(
                'e_id' => $id_num,
                'log_type' => $log_type,
                'date_time' => $date_time,
                'branch_number' => $branch_number,
                'action' => 'log'
            );
            
            // Convert data array to query string format
            $data_query = http_build_query($data);
            
            // Set stream context options
            $options = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $data_query,
                ),
            );
            
            // Create stream context
            $context = stream_context_create($options);
            
            // Send POST request and capture the response
            $response = file_get_contents($url, false, $context);
            
            // Get the status code from the response headers
            $status_code = null;
            if (isset($http_response_header)) {
                foreach ($http_response_header as $header) {
                    if (preg_match('/^HTTP\/\d+\.\d+\s+(\d+)/', $header, $matches)) {
                        $status_code = intval($matches[1]);
                        break;
                    }
                }
            }
            
            // Process the response
            echo "Response status code: " . $status_code . "\n";
            echo "Response body: " . $response;
            if($status_code == 200){
                $is_sent = $conn->prepare("UPDATE tbl_attendance SET is_sent = '1' WHERE al_id = $al_id");
                $is_sent->execute();
                echo 'attendance sent';
            }else{
                echo "error";
            }
            

        }else{
            echo "already sent";
        }

    }
} else {
    echo "0 results";
}
    }


    function postUserData() {

        require_once '../global-library/config.php';
        require_once '../include/functions.php';
        include '../global-library/database.php';
        require_once '../global-library/include.php';
        
        // $zk = new ZKLibrary('192.168.1.205', 4370, 'TCP');
        // echo 'Library Loaded<br>';
        // echo 'Requesting connection<br>';
        // $zk->connect();
        // Your PHP function code here 
        // URL to which the POST request will be sent
        $currentDateTime = date('Y-m-d H:i:s');
        // Data to be sent in the POST request
        // $get_users = $conn->prepare("SELECT * FROM tbl_attendance WHERE    ");
        $oneWeekAgo = date('Y-m-d H:i:s', strtotime('-1 week'));
        
        $get_users = $conn->prepare("SELECT * FROM tbl_users WHERE date_time >= :oneWeekAgo AND is_sent = '0'");
$get_users->bindParam(":oneWeekAgo", $oneWeekAgo, PDO::PARAM_STR);
$get_users->execute();

        $all_users = $get_users->fetchAll(PDO::FETCH_ASSOC);
        $config = $conn->prepare("SELECT * FROM bs_config WHERE il_id = '1'");
        $config->execute();
        $config_data = $config->fetch();
        $branch_number =  $config_data['branch_number'];
        $url = $config_data['api'] . '/biometric/index.php';

        echo 'Connected<br>' .'<br> all users:';

        print_r($all_users);
        if ($all_users) {
            echo 'users sending';
            // Fetch the results
            // Output data of each row
            foreach ($all_users as $user) {
                echo 'user current :';
                print_r($user);
                $user_id = $user['user_id'];
                $fname = $user['first_name'];
                $mname = $user['middle_name'];
                $lname = $user['last_name'];
                $ul_id = $user['ul_id'];
                // $byte = $zk->getUserTemplateAll($user_id);
                echo 'BYTE';
                print_r($byte);
                $data = array(
                    'e_id' => $user_id,
                    'fname' => $fname,
                    'mname' => $mname,
                    'lname' => $lname,
                    'branch_number' => $branch_number,
                    // 'byte' => $byte,
                    'action' => 'register'
                );
                
                // Convert data array to query string format
                $data_query = http_build_query($data);
                
                // Set stream context options
                $options = array(
                    'http' => array(
                        'method' => 'POST',
                        'header' => 'Content-type: application/x-www-form-urlencoded',
                        'content' => $data_query,
                    ),
                );
                
                // Create stream context
                $context = stream_context_create($options);
                
                // Send POST request and capture the response
                $response = file_get_contents($url, false, $context);
                
                // Get the status code from the response headers
                $status_code = null;
                
                if (isset($http_response_header)) {
                    foreach ($http_response_header as $header) {
                        if (preg_match('/^HTTP\/\d+\.\d+\s+(\d+)/', $header, $matches)) {
                            $status_code = intval($matches[1]);
                            break;
                        }
                    }
                }
                
                // Process the response
                echo "Response status code: " . $status_code . "\n";
                echo "Response body: " . $response;
                if($status_code == 200){
                    $is_sent = $conn->prepare("UPDATE tbl_users SET is_sent = '1' WHERE ul_id = $ul_id");
                    $is_sent->execute();
                    echo "sent thank you";
                }else{
                    echo "error";
                }
                
            }
        } else {
            echo "0 results";
        }
            }

         function initializeBranch(){
            
        require_once '../global-library/config.php';
        require_once '../include/functions.php';
        include '../global-library/database.php';
        require_once '../global-library/include.php';

                $config = $conn->prepare("SELECT * FROM bs_config WHERE il_id = '1'");
                $config->execute();
                $config_data = $config->fetch();
                $branch_number = $config_data['branch_number'];

                $data = array(
                );
                
                // Convert data array to query string format
                $data_query = http_build_query($data);
                
                // Set stream context options
                $options = array(
                    'http' => array(
                        'method' => 'POST',
                        'header' => 'Content-type: application/x-www-form-urlencoded',
                        'content' => $data_query,
                    ),
                );
                
                // Create stream context
                $context = stream_context_create($options);
                
                // Send POST request and capture the response
                $response = file_get_contents($url, false, $context);
                
                // Get the status code from the response headers
                $status_code = null;
                
                if (isset($http_response_header)) {
                    foreach ($http_response_header as $header) {
                        if (preg_match('/^HTTP\/\d+\.\d+\s+(\d+)/', $header, $matches)) {
                            $status_code = intval($matches[1]);
                            break;
                        }
                    }
                }
                
                // Process the response
                echo "Response status code: " . $status_code . "\n";
                echo "Response body: " . $response;
                if($status_code == 200){
                    $is_sent = $conn->prepare("UPDATE tbl_attendance SET is_sent = '1' WHERE al_id = $ul_id");
                }else{
                    echo "error";
                }

            }

    // function postAttendanceData() {
    //     // Your PHP function code here 
    //     echo 'Library Loaded</br>';
    
    //     echo 'Requesting for connection</br>';
    
    //     echo 'Connected</br>';
    //     // $zk->testVoice();
    //     // $zk->setUser('', '12335', 'kevin', '', '4');    

    //     // $users = $zk->getUser();

    //     $users_attendance = $zk->getAttendance();
    //     $attendance_json = json_encode($users_attendance);

    //     // print_r($users);
    //     echo "<br>";
    //     // print_r($users_attendance);
    //     // DBService::saveUsersToDB($users);
    //     // $users = $zk->getUser();

    //     echo "<script>
    //     const users_attendance =  JSON.parse('$attendance_json');
    //     users_attendance.forEach((attendance) => {
    //     var user_id = attendance[1]
    //     var type = attendance[2]
    //     var date = attendance[3]
    //         document.write('user_id: ' + user_id + '<br>');
    //         document.write('type: ' + type + '<br>');
    //         document.write('date: ' + date + '<br>'); // Added closing quotation mark and semicolon


    //         const data = {
    //             user_id: user_id,
    //             type : type,
    //             date : date,
    //             branch : '$branch_number'
    //             };
                
    //             // Options for the fetch request
    //             const options = {
    //             method: 'POST',
    //             headers: {
    //             'Content-Type': 'application/json' // Specify content type if sending JSON data
    //             },
    //             body: JSON.stringify(data) // Convert data to JSON string
    //             };
                
    //             // URL to which the data will be sent
    //             const url = '$api';
                
    //             // Make the fetch request
    //             fetch(url, options)
    //             .then(response => {
    //             if (!response.ok) {
    //             throw new Error('Network response was not ok');
    //             }
    //             return response.json(); // Parse the JSON response
    //             })
    //             .then(data => {
    //             // Handle the response data
    //             console.log('Response:', data);
    //             })
    //             .catch(error => {
    //             // Handle any errors
    //             console.error('Error:', error);
    //             });
                
            
    //     });
    //         </script>";
    // }
    ?>