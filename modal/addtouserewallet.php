<?php
	session_start();
	
	if(isset($_SESSION['loggeduserid'])){

		include_once ("userdao.php");
		
		$fromuserid = $_SESSION['loggeduserid'];
		$touserid = mysql_escape_string($_REQUEST ['userid']);
		$amount = mysql_escape_string($_REQUEST ['amount']);
		
		$dao = new UserDAO();
			
		$user = $dao->findUser($touserid);
		
		if(isset($user)){
			
			if($user->status=="active"){
				
				$ewallet = $dao->getUserEWallet($fromuserid);
				
				if($ewallet->balance<$amount)
					echo "insufficient";
				else{
					$added = $dao->addToUserEWallet($fromuserid, $touserid, $amount);			
			
					if($added===true)
						echo "done";
					else
						echo "error";
				}
			}
			else
				echo "pending";
		}
		else
			echo "invalid";
	}
	else
		echo "notlogged";
?>