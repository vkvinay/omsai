<?php
session_start();

if(isset($_SESSION['loggedadminid'])){

	$_SESSION['last_activity'] = time();

	$adminid = $_SESSION['loggedadminid'];

	include_once 'modal/admindao.php';

	$dao = new AdminDAO();

	$ar = $dao->getNewUsers(0,100);
?>
					<?php if(count($ar)>0){?>

<form class="frm">

	<div class="row"
		style="background-color: black; color: white; font-weight: bold; padding: 4px;">
		<div class="col50 leftfloat">&nbsp;</div>
		<div class="col75 leftfloat centeralign">User ID</div>
		<div class="col250 leftfloat">Name</div>
		<div class="col75 leftfloat">Gender</div>
		<div class="col150 leftfloat">Contact Number</div>
		<div class="col150 leftfloat">Join Date</div>
		<div class="clear"></div>
	</div>
						
						<?php 
							for($i=0;$i<count($ar);$i++){
								$ob = $ar[$i];
						?>
							
						<div class="row">
		<div class="col50 leftfloat">&nbsp;</div>
		<div class="col75 leftfloat" style="text-align: center;"><?php echo $ob->userid;?></div>
		<div class="col250 leftfloat"><?php echo $ob->name;?></div>
		<div class="col75 leftfloat"><?php echo $ob->sex;?></div>
		<div class="col150 leftfloat"><?php echo $ob->contact_number;?></div>
		<div class="col150 leftfloat"><?php echo $ob->joindate;?></div>
		<div class="col50 leftfloat">
			<span class="activate lnk" rel="<?php echo $ob->userid;?>">Activate</span>
		</div>
		<div class="clear"></div>
	</div>

						<?php } ?>
						
					</form>

<?php } else { ?>

<div class="row">
	<br/>
	&nbsp;&nbsp;<span class="blockheader">No new requests...</span>
</div>

<?php 
	 } 
	} 
	else { 
		echo "notlogged"; 
	}
?>
