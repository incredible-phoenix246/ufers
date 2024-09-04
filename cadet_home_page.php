<?php
session_start();
include("ufers_con/ufers_con.php");
include("sections/cadet_verifier.php");


//echo $dob;

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
		<title>UFERS-HOME</title>
		
		
		<link rel="stylesheet" href="bootstrap/css/style.css"/>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="bootstrap/font/css/font-awesome.css"/>		
		
		<script type="text/javascript" src="bootstrap/js/jquery.js"></script>
		<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/parent_state_lga_selector.js"></script>
		<script type="text/javascript" src="js/modal_activator.js"></script>
		<link rel="stylesheet" href="css/my_styler.css"/>
		<style>
			
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
							
							<img src="imgs/gen_logo.jpg" width="100%" />
							<?php 
								include("sections/cadet_menu.php");
							?>
							<p style="background:#000000;color:#F0FFF0;font-size:28px;">
								<marquee scrollamount="5" style="text-decoration:none;">
									<a style="text-decoration:none;color:#F0FFF0;">NIGERIA POLICE ACADEMY, WUDIL-KANO</a>
								</marquee>
							</p>
						
						<div class="col-lg-12">
							<?php
								include("sections/cadet_profile.php");
							?>
							<div class="col-lg-8 col-lg-offset-2">
								<p style="color:#F0FFF0;background:#008000;border:solid 1px #008000;border-radius:10px;font-size:28px;padding:10px;">CADET DETAILS</p>
								<form class="form-group" method="POST" action="process/edit_cadet_info_pro.php" enctype="multipart/form-data" onsubmit="return stopper();">
									<div class="form-group col-lg-4">
										<label for="npa_no" style="font-size:20px;color:white;">NPA NO:</label>
										<input type="text" class="form-control" id="npa_no" name="npa_no" value="<?php echo $npa_no; ?>" readonly >
									</div>
									<div class="form-group col-lg-4">
										<label for="sname" style="font-size:20px;color:white;">Surname:</label>
										<input type="text" class="form-control" id="sname" name="sname" value="<?php echo $sname; ?>" readonly >
									</div>
									<div class="form-group col-lg-4">
										<label for="fname" style="font-size:20px;color:white;">First Name:</label>
										<input type="text" class="form-control" id="fname" name="fname" value="<?php echo $fname; ?>" readonly >
									</div>
									<div class="form-group col-lg-4">
										<label for="onames" style="font-size:20px;color:white;">Other Names:</label>
										<input type="text" class="form-control" id="onames" name="onames" value="<?php echo $onames; ?>" readonly >
									</div>
									<div class="form-group col-lg-4">
										<label for="gender" style="font-size:20px;color:white;">Gender:</label>
										<?php
											if($gender=="F"){
												$gender_display="FEMALE";
											}
											else{
												$gender_display="MALE";
											}
										?>
										<select class="form-control" id="gender" name="gender">
											<option value="<?php echo $gender; ?>"><?php echo $gender_display;?></option>
											<option value="M">MALE</option>
											<option value="F">FEMALE</option>
										</select>
									</div>
									<div class="form-group col-lg-4">
										<label for="dob" style="font-size:20px;color:white;">Date of Birth:</label>
										<input type="date" class="form-control" id="dob" name="dob" value="<?php echo $dob; ?>" required >
									</div>
									<div class="form-group col-lg-4">
										<label for="phone" style="font-size:20px;color:white;">Phone:</label>
										<input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>" required />
									</div>
									<div class="form-group col-lg-6">
										<label for="email" style="font-size:20px;color:white;">Email:</label>
										<input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required />
									</div>
									<div class="form-group col-lg-4">
										<label for="p_state" style="font-size:20px;color:white;">State:</label>
										<select class="form-control" id="p_state" name="p_state" required >
											<option value="<?php echo $p_state; ?>"><?php echo $cdt_state; ?></option>
											<option value="ABIA">ABIA</option>
											<option value="ADAMAWA">ADAMAWA</option>
											<option value="AKWA-IBOM">AKWA-IBOM</option>
											<option value="ANAMBRA">ANAMBRA</option>
											<option value="BAUCHI">BAUCHI</option>
											<option value="BAYELSA">BAYELSA</option>
											<option value="BENUE">BENUE</option>
											<option value="BORNO">BORNO</option>
											<option value="CROSS RIVER">CROSS RIVER</option>
											<option value="DELTA">DELTA</option>
											<option value="EBONYI">EBONYI</option>
											<option value="EDO">EDO</option>
											<option value="EKITI">EKITI</option>
											<option value="ENUGU">ENUGU</option>
											<option value="FCT-ABUJA">FCT ABUJA</option>
											<option value="GOMBE">GOMBE</option>
											<option value="IMO">IMO</option>
											<option value="JIGAWA">JIGAWA</option>
											<option value="KADUNA">KADUNA</option>
											<option value="KANO">KANO</option>
											<option value="KATSINA">KATSINA</option>
											<option value="KEBBI">KEBBI</option>
											<option value="KOGI">KOGI</option>
											<option value="KWARA">KWARA</option>
											<option value="LAGOS">LAGOS</option>
											<option value="NASSARAWA">NASSARAWA</option>
											<option value="NIGER">NIGER</option>
											<option value="OGUN">OGUN</option>
											<option value="ONDO">ONDO</option>
											<option value="OSUN">OSUN</option>
											<option value="OYO">OYO</option>
											<option value="PLATEAU">PLATEAU</option>
											<option value="RIVERS">RIVERS</option>
											<option value="SOKOTO">SOKOTO</option>
											<option value="TARABA">TARABA</option>
											<option value="YOBE">YOBE</option>
											<option value="ZAMFARA">ZAMFARA</option>
										</select>
									</div>
									<div class="form-group col-lg-4">
										<label for="p_lga" style="font-size:20px;color:white;">LGA:</label>
										<select class="form-control" id="p_lga" name="p_lga">
											<option value="<?php echo $cdt_lga; ?>"><?php echo $cdt_lga; ?></option>
										</select>
									</div>
									<div class="form-group col-lg-4">
										<label for="cdt_tribe" style="font-size:20px;color:white;">TRIBE:</label>
										<input type="text" class="form-control" id="cdt_tribe" name="cdt_tribe" value="<?php echo $cdt_tribe; ?>" required />
									</div>
									<div class="form-group col-lg-3">
										<label for="cdt_rc" style="font-size:20px;color:white;">RC:</label>
										<input type="text" class="form-control" id="cdt_rc" name="cdt_rc" value="<?php echo $cdt_rc; ?>" readonly />
									</div>
									<div class="form-group col-lg-3">
										<label for="cdt_squad" style="font-size:20px;color:white;">Squad:</label>
										<select class="form-control" id="cdt_squad" name="cdt_squad" required>
											<option value="<?php echo $cdt_squad; ?>"><?php echo $cdt_squad; ?></option>
											<?php
												for($sq=1;$sq<=30;$sq++){
													echo "<option value=\"$sq\">$sq</option>";
												}
											?>
										</select>
									</div>
									<div class="form-group col-lg-6">
										<label for="cdt_department" style="font-size:20px;color:white;">Department:</label>
										<input type="text" class="form-control" id="cdt_department" name="cdt_department" value="<?php echo $cdt_department; ?>" readonly />
									</div>
									
									 
									  <div class="col-lg-12" style="text-align:center;">
										  <div class="form-group col-lg-4 col-lg-offset-4">
											<input type="submit" class="form-control btn btn-success" id="submit" Value="Update" style="font-size:20px;color:white;height:60px;">
										  </div>
									  </div>
								</form> 
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