<?php
class AdminDAO {
	
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
	
	function updatePairWithdrawlRequest($request_id, $status, $admin){
	
		include_once ("database.php");
	
		$qry1 = "update pair_withdrawl_request set status='$status' where request_id=$request_id";
		
		$pair_withdrawl_request = $this->getPairWithdrawlRequest($request_id);
		
		//$qry2 = "update ewallet set balance=balance-" . $pair_withdrawl_request->amount . " where userid=" . $pair_withdrawl_request->userid;

		if($status=="approved")
			$qry3 = "insert into ewallet_log(admin,userid,amount,create_date,message) values($admin," . $pair_withdrawl_request->userid . "," . $pair_withdrawl_request->amount . ",'" . date('Y-m-d h:i:s') . "','Pair Withdrawl')";
		else
			$qry3 = "insert into ewallet_log(admin,userid,amount,create_date,message) values($admin," . $pair_withdrawl_request->userid . "," . $pair_withdrawl_request->amount . ",'" . date('Y-m-d h:i:s') . "','Denied')";
				
//		return Database::executeQuery ($qry1) && Database::executeQuery ($qry2) && Database::executeQuery ($qry3);
		return Database::executeQuery ($qry1) && Database::executeQuery ($qry3);
	}
	
	function getPairWithdrawlRequest($request_id) {
	
		include_once ("database.php");
	
		$qry = "select request_id,userid,amount,request_date,status from pair_withdrawl_request where request_id=$request_id";
	
		$row = Database::readSingleRow($qry);
	
		if ($row == NULL)
			return NULL;
		else {
	
			include_once ("entity/pairwithdrawlrequest.php");
	
			$request = new PairWithdrawlRequest();

			$request->request_id = $row [0];
			$request->userid = $row [1];
			$request->amount = $row [2];
			$request->request_date = $row [3];
			$request->status = $row [4];
	
			return $request;
		}
	}
	
	function disableUser($userid) {
	
		include_once ("database.php");
	
		$activation_date = date('Y-m-d h:i:s');
	
		$qry = "update userdata set status='disabled' where userid=$userid";
	
		return Database::executeQuery ( $qry );
	}
	
	function isValidAdmin($userid, $password) {

		include_once ("database.php");
	
		$qry = "select userid from admindata where userid='$userid' and password='$password'";

		$row = Database::readSingleRow ( $qry );
	
		if ($row == NULL)
			return false;
		else
			return true;
	}
	
	function isValidAdminTransactionPassword($userid, $password) {
	
		include_once ("database.php");
	
		$qry = "select userid from admindata where userid='$userid' and transaction_password='$password'";
	
		$row = Database::readSingleRow ( $qry );
	
		if ($row == NULL)
			return false;
		else
			return true;
	}
	
	function oldPasswordValid($userid,$oldpassword){
	
		include_once ("database.php");
	
		$qry = "select userid from admindata where userid='$userid' and password='$oldpassword'";
	
		$row = Database::readSingleRow ( $qry );
	
		if ($row == NULL)
			return false;
		else
			return true;
	}
	
	function isAdminAccount($userid) {
	
		include_once ("database.php");
	
		$qry = "select userid from userdata where userid=$userid and isadmin='y'";
	
		$row = Database::readSingleRow ( $qry );
	
		if ($row == NULL)
			return false;
		else
			return true;
	}
	
	function getAllUsers($start, $recordcount) {
		
		include_once ("database.php");
		
		$qry = "select userid,name,email,password,sex,contact_number,city,country,address,joindate,status,leftside,rightside,sponsorid,transactionpassword,accountholdername,bankname,branch,accountnumber,ifsccode,parentid,childcount,paymentstatus,activationdate,activatedby,level from userdata order by name,country,city";
		
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
				
				$users [++ $ct] = $userdata;
			}
			
