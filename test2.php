<?php
		include_once ("modal/userdao.php");
		
		$userid = 33;
		
		$udao = new UserDAO();
		$userdata = $udao->findUser($userid);
		try{
				$message = urlencode("Dear " . $userdata->name . ", We welcome you to the usdp family. Thank you for choosing us. Your ID is : " . $userdata->userid . ", Password is : " . base64_decode($userdata->password) . " and Transaction Password is : " . base64_decode($userdata->transaction_password));
	
				$from = "USDPRG"; // This is who the message appears to be from.
				
				$fromCountry = "91"; // Change this to the appropriate country code (default
				// UK)
				
				$to = urlencode($fromCountry . $userdata->contact_number); //A single number or a comma-seperated list of numbers 
				
				// $message = "This is a test message from the PHP API script"; //160 chars or less
				
				$username = "amartran"; // insert your username
				
				$pword = "demo1234"; //Your developer API password
				
				$hash = "RjK=H4kL"; //Do not change
				
				$sourceinfo = "1"; //Display POST info
				
				//$url ="http://pinnacle.citycollegeroorkee.in/sendsms.jsp?user=$username&password=$pword&mobiles=$to&sms=$message&unicode=0&senderid=USDPRG&version=3";

				//$url = "GET $url HTTP/1.1rn";
				
//				echo $url;

//				$header = "GET $script HTTP/1.1rn".
				
				//"Host: $hostrn". "User-Agent: HTTP/1.1rn". "Content-Type: application/x-www-form-urlencodedrn". "Content-Length: $request_lengthrn". "Connection: closernrn". "$requestrn";
				
				//Now we open up the connection
				
				$host = "pinnacle.citycollegeroorkee.in:80";
				$script = "/sendsms.jsp?user=$username&password=$pword&mobiles=$to&sms=$message&unicode=0&senderid=USDPRG&version=3";
				
				echo "[$script]<br/><br/>";
				
				$out = "GET $script HTTP/1.1\r\n";
				$out .= "Host: $host\r\n";
				$out .= "Accept: */*\r\n";
				$out .= "Connection: Close\r\n\r\n";

				echo $out;
				
				echo "<br/><br/>-----------------------------------------------------<br/><br/>";
				
				$socket = @fsockopen($host, 80, $errno, $errstr);
				echo "[$errno , $errstr]";
				if ($socket) //if its open, then...		
				{ 
					fputs($socket, $out);
				
					// 	send the details over
					$output = "";
					while(!feof($socket)){ 
						$output .= fgets($socket,128);
					}
					print($output);
						
					//get the results
				
					fclose($socket);				
				}
				
			}
			catch( Exception $ex){
				echo $ex->errorMessage();
			}
	?>