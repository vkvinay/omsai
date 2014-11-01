<?php 
	session_start();

	if(isset($_SESSION['loggeduserid']) && (time()-$_SESSION['last_activity'])<1200){
		$_SESSION['last_activity'] = time();
			
		include_once 'modal/userdao.php';
		include_once 'modal/utility.php';
		include_once 'modal/entity/levelinfo.php';
		
		$userid = $_SESSION['loggeduserid'];
		
		$dao = new UserDAO();
		$user = $dao->findUser($userid);
		
		$level = $dao->getLatestLevelInfo($userid);
		
		//$level = $dao->getLatestLevelInfo($userid, $user->level);
		$payment_transaction = $dao->getSenderPaymentTransaction($user->userid, $level->level);

		if(isset($payment_transaction)){
			if($payment_transaction->status=="approved"){
				$approved = true;
				$waiting = false;
			}
			else{
				$approved = false;
				$waiting = true;
				$rejected = false;
		
				$receiverid = $dao->getReceiverID($userid, $level->level);
		
				if(isset($receiverid)){
					$waiting = false;
					$parent = $dao->findUser($receiverid);
				}
				else
					$waiting = true;
			}
		}
		else
			$waiting = true;
?>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Send Gift</title>

<style type="text/css">
	.blockheader{
		margin-left: 50px;
		font-family: font-family: 'CartoGothicStdBook', Arial, Helvetica, sans-serif;	
		font-weight: bold;
		font-size: 18px;
	}
</style>

<?php include("commonresources.php");?>

<script type="text/javascript" src="scripts/giftsend.js"></script>

</head>
<body>

<?php include("top.php"); ?>

<!-- .topbar -->
<?php include('topbarlogged.php'); ?>

<?php include("logomenu.php"); ?>
			
			
			<div class="middlecontent">
				<br/><br/>
				
				<div class="col600 leftfloat">
				
				<?php if($waiting===false){?>
				
				<div class="registerform">
				
					<?php if($approved){ ?>
				
						<div class="row"><span class="blockheader">You are approved...</span></div>
						
					<?php } else { ?>
					
					<form class="frm">
						
						<div class="row"><span class="blockheader">Send gift to this person</span></div>
						
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col150 leftfloat columnlabelbold">User ID</div>
							<div class="col250 leftfloat">
								<?php echo $parent->userid;?>
							</div>
							<div class="clear"></div>
						</div>
					
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col150 leftfloat columnlabelbold">Name</div>
							<div class="col250 leftfloat">
								<?php echo $parent->name?>
							</div>
							<div class="clear"></div>
						</div>					
		
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col150 leftfloat columnlabelbold">Contact Number</div>
							<div class="col250 leftfloat columnlabel">
								<?php echo $parent->contact_number;?>
							</div>
							<div class="clear"></div>
						</div>
						
						<br/>
						<div class="row"><span class="blockheader">Bank Details</span></div>
							
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col150 leftfloat columnlabelbold">Name</div>
							<div class="col250 leftfloat">
								<?php echo $parent->account_holder_name;?>
							</div>
							<div class="clear"></div>
						</div>
							
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col150 leftfloat columnlabelbold">Bank</div>
							<div class="col250 leftfloat">
								<?php echo $parent->bank_name;?>
							</div>
							<div class="clear"></div>
						</div>
							
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col150 leftfloat columnlabelbold">Branch</div>
							<div class="col250 leftfloat">
								<?php echo $parent->branch;?>
							</div>
							<div class="clear"></div>
						</div>
							
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col150 leftfloat columnlabelbold">Account Number</div>
							<div class="col250 leftfloat">
								<?php echo $parent->account_number;?>
							</div>
							<div class="clear"></div>
						</div>
							
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col150 leftfloat columnlabelbold">IFSC Code</div>
							<div class="col250 leftfloat">
								<?php echo $parent->ifsc_code;?>
							</div>
							<div class="clear"></div>
						</div>						
					</form>			
					
					<?php } ?>
						
				</div>
				
				<?php } else {?>
				
					<div class="row"><span class="blockheader">You will receive information soon...</span></div>
								
				<?php } ?>
				
				</div>
				<div class="col250 leftfloat">
					<img src="images/gift.jpg"/>
				</div>
				<div class="clear"></div>
				<br/><br/>
														
			</div>
			
			
<?php include("bottom.php"); ?>

<?php
	}
	else
		header("location: index.php");
?>