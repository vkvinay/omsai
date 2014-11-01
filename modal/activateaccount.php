<?php
	session_start();
	
	if(isset($_SESSION['loggedadminid'])){
	
		include_once ("admindao.php");
		include_once ("userdao.php");
		
		$me = 0;
		$userid = $_REQUEST['userid'];
		
		$dao = new AdminDAO();
		$udao = new UserDAO();
		
		$updated = $dao->activateUser($userid, $me);
		
		if($updated===true){
/*			
			$userdata = $udao->findUser($userid);
			
//			include_once ("utility.php");

			try {
				$message ="Dear " . $userdata->name . ", <br/>We welcome you to the usdp family. Thank you for choosing us. <br/><br/>Your ID is : " . $userdata->userid . "<br/>Password is : " . base64_decode($userdata->password) . "<br/>Transaction Password is : " . base64_decode($userdata->transaction_password);
				
				require 'phpmailer/class.phpmailer.php';
				
				$mail = new PHPMailer ( true ); // New instance, with exceptions enabled
				
				$mail->IsSMTP (); // tell the class to use SMTP
				
				$mail->SMTPAuth = true; // enable SMTP authentication
				
				$mail->Port = 25; // set the SMTP server port
				
				$mail->Host = "mail.usdp.co.uk"; // SMTP server
				
				$mail->Username = "registration@usdp.co.uk"; // SMTP server username
				
				$mail->Password = "registration"; // SMTP server password
				
				$mail->From = "registration@usdp.co.uk";
				
				$mail->FromName = "USDP.CO.UK";
				
				$mail->AddAddress ($userdata->email);
				
				$mail->Subject = "Successful registration";
				
				$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; 
				
				$mail->WordWrap = 80; // set word wrap
				
				$mail->MsgHTML ( $message );
				
				$mail->IsHTML ( true ); // send as HTML
				
				$mail->Send ();
				
				// echo 'Message has been sent.';
			
			} catch ( phpmailerException $e ) {
				
				 echo $e->errorMessage();
			
			}
			
			try{
				$message ="Dear " . $userdata->name . ", We welcome you to the usdp family. Thank you for choosing us. Your ID is : " . $userdata->userid . ", Password is : " . base64_decode($userdata->password) . " and Transaction Password is : " . base64_decode($userdata->transaction_password);
	
				$from = "USDPRG"; // This is who the message appears to be from.
				
				$fromCountry = "91"; // Change this to the appropriate country code (default
				// UK)
				
				$to = $fromCountry . $userdata->contact_number; //A single number or a comma-seperated list of numbers 
				
				// $message = "This is a test message from the PHP API script"; //160 chars or less
				
				$username = "amartran"; // insert your username
				
				$pword = "demo1234"; //Your developer API password
				
				$hash = "RjK=H4kL"; //Do not change
				
				$sourceinfo = "1"; //Display POST info
				
				//$url ="http://pinnacle.citycollegeroorkee.in/sendsms.jsp?user=$username&password=$pword&mobiles=$to&sms=$message&unicode=0&senderid=USDPRG&version=3";
				
				$data = "user=$username&password=$pword&mobiles=$to&sms=$message&unicode=0&senderid=USDPRG&version=3";
				
				$url = "http://pinnacle.citycollegeroorkee.in/sendsms.jsp";
				
				$ch = curl_init($url); //note https for SSL
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch); //This is the result from Textlocal
				curl_close($ch);
								
			}
			catch( Exception $ex){
				echo $ex->errorMessage();
			}
*/			
		}
		else
			echo "error";
	}
	else
		echo "notlogged";
?>