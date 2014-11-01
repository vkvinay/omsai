<?php
	session_start();
	
	if(isset($_SESSION['loggedadminid'])){
	
		include_once ("admindao.php");
		
		$dao = new AdminDAO();
		
		$userid = $_SESSION['loggedadminid'];
		
		$oldpassword = mysql_escape_string($_REQUEST ['oldpassword']);
		$password = mysql_escape_string($_REQUEST ['password']);
		
		if($dao->oldPasswordValid($userid,$oldpassword)===false)
			echo "invalidold";
		else{
			$updated = $dao->updatePassword($userid, $password);
			
			if($updated===true)
				echo "done";
			else
				echo "error";
		}
	}
	else
		echo "notlogged";
?>