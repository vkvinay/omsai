<?php 
	session_start();

	if(isset($_SESSION['loggeduserid']) && (time()-$_SESSION['last_activity'])<1200){
		$_SESSION['last_activity'] = time();
?>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Send Gift</title>

<style type="text/css">
	.blockheader{
		margin-left: 50px;
		font-family: font-family: 'CartoGothicStdBook', Arial, Helvetica, sans-serif;	
		font-weight: bold;
		font-size: 18px;
	}
</style>

<?php include("commonresources.php");?>

<script type="text/javascript" src="scripts/receivegiftform.js"></script>

</head>
<body>

<?php include("top.php"); ?>

<!-- .topbar -->
<?php include('topbarlogged.php'); ?>

<?php include("logomenu.php"); ?>
			
			
			<div class="middlecontent">
				<br/><br/>
			
				<div class="leftfloat senders" style="width: 720px">	
					&nbsp;									
				</div>
				<div class="col200 leftfloat">
					<img src="images/gift.jpg" style="width: 195px; height: 195px; padding-top: 50px; margin-left: 20px;"/>
				</div>
				<div class="clear"></div>
				<br/><br/>
										
			</div>
			
			
<?php include("bottom.php"); ?>

<?php 
	}
	else
		header("location: index.php");
?>