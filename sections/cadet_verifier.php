<?php
	if(isset($_SESSION['npa_no'])){//, $_SESSION['sname'], $_SESSION['fname'], $_SESSION['onames'], $_SESSION['phone'])){
		$npa_no=$_SESSION['npa_no'];
		/*$sname=$_SESSION['sname'];
		$fname=$_SESSION['fname'];
		$onames=$_SESSION['onames'];
		$gender=$_SESSION['gender'];
		$dob=$_SESSION['dob'];
		$phone=$_SESSION['phone'];
		$email=$_SESSION['email'];
		$cdt_state=$_SESSION['cdt_state'];
		$cdt_lga=$_SESSION['cdt_lga'];
		$cdt_tribe=$_SESSION['cdt_tribe'];
		$parent_id=$_SESSION['parent_id'];
		$cdt_rc=$_SESSION['cdt_rc'];
		$cdt_squad=$_SESSION['cdt_squad'];
		$cdt_department=$_SESSION['cdt_department'];
		*/
		
		//now check the variables against the database
		$ver_cdt=$mycon->prepare("SELECT cadet_bio.npa_no, cadet_dept.dept_code 
			FROM cadet_bio 
			JOIN cadet_dept
			ON cadet_bio.npa_no=cadet_dept.npa_no
			AND cadet_bio.npa_no=:npa_no");
		$ver_cdt->bindvalue(':npa_no', $npa_no, PDO::PARAM_STR);
		$ver_cdt->execute();
		$found_ver_cdt=$ver_cdt->rowCount();
		if($found_ver_cdt<1){
			header("location:logout.php?err_msg=Invalid session login credentials detected !!!");
		}
		else{
			//get the details of the cadet using the npa_no
			$cdt_det=$mycon->prepare("SELECT cadet_bio.fname, cadet_bio.sname, cadet_bio.onames, cadet_bio.gender, cadet_bio.dob, cadet_bio.phone, 
				cadet_bio.email, cadet_bio.state, cadet_bio.lga, cadet_bio.tribe, cadet_bio.parent_id, cadet_bio.temp_edit_status, cadet_rc.rc, cadet_rc.squad 
					FROM cadet_bio 
					JOIN cadet_rc
					ON cadet_bio.npa_no=cadet_rc.npa_no
					AND cadet_bio.npa_no=:npa_no");
			$cdt_det->bindvalue(':npa_no', $npa_no,PDO::PARAM_STR);
			$cdt_det->execute();
			while($rt_cdt_det=$cdt_det->fetch(PDO::FETCH_ASSOC)){
				$sname=$rt_cdt_det['sname'];
				$fname=$rt_cdt_det['fname'];
				$onames=$rt_cdt_det['onames'];
				$gender=$rt_cdt_det['gender'];
				$dob=$rt_cdt_det['dob'];
				$phone=$rt_cdt_det['phone'];
				$email=$rt_cdt_det['email'];
				$cdt_state=$rt_cdt_det['state'];
				$cdt_lga=$rt_cdt_det['lga'];
				$cdt_tribe=$rt_cdt_det['tribe'];
				$parent_id=$rt_cdt_det['parent_id'];					
				$temp_edit_status=$rt_cdt_det['temp_edit_status'];					
				$cdt_rc=$rt_cdt_det['rc'];						
				$cdt_squad=$rt_cdt_det['squad'];						
			}

			//get the department of the cadet
			$cdt_dept=$mycon->prepare("SELECT cadet_dept.dept_code, departments.dept_name
				FROM cadet_dept
				JOIN departments
				ON cadet_dept.dept_code=departments.dept_code
				AND cadet_dept.npa_no=:npa_no");
			$cdt_dept->bindvalue(':npa_no', $npa_no,PDO::PARAM_STR);
			$cdt_dept->execute();
			while($rt_cdt_dept=$cdt_dept->fetch(PDO::FETCH_ASSOC)){
				$cdt_department=$rt_cdt_dept['dept_name'];
			}
			/*
			$lastlog=date("YmdHis");
			$upd_ll=$mycon->prepare("UPDATE staff_cred SET lastlog=:lastlog WHERE apfno=:apfno");
			$upd_ll->bindvalue(':apfno', $apfno, PDO::PARAM_STR);
			$upd_ll->bindvalue(':lastlog', $lastlog, PDO::PARAM_STR);
			$upd_ll->execute();
			*/
		}
	}
	else{
		header("location:logout.php?err_msg=Invalid session, please login again");
	}
?>