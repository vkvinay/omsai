<?php
session_start ();

if (isset ( $_SESSION ['loggeduserid'] ) && (time () - $_SESSION ['last_activity']) < 1200) {
	$_SESSION ['last_activity'] = time ();
	
	include_once 'modal/userdao.php';
	include_once 'modal/admindao.php';
	
	$adao = new AdminDAO ();
	$udao = new UserDAO ();
	
	$userid = $_SESSION ['loggeduserid'];
	
	$user = $udao->findUser ( $userid );
	
	$leftsideid = $user->leftside;
	$rightsideid = $user->rightside;
	
	$left_count = 0;
	$right_count = 0;
	
	if (isset ( $leftsideid )) {
		$left_count ++;
	}
	
	if (isset ( $rightsideid )) {
		$right_count ++;
	}
	
	$udao->totalcount = 0;
	
	if (isset ( $leftsideid )) {
		
		$udao->getChildCount ( $leftsideid );
		$left_count += $udao->totalcount;
	}
	
	$udao->totalcount = 0;
	
	if (isset ( $rightsideid )) {
		$udao->getChildCount ( $rightsideid );
		$right_count += $udao->totalcount;
	}
	
	if ($left_count == $right_count)
		$pair = $left_count;
	else if ($left_count < $right_count)
		$pair = $left_count;
	else if ($left_count > $right_count)
		$pair = $right_count;
	
	$pairincome = $pair * 100;
	
	$logs = $adao->getPairIncomeLogs ( $userid );
	$total = 0;
	
	if (isset ( $logs ) && count ( $logs ) > 0) {
		foreach ( $logs as $log ) {
			$total = $total + $log->amount;
		}
	}
	
	$pairincome -= $total;
	
	$pair = $pair - ($total / 100);
	?>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Binary Income</title>

<?php include("commonresources.php");?>

</head>
<body>

<?php include("top.php"); ?>

<!-- .topbar -->
<?php include('topbarlogged.php'); ?>

<?php include("logomenu.php"); ?>
			
			
			<div class="middlecontent">
		<br /> <br />
		<div class="registerform">

			<div class="accountheader">Your Binary Income</div>
			<br />

			<div class="row">
				<div class="col100 leftfloat">&nbsp;</div>
				<div class="col150 leftfloat columnlabelbold">
					<h4>Pairs :</h4>
				</div>
				<div class="col350 leftfloat">
					<h4><?php echo $pair; ?></h4>
				</div>
				<div class="message col200 leftfloat">&nbsp;</div>
				<div class="clear"></div>
			</div>

			<div class="row">
				<div class="col100 leftfloat">&nbsp;</div>
				<div class="col150 leftfloat columnlabelbold">
					<h4>Income :</h4>
				</div>
				<div class="col350 leftfloat">
					<h4><?php echo $pairincome; ?></h4>
				</div>
				<div class="message col200 leftfloat">&nbsp;</div>
				<div class="clear"></div>
			</div>
		
			<div class="accountheader">Binary Income Logs</div>
			<br />

			<div class="row">
				<div class="col100 leftfloat">&nbsp;</div>
				<div class="col600 leftfloat columnlabelbold">
			
<?php
	$ar = $adao->getPairIncomeLogs ( $userid );
	
	if (isset ( $ar ) && count ( $ar ) > 0) {
		?>
<br />
			<div
				style="background-color: black; color: white; font-weight: bold; padding: 5px;">
				<div class="col75 leftfloat">S. No.</div>
				<div class="col100 leftfloat">Amount</div>
				<div class="col200 leftfloat">Create Date</div>
				<div class="col150 leftfloat">Message</div>
				<div class="clear"></div>
			</div>

<?php
		$total = 0;
		for($i = 0; $i < count ( $ar ); $i ++) {
			
			$ob = $ar [$i];
			
			$style = "style='background-color: white; color: black; padding: 5px;'";
			
			$total = $total + $ob->amount;
			?>
			<div class="row" <?php echo $style;?>>
				<div class="col75 leftfloat"><?php echo $i+1;?>.</div>
				<div class="col100 leftfloat"><?php echo $ob->amount;?>&nbsp;</div>
				<div class="col200 leftfloat"><?php echo date('d / M / Y h:i', strtotime($ob->create_date));?>&nbsp;</div>
				<div class="col150 leftfloat">
					<?php
						if($ob->message=="PairToEWallet")
							echo "Transferred to E-Wallet";
						else if($ob->message=="Pair Withdrawl")
							echo "Requested for withdraw";
					?>
				</div>
				<div class="clear"></div>
			</div>
	<?php }?>

<?php } else {?>

		<br />
			<div>
				<div class="col200 leftfloat">
					<h3>No transactions...</h3>
				</div>
				<div class="clear"></div>
			</div>


<?php }	?>						
				</div>

	</div>
			
	</div>
	<div class="clear"></div>			
			
<?php
	include ("bottom.php");
	?>

<?php
} else
	header ( "location: index.php" );
?>