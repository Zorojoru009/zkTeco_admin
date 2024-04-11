<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}
//querying the bs user count data
$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
$getUserCount = $conn->prepare("SELECT * FROM bs_user_count WHERE sl_id='1'");
$getUserCount->execute();
$getUserCount_data = $getUserCount->fetch();
// querying the bs_config data
$getConfig = $conn->prepare("SELECT * FROM bs_config WHERE il_id='1'");
$getConfig->execute();
$getConfig_data = $getConfig->fetch();

// getting the needed info for generating a user ID

$branch_number = $getConfig_data['branch_number'];
$user_count = $getUserCount_data['user_count'];
$currentYear = date('Y');
// echo $branch_number; echo $currentYear;echo $user_count;

$user_id = $branch_number . $currentYear . $user_count;
$user_id_display =  $branch_number .'-'. $currentYear .'-'. $user_count;
$currentPath = $_SERVER['REQUEST_URI'];
// echo $currentPath;
?>


<div class="col-xl-6" style="margin: auto">
    <div class="card">
        <div class="card-body">

            <h4 class="header-title mb-3"> Add User</h4>

            <div id="rootwizard">

                <ul class="nav nav-pills bg-light nav-justified form-wizard-header mb-3" style="display: none">
                    <li class="nav-item">
                        <a id="warning" class="nav-link rounded-0 pt-2 pb-2" style="background-color: red">
                            <span class="d-none d-sm-inline" style="color:white">Device is not connected. You cannot add
                                a user. Please make sure your device is connected to LAN CABLE.</span>
                        </a>
                    </li>
                </ul>

                <!-- <form style="display: none;" id="connectFormRequest" method="post"
                    action="<?php echo WEB_ROOT; ?>attendance_device_functions/device_service.php">
                    <input type="hidden" name="action" value="connect_device_request">
                  
                </form> -->

                <ul class="nav nav-pills bg-light nav-justified form-wizard-header mb-3">

                    <li class="nav-item" data-target-form="#profileForm">
                        <a id="profileLink" href="#second" data-bs-toggle="tab" data-toggle="tab"
                            class="nav-link rounded-0 pt-2 pb-2">
                            <i class="mdi mdi-face-profile me-1"></i>
                            <span class="d-none d-sm-inline">Profile</span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content mb-0 b-0 pt-0">
                    <div class="tab-pane fade" id="second">
                        <form id="profileForm" method="post" action="process.php?action=add" class="form-horizontal">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label" for="name3">User ID</label>
                                        <div class="col-md-9">
                                            <input type="text" id="name3" name="uid" value="<?php echo $user_id; ?>"
                                                class="form-control" required readonly
                                                style="background-color: #f0f0f0;">

                                        </div>
                                    </div>

                                    <input type="hidden" name="requester_path" value="<?php echo $currentPath;?>">
                                    <input type="hidden" name="requester_path" value="<?php echo $user_count;?>">

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label" for="fname"> First name</label>
                                        <div class="col-md-9">
                                            <input type="text" id="fname" name="fname" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label" for="mname"> Middle name</label>
                                        <div class="col-md-9">
                                            <input type="text" id="mname" name="mname" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label" for="lname"> Last name</label>
                                        <div class="col-md-9">
                                            <input type="text" id="surname3" name="lname" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="col-md-3 col-form-label" for="roles"> Role</label>
                                        <div class="col-md-9">
                                            <select class="form-select" name="role" id="roles">
                                                <option selected value="4">Staff</option>
                                                <!-- <option value="8">Staff</option> -->
                                                <!-- <option value="10">Three</option>
													<option value="14">Three</option> -->
                                            </select>
                                        </div>
                                    </div>


                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </form>
                    </div>

                    <div class="tab-pane fade" id="third">
                        <form id="otherForm" method="post" action="#" class="form-horizontal">
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-center">
                                        <h2 class="mt-0">
                                            <i class="mdi mdi-check-all"></i>
                                        </h2>
                                        <h3 class="mt-0">Thank you !</h3>

                                        <p class="w-75 mb-2 mx-auto">Quisque nec turpis at urna dictum luctus.
                                            Suspendisse convallis dignissim eros at volutpat. In egestas mattis
                                            dui. Aliquam mattis dictum aliquet.</p>

                                        <div class="mb-3">
                                            <div class="form-check d-inline-block">
                                                <input type="checkbox" class="form-check-input" id="customCheck4"
                                                    required>
                                                <label class="form-check-label" for="customCheck4">I agree with the
                                                    Terms and Conditions</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </form>
                    </div>

                    <ul class="list-inline wizard mb-0">
                        <li class="previous list-inline-item"><a href="javascript: void(0);"
                                class="btn btn-secondary">Previous</a>
                        </li>

                        <li class="next list-inline-item float-end"><a href="javascript: submitForm();"
                                class="btn btn-success waves-effect waves-light">Next</a></li>
                    </ul>



                </div> <!-- tab-content -->
            </div> <!-- end #rootwizard-->

        </div> <!-- end card-body -->
    </div> <!-- end card-->
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Wait for the document to be fully loaded
    var link = document.getElementById("profileLink");
    // Simulate a click on the anchor element with id "profileLink"
    link.click();

    // Add an event listener to the anchor element inside an element with class "next"
    // When clicked, it calls the submitForm function
    document.querySelector(".next a").addEventListener("click", function() {
        submitForm();
    });

    // Add an event listener to the form with id "connectFormRequest"
    // When submitted, it prevents the default form submission behavior,
    // Serializes form data, and sends an AJAX request to the specified URL

    // Call the submitFormRequest function
});

// Function to submit form immediately

// Function to submit the form with id "profileForm"
function submitForm() {
    // Get the form element
    var form = document.getElementById("profileForm");
    // Submit the form
    form.submit();
}
</script>