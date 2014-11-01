<?php
	session_start();

	if(isset($_SESSION['loggeduserid']) && (time()-$_SESSION['last_activity'])<1200){
		$_SESSION['last_activity'] = time();

		$name = $_SESSION['loggedusername'];
		$userid = $_SESSION['loggeduserid'];

		include_once 'modal/userdao.php';
		include_once 'modal/entity/paymenttransaction.php';

		$dao = new UserDAO();
		$user = $dao->findUser($userid);

		$currentlevel = $dao->getCurrentLevel($userid);

		$status = $user->status;
		if($status=="active")
			$profile_pic = "user_" . $user->sex;
		else
			$profile_pic = $status;

		$leftsideid = $user->leftside;
		$rightsideid = $user->rightside;

		$left_count = 0;
		$right_count = 0;
		$left_paid_count = 0;
		$right_paid_count = 0;

		if(isset($leftsideid)){
			$left_count++;
			$l_payment_transaction = $dao->getSenderPaymentTransaction($leftsideid, 0);
			if(isset($l_payment_transaction) && $l_payment_transaction->status=='approved')
				$left_paid_count++;
		}

		if(isset($rightsideid)){
			$right_count++;
			$r_payment_transaction = $dao->getSenderPaymentTransaction($rightsideid, 0);

			if(isset($r_payment_transaction) && $r_payment_transaction->status=='approved')
				$right_paid_count++;
		}

		$dao->totalcount = 0;

		if(isset($leftsideid)){

			$dao->getChildCount($leftsideid);
			$left_count += $dao->totalcount;

			$dao->totalcount = 0;
			$dao->getPaidChildCount($leftsideid);
			$left_paid_count += $dao->totalcount;
		}

		$dao->totalcount = 0;

		if(isset($rightsideid)){
			$dao->getChildCount($rightsideid);
			$right_count += $dao->totalcount;

			$dao->totalcount = 0;
			$dao->getPaidChildCount($rightsideid);
			$right_paid_count += $dao->totalcount;
		}

		$ar_income = $dao->getUserIncome($userid);
		$income = 0;

		$level_income = array(1000,2000,4000,8000,16000,32000,64000,128000);

		if(isset($ar_income) && count($ar_income)>0){

			for($i=0;$i<count($ar_income);$i++){
				$payment_transaction = $ar_income[$i];
				$income += $level_income[$payment_transaction->level];
			}
		}

// 		$parentset = $dao->isReceiverSetForCurrentLevel($userid);
// 		if($parentset===false){
// 			$dao->setReceiverID($userid, $user->level);
// 		}
?>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Section</title>

<?php include("commonresources.php");?>

</head>
<body>

<?php include("top.php"); ?>

<!-- .topbar -->
<?php include('topbarlogged.php'); ?>

<?php include("logomenu.php"); ?>

<div class="middlecontent">

	<div class="accountdata">
		<h2>Account Overview</h2>

		<div class="accountheader">Account Details</div>
		<div class="accountdetails">
			<div class="col100 leftfloat">&nbsp;</div>
			<div class="col500 leftfloat">
				<div class="row">&nbsp;</div>
				<div class="row">
					<div class="col100 leftfloat">User ID</div>
					<div class="col50 leftfloat centeralign">:</div>
					<div class="col300"><?php echo $user->userid;?></div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="col100 leftfloat">Name</div>
					<div class="col50 leftfloat centeralign">:</div>
					<div class="col300"><?php echo $user->name;?></div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="col100 leftfloat">Sponsor ID</div>
					<div class="col50 leftfloat centeralign">:</div>
					<div class="col300"><?php echo $user->sponsorid;?></div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="col100 leftfloat">Email</div>
					<div class="col50 leftfloat centeralign">:</div>
					<div class="col300 leftfloat"><?php echo $user->email;?></div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="col100 leftfloat">Contact Number</div>
					<div class="col50 leftfloat centeralign">:</div>
					<div class="col300"><?php echo $user->contact_number;?></div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="col200 leftfloat">
				<div class="pic"><img src="images/<?php echo $profile_pic;?>.png"/></div>
			</div>
			<div class="clear"></div>
		</div>

		<div class="col400 leftfloat">
			<div class="accountheader">IDs Count</div>
			<div class="accountdetails">
				<div class="row">&nbsp;</div>
				<div class="row">
					<div class="col100 leftfloat">&nbsp;</div>
					<div class="col100 leftfloat">Left Count</div>
					<div class="col50 leftfloat centeralign">:</div>
					<div class="col300"><?php echo $left_count;?></div>
					<div class="clear"></div>
				</div>
				<div class="row">
					<div class="col100 leftfloat">&nbsp;</div>
					<div class="col100 leftfloat">Right Count</div>
					<div class="col50 leftfloat centeralign">:</div>
					<div class="col300"><?php echo $right_count;?></div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
        <div class="col100 leftfloat">&nbsp;</div>
		<div class="col400 rightfloat">
			<div class="accountheader">Income Information</div>
			<div class="accountdetails">
				<div class="row">&nbsp;</div>
				<div class="row">
					<div class="col100 leftfloat">&nbsp;</div>
					<div class="col100 leftfloat">Total Income</div>
					<div class="col50 leftfloat centeralign">:</div>
					<div class="col300"><?php echo $income;?></div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div class="clear"></div>

	</div>

</div>

<?php include("bottom.php"); ?>

<?php
	}
	else
		header("location: index.php");
?>