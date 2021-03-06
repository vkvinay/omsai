<?php 
	session_start();

	if(isset($_SESSION['loggeduseremail'])){
		
		$name = $_SESSION['loggedusername'];
		$userid = $_SESSION['loggeduserid'];
		
		include("modal/userdao.php");
		
		$dao = new UserDAO();
		$user = $dao->findUser($userid);
		
		if(isset($user->leftside))
			$l1_user = $dao->findUser($user->leftside);
			
		if(isset($user->rightside))
			$l2_user = $dao->findUser($user->rightside);
?>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Direct List</title>

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
				
				<div class="downtree">
					<div style="background-color: black; color: white; font-weight: bold; padding: 5px;">
						<div class="col50 leftfloat">S. No.</div>
						<div class="col250 leftfloat">Name</div>				
						<div class="col100 leftfloat">User ID</div>
						<div class="col150 leftfloat">Join Date</div>
						<div class="col50 leftfloat">Status</div>
						<div class="clear"></div>
					</div>
					
					<?php if(isset($l1_user)){?>
					<div style="background-color: rgb(128,255,255); color: black; padding: 5px;">
						<div class="col50 leftfloat">1.</div>
						<div class="col250 leftfloat"><?php echo $l1_user->name;?></div>				
						<div class="col100 leftfloat"><?php echo $l1_user->userid;?></div>
						<div class="col150 leftfloat"><?php echo $l1_user->joindate;?></div>
						<div class="col50 leftfloat"><?php echo $l1_user->status;?></div>
						<div class="clear"></div>
					</div>
					<?php }else{?>
					Not added...
					<?php } ?>
					
					<?php if(isset($l2_user)){?>
					<div style="background-color: white; color: black; padding: 5px;">
						<div class="col50 leftfloat">2.</div>
						<div class="col250 leftfloat"><?php echo $l2_user->name;?></div>				
						<div class="col100 leftfloat"><?php echo $l2_user->userid;?></div>
						<div class="col150 leftfloat"><?php echo $l2_user->joindate;?></div>
						<div class="col50 leftfloat"><?php echo $l2_user->status;?></div>
						<div class="clear"></div>
					</div>
					<?php }else{?>
					Not added...
					<?php } ?>
					
					<br/><br/>
				</div>
				
			</div>
			
<?php include("bottom.php"); ?>

<?php 
	}
	else
		header("location: index.php");
?>