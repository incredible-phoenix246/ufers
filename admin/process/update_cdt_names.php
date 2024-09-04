<?php
include("../../ufers_con/ufers_con.php");

$npa_no=$_POST['npa_no'];
$cdt_sname=$_POST['cdt_sname'];
$cdt_fname=$_POST['cdt_fname'];
$cdt_onames=$_POST['cdt_onames'];

try{
	//now unseal the parent_id
	$upd_cdt_bio=$mycon->prepare("UPDATE cadet_bio SET fname=:fname, sname=:sname, onames=:onames WHERE npa_no=:npa_no");
	$upd_cdt_bio->bindvalue(':npa_no', $npa_no, PDO::PARAM_STR);
	$upd_cdt_bio->bindvalue(':fname', $cdt_fname, PDO::PARAM_STR);
	$upd_cdt_bio->bindvalue(':sname', $cdt_sname, PDO::PARAM_STR);
	$upd_cdt_bio->bindvalue(':onames', $cdt_onames, PDO::PARAM_STR);
	$upd_cdt_bio->execute();
	header("location:../admin_page.php?err_msg=Department Changed for $npa_no !!!");
}
catch(PDOException $e){
	$db_err=$e->getMessage();
	header("location:../admin_page.php?err_msg=$db_err");
}
?>