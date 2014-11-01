<?php
	session_start();

	include_once("userdao.php");
	
	$dao = new UserDAO();
	
	$userid = $_SESSION['loggeduserid'];
	$password = mysql_escape_string($_REQUEST['password']);

	$password = base64_encode($password);
	
	$valid = $dao->isValidTransactionPassword($userid, $password);
		
	if($valid===true)
		echo "valid";
	else
		echo "wrong";
?>