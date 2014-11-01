<?php 
	session_start();

	if(isset($_SESSION['loggedadminid']) && (time()-$_SESSION['last_activity'])<1200){
		$_SESSION['last_activity'] = time();
?>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Section</title>

<?php include("commonresources.php");?>

<script type="text/javascript" src="scripts/adminewallet.js"></script>

</head>
<body>

<?php include("top.php"); ?>

<!-- .topbar -->
<?php include('topbarlogged.php'); ?>

<?php include("adminlogomenu.php"); ?>
			
<div class="middlecontent">

	<div class="accountdata">
		<h2>Transfer money to e-wallet</h2>
		
		<div class="accountheader">Activate / Deactivate</div>
		<form class="frm">
		<br/>
		<div class="row">
			<div class="col100 leftfloat">&nbsp;</div>
			<div class="col150 leftfloat">User ID</div>
			<div class="col250 leftfloat">
				<input type="text" class="txt txt200" name="userid"/>
			</div>
			<div class="col200 leftfloat msguserid message">&nbsp;</div>
			<div class="clear"></div>
		</div>
		<div class="row">
			<div class="col100 leftfloat">&nbsp;</div>
			<div class="col150 leftfloat">Amount</div>
			<div class="col250 leftfloat">
				<input type="text" class="txt txt200" name="amount"/>
			</div>
			<div class="col200 leftfloat msgamount message">&nbsp;</div>
			<div class="clear"></div>
		</div>
		<div class="row">
			<div class="col100 leftfloat">&nbsp;</div>
			<div class="col150 leftfloat">&nbsp;</div>
			<div class="col500 leftfloat">
				<input type="button" name="btntransfer" value="Transfer Amount"/>
				<input type="button" name="btnlogs" value=" View Logs "/>
			</div>		
			<div class="clear"></div>
		</div>
		<div class="row">
			<div class="col100 leftfloat">&nbsp;</div>
			<div class="col300 leftfloat msgupdate">
			&nbsp;
			</div>
		</div>
		<br/>
		</form>
		
		<div class="accountheader">Previous transactions...</div>
		<div class="logs">
			&nbsp;		
		</div>
	</div>
	
</div>
			
<?php include("bottom.php"); ?>

<?php 
	}
	else
		header("location: index.php");
?>