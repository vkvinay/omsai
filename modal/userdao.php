<?php
class UserDAO {

	var $leftcount = 0;			// for getLeftCount() 
	var $rightcount = 0;		// for getRightCount()
	var $totalcount = 0;
	var $arcount = -1;
	var $ar = array();
	
	function addUser($userdata, $added_by_id) {
		
		include_once ("database.php");		
		include_once ("data.php");
		
		$qry = "insert into userdata(email,name,password,sex,contact_number,city,country,address,joindate,status,sponsorid,transactionpassword,parentid,accountholdername,bankname,branch,accountnumber,ifsccode) values('" . 
		$userdata->email . "','" . 
		$userdata->name . "','" . 
		$userdata->password . "','" . 
		$userdata->sex . "','" . 
		$userdata->contact_number . "','" . 
		$userdata->city . "','" . 
		$userdata->country . "','" . 
		$userdata->address . "','" . 
		$userdata->joindate . "','" . 
		$userdata->status . "'," .
		$userdata->sponsorid . ",'" . 
		$userdata->transaction_password . "'," . 
		$userdata->parent_id . ",'" .
		$userdata->account_holder_name . "','" .
		$userdata->bank_name . "','" .
		$userdata->branch . "','" .
		$userdata->account_number . "','" .
		$userdata->ifsc_code . "')";
		
		$id = Database::executeQueryForID($qry);
		
		$userdata->userid = $id;
		
		$qry = "insert into ewallet(userid,balance,last_update) values(" . $id . ",0,'" . date('Y-m-d h:i:s') . "')";
		Database::executeQuery($qry);
		
		$ewallet = $this->getUserEWallet($added_by_id);
		
		if($ewallet->balance>=Data::$entry_amount){
			
			$this->deductBalance($added_by_id, Data::$entry_amount);
			
			include_once ("admindao.php");
			
			$adao = new AdminDAO();
			
			$adao->activateUser($id, $added_by_id);
			
			//$this->sendWelcomeSms($userdata);
			
			// check if at level 4 or above and a new entry added
/*			
			//$sponsorer = $this->findUser($userdata->sponsorid);
			$sponsorer = $this->findUser($userdata->parent_id);
			$level_info = $this->getLatestLevelInfo($sponsorer->userid);
			
			if($sponsorer->isadmin=="n"){
				
				if($level_info->level>=3){

					if($this->userAddedAfterReachingLevel($level_info)){
						$this->setReceivers($sponsorer->userid, $level_info->level);
					}
				}
			}		
*/				
		}
		
		return $id;
	}

	function userAddedAfterReachingLevel($level_info){
		
		$qry = "select userid from userdata where parentid=" . $level_info->userid . " and activationdate > '" . $level_info->reachingdate . "'";
		include_once ("database.php");
		
		return Database::dataExists($qry);
	}
	
	function addPairWithdrawlRequest($pair_withdrawl_request) {
	
		include_once ("database.php");
	
		$qry = "insert into pair_withdrawl_request(userid,amount,request_date,status) values(" .
				$pair_withdrawl_request->userid . "," .
				$pair_withdrawl_request->amount . ",'" .
				date('Y-m-d h:i:s') . "','pending')";
	
		return Database::executeQuery($qry);
	}
	
	function transferToEWallet($userid, $amount) {
	
		include_once ("database.php");
	
		$qry1 = "update ewallet set balance=balance+$amount where userid=$userid";
	
		$qry2 = "insert into ewallet_log(admin,userid,amount,create_date,message) values('user',$userid,$amount,'" . date('Y-m-d h:i:s') . "','PairToEWallet')";
		
		return Database::executeQuery($qry1) && Database::executeQuery($qry2);
	}
	
	function getRequestHistory($userid, $start, $recordcount) {
	
		include_once ("database.php");
	
		$qry = "select request_id,userid,amount,request_date,status from pair_withdrawl_request where userid=$userid order by request_date desc limit $start,$recordcount";
	
		$rows = Database::readData ( $qry );
	
		if ($rows == NULL)
			return NULL;
		else {
				
			include_once ("entity/pairwithdrawlrequest.php");
				
			$requests = array ();
			$ct = - 1;
				
			while($row = mysql_fetch_row($rows)){
	
				$request = new PairWithdrawlRequest();
	
				$request->request_id = $row [0];
				$request->userid = $row [1];
				$request->amount = $row [2];
				$request->request_date = $row [3];
				$request->status = $row [4];
	
				$requests [++ $ct] = $request;
			}
				
			return $requests;
		}
	}
	
	function deductBalance($userid, $amount){
		
		include_once ("database.php");
		
		$qry1 = "update ewallet set balance=balance-$amount where userid=$userid";

		$qry2 = "insert into ewallet_log(admin,userid,amount,create_date,message) values($userid,$userid,$amount,'" . date('Y-m-d h:i:s') . "','Debit')";		
		
		return Database::executeQuery ($qry1) && Database::executeQuery($qry2);
	}
	
	function incrementChildCount($userid){
		
		include_once ("database.php");
		
		$qry = "update userdata set childcount=childcount+1 where userid=" . $userid;
		
		return Database::executeQuery ( $qry );
	}

	function disablePendingUsers(){
		
		include_once ("database.php");
		
		$qry1 = "update levelinfo set status='disabled' where userid in (select senderid from paymenttransactions where status='pending' and datediff(now(),entrydate)*24 > 72)";
		Database::executeQuery ( $qry1 );

		$qry2 = "update userdata set status='disabled' where userid in (select senderid from paymenttransactions where status='pending' and datediff(now(),entrydate)*24 > 72)";
		Database::executeQuery ( $qry2 );
		
		$qry3 = "select userid,level from levelinfo where status='disabled'";
		$rows = Database::readData($qry3);
		
		if(isset($rows) && count($rows)>0){
			
			while($row = mysql_fetch_row($rows)){
				
				$t_userid = $row[0];
				$t_level = $row[1];
				
				$qry5 = "update levelinfo set entrycount=entrycount-1 where userid=(select receiverid from paymenttransactions where senderid=$t_userid and level=$t_level and status not in('disabled'))";
				Database::executeQuery($qry5);				
				
				$qry4 = "update paymenttransactions set status='disabled' where senderid=$t_userid and level=$t_level";
				Database::executeQuery($qry4);
			}
		}
	}
	
