<?php
session_start();
include("../ufers_con/ufers_con.php");
include("../sections/cadet_verifier.php");




$disp_dob=date("d-M-Y", strtotime($dob));
//echo $dob."---".$disp_dob;


try{
		//echo $npa_no;
		$cdt_det=$mycon->prepare("SELECT fname, sname FROM cadet_bio WHERE npa_no=:npa_no");
		$cdt_det->bindvalue(':npa_no', $npa_no, PDO::PARAM_STR);
		$cdt_det->execute();
		while($rt_cdt_det=$cdt_det->fetch(PDO::FETCH_ASSOC)){
			$pre_fname=$rt_cdt_det['fname'];
			$pre_sname=$rt_cdt_det['sname'];
		}
		
		//now update with the real names
		$upd_names=$mycon->prepare("UPDATE cadet_bio SET fname=:fname, sname=:sname WHERE npa_no=:npa_no");
		$upd_names->bindvalue(':fname', $pre_sname, PDO::PARAM_STR);
		$upd_names->bindvalue(':sname', $pre_fname, PDO::PARAM_STR);
		$upd_names->bindvalue(':npa_no', $npa_no, PDO::PARAM_STR);
		$upd_names->execute();
		
		
		
	
	
	header("location:../cadet_home_page.php?err_msg=Your NAme switch was updated succesfully. Thank You !");
}
catch(PDOexception $e){
	$db_err=$e->getMessage();
	header("location:../cadet_home_page.php?err_msg=$db_err");
}
?>