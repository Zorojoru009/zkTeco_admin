<?php
if (!defined('WEB_ROOT')) {
	header('Location: ../index.php');
	exit;
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

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
                <form method="post" action="process.php">
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
            <div id="success-alert-modal" class="modal fade show" tabindex="-1" style="display: none;"
                aria-modal="true" role="dialog">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content modal-filled bg-success">
                        <div class="modal-body">
                            <div class="text-center">
                                <i class="dripicons-checkmark h1 text-white"></i>
                                <h4 class="mt-2 text-white">Well Done!</h4>
                                <p class="mt-3 text-white">Cras mattis consectetur purus sit amet fermentum. Cras justo
                                    odio, dapibus ac facilisis in, egestas eget quam.</p>
                                <button type="button" class="btn btn-light my-2"
                                    data-bs-dismiss="modal">Continue</button>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
        </div>

    </div>

</div>



</div>

<script>
function runProcess() {
    // Create a new script element
    var script = document.createElement('script');

    // Set the source attribute to process.php
    script.src = 'process.php';

    // Append the script element to the body
    document.body.appendChild(script);
}
</script>