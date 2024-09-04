<?php
include("../../ufers_con/ufers_con.php");

$npa_no=$_GET['npa_no'];

try{
	//first get the parent_id
	$pid=$mycon->prepare("SELECT parent_id FROM cadet_bio WHERE npa_no=:npa_no");
	$pid->bindvalue(':npa_no', $npa_no, PDO::PARAM_STR);
	$pid->execute();
	while($rt_pid=$pid->fetch(PDO::FETCH_ASSOC)){
		$parent_id=$rt_pid['parent_id'];
	}
	if($parent_id=="2300001"){
		header("location:../admin_page.php?err_msg=Cannot Unseal this record. Check if cadet updated their own details first !!!");
	}
	else{
		//now unseal the parent_id
		$upd_pr=$mycon->prepare("UPDATE cadet_parents SET status=:blank WHERE parent_id=:parent_id");
		$upd_pr->bindvalue(':blank', 'BLANK', PDO::PARAM_STR);
		$upd_pr->bindvalue(':parent_id', $parent_id, PDO::PARAM_STR);
		$upd_pr->execute();
		header("location:../admin_page.php?err_msg=Parents records Unsealed !!!");
	}
}
catch(PDOException $e){
	$db_err=$e->getMessage();
	header("location:../admin_page.php?err_msg=$db_err");
}
?>