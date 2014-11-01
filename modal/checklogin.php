<?php
	session_start();

	include_once("userdao.php");
	include_once("utility.php");
	include_once("entity/userdata.php");
	
	$dao = new UserDAO();
	
	$userid = mysql_escape_string($_REQUEST['loginuserid']);
	$password = mysql_escape_string($_REQUEST['loginpassword']);

	$today = date('Y-m-d h:i:s');
	
	$dao = new UserDAO();
	
	$user = $dao->findUser($userid);

    if(!isset($user)){
        echo "invalid";
    }
	else if($user->status=="disabled"){
		echo "disabled";
	}
	else if($user->status=="pending"){
		echo "pending";
	}
	else{

		$valid = $dao->isValidUser($userid, $password);
		
		if($valid===true){
			
			include_once("entity/userdata.php");
			
			$userdata = $dao->findUser($userid);
			
			$_SESSION['loggeduseremail'] = $userdata->email;
			$_SESSION['loggeduserid'] = $userdata->userid;
			$_SESSION['loggedusername'] = $userdata->name;
			$_SESSION['last_activity'] = time();
				
			echo "correct";
		}
		else
			echo "invalid";
	}
?>