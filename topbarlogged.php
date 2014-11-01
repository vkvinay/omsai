<?php $name = $_SESSION['loggedusername']; ?>
<section id="topbar">
	<div class="inner">
		<div class="topleft">
		</div>
		<!-- .topleft -->
		<div class="topright" style="text-align: right">
			Welcome : <?php echo $name; ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="logout.php" style="color:blue">Logout</a>&nbsp;&nbsp;
		</div>
    </div>
</section>