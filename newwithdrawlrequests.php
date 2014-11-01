<?php
session_start();

if(isset($_SESSION['loggedadminid'])){

	$_SESSION['last_activity'] = time();

	$adminid = $_SESSION['loggedadminid'];

	include_once 'modal/admindao.php';

	$dao = new AdminDAO();

	$ar = $dao->getWithdrawlRequests(0, 100);

	if(count($ar)>0){?>

	<br/>

	<div class="row"style="background-color: black; color: white; font-weight: bold; padding: 4px;">
		<div class="col50 leftfloat">&nbsp;</div>
		<div class="col75 leftfloat centeralign">User ID</div>
		<div class="col100 leftfloat">Amount</div>
		<div class="col150 leftfloat">Request Date</div>
		<div class="clear"></div>
	</div>
						
<?php 
	for($i=0;$i<count($ar);$i++){
		$ob = $ar[$i];
?>
							
	<div class="row">
		<div class="col50 leftfloat">&nbsp;</div>
		<div class="col75 leftfloat" style="text-align: center;"><?php echo $ob->userid;?></div>
		<div class="col100 leftfloat"><?php echo $ob->amount;?></div>
		<div class="col150 leftfloat"><?php echo $ob->request_date;?></div>
		<div class="col150 leftfloat">
			<span class="approve lnk" rel="<?php echo $ob->request_id;?>">Accept</span>&nbsp;&nbsp;
			<span class="deny lnk" rel="<?php echo $ob->request_id;?>">Deny</span>
		</div>
		<div class="clear"></div>
	</div>

<?php } ?>
						
	</form>

<?php } else { ?>

<div class="row">
	<br/>
	&nbsp;&nbsp;<span class="blockheader">No new requests...</span>
</div>

<?php 
	 } 
	} 
	else { 
		echo "notlogged"; 
	}
?>
