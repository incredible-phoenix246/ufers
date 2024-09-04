<?php
session_start();
include("ufers_con/ufers_con.php");
include("sections/cadet_verifier.php");

//echo $parent_id."---";
//using the npa_no, get the details of the parent_id
$par_info=$mycon->prepare("SELECT cadet_parents.fname, cadet_parents.sname, cadet_parents.email, cadet_parents.occupation, cadet_parents.state_of_residence,
	cadet_parents.lga, cadet_parents.address, cadet_parents.status
	FROM cadet_parents
	WHERE cadet_parents.parent_id=:parent_id");
$par_info->bindvalue(':parent_id', $parent_id, PDO::PARAM_STR);
$par_info->execute();
while($rt_par_info=$par_info->fetch(PDO::FETCH_ASSOC)){
	$p_fname=$rt_par_info['fname'];
	$p_sname=$rt_par_info['sname'];
	$p_email=$rt_par_info['email'];
	$p_occupation=$rt_par_info['occupation'];
	$p_state=$rt_par_info['state_of_residence'];
	$p_lga=$rt_par_info['lga'];
	$p_address=$rt_par_info['address'];
	$p_status=$rt_par_info['status'];
}

if($p_status=="BLANK"){
	$read_status="";
	$submit_btn="<input type=\"submit\" class=\"form-control btn btn-success\" id=\"submit\" Value=\"Update\" style=\"font-size:20px;color:white;height:60px;\">";
}
else{
	$read_status="readonly";
	$submit_btn="<a class=\"btn btn-danger\" data-toggle=\"modal\" data-target=\"#parent_info_seal\" style=\"font-size:20px;color:white;height:60px;\">Sealed</a>";
}
//get all the phones associated with this parent_id
$p_phone1="";
$p_phone2="";
$par_phones=$mycon->prepare("SELECT phone FROM cadet_parent_phone WHERE parent_id=:parent_id");
$par_phones->bindvalue(':parent_id', $parent_id, PDO::PARAM_STR);
$par_phones->execute();
$total_phones=$par_phones->rowCount();

$parent_phone="";
while($rt_par_phones=$par_phones->fetch(PDO::FETCH_ASSOC)){
	$parent_phone=$rt_par_phones['phone'].";".$parent_phone;
}
$two_parent_phones=explode(";",$parent_phone);
if($total_phones<2){
	$p_phone1=$two_parent_phones[0];
	$p_phone2="";
}
else{
	$p_phone1=$two_parent_phones[0];
	$p_phone2=$two_parent_phones[1];
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
		<title>UFERS-HOME</title>
		
		
		<link rel="stylesheet" href="bootstrap/css/style.css"/>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="bootstrap/font/css/font-awesome.css"/>		
		
		<script type="text/javascript" src="bootstrap/js/jquery.js"></script>
		<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/parent_state_lga_selector.js"></script>
		<script type="text/javascript" src="js/modal_activator.js"></script>
		<link rel="stylesheet" href="css/my_styler.css"/>
		<script>
			function stopper(){
				var p_status=document.getElementById("p_status").value;
				if(p_status=="BLANK"){
					return true;
				}
				else{
					alert("Parent Details Already Updated, Contact Admin !!!");
					return false;
				}
			}
		</script>
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
								<p style="color:#F0FFF0;background:#DC143C;border:solid 1px #DC143C;border-radius:10px;font-size:28px;padding:10px;">MY PARENTS/GUARDIAN DETAILS</p>
								<form class="form-group" method="POST" action="process/cadet_parent_info_pro.php" enctype="multipart/form-data" onsubmit="return stopper();">
									<div class="form-group col-lg-4">
										<label for="parent_id" style="font-size:20px;color:white;">PARENT ID:</label>
										<input type="text" class="form-control" id="parent_id" name="parent_id" value="<?php echo $parent_id; ?>" readonly >
										<input type="hidden" class="form-control" id="p_status" name="p_status" value="<?php echo $p_status; ?>" readonly >
									</div>
									<div class="form-group col-lg-4">
										<label for="p_sname" style="font-size:20px;color:white;">Surname:</label>
										<input type="text" class="form-control" id="p_sname" name="p_sname" value="<?php echo $p_sname; ?>" required <?php echo $read_status; ?>/>
									</div>
									<div class="form-group col-lg-4">
										<label for="p_fname" style="font-size:20px;color:white;">First Name:</label>
										<input type="text" class="form-control" id="p_fname" name="p_fname" value="<?php echo $p_fname; ?>" required <?php echo $read_status; ?>/>
									</div>									
									
									<div class="form-group col-lg-6">
										<label for="p_email" style="font-size:20px;color:white;">Email:</label>
										<input type="email" class="form-control" id="p_email" name="p_email" value="<?php echo $p_email; ?>" <?php echo $read_status; ?>/>
									</div>
									<div class="form-group col-lg-6">
										<label for="p_occupation" style="font-size:20px;color:white;">Occupation:</label>
										<input type="text" class="form-control" id="p_occupation" name="p_occupation" value="<?php echo $p_occupation; ?>" required <?php echo $read_status; ?> />
									</div>
									<div class="form-group col-lg-6">
										<label for="p_phone1" style="font-size:20px;color:white;">Phone1:</label>
										<input type="text" class="form-control" id="p_phone1" name="p_phone1" value="<?php echo $p_phone1; ?>" required <?php echo $read_status; ?> />
									</div>
									<div class="form-group col-lg-6">
										<label for="p_phone2" style="font-size:20px;color:white;">Phone2:</label>
										<input type="text" class="form-control" id="p_phone2" name="p_phone2" value="<?php echo $p_phone2; ?>" <?php echo $read_status; ?> />
									</div>
									
									<div class="form-group col-lg-6">
										<label for="p_state" style="font-size:20px;color:white;">State of Residence:</label>
										<select class="form-control" id="p_state" name="p_state" required <?php echo $read_status; ?>>
											<option value="<?php echo $p_state; ?>"><?php echo $p_state; ?></option>
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
											<option value="FCT-ABUJA">FCT-ABUJA</option>
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
									<div class="form-group col-lg-6">
										<label for="p_lga" style="font-size:20px;color:white;">LGA:</label>
										<select class="form-control" id="p_lga" name="p_lga" <?php echo $read_status; ?>>
											<option value="<?php echo $p_lga; ?>"><?php echo $p_lga; ?></option>
										</select>
									</div>
									<div class="form-group col-lg-12">
										<label for="p_address" style="font-size:20px;color:white;">Address:</label>
										<textarea class="form-control" id="p_address" name="p_address" <?php echo $read_status; ?>><?php echo $p_address; ?></textarea>
									</div>
																		
									  <div class="col-lg-12" style="text-align:center;">
										  <div class="form-group col-lg-4 col-lg-offset-4">
											<?php
												echo $submit_btn;
											?>
											<!--Seal stamp-->
											<div class="modal fade" id="parent_info_seal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
											  <div class="modal-dialog" role="document">
												<div class="modal-content">
												  <div class="modal-header" style="background:#E0FFFF;color:#B22222;text-align:center;">
													<h2 class="modal-title" id="exampleModalLabel">SEALED PARENT DATA</h2>
													
												  </div>
												  <div class="modal-body" style="font-size:22px;color:#FF0000;">
													Parent information has been edited and locked. Please contact admin for further action !
													<!--You are all welcome to the Pop-Up lessons &hellip;-->
												  </div>
												  <div class="modal-footer" style="text-align:center;">
													<a  class="close btn btn-info" data-dismiss="modal" aria-label="Close">Close</a>
												  </div>
												</div>
											  </div>
											</div>
											<!--Seal stamp-->
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