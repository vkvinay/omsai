<?php
class IDEntryDAO {
	
	function getUsers($startdate, $enddate) {
		
		include_once ("database.php");
		
		$qry = "select userid,name,email,password,sex,contact_number,city,country,address,joindate,status,leftside,rightside,sponsorid,transactionpassword,accountholdername,bankname,branch,accountnumber,ifsccode,parentid,childcount,paymentstatus,activationdate,activatedby,level from userdata where activationdate>='$startdate 00:00:01' and activationdate<='$enddate 11:59:59' order by name,country,city";
		
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
}
?>
