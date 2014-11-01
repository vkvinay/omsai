<?php
	session_start();
	
	if(isset($_SESSION['loggeduserid'])){

		$userid = $_SESSION['loggeduserid'];

		include_once ("userdao.php");
		include_once ("admindao.php");
		
		$userid = $_SESSION['loggeduserid'];
		$amount = mysql_escape_string($_REQUEST ['amount']);
		
		$dao = new UserDAO();
		$udao = new UserDAO();
		$adao = new AdminDAO();
		
		$user = $udao->findUser($userid);
		
		$leftsideid = $user->leftside;
		$rightsideid = $user->rightside;
		
		$left_count = 0;
		$right_count = 0;
		
		if(isset($leftsideid)){
			$left_count++;
		}
		
		if(isset($rightsideid)){
			$right_count++;
		}
		
		$udao->totalcount = 0;
		
		if(isset($leftsideid)){
		
			$udao->getChildCount($leftsideid);
			$left_count += $udao->totalcount;
		}
		
		$udao->totalcount = 0;
		
		if(isset($rightsideid)){
			$udao->getChildCount($rightsideid);
			$right_count += $udao->totalcount;
		}
		
		if($left_count==$right_count)
			$pair = $left_count;
		else if($left_count<$right_count)
			$pair = $left_count;
		else if($left_count>$right_count)
			$pair = $right_count;
		
		$pairincome = $pair * 100;
		
		$logs = $adao->getPairIncomeLogs($userid);
		$total = 0;
		
		if(isset($logs) && count($logs)>0){
			foreach($logs as $log){
				$total = $total + $log->amount;
			}
		}
		
		$pairincome -= $total;
		
		if($pairincome<$amount)
			echo "invalid";
		else{
			$added = $dao->transferToEWallet($userid, $amount);				
	
			if($added===true)
				echo "done";
			else
				echo "error";
		}
	}
	else
		echo "notlogged";
?>