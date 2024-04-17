<script>
    
function setFeedback(result) {
    // Log for debugging
    // console.log("setFeedback called with result:", result);

    // Set feedback based on result
    if (result == 0) {
        console.log("Setting feedback to 'success'");
        sessionStorage.setItem("dc_feedback", "success");
    } else {
        console.log("Setting feedback to 'error'");
        sessionStorage.setItem("dc_feedback", "error");
    }
}

function setFeedbackRequest(result) {
    // Log for debugging
    // console.log("setFeedback called with result:", result);

    // Set feedback based on result
    if (result == 0) {
        console.log("Setting feedback to 'success'");
        sessionStorage.setItem("rq_feedback", "success");
    } else {
        console.log("Setting feedback to 'error'");
        sessionStorage.setItem("rq_feedback", "error");
    }
}
console.log("running");
</script>

<?php
include '../global-library/include.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve POST variables
    $action = isset($_POST['action']) ? $_POST['action'] : null;

    // Process the received data
    // For example, print the values
    switch($action) {
        case 'connect_device':
            connect_device();
            break;
        case 'connect_device_request':
            connect_device_request();
    }
} else {
    // Handle the case when no form data is submitted
    echo "No form data submitted";
}

function connect_device() {
    $web_root = WEB_ROOT;
    // connect device
    function errorHandler($severity, $message, $file, $line) {
        throw new ErrorException($message, 0, $severity, $file, $line);
    }

    // Set custom error handler
    set_error_handler('errorHandler');

    try {
        // Your code that may throw warnings or notices
        $zk = new ZKLibrary('192.168.1.31', 4370, 'TCP');
        echo 'Library Loaded<br>';
        echo 'Requesting connection<br>';
        $zk->connect();
        echo 'Connected<br>';

        // JavaScript code to set feedback
        echo '<script>setFeedback(0);</script>';
        echo '<script>window.onload = function() {
            console.log("JavaScript code executed");
            window.location.href = "' . $web_root . 'include/template.php";
        }</script>';
    } catch (Throwable $e) {
        // Code to handle Throwable
        echo 'Caught Throwable: ' . $e->getMessage() . '<br>';

        // JavaScript code to set feedback
        echo '<script>setFeedback(1);</script>';
        echo '<script>window.onload = function() {
            console.log("JavaScript code executed");
            window.location.href = "' . $web_root . 'include/template.php";
        }</script>';
    }
}


function connect_device_request() {
    $web_root = WEB_ROOT;
    $requester_path = isset($_POST['requester_path']) ? $_POST['requester_path'] : null;
    // connect device
   
    function errorHandler($severity, $message, $file, $line) {
        throw new ErrorException($message, 0, $severity, $file, $line);
    }

    // Set custom error handler
    set_error_handler('errorHandler');

    try {
        // Your code that may throw warnings or notices
        $zk = new ZKLibrary('192.168.0.31', 4370, 'TCP');
        echo 'Library Loaded<br>';
        echo 'Requesting connection<br>';
        $zk->connect();
        echo 'Connected<br>';

        // JavaScript code to set feedback
        echo '<script>setFeedbackRequest(0);</script>';
        echo '<script>window.onload = function() {
            console.log("JavaScript code executed");
            // window.location.href = "' . $requester_path . '";
        }</script>';
        
    } catch (Throwable $e) {
        // Code to handle Throwable
        echo 'Caught Throwable: ' . $e->getMessage() . '<br>';
        echo $requester_path;
        // JavaScript code to set feedback
        echo '<script>setFeedbackRequest(1);</script>';
        echo '<script>window.onload = function() {
            console.log("JavaScript code executed");
            // window.location.href = "' . $requester_path . '";
        }</script>';
        
    }
    
}
?>