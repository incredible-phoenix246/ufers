<?php
include("../../ufers_con/ufers_con.php");

$npa_no=$_POST['npa_no'];
$old_dept=$_POST['old_dept'];
$cur_dept=$_POST['cur_dept'];

try{
	//now unseal the parent_id
	$upd_dept=$mycon->prepare("UPDATE cadet_dept SET dept_code=:cur_dept WHERE npa_no=:npa_no");
	$upd_dept->bindvalue(':cur_dept', $cur_dept, PDO::PARAM_STR);
	$upd_dept->bindvalue(':npa_no', $npa_no, PDO::PARAM_STR);
	$upd_dept->execute();
	header("location:../admin_page.php?err_msg=Department Changed for $npa_no !!!");
}
catch(PDOException $e){
	$db_err=$e->getMessage();
	header("location:../admin_page.php?err_msg=$db_err");
}
?>