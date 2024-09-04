<?php
session_start();
session_destroy();
if(isset($_GET['err_msg'])){
	$mango=$_GET['err_msg'];
}
else{
	$mango="LOG OUT SUCCESSFUL";
}

//echo $err_msg;
header("location:index.php?err_msg=$mango");
?>