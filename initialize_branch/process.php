<?php 

require_once '../global-library/config.php';
require_once '../include/functions.php';


checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
	
    case 'updateBranch' :
        updateBranch();
        break;
	   
    default :
        // if action is not defined or unknown
        // move to main category page
        // header('Location: index.php');
}

function updateBranch(){
    include '../global-library/database.php';

    $config = $conn->prepare("SELECT * FROM bs_config WHERE il_id = '1'");
    $config->execute();
    $config_data = $config->fetch();

    $url = $config_data['api'] . '/biometric/index.php';
    $branch_number = $config_data['branch_location'];
    $branch_location = $config_data['branch_location'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    
            // Output your data here
            $data = array(
                'branch_number' => $branch_number,
                'branch_location' => $branch_location,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'action' => 'branch_update'
            );
            
            // Convert data array to query string format
            $data_query = http_build_query($data);
            
            // Set stream context options
            $options = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $data_query,
                    'max_redirects' => 100,
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
                echo 'BRANCH STATUS UPDATED SUCCESSFULLY';
                // header("location: index.php?feedbackMessage=updateBranchSuccess");
            }else{
                // header("location: index.php?feedbackMessage=updateBranchFailed");
                echo "error";
            }
            

}
