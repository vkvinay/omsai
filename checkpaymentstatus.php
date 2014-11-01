<?php
session_start ();

if (isset ( $_SESSION ['loggedadminid'] ) && (time () - $_SESSION ['last_activity']) < 1200) {
	$_SESSION ['last_activity'] = time ();
	
	include_once 'modal/userdao.php';
	include_once 'modal/utility.php';
	include_once 'modal/entity/levelinfo.php';
	
	$userid = $_REQUEST ['id'];
	
	$dao = new UserDAO ();
	$user = $dao->findUser ( $userid );
	
	if (isset ( $user )) {
		
		$level = $dao->getLatestLevelInfo ( $userid );
		
		// $level = $dao->getLatestLevelInfo($userid, $user->level);
		$payment_transaction = $dao->getSenderPaymentTransaction ( $user->userid, $level->level );
?>


<div class="row">
	<h4>Current Level : <?php echo $level->level+1;?></h4>
</div>

<?php
		if (isset ( $payment_transaction ) && $payment_transaction->status=="pending") {
			
			$parent = $dao->findUser ( $payment_transaction->receiverid );
?>
<div class="row">
	<h2>Send gift to this person</h2>
</div>

<div class="row">
	<div class="col150 leftfloat">User ID</div>
	<div class="col250 leftfloat">
		<?php echo $payment_transaction->receiverid;?>
	</div>
	<div class="clear"></div>
</div>

<div class="row">
	<div class="col150 leftfloat columnlabelbold">Name</div>
	<div class="col250 leftfloat">
		<?php echo $parent->name?>
	</div>
	<div class="clear"></div>
</div>

<div class="row">
	<div class="col150 leftfloat columnlabelbold">Contact Number</div>
	<div class="col250 leftfloat columnlabel">
		<?php echo $parent->contact_number;?>
	</div>
	<div class="clear"></div>
</div>

<br />
<div class="row">
	<h2>Bank Details</h2>
</div>

<div class="row">
	<div class="col150 leftfloat columnlabelbold">Name</div>
	<div class="col250 leftfloat">
		<?php echo $parent->account_holder_name;?>
	</div>
	<div class="clear"></div>
</div>

<div class="row">
	<div class="col150 leftfloat columnlabelbold">Bank</div>
	<div class="col250 leftfloat">
		<?php echo $parent->bank_name;?>
	</div>
	<div class="clear"></div>
</div>

<div class="row">
	<div class="col150 leftfloat columnlabelbold">Branch</div>
	<div class="col250 leftfloat">
		<?php echo $parent->branch;?>
	</div>
	<div class="clear"></div>
</div>

<div class="row">
	<div class="col150 leftfloat columnlabelbold">Account Number</div>
	<div class="col250 leftfloat">
		<?php echo $parent->account_number;?>
	</div>
	<div class="clear"></div>
</div>

<div class="row">
	<div class="col150 leftfloat columnlabelbold">IFSC Code</div>
	<div class="col250 leftfloat">
		<?php echo $parent->ifsc_code;?>
	</div>
	<div class="clear"></div>
</div>

<?php } else {?>

<div class="row">
	<span class="blockheader">No payment transaction entry...</span>
</div>

<?php
		}
?> 

<div class="row">
	<h2>Child Status</h2>
</div>

<?php 
	$leftid = $user->leftside==NULL ? "None" : $user->leftside;
	$rightid = $user->rightside==NULL ? "None" : $user->rightside;
?>

<div class="row">
	<div class="col150 leftfloat">Left Side</div>
	<div class="col250 leftfloat">	
		<?php 
			if($user->leftside==NULL)
				echo "Not added...";
			else
				echo $user->leftside;
		?>
	</div>
	<div class="clear"></div>
</div>

<div class="row">
	<div class="col150 leftfloat">Right Side</div>
	<div class="col250 leftfloat">
		<?php 
			if($user->rightside==NULL)
				echo "Not added...";
			else
				echo $user->rightside;
		?>
	</div>
	<div class="clear"></div>
</div>

<br/><br/>
<h2>Previous Sending History</h2>

<?php 
	$ar = $dao->getSenderReport($userid);
?>
				<?php if(isset($ar) && count($ar)>0){ ?>
					<div style="background-color: black; color: white; font-weight: bold; padding: 5px;">
						<div class="col50 leftfloat">S. No.</div>
						<div class="col250 leftfloat">Receiver ID</div>				
						<div class="col50 leftfloat">Level</div>
						<div class="col75 leftfloat">Amount</div>
						<div class="col150 leftfloat">Confirm Date</div>
						<div class="col50 leftfloat">Status</div>
						<div class="clear"></div>
					</div>

					<?php 
					    $total = 0;
						for($i=0;$i<count($ar);$i++){
							
							if($i%2==0)
								$style = "style='background-color: rgb(128,255,255); color: black; padding: 5px;'";
							else
								$style = "style='background-color: white; color: black; padding: 5px;'";
							
							$ob = $ar[$i];
							//$user = $dao->findUser($ob->receiverid);
							
							$jise_bheja = $dao->findUser($ob->receiverid);
							
							if(!isset($ob->confirmdate))
								$confirmdate = "n/a";
							else
								$confirmdate = $ob->confirmdate;
							
							$total = $total + Utility::getLevelAmount($ob->level);
					?>
					<div class="row" <?php echo $style;?>>
						<div class="col50 leftfloat"><?php echo $i+1;?>.</div>
						<div class="col250 leftfloat"><?php echo $ob->receiverid;?> ( <?php echo $jise_bheja->name;?> )</div>				
						<div class="col50 leftfloat"><?php echo $ob->level+1;?>&nbsp;</div>
						<div class="col75 leftfloat"><?php echo Utility::getLevelAmount($ob->level);?></div>
						<div class="col150 leftfloat"><?php echo $confirmdate;?>&nbsp;</div>
						<div class="col50 leftfloat"><?php echo $ob->status;?>&nbsp;</div>
						<div class="clear"></div>
					</div>
					<?php }?>
					<div class="row" style='background-color: white; color: black; padding: 5px;'>
						<div class="col75 leftfloat">&nbsp;</div>
						<div class="col150 leftfloat">&nbsp;</div>				
						<div class="col100 leftfloat" style="text-align: right">Total = &nbsp;</div>
						<div class="col100 leftfloat"><?php echo $total;?> Rs.</div>
						<div class="col150 leftfloat">&nbsp;</div>
						<div class="col50 leftfloat">&nbsp;</div>
						<div class="clear"></div>
					</div>
					
					<br/><br/>
					<?php } else { echo "No transactions...<br/><br/>"; } ?>


<br/>
<h2>Previous Receiving History</h2>

<?php 
	$ar = $dao->getReceiverReport($userid);
?>
				<?php if(isset($ar) && count($ar)>0){ ?>
					<div style="background-color: black; color: white; font-weight: bold; padding: 5px;">
						<div class="col50 leftfloat">S. No.</div>
						<div class="col250 leftfloat">Sender ID</div>				
						<div class="col50 leftfloat">Level</div>
						<div class="col75 leftfloat">Amount</div>
						<div class="col150 leftfloat">Confirm Date</div>
						<div class="col50 leftfloat">Status</div>
						<div class="clear"></div>
					</div>

					<?php 
					    $total = 0;
						for($i=0;$i<count($ar);$i++){
							
							if($i%2==0)
								$style = "style='background-color: rgb(128,255,255); color: black; padding: 5px;'";
							else
								$style = "style='background-color: white; color: black; padding: 5px;'";
							
							$ob = $ar[$i];
							//$user = $dao->findUser($ob->receiverid);
							
							$jise_bheja = $dao->findUser($ob->senderid);
							
							if(!isset($ob->confirmdate))
								$confirmdate = "n/a";
							else
								$confirmdate = $ob->confirmdate;
							
							$total = $total + Utility::getLevelAmount($ob->level);
					?>
					<div class="row" <?php echo $style;?>>
						<div class="col50 leftfloat"><?php echo $i+1;?>.</div>
						<div class="col250 leftfloat"><?php echo $ob->senderid;?> ( <?php echo $jise_bheja->name;?> )</div>				
						<div class="col50 leftfloat"><?php echo $ob->level+1;?>&nbsp;</div>
						<div class="col75 leftfloat"><?php echo Utility::getLevelAmount($ob->level);?></div>
						<div class="col150 leftfloat"><?php echo $confirmdate;?>&nbsp;</div>
						<div class="col50 leftfloat"><?php echo $ob->status;?>&nbsp;</div>
						<div class="clear"></div>
					</div>
					<?php }?>
					<div class="row" style='background-color: white; color: black; padding: 5px;'>
						<div class="col75 leftfloat">&nbsp;</div>
						<div class="col150 leftfloat">&nbsp;</div>				
						<div class="col100 leftfloat" style="text-align: right">Total = &nbsp;</div>
						<div class="col100 leftfloat"><?php echo $total;?> Rs.</div>
						<div class="col150 leftfloat">&nbsp;</div>
						<div class="col50 leftfloat">&nbsp;</div>
						<div class="clear"></div>
					</div>
					
					<br/><br/>
					<?php } else { echo "No transactions...<br/><br/>"; } ?>
					
<?php
	} else {
		?>

<div class="row">
	<span class="blockheader">Invalid user id...</span>
</div>

<?php
	}
} else
	echo "notlogged";
?>