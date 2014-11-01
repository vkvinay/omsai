<?php
	include_once 'modal/userdao.php';
	
	$dao = new UserDAO();
	
	$ar = $dao->getAllUsers(0, 100);
	
	for($i=0;$i<count($ar);$i++){
		$ob = $ar[$i];
		
		$userid = $ob->userid;
		$password = $ob->password;
		$transaction_password = $ob->transaction_password;
		
		$password = base64_decode($password);
		$transaction_password = base64_decode($transaction_password);
		
		echo "$userid , $password , $transaction_password<br/>";
	}
?>