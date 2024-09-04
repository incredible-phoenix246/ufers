<?php
session_start();
include("../ufers_con/ufers_con.php");
include("../sections/cadet_verifier.php");


$p_sname=$_POST['p_sname'];
$p_fname=$_POST['p_fname'];
$p_email=$_POST['p_email'];
$p_occupation=$_POST['p_occupation'];
$p_phone1=$_POST['p_phone1'];
$p_phone2=$_POST['p_phone2'];
$p_state=$_POST['p_state'];
$p_lga=$_POST['p_lga'];
$p_address=$_POST['p_address'];

try{
	//echo "$parent_id---$p_sname---$p_fname---$p_email---$p_occupation---$p_phone1--$p_phone2--$p_state--$p_lga--$p_address";
	//update the parent details
	$ins_par=$mycon->prepare("UPDATE cadet_parents SET fname=:fname, sname=:sname, email=:email, occupation=:occupation,
	state_of_residence=:state_of_residence, lga=:lga, address=:address, status=:status, entered_by=:entered_by 
	WHERE parent_id=:parent_id");
	$ins_par->bindvalue(':fname', $p_fname, PDO::PARAM_STR);
	$ins_par->bindvalue(':sname', $p_sname, PDO::PARAM_STR);
	$ins_par->bindvalue(':email', $p_email, PDO::PARAM_STR);
	$ins_par->bindvalue(':occupation', $p_occupation, PDO::PARAM_STR);
	$ins_par->bindvalue(':state_of_residence', $p_state, PDO::PARAM_STR);
	$ins_par->bindvalue(':lga', $p_lga, PDO::PARAM_STR);
	$ins_par->bindvalue(':address', $p_address, PDO::PARAM_STR);
	$ins_par->bindvalue(':status', 'FILLED', PDO::PARAM_STR);
	$ins_par->bindvalue(':parent_id', $parent_id, PDO::PARAM_STR);
	$ins_par->bindvalue(':entered_by', $npa_no, PDO::PARAM_STR);
	$ins_par->execute();
	
	//now enter the phone numbers
	if($p_phone1!=""){
		$ins_phone_1=$mycon->prepare("INSERT INTO cadet_parent_phone (parent_id, phone) VALUES (:parent_id, :phone)");
		$ins_phone_1->bindvalue(':parent_id', $parent_id, PDO::PARAM_STR);
		$ins_phone_1->bindvalue(':phone', $p_phone1, PDO::PARAM_STR);
		$ins_phone_1->execute();
	}
	if($p_phone2!=""){
		$ins_phone_2=$mycon->prepare("INSERT INTO cadet_parent_phone (parent_id, phone) VALUES (:parent_id, :phone)");
		$ins_phone_2->bindvalue(':parent_id', $parent_id, PDO::PARAM_STR);
		$ins_phone_2->bindvalue(':phone', $p_phone2, PDO::PARAM_STR);
		$ins_phone_2->execute();
	}
	
	header("location:../cadet_parent_info.php?err_msg=Your parents details were captured succesfully. Thank You !");
}
catch(PDOexception $e){
	$db_err=$e->getMessage();
	header("location:../cadet_parent_info.php?err_msg=$db_err");
}
/*

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
while($rt_par_phones=$par_phones->fetch(PDO::FETCH_ASSOC)){
	if($par_phones->rowcount()>1){
		$p_phone1=$rt_par_info['phone'];
		$p_phone2=$rt_par_info['phone'];
	}
	else{
		$p_phone1=$rt_par_info['phone'];
	}	
}
*/

?>