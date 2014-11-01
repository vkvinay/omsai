<?php 
	session_start();

	if(isset($_SESSION['loggeduseremail'])){
?>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User added successfully...</title>

<?php include("commonresources.php");?>

</head>
<body>

<?php include("top.php"); ?>

<!-- .topbar -->
<?php include('topbarlogged.php'); ?>

<?php include("logomenu.php"); ?>
			
			
			<div class="middlecontent">
				<br/><br/>
				
				<div class="row">
					<div class="col100 leftfloat">&nbsp;</div>
					<div class="col350 leftfloat">
						User added successfully...
					</div>
					<div class="clear"></div>
				</div>
				<br/><br/>
			</div>
			
<?php include("bottom.php"); ?>

<?php 
	}
	else
		header("location: index.php");
?>