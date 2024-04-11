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
            } if (type == 2) {
                headingElement.textContent = 'Branch Number Successfully Changed';
                paragraphElement.textContent = '';
            } else if(type == 3){
                headingElement.textContent = 'Branch Location Successfully Changed';
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
} elseif($feedbackMessage == "changeBranchLocationSuccess"){
    openModalPHP(3);
} else {
    // Handle other cases here if needed
}
?>

<style rel="stylesheet">
/* Add your custom styles here */
td {
    vertical-align: super;
}
</style>

<div class="card">
    <div class="card-body">
        <div class="row" style="text-align:center;">
            <!-- Form to set branch number -->
            <div class="col-lg-6 mb-3">
                <form method="post" action="process.php?action=branchNumber" style="text-align:center;">
                    <label for="branchnumber" class="form-label">Set Branch Number</label>
                    <br>
                    <input  style="text-align:center" class="form-control" value="<?php 
                            $branch = $conn->prepare("SELECT * FROM bs_config WHERE il_id = '1'");
                            $branch->execute();
                            $branch_data = $branch->fetch();
                            echo $branch_data['branch_number'];
                    ?>" id="branchnumber" type="number" name="branchNumber">
                    <br>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
            
            <!-- Display branch number -->
            <div class="col-lg-6 mb-3">
                <p>Branch Number:
                    <br>
                <?php
                    echo $branch_data['branch_number'];
                ?>
                </p>
            </div>
        </div>
        
        <div class="row" style="text-align:center;">
            <!-- Form to change API -->
            <div class="col-lg-6 mb-3">
                <form method="post" action="process.php?action=changeApi" style="text-align:center;">
                    <label for="simpleinput" class="form-label">Change API</label>
                    <br>
                    <input style="text-align:center" type="text" value="<?php 
                      echo $branch_data['api'];
                    ?>" name="api" id="simpleinput" class="form-control">
                    <br>
                    <button type="submit" class="btn btn-danger">Submit</button>
                </form>
            </div>
            
            <!-- Display branch number again -->
            <div class="col-lg-6 mb-3">
                <p>API:
                    <br/>
                <?php
                  
                    echo $branch_data['api'];
                ?>
                </p>
            </div>
        </div>
        <div class="row" style="text-align:center;">

            <div class="col-lg-6 mb-3" >
            <form method="post" action="process.php?action=branchLocation" style="text-align:center;">
                    <label for="branchLocation" class="form-label">Set Branch Location</label>
                    <br>
                    <input value="<?php echo $branch_data['branch_location'];
                    ?>" class="form-control" id="branchLocation" type="text"style="text-align:center;" name="branchLocation">
                    <br>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>

            <div class="col-lg-6 mb-3">
                <p>Branch Location:
                    <br>
                <?php
                    echo $branch_data['branch_location'];
                ?>
                </p>
            </div>
        <hr>
    </div>
   

    <!-- Modal -->
    <div id="success-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content modal-filled bg-success">
                <div class="modal-body">
                    <div class="text-center">
                        <i class="dripicons-checkmark h1 text-white"></i>
                        <h4 class="mt-2 text-white">Well Done!</h4>
                        <p class="mt-3 text-white"></p>
                        <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">Continue</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>

<!-- jQuery -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
