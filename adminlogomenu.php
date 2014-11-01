<?php if(isset($_SESSION['loggedadminid'])){?>

<div>
<table cellpadding="0" cellspacing="0" border="0" width="100%"  >
  <tr>
    <td bgcolor="#FFFF66"><div class="menu" >
        <ul class="sf-menu">
          <li><a href="adminsection.php" class="whitelink">Home</a></li>
          <li><a href="paymentstatus.php" class="whitelink">Payment Status</a></li>
          <li><a href="newids.php" class="whitelink">New Ids</a></li>
          <li><a href="#">Update Account</a>
            <ul class="sub-menu" style="display: block; visibility: hidden; ">
              <li><a href="changeadminpassword.php">Change Password</a></li>
            </ul>
          </li>
          <li><a href="adminewalletpassword.php" class="whitelink">E-Wallet</a></li>
        </ul>
       
      </div></td>
  <tr>
</table>
</div>

<?php } ?>