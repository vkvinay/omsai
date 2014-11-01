<?php 
	session_start();

	if(isset($_SESSION['loggedadminid'])){
			
		include_once 'modal/admindao.php';
		include_once 'modal/entity/ewalletlog.php';
		
		$userid = $_REQUEST['userid'];
		
		$dao = new AdminDAO();
		$user = $dao->findUser($userid);
		
		if(isset($user)){
			$ar = $dao->getEwalletLogs($userid);

			if(isset($ar) && count($ar)>0){
?>
<br/><br/>
<div style="background-color: black; color: white; font-weight: bold; padding: 5px;">
	<div class="col75 leftfloat">S. No.</div>
	<div class="col100 leftfloat">Amount</div>
	<div class="col150 leftfloat">Create Date</div>
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
							
							$total = $total + $ob->amount;
					?>
							<div class="row" <?php echo $style;?>>
								<div class="col75 leftfloat"><?php echo $i+1;?>.</div>
								<div class="col100 leftfloat"><?php echo $ob->amount;?>&nbsp;</div>
								<div class="col150 leftfloat"><?php echo date('d / M / Y h:i', strtotime($ob->create_date));?>&nbsp;</div>
								<div class="clear"></div>
							</div>
							<?php }?>
							<div class="row"
								style='background-color: white; color: black; padding: 5px;'>
								<div class="col75 leftfloat">&nbsp;</div>
								<div class="col100 leftfloat" style="text-align: right">Total = &nbsp;</div>
								<div class="col100 leftfloat"><?php echo $total;?> Rs.</div>
								<div class="clear"></div>
							</div>

<?php } else { echo "<br/>No transactions..."; } ?>

<?php 
		}
		else
			echo "<br/>Invalid userid...";
	}
	else 
		echo "notlogged";
?>			