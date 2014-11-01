<?php 
	session_start();

	if(isset($_SESSION['loggeduseremail'])){
		
		$name = $_SESSION['loggedusername'];
		$userid = $_SESSION['loggeduserid'];
		
		include("modal/userdao.php");
		
		$dao = new UserDAO();
		$user = $dao->findUser($userid);
		
		$dao->ar = array();
		$dao->arcount = -1;
		
		if(isset($user->leftside)){
			$dao->getDownlineList($user->leftside);
			$ar_left = $dao->ar;
		}

		$dao->ar = array();
		$dao->arcount = -1;
		
		if(isset($user->rightside)){
			$dao->getDownlineList($user->rightside);
			$ar_right = $dao->ar;
		}
?>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Downline Tree</title>

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
					<div class="col100 leftfloat">&nbsp;</div>
					<div class="leftfloat">
					<div style="background-color: black; color: white; font-weight: bold; padding: 5px;">
						<div class="col50 leftfloat">S. No.</div>
						<div class="col250 leftfloat">Name</div>				
						<div class="col100 leftfloat">User ID</div>
						<div class="col150 leftfloat">Join Date</div>
						<div class="col50 leftfloat">Status</div>
						<div class="clear"></div>
					</div>
					</div>
					<div class="clear"></div>
					
					<?php 
						$x = 0;
						if(isset($user->leftside)){
							$temp_user = $dao->findUser($user->leftside);
							++$x;
					?>
					<div class="col100 leftfloat">&nbsp;</div>
					<div class="leftfloat">					
					<div style="background-color: rgb(128,255,255); color: black; padding: 5px;">
						<div class="col50 leftfloat"><?php echo 1;?>.</div>
						<div class="col250 leftfloat"><?php echo $temp_user->name;?></div>				
						<div class="col100 leftfloat"><?php echo $temp_user->userid;?></div>
						<div class="col150 leftfloat"><?php echo $temp_user->joindate;?></div>
						<div class="col50 leftfloat"><?php echo $temp_user->status;?></div>
						<div class="clear"></div>
					</div>
					</div>
					<div class="clear"></div>
					
					<?php 
						}
					?>
					<?php 
						if(isset($ar_left) && count($ar_left)>0){
					?>
					
						<div class="col100 leftfloat" style="font-weight: bold; font-size: 24px; vertical-align: top;">
							LEFT
						</div>					
						<div class="leftfloat">
					<?php 
							for($i=0;$i<count($ar_left);$i++){						
								$id = $ar_left[$i];
								
								$temp_user = $dao->findUser($id); 
					?>
					<div style="background-color: rgb(128,255,255); color: black; padding: 5px;">
						<div class="col50 leftfloat"><?php echo $i+$x+1;?>.</div>
						<div class="col250 leftfloat"><?php echo $temp_user->name;?></div>				
						<div class="col100 leftfloat"><?php echo $temp_user->userid;?></div>
						<div class="col150 leftfloat"><?php echo $temp_user->joindate;?></div>
						<div class="col50 leftfloat"><?php echo $temp_user->status;?></div>
						<div class="clear"></div>
					</div>
					<?php 
							}
					?>
					
						</div>
						<div class="clear"></div>
					<?php 
						}
					?>
					
					<div class="row">&nbsp;</div>
					
					<?php 
						$x = 0;
						if(isset($user->rightside)){
							$temp_user = $dao->findUser($user->rightside);
							++$x;
					?>
					<div class="col100 leftfloat">&nbsp;</div>
					<div class="leftfloat">					
					<div style="background-color: rgb(128,255,255); color: black; padding: 5px;">
						<div class="col50 leftfloat">1.</div>
						<div class="col250 leftfloat"><?php echo $temp_user->name;?></div>				
						<div class="col100 leftfloat"><?php echo $temp_user->userid;?></div>
						<div class="col150 leftfloat"><?php echo $temp_user->joindate;?></div>
						<div class="col50 leftfloat"><?php echo $temp_user->status;?></div>
						<div class="clear"></div>
					</div>
					</div>
					<div class="clear"></div>
					<?php 
						}
					?>
					
					<?php 
					
						if(isset($ar_right) && count($ar_right)>0){
					?>
					<div class="col100 leftfloat" style="font-weight: bold; font-size: 24px;">
						RIGHT
					</div>
					<div class="leftfloat">					
					
					<?php 
							for($i=0;$i<count($ar_right);$i++){
								$id = $ar_right[$i];
								$temp_user = $dao->findUser($id); 
					?>
					<div style="background-color: rgb(128,255,255); color: black; padding: 5px;">
						<div class="col50 leftfloat"><?php echo $i+$x+1;?>.</div>
						<div class="col250 leftfloat"><?php echo $temp_user->name;?></div>				
						<div class="col100 leftfloat"><?php echo $temp_user->userid;?></div>
						<div class="col150 leftfloat"><?php echo $temp_user->joindate;?></div>
						<div class="col50 leftfloat"><?php echo $temp_user->status;?></div>
						<div class="clear"></div>
					</div>
					<?php 
							}
					?>
					
						</div>
						<div class="clear"></div>
					<?php 
						}
					?>
															
					<br/><br/>
				</div>
				
			</div>
			
<?php include("bottom.php"); ?>

<?php 
	}
	else
		header("location: index.php");
?>