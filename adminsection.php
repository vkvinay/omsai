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

<script type="text/javascript" src="scripts/adminsection.js"></script>

</head>
<body>

<?php include("top.php"); ?>

<!-- .topbar -->
<?php include('topbarlogged.php'); ?>

<?php include("adminlogomenu.php"); ?>
			
<div class="middlecontent">

	<div class="accountdata">
		<h2>User Actions</h2>
		
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
			<div class="col150 leftfloat">Action</div>
			<div class="col250 leftfloat">
				<label><input type="radio" name="action" value="active" checked="checked"/>Activate</label>&nbsp;&nbsp;
				<!-- <label><input type="radio" name="action" value="disabled"/>Deactivate</label> -->
			</div>
			<div class="clear"></div>
		</div>
		<div class="row">
			<div class="col100 leftfloat">&nbsp;</div>
			<div class="col150 leftfloat">&nbsp;</div>
			<div class="col250 leftfloat">
				<input type="button" name="btnupdate" value="Update Status"/>
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
		
		<div class="accountheader">New Users</div>
		<div class="accountdetails">
			&nbsp;		
		</div>
	
		<br/><br/>
		
		<div class="accountheader">New Withdrawl Requests</div>
		<div class="withdrawlrequests">
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