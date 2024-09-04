<?php
session_start();
include("../../ufers_con/ufers_con.php");
if(isset($_POST['admin_no'])){
	$admin_no=$_POST['admin_no'];	
	$admin_pass=md5($_POST['admin_pass']);	
	//check the usercredentials
	$check_admin=$mycon->prepare("SELECT staff.apfno, staff.fname, staff.sname, staff.onames, staff.gender, 
		staff_cred.role 
			FROM staff 
			JOIN staff_cred
			ON staff.apfno=staff_cred.apfno
			AND staff.apfno=:apfno
			AND staff_cred.role=:role
			AND staff_cred.password=:password");
	$check_admin->bindvalue(':apfno', $admin_no,PDO::PARAM_STR);
	$check_admin->bindvalue(':role', 'OPERATOR',PDO::PARAM_STR);
	$check_admin->bindvalue(':password', $admin_pass,PDO::PARAM_STR);
	$check_admin->execute();
	$total_check_admin=$check_admin->rowCount();
	
	if($total_check_admin<1){
		header("location:../index.php?err_msg=Invalid login details for $admin_no, please contact admin !!!");
	}
	else{
		while($rt_check_admin=$check_admin->fetch(PDO::FETCH_ASSOC)){
			$apfno=$rt_check_admin['apfno'];
			$sname=$rt_check_admin['sname'];
			$fname=$rt_check_admin['fname'];					
			$role=$rt_check_admin['role'];					
		}
		
		$_SESSION['apfno']=$apfno;
		$_SESSION['role']=$role;
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
		
		header("location:../admin_page.php");
	}
}
else{
	header("location:../logout.php?err_msg=Invalid POST operations detected !!!");
}

?>