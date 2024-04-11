<?php 

require_once '../global-library/config.php';
require_once '../include/functions.php';


checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
	
    case 'branchNumber' :
        changeBranchNumber();
        break;
		
	case 'changeApi' :
        changeApi();
        break;
        
    case 'branchLocation' :
        changeBranchLocation();
        break;
    
    case 'deleteImage' :

        break;
    
	   
    default :
        // if action is not defined or unknown
        // move to main category page
        // header('Location: index.php');
}

function changeBranchNumber(){
    include '../global-library/database.php';
    $branchNumber = $_POST['branchNumber'];

    $updateBranch = $conn->prepare("UPDATE bs_config SET branch_number = '$branchNumber' WHERE il_id = '1' ");
    $updateBranch->execute();
    header("location: index.php?feedbackMessage=changeBranchNumberSuccess");
}

function changeApi(){
    include '../global-library/database.php';
    $api = $_POST['api'];

    $updateApi = $conn->prepare("UPDATE bs_config SET api = '$api' WHERE il_id = '1' ");
    $updateApi->execute();

    header("location: index.php?feedbackMessage=changeApiSuccess");
}

function changeBranchLocation(){
    include '../global-library/database.php';
    $branch_location = $_POST['branchLocation'];

    $updateApi = $conn->prepare("UPDATE bs_config SET branch_location = '$branch_location' WHERE il_id = '1' ");
    $updateApi->execute();

    header("location: index.php?feedbackMessage=changeBranchLocationSuccess");
}



?>