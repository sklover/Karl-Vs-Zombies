<?php
ob_start();
require_once('functions/load_config.php');
require_once('functions/quick_con.php'); 
$config = load_config('settings/config.dat'); 
$id = $_SESSION['id'];
$sql = my_quick_con($config) or die("MySQL problem"); 
$table_v = $config['var_table']; 
$ret = mysql_query("SELECT value FROM $table_v WHERE zkey='reg-open';"); 

$open = mysql_fetch_assoc($ret);
$open = $open['value'];

if($open == 0) {
	mysql_free_result($ret);
	mysql_close($sql); 
	header("Location:reg_closed.php");
}

$ret = mysql_query("SELECT value FROM $table_v WHERE zkey='reg-closed';");
$closed = mysql_fetch_assoc($ret); 
$closed = $closed['value'];
if($closed == 1) {
	mysql_free_result($ret); 
	mysql_close($sql); 
	header("Location:reg_closed.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Humans vs. Zombies :: Source - Register</title>
<style type="text/css">
<!--
body,td,th {
	font-size: 12px;
	color: #000000;
	font-family: Arial, Helvetica, sans-serif;
}
body {
	background-color: #000000;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	color: #FF0000;
}
a:visited {
	color: #990000;
}
.style1 {	color: #FFFFFF;
	font-weight: bold;
}
.style2 {color: #FFFFFF}
.style8 {font-size: 10px}
.style3 {font-size: 10px; color: #FFFFFF; }
.style4 {font-size: 12px}
-->
</style></head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="29" bgcolor="#2E2C2D">&nbsp;</td>
    <td width="900" height="300" rowspan="2" valign="top" bgcolor="#FFFFFF"><table id="Table_01" height="301" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="29" colspan="18" background="images/Top_01.jpg"><div align="right" class="style1">
            <div align="right">
            </div>
            <label>
            <div align="left"></div>
          </label>
        </div></td>
        <td rowspan="8"><img src="images/Top_02.jpg" width="2" height="300" alt="" /></td>
      </tr>
      <tr>
        <td colspan="18"><img src="images/Top_03.jpg" width="898" height="14" alt="" /></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td rowspan="3"><img src="images/Top_04.jpg" width="21" height="210" alt="" /></td>
        <td colspan="8" rowspan="2"><img src="images/Top_05.jpg" width="544" height="195" alt="" /></td>
        <td colspan="9"><img src="images/Top_06.jpg" width="333" height="39" alt="" /></td>
      </tr>
      <tr>
        <td colspan="3" rowspan="2"><img src="images/Top_07.jpg" width="51" height="171" alt="" /></td>
        <td height="156" colspan="5" align="left" valign="top" background="images/Top_08.jpg"><p class="style2"><strong>HvZ Source</strong> is a free hosting service started by the original creators of the <a href="http://www.Humansvszombies.org">Humans vs. Zombies</a> game.</p>
          <p class="style2">This spring, we'll be launching the full version of our game engine. For more info, visit us at the <a href="http://forums.humansvszombies.org">HvZ Forums</a>.</p></td>
        <td rowspan="3"><img src="images/Top_09.jpg" width="57" height="173" alt="" /></td>
      </tr>
      <tr>
        <td colspan="8"><img src="images/Top_10.jpg" width="544" height="15" alt="" /></td>
        <td colspan="5"><img src="images/Top_11.jpg" width="225" height="15" alt="" /></td>
      </tr>
      <tr>
        <td colspan="2" rowspan="2"><a href="index.php"><img src="images/Top_12.jpg" alt="" width="112" height="44" border="0" /></a></td>
        <td rowspan="3"><img src="images/Top_13.jpg" width="1" height="47" alt="" /></td>
        <td rowspan="3"><a href="kill.php"><img src="images/Top_14.jpg" alt="" width="161" height="47" border="0" /></a></td>
        <td rowspan="3"><a href="players.php"><img src="images/Top_15.jpg" alt="" width="113" height="47" border="0" /></a></td>
        <td rowspan="3"><img src="images/Top_16.jpg" width="1" height="47" alt="" /></td>
        <td rowspan="2"><a href="rules.php"><img src="images/Top_17.jpg" alt="" width="113" height="44" border="0" /></a></td>
        <td rowspan="3"><img src="images/Top_18.jpg" width="1" height="47" alt="" /></td>
        <td colspan="2" rowspan="2"><a href="http://www.humansvszombies.org" target="_blank"><img src="images/Top_19.jpg" alt="" width="93" height="44" border="0" /></a></td>
        <td rowspan="3"><img src="images/Top_20.jpg" width="1" height="47" alt="" /></td>
        <td colspan="2" rowspan="2"><a href="http://blog.humansvszombies.org" target="_blank"><img src="images/Top_21.jpg" alt="" width="93" height="44" border="0" /></a></td>
        <td colspan="4"><img src="images/Top_22.jpg" width="152" height="2" alt="" /></td>
      </tr>
      <tr>
        <td rowspan="2"><img src="images/Top_23.jpg" width="1" height="45" alt="" /></td>
        <td><a href="http://wiki.humansvszombies.org" target="_blank"><img src="images/Top_24.jpg" alt="" width="93" height="42" border="0" /></a></td>
        <td rowspan="2"><img src="images/Top_25.jpg" width="1" height="45" alt="" /></td>
        <td colspan="2"><a href="http://forums.humansvszombies.org" target="_blank"><img src="images/Top_26.jpg" alt="" width="114" height="42" border="0" /></a></td>
      </tr>
      <tr>
        <td colspan="2"><img src="images/Top_27.jpg" width="112" height="3" alt="" /></td>
        <td><img src="images/Top_28.jpg" width="113" height="3" alt="" /></td>
        <td colspan="2"><img src="images/Top_29.jpg" width="93" height="3" alt="" /></td>
        <td colspan="2"><img src="images/Top_30.jpg" width="93" height="3" alt="" /></td>
        <td><img src="images/Top_31.jpg" width="93" height="3" alt="" /></td>
        <td colspan="2"><img src="images/Top_32.jpg" width="114" height="3" alt="" /></td>
      </tr>
      <tr>
        <td><img src="images/spacer.gif" width="21" height="1" alt="" /></td>
        <td><img src="images/spacer.gif" width="91" height="1" alt="" /></td>
        <td><img src="images/spacer.gif" width="1" height="1" alt="" /></td>
        <td><img src="images/spacer.gif" width="161" height="1" alt="" /></td>
        <td><img src="images/spacer.gif" width="113" height="1" alt="" /></td>
        <td><img src="images/spacer.gif" width="1" height="1" alt="" /></td>
        <td><img src="images/spacer.gif" width="113" height="1" alt="" /></td>
        <td><img src="images/spacer.gif" width="1" height="1" alt="" /></td>
        <td><img src="images/spacer.gif" width="63" height="1" alt="" /></td>
        <td><img src="images/spacer.gif" width="30" height="1" alt="" /></td>
        <td><img src="images/spacer.gif" width="1" height="1" alt="" /></td>
        <td><img src="images/spacer.gif" width="20" height="1" alt="" /></td>
        <td><img src="images/spacer.gif" width="73" height="1" alt="" /></td>
        <td><img src="images/spacer.gif" width="1" height="1" alt="" /></td>
        <td><img src="images/spacer.gif" width="93" height="1" alt="" /></td>
        <td><img src="images/spacer.gif" width="1" height="1" alt="" /></td>
        <td><img src="images/spacer.gif" width="57" height="1" alt="" /></td>
        <td><img src="images/spacer.gif" width="57" height="1" alt="" /></td>
        <td><img src="images/spacer.gif" width="2" height="1" alt="" /></td>
      </tr>
    </table></td>
    <td height="29" align="left" valign="top" bgcolor="#2E2C2D">&nbsp;</td>
  </tr>
  <tr>
    <td style="background:url(images/LeftBKGRNDImage.jpg) no-repeat right top" bgcolor="#000000">&nbsp;</td>
    <td align="left" style="background:url(images/RightBKGRNDImage.jpg) no-repeat left top" bgcolor="#000000">&nbsp;</td>
  </tr>
  <tr>
    <td style="background:url(images/LeftColumn.jpg) right top repeat-y">&nbsp;</td>
    <td width="900" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="10" cellpadding="10">
      <tr>
        <td valign="top">


<?php
if($_POST['submit'] == 'Register') {
$err = 0; 
$fname = ereg_replace("[^A-Za-z0-9]","",$_POST['firstname']);
$lname = ereg_replace("[^A-Za-z0-9]","",$_POST['lastname']);
$username = ereg_replace("[^A-Za-z0-9]","",$_POST['username']);
$password1 = ereg_replace("[^A-Za-z0-9]","",$_POST['password1']);
$password2 = ereg_replace("[^A-Za-z0-9]","",$_POST['password2']); 
$email_address = ereg_replace("[^A-Za-z0-9@.]","",$_POST['email_address']);

if($_POST['oz_opt'] == 'oz') {
	$oz_opt = 1; 
} else {
	$oz_opt = 0; 
}
print "<table height=100% width=100%><tr><td align=center valign=center>";
if(strlen($fname) > 30) {
$err = 1; 
print "Your first name is too long. Get a new one."; 
}
if(strlen($lname) > 30) {
print "Your last name is too long. Get a new one.";
}
if(strlen($username) < 4) {
print "Username is too short.<br>";
}
if(strlen($username) > 20) {
$err = 1;
print "Username is too long.<br>";
}
if(strlen($password1) < 4) {
$err = 1;
print "Password is too short.<br>";
}
if(strlen($password1) > 20) {
$err = 1;
print "Password is too long.<br>";
}
if($password1 != $password2) {
$err = 1;
print "Passwords do not match.<br>";
}
if($err == 1) {
print "<a href='register.php'>Try again</a>";
} else {
$sql = my_quick_con($config) or die("MySQL problem"); 
$table_u = $config['user_table'];
$password = md5($password1);
$ret = mysql_query("SELECT * FROM $table_u WHERE username='$username';");
if(mysql_num_rows($ret) > 0) {
print "Someone has already registered with that username.<br>"; 
print "<a href='register.php'>Try again</a>";
} else {
	$id = '';
	$ret = mysql_query("SELECT * FROM $table_u WHERE email='$email_address';"); 
	if(mysql_num_rows($ret) > 0) {
		print "Someone has already registered with that email address.<br>"; 
		print "<a href='register.php'>Try again</a>";
	} else {
		$valid_id = 0; 
		$c_list = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		srand(); 

		while($valid_id == 0) {
			$id = '';
			for($i = 0; $i < $config['id_length']; $i++) {
				$n = rand() % 35;
				$id .= substr($c_list, $n, 1); 
			}
			$ret = mysql_query("SELECT * FROM $table_u WHERE id='$id';");
			if(mysql_num_rows($ret) == 0) {
				$valid_id = 1; 
			}
		}
		$ret = mysql_query("INSERT INTO $table_u (id, fname, lname, username, password, email, oz_opt, state, kills) VALUES ('$id','$fname','$lname','$username','$password','$email_address','$oz_opt', 1, 0);");
		print "Registered.<br>";
                print "<a href='index.php'>Home</a><br><br> Your ID is: ";
                print $id; 
                print "<br>Please write it down and cary it with you during the game.  If a zombie tags you, please give them your ID. <br>You can also find your ID in the My Account section of the site.";

		//TWITTER
		// The message you want to send
		$message = $fname . " " . $lname . " has registered for HvZ!";
		include("twitter.php");

		//email player

$header = "From: no-reply@HvZSource.com \r\n";
$body  = "Hi there $fname.\n\n";
$body .= "Thanks for Registering for HvZ.\n\n\n";
$body .= "Your ID nubmer is: $id.  Please write it down and carry it with you at all times.\n\n";
$body .= "You can change your password and find your ID number in your account page, once you login.\n\n";
$body .= "--HvZSource";
mail($email_address, "HvZSource: Registration Confirmation", $body, $header);

	}
}

mysql_close($sql);
}
print "</td></tr></table>";

} else { 
?>

<table height=100% width=100%><tr><td align=center valign=center>
<h3>Registration</h3>
<form method=POST action=<?php echo $PHP_SELF; ?>>
<table>
<tr>
<td>first name:</td>
<td><input type='text' name='firstname' size=20 maxlength=20></td>
</tr>
<tr>
<td>last name:</td>
<td><input type='text' name='lastname' size=20 maxlength=20></td>
</tr>
<tr>
<td>username:</td>
<td><input type='text' name='username' size=20 maxlength=20></td>
</tr>
<tr><td colspan=2 align=center>(between 4 and 20 alphanumerics)</td></tr>
<tr>
<td>password:</td>
<td><input type='password' name='password1' size=20 maxlength=20></td>
</tr>
<tr>
<td>confirm password:</td>
<td><input type='password' name='password2' size=20 maxlength=20></td>
</tr>
<tr>
<td colspan=2 align=center>(between 4 and 20 alphanumerics)</td>
</tr>
<tr>
<td>email address:</td>
<td><input type='text' name='email_address' size=20 maxlength=30></td>
</tr>
<tr>
<td colspan=2 align=center>(up to 30 alphanumerics)</td>
</tr>
<tr>
<td colspan=2 align=center>
<input type='checkbox' name='oz_opt' value='oz'> Put me in the original zombie pool
</td>
</tr>
<tr>
<td colspan=2 align=center>
<input type='submit' name='submit' value='Register'>
<input type='reset' value='Reset' onClick="return confirm('Reset?');">
</td>
</tr>
</table>
</form>
<a href="login.php">Back to login</a>
</td></tr></table>

<?php
}
?>
	</td>
       
      </tr>
    </table>
    </td>
    <td style="background:url(images/RightColumn.jpg) left top repeat-y">&nbsp;</td>
  </tr>
  <tr>
    <td style="background:url(images/RightBottomBKGRNDImage.jpg) no-repeat right top">&nbsp;</td>
    <td width="900"><table id="Table_" width="900" height="130" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="2"><img src="images/Bottom_01.jpg" width="900" height="95" alt="" /></td>
      </tr>
      <tr>
        <td rowspan="2"><img src="images/Bottom_02.jpg" width="549" height="35" alt="" /></td>
        <td height="27" background="images/Bottom_03.jpg"><div align="right" class="style1">| <a href="mailto:Hosting@HVZSource.com" target="_blank">Contact Us</a> | <a href="http://www.humansvszombies.org" target="_blank">Learn More</a> | <a href="http://www.humansvszombies.org/About.php" target="_blank">HvZ News</a>      |  <a href="admin/index.php">Admin</a>  |</div></td>
      </tr>
      <tr>
        <td> <img src="images/Bottom_04.jpg" width="351" height="8" alt="" /></td>
      </tr>

    </table></td>  
    <td style="background:url(images/LeftBottomBKGRNDImage.jpg) no-repeat left top">&nbsp;</td>
  </tr>
</table>
           <center><img src="http://media.goucherzombies.com/hvzsource/Maverick.gif" alt="" width="200" height="125" /><br>
            <p align="center" class="style8 style2">HVZ Source code ©2008 and Justin Quick.<br />
              Web design and logo ©2008 Max Temkin.<br />
              &quot;Humans vs. Zombies&quot; rules, logo ©2008 Chris Weed.</p>
              <p align="center" class="style8 style2"> HVZ SOURCE is a project created by Chris Weed (Paladin), <br>Joe Sklover (Ranger), Justin Quick (Sourcerer), Trevor Moorman (Rogue), <br>and Max Temkin (Wizard).</p></th>

</body> 
</html> 


<?php
ob_end_flush();
?>
