<?php
	session_start();
	
	if(isset($_SESSION['loggedadminid'])){

		$userid = $_SESSION['loggedadminid'];
		
		include_once ("entity/ewallet.php");
		include_once ("admindao.php");
		
		$admin = $_SESSION['loggeduserid'];
		$userid = mysql_escape_string($_REQUEST ['userid']);
		$amount = mysql_escape_string($_REQUEST ['amount']);
		
		$ewallet = new EWallet();
		
		$dao = new AdminDAO();
			
		$ewallet->userid = $userid;
		$ewallet->balance = $amount;
			
		$added = $dao->addToEWallet($ewallet, $admin);			

		if($added===true)
			echo "done";
		else
			echo "error";
	}
	else
		echo "notlogged";
?>