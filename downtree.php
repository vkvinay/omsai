<?php 
	session_start();

	if(isset($_SESSION['loggeduserid']) && (time()-$_SESSION['last_activity'])<1200){
		$_SESSION['last_activity'] = time();
			
		$name = $_SESSION['loggedusername'];
		$userid = $_SESSION['loggeduserid'];
		
		include("modal/userdao.php");
?>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Downline Tree</title>

<link rel="stylesheet" type="text/css" media="all" href="css/downtree.css">
<?php include("commonresources.php");?>

<script type="text/javascript" src="scripts/common.js"></script>
<script type="text/javascript" src="scripts/downtree.js"></script>
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
				
				<div class="downtree">&nbsp;</div>
				
			</div>
			
<?php include("bottom.php"); ?>

<?php 
	}
	else
		header("location: index.php");
?>