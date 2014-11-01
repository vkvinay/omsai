<?php 
	session_start();

	if(isset($_SESSION['loggedadminid']) && (time()-$_SESSION['last_activity'])<1200){
		$_SESSION['last_activity'] = time();
?>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Id addition information</title>

<?php include("commonresources.php");?>
<link rel="stylesheet" type="text/css" media="screen" href="css/calendar.css">

<script type="text/javascript" src="scripts/cal.js"></script>
<script type="text/javascript" src="scripts/newids.js"></script>

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
							<div class="col150 leftfloat columnlabelbold">Start Date</div>
							<div class="col350 leftfloat">
								<input type="text" name="startdate" class="txt txt100"/>
							</div>
							<div class="message col200 leftfloat">&nbsp;</div>
							<div class="clear"></div>
						</div>
					
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col150 leftfloat columnlabelbold">End Date</div>
							<div class="col350 leftfloat">
								<input type="text" name="enddate" class="txt txt100"/>
							</div>
							<div class="message col200 leftfloat">&nbsp;</div>
							<div class="clear"></div>
						</div>
					
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col150 leftfloat columnlabelbold">&nbsp;</div>
							<div class="col350 leftfloat">
								<input type="button" value="   Load Data   " name="btnsubmit" style="padding:5px;"/>
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