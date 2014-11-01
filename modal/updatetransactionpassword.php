<?php
	session_start();
	
	if(isset($_SESSION['loggeduserid'])){
	
		include_once ("entity/userdata.php");
		include_once ("userdao.php");
		
		$dao = new UserDAO();
		
		$userid = $_SESSION['loggeduserid'];
		
		$oldpassword = mysql_escape_string($_REQUEST ['oldpassword']);
		$password = mysql_escape_string($_REQUEST ['password']);
		
		$oldpassword = base64_encode($oldpassword);
		$password = base64_encode($password);
		
		if($dao->oldTransactionPasswordValid($userid,$oldpassword)===false)
			echo "invalidold";
		else{
			$updated = $dao->updateTransactionPassword($userid, $password);
			
			if($updated===true)
				echo "done";
			else
				echo "error";
		}
	}
	else
		echo "notlogged";
?>