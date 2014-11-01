<?php 
	session_start();

	if(isset($_SESSION['loggeduserid']) && (time()-$_SESSION['last_activity'])<1200){
		$_SESSION['last_activity'] = time();
			
		include_once 'modal/userdao.php';
		include_once 'modal/entity/paymenttransaction.php';
		include_once 'modal/utility.php';
		
		$userid = $_SESSION['loggeduserid'];
		
		$dao = new UserDAO();
		$user = $dao->findUser($userid);
		
		$ar = $dao->getReceiverReport($userid);
?>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Received Gift List</title>

<style type="text/css">
	.blockheader{
		margin-left: 50px;
		font-family: font-family: 'CartoGothicStdBook', Arial, Helvetica, sans-serif;	
		font-weight: bold;
		font-size: 18px;
	}
</style>
<link rel="stylesheet" type="text/css" media="all" href="css/downtree.css">

<?php include("commonresources.php");?>

</head>
<body>

<?php include("top.php"); ?>

<!-- .topbar -->
<?php include('topbarlogged.php'); ?>

<?php include("logomenu.php"); ?>
			
			
			<div class="middlecontent">
				<br/><br/>
				
				<div class="downtree">
					<?php if(isset($ar) && count($ar)>0){ ?>
					<div style="background-color: black; color: white; font-weight: bold; padding: 5px;">
						<div class="col75 leftfloat">S. No.</div>
						<div class="col150 leftfloat">Sender ID</div>				
						<div class="col100 leftfloat">Level</div>
						<div class="col100 leftfloat">Amount</div>
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
							
							if(!isset($ob->confirmdate))
								$confirmdate = "n/a";
							else
								$confirmdate = $ob->confirmdate;
							
							$total = $total + Utility::getLevelAmount($ob->level);
					?>
					<div class="row" <?php echo $style;?>>
						<div class="col75 leftfloat"><?php echo $i+1;?>.</div>
						<div class="col150 leftfloat"><?php echo $ob->senderid;?>&nbsp;</div>				
						<div class="col100 leftfloat"><?php echo $ob->level;?>&nbsp;</div>
						<div class="col100 leftfloat"><?php echo Utility::getLevelAmount($ob->level);?>&nbsp;</div>
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
					<?php } else { echo "No transactions..."; } ?>
				</div>
			</div>
			
			
<?php include("bottom.php"); ?>

<?php 
	}
	else
		header("location: index.php");
?>