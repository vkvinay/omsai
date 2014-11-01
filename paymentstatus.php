<?php 
	session_start();

	if(isset($_SESSION['loggedadminid']) && (time()-$_SESSION['last_activity'])<1200){
		$_SESSION['last_activity'] = time();
?>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Check payment status</title>

<?php include("commonresources.php");?>
<script type="text/javascript" src="scripts/paymentstatus.js"></script>

</head>
<body>

<?php include("top.php"); ?>

<!-- .topbar -->
<?php include('topbarlogged.php'); ?>

<?php include("adminlogomenu.php"); ?>
			
			
			<div class="middlecontent">
				<br/><br/>
				<div class="registerform">
					<form class="frm">
					
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col50 leftfloat columnlabelbold">ID</div>
							<div class="col350 leftfloat">
								<input type="text" name="id" class="txt txt100"/> &nbsp; <input type="button" value="   Check Status   " name="btnsubmit" style="padding:5px;"/>
							</div>
							<div class="message col200 leftfloat">&nbsp;</div>
							<div class="clear"></div>
						</div>
						
						<div>
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col400 leftfloat">
								<div class="row message statusmsg">&nbsp;</div>
							</div>
							<div class="clear"></div>
						</div>
						
						<div>
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col700 leftfloat data">
								&nbsp;
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