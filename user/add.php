<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

?>


<div class="col-xl-6" style="margin: auto">
    <div class="card">
        <div class="card-body">

            <h4 class="header-title mb-3"> Add User</h4>

            <div id="rootwizard">
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
                                            <input type="text" id="name3" name="uid" value="" class="form-control"
                                                required readonly>
                                        </div>
                                    </div>
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

<script>
	
document.addEventListener("DOMContentLoaded", function() {
    var link = document.getElementById("profileLink");
    // Simulate a click on the anchor element
    link.click();
    
    // Function to submit form when Next button is clicked
    document.querySelector(".next a").addEventListener("click", function() {
        submitForm();
    });
});

function submitForm() {
    // Get the form element
    var form = document.getElementById("profileForm");

    // Submit the form
    form.submit();
}
</script>