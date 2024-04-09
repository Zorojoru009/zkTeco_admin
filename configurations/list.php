<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}

$feedbackMessage = (isset($_GET['feedbackMessage']) && $_GET['feedbackMessage'] != '') ? $_GET['feedbackMessage'] : '&nbsp;';

function openModalPHP($type){
    echo "<script>
    function openModal(type) {
        $(document).ready(function() {
            // Show the modal when the document is ready
            $('#success-alert-modal').modal('show');
           
            var headingElement = document.querySelector('#success-alert-modal h4');
            var paragraphElement = document.querySelector('#success-alert-modal p');

            if(type == 1){
                headingElement.textContent = 'API Successfully Changed';
                paragraphElement.textContent = '';
            } else {
                headingElement.textContent = 'Branch Number Successfully Changed';
                paragraphElement.textContent = '';
            }
        });
    }
    
    openModal($type);
    </script>";
}


if($feedbackMessage == "changeBranchNumberSuccess"){
    openModalPHP(2);
} elseif($feedbackMessage == "changeApiSuccess"){
    openModalPHP(1);
} else {
    // Handle other cases here if needed
}
?>


<style rel="stylesheet">
td {
    vertical-align: super;
}
</style>
<div class="card">

    <div class="card-body">
        <div class="mb-3 col-lg-12" style="text-align:center">

            <div class="mb-3 col-lg-6 " style="text-align:center">
                <form method="post" action="process.php?action=branchNumber">
                    <label for="branchnumber" class="form-label">Branch Number</label>
                    <br>
                    <input class=" form-control" id="branchnumber" type="number" name="branchNumber"
                        style="text-align:center">
                    <br />
                    <button type="submit" class="btn btn-success waves-effect waves-light">Set Branch Number</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <form method="post" action="process.php?action=changeApi">
                    <label for="simpleinput" class="form-label col-lg-12" style="text-align:center;">Application
                        Programming Interface</label>

                    <div class="grid-container">
                        <input type="text" name="api" id="simpleinput" class="form-control">
                    </div>
                    <div class="col-lg-12" style="text-align: center;">
                        <br />
                        <button type="submit" class="btn btn-danger waves-effect waves-light">Change API</button>
                </form>
            </div>

            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                data-bs-target="#success-alert-modal">Success Alert</button>

            <div id="success-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content modal-filled bg-success">
                        <div class="modal-body">
                            <div class="text-center">
                                <i class="dripicons-checkmark h1 text-white"></i>
                                <h4 class="mt-2 text-white">Well Done!</h4>
                                <p class="mt-3 text-white"></p>
                                <button type="button" class="btn btn-light my-2"
                                    data-bs-dismiss="modal">Continue</button>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

        </div>

    </div>



</div>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->