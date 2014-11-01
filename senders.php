<?php 
	session_start();

	if(isset($_SESSION['loggeduserid']) && (time()-$_SESSION['last_activity'])<1200){
		$_SESSION['last_activity'] = time();

		$userid = $_SESSION['loggeduserid'];
		
		include_once 'modal/userdao.php';
		include_once 'modal/utility.php';
		
		$dao = new UserDAO();
				
		$dao->disablePendingUsers();
		
		$user = $dao->findUser($userid);
		
		$level = $dao->getCurrentLevel($userid);
		
		$giftavailable = false;

		if(isset($user->leftside) && isset($user->rightside)){
			
			$ar = $dao->getGiftSenders($userid);
	
			if(count($ar)>0){
				
				$giftavailable = false;
				
				for($i=0;$i<count($ar);$i++){
					$obj = $ar[$i];
					
					if($obj->status=='pending'){
						$giftavailable = true;
						break;	
					}						
				}
				
				if(count($ar)<5)
					$giftavailable = true;
			}		
		}
		else
			$giftavailable = false;
?>

					<?php if($giftavailable){?>
				
					<form class="frm">
						
						<div class="row"><span class="blockheader">Receive gift from these person</span></div>
				
						<div class="row" style="background-color: black; color: white; font-weight: bold; padding: 4px;">						
							<div class="col50 leftfloat">&nbsp;</div>
							<div class="col75 leftfloat centeralign">User ID</div>
							<div class="col200 leftfloat">Name</div>
							<div class="col75 leftfloat">Gender</div>
							<div class="col150 leftfloat">Contact Number</div>
							<div class="col50 leftfloat">Level</div>
							<div class="clear"></div>
						</div>
						
						<?php 
							for($i=0;$i<count($ar);$i++){
								$obj = $ar[$i];
								
								$transactionid = $obj->transactionid;
								$id = $obj->senderid;
								
								$user = $dao->findUser($id);
						?>
							
						<div class="row">
							<div class="col50 leftfloat">&nbsp;</div>
							<div class="col75 leftfloat" style="text-align: center;"><?php echo $user->userid;?></div>
							<div class="col200 leftfloat"><?php echo $user->name;?></div>
							<div class="col75 leftfloat"><?php echo $user->sex;?></div>
							<div class="col150 leftfloat"><?php echo $user->contact_number;?></div>
							<div class="col50 leftfloat"><?php echo $obj->level+1;?></div>
							<?php if($obj->status=='pending'){?>
							<div class="col50 leftfloat"><span class="approve lnk" transactionid="<?php echo $transactionid;?>" userid="<?php echo $user->userid;?>">Approve</span></div>							
							<?php }else{ echo "Approved";}?>
							<div class="clear"></div>
						</div>

						<?php } ?>
						
					</form>				
					
					<?php } else { ?>

						<div class="row"><span class="blockheader">You will receive the gift soon...</span></div>
					
					<?php } ?>

<?php } else { echo "notlogged"; }?>					