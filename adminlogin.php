<?php 
	session_start();
?>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Administrator Section</title>

<?php include("commonresources.php");?>

<script type="text/javascript" src="scripts/common.js"></script>
<script type="text/javascript" src="scripts/adminlogin.js"></script>

</head>

<?php include("top.php"); ?>


		<div class="col500 leftfloat">
			<form class="frm">
			<div class="row"><br/><br/>&nbsp;</div>
			<div class="row">
				<div class="col100 leftfloat">&nbsp;</div>
				<div class="col100 leftfloat">Username</div>
				<div class="col300 leftfloat">
					<input type="text" name="loginuserid" class="txt txt250 lg"/>
				</div>
				<div class="col100 leftfloat">&nbsp;</div>
				<div class="clear"></div>
			</div>
	
			<div class="row">
				<div class="col100 leftfloat">&nbsp;</div>
				<div class="col100 leftfloat">Password</div>
				<div class="col300 leftfloat">
					<input type="password" name="loginpassword" class="txt txt250 lg"/>
				</div>
				<div class="col100 leftfloat">&nbsp;</div>
				<div class="clear"></div>
			</div>
	
			<div class="row">
				<div class="col100 leftfloat">&nbsp;</div>
				<div class="col100 leftfloat">&nbsp;</div>
				<div class="col300 leftfloat">
					<input type="button" name="btnlogin" value=" Authenticate "/>
				</div>
				<div class="col100 leftfloat">&nbsp;</div>
				<div class="clear"></div>
			</div>
	
			<div class="row">
				<div class="col100 leftfloat">&nbsp;</div>
				<div class="col300 leftfloat loginmsg">&nbsp;</div>
				<div class="clear"></div>
			</div>
			</form>
		</div>
		<div class="col100 leftfloat">&nbsp;</div>
		<div class="col200 leftfloat">
			<div class="row"><br/><br/>&nbsp;</div>
			<img src="images/adminlogin.jpg" style="width:150px; height: 150px;"/>
		</div>		
		<div class="clear"></div>

			
<?php include("bottom.php"); ?>
