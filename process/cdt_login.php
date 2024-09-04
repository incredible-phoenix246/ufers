<?php
session_start();
include("../ufers_con/ufers_con.php");
if(isset($_POST['npa_no'])){
	$npa_no=$_POST['npa_no'];	
	//check the usercredentials
	$check_cdt=$mycon->prepare("SELECT cadet_bio.fname, cadet_bio.sname, cadet_bio.onames, cadet_bio.gender, cadet_bio.dob, cadet_bio.phone, 
		cadet_bio.email, cadet_bio.state, cadet_bio.lga, cadet_bio.tribe, cadet_bio.parent_id, cadet_rc.rc, cadet_rc.squad 
			FROM cadet_bio 
			JOIN cadet_rc
			ON cadet_bio.npa_no=cadet_rc.npa_no
			AND cadet_bio.npa_no=:npa_no");
	$check_cdt->bindvalue(':npa_no', $npa_no,PDO::PARAM_STR);
	$check_cdt->execute();
	$total_check_cdt=$check_cdt->rowCount();
	
	if($total_check_cdt<1){
		header("location:../index.php?err_msg=No records exist for $npa_no, please contact admin !!!");
	}
	else{
		while($rt_check_cdt=$check_cdt->fetch(PDO::FETCH_ASSOC)){
			$sname=$rt_check_cdt['sname'];
			$fname=$rt_check_cdt['fname'];
			$onames=$rt_check_cdt['onames'];
			$gender=$rt_check_cdt['gender'];
			$dob=$rt_check_cdt['dob'];
			$phone=$rt_check_cdt['phone'];
			$email=$rt_check_cdt['email'];
			$cdt_state=$rt_check_cdt['state'];
			$cdt_lga=$rt_check_cdt['lga'];
			$cdt_tribe=$rt_check_cdt['tribe'];
			$parent_id=$rt_check_cdt['parent_id'];						
			$cdt_rc=$rt_check_cdt['rc'];						
			$cdt_squad=$rt_check_cdt['squad'];						
		}
		//get the department of the cadet
		$cdt_det=$mycon->prepare("SELECT cadet_dept.dept_code, departments.dept_name
			FROM cadet_dept
			JOIN departments
			ON cadet_dept.dept_code=departments.dept_code
			AND cadet_dept.npa_no=:npa_no");
		$cdt_det->bindvalue(':npa_no', $npa_no,PDO::PARAM_STR);
		$cdt_det->execute();
		while($rt_cdt_det=$cdt_det->fetch(PDO::FETCH_ASSOC)){
			$cdt_department=$rt_cdt_det['dept_name'];
		}
		//place into session variables
		$_SESSION['npa_no']=$npa_no;
		/*$_SESSION['sname']=$sname;
		$_SESSION['fname']=$fname;
		$_SESSION['onames']=$onames;
		$_SESSION['gender']=$gender;
		$_SESSION['dob']=$dob;
		$_SESSION['phone']=$phone;
		$_SESSION['email']=$email;
		$_SESSION['cdt_state']=$cdt_state;
		$_SESSION['cdt_lga']=$cdt_lga;
		$_SESSION['cdt_tribe']=$cdt_tribe;
		$_SESSION['parent_id']=$parent_id;
		$_SESSION['cdt_rc']=$cdt_rc;
		$_SESSION['cdt_squad']=$cdt_squad;
		$_SESSION['cdt_department']=$cdt_department;*/
		
		header("location:../cadet_home_page.php");
	}
}
else{
	header("location:../logout.php?err_msg=Invalid POST operations detected !!!");
}

?>