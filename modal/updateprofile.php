<?php
	session_start();
	
	if(isset($_SESSION['loggeduserid'])){
	
		include_once ("entity/userdata.php");
		include_once ("userdao.php");
		
		$userid = $_SESSION['loggeduserid'];
		
		$email = mysql_escape_string($_REQUEST ['email']);
		$name = mysql_escape_string($_REQUEST ['name']);
		$sex = mysql_escape_string($_REQUEST ['gender']);
		$contact_number = mysql_escape_string($_REQUEST ['contact_number']);
		$city = mysql_escape_string($_REQUEST ['city']);
		$country = mysql_escape_string($_REQUEST ['u_country']);
		$address = mysql_escape_string($_REQUEST ['address']);
		
		$account_holder_name = mysql_escape_string($_REQUEST ['accountholdername']);
		$bank = mysql_escape_string($_REQUEST ['bank']);
		$branch = mysql_escape_string($_REQUEST ['branch']);
		$account_number = mysql_escape_string($_REQUEST ['accountnumber']);
		$ifsc_code = mysql_escape_string($_REQUEST ['ifsccode']);
		
		$userdata = new UserData();
		
		$dao = new UserDAO();

		$userdata->userid = $userid;
		$userdata->email = $email;
		$userdata->name = $name;
		$userdata->sex = $sex;
		$userdata->contact_number = $contact_number;
		$userdata->city = $city;
		$userdata->country = $country;
		$userdata->address = $address;
		$userdata->account_holder_name = $account_holder_name;
		$userdata->account_number = $account_number;
		$userdata->bank_name = $bank;
		$userdata->branch = $branch;
		$userdata->ifsc_code = $ifsc_code;
		
		$updated = $dao->updateUser($userdata);
		
		if($updated===true)
			echo "done";
		else
			echo "error";
	}
	else
		echo "notlogged";
?>