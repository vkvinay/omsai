<?php
	session_start();

	include_once("admindao.php");
	
	$dao = new AdminDAO();
	
	$userid = mysql_escape_string($_SESSION['loggedadminid']);
	$password = mysql_escape_string($_REQUEST['password']);

	$today = date('Y-m-d h:i:s');
	
	$dao = new AdminDAO();
	
	$valid = $dao->isValidAdminTransactionPassword($userid, $password);
	
	if($valid===true){
		$_SESSION['last_activity'] = time();

		echo "correct";
	}
	else
		echo "wrong";
?>