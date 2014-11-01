<?php 
	session_start();

	if(isset($_SESSION['loggeduserid']) && (time()-$_SESSION['last_activity'])<1200){
		$_SESSION['last_activity'] = time();
?>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Authenticate Transaction Password</title>

<?php include("commonresources.php");?>
<script type="text/javascript" src="scripts/receivegift.js"></script>

</head>
<body>

<?php include("top.php"); ?>

<!-- .topbar -->
<?php include('topbarlogged.php'); ?>

<?php include("logomenu.php"); ?>
			
			
			<div class="middlecontent">
				<br/><br/>
				<div class="registerform">
					
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col150 leftfloat columnlabelbold">Transaction Password</div>
							<div class="col350 leftfloat">
								<input type="password" name="password" class="txt txt200"/>
							</div>
							<div class="message col200 leftfloat">&nbsp;</div>
							<div class="clear"></div>
						</div>
						
						<div>
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col150 leftfloat columnlabelbold">&nbsp;</div>
							<div class="col300 leftfloat">
							<input type="button" value="Check Password" name="btnsubmit" /> <span
								id="cont"></span><br/><br/>
							</div>
							<div class="clear"></div>
						</div>
						
						<div>
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col400 leftfloat">
								<div class="row message passwordmsg">&nbsp;</div>
							</div>
							<div class="clear"></div>
						</div>
		
				</div>
									
			</div>
			
			
<?php include("bottom.php"); ?>

<?php 
	}
	else
		header("location: index.php");
?>