<?php
session_start();
include("../ufers_con/ufers_con.php");
include("../sections/cadet_verifier.php");


$dob=$_POST['dob'];
$gender=$_POST['gender'];
$phone=$_POST['phone'];
$email=$_POST['email'];
$cdt_state=$_POST['p_state'];
$cdt_lga=$_POST['p_lga'];
$cdt_tribe=$_POST['cdt_tribe'];
$cdt_squad=$_POST['cdt_squad'];

$disp_dob=date("d-M-Y", strtotime($dob));
//echo $dob."---".$disp_dob;


try{
	if($temp_edit_status=="RAW"){
		//create a parent_id for this npa_no
		$pid=$mycon->prepare("SELECT parent_id FROM cadet_parents");
		$pid->execute();
		$total_pid=$pid->rowCount();
		$next_pid=$total_pid+1;
		if($next_pid<10){
			$my_pid="23"."0000".$next_pid;
		}
		elseif($next_pid<100){
			$my_pid="23"."000".$next_pid;
		}
		elseif($next_pid<1000){
			$my_pid="23"."00".$next_pid;
		}
		elseif($next_pid<10000){
			$my_pid="23"."0".$next_pid;
		}
		//echo $my_pid;
		
		//now create a row for the parent_id
		$ins_par=$mycon->prepare("INSERT INTO cadet_parents (parent_id, fname, sname, email, occupation, state_of_residence,
			lga, address, status, entered_by) VALUES (:parent_id, :fname, :sname, :email, :occupation, :state_of_residence,
			:lga, :address, :status, :entered_by)");
		$ins_par->bindvalue(':parent_id', $my_pid, PDO::PARAM_STR);
		$ins_par->bindvalue(':fname', '', PDO::PARAM_STR);
		$ins_par->bindvalue(':sname', '', PDO::PARAM_STR);
		$ins_par->bindvalue(':email', '', PDO::PARAM_STR);
		$ins_par->bindvalue(':occupation', '', PDO::PARAM_STR);
		$ins_par->bindvalue(':state_of_residence', '', PDO::PARAM_STR);
		$ins_par->bindvalue(':lga', '', PDO::PARAM_STR);
		$ins_par->bindvalue(':address', '', PDO::PARAM_STR);
		$ins_par->bindvalue(':status', 'BLANK', PDO::PARAM_STR);
		$ins_par->bindvalue(':entered_by', $npa_no, PDO::PARAM_STR);
		$ins_par->execute();
		
		//update the cadet_bio details
		$upd_cdt_bio=$mycon->prepare("UPDATE cadet_bio SET dob=:dob, gender=:gender, phone=:phone, email=:email,
			state=:state, lga=:lga, tribe=:tribe, parent_id=:parent_id, temp_edit_status=:temp_edit_status WHERE npa_no=:npa_no");
		$upd_cdt_bio->bindvalue(':dob', $dob, PDO::PARAM_STR);
		$upd_cdt_bio->bindvalue(':gender', $gender, PDO::PARAM_STR);
		$upd_cdt_bio->bindvalue(':phone', $phone, PDO::PARAM_STR);
		$upd_cdt_bio->bindvalue(':email', $email, PDO::PARAM_STR);
		$upd_cdt_bio->bindvalue(':state', $cdt_state, PDO::PARAM_STR);
		$upd_cdt_bio->bindvalue(':lga', $cdt_lga, PDO::PARAM_STR);
		$upd_cdt_bio->bindvalue(':tribe', $cdt_tribe, PDO::PARAM_STR);
		$upd_cdt_bio->bindvalue(':parent_id', $my_pid, PDO::PARAM_STR);
		$upd_cdt_bio->bindvalue(':temp_edit_status', 'EDITED', PDO::PARAM_STR);
		$upd_cdt_bio->bindvalue(':npa_no', $npa_no, PDO::PARAM_STR);
		$upd_cdt_bio->execute();
	}
	else{
		//get the parent_id of the cadet
		$tr_pid=$mycon->prepare("SELECT parent_id FROM cadet_bio WHERE npa_no=:npa_no");
		$tr_pid->bindvalue(':npa_no', $npa_no, PDO::PARAM_STR);
		$tr_pid->execute();
		while($rt_tr_pid=$tr_pid->fetch(PDO::FETCH_ASSOC)){
			$old_parent_id=$rt_tr_pid['parent_id'];
		}
		//update the cadet_bio details
		$upd_cdt_bio=$mycon->prepare("UPDATE cadet_bio SET dob=:dob, gender=:gender, phone=:phone, email=:email,
			state=:state, lga=:lga, tribe=:tribe, parent_id=:parent_id, temp_edit_status=:temp_edit_status WHERE npa_no=:npa_no");
		$upd_cdt_bio->bindvalue(':dob', $dob, PDO::PARAM_STR);
		$upd_cdt_bio->bindvalue(':gender', $gender, PDO::PARAM_STR);
		$upd_cdt_bio->bindvalue(':phone', $phone, PDO::PARAM_STR);
		$upd_cdt_bio->bindvalue(':email', $email, PDO::PARAM_STR);
		$upd_cdt_bio->bindvalue(':state', $cdt_state, PDO::PARAM_STR);
		$upd_cdt_bio->bindvalue(':lga', $cdt_lga, PDO::PARAM_STR);
		$upd_cdt_bio->bindvalue(':tribe', $cdt_tribe, PDO::PARAM_STR);
		$upd_cdt_bio->bindvalue(':parent_id', $old_parent_id, PDO::PARAM_STR);
		$upd_cdt_bio->bindvalue(':temp_edit_status', 'EDITED', PDO::PARAM_STR);
		$upd_cdt_bio->bindvalue(':npa_no', $npa_no, PDO::PARAM_STR);
		$upd_cdt_bio->execute();
		
	}
	
	//update the squad of the cadet as well
	$upd_sq=$mycon->prepare("UPDATE cadet_rc SET squad=:squad WHERE npa_no=:npa_no");
	$upd_sq->bindvalue(':squad', $cdt_squad, PDO::PARAM_STR);
	$upd_sq->bindvalue(':npa_no', $npa_no, PDO::PARAM_STR);
	$upd_sq->execute();
	
	
	header("location:../cadet_parent_info.php?err_msg=Your bio details was updated succesfully. Thank You !");
}
catch(PDOexception $e){
	$db_err=$e->getMessage();
	header("location:../cadet_home_page.php?err_msg=$db_err");
}
?>