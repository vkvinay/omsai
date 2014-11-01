<?php 
	session_start();

	if(isset($_SESSION['loggeduserid']) && (time()-$_SESSION['last_activity'])<1200){
		$_SESSION['last_activity'] = time();
			
		$userid = $_SESSION['loggeduserid'];
		
		include_once('modal/userdao.php');
		
		$dao = new UserDAO();
		$user = $dao->findUser($userid);
?>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Donation slip</title>

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
					<div class="col50 leftfloat">&nbsp;</div>
					<div class="col700 leftfloat">
						<div class="row">
							USDPCO <br/>
							Some text...
						</div>
						<div class="row">
							Date : <?php echo date('Y-m-d');?>
						</div>
						<div class="row">
							<?php echo $user->name;?><br/>
							<?php echo $user->address;?><br/>
							<?php echo $user->city . ", " . $user->country;?><br/>
							Reference number: 
						</div>
						
						<div class="row">
							Dear <?php echo $user->name;?>
						</div>
						<div class="row">
							USDPCO Group would like to thank you for being our donor and contributing the amount of ($10) .
						</div>
						<div class="row">
							We hereby acknowledge that no goods or services were exchanged against this donation. With your donation, we were able to provide goods or services to the benefiting from the donation.
						</div>
						<div class="row">
							Please retain this record to avail benefits on your contribution as permitted by the law. We sincerely hope, you will also continue to support our initiatives in the near future.
						</div>
						<div class="row">
							Thank you once again
						</div>
						<div class="row">
							With kind regards,<br/>
							USDPCO Group
						</div>
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