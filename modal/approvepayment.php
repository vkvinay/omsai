<?php
	session_start();
	
	if(isset($_SESSION['loggeduserid'])){
	
		include_once ("userdao.php");
		
		$transactionid = $_REQUEST['transactionid'];
		$userid = $_REQUEST['userid'];
		$approvedby = $_SESSION['loggeduserid'];
		
		$dao = new UserDAO();
		
		$updated = $dao->approvePayment($transactionid, $userid, $approvedby);
		
		if($updated===true)
			echo "done";
		else
			echo "error";
	}
	else
		echo "notlogged";
?>