			return $users;
		}		
	}
		
	function getNewUsers($start, $recordcount) {
	
		include_once ("database.php");
	
		$qry = "select userid,name,email,password,sex,contact_number,city,country,address,joindate,status,leftside,rightside,sponsorid,transactionpassword,accountholdername,bankname,branch,accountnumber,ifsccode,parentid,childcount,paymentstatus,activationdate,activatedby,level from userdata where status='pending' order by joindate";
	
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
	
				$users [++ $ct] = $userdata;
			}
				
			return $users;
		}
	}

	function updatePassword($userid, $password) {
	
		include_once ("database.php");
	
		$qry = "update admindata set password='$password' where userid='$userid'";
	
		return Database::executeQuery ( $qry );
	}	
	
	function addToEWallet($ewallet, $admin) {
	
		include_once ("database.php");
	
		$qry1 = "update ewallet set last_update='" . date('Y-m-d h:i:s') . "', balance=balance+" . $ewallet->balance . " where userid=" . $ewallet->userid;
				
		$qry2 = "insert into ewallet_log(admin,userid,amount,create_date,message) values('$admin'," . $ewallet->userid . "," . $ewallet->balance . ",'" . date('Y-m-d h:i:s') . "','Credit')";
		
		return Database::executeQuery ( $qry1 ) && Database::executeQuery ( $qry2 );
	}
	
	function getEwalletLogs($userid) {
	
		include_once ("database.php");
	
		$qry = "(select logid,userid,amount,admin,create_date,message from ewallet_log where userid=$userid and message='Credit') union ";
		$qry .= "(select logid,userid,amount,admin,create_date,message from ewallet_log where admin=$userid and message='Debit') order by create_date desc";
		
		$rows = Database::readData ($qry);
	
		if ($rows == NULL)
			return NULL;
		else {
				
			$ar = array();
			$ct = - 1;

			include_once ("entity/ewalletlog.php");
			
			while($row = mysql_fetch_row($rows)){
					
				$pt = new EWalletLog();
					
				$pt->logid = $row [0];
				$pt->userid = $row [1];
				$pt->amount = $row [2];
				$pt->admin = $row [3];
				$pt->create_date = $row[4];
				$pt->message = $row[5];
					
				$ar [++$ct] = $pt;
			}
				
			return $ar;
		}
	}
	
	function getPairIncomeLogs($userid) {
	
		include_once ("database.php");
	
		$qry = "select logid,userid,amount,admin,create_date,message from ewallet_log where userid=$userid and message in ('Pair Withdrawl', 'PairToEWallet') order by create_date desc";
	
		$rows = Database::readData ($qry);
	
		if ($rows == NULL)
			return NULL;
		else {
	
			$ar = array();
			$ct = - 1;
	
			include_once ("entity/ewalletlog.php");
				
			while($row = mysql_fetch_row($rows)){
					
				$pt = new EWalletLog();
					
				$pt->logid = $row [0];
				$pt->userid = $row [1];
				$pt->amount = $row [2];
				$pt->admin = $row [3];
				$pt->create_date = $row[4];
				$pt->message = $row[5];
					
				$ar [++$ct] = $pt;
			}
	
			return $ar;
		}
	}
	
	function disablePendingUsers(){
		
		include_once ("database.php");
		
		$qry = "update levelinfo set status='disabled' where userid in (select senderid from paymenttransactions where status='pending' and datediff(now(),entrydate)*24 > 72)";
		Database::executeQuery ( $qry );
	
		$qry = "update userdata set status='disabled' where userid in (select senderid from paymenttransactions where status='pending' and datediff(now(),entrydate)*24 > 72)";
		Database::executeQuery ( $qry );
	}
	
	function activateUser($userid, $activatedby) {
	
		include_once("userdao.php");
		
		$dao = new UserDAO();
		
		$user_info = $dao->findUser($userid);
		
		if($user_info->status=="pending"){
			
			$level = 0;
			
			$this->disablePendingUsers();
			
			include_once ("database.php");
			include_once ("data.php");
			
			$activation_date = date('Y-m-d h:i:s');
		
			$qry1 = "update userdata set activationdate='$activation_date', activatedby=$activatedby, status='active', paymentstatus='done' where userid=$userid";
			$result1 = Database::executeQuery($qry1);
			
			$qry2 = "insert into levelinfo(userid,level,reachingdate,status,entrycount,childcount) values($userid,0,'$activation_date','active',0,0)";
			$result2 = Database::executeQuery($qry2);
			
			//$qry3 = "select max(level) from levelinfo where userid=$userid";
			
			//$row = Database::readSingleRow($qry3);
			//$level = $row[0];
	
			// read all records before my record who are active, have two children approved and set their receivers
			//$qry4 = "select userid from levelinfo where userid<$userid and entrycount<5 and level=$level";
			$qry4 = "select userid from levelinfo where userid<$userid and entrycount<" . Data::$receiver_count . " and level=0";
			
			$trows = Database::readData($qry4);
			
			if(isset($trows) && count($trows)>0){
				
				include_once "userdao.php";
				
				while($trow = mysql_fetch_row($trows)){
					
					$tuserid = $trow[0];
	
					$udao = new UserDAO();
					
					$currentuser = $this->findUser($tuserid);
			
					if($currentuser->isadmin=='y'){
						
						$qry5 = "select userid from levelinfo where userid>$tuserid and level=0 and receiverset='n' order by entryid limit 0," . Data::$receiver_count;
			
						$urows = Database::readData($qry5);
							
						if(isset($urows) && count($urows)>0){
					
							while($urow = mysql_fetch_row($urows)){
								$u_userid = $urow[0];
					
								$qry6 = "insert into paymenttransactions(receiverid,senderid,level,entrydate,status) values($tuserid,$u_userid,$level,'$activation_date','pending')";
			
								$result3 = Database::executeQuery($qry6);
					
								$qry7 = "update levelinfo set receiverset='y' where userid=$u_userid and level=$level";
			
								Database::executeQuery($qry7);
									
								$qry8 = "update levelinfo set entrycount=entrycount+1 where userid=$tuserid and level=$level";
								
								Database::executeQuery($qry8);
					
								$this->sendSMS($tuserid, $u_userid);
							}
						}
					}
					else{
						if(isset($currentuser->leftside) && isset($currentuser->rightside) && $udao->isApproved($currentuser->leftside) && $udao->isApproved($currentuser->rightside)){
							
							$paymenttransaction = $udao->getSenderPaymentTransaction($tuserid, $level);
							if(isset($paymenttransaction) && $paymenttransaction->status=='approved'){
									
								//$qry5 = "select userid from levelinfo where userid>$tuserid and level=$level and receiverset='n' order by entryid limit 0,5";
								$qry5 = "select userid from levelinfo where userid>$tuserid and level=0 and receiverset='n' order by entryid limit 0," . Data::$receiver_count;
								$urows = Database::readData($qry5);
								
								if(isset($urows) && count($urows)>0){
									
									while($urow = mysql_fetch_row($urows)){
										$u_userid = $urow[0];
											
										$qry6 = "insert into paymenttransactions(receiverid,senderid,level,entrydate,status) values($tuserid,$u_userid,$level,'$activation_date','pending')";					
										$result3 = Database::executeQuery($qry6);
		
										$qry7 = "update levelinfo set receiverset='y' where userid=$u_userid and level=$level";			
										Database::executeQuery($qry7);						
										
				 						$qry8 = "update levelinfo set entrycount=entrycount+1 where userid=$tuserid and level=$level";
				 						Database::executeQuery($qry8);
				 						
				 						$this->sendSMS($tuserid, $u_userid);
									}
								}
							}
						}
					}
				}
			}
					
			return true;
		}
		else
			return false;
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
				
			$pword = "demo1234"; //Your developer API password
				
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
	
	function activateDeactivateUser($userid, $activatedby,$action) {
	
		include_once ("database.php");
	
		$activation_date = date('Y-m-d h:i:s');
	
		if($action=="active"){
			$qry = "update userdata set status='active' where userid=$userid";
			Database::executeQuery ( $qry );

			include_once("userdao.php");
			$udao = new UserDAO();
			$level = $udao->getCurrentLevel($userid);
			
			$qry = "update levelinfo set status='active',receiverset='n' where userid=$userid and level=$level";	
			Database::executeQuery ( $qry );
			
			$qry = "delete from paymenttransactions where senderid=$userid and level=$level";	
			Database::executeQuery ( $qry );
			
			$udao->setReceivers($userid, $level);
		}
		else if($action=="disabled"){
			// to be implemented
		}
		
		return true;
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
	
	function getWithdrawlRequests($start, $recordcount) {
	
		include_once ("database.php");
	
		$qry = "select request_id,userid,amount,request_date,status from pair_withdrawl_request where status='pending' limit $start,$recordcount";
	
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
	
	function getLevelReceivers($level){
		
		include_once ("database.php");
		
		$qry = "select userid from levelinfo where level=$level and userid in(select senderid from paymenttransactions where level=$level and status='approved') order by entryid";
		
		$rows = Database::readData ( $qry );
		
		if ($rows == NULL)
			return NULL;
		else {
		
			include_once ("entity/pairwithdrawlrequest.php");
		
			$ar = array ();
			$ct = - 1;
		
			while($row = mysql_fetch_row($rows)){
		
				$ar [++ $ct] = $row[0];
			}
		
			return $ar;
		}
	}
}
?>