	function getPaymentTransaction($transactionid) {
	
		include_once ("database.php");
	
		$qry = "select transactionid,receiverid,senderid,level,entrydate,status,confirmdate from paymenttransactions where transactionid=$transactionid";
	
		$row = Database::readSingleRow ( $qry );
	
		if ($row == NULL)
			return NULL;
		else {
	
			include_once ("entity/paymenttransaction.php");
	
			$pt = new PaymentTransaction();
	
			$pt->transactionid = $row [0];
			$pt->receiverid = $row [1];
			$pt->senderid = $row [2];
			$pt->level = $row [3];
			$pt->entrydate = $row[4];
			$pt->status = $row[5];
			$pt->confirmdate = $row[6];
	
			return $pt;
		}
	}
	
	function approvePayment($transactionid, $userid, $approvedby){
	
		$payment_info = $this->getPaymentTransaction($transactionid);
		
		if($payment_info->status=="pending"){
			
			$this->disablePendingUsers();
			
			include_once ("database.php");
			include_once ("data.php");
			
			$activation_date = date('Y-m-d h:i:s');
			
			$qry1 = "update paymenttransactions set status='approved', confirmdate='$activation_date' where transactionid=$transactionid";
			$result1 = Database::executeQuery($qry1);
			
			// get the current level of user or approvedby who is approved
			$qry2 = "select max(level) from levelinfo where userid=$userid";
			$row = Database::readSingleRow($qry2);
			$level = $row[0];
						
			// increase the child count of approvedby
	 		$qry3 = "update levelinfo set childcount=childcount+1 where userid=$approvedby and level=$level";
	 		Database::executeQuery($qry3);
			 		
	 		$levelinfo = $this->getLatestLevelInfo($approvedby, $level);
	 		
	 		// check if childcount of approvedby reaches Data::$receiver_count, increase his level and new entry in paymenttransaction
	 		if($levelinfo->childcount==Data::$receiver_count){
	 			$nextlevel = intval($level+1);
		 		
		 		$userdata = $this->findUser($approvedby);
		 		if($userdata->isadmin=='y'){				// this is for admin record
		 			
		 			$qry4 = "insert into levelinfo(userid,level,reachingdate,status,receiverset,entrycount,childcount) values($approvedby,$nextlevel,'$activation_date','active','y',0,0)";
		 			Database::executeQuery($qry4);
	
	 				$qry5 = "insert into paymenttransactions(senderid,level,entrydate,status) values($approvedby,$nextlevel,'$activation_date','approved')";
	 				Database::executeQuery($qry5);
		 		}
		 		else{
		 			$qry4 = "insert into levelinfo(userid,level,reachingdate,status,entrycount,childcount) values($approvedby,$nextlevel,'$activation_date','active',0,0)";
		 			Database::executeQuery($qry4);	 				
		 		}
		 		
		 		// find and set a receiver that is already on new level for approvedby	
		 		if($userdata->isadmin=="n" && $nextlevel<3){
//		 			echo "Approve karne wala abhi level 3 par nahi pahuncha";
	 				$this->setReceivers($approvedby, $nextlevel);
				}
	 		}
	 		
	 		// find and set a receiver of approved user
	 		
	/************************************************ changed **************************/ 		
	// 		$this->setReceivers($userid, $level);
	/************************************************ changed **************************/
	
	 		$user_level = $this->getLatestLevelInfo($userid);
	 		if($user_level->level<3)
	 			$this->setReceivers($userid, $user_level->level);
	 		
	// now check all the users who have reached level 3 or more & have added 3 approved users under them & waiting for entry to be added in paymenttransaction 		
	 		
	 		
	 		
	 		// whenever a user is approved, find its sponsorer(parent) and then that sponsorers father(grandfather), check if grandfather is on level 4 onwards 
	 		// if yes, check if sponsorer's(father) left and right are also approved
	 		
	 		if($user_level->level==0){
	 			
		 		$approved_user = $this->findUser($userid);
	 			if($this->parentIsBlockedOnLevel3orMore($approved_user->parent_id)){
	 				
	 				$parent_level = $this->getLatestLevelInfo($approved_user->parent_id);
	 				
	 				if($this->parentAdded3ApprovedUsersAfterReachingLevel3OrMore($approved_user->parent_id)){
	 					$this->setReceivers($approved_user->parent_id, $parent_level->level);
	 				}
	 			}
	 			
	/*	 		
		 		$pitaji = $this->findUser($approved_user->parent_id);
		 		
		 		if(isset($pitaji)){
		 			
					echo "[ current user's pitaji found with id  " . $pitaji->userid . " ]<br/>";
		 			
		 			if(isset($pitaji->parent_id)){
		 				
		 				echo "<br/>Pitaji ka baap set hai...";
		 				
			 			$dadaji = $this->findUser($pitaji->parent_id);				
			
			 			if(isset($dadaji)){
			 				
			 				echo "<br/>Dadaji mil gaye " . $dadaji->userid;
			 				
					 		// check if parent has reached level 3 or onwards
			 				$dadaji_level = $this->getLatestLevelInfo($dadaji->userid);
				 			
			 				if($dadaji->isadmin=='n'){
			 				
			 					echo "[ current user's dadaji found with id  " . $dadaji->userid . " ]<br/>";
			 				
						 		if($dadaji_level->level>=3){		 			
					 			
					 				echo "[ Dadaji has reached level = " . $dadaji_level->level . " ]<br/>";
					 			
						 			$dadaji_payment_transaction = $this->getSenderPaymentTransaction($dadaji->userid, $dadaji_level->level);
					 			
						 			// no entry in payment transaction found for dadaji for that level
						 			if($dadaji_payment_transaction==NULL){
						 				
						 				echo "No entry found in payment trasaction for " . $dadaji->userid . " at level " . $dadaji_level->level . "<br/>";
						 				
							 			// check if parent user has added an id after reaching this maximum level
							 			if($this->userAddedAfterReachingLevel($dadaji_level)){
							 				
							 				echo "Dadaji added a user after reaching level " . $dadaji_level->level . "<br/>";
							 				
							 				// now get left and right side of pitaji
							 				
							 				if(isset($pitaji->leftside) && isset($pitaji->rightside) && $this->isApproved($pitaji->userid) && $this->isApproved($pitaji->leftside) && $this->isApproved($pitaji->rightside)){
				
							 					echo "Dadaji ka beta ki both sides exists and approved<br/>";
							 					
												$this->setReceivers($dadaji->userid, $dadaji_level->level);			 								 	
							 				}
							 			}
						 			}
						 		}
			 				}
			 				else{
			 				}
			 			}
			 			else
			 				echo "Dadaji nahi milay";
		 			}
	 			}
	*/ 			
		 	}
		}
		
 		return true;
	}

