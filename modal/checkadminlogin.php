<?php
	session_start();

	include_once("admindao.php");
	
	$dao = new AdminDAO();
	
	$userid = mysql_escape_string($_REQUEST['loginuserid']);
	$password = mysql_escape_string($_REQUEST['loginpassword']);

	$today = date('Y-m-d h:i:s');

	$dao = new AdminDAO();
	
	$valid = $dao->isValidAdmin($userid, $password);
	
	if($valid===true){

		$_SESSION['last_activity'] = time();
		$_SESSION['loggedusername'] = "Administrator";
		$_SESSION['loggedadminid'] = $userid;
			
		echo "correct";
	}
	else
		echo "invalid";
?>