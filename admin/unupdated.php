<?php
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
		
		<link rel="stylesheet" type="text/css" href="../datatable/css/jquery.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="../datatable/css/buttons.dataTables.min.css">
		<!--<script type="text/javascript" charset="utf8" src="../datatable/js/jquery-3.3.1.js"></script>-->
		<script type="text/javascript" charset="utf8" src="../datatable/js/jquery.dataTables.min.js"></script>
		<script type="text/javascript" charset="utf8" src="../datatable/js/dataTables.buttons.min.js"></script>
		<script type="text/javascript" charset="utf8" src="../datatable/js/buttons.flash.min.js"></script>
		<script type="text/javascript" charset="utf8" src="../datatable/js/jszip.min.js"></script>
		<script type="text/javascript" charset="utf8" src="../datatable/js/pdfmake.min.js"></script>
		<script type="text/javascript" charset="utf8" src="../datatable/js/vfs_fonts.js"></script>
		<script type="text/javascript" charset="utf8" src="../datatable/js/buttons.html5.min.js"></script>
		<script type="text/javascript" charset="utf8" src="../datatable/js/buttons.print.min.js"></script>
		<script>
			
			$(document).ready(function() {
			    $('#bs_table').DataTable( {
			        dom: 'Bfrtip',
			        buttons: [
			           /**/ {
							extend: 'csvHtml5',
							title: '<?php echo "LIST OF CADETS THAT HAVE NOT UPDATED THEIR RECORDS";?>'
						},
						
						{
							extend: 'pdfHtml5',
							title: '<?php echo "LIST OF CADETS THAT HAVE NOT UPDATED THEIR RECORDS";?>'
						},
						'print'
						
			        ]
			    } );
			} );
		</script>
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
							<div class="col-lg-5"><a href="index.php" class="btn btn-warning">``*~~*``</a></div>
							<div class="col-lg-10 col-lg-offset-1">
								<table pdata-order='[[ 3, "asc" ]]' data-page-length='25' class="table table-hover table-bordered" id="bs_table">
									<thead>
										<tr>
											<th style="text-align:center;">SNO</th><th>NPA NO.</th><th>NAMES</th><th>RC</th><th>SQUAD</th><th>DEPT</th>
										</tr>
									</thead>
									<tbody>								
										<?php
											//get the cadets
											$sno=1;
											$cdts=$mycon->prepare("SELECT cadet_bio.npa_no, cadet_bio.fname, cadet_bio.sname, cadet_bio.onames, cadet_rc.rc, cadet_rc.squad
												FROM cadet_bio
												JOIN cadet_rc
												ON cadet_bio.npa_no=cadet_rc.npa_no
												AND cadet_bio.temp_edit_status=:raw
												ORDER BY cadet_rc.rc ASC, cadet_rc.squad ASC");
											$cdts->bindvalue(':raw', 'RAW', PDO::PARAM_STR);
											$cdts->execute();
											while($rt_cdts=$cdts->fetch(PDO::FETCH_ASSOC)){
												$npa_no=$rt_cdts['npa_no'];
												$names=$rt_cdts['sname']." ".$rt_cdts['fname']." ".$rt_cdts['onames'];
												$rc="RC".$rt_cdts['rc'];
												//$squad=$rt_cdts['squad'];
												$squad=substr($npa_no, 7,2);
												
												//using the npa_no, get the department
												$dpt=$mycon->prepare("SELECT departments.dept_name
													FROM departments
													JOIN cadet_dept
													ON departments.dept_code=cadet_dept.dept_code
													AND cadet_dept.npa_no=:npa_no");
												$dpt->bindvalue(':npa_no', $npa_no, PDO::PARAM_STR);
												$dpt->execute();
												
												while($rt_dpt=$dpt->fetch(PDO::FETCH_ASSOC)){
													$dept_name=$rt_dpt['dept_name'];
												}
												echo "
												<tr>
													<td style=\"text-align:center;\">$sno</td>
													<td>$npa_no</td>
													<td>$names</td><td>$rc</td><td>$squad</td>
													<td>$dept_name</td>
												</tr>
												";
												$sno++;
												
											}
										?>
									</tbody>
								</table>
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