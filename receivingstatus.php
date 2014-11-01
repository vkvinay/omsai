<?php
include_once 'modal/admindao.php';
include_once 'modal/userdao.php';

if (isset ( $_REQUEST ['level'] )) {
	
	$level = $_REQUEST ['level'];
	
	$found = true;
	
	$dao = new AdminDAO ();
	$udao = new UserDAO ();
	
	$ar = $dao->getLevelReceivers ( $level );
} else
	$found = false;
?>

<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Send Gift List</title>

<style type="text/css">
.blockheader {
	margin-left: 50px;
	font-family: font-family :     'CartoGothicStdBook', Arial, Helvetica,
		sans-serif;
	font-weight: bold;
	font-size: 18px;
}
</style>
<link rel="stylesheet" type="text/css" media="all"
	href="css/downtree.css">

<?php include("commonresources.php");?>

</head>
<body>

<?php include("top.php"); ?>


			
			<div class="middlecontent">
		<br /> <br />

		<div class="downtree">
				<?php if(isset($ar) && count($ar)>0){ ?>
				
				<h3>Level = <?php echo $level; ?></h3>

			<div
				style="background-color: black; color: white; font-weight: bold; padding: 5px;">
				<div class="col75 leftfloat">S. No.</div>
				<div class="col100 leftfloat">User ID</div>
				<div class="col250 leftfloat">Name</div>
				<div class="col100 leftfloat">Child</div>
				<div class="col100 leftfloat">Entry</div>
				<div class="col100 leftfloat">Child</div>
				<div class="clear"></div>
			</div>

			<?php
					$total = 0;
					for($i = 0; $i < count ( $ar ); $i ++) {
						
						if ($i % 2 == 0)
							$style = "style='background-color: rgb(128,255,255); color: black; padding: 5px;'";
						else
							$style = "style='background-color: white; color: black; padding: 5px;'";
						
						$userid = $ar [$i];
						$user = $dao->findUser ( $userid );
												
						$leftsideid = $user->leftside;
						$rightsideid = $user->rightside;
						
						$left_count = 0;
						$right_count = 0;
						
						if(isset($leftsideid))
							$left_count++;
						
						if(isset($rightsideid))
							$right_count++;
						
						$udao->totalcount = 0;
						
						if(isset($leftsideid)){
							$udao->getChildCount($leftsideid);
							$left_count += $udao->totalcount;
						}						
						
						$udao->totalcount = 0;
						
						if(isset($rightsideid)){
							$udao->getChildCount($rightsideid);
							$right_count += $udao->totalcount;
						}
						
						$level_info = $udao->getLevelInfo ( $userid, $level );
						
						if (! isset ( $ob->confirmdate ))
							$confirmdate = "n/a";
						else
							$confirmdate = $ob->confirmdate;
						
			?>
			<div class="row" <?php echo $style;?>>
				<div class="col75 leftfloat"><?php echo $i+1;?>.</div>
				<div class="col100 leftfloat"><?php echo $userid;?>&nbsp;</div>
				<div class="col250 leftfloat"><?php echo $user->name;?>&nbsp;</div>
				<div class="col100 leftfloat"><?php echo $level_info->childcount;?></div>
				<div class="col100 leftfloat"><?php echo $level_info->entrycount;?>&nbsp;</div>
				<div class="col100 leftfloat"><?php echo "$left_count + $right_count";?>&nbsp;</div>
				<div class="clear"></div>
			</div>
					<?php }?>

			<br /> <br />
					<?php } else { echo "No entries...<br/><br/>"; } ?>
				</div>
	</div>
			
			
<?php include("bottom.php"); ?>
