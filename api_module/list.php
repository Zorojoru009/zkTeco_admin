<?php
if (!defined('WEB_ROOT')) {
    header('Location: ../index.php');
    exit;
}
$config= $conn->prepare("SELECT * FROM bs_config WHERE il_id = '1'");
$config->execute();
$config_data = $config->fetch();
$api = $config_data['api'];
$branch_number = $config_data['branch_number'];
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

// function callPostAttendance() {
//             $.ajax({
//                 url: 'process.php', // Path to your PHP script
//                 type: 'POST', // HTTP method
//                 data: {
//                     action: 'postAttendanceData', // Name of the PHP function you want to call
//                     // Add any parameters your PHP function requires, e.g., param1: 'value1', param2: 'value2'
//                 },
//                 success: function(response) {
//                     // Handle the response from the PHP function
//                     console.log(response);
//                 }
//             });
//         }
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
async function fetchData() {
    // Use XMLHttpRequest or fetch API to fetch updated data from the server
    // Update time elapsed
    updateTimeElapsed();
    // Update pulls count
    // Example:
    pulls++;
    updatePullsCount(pulls);
    await callPHPUser();
    await callPHPAttendance();
    await callPHPPostAttendance();
  //  await callPHPAttendance();
   // await callPHPPostAttendance();

    // Replace 5 with the actual count received from the server
}

async function callPHPAttendance() {
    console.log("callPHP CALLED");
    // Define the URL of the process.php script
    const url = 'process.php';

    // Define the data you want to send to the PHP script
    const data = {
        action: 'getAttendance'
    };

    // Make a POST request to process.php using the Fetch API
    fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json', // Specify the content type as JSON
            },
            body: JSON.stringify(data) // Convert data to JSON format
        })
        .then(response => {
            // Handle the response from process.php
            if (response.ok) {
                return response.text(); // Return response data as text
            }
            throw new Error('Network response was not ok.');
        })
        .then(responseText => {
            // Handle the response text
            console.log(responseText); // Log the response text
            
        })
        .catch(error => {
            // Handle any errors that occur during the fetch request
            console.error('Fetch error:', error);
        });

}

async function callPHPPostAttendance(){
    console.log("callPHP CALLED");
    // Define the URL of the process.php script
    const url = 'process.php';

    // Define the data you want to send to the PHP script
    const data = {
        action: 'postAttendanceData'
    };

    // Make a POST request to process.php using the Fetch API
    fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json', // Specify the content type as JSON
            },
            body: JSON.stringify(data) // Convert data to JSON format
        })
        .then(response => {
            // Handle the response from process.php
            if (response.ok) {
                return response.text(); // Return response data as text
            }
            throw new Error('Network response was not ok.');
        })
        .then(responseText => {
            // Handle the response text
            console.log(responseText); // Log the response text
            
        })
        .catch(error => {
            // Handle any errors that occur during the fetch request
            console.error('Fetch error:', error);
        });

}

async function callPHPUser(){
    console.log("callPHP CALLED");
    // Define the URL of the process.php script
    const url = 'process.php';

    // Define the data you want to send to the PHP script
    const data = {
        action: 'postUserData'
    };

    // Make a POST request to process.php using the Fetch API
    fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json', // Specify the content type as JSON
            },
            body: JSON.stringify(data) // Convert data to JSON format
        })
        .then(response => {
            // Handle the response from process.php
            if (response.ok) {
                return response.text(); // Return response data as text
            }
            throw new Error('Network response was not ok.');
        })
        .then(responseText => {
            // Handle the response text
            console.log(responseText); // Log the response text
            
        })
        .catch(error => {
            // Handle any errors that occur during the fetch request
            console.error('Fetch error:', error);
        });

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
        intervalId = setInterval(fetchData, 15000); // Fetch data every 1 second
    }
});
</script>