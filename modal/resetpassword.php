<?php
	function get_random_string($valid_chars, $length)
	{
		// start with an empty random string
		$random_string = "";
	
		// count the number of chars in the valid chars string so we know how many choices we have
		$num_valid_chars = strlen($valid_chars);
	
		// repeat the steps until we've created a string of the right length
		for ($i = 0; $i < $length; $i++)
		{
		// pick a random number from 1 up to the number of valid chars
		$random_pick = mt_rand(1, $num_valid_chars);
	
		// take the random character out of the string of valid chars
		// subtract 1 from $random_pick because strings are indexed starting at 0, and we started picking at 1
		$random_char = $valid_chars[$random_pick-1];
	
		// add the randomly-chosen char onto the end of our string so far
		$random_string .= $random_char;
		}
	
		// return our finished random string
		return $random_string;
	}

	include_once ("entity/userdata.php");
	include_once ("userdao.php");
	
	$email = mysql_escape_string($_REQUEST ['email']);

	$dao = new UserDAO();

	$original_string = 'abcdefghijklmnopqrstuvwxyz';
	$newpassword = get_random_string($original_string, 6);
	
	$userdata = $dao->findUserByEmail($email);
	
	if($userdata!=null){
		
		$userdata->password = md5($newpassword);
		
		$updated = $dao->updateUser($userdata);
		
		if($updated===true){
			
			
			//begin of HTML message
			$message = "
			
			<html>
			<body bgcolor='#DCEEFC'>
			
			Password retrieval <br/><br/>
			
			Your password is:  <b>$password</b><br/><br/>
			
			<br />
			<br />
			<b><i>This is an auto-generated mail , please do not reply</i></b>
			</body>
			</html>
			";
			
			/*
			 $from = "info@internationalfxbusiness.com";
			 $subject = "Lost password";
			 $password = "1nternati0nalfxbus1ness.c0m";
			
			 require("phpmailer/class.phpmailer.php");
			 require("phpmailer/class.smtp.php");
			
			 $from = "info@internationalfxbusiness.com";
			 $subject = "Code validation @ internationalfxbusiness";
			 $password = "1nternati0nalfxbus1ness.c0m";
			
			 $mail = new PHPMailer();
			 $mail->IsSMTP();
			 $mail->SMTPAuth = true; 			// turn on SMTP authentication
			 $mail->SMTPDebug = 1;
			
			 $mail->SMTPSecure = 'ssl';                  // enable SMTP authentication
			 //$mail->Host = 'mail.internationalfxbusiness.com';      // sets SMTP server
			 $mail->Host = 'gains.monstercloudservers.com';
			 //$mail->Port = 587;
			 $mail->Port = 465;
			 $mail->AddAddress($email);
			 $mail->Username = "info@internationalfxbusiness.com"; // SMTP username
			
			 $mail->Password = $password; // SMTP password
			 $mail->AddReplyTo("info@internationalfxbusiness.com","Moderator");
			 $mail->Subject = $subject;
			 $mail->Body = $message;
			 $mail->From = $from;
			 $mail->FromName = "info@internationalfxbusiness";
			 $mail->ContentType = "text/html";
			
			 $result = $mail->Send();
			
			 if($result){
			 echo "done";
			 }
			 else
			 	echo "error";
			
			 }
			 else
			 	echo "error";
			 */
			 $headers = 'From: admin@usdpco.co.uk' . "\r\n";
			 $headers .= "MIME-Version: 1.0" . "\r\n";
			 $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
			
			 $subject = "Password recovery";
			
			 $result = mail($email,$subject,$message,$headers);
			
			 if($result)
			 	echo "done";
			else
				echo "error";
		}
		else
			echo "error";
	}
	else
		echo "invalid";
?>