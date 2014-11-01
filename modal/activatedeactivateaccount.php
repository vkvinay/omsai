<?php
	session_start();
	
	if(isset($_SESSION['loggedadminid'])){
	
		include_once ("userdao.php");
		include_once ("admindao.php");
		
		$me = 0;
		$userid = $_REQUEST['userid'];
		$action = $_REQUEST['action'];
		
		$dao = new UserDAO();
		$adao = new AdminDAO();
		$user = $dao->findUser($userid);
		
		$updated = $adao->activateDeactivateUser($userid, $me, $action);
		
		if($updated===true)
			echo "done";
		else
			echo "error";
	}
	else
		echo "notlogged";
?>