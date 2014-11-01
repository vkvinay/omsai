<?php 
	session_start();

	if(isset($_SESSION['loggeduserid']) && (time()-$_SESSION['last_activity'])<1200){
		$_SESSION['last_activity'] = time();
		
		include_once 'modal/admindao.php';
		include_once 'modal/userdao.php';
		include_once 'modal/entity/ewallet.php';
		include_once 'modal/entity/ewalletlog.php';
		
		$userid = $_SESSION['loggeduserid'];
				
		$adao = new AdminDAO();
		$udao = new UserDAO();
		
		$ewallet = $udao->getUserEWallet($userid);
		
		$logs = $adao->getEwalletLogs($userid);
		
		if(isset($ewallet))
			$balance = $ewallet->balance;
		else
			$balance = 0;
		
		$userid = $_SESSION['loggeduserid'];
		
		$user = $udao->findUser($userid);
		
		$leftsideid = $user->leftside;
		$rightsideid = $user->rightside;
		
		$left_count = 0;
		$right_count = 0;
		
		if(isset($leftsideid)){
			$left_count++;
		}
		
		if(isset($rightsideid)){
			$right_count++;
		}
		
		$udao->totalcount = 0;
		
		if(isset($leftsideid)){
				
			$udao->getChildCount($leftsideid);
			$left_count += $udao->totalcount;
		}
		
		$udao->totalcount = 0;
		
		if(isset($rightsideid)){
			$udao->getChildCount($rightsideid);
			$right_count += $udao->totalcount;
		}
		
		if($left_count==$right_count)
			$pair = $left_count;
		else if($left_count<$right_count)
			$pair = $left_count;
		else if($left_count>$right_count)
			$pair = $right_count;
		
		$pairincome = $pair * 100;
		
		$logs = $adao->getPairIncomeLogs($userid);
		$total = 0;
		
		if(isset($logs) && count($logs)>0){
			foreach($logs as $log){
				$total = $total + $log->amount;
			}
		}
		
		$pairincome -= $total;
?>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User E-Wallet</title>

<?php include("commonresources.php");?>
<script type="text/javascript" src="scripts/userewallet.js"></script>

</head>
<body>

<?php include("top.php"); ?>

<!-- .topbar -->
<?php include('topbarlogged.php'); ?>

<?php include("logomenu.php"); ?>
			
			
			<div class="middlecontent">
				<br/><br/>
				<div class="registerform">
					<form class="frm">
						<input type="hidden" name="hidden_userid" value="<?php echo $userid;?>"/>
					
						<div class="accountheader">E-Wallet</div>
						<br/>
						
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col150 leftfloat columnlabelbold"><h3>Current Balance</h3></div>
							<div class="col50 leftfloat columnlabelbold">:</div>
							<div class="col350 leftfloat">
								<h3><?php echo $balance; ?></h3>
							</div>
							<div class="message col200 leftfloat">&nbsp;</div>
							<div class="clear"></div>
						</div>
						
						<div class="accountheader">Pair Income</div>
						<br/>
						
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col150 leftfloat columnlabelbold"><h3>Income</h3></div>
							<div class="col50 leftfloat columnlabelbold">:</div>
							<div class="col350 leftfloat">
								<h3><?php echo $pairincome; ?></h3>
							</div>
							<div class="message col200 leftfloat">&nbsp;</div>
							<div class="clear"></div>
						</div>
						
						<?php if($pairincome>=500){ ?>
						
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col150 leftfloat">Amount</div>
							<div class="col250 leftfloat">
								<input type="text" class="txt txt150" name="withdrawlamount"/>
							</div>
							<div class="col200 leftfloat msgwithdrawlamount message">&nbsp;</div>
							<div class="clear"></div>
						</div>
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col150 leftfloat">&nbsp;</div>
							<div class="col500 leftfloat">
								<input type="button" name="btnwithdrawl" value="Request Withdrawl"/>&nbsp;&nbsp;
								<input type="button" name="btnaddtoewallet" value="Transfer to E-Wallet"/>
							</div>		
							<div class="clear"></div>
						</div>
						<?php } ?>
						
						<div class="accountheader">Transfer to other's E-Wallet</div>
						<form class="frm">
						<br/>
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col150 leftfloat">User ID</div>
							<div class="col250 leftfloat">
								<input type="text" class="txt txt100" name="userid"/>
							</div>
							<div class="col200 leftfloat msguserid message">&nbsp;</div>
							<div class="clear"></div>
						</div>
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col150 leftfloat">Amount</div>
							<div class="col250 leftfloat">
								<input type="text" class="txt txt150" name="amount"/>
							</div>
							<div class="col200 leftfloat msgamount message">&nbsp;</div>
							<div class="clear"></div>
						</div>
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col150 leftfloat">&nbsp;</div>
							<div class="col500 leftfloat">
								<input type="button" name="btntransfer" value="Transfer Amount"/>
							</div>		
							<div class="clear"></div>
						</div>
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col300 leftfloat msgupdate">
							&nbsp;
							</div>
						</div>
						<br/>
						</form>
												
						<div class="accountheader">E-Wallet Logs</div>
						
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col600 leftfloat">
								<div class="logs">&nbsp;</div>
							</div>
							<div class="clear"></div>
						</div>
												
						<div class="accountheader">Pair Income Logs</div>
						
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col600 leftfloat">
								<div class="pairlogs">&nbsp;</div>
							</div>
							<div class="clear"></div>
						</div>
						
					</form>				
				</div>
									
			</div>
			
			
<?php include("bottom.php"); ?>

<?php 
	}
	else
		header("location: index.php");
?>