<?php
class Utility {
	public static function getHoursBetweenDates($date1, $date2) {
/*		$date1 = new DateTime ( $dt1 );
		$date2 = new DateTime ( $dt2 );
		
		echo "<br/> hi <br/>";
		
		$diff = $date2->diff ( $date1 );
		
		echo "** " . $diff->h . " , " . $diff->d;
		
		$hours = $diff->h;
		$hours = $hours + ($diff->d * 24);
		
		return $hours;
*/

		$diff = abs(strtotime($date2) - strtotime($date1));
		
		$hours = floor($diff/3600);
				
		return floor($hours);
	}
	
	public static function getLevelAmount($level){
		$level_income = array(1000,2000,4000,8000,16000,32000,64000,128000);
		
		return $level_income[$level];
	}
	
	public static function sendRegistrationEmail($userdata) {
		
		try {
			$message ="Dear " . $userdata->name . ", <br/>We welcome you to the usdp family. Thank you for choosing us. <br/><br/>Your ID is : " . $userdata->userid . "<br/><br/>Password is : " . base64_decode($userdata->password);
			
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
			$message ="Dear " . $userdata->name . ", We welcome you to the usdp family. Thank you for choosing us. Your ID is : " . $userdata->userid . ", Username is : " . $userdata->name . " and Password is : " . base64_decode($userdata->password);

			$from = "USDPRG"; // This is who the message appears to be from.
			
			$fromCountry = "91"; // Change this to the appropriate country code (default
			// UK)
			
			$to = $fromCountry . $userdata->contact_number; //A single number or a comma-seperated list of numbers 
			
			// $message = "This is a test message from the PHP API script"; //160 chars or less
			
			$username = "amartran"; // insert your username
			
			$pword = "demo1234"; //Your developer API password
			
			$hash = "RjK=H4kL"; //Do not change
			
			$sourceinfo = "1"; //Display POST info
			
			//extract data from the post
			
			//extract($_POST);
			
			//set POST variables
			
			//"http://182.72.103.86/websmpp/websms?user=$username&pass=$pword&sid=$from&mno=$to&text=$message&type=1&esm=0&dcs=0";
			
			$url ="http://pinnacle.citycollegeroorkee.in/sendsms.jsp?user=$username&password=$pword&mobiles=$to&sms=$message&unicode=0&senderid=USDPRG&version=3";
										
			echo "<iframe src='$url' width='1' height='1'></iframe>";
			
		}
		catch( Exception $ex){
			echo $ex->errorMessage();
		}
	}
}
?>