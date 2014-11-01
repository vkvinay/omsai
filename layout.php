<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your title here</title>

<!-- Stylesheet -->
<link rel="stylesheet" type="text/css" media="all" href="css/common.css">
<link rel="stylesheet" type="text/css" media="all" href="css/style.css">
<link rel="stylesheet" type="text/css" media="all" href="css/sf_menu.css">
<link rel="stylesheet" type="text/css" media="all" href="css/screen.css">
<link rel="stylesheet" type="text/css" media="screen" href="css/flexslider.css">
<link rel="stylesheet" type="text/css" media="all" href="css/jquery.lightbox.css">

<!-- Javascripts -->
<script type="text/javascript" src="scripts/jquery.min.js"></script>
<script type="text/javascript" src="scripts/jquery.easing.js"></script>
<script type="text/javascript" src="scripts/superfish.js"></script>
<script type="text/javascript" src="scripts/hoverIntent.js"></script>
<script type="text/javascript" src="scripts/jquery.tools.min.js"></script>
<script type="text/javascript" src="scripts/jquery.preloadify.min.js"></script>
<script type="text/javascript" src="scripts/jquery.mobilemenu.js"></script>
<script type="text/javascript" src="scripts/jquery.lightbox.js?ver=3.3.1"></script>
<script type="text/javascript" src="scripts/sys_custom.js"></script>
<script type="text/javascript" src="scripts/general.js"></script>
</head>
<body>
	<div id="boxed" class="fullwidth">
		<div id="wrapper">
			<section id="topbar">
				<div class="inner">
					<div class="topleft">
						<ul class="links">
							<li><a href="index.php">Home</a></li>
							<!-- <li><a href="content_page.php?page=Help">Help</a></li>-->
							<li><a href="registration.php">Join Now</a></li>
							<li><a href="forgot_password.php">Forgot Password?</a></li>
						</ul>
					</div>
					<!-- .topleft -->
					<div class="topright">
						<form id="form2" name="form2" method="post" style="margin: 0px;"
							action="login_func.php"
							enctype="application/x-www-form-urlencoded"
							onsubmit="return validateForm(this,0,0,0,1,8);">
							<div class="field">
								<input name="username" type="text" alt="blank"
									emsg="Please enter your username">

							</div>
							<div class="field">
								<input name="password" type="password" alt="blank"
									emsg="Please enter your password">
							</div>
							<div class="field">
								<button type="submit" class="button small blue" value="Submit">
									<span>Login</span>
								</button>
							</div>
						</form>
					</div>
				</div>
			</section>
			<!-- .topbar -->
			<header id="header">
				<div class="inner">
					<div class="logo">
						<a href="index1.php"><img src="images/logo.png" alt="logo"
							width="180"></a>
					</div>
					<!-- logo -->
					<div class="menu">
						<ul class="sf-menu sf-js-enabled">
							<li><a href="index.php">Home</a></li>
							<li><a href="content_page.php?page=about_us">About Us</a></li>
							<li><a href="#">How to Help</a>
								<ul class="sub-menu" style="display: none; visibility: hidden;">
									<li><a href="content_page.php?page=how_to_help_aus">OM SAI</a></li>
									<li><a href="content_page.php?page=how_to_help_ind">OM SAI India</a></li>
									<li><a href="content_page.php?page=htn_sms_promotion">OM SAI SMS
											Promotion</a></li>
								</ul></li>
							<li><a href="content_page.php?page=donate">Donate</a></li>
							<li><a href="news.php">News</a></li>
							<li><a href="contact_us.php">Contact Us</a></li>
						</ul>
						<!-- end:sf-menu -->
					</div>
					<!-- menu -->
				</div>
			</header>
			
			<div class="middlecontent">
				Write here...				
			</div>
			
			<footer id="footer">
				<div class="inner" style="float: left;">
					<ul
						style="float: right; vertical-align: top; margin-top: 0px; list-style: none;">
						<li
							style="float: left; vertical-align: top; margin-left: 15px; margin-right: 15px;"><a
							href="index.php">Home</a></li>
						<li
							style="float: left; vertical-align: top; margin-left: 15px; margin-right: 15px;"><a
							href="content_page.php?page=about_us">About Us</a></li>
						<li
							style="float: left; vertical-align: top; margin-left: 15px; margin-right: 15px;"><a
							href="news.php">News</a></li>

						<li
							style="float: left; vertical-align: top; margin-left: 15px; margin-right: 15px;"><a
							href="contact_us.php">Contact Us</a></li>
					</ul>
					<p>&nbsp;&nbsp;&nbsp;&nbsp;�2012. OM SAI All Rights Reserved.</p>
					<div>
						<!-- .inner -->
					</div>
				</div>
			</footer>
			<!-- .footer -->
		</div>
		<!-- .wrapper -->
	</div>
</body>
</html>