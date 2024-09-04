<?php
session_start();
include("../ufers_con/ufers_con.php");

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
								<form class="form-group" method="POST" action="" enctype="multipart/form-data" onsubmit="return stopper();">
									<div class="form-group col-lg-12">
										<label for="npa_no" style="font-size:20px;color:white;">NPA NO:</label>
										<input type="text" class="form-control" id="npa_no" name="npa_no" required>
									</div>									 
									  <div class="col-lg-12" style="text-align:center;">
										  <div class="form-group col-lg-4 col-lg-offset-4">
											<input type="submit" class="form-control btn btn-success" id="submit" Value="Load Page" style="font-size:20px;color:white;height:60px;">
										  </div>
									  </div>
								</form> 
							</div>
							<div class="col-lg-8 col-lg-offset-2" style="background:#E6E6FA;">
							<?php
								if(isset($_POST['npa_no'])){	
									$npa_no=$_POST['npa_no'];
									echo "
										<table class=\"table table-hover table-bordered\">
											<tr>
												<th>SNO</th><th>NPA NO</th><th>NAMES</th><th>RC/Squad</th><th>DEPARTMENT</th><th>--</th>
											</tr>";
									//get the details of the npa_no
									$cdt_det=$mycon->prepare("SELECT cadet_bio.npa_no, cadet_bio.fname, cadet_bio.sname, cadet_bio.onames,
										cadet_rc.rc, cadet_rc.squad
										FROM cadet_bio
										JOIN cadet_rc
										ON cadet_bio.npa_no=cadet_rc.npa_no
										AND cadet_bio.npa_no=:npa_no");
									$cdt_det->bindvalue(':npa_no', $npa_no, PDO::PARAM_STR);
									$cdt_det->execute();
									$sno=1;
									while($rt_cdt_det=$cdt_det->fetch(PDO::FETCH_ASSOC)){
										$cdt_npa_no=$rt_cdt_det['npa_no'];
										$cdt_fname=$rt_cdt_det['fname'];
										$cdt_sname=$rt_cdt_det['sname'];
										$cdt_onames=$rt_cdt_det['onames'];
										$cdt_rc=$rt_cdt_det['rc'];
										$cdt_squad =$rt_cdt_det['squad'];
										
										//now get the department of the cadet
										$dept_det=$mycon->prepare("SELECT cadet_dept.dept_code, departments.dept_name
											FROM cadet_dept
											JOIN departments
											ON cadet_dept.dept_code=departments.dept_code
											AND cadet_dept.npa_no=:npa_no");
										$dept_det->bindvalue(':npa_no', $npa_no, PDO::PARAM_STR);
										$dept_det->execute();
										while($rt_dept_det=$dept_det->fetch(PDO::FETCH_ASSOC)){
											$cdt_dp_code=$rt_dept_det['dept_code'];
											$cdt_dp_name=$rt_dept_det['dept_name'];
										}
										echo "
											<tr>
												<td>$sno</td><td>$cdt_npa_no</td>
												<td><a href=\"cdt_names.php?npa_no=$npa_no\">$cdt_fname  $cdt_sname $cdt_onames</a></td>
												<td>$cdt_rc [$cdt_squad]</td>
												<td><a data-toggle=\"modal\" data-target=\"#chnge_dept_name\">$cdt_dp_name</a></td>
												<td><a href=\"process/unseal_parent.php?npa_no=$npa_no\" class=\"btn btn-default\">Unseal Parent</a></td>											
												<!-- Modal -->
												<div class=\"modal fade\" id=\"chnge_dept_name\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
												  <div class=\"modal-dialog\" role=\"document\">
													<div class=\"modal-content\">
													  <div class=\"modal-header\" style=\"background:#6495ED;color:#F0FFF0;\">
														<h3 class=\"modal-title\" id=\"exampleModalLabel\">CHANGE PASSWORD</h3>
														<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">
														  <span aria-hidden=\"true\">&times;</span>
														</button>
													  </div>
													  <div class=\"modal-body\">												
														<form action=\"process/change_cdt_dept.php\" method=\"post\" enctype=\"multipart/form-data\">
															<div class=\"form-group col-lg-12\">
																<label for=\"old_dept\" style=\"font-size:20px;\">Old Department</label>
																<input id=\"old_dept\" type=\"text\" class=\"form-control\" name=\"old_dept\" value=\"$cdt_dp_name\" readonly/>									
																<input id=\"npa_no\" type=\"hidden\" class=\"form-control\" name=\"npa_no\" value=\"$npa_no\" />									
															</div>
															<div class=\"form-group col-lg-12\">	
																<label for=\"cur_dept\" style=\"font-size:20px;\">New Department:</label>
																<select id=\"cur_dept\" class=\"form-control\" name=\"cur_dept\" >
																";
																$mds=$mycon->prepare("SELECT dept_code, dept_name FROM departments");
																$mds->execute();
																while($rt_mds=$mds->fetch(PDO::FETCH_ASSOC)){
																	$dp_code=$rt_mds['dept_code'];
																	$dp_name=$rt_mds['dept_name'];
																	echo "<option value=\"$dp_code\">$dp_name</option>";
																}
															echo "
																</select>
															</div>
															<div class=\"form-group col-lg-6 col-lg-offset-3\">
																<button type=\"submit\" id=\"submit\" class=\"form-control btn btn-primary\" style=\"marging:5px;padding-bottom:40px;font-size:28px;color:;\">Change</button>
															</div>
														</form>
														<!--You are all welcome to the Pop-Up lessons &hellip;-->
													  </div>
													  <div class=\"modal-footer\" style=\"text-align:center;\">
														<button type=\"button\" class=\"btn btn-secondary\" data-dismiss=\"modal\">Close</button>
													  </div>
													</div>
												  </div>
												</div>
												<!-- end of modal -->
											</tr>
										";
										$sno++;
									}
											
									echo "	
										</table>
									";
								}
							?>
								
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