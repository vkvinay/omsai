<?php 
	session_start();

	if(isset($_SESSION['loggeduserid']) && (time()-$_SESSION['last_activity'])<1200){
		$_SESSION['last_activity'] = time();
			
		$name = $_SESSION['loggedusername'];
		$userid = $_SESSION['loggeduserid'];
		
		include("modal/userdao.php");
		include("modal/utility.php");
		
		$dao = new UserDAO();
		
		$ar = $dao->getUserIncome($userid);
?>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>E-Wallet Summary</title>

<link rel="stylesheet" type="text/css" media="all" href="css/downtree.css">
<?php include("commonresources.php");?>

<script type="text/javascript" src="scripts/common.js"></script>
<script type="text/javascript" src="scripts/jquery.tooltip.js"></script>

</head>
<body>
<input type="hidden" name="userid" value="<?php echo $userid;?>"/>
<?php include("top.php"); ?>

<!-- .topbar -->
<?php include('topbarlogged.php'); ?>

<?php include("logomenu.php"); ?>
			
			<div class="middlecontent">
				<br/><br/>
				
				<?php if(isset($ar) && count($ar)>0){ ?>
				<div class="downtree">
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
							
							if(!isset($ob->confirmdate))
								$confirmdate = "n/a";
							else
								$confirmdate = $ob->confirmdate;
							
							$total = $total + Utility::getLevelAmount($ob->level);
					?>
					<div class="row" <?php echo $style;?>>
						<div class="col75 leftfloat"><?php echo $i+1;?>.</div>
						<div class="col150 leftfloat"><?php echo $ob->senderid;?></div>				
						<div class="col100 leftfloat"><?php echo $ob->level?></div>
						<div class="col100 leftfloat"><?php echo Utility::getLevelAmount($ob->level);?></div>
						<div class="col150 leftfloat"><?php echo $confirmdate;?></div>
						<div class="col50 leftfloat"><?php echo $ob->status;?></div>
						<div class="clear"></div>
					</div>
					<?php }?>
					<div class="row" style='background-color: white; color: black; padding: 5px;'>
						<div class="col75 leftfloat">&nbsp;</div>
						<div class="col150 leftfloat">&nbsp;</div>				
						<div class="col100 leftfloat" style="text-align: right">Total = </div>
						<div class="col100 leftfloat"><?php echo $total;?> Rs.</div>
						<div class="col150 leftfloat">&nbsp;</div>
						<div class="col50 leftfloat">&nbsp;</div>
						<div class="clear"></div>
					</div>
					
					<br/><br/>
				</div>
				<?php } else { echo "No transactions..."; } ?>
			</div>
			
<?php include("bottom.php"); ?>

<?php 
	}
	else
		header("location: index.php");
?>