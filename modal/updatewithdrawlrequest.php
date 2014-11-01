<?php
	session_start();
	
	if(isset($_SESSION['loggedadminid'])){
	
		include_once ("admindao.php");
		
		$admin = $_SESSION['loggedadminid'];
		$request_id = $_REQUEST['request_id'];
		$status = $_REQUEST['status'];
		echo "admin = $admin";
		$dao = new AdminDAO();
		
		$updated = $dao->updatePairWithdrawlRequest($request_id, $status, $admin);		
		
		if($updated===true)
			echo "done";
		else
			echo "error";
	}
	else
		echo "notlogged";
?>