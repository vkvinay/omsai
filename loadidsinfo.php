<?php
session_start ();

if (isset ( $_SESSION ['loggedadminid'] ) && (time () - $_SESSION ['last_activity']) < 1200) {
	$_SESSION ['last_activity'] = time ();
	
	include_once 'modal/userdao.php';
	include_once 'modal/utility.php';
	include_once 'modal/identrydao.php';
	
	$startdate = $_REQUEST ['startdate'];
	$enddate = $_REQUEST ['enddate'];
	
	$dao = new IDEntryDAO();
	$udao = new UserDAO();
	
	$ar = $dao->getUsers($startdate, $enddate);
?>

<br />
<br />
<h2>ID entry information</h2>

<?php
	if(isset($ar) && count($ar)>0){ 
?>
<div
	style="background-color: black; color: white; font-weight: bold; padding: 5px;">
	<div class="col50 leftfloat">S. No.</div>
	<div class="col50 leftfloat">ID</div>
	<div class="col150 leftfloat">Name</div>
	<div class="col150 leftfloat">Phone</div>
	<div class="col50 leftfloat">S.ID</div>
	<div class="col150 leftfloat">Sponsorer Name</div>
	<div class="clear"></div>
</div>

<?php
		$total = 0;
		for($i = 0; $i < count ( $ar ); $i ++) {
			
			if ($i % 2 == 0)
				$style = "style='background-color: rgb(128,255,255); color: black; padding: 5px;'";
			else
				$style = "style='background-color: white; color: black; padding: 5px;'";
			
			$ob = $ar [$i];
			
			$udao = new UserDAO();
			
			$sponsorer = $udao->findUser($ob->sponsorid);
			
			$total = $total + 1;
?>

<div class="row" <?php echo $style;?>>
	<div class="col50 leftfloat"><?php echo $i+1;?>.</div>
	<div class="col50 leftfloat"><?php echo $ob->userid;?></div>
	<div class="col150 leftfloat"><?php echo $ob->name;?>&nbsp;</div>
	<div class="col150 leftfloat"><?php echo $ob->contact_number;?></div>
	<div class="col50 leftfloat"><?php echo $sponsorer->userid;?></div>
	<div class="col150 leftfloat"><?php echo $sponsorer->name;?></div>
		<div class="clear"></div>
</div>
<?php }?>
<div class="row"
	style='background-color: white; color: black; padding: 5px;'>
	<div class="col100 leftfloat" style="text-align: right">Total = &nbsp;</div>
	<div class="col100 leftfloat"><?php echo $total;?></div>
	<div class="clear"></div>
</div>

<br />
<br />
<?php } else { echo "No ids added...<br/><br/>"; } ?>

<?php
} else
	echo "notlogged";
?>