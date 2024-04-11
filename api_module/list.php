<?php
if (!defined('WEB_ROOT')) {
    header('Location: ../index.php');
    exit;
}
$config= $conn->prepare("SELECT * FROM bs_config WHERE il_id = '1'");
$config->execute();
$config_data = $config->fetch();
$api = $config_data['api'];
?>

<style rel="stylesheet">
/* Add your custom styles here */
td {
    vertical-align: super;
}
</style>

<div class="card">
    <div class="card-body">
        <div class="card card-body text-center">
            <h4 class="card-title">Run API Module</h4>
            <p class="card-text"> API: <?php echo $api; ?>.</p>
            <a href="#" class="btn btn-primary" id="runButton">RUN</a>
        </div>

        <div class="card card-body text-center" id="api_module_running" style="display: none">
            <h4 class="card-title">API Module Running </h4>
            <p class="card-text"> Time Elapsed: <span id="timeElapsed">0 seconds</span></p>
            <p class="card-text-pull"> Pulls: <span id="pulls">0</span></p>
        </div>
    </div>
</div>

<script>
var pulls = 0;
var startTime = null;
var intervalId = null; // Store interval ID

// Function to update time elapsed
function updateTimeElapsed() {
    if (!startTime) return; // If startTime is not set, return

    var currentTime = new Date().getTime();
    var elapsedTime = Math.floor((currentTime - startTime) / 1000); // Calculate elapsed time in seconds
    document.getElementById("timeElapsed").innerText = elapsedTime + " seconds";
}

// Function to update pulls count
function updatePullsCount(count) {
    document.getElementById("pulls").innerText = count;
}

// Function to periodically fetch data from the server
function fetchData() {
    // Use XMLHttpRequest or fetch API to fetch updated data from the server
    // Update time elapsed
    updateTimeElapsed();
    // Update pulls count
    // Example:
    pulls++;
    updatePullsCount(pulls); // Replace 5 with the actual count received from the server
}

// Event listener for run button click
document.getElementById("runButton").addEventListener("click", function() {
    // If interval is running, stop it; otherwise, start it
    var button = document.getElementById("runButton");
    if (intervalId) {
        clearInterval(intervalId); // Stop the interval
        intervalId = null; // Reset intervalId
        document.getElementById("api_module_running").style.display = "none"; // Hide API Module Running section
        document.getElementById("runButton").innerHTML = "RUN"; // Change button text back to "RUN"

        button.style = "background-color:  #71B6F9";
    } else {
        // Start fetching data periodically when run button is clicked
        button.style = "background-color: red";
        document.getElementById("api_module_running").style.display =
        "block"; // Show API Module Running section
        document.getElementById("runButton").innerHTML = "STOP"; // Change button text to "STOP"
        startTime = new Date().getTime(); // Set startTime when the button is clicked
        intervalId = setInterval(fetchData, 1000); // Fetch data every 1 second
    }
});
</script>
<?php

//API METHOD SAVE FOR TOMRORROW

// API endpoint URL
$apiUrl = $api;

// Data to be sent in the POST request
$postData = array(
    'key1' => 'value1',
    'key2' => 'value2'
);

// Create HTTP header
$options = array(
    'http' => array(
        'method' => 'POST',
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'content' => http_build_query($postData)
    )
);

// Create context
$context = stream_context_create($options);

// Send POST request and get response
$response = file_get_contents($apiUrl, false, $context);

// Check for errors
if ($response === false) {
    echo "Error: Unable to connect to API.";
} else {
    // Handle response
    echo "Response from API: " . $response;
}

?>
