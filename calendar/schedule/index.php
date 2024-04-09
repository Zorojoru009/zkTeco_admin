<?php
require_once '../../global-library/config.php';
require_once '../../include/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$dataId = $_GET['id'];

$sql = "SELECT * FROM tr_schedule WHERE emp_id = '$dataId'";

$req = $conn->prepare($sql);
$req->execute();

$events = $req->fetchAll();


		$rec = $conn->prepare("SELECT * FROM bs_employee WHERE e_id = '$dataId'");
		$rec->execute();
		$rec_data = $rec->fetch();
		
		if ($rec_data['image']) {
			$image = WEB_ROOT . 'assets/images/employee/' . $rec_data['image'];
		} else {
			$image = WEB_ROOT . 'assets/images/employee/noimage.png';
		}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $sett_data['system_title']; ?></title>

	<link rel="shortcut icon" href="<?php echo WEB_ROOT; ?>assets/images/favicon.ico">

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo WEB_ROOT; ?>calendar/schedule/css/bootstrap.min.css" rel="stylesheet">

	<!-- FullCalendar -->
	<link href='<?php echo WEB_ROOT; ?>calendar/schedule/css/fullcalendar.css' rel='stylesheet' />


    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
	#calendar {
		max-width: 800px;
	}
	.col-centered{
		float: none;
		margin: 0 auto;
	}
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="background-color: #272c33;">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header" style="width: 100%; background-color: #272c33;">
				<div class="row">
					<div class="col-lg-4" style="height: 65px; padding: 14px;">
						<a type="button" class="btn btn-default" href="<?php echo WEB_ROOT; ?>employee/index.php">Cancel</a>
					</div>
					<div class="col-lg-4">
						<center><h3 style="color:#ffffff;">Employee Schedule</h3></center>
					</div>
					<div class="col-lg-4" style="">
					</div>
				</div>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <!--<ul class="nav navbar-nav">
                    <li>
                        <a href="#">Menu</a>
                    </li>
                </ul>!-->
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

	<style>
		.avatar {
			vertical-align: middle;
			width: 100px;
			height: 100px;
			border-radius: 50%;
			object-fit: cover;
		}
	</style>

    <!-- Page Content -->
    <div class="container">
		<center>
			<img src="<?php echo $image; ?>" class="avatar" />
			<h3 style="color:#000000;"><?php echo $rec_data['e_lname']; ?>, <?php echo $rec_data['e_fname']; ?></h3>
		</center>
		<br />
        <div class="row">
            <div class="col-lg-12 text-center">				                          
                <div id="calendar" class="col-centered">
					<br />
					<a type="button" class="btn btn-default" href="<?php echo WEB_ROOT; ?>employee/index.php">Cancel</a>
                </div>
            </div>

        </div>
        <!-- /.row -->

		<!-- Modal -->
		<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			<form class="form-horizontal" method="POST" action="addEvent.php">

			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Schedule</h4>
			  </div>
			  <div class="modal-body">

				  <div class="form-group">
					<label for="title" class="col-sm-2 control-label">Type</label>
					<div class="col-sm-10">
						<label class="radio">
							<input type="radio" class="shift_type" name="title" id="optionsRadios2" value="s" checked="">
							1st Shift
						</label>	
						<label class="radio">
							<input type="radio" class="shift_type" name="title" id="optionsRadios2" value="b">
							2nd Shift
						</label>	
						<label class="radio">
							<input type="radio" class="shift_type" name="title" id="optionsRadios2" value="o">
							Off Duty
						</label>	
					</div>
				  </div>				 
				  
				  <div class="form-group" id="cctype1">
					<label for="start" class="col-sm-2 control-label">Start date</label>
					<div class="col-sm-10">
						<input type="text" name="start" class="form-control" id="start" autocomplete=off readonly /><br />
							<div class="col-sm-12 controls">
								<div class="col-sm-3">
									<label for="start">Time In</label>
								</div>
								<div class="col-sm-9">
									<select name="din1" style="width: 50px;">										
										<?php
											for($x1=0; $x1<=24; $x1++)
											{
												$cts1 = strlen($x1);
												if($cts1 != 2){ $y1 = 0 . $x1; }else{ $y1 = $x1; }
										?>
												<option value="<?php echo $y1; ?>"><?php echo $y1; ?></option>
										<?php } ?>
									</select>/hr
									  &nbsp;:&nbsp;							
									<select name="din2" style="width: 50px;">										
										<?php
											for($x2=0; $x2<=59; $x2++)
											{
												$cts2 = strlen($x2);
												if($cts2 != 2){ $y2 = 0 . $x2; }else{ $y2 = $x2; }
										?>
												<option value="<?php echo $y2; ?>"><?php echo $y2; ?></option>
										<?php } ?>
									</select>/min
								</div>
							</div>
							<div class="col-sm-12 controls">
								<div class="col-sm-3">
									<label for="start">Time Out</label>	
								</div>
								<div class="col-sm-9">								
									<select name="dout1" style="width:50px;">										
										<?php
											for($x3=0; $x3<=24; $x3++)
											{
												$cts3 = strlen($x3);
												if($cts3 != 2){ $y3 = 0 . $x3; }else{ $y3 = $x3; }
										?>
												<option value="<?php echo $y3; ?>"><?php echo $y3; ?></option>
										<?php } ?>
									</select>/hr
									  &nbsp;:&nbsp;
									<select name="dout2" style="width:50px;">										
										<?php
											for($x4=0; $x4<=59; $x4++)
											{
												$cts4 = strlen($x4);
												if($cts4 != 2){ $y4 = 0 . $x4; }else{ $y4 = $x4; }
										?>
												<option value="<?php echo $y4; ?>"><?php echo $y4; ?></option>
										<?php } ?>
									</select>/min
								</div>
							</div>
					</div>
				  </div>				  				  
				  
				  <div class="form-group" style="display:none;">
					<label for="end" class="col-sm-2 control-label">End date</label>
					<div class="col-sm-10">
					  <input type="text" name="end" class="form-control" id="end" autocomplete=off readonly />
					</div>
				  </div>

			  </div>
			  <div class="modal-footer">
				<input type="hidden" name="id" value="<?php echo $dataId; ?>" />
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success">Save changes</button>
			  </div>
			</form>
			</div>
		  </div>
		</div>



		<!-- Modal -->
		<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			<form class="form-horizontal" method="POST" action="deleteEventDate.php">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Delete Schedule</h4>
			  </div>
			  <div class="modal-body">

				  <div class="form-group" style="display:none;">
					<label for="title" class="col-sm-2 control-label">Title</label>
					<div class="col-sm-10">
					  <input type="text" name="title" class="form-control" id="title" placeholder="Title">
					</div>
				  </div>
				  
				    <div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						  <div class="checkbox">
							<h4>Are you sure? This process cannot be undone.</h4>
							<p>To proceed please check the box below.</p>
							<label class="text-danger"><input type="checkbox" name="delete">Delete Schedule</label>
						  </div>
						</div>
					</div>

				  <input type="hidden" name="id" class="form-control" id="id">


			  </div>

			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success">Save changes</button>
			  </div>
			</form>
			</div>
		  </div>
		</div>

    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="<?php echo WEB_ROOT; ?>calendar/schedule/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo WEB_ROOT; ?>calendar/schedule/js/bootstrap.min.js"></script>

	<!-- FullCalendar -->
	<script src='<?php echo WEB_ROOT; ?>calendar/schedule/js/moment.min.js'></script>
	<script src='<?php echo WEB_ROOT; ?>calendar/schedule/js/fullcalendar.min.js'></script>

	<script>

	$(document).ready(function() {

		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			// defaultDate: '2016-01-12',
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			selectable: true,
			selectHelper: true,
			select: function(start, end) {

				$('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
				$('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
				$('#ModalAdd').modal('show');
			},
			eventRender: function(event, element) {
				element.bind('dblclick', function() {
					$('#ModalEdit #id').val(event.id);
					$('#ModalEdit #title').val(event.title);
					$('#ModalEdit #color').val(event.color);
					$('#ModalEdit').modal('show');
				});
			},
			eventDrop: function(event, delta, revertFunc) { // si changement de position

				edit(event);

			},
			eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

				edit(event);

			},
			events: [
			<?php foreach($events as $event):

				$start = explode(" ", $event['start']);
				$end = explode(" ", $event['end']);
				if($start[1] == '00:00:00'){
					$start = $start[0];
				}else{
					$start = $event['start'];
				}
				if($end[1] == '00:00:00'){
					$end = $end[0];
				}else{
					$end = $event['end'];
				}
				
				if(($event['title'] == '1st Shift') || ($event['title'] == '2nd Shift') || ($event['title'] == 'Off Duty'))
				{ $timeIn = $event['time_in']; $timeOut = $event['time_out']; }else{ $timeIn = ""; $timeOut = ""; }
			?>
				{
					id: '<?php echo $event['ns_id']; ?>',
					title: '<?php echo $event['title']; ?> | <?php echo $timeIn; ?> - <?php echo $timeOut; ?>',
					start: '<?php echo $start; ?>',
					end: '<?php echo $end; ?>',
					color: '<?php echo $event['color']; ?>',
				},
			<?php endforeach; ?>
			]
		});

		function edit(event){
			start = event.start.format('YYYY-MM-DD HH:mm:ss');
			if(event.end){
				end = event.end.format('YYYY-MM-DD HH:mm:ss');
			}else{
				end = start;
			}

			id =  event.id;

			Event = [];
			Event[0] = id;
			Event[1] = start;
			Event[2] = end;

			$.ajax({
			 url: 'editEventDate.php',
			 type: "POST",
			 data: {Event:Event},
			 success: function(rep) {
					if(rep == 'OK'){
						alert('Saved');
					}else{
						alert('Could not be saved. try again.');
					}
				}
			});
		}

	});

</script>

<script type="text/javascript">

	$(".shift_type").click(function(){


		var value_checked = $(this).val();
		
		// Duty Option		
		if(value_checked == "s" || value_checked == "b"){
			$("#cctype1").show();			
		}
		else{
			$("#cctype1").hide();			
		}
		// Break Option
		if(value_checked == "b"){
			$("#cctype2").show();			
		}
		else{
			$("#cctype2").hide();		
		}
		
});

</script>

</body>

</html>
