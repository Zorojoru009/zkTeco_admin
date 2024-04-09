<?php
require_once 'global-library/config.php';
require_once 'include/functions.php';

$errorMessage = '&nbsp;';


if (isset($_POST['txtUserName'])) {
	$result = doLogin();

	if ($result != '') {
		$errorMessage = $result;
	}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
<title><?php echo $sett_data['system_title']; ?> - Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="Lending System - www.tridentechnology.com" name="description" />
<meta content="Coderthemes" name="author" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['admin_dir'] . '/include/global-css.php'); ?>
<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/include/misc-js.php'); ?>	

    </head>

    <body class="loading authentication-bg authentication-bg-pattern">

        <div class="account-pages my-5">
            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="text-center">   
                            <a href="#">
                                <!-- <img src="../assets/images/logo-dark.png" alt="" height="22" class="mx-auto"> -->
								<h1> <img src="<?php echo WEB_ROOT; ?>assets/images/trams-logo.png" alt="user-img" title="" height="60%" width="60%"></h1>
                            </a>
                            <!-- <p class="text-muted mt-2 mb-4">Lending</p> -->

                        </div>
                        <div class="card">
                            <div class="card-body p-4">
                                
                                <div class="text-center mb-4">
                                    <h4 class="text-uppercase mt-0">Sign In</h4>
                                </div>
							<?php
								if($errorMessage == 'Updated successfully.')
								{
							?>
								<div class="alert alert-success alert-dismissible fade show" role="alert">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									<i class="mdi mdi-check-all me-2"></i> <strong><?php echo $errorMessage; ?></strong>
								</div>
							<?php
								}
								else if($errorMessage == 'Incorrect username or password.')
								{
							?>	
								<div class="alert alert-danger alert-dismissible fade show" role="alert">
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									<i class="mdi mdi-block-helper me-2"></i> <strong><?php echo $errorMessage; ?></strong>
								</div>
							<?php								
								} else {}
							?>
                                <form id="loginform" name="frmLogin" method="post">
                                    <div class="mb-3">
                                        <label for="emailaddress" class="form-label">Username</label>
                                        <input class="form-control" type="rext" name="txtUserName" id="txtUserName" autocomplete=off required="" placeholder="Enter your username">
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input class="form-control" type="password" required="" name="txtPassword" id="txtPassword" autocomplete=off placeholder="Enter your password">
                                    </div>
									
									<!--
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                            <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                        </div>
                                    </div>
									-->

                                    <div class="mb-3 d-grid text-center">
                                        <button class="btn btn-primary" type="submit"> Log In </button>
                                    </div>
                                </form>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->
						
						<!--
                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p> <a href="pages-recoverpw.html" class="text-muted ms-1"><i class="fa fa-lock me-1"></i>Forgot your password?</a></p>
                                <p class="text-muted">Don't have an account? <a href="pages-register.html" class="text-dark ms-1"><b>Sign Up</b></a></p>
                            </div>
                        </div>
                        -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['admin_dir'] . '/include/global-js.php'); ?>
        
    </body>
</html>