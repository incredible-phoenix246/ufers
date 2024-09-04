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
		<script type="text/javascript" src="../canvas/canvasjs.min.js"></script>
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
							<div class="col-lg-5"><a href="index.php" class="btn btn-warning">``*~~*``</a></div>
							<div class="col-lg-8 col-lg-offset-2">
								<?php
									$cdts=$mycon->prepare("SELECT * FROM cadet_bio");
									$cdts->execute();
									$total_cadet=$cdts->rowCount();
									
									$un_updated=$mycon->prepare("SELECT cadet_bio.npa_no, cadet_bio.fname, cadet_bio.sname, cadet_bio.onames, cadet_rc.rc
										FROM cadet_bio
										JOIN cadet_rc
										ON cadet_bio.npa_no=cadet_rc.npa_no
										AND cadet_bio.temp_edit_status=:raw
										ORDER BY cadet_rc.rc ASC");
									$un_updated->bindvalue(':raw', 'RAW', PDO::PARAM_STR);
									$un_updated->execute();
									$total_un_updated=$un_updated->rowCount();
									
									$updated_cadets=$total_cadet-$total_un_updated;
									
									
									$percent_updated=($updated_cadets/$total_cadet) * 100;
									$percent_un_updated=($total_un_updated/$total_cadet) * 100;
									
									$dataPoints = array( 
										array("label"=>"Updated", "y"=>$percent_updated),
										array("label"=>"Not Updated", "y"=>$percent_un_updated)
									)									
								?>
								<script>
									window.onload = function() {
									 
									 
									var chart = new CanvasJS.Chart("chartContainer", {
										animationEnabled: true,
										title: {
											text: "CADETS PARTICIPATION IN DATA UPDATE"
										},
										subtitles: [{
											text: "CADET DATA UPDATE"
										}],
										data: [{
											type: "pie",
											yValueFormatString: "#,##0.\"\"",
											indexLabel: "{label} ({y})",
											dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
										}]
									});
									chart.render();
									 
									}
								</script>
									<div id="chartContainer" style="height: 370px; width: 100%;"></div>
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