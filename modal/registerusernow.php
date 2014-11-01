<?php
	function createRandomPassword(){
		
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
		
		srand((double)microtime()*1000000);
		
		$i=0;
		$pass = '';
		
		while($i <= 7){
			$num = rand()%33;
			$tmp = substr($chars, $num, 1);
			$pass = $pass . $tmp;
			$i++;
		}
		
		return $pass;
	}
	
	session_start();
	
	if(isset($_SESSION['loggeduserid'])){

		$userid = $_SESSION['loggeduserid'];
		
		include_once ("entity/userdata.php");
		include_once ("utility.php");
		include_once ("userdao.php");
		
		$hasBalance = $_REQUEST['hb'];
		$added_by_id = $_SESSION['loggeduserid'];
		
		if($hasBalance=="y")
			$sponsorid = $_REQUEST['userid'];
		else
			$sponsorid = $_SESSION['loggeduserid'];
		
		if(is_numeric($_REQUEST['userid'])===false)
			echo "invalidid";
		else{
			$email = mysql_escape_string($_REQUEST ['email']);
			$name = mysql_escape_string($_REQUEST ['name']);
			$sex = mysql_escape_string($_REQUEST ['gender']);
			$contact_number = mysql_escape_string($_REQUEST ['contact_number']);
			$city = mysql_escape_string($_REQUEST ['city']);
			$country = mysql_escape_string($_REQUEST ['u_country']);
			$address = mysql_escape_string($_REQUEST ['address']);
			$side = mysql_escape_string($_REQUEST ['side']);
			
			$password = createRandomPassword();
			$transaction_password = createRandomPassword();
			$password = base64_encode($password); 
			$transaction_password = base64_encode($transaction_password);
			
			$account_holder_name = mysql_escape_string($_REQUEST ['accountholdername']);
			$bank = mysql_escape_string($_REQUEST ['bank']);
			$branch = mysql_escape_string($_REQUEST ['branch']);
			$account_number = mysql_escape_string($_REQUEST ['accountnumber']);
			$ifsc_code = mysql_escape_string($_REQUEST ['ifsccode']);
			
			$userdata = new UserData();
			
			$dao = new UserDAO();
				
			$user = $dao->findUser($sponsorid);
			
			if(isset($user)){
				
				if($user->status=="pending")
					echo "pending";
				else if($dao->isDuplicateEmail($email)===true)
				 	echo "duplicateemail";
				else if($dao->isSideAlreadyFilled($sponsorid, $side) ===true)
				 	echo "duplicateside";
				else 
				{
					$parentid = $userid;
					
					$userdata->email = $email;
					$userdata->name = $name;
					$userdata->password = $password;
					$userdata->transaction_password = $transaction_password;
					$userdata->sex = $sex;
					$userdata->contact_number = $contact_number;
					$userdata->city = $city;
					$userdata->country = $country;
					$userdata->address = $address;
					$userdata->status = "pending";
					$userdata->joindate = date('y-m-d h:i:s');
					$userdata->sponsorid = $sponsorid;
					$userdata->parent_id = $parentid;
					
					$userdata->account_holder_name = $account_holder_name;
					$userdata->account_number = $account_number;
					$userdata->bank_name = $bank;
					$userdata->branch = $branch;
					$userdata->ifsc_code = $ifsc_code;
						
					$id = $dao->addUser($userdata, $added_by_id);
					
					$dao->incrementChildCount($parentid);
					
					$added = $dao->setSponsorSide($side,$id,$sponsorid);
					
					if($added===true)
						echo "done";
					else
						echo "error";
				}
			}		
			else
				echo "notfound";
		}
	}
	else
		echo "notlogged";
?>