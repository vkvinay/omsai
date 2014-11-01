<?php 
	session_start();

	if(isset($_SESSION['loggeduserid'])){
			
		include_once 'modal/admindao.php';
		include_once 'modal/entity/ewalletlog.php';
		
		$userid = $_REQUEST['userid'];
		
		$dao = new AdminDAO();
		$user = $dao->findUser($userid);
		
		if(isset($user)){
			$ar = $dao->getPairIncomeLogs($userid);

			if(isset($ar) && count($ar)>0){
?>
<br/><br/>
<div style="background-color: black; color: white; font-weight: bold; padding: 5px;">
	<div class="col75 leftfloat">S. No.</div>
	<div class="col100 leftfloat">Amount</div>
	<div class="col200 leftfloat">Create Date</div>
	<div class="col150 leftfloat">Message</div>
	<div class="clear"></div>
</div>

<?php 
					    $total = 0;
						for($i=0;$i<count($ar);$i++){
							
							$ob = $ar[$i];
							
							$style = "style='background-color: white; color: black; padding: 5px;'";
							
							$total = $total + $ob->amount;
					?>
							<div class="row" <?php echo $style;?>>
								<div class="col75 leftfloat"><?php echo $i+1;?>.</div>
								<div class="col100 leftfloat"><?php echo $ob->amount;?>&nbsp;</div>
								<div class="col200 leftfloat"><?php echo date('d / M / Y h:i', strtotime($ob->create_date));?>&nbsp;</div>
								<div class="col150 leftfloat"><?php echo $ob->message;?>&nbsp;</div>
								<div class="clear"></div>
							</div>
							<?php }?>

<?php } else {?>

		<br/>
		<div>		
			<div class="col200 leftfloat"><h3>No transactions...</h3></div>
			<div class="clear"></div>
		</div>


<?php
		} 
	}
	else
		echo "Invalid userid...";
}
	else 
		echo "notlogged";
?>			