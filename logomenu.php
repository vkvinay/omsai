<header id="header">
	<div class="inner">
		<div class="logo">
			<a href="index1.php"><img src="img/Om_logo.JPG" alt="logo"
				width="180"></a>
		</div>

		<?php if(!isset($_SESSION['loggeduserid'])){?>
		<!-- logo -->
		<div class="menu">
			<ul class="sf-menu sf-js-enabled">
				<li><a href="index.php">Home</a></li>
				<li><a href="aboutus.php">About Us</a></li>
				<li><a href="donationslip.php">Donate</a></li>
				<li><a href="news.php">News</a></li>
				<li><a href="contactus.php">Contact Us</a></li>
			</ul>
			<!-- end:sf-menu -->
		</div>
		<?php } ?>		
	</div>
</header>

<?php if(isset($_SESSION['loggeduserid'])){?>

<br/>
<div>
<table cellpadding="0" cellspacing="0" border="0" width="100%"  >
  <tr>
    <td bgcolor="#FFFF66"><div class="menu" >
        <ul class="sf-menu">
          <li><a href="usersection.php" class="whitelink">Home</a></li>
          <li><a href="#">Update Account</a>
            <ul class="sub-menu" style="display: block; visibility: hidden; ">
              <li><a href="editprofile.php">Update Profile</a></li>
              <li><a href="changepassword.php">Change Password</a></li>
              <li><a href="changetransactionpassword.php">Change Transaction Password </a></li>
            </ul>
          </li>
          <li> <a href="#">My&nbsp;&nbsp;Team</a>
            <ul class="sub-menu" style="display: block; visibility: hidden; ">
              <li><a href="registration.php">New Member</a></li>
              <li><a href="downtree.php">Downline Tree</a></li>
<!--              <li><a href="direct_list.php">Direct List</a></li>-->
            </ul>
          </li>
<!--		   <li> <a href="#">My Gift List</a>-->
<!--            <ul class="sub-menu" style="display: block; visibility: hidden; ">-->
<!--              <li><a href="giftsend.php">Send Gift </a></li>-->
<!--              <li><a href="giftsendlist.php">Sent Gift List</a></li>-->
<!--			  <li><a href="receivegift.php">Receive Gift</a></li>-->
<!--			  <li><a href="giftreceivedlist.php">Received Gift List</a></li>-->
<!--             </ul>-->
<!--          </li>-->
          <li> <a href="#">My Income</a>
            <ul class="sub-menu" style="display: block; visibility: hidden; ">
              <li><a href="userewallet.php">E-Wallet</a></li>
              <li><a href="directincome.php">Direct Income</a></li> 
              <li><a href="binaryincome.php" >Binary Income</a></li>
<!--			   <li><a href="my_reward.php">My Reward</a></li> -->
              <!-- <li><a href="my_incentive_list.php">Transaction Details</a> </li> -->
            </ul>
          </li>
          <!-- 
		   <li><a href="#">E-Wallet</a>
				 <ul class="sub-menu" style="display: block; visibility: hidden; ">  
				 <li  ><a href="my_ewallet_details.php?pay_plan=FUND_RECEIVE">Fund Receive Details</a> </li>
                  <li  ><a href="my_ewallet_details.php?pay_plan=FUND_TRANSFER" >Fund Trasfered Details</a></li>
                  <li  ><a href="my_ewallet_details.php?pay_plan=WELTH_PIN">Purchased Topup Details</a></li>
                  <li><a href="ewallet_statement.php">E-Wallet Statement</a></li>  
				   <li><a href="ewallet_summary.php"> E-Wallet Summary</a></li>  
                   <li><a href="my_ewallet_purchase_pin.php">Pin Purchase</a></li>
                   <li><a href="my_ewallet_fund_transfer.php">Fund Transfer To UserID</a></li> 
			    </ul></li> -->
        </ul>
       
      </div></td>
  <tr>
</table>
</div>

<?php } ?>