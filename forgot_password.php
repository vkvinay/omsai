<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Password retrieval</title>

<!-- Stylesheet -->
<link rel="stylesheet" type="text/css" media="all" href="css/common.css">
<link rel="stylesheet" type="text/css" media="all" href="css/style.css">
<link rel="stylesheet" type="text/css" media="all" href="css/sf_menu.css">

<!-- Javascripts -->
<script type="text/javascript" src="scripts/jquery.min.js"></script>
<script type="text/javascript" src="scripts/common.js"></script>
<script type="text/javascript" src="scripts/forgotpassword.js"></script>
<script type="text/javascript" src="scripts/jquery.easing.js"></script>
<script type="text/javascript" src="scripts/superfish.js"></script>
<script type="text/javascript" src="scripts/hoverIntent.js"></script>
<script type="text/javascript" src="scripts/jquery.tools.min.js"></script>
<script type="text/javascript" src="scripts/jquery.mobilemenu.js"></script>

</head>
<body>

<?php include("top.php"); ?>

<!-- .topbar -->
<?php include('topbar.php'); ?>

<?php include("logomenu.php"); ?>
			
			<div class="middlecontent">
				<br/><br/>
				<div class="registerform">
					<form class="frm">
						
						<div class="row">
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col150 leftfloat columnlabelbold">Email</div>
							<div class="col350 leftfloat">
								<input type="text" name="email" class="txtnorm txt250" placeholder="Your valid email id"/>
							</div>
							<div class="message emailmessage col300 leftfloat">&nbsp;</div>
							<div class="clear"></div>
						</div>
						
						<div>
							<div class="col100 leftfloat">&nbsp;</div>
							<div class="col150 leftfloat columnlabelbold">&nbsp;</div>
							<div class="col300 leftfloat">
							<input type="button" value=" Reset password " name="btnsubmit" /> <span
								id="cont"></span><br/><br/>
							</div>
							<div class="clear"></div>
						</div>
		
					</form>				
				</div>
									
			</div>
			
<?php include("bottom.php"); ?>