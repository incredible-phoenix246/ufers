<?php
include("../ufers_con/ufers_con.php");
//get the number of cadets that have filled their forms
$gt_cdt=$mycon->prepare("SELECT * FROM cadet_bio WHERE temp_edit_status=:raw");
$gt_cdt->bindvalue(':raw', 'RAW', PDO::PARAM_STR);
$gt_cdt->execute();
echo $gt_cdt->rowCount();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
		<meta name="keywords" content="">
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>UFERS-ADMIN</title>
		
		
		<link rel="stylesheet" href="../bootstrap/css/style.css"/>
		<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="../bootstrap/font/css/font-awesome.css"/>		
		
		<script type="text/javascript" src="../bootstrap/js/jquery.js"></script>
		<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="../js/modal_activator.js"></script>
		<link rel="stylesheet" href="../css/my_styler.css"/>
		<style>
			#admin_no, #admin_pass{
				box-shadow: 5px 5px 5px #00008B;
				font-size:40px;
				height:60px;
				color:#228B22;
				background:#F8F8FF;
			}
		</style>
    </head>
	<body>
		<div class="container-fluid">
			<div class="main-content">
				<div class='container'>
					<div class="row">
						<div class='col-lg-12' style="margin-top:0px;" id="main_div">
							<div id="fp" class="col-lg-8 col-md-10 col-xs-10" style="">
								
							</div>
							
							<img src="../imgs/gen_logo.jpg" width="100%" />
							<?php 
								
							?>
							<p style="background:#000000;color:#F0FFF0;font-size:28px;">
								<marquee scrollamount="5" style="text-decoration:none;">
									<a style="text-decoration:none;color:#F0FFF0;">NIGERIA POLICE ACADEMY, WUDIL-KANO</a>
								</marquee>
							</p>
						
						<div class="col-lg-12">							
							<div class="col-lg-8 col-lg-offset-2">
								<form class="form-group" method="POST" action="process/admin_login.php" enctype="multipart/form-data" onsubmit="return stopper();">
									<div class="form-group col-lg-6">
										<label for="admin_no" style="font-size:20px;color:white;">ADMIN NO:</label>
										<input type="text" class="form-control" id="admin_no" name="admin_no" required>
									</div>
									<div class="form-group col-lg-6">
										<label for="admin_pass" style="font-size:20px;color:white;">PASSWORD:</label>
										<input type="password" class="form-control" id="admin_pass" name="admin_pass" required>
									</div>
									 
									  <div class="col-lg-12" style="text-align:center;">
										  <div class="form-group col-lg-4 col-lg-offset-4">
											<input type="submit" class="form-control btn btn-success" id="submit" Value="LOGIN" style="font-size:20px;color:white;height:60px;">
										  </div>
									  </div>
								</form> 
								
								<div class="col-lg-12" style="">
									<div class="col-lg-5"><a href="../" class="btn btn-danger">``*~~*``</a></div>
									<?php
										$tdn=$mycon->prepare("SELECT parent_id FROM cadet_parents");
										$tdn->execute();
										$total_tdn=$tdn->rowCount();
										$formated_total_tdn=number_format($total_tdn, 0, '.', ',');
										echo "
											<div class=\"col-lg-4\" style=\"padding:5px;margin:5px;text-align:center;color:#F0FFF0;font-size:25px;border:solid 3px #DC143C;border-radius:5%;\">
												$formated_total_tdn
											</div>
										";
									?>
									<div class="col-lg-12">
										<a href="unupdated.php" class="btn btn-warning">Blancs</a>
										<a href="view.php" class="btn btn-success">``*~~*``</a>
										<a href="male_rc7_9.php" class="btn btn-success">Male RC 7 to 9</a>
									</div>
									
								</div>
								<div class="col-lg-6 col-lg-offset-3" style="color:white;border-radius:5px;border:solid 2px green;text-align:center;font-size:20px;padding:5px;">
									MATTRASS COLLECTION LIST
										<a class="btn btn-info" href="rc6_mattrass.php" style="font-size:20px;">RC6</a>
										<a class="btn btn-default" href="rc7_mattrass.php" style="font-size:20px;">RC7</a>
										<a class="btn btn-danger" href="rc8_mattrass.php" style="font-size:20px;">RC8</a>
										<a class="btn btn-success" href="rc9_mattrass.php" style="font-size:20px;">RC9</a>
								</div>
								
							</div>
						</div>
						
						
							<?php
								if(isset($_GET['err_msg'])){
									$err_msg=$_GET['err_msg'];
									echo "
											<div class=\"modal fade\" id=\"modal_err_msg\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
												<div class=\"modal-dialog\" role=\"document\">
													<div class=\"modal-content\">
														<div class=\"modal-header\" style=\"background:#4682B4;color:#F0FFF0;\">
															<h4 class=\"modal-title\" id=\"exampleModalLabel\">NIGERIA POLICE ACADEMY</h4>
															<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
															<span aria-hidden=\"true\">&times;</span>
															</button>
														</div>
														<div class=\"modal-body\" style=\"font-size:16px;\">
															$err_msg
														</div>
														<div class=\"modal-footer\">
															<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
														</div>
													</div>
												</div>
											</div>
									
									";
								}
							?>
							<!-- include the log-in pages here -->
							<?php
								
							?>
														
						</div>
					</div>
				</div>
				<div class="12">&nbsp;<br>&nbsp;<br>&nbsp;&nbsp;<br>&nbsp;<br>&nbsp;&nbsp;<br>&nbsp;<br>&nbsp;&nbsp;<br>&nbsp;<br>&nbsp;</div>
			</div>
			<?php //include("sections/footer.php"); ?>
		</div>
	</body>
</html>