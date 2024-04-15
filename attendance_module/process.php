<?php

$zk = new ZKLibrary('192.168.1.205', 4370, 'TCP');
$zk->connect();
// Check if the AJAX request contains the function name
if (isset($_POST['action'])) {
    // Call the PHP function based on the function name received
    switch ($_POST['action']) {
        case 'postAttendanceData':
            // Call your PHP function here
            $result = postAttendanceData(); // Assuming your_php_function() returns some result
            // Return the result
            echo json_encode($result); // You can encode the result in JSON format for better handling in JavaScript
            break;
        // Add more cases if you have multiple PHP functions to call
        // case 'another_php_function_name':
        //     // Call another PHP function
        //     break;
        default:
            // Handle invalid function name
            echo "Invalid function name";
            break;
    }
}


// Example PHP function
function postAttendanceData() {
    // Your PHP function code here 
    echo 'Library Loaded</br>';
  
    echo 'Requesting for connection</br>';
   
    echo 'Connected</br>';
    // $zk->testVoice();
    // $zk->setUser('', '12335', 'kevin', '', '4');    

    // $users = $zk->getUser();

    $users_attendance = $zk->getAttendance();
    $attendance_json = json_encode($users_attendance);

    // print_r($users);
    echo "<br>";
    // print_r($users_attendance);
    // DBService::saveUsersToDB($users);
    // $users = $zk->getUser();

    echo "<script>
    const users_attendance =  JSON.parse('$attendance_json');
    users_attendance.forEach((attendance) => {
       var user_id = attendance[1]
       var type = attendance[2]
       var date = attendance[3]
        document.write('user_id: ' + user_id + '<br>');
        document.write('type: ' + type + '<br>');
        document.write('date: ' + date + '<br>'); // Added closing quotation mark and semicolon


        const data = {
            user_id: user_id,
            type : type,
            date : date,
            branch : '$branch_number'
            };
            
            // Options for the fetch request
            const options = {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json' // Specify content type if sending JSON data
            },
            body: JSON.stringify(data) // Convert data to JSON string
            };
            
            // URL to which the data will be sent
            const url = '$api';
            
            // Make the fetch request
            fetch(url, options)
            .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            return response.json(); // Parse the JSON response
            })
            .then(data => {
            // Handle the response data
            console.log('Response:', data);
            })
            .catch(error => {
            // Handle any errors
            console.error('Error:', error);
            });
            
        
    });
        </script>";
}
?>
