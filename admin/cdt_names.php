<?php
session_start();
include("../ufers_con/ufers_con.php");
$npa_no=$_GET['npa_no'];
$cdt_det=$mycon->prepare("SELECT fname, sname, onames FROM cadet_bio WHERE npa_no=:npa_no");
$cdt_det->bindvalue(':npa_no', $npa_no, PDO::PARAM_STR);
$cdt_det->execute();
while($rt_cdt_det=$cdt_det->fetch(PDO::FETCH_ASSOC)){
	$cdt_fname=$rt_cdt_det['fname'];
	$cdt_sname=$rt_cdt_det['sname'];
	$cdt_onames=$rt_cdt_det['onames'];
}

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
			#old_dept, #cur_dept{
				box-shadow: 5px 5px 5px #00008B;
				font-size:20px;
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
								<form class="form-group" method="POST" action="process/update_cdt_names.php" enctype="multipart/form-data" onsubmit="return stopper();">
									  <style>
										label{
											color:#F0FFF0;font-size:18px;
										}
									  </style>
									  <div class="form-group col-lg-12">
										<label for="npa_no" >NPA No:</label>
										<input type="text" class="form-control" id= "npa_no" name="npa_no" value="<?php echo $npa_no; ?>" readonly />
									  </div>
									  <div class="form-group col-lg-4">
										<label for="cdt_sname" >Surname:</label>
										<input type="text" class="form-control" id= "cdt_sname" name="cdt_sname" value="<?php echo $cdt_sname; ?>" required />
									  </div>
									  <div class="form-group col-lg-4">
										<label for="cdt_fname" >First Name:</label>
										<input type="text" class="form-control" id= "cdt_fname" name="cdt_fname" value="<?php echo $cdt_fname; ?>" required />
									  </div>
									  <div class="form-group col-lg-4">
										<label for="cdt_onames" >Other Names:</label>
										<input type="text" class="form-control" id= "cdt_onames" name="cdt_onames" value="<?php echo $cdt_onames; ?>" />
									  </div>
									<div class="form-group col-lg-12" style="text-align:center;">
										<input type="submit" class="btn btn-info" value="Update" style="font-size:20px;" />
									</div>
								  
								</form> 
							</div>
							<div class="col-lg-8 col-lg-offset-2" style="background:#E6E6FA;">
								
							</div><a href="logout.php" class="btn btn-danger">LOgout</a>
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