	function parentAdded3ApprovedUsersAfterReachingLevel3OrMore($userid){
		
		$level_info = $this->getLatestLevelInfo($userid);
		
		$qry = "select userid,rightside from userdata where parentid=$userid and activationdate> '" . $level_info->reachingdate . "'";
		echo "<br/>$qry";
		
		$rows = Database::readData($qry);
		
		if(isset($rows)){
			
			while($row = mysql_fetch_row($rows)){
				
				$tuserid = $row[0];
				
				$tuser = $this->findUser($tuserid);
				echo "<br/> tuser = " . $tuser->userid;
				
				if(isset($tuser->leftside) && isset($tuser->rightside) && $this->isApproved($tuser->userid) && $this->isApproved($tuser->leftside) && $this->isApproved($tuser->rightside)){
					
					echo "<br/>Tuser = " . $tuser->userid . " , left = " . $tuser->leftside . " , right = " . $tuser->rightside;
					
					return true;
				}
			}
		}
		
		return false;
	}
	
	function parentIsBlockedOnLevel3orMore($userid){
		
		$level_info = $this->getLatestLevelInfo($userid);
		
		$user_payment_transaction = $this->getSenderPaymentTransaction($userid, $level_info->level);
		
		return $user_payment_transaction==NULL;
	}
	
	function isApproved($userid){
		
		$level_info = $this->getLatestLevelInfo($userid);

		if(isset($level_info)){
			
			$payment_transaction = $this->getSenderPaymentTransaction($userid, $level_info->level);
			
			if(isset($payment_transaction)){
			
				return $payment_transaction->status=="approved";
			}
			else
				return false;
		}
	}
	
	function setReceivers($userid, $level){
		
		$activation_date = date('Y-m-d h:i:s');
		
		include_once ("data.php");
		
		$level_info = $this->getLatestLevelInfo($userid);
		$entryid = $level_info->entryid;
		
//		$qry5 = "select userid,childcount from levelinfo where userid<=$userid and level=$level and entrycount<" . Data::$receiver_count . " and userid in (select senderid from paymenttransactions where status='approved' and level=$level) order by entryid";
		
		$qry5 = "select userid,childcount,entryid from levelinfo where entryid<=$entryid and level=$level and entrycount<" . Data::$receiver_count . " and userid in (select senderid from paymenttransactions where status='approved' and level=$level) order by entryid";		
		$rows = Database::readData($qry5);
		echo "<br/>[ $qry5 ]";
		if(isset($rows) && count($rows)>0){
				
			while($approw=mysql_fetch_row($rows)){
		
				$currentid = $approw[0];
				
				if($level==1){
					
					$currentusernow = $this->findUser($currentid);
					
					$this->totalcount = 0;
					$leftcount = 1;
					$rightcount = 1;
					
					$this->getChildCount($currentusernow->leftside);
					$leftcount += $this->totalcount;
						
					$this->totalcount = 0;
					$this->getChildCount($currentusernow->rightside);
					$rightcount += $this->totalcount;
						
					echo "<br/>[ $currentid, $leftcount , $rightcount ]";
					
					if( $leftcount + $rightcount <3)
						continue;
				}				
				
				$childcount = $approw[1];
				$currententryid = $approw[2];
				
				$currentuser = $this->findUser($currentid);
				
				if($level==0){
					if(isset($currentuser->leftside) && isset($currentuser->rightside) && $this->isApproved($currentuser->leftside) && $this->isApproved($currentuser->rightside)){			// for level 0 only
							
						$toread = Data::$receiver_count - $childcount;			// mysql record count starts with 0
							
						$qry6 = "select userid from levelinfo where userid>$currentid and level=$level and receiverset='n' and entrycount<" . Data::$receiver_count . " and status not in('disabled') order by entryid limit 0,$toread";
						
						$parrows = Database::readData($qry6);
						echo "<br/>$qry6";
						if(isset($parrows) && count($parrows)>0){
								
							while($parrow=mysql_fetch_row($parrows)){
								$tuserid = $parrow[0];
			
								$qry7 = "insert into paymenttransactions(receiverid,senderid,level,entrydate,status) values($currentid,$tuserid,$level,'$activation_date','pending')";
								echo "<br/>$qry7";
								$result3 = Database::executeQuery($qry7);
									
								$qry8 = "update levelinfo set receiverset='y' where userid=$tuserid and level=$level";
								Database::executeQuery($qry8);
									
								$qry9 = "update levelinfo set entrycount=entrycount+1 where userid=$currentid and level=$level";
								Database::executeQuery($qry9);
								
								//$this->sendSMS($currentid, $tuserid);
							}
						}
					}
				}
				else{
					$toread = Data::$receiver_count - $childcount;			// mysql record count starts with 0
						
//					$qry6 = "select userid from levelinfo where userid>$currentid and level=$level and receiverset='n' and entrycount<" . Data::$receiver_count . " and status not in('disabled') order by entryid limit 0,$toread";
					$qry6 = "select userid from levelinfo where entryid>$currententryid and level=$level and receiverset='n' and entrycount<" . Data::$receiver_count . " and status not in('disabled') order by entryid limit 0,$toread";
					
					echo "<br/>( $qry6 )";
					$parrows = Database::readData($qry6);
					
					if(isset($parrows) && count($parrows)>0){
					
						while($parrow=mysql_fetch_row($parrows)){
							$tuserid = $parrow[0];
						
							$qry7 = "insert into paymenttransactions(receiverid,senderid,level,entrydate,status) values($currentid,$tuserid,$level,'$activation_date','pending')";
							echo "( $qry7 )<br/>";
							$result3 = Database::executeQuery($qry7);
								
							$qry8 = "update levelinfo set receiverset='y' where userid=$tuserid and level=$level";
							Database::executeQuery($qry8);
								
							$qry9 = "update levelinfo set entrycount=entrycount+1 where userid=$currentid and level=$level";
							Database::executeQuery($qry9);
					
							//$this->sendSMS($currentid, $tuserid);
						}
					}
				}
			}
		}
	}
	
	function sendWelcomeSms($userdata){
		include_once ("utility.php");
		
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
		
			$pword = "demo34"; //Your developer API password
		
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
		
	}
	
	function sendSMS($receiver, $sender){
		try{
			include_once 'utility.php';
				
			$userdata = $this->findUser($sender);
			$r_userdata = $this->findUser($receiver);
	
			$r_level = $this->getCurrentLevel($receiver);
	
			//$message ="Dear " . $userdata->name . ", We welcome you to the usdp family. Thank you for choosing us. Your ID is : " . $userdata->userid . ", Password is : " . base64_decode($userdata->password) . " and Transaction Password is : " . base64_decode($userdata->transaction_password);
			$message = "Dear " . $userdata->name . ", Please send gift Rs. " . Utility::getLevelAmount($r_level)  . " to NAME : " . $r_userdata->account_holder_name . ", BANK : " . $r_userdata->bank_name . ", ACCOUNT NO. : " . $r_userdata->account_number . ", IFSC CODE : " . $r_userdata->ifsc_code . " within 72 hours.";
	
			$from = "USDPRG"; // This is who the message appears to be from.
	
			$fromCountry = "91"; // Change this to the appropriate country code (default
			// UK)
	
			$to = $fromCountry . $userdata->contact_number; //A single number or a comma-seperated list of numbers
	
			// $message = "This is a test message from the PHP API script"; //160 chars or less
	
			$username = "amartran"; // insert your username
	
			$pword = "dem234"; //Your developer API password
	
			$hash = "RjK=H4kL"; //Do not change
	
			$sourceinfo = "1"; //Display POST info
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
	}
	
	function updateUser($userdata) {
		
		include_once ("database.php");
		
		$qry = "update userdata set " . 
				"name='" . $userdata->name . "'," . 
				"sex='" . $userdata->sex . "'," . 
				"email='" . $userdata->email. "'," . 
				"contact_number='" . $userdata->contact_number. "'," . 
				"city='" . $userdata->city . "'," . 
				"country='" . $userdata->country . "'," . 
				"address='" . $userdata->address . "'," . 
				"accountholdername='" . $userdata->account_holder_name . "'," .
				"bankname='" . $userdata->bank_name . "'," .
				"branch='" . $userdata->branch . "'," .
				"accountnumber='" . $userdata->account_number . "'," .
				"ifsccode='" . $userdata->ifsc_code . "' " .				
				"where userid=" . $userdata->userid;
		
		return Database::executeQuery ( $qry );
	}
	
	function setSponsorSide($side, $id, $sponsorid) {
	
		include_once ("database.php");
	
		if($side=="left")
			$qry = "update userdata set leftside=$id where userid=$sponsorid";
		else
			$qry = "update userdata set rightside=$id where userid=$sponsorid";
				
		return Database::executeQuery ( $qry );
	}
	
	function deleteUser($userid) {
		
		include_once ("database.php");
		
		$qry = "update userdata set status='removed' where userid=" . $userid;
		
		return Database::executeQuery ( $qry );
	}
	
	function findUser($userid) {
		
		include_once ("database.php");
		
		$qry = "select userid,name,email,password,sex,contact_number,city,country,address,joindate,status,leftside,rightside,sponsorid,transactionpassword,accountholdername,bankname,branch,accountnumber,ifsccode,parentid,childcount,paymentstatus,activationdate,activatedby,level,isadmin from userdata where userid=$userid";
		
		$row = Database::readSingleRow ( $qry );
		
		if ($row == NULL)
			return NULL;
		else {
			
			include_once ("entity/userdata.php");
			
			$userdata = new UserData ();
			
			$userdata->userid = $row [0];
			$userdata->name = $row [1];
			$userdata->email = $row [2];
			$userdata->password = $row [3];
			$userdata->sex = $row [4];
			$userdata->contact_number = $row [5];
			$userdata->city = $row [6];
			$userdata->country = $row [7];
			$userdata->address = $row [8];
			$userdata->joindate = $row [9];
			$userdata->status = $row [10];
			$userdata->leftside = $row [11];
			$userdata->rightside = $row [12];
			$userdata->sponsorid = $row [13];
			$userdata->transaction_password = $row [14];
			$userdata->account_holder_name = $row [15];
			$userdata->bank_name = $row [16];
			$userdata->branch = $row [17];
			$userdata->account_number = $row [18];
			$userdata->ifsc_code = $row [19];
			$userdata->parent_id = $row [20];
			$userdata->child_count = $row [21];
			$userdata->payment_status = $row [22];
			$userdata->activation_date = $row [23];
			$userdata->activated_by = $row [24];
			$userdata->level = $row[25];
			$userdata->isadmin = $row[26];
				
			return $userdata;
		}
	}
	
	function getUserEWallet($userid) {
	
		include_once ("database.php");
	
		$qry = "select walletid,userid,balance,last_update from ewallet where userid=$userid";
	
		$row = Database::readSingleRow ( $qry );
	
		if ($row == NULL)
			return NULL;
		else {
				
			include_once ("entity/ewallet.php");
				
			$ewallet = new EWallet();
				
			$ewallet->walletid = $row [0];
			$ewallet->userid = $row [1];
			$ewallet->balance = $row [2];
			$ewallet->last_update = $row [3];
	
			return $ewallet;
		}
	}
	
	function getLevelInfo($userid, $level) {
	
		include_once ("database.php");
	
		$qry = "select entryid,userid,level,reachingdate,childcount,status,entrycount from levelinfo where userid=$userid and level=$level";
	
		$row = Database::readSingleRow ( $qry );
	
		if ($row == NULL)
			return NULL;
		else {
				
			include_once ("entity/levelinfo.php");
				
			$li = new LevelInfo();
				
			$li->entryid = $row [0];
			$li->userid = $row [1];
			$li->level = $row [2];
			$li->reachingdate = $row [3];
			$li->childcount = $row[4];
			$li->status = $row[5];
			$li->entrycount = $row[6];
	
			return $li;
		}
	}
	
	function getLatestLevelInfo($userid) {
	
		include_once ("database.php");
	
		$qry = "select entryid,userid,level,reachingdate,childcount,status from levelinfo where userid=$userid and level=(select max(level) from levelinfo where userid=$userid)";
	
		$row = Database::readSingleRow ( $qry );
	
		if ($row == NULL)
			return NULL;
		else {
	
			include_once ("entity/levelinfo.php");
	
			$li = new LevelInfo();
	
			$li->entryid = $row [0];
			$li->userid = $row [1];
			$li->level = $row [2];
			$li->reachingdate = $row [3];
			$li->childcount = $row[4];
			$li->status = $row[5];
	
			return $li;
		}
	}
	
	function getSenderReport($userid) {
	
		include_once ("database.php");
	
		$qry = "select transactionid,receiverid,senderid,level,entrydate,status,confirmdate from paymenttransactions where senderid=$userid and status='approved' and receiverid is not null order by transactionid";
		
		$rows = Database::readData ($qry);
		
		if ($rows == NULL)
			return NULL;
		else {
			
			$ar = array();
			$ct = - 1;
			
			while($row = mysql_fetch_row($rows)){
			
				$pt = new PaymentTransaction();
			
				$pt->transactionid = $row [0];
				$pt->receiverid = $row [1];
				$pt->senderid = $row [2];
				$pt->level = $row [3];
				$pt->entrydate = $row[4];
				$pt->status = $row[5];
				$pt->confirmdate = $row[6];
			
				$ar [++$ct] = $pt;
			}
			
			return $ar;
		}
	}
	
	function getReceiverReport($userid) {
	
		include_once ("database.php");
	
		$qry = "select transactionid,receiverid,senderid,level,entrydate,status,confirmdate from paymenttransactions where receiverid=$userid and status='approved' order by transactionid";
	
		$rows = Database::readData ($qry);
	
		if ($rows == NULL)
			return NULL;
		else {
	
			$ar = array();
			$ct = - 1;
	
			while($row = mysql_fetch_row($rows)){
	
				$pt = new PaymentTransaction();
				
				$pt->transactionid = $row [0];
				$pt->receiverid = $row [1];
				$pt->senderid = $row [2];
				$pt->level = $row [3];
				$pt->entrydate = $row[4];
				$pt->status = $row[5];
				$pt->confirmdate = $row[6];
				
				$ar [++$ct] = $pt;
			}
	
			return $ar;
		}
	}
	
	function getReceiverPaymentTransaction($userid, $level) {
	
		include_once ("database.php");
	
		$qry = "select transactionid,receiverid,senderid,level,entrydate,status,confirmdate from paymenttransactions where receiverid=$userid and level=$level";
		
		$row = Database::readSingleRow ( $qry );
	
		if ($row == NULL)
			return NULL;
		else {
	
			include_once ("entity/paymenttransaction.php");
	
			$pt = new PaymentTransaction();
	
			$pt->transactionid = $row [0];
			$pt->receiverid = $row [1];
			$pt->senderid = $row [2];
			$pt->level = $row [3];
			$pt->entrydate = $row[4];
			$pt->status = $row[5];
			$pt->confirmdate = $row[6];
	
			return $pt;
		}
	}
	
	function getSenderPaymentTransaction($userid, $level) {
	
		include_once ("database.php");
	
		$qry = "select transactionid,receiverid,senderid,level,entrydate,status,confirmdate from paymenttransactions where senderid=$userid and level=$level";

		$row = Database::readSingleRow ( $qry );
	
		if ($row == NULL)
			return NULL;
		else {
	
			include_once ("entity/paymenttransaction.php");
	
			$pt = new PaymentTransaction();
	
			$pt->transactionid = $row [0];
			$pt->receiverid = $row [1];
			$pt->senderid = $row [2];
			$pt->level = $row [3];
			$pt->entrydate = $row[4];
			$pt->status = $row[5];
			$pt->confirmdate = $row[6];

			return $pt;
		}
	}
	
	function getCurrentLevel($userid) {
	
		include_once ("database.php");
	
		$qry = "select level from levelinfo where userid=$userid and entryid=(select max(entryid) from levelinfo where userid=$userid)";
	
		$row = Database::readSingleRow ( $qry );
	
		if ($row == NULL)
			return NULL;
		else {
	
			include_once ("entity/levelinfo.php");
	
			return $row [0];
		}
	}
	
	function getParentID(){

		include_once ("database.php");
		include_once ("data.php");
		
		$qry = "select userid from userdata where paymentstatus='done' and childcount<" . Data::$receiver_count . " order by userid limit 0,1";
		
		$row = Database::readSingleRow ( $qry );
		
		if ($row == NULL)
			return NULL;
		else
			return $row[0];				
	}
	
	function getReceiverID($userid, $level){
	
		include_once ("database.php");
	
		$qry = "select receiverid from paymenttransactions where level=$level and senderid=$userid";
	
		$row = Database::readSingleRow ( $qry );
	
		if ($row == NULL)
			return NULL;
		else
			return $row[0];
	}
	
	function isPaymentDoneOnLevel($userid, $level){
	
		include_once ("database.php");
	
		$qry = "select userid from levelinfo where status='done' and level=$level and userid=$userid";
	
		$row = Database::readSingleRow ( $qry );
	
		if ($row == NULL)
			return false;
		else
			return true;
	}
	
	function disableUser($userid) {
	
		include_once ("database.php");
	
		$activation_date = date('Y-m-d h:i:s');
	
		$qry = "update userdata set status='disabled' where userid=$userid";
		Database::executeQuery ( $qry );
		
		$qry = "update levelinfo set status='disabled' where userid=$userid";
		Database::executeQuery ( $qry );
		
		$qry = "update paymenttransactions set status='disabled' where senderid=$userid and level=(select max(level) from paymenttransactions where senderid=$userid)";
		Database::executeQuery ( $qry );
		
		return true;
	}
	
	function isDuplicateEmail($email) {
	
		include_once ("database.php");
	
		$qry = "select userid from userdata where email='$email'";
	
		$row = Database::readSingleRow ( $qry );
	
		if ($row == NULL)
			return false;
		else
			return true;
	}
	
	function isSideAlreadyFilled($sponsorid, $side) {
	
		include_once ("database.php");
	
		if($side=="left")
			$qry = "select userid from userdata where userid=$sponsorid and leftside is not null";
		else
			$qry = "select userid from userdata where userid=$sponsorid and rightside is not null";

		$row = Database::readSingleRow ( $qry );
	
		if ($row == NULL)
			return false;
		else
			return true;
	}
	
	function isValidUser($userid, $password) {
	
		include_once ("database.php");
	
		$qry = "select userid from userdata where userid=$userid and password='$password'";
	
		$row = Database::readSingleRow ( $qry );
	
		if ($row == NULL)
			return false;
		else
			return true;
	}
	
	function isValidTransactionPassword($userid, $password) {
	
		include_once ("database.php");
	
		$qry = "select userid from userdata where userid=$userid and transactionpassword='$password'";
	
		$row = Database::readSingleRow ( $qry );
	
		if ($row == NULL)
			return false;
		else
			return true;
	}
	
	function getGiftSenders($userid){
		
		include_once("database.php");
		
		$qry = "select transactionid,receiverid,senderid,level,entrydate,status,confirmdate from paymenttransactions where status in ('pending','approved') and receiverid=$userid";
		
		$rows = Database::readData ($qry);
		
		if ($rows == NULL)
			return NULL;
		else {
				
			$senders = array ();
			$ct = - 1;
				
			while($row = mysql_fetch_row($rows)){

				include_once 'entity/paymenttransaction.php';
				
				$pt = new PaymentTransaction();
		
				$pt->transactionid = $row [0];
				$pt->receiverid = $row [1];
				$pt->senderid = $row [2];
				$pt->level = $row [3];
				$pt->entrydate = $row[4];
				$pt->status = $row[5];
				$pt->confirmdate = $row[6];
								
				$senders [++$ct] = $pt;
			}
				
			return $senders;
		}
		
	}
	
	function findUserByEmail($email) {
	
		include_once ("database.php");
	
		$qry = "select userid,name,email,password,sex,contact_number,city,country,address,joindate,status,leftside,rightside,sponsorid,transactionpassword,accountholdername,bankname,branch,accountnumber,ifsccode,parentid,childcount,paymentstatus,activationdate,activatedby,level,isadmin from userdata where email='$email'";
	
		$row = Database::readSingleRow ( $qry );
	
		if ($row == NULL)
			return NULL;
		else {
				
			include_once ("entity/userdata.php");
				
			$userdata = new UserData ();
				
			$userdata->userid = $row [0];
			$userdata->name = $row [1];
			$userdata->email = $row [2];
			$userdata->password = $row [3];
			$userdata->sex = $row [4];
			$userdata->contact_number = $row [5];
			$userdata->city = $row [6];
			$userdata->country = $row [7];
			$userdata->address = $row [8];
			$userdata->joindate = $row [9];
			$userdata->status = $row [10];
			$userdata->leftside = $row [11];
			$userdata->rightside = $row [12];
			$userdata->sponsorid = $row [13];
			$userdata->transaction_password = $row [14];
			$userdata->account_holder_name = $row [15];
			$userdata->bank_name = $row [16];
			$userdata->branch = $row [17];
			$userdata->account_number = $row [18];
			$userdata->ifsc_code = $row [19];
			$userdata->parent_id = $row [20];
			$userdata->child_count = $row [21];
			$userdata->payment_status = $row [22];
			$userdata->activation_date = $row [23];
			$userdata->activated_by = $row [24];
			$userdata->level = $row[25];
			$userdata->isadmin = $row[26];
				
			return $userdata;
		}
	}
	
	function getAllUsers($start, $recordcount) {
		
		include_once ("database.php");
		
		$qry = "select userid,name,email,password,sex,contact_number,city,country,address,joindate,status,leftside,rightside,sponsorid,transactionpassword,accountholdername,bankname,branch,accountnumber,ifsccode,parentid,childcount,paymentstatus,activationdate,activatedby,level,isadmin from userdata order by name,country,city";
		
		$rows = Database::readData ( $qry );
		
		if ($rows == NULL)
			return NULL;
		else {
			
			include_once ("entity/userdata.php");
			
			$users = array ();
			$ct = - 1;
			
			while($row = mysql_fetch_row($rows)){
				
				$userdata = new UserData ();
				
				$userdata->userid = $row [0];
				$userdata->name = $row [1];
				$userdata->email = $row [2];
				$userdata->password = $row [3];
				$userdata->sex = $row [4];
				$userdata->contact_number = $row [5];
				$userdata->city = $row [6];
				$userdata->country = $row [7];
				$userdata->address = $row [8];
				$userdata->joindate = $row [9];
				$userdata->status = $row [10];
				$userdata->leftside = $row [11];
				$userdata->rightside = $row [12];
				$userdata->sponsorid = $row [13];
				$userdata->transaction_password = $row [14];
				$userdata->account_holder_name = $row [15];
				$userdata->bank_name = $row [16];
				$userdata->branch = $row [17];
				$userdata->account_number = $row [18];
				$userdata->ifsc_code = $row [19];
				$userdata->parent_id = $row [20];
				$userdata->child_count = $row [21];
				$userdata->payment_status = $row [22];
				$userdata->activation_date = $row [23];
				$userdata->activated_by = $row [24];
				$userdata->level = $row[25];
				$userdata->isadmin = $row[26];
				
				$users [++ $ct] = $userdata;
			}
			
			return $users;
		}
	}
	
	function getUserIncome($userid) {
	
		include_once ("database.php");
	
		$qry = "select transactionid,receiverid,senderid,level,entrydate,status,confirmdate from paymenttransactions where receiverid=$userid and status='approved'";
	
		$rows = Database::readData ( $qry );
	
		if ($rows == NULL)
			return NULL;
		else {
				
			include_once ("entity/paymenttransaction.php");
				
			$users = array ();
			$ct = - 1;
				
			while($row = mysql_fetch_row($rows)){
	
				$paymenttransaction = new PaymentTransaction();
	
				$paymenttransaction->transactionid = $row [0];
				$paymenttransaction->receiverid = $row [1];
				$paymenttransaction->senderid = $row [2];
				$paymenttransaction->level = $row [3];
				$paymenttransaction->entrydate = $row [4];
				$paymenttransaction->status = $row [5];
				$paymenttransaction->confirmdate = $row [6];
	
				$users [++ $ct] = $paymenttransaction;
			}
				
			return $users;
		}
	}
	
// 	function getChildCount($userid){
		
// 		if(!isset($userid))
// 			return 0;
		
// 		$qry = "select leftside,rightside from userdata where userid=$userid";
// 		echo "<br/>[$qry]";
// 		$row = Database::readSingleRow($qry);
		
// 		if(isset($row)){
			
// 			$leftsideuserid = $row[0];
// 			$rightsideuserid = $row[1];
			
// 			if(!isset($leftsideuserid) && !isset($rightsideuserid))
// 				return 0;
				
// 			if(isset($leftsideuserid) && isset($leftsideuserid)){
// 				return 1 + $this->getChildCount($leftsideuserid) + 1 + $this->getChildCount($rightsideuserid);
// 			}
// 			else if(isset($leftsideuserid) && !isset($rightsideuserid)){
// 				return 1 + $this->getChildCount($leftsideuserid);
// 			}
// 			else if(isset($rightsideuserid) && !isset($leftsideuserid)){
// 				return 1 + $this->getChildCount($rightsideuserid);
// 			}
// 			else
// 				return 0;
// 		}
// 		else
// 			return 0;
// 	}
	
	function getChildCount($userid){
		
		if(!isset($userid))
			return 0;
		
		$qry = "select leftside,rightside from userdata where userid=$userid";
		$row = Database::readSingleRow($qry);
		
		if(isset($row)){
			
			$leftsideuserid = $row[0];
			$rightsideuserid = $row[1];
			
			if(!isset($leftsideuserid) && !isset($rightsideuserid))
				return 0;

			if(isset($leftsideuserid) && isset($rightsideuserid)){
				$this->totalcount++;
				$this->totalcount++;
				$this->getChildCount($leftsideuserid);
				$this->getChildCount($rightsideuserid);
			}
			else if(isset($leftsideuserid)){
				$this->totalcount++;
				$this->getChildCount($leftsideuserid);
			}
			else if(isset($rightsideuserid)){
				$this->totalcount++;
				$this->getChildCount($rightsideuserid);
			}
		}
	}
	
	function getPaidChildCount($userid){
	
		if(!isset($userid))
			return;
	
		$qry = "select leftside,rightside from userdata where userid=$userid and status='active'";
		$row = Database::readSingleRow($qry);
	
		if(isset($row)){
				
			$leftsideuserid = $row[0];
			$rightsideuserid = $row[1];
				
			if(!isset($leftsideuserid) && !isset($rightsideuserid))
				return;
	
			$level = $this->getCurrentLevel($userid);
			
			$leftpaid = false;
			$rightpaid = false;

			if(isset($leftsideuserid)){
				$l_payment = $this->getSenderPaymentTransaction($leftsideuserid, $level);
				
				if(isset($l_payment) && $l_payment->status=="approved")
					$leftpaid = true;
			}
			
			if(isset($rightsideuserid)){
				$r_payment = $this->getSenderPaymentTransaction($rightsideuserid, $level);
				
				if(isset($r_payment) && $r_payment->status=="approved")
					$rightpaid = true;
			}			
				
			if(isset($leftsideuserid) && isset($rightsideuserid) && $leftpaid && $rightpaid){
				$this->totalcount++;
				$this->totalcount++;
				$this->getPaidChildCount($leftsideuserid);
				$this->getPaidChildCount($rightsideuserid);
			}
			else if(isset($leftsideuserid) && $leftpaid){
				$this->totalcount++;
				$this->getPaidChildCount($leftsideuserid);
			}
			else if(isset($rightsideuserid) && $rightpaid){
				$this->totalcount++;
				$this->getPaidChildCount($rightsideuserid);
			}
		}
	}
/*	
	function getRightCount($userid){
		
		$qry = "select rightside from userdata where userid=$userid";
		
		$row = Database::readSingleRow($qry);
		
		if(isset($row)){
			
			$rightsideuserid = $row[0];
			if(!isset($rightsideuserid))
				return 0;
				
			if(isset($rightsideuserid)){
				return 1 + $this->getLeftCount($rightsideuserid);
			}
			else
				return 0;
		}
		else
			return 0;
	}
	
	function getPaidCount($userid){
	
		$qry = "select leftside,rightside from userdata where userid=$userid";
//	echo "<br/>[$qry]";
		$row = Database::readSingleRow($qry);
	
		if(isset($row)){
				
			$leftsideuserid = $row[0];
			$rightsideuserid = $row[1];
			
			if(!isset($leftsideuserid) && !isset($leftsideuserid))
				return 0;
			
			$lpaid = true;
			$rpaid = true;
			
			if(isset($leftsideuserid)){
				$qry = "select status from paymenttransactions where senderid=$leftsideuserid";
//	echo "<br/>[$qry]";
				$trow = Database::readSingleRow($qry);
				if(isset($trow)){
					$status = $trow[0];
					
					if($status=='approved')
						$lpaid = true;
					else
						$lpaid = false;
				}
				else
					$lpaid = false;
			}
			
			if(isset($rightsideuserid)){
				$qry = "select status from paymenttransactions where senderid=$rightsideuserid";
//				echo "<br/>[$qry]";
				
				$trow = Database::readSingleRow($qry);
				if(isset($trow)){
					$status = $trow[0];
				
					if($status=='approved')
						$rpaid = true;
					else
						$rpaid = false;
				}
				else
					$rpaid = false;
			}
				
//			echo "<br/>left paid = $lpaid , right paid = $rpaid";
			
			if(isset($leftsideuserid) && isset($rightsideuserid)){
				if($lpaid && $rpaid)
					return 1 + $this->getPaidCount($leftsideuserid) + 1 + $this->getPaidCount($rightsideuserid);
				else if($lpaid)
					return 0 + $this->getPaidCount($leftsideuserid);
				else if($rpaid)
					return 0 + $this->getPaidCount($rightsideuserid);
			}
			else if(isset($leftsideuserid) && !isset($rightsideuserid)){
				if($lpaid)
					return 1 + $this->getPaidCount($leftsideuserid);
				else
					return 0 + $this->getPaidCount($leftsideuserid);
			}
			else if(isset($rightsideuserid) && !isset($leftsideuserid)){
				if($rpaid)
					return 1 + $this->getPaidCount($rightsideuserid);
				else
					return 0 + $this->getPaidCount($rightsideuserid);
			}
			else
				return 0;
		}
		else
			return 0;
	}
	
	function getRightPaidCount($userid){
	
		$qry = "select rightside from userdata where userid=$userid";
	
		$row = Database::readSingleRow($qry);
	
		if(isset($row)){
				
			$rightsideuserid = $row[0];
			if(!isset($rightsideuserid))
				return 0;
				
			$paid = true;
				
			$qry = "select status from paymenttransactions where senderid=$rightsideuserid";
			
			$trow = Database::readSingleRow($qry);
			if(isset($trow)){
				$status = $trow[0];
			
				if($status=='approved')
					$paid = true;
				else
					$paid = false;
			}
			else
				$paid = false;
							
			if(isset($rightsideuserid)){
				if($paid)
					return 1 + $this->getRightPaidCount($rightsideuserid);
				else
					return 0 + $this->getRightPaidCount($rightsideuserid);
			}
			else
				return 0;
		}
		else
			return 0;
	}
*/	
	function updatePassword($userid, $password) {
		
		include_once ("database.php");
		
		$qry = "update userdata set " . 
				"password='$password' where userid=$userid";
		
		return Database::executeQuery ( $qry );
	}
	
	function updateTransactionPassword($userid, $password) {
		
		include_once ("database.php");
		
		$qry = "update userdata set " . 
				"transactionpassword='$password' where userid=$userid";
		
		return Database::executeQuery ( $qry );
	}
	
	function oldPasswordValid($userid,$oldpassword){
		
		include_once ("database.php");
		
		$qry = "select userid from userdata where userid=$userid and password='$oldpassword'";
		
		$row = Database::readSingleRow ( $qry );
		
		if ($row == NULL)
			return false;
		else
			return true;
	}
	
	function oldTransactionPasswordValid($userid,$oldpassword){
		
		include_once ("database.php");
		
		$qry = "select userid from userdata where userid=$userid and transactionpassword='$oldpassword'";
		
		$row = Database::readSingleRow ( $qry );
		
		if ($row == NULL)
			return false;
		else
			return true;
	}
	
	function getDownlineList($userid){
		
		$qry = "select leftside,rightside from userdata where userid=$userid";
		
		$row = Database::readSingleRow($qry);
		
		if(isset($row)){
				
			$leftsideuserid = $row[0];
			$rightsideuserid = $row[1];

			if(!isset($leftsideuserid) && !isset($rightsideuserid))
				return;
		
			if(isset($leftsideuserid) && isset($rightsideuserid)){
				$this->ar[++$this->arcount] = $leftsideuserid;
				$this->ar[++$this->arcount] = $rightsideuserid;
				$this->getDownlineList($leftsideuserid);
				$this->getDownlineList($rightsideuserid);
			}
			else if(isset($leftsideuserid)){
				$this->ar[++$this->arcount] = $leftsideuserid;				
				$this->getDownlineList($leftsideuserid);
			}
			else if(isset($rightsideuserid)){
				$this->ar[++$this->arcount] = $rightsideuserid;				
				$this->getDownlineList($rightsideuserid);
			}
		}
		
	}
	
	function isReceiverSetForCurrentLevel($userid){
		
		include_once ("database.php");
		
		$qry = "select receiverid from paymenttransactions where senderid=$userid and level=(select max(level) from paymenttransactions where senderid=$userid)";
		
		$row = Database::readSingleRow($qry);
		
		if ($row == NULL)
			return false;
		else{
			if(isset($row[0]))
				return true;
			else 
				return false;
		}
	}
	
	// set receiver for this userid
	function setReceiverID($userid, $level){
		
		include_once ("database.php");
		include_once ("data.php");
		
		$qry = "select userid from levelinfo where entryid=(select min(entryid) from levelinfo where status='active' and childcount<" . Data::$receiver_count . " and level=(select max(level) from levelinfo where userid=$userid))";
		$row = Database::readSingleRow($qry);
		
		if ($row == NULL)
			return false;
		else{
			$receiverid = $row[0];
			
			$qry = "select count(receiverid) from paymenttransactions where receiverid=$receiverid and level=$level";
			$trow = Database::readSingleRow($qry);
			
			if ($trow == NULL)
				return false;
			else{
				$cnt = $trow[0];
				
				if($cnt<Data::$receiver_count){
					$qry = "update paymenttransactions set receiverid=$receiverid where senderid=$userid and level=$level";
					return Database::executeQuery($qry);
				}
				else{
					//wait
				}
			}

			return true;
		}
	}
	
	function addToUserEWallet($fromuserid, $touserid, $amount) {
	
		include_once ("database.php");
	
		$qry1 = "update ewallet set last_update='" . date('Y-m-d h:i:s') . "', balance=balance-" . $amount . " where userid=" . $fromuserid;
		$qry2 = "update ewallet set last_update='" . date('Y-m-d h:i:s') . "', balance=balance+" . $amount . " where userid=" . $touserid;
		
		$qry3 = "insert into ewallet_log(admin,userid,amount,create_date,message) values($fromuserid,$touserid,$amount,'" . date('Y-m-d h:i:s') . "','Debit')";
		$qry4 = "insert into ewallet_log(admin,userid,amount,create_date,message) values($fromuserid,$touserid,$amount,'" . date('Y-m-d h:i:s') . "','Credit')";
		
		return Database::executeQuery ( $qry1 ) && Database::executeQuery ( $qry2 ) && Database::executeQuery ( $qry3 ) && Database::executeQuery ( $qry4 );
	}
}
?>
