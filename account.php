<?php
ob_start();
session_start();

require_once('security.php');
require_once('functions/load_config.php');
require_once('functions/quick_con.php');
$config = load_config('settings/config.dat'); 
$sql = my_quick_con($config) or die("SQL problem"); 
$table_u = $config['user_table'];
$game_name = $config['game_name'];
$id = $_SESSION['id'];
$ret = mysql_query("SELECT pic_path FROM $table_u WHERE id='$id';"); 
$c_pic_path = mysql_fetch_assoc($ret);
$c_pic_path = $c_pic_path['pic_path'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Humans vs. Zombies :: Source - My Account</title>
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
                <a href='account.php'>My Account</a>&nbsp;&nbsp;|&nbsp;&nbsp;
                <a href='logout.php'>Log Out</a>
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
if($_POST['submit'] == 'Change Password') {
	$ret = mysql_query("SELECT password FROM $table_u WHERE id='$id';");
	$pass_ret = mysql_fetch_assoc($ret); 
	$pass_ret = $pass_ret['password'];
	$pass_cur = md5(ereg_replace("[^A-Za-z0-9]","",$_POST['pass_original']));
	$pass_new = md5(ereg_replace("[^A-Za-z0-9]","",$_POST['pass_new']));
	$pass_con = md5(ereg_replace("[^A-Za-z0-9]","",$_POST['pass_confirm']));
	print "<table width=100% height=100%><tr><td align=center valign=center>";
	if($pass_ret == $pass_cur) {
		if(strlen($_POST['pass_new']) >= 4 && strlen($_POST['pass_new']) <= 20) {
			if($pass_new == $pass_con) {
				$ret = mysql_query("UPDATE $table_u SET password = '$pass_new' WHERE id='$id';");
				print "Password successfully changed.<br>";
				print "<a href='account.php'>Back</a>";
			} else {
				print "The passwords you entered did not match."; 
				print "<a href='account.php'>Back</a>";
			}
		} else {
			print "Your new password must be between 4 and 20 alphanumerics.<br>";
			print "<a href='account.php'>Back</a>";
		}
	} else {
		print "The password you entered was incorrect.<br>"; 
		print "<a href='account.php'>Back</a>";
	}
	print "</td></tr></table>";
} else if($_POST['submit'] == 'Upload') {
	$ret = mysql_query("SELECT fname, lname FROM $table_u WHERE id='$id';");
	$row = mysql_fetch_row($ret); 
	$extension = basename($_FILES['new_pic']['name']);
	$sub_ex = explode(".", $extension); 
	$extension = strtolower($sub_ex[sizeof($sub_ex) - 1]);
	$target_path = "/pics/$game_name/$row[0]_$row[1].$extension";
	print "<table width=100% height=100%><tr><td align=center valign=center>";
	if(($extension == 'jpg') || ($extension == 'jpeg') || ($extension == 'gif')) {
		if(move_uploaded_file($_FILES['new_pic']['tmp_name'], $target_path)) {
			$ret = mysql_query("UPDATE $table_u SET pic_path = '$target_path' WHERE id='$id';");
			print "Picture successfully uploaded.<br>"; 
			print "<a href='account.php'>Back</a>";
		} else {
			print "There was an error uploading.<br>";
			print "<a href='account.php'>Back</a>";
		}
	} else {
		print "The file you attempted to upload was not properly formatted.<br>";
		print "<a href='account.php'>Back</a>";
	}
	print "</td></tr></table>";
} else {
?>
<body>
<h1>My Account:</h1>
<form method=POST action=<?php echo $PHP_SELF; ?>>
<table>
<tr><td colspan=2 align=center><b><h2>Change Password:</h2></b></td></tr>
<tr>
<td>Original Password:</td>
<td><input type='password' name='pass_original' size=20 maxlength=20></td>
</tr>
<tr>
<td>New Password:</td>
<td><input type='password' name='pass_new' size=20 maxlength=20></td>
</tr>
<tr>
<td>Confirm New Password:</td>
<td><input type='password' name='pass_confirm' size=20 maxlength=20></td>
</tr>
<tr><td colspan=2 align=center>
<input type='submit' name='submit' value='Change Password'>
</td></tr>
</table>
</form>

<form method=POST enctype='multipart/form-data' action=<?php echo $PHP_SELF; ?>>
<input type='hidden' name='MAX_FILE_SIZE' value='1000000'>
<table>
<tr>
<td><img src='<?php echo $c_pic_path; ?>' height=200></td>
<td>
Upload a new picture: <input type='file' size=30 name='new_pic'><br>
<small>
Acceptable formats are JPEG, JPG, and GIF.<br>
The file must be under 1 MB.<br>
Pictures are scaled to 200 pixel height.<br>
Abuse of the lack of a width setting will see you banned.<br>
Your picture should be of you, but this is not required.<br>
Any picture deemed inappropriate will be removed, and repeated attempts to upload said picture may result in a ban.<br>
</small><br><br>
<center>
<input type='submit' name='submit' value='Upload'>
</center>
</td>
</tr>
</table>
</form>
<center><br><br>
<font size="3">Your ID is <?php echo $id; ?>.</font><br>
</center>
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
            <p align="center" class="style8 style2">KarlVsZombies game code by Karl Tata.<br />
              &quot;Humans vs. Zombies&quot; rules, logo &copy;2009 Gnarwhal Studios.</p>
              <p align="center" class="style8 style2"> HVZ SOURCE is a project created by Chris Weed (Paladin), <br>Brad Sappington (Bard), Joe Sklover (Ranger), Justin Quick (Sourcerer),<br> Trevor Moorman (Rogue), and Max Temkin (Wizard).</p></th>

</body>
</html>

<?php
mysql_free_result($ret);
mysql_close($sql);
ob_end_flush();
?>
