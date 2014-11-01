<!-- 
<div id="pop1" class="popbox">
    <h2>ID = <?php echo $lev1_1_id;?></h2>
    <p>This is an example popbox.</p>
</div>	
<div id="pop2" class="popbox">
    <h2>ID = <?php echo $lev1_1_id;?></h2>
    <p>This is an example popbox.</p>
</div>	
<div id="pop3" class="popbox">
    <h2>ID = <?php echo $lev1_1_id;?></h2>
    <p>This is an example popbox.</p>
</div>	
<div id="pop4" class="popbox">
    <h2>ID = <?php echo $lev1_1_id;?></h2>
    <p>This is an example popbox.</p>
</div>	
<div id="pop5" class="popbox">
    <h2>ID = <?php echo $lev1_1_id;?></h2>
    <p>This is an example popbox.</p>
</div>	
<div id="pop6" class="popbox">
    <h2>ID = <?php echo $lev1_1_id;?></h2>
    <p>This is an example popbox.</p>
</div>	
<div id="pop7" class="popbox">
    <h2>ID = <?php echo $lev1_1_id;?></h2>
    <p>This is an example popbox.</p>
</div>	
-->
<?php
	for($i=1;$i<=7;$i++){
		$id = $ids[$i-1];
		
		$user = $dao->findUser($id);
?>

	<div id="pop<?php echo $i;?>" class="popbox">
	
	</div>

<?php 
	}
?>