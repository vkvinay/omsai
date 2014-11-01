<?php
	session_start();

	if(isset($_SESSION['loggeduserid']) && (time()-$_SESSION['last_activity'])<1200){
		$_SESSION['last_activity'] = time();
		
		$userid = $_REQUEST['userid'];
		
		$starting = false;
		if($_REQUEST['userid']==$_SESSION['loggeduserid'])
			$starting = true;
		
		include_once 'modal/userdao.php';
		
		$dao = new UserDAO();
		$user = $dao->findUser($userid);
		
		if(isset($user->sponsorid))
			$sponsorid = $user->sponsorid;
		else
			$sponsorid = "";
		
		$lev0_name = $user->name;
		$lev0_id = $user->userid;
		$lev0_popper = "popper";
		$lev0_icon = "user_" . $user->sex;
		$lev0_enabled = $user->status;
		
		$lev1_1_id = "";
		$lev1_1_name = "Empty";
		$lev1_1_popper = "";
		$lev1_1_icon = "blank";
		$lev1_1_enabled = "disabled";
		
		$lev1_2_id = "";
		$lev1_2_name = "Empty";
		$lev1_2_popper = "";
		$lev1_2_icon = "blank";
		$lev1_2_enabled = "disabled";
		
		$lev2_1_id = "";
		$lev2_1_name = "Empty";
		$lev2_1_popper = "";
		$lev2_1_icon = "blank";
		$lev2_1_enabled = "disabled";
		
		$lev2_2_id = "";
		$lev2_2_name = "Empty";	
		$lev2_2_popper = "";
		$lev2_2_icon = "blank";
		$lev2_2_enabled = "disabled";
		
		$lev2_3_id = "";
		$lev2_3_name = "Empty";	
		$lev2_3_popper = "";
		$lev2_3_icon = "blank";
		$lev2_3_enabled = "disabled";
		
		$lev2_4_id = "";
		$lev2_4_name = "Empty";
		$lev2_4_popper = "";
		$lev2_4_icon = "blank";
		$lev2_4_enabled = "disabled";
		
		if(isset($user->leftside)){
			
			$l1_1_user = $dao->findUser($user->leftside);
			
			$lev1_1_id = $l1_1_user->userid;
			$lev1_1_name = $l1_1_user->name;
			$lev1_1_popper = "popper";
	
			if($l1_1_user->status=="active")		
				$lev1_1_icon = "user_" . $l1_1_user->sex;
			else if($l1_1_user->status=="disabled")
				$lev1_1_icon = "disabled";
			else
				$lev1_1_icon = "pending";
			
			$lev1_1_enabled = $l1_1_user->status;		
			
			if(isset($l1_1_user->leftside)){
				
				$l2_1_user = $dao->findUser($l1_1_user->leftside);
				
				$lev2_1_id = $l2_1_user->userid;
				$lev2_1_name = $l2_1_user->name;
				$lev2_1_popper = "popper";
				
				if($l2_1_user->status=="active")		
					$lev2_1_icon = "user_" . $l1_1_user->sex;
				else if($l2_1_user->status=="disabled")
					$lev2_1_icon = "disabled";
				else
					$lev2_1_icon = "pending";
							
				$lev2_1_enabled = $l2_1_user->status;		
			}
				
			if(isset($l1_1_user->rightside)){
				
				$l2_2_user = $dao->findUser($l1_1_user->rightside);
					
				$lev2_2_id = $l2_2_user->userid;
				$lev2_2_name = $l2_2_user->name;
				$lev2_2_popper = "popper";
				
				if($l2_2_user->status=="active")		
					$lev2_2_icon = "user_" . $l1_1_user->sex;
				else if($l2_2_user->status=="disabled")
					$lev2_2_icon = "disabled";
				else
					$lev2_2_icon = "pending";
							
				$lev2_2_enabled = $l2_2_user->status;		
			}
		}
	
		if(isset($user->rightside)){
			
			$l1_2_user = $dao->findUser($user->rightside);
			
			$lev1_2_id = $l1_2_user->userid;
			$lev1_2_name = $l1_2_user->name;
			$lev1_2_popper = "popper";
			
			if($l1_2_user->status=="active")		
				$lev1_2_icon = "user_" . $l1_2_user->sex;
			else if($l1_2_user->status=="disabled")
				$lev1_2_icon = "disabled";
			else
				$lev1_2_icon = "pending";
	
			$lev1_2_enabled = $l1_2_user->status;
			
			if(isset($l1_2_user->leftside)){
					
				$l2_3_user = $dao->findUser($l1_2_user->leftside);
					
				$lev2_3_id = $l2_3_user->userid;
				$lev2_3_name = $l2_3_user->name;
				$lev2_3_popper = "popper";
				
				if($l2_3_user->status=="active")		
					$lev2_3_icon = "user_" . $l2_3_user->sex;
				else if($l2_3_user->status=="disabled")
					$lev2_3_icon = "disabled";
				else
					$lev2_3_icon = "pending";
		
				$lev2_3_enabled = $l2_3_user->status;				
			}
				
			if(isset($l1_2_user->rightside)){
					
				$l2_4_user = $dao->findUser($l1_2_user->rightside);
			
				$lev2_4_id = $l2_4_user->userid;
				$lev2_4_name = $l2_4_user->name;
				$lev2_4_popper = "popper";		
				
				if($l2_4_user->status=="active")		
					$lev2_4_icon = "user_" . $l2_4_user->sex;
				else if($l2_4_user->status=="disabled")
					$lev2_4_icon = "disabled";
				else
					$lev2_4_icon = "pending";
							
				$lev2_4_enabled = $l2_4_user->status;				
			}
		}
		
		$ids = array();
		
		$ids[0] = $lev0_id;
		$ids[1] = $lev1_1_id;
		$ids[2] = $lev1_2_id;
		$ids[3] = $lev2_1_id;
		$ids[4] = $lev2_2_id;
		$ids[5] = $lev2_3_id;
		$ids[6] = $lev2_4_id;
		
		if(!($sponsorid=="")){
	?>
	
	<div class="row">
		<?php if($starting===false){?>
			<span rel="<?php echo $sponsorid;?>" class="parent">Parent</span>
		<?php } else { echo "&nbsp;"; } ?>
	</div>
	
	<?php } ?>
	
	<div class="row">
		<div class="col100 leftfloat blanknode">&nbsp;</div>
		<div class="col100 leftfloat blanknode">&nbsp;</div>
		<div class="col100 leftfloat blanknode">&nbsp;</div>
		<div class="col100 leftfloat valuenode">
			<p><?php echo $lev0_name; ?></p>
			<img src="images/<?php echo $lev0_icon;?>.png" class="<?php echo $lev0_enabled;?> <?php echo $lev0_popper;?>" data-popbox="pop1" rel="<?php echo $lev0_id;?>"/>
		</div>
		<div class="col100 leftfloat blanknode">&nbsp;</div>
		<div class="col100 leftfloat blanknode">&nbsp;</div>
		<div class="col100 leftfloat blanknode">&nbsp;</div>
		<div class="clear"></div>
	</div>
	
	<div class="row">
		<div class="col100 leftfloat blanknode">&nbsp;</div>
		<div class="col100 leftfloat blanknode"><div class="leftbordernode">&nbsp;</div></div>
		<div class="col100 leftfloat blanknode topbordernode">&nbsp;</div>
		<div class="col100 leftfloat blanknode topbordernode">&nbsp;</div>
		<div class="col100 leftfloat blanknode topbordernode">&nbsp;</div>
		<div class="col100 leftfloat blanknode"><div class="rightbordernode">&nbsp;</div></div>
		<div class="col100 leftfloat blanknode">&nbsp;</div>
		<div class="clear"></div>
	</div>
	
	<div class="row">
		<div class="col100 leftfloat blanknode">&nbsp;</div>
		<div class="col100 leftfloat valuenode">
			<p><?php echo $lev1_1_name; ?></p>
			<img src="images/<?php echo $lev1_1_icon;?>.png" class="<?php echo $lev1_1_enabled;?> <?php echo $lev1_1_popper;?>"  data-popbox="pop2" rel="<?php echo $lev1_1_id;?>"/>
		</div>
		<div class="col100 leftfloat blanknode">&nbsp;</div>
		<div class="col100 leftfloat blanknode">&nbsp;</div>
		<div class="col100 leftfloat blanknode">&nbsp;</div>
		<div class="col100 leftfloat valuenode">
			<p><?php echo $lev1_2_name; ?></p>
			<img src="images/<?php echo $lev1_2_icon;?>.png" class="<?php echo $lev1_2_enabled;?> <?php echo $lev1_2_popper;?>" data-popbox="pop3" rel="<?php echo $lev1_2_id;?>"/>
		</div>
		<div class="col100 leftfloat blanknode">&nbsp;</div>
		<div class="clear"></div>
	</div>
	
	<div class="row">
		<div class="col100 leftfloat blanknode"><div class="leftbordernode">&nbsp;</div></div>
		<div class="col100 leftfloat blanknode topbordernode">&nbsp;</div>
		<div class="col100 leftfloat blanknode"><div class="rightbordernode">&nbsp;</div></div>
		<div class="col100 leftfloat blanknode">&nbsp;</div>
		<div class="col100 leftfloat blanknode"><div class="leftbordernode">&nbsp;</div></div>
		<div class="col100 leftfloat blanknode topbordernode">&nbsp;</div>
		<div class="col100 leftfloat blanknode"><div class="rightbordernode">&nbsp;</div></div>
		<div class="clear"></div>
	</div>
	
	<div class="row">
		<div class="col100 leftfloat valuenode">
			<p><?php echo $lev2_1_name; ?></p>
			<img src="images/<?php echo $lev2_1_icon;?>.png" class="<?php echo $lev2_1_enabled;?> <?php echo $lev2_1_popper;?>" data-popbox="pop4" rel="<?php echo $lev2_1_id;?>"/>
		</div>
		<div class="col100 leftfloat blanknode">&nbsp;</div>
		<div class="col100 leftfloat valuenode">
			<p><?php echo $lev2_2_name; ?></p>
			<img src="images/<?php echo $lev2_2_icon;?>.png" class="<?php echo $lev2_2_enabled;?> <?php echo $lev2_2_popper;?>" data-popbox="pop5" rel="<?php echo $lev2_2_id;?>"/>
		</div>
		<div class="col100 leftfloat blanknode">&nbsp;</div>
		<div class="col100 leftfloat valuenode">
			<p><?php echo $lev2_3_name; ?></p>
			<img src="images/<?php echo $lev2_3_icon;?>.png" class="<?php echo $lev2_3_enabled;?> <?php echo $lev2_3_popper;?>" data-popbox="pop6" rel="<?php echo $lev2_3_id;?>"/>
		</div>
		<div class="col100 leftfloat blanknode">&nbsp;</div>
		<div class="col100 leftfloat valuenode">
			<p><?php echo $lev2_4_name; ?></p>
			<img src="images/<?php echo $lev2_4_icon;?>.png" class="<?php echo $lev2_4_enabled;?> <?php echo $lev2_4_popper;?>" data-popbox="pop7" rel="<?php echo $lev2_4_id;?>"/>
		</div>
		<div class="clear"></div>
	</div>
	
	<?php
		for($i=1;$i<=7;$i++){
			$id = $ids[$i-1];
	
			if($id=="")
				continue;
			
			$user = $dao->findUser($id);
			
			$classname = "";
			
			if(isset($user->sponsorid)){
				$classname = "popbox";
	?>
	
		<div id="pop<?php echo $i;?>" class="<?php echo $classname; ?>">
			<div class="row">
				<div class="poplabel">Name</div>
				<div class="popgap">:</div>
				<div class="popdata"><?php echo $user->name;?></div>
				<div class="popgap">&nbsp;</div>
				<div class="poplabel">ID</div>
				<div class="popgap">:</div>
				<div class="popdata"><?php echo $user->userid;?></div>
				<div class="clear"></div>
			</div>
			<div class="row">
				<div class="poplabel">Email</div>
				<div class="popgap">:</div>
				<div class="popdata"><?php echo $user->email;?></div>
				<div class="popgap">&nbsp;</div>
				<div class="poplabel">Sponsor ID</div>
				<div class="popgap">:</div>
				<div class="popdata"><?php echo $user->sponsorid;?></div>
				<div class="clear"></div>
			</div>
			<div class="row">
				<div class="poplabel">Join Date</div>
				<div class="popgap">:</div>
				<div class="popdata"><?php echo $user->joindate;?></div>
				<div class="popgap">&nbsp;</div>
				<div class="poplabel">Contact</div>
				<div class="popgap">:</div>
				<div class="popdata"><?php echo $user->contact_number;?></div>
				<div class="clear"></div>
			</div>
		</div>
	
<?php 
			}
		}
	}
	else
		echo "notlogged";
?>