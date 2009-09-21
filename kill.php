<?php
ob_start();
session_start();
require_once('security.php');
require_once('functions/load_config.php');
require_once('functions/quick_con.php'); 
$config = load_config('settings/config.dat'); 
$sql = my_quick_con($config) or die("MySQL problem"); 
$table_v = $config['var_table'];
$table_u = $config['user_table'];
$table_t = $config['time_table'];
// Set default time zone
$ret = mysql_query("SELECT zone FROM $table_t");
while($row = mysql_fetch_array($ret))
	   date_default_timezone_set($row['zone']);
$ret = mysql_query("UPDATE $table_u SET state = -4 WHERE now() > feed + INTERVAL 2 day;");
$ret = mysql_query("UPDATE $table_u SET starved = feed + INTERVAL 2 day WHERE state = -4;");
$ret = mysql_query("UPDATE $table_u SET state = 0 WHERE state = -4;");
$ret = mysql_query("SELECT value FROM $table_v WHERE zkey='oz-revealed';");
// this is an array fetching bug 
// $reveal_oz = mysql_fetch_assoc($ret);
// $reveal_oz is clearly expecting a scalar return value and not an array
// therefore, you have to look at the query and figure out which single field 
// it was trying to extract (value in this case, based on the prior SELECT).
$reveal_oz = mysql_fetch_assoc($ret);
$reveal_oz = $reveal_oz['value'];
// UCWATIDIDTHAR?
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Humans vs. Zombies :: Source</title>
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

<?php
$ret = mysql_query("SELECT value FROM $table_v WHERE zkey='game-started';");
$game_started = mysql_fetch_assoc($ret); 
$game_started = $game_started['value'];
if($game_started == 0) {
	mysql_free_result($ret);
	mysql_close($sql); 
	header("location:game_no_start.php");
}
$ret = mysql_query("SELECT value FROM $table_v WHERE zkey='game-over';");
$game_over = mysql_fetch_assoc($ret);
$game_over = $game_over['ret'];
if($game_over == 1) {
        mysql_free_result($ret);
        mysql_close($sql);
        header("location:game_over.php");
}


if($_POST['submit'] == 'Report Kill') {
$victim = strtoupper(ereg_replace("[^A-Za-z0-9]","",$_POST['victim_id']));
$feed[0] = $_SESSION['id'];
$feed[1] = ereg_replace("[^A-Za-z0-9]","",$_POST['feed1']);
$feed[2] = ereg_replace("[^A-Za-z0-9]","",$_POST['feed2']);
$hour = ereg_replace("[^0-9]","",$_POST['hour']);
$minute = ereg_replace("[^0-9]","",$_POST['minute']);
$today = ereg_replace("[^0-1]","",$_POST['day']);
$err = 0; 
$ret = mysql_query("SELECT value FROM $table_v WHERE zkey='oz-revealed';");
$revealed = mysql_fetch_assoc($ret);
$revealed = $revealed['value'];

print "<table height=100% width=100%><tr><td align=center valign=center><font color='white'>";

$ret = mysql_query("SELECT state FROM $table_u WHERE id='$victim';");
$vstate = mysql_fetch_assoc($ret); 
$vstate = $vstate['state'];
if(mysql_num_rows($ret) == 0) {
	print "The ID number you entered could not be found.<br>"; 
	$err = 1; 
} else if($vstate <= 0) {
	print "Eating that person won't help you.<br>"; 
	$err = 1; 
} else {
	$current_hour = date('H');
	$current_minute = date('i');
	if($today == 1 && (($hour > $current_hour) || ($hour == $current_hour && $minute > $current_minute))) {
		print "You can't eat people from the future.<br>";
		$err = 1;
	}
}
for($i = 0; $i < sizeof($feed) && $err == 0; $i++) { if(strlen($feed[$i]) > 0) {
	if(!$revealed) {
		$f = $feed[$i];
                $ret = mysql_query("SELECT state FROM $table_u WHERE id='$f';");
                $temp = mysql_fetch_assoc($ret);
		$temp = $temp['state'];
                if($temp == '-2') $feed[$i] = 'OriginalZombie';
        }

	$ret = mysql_query("SELECT state, fname, lname, feed FROM $table_u WHERE id='$feed[$i]';"); 
	if(mysql_num_rows($ret) == 0) { $err = 1; break; }

	$row = mysql_fetch_row($ret); 

	$f_state = $row[0]; 
	$feed_name = "$row[1] $row[2]";

//	$day = date('d');
//	if($today == 0) $day--;
//	$last_day = substr($row[3], 8, 2);
//	$last_hour = substr($row[3], 11, 2);
//	$last_minute = substr($row[3], 14, 2);

	if($f_state == 0) {		print "$feed_name is dead."; $err = 1; break; }
	else if($f_state > 0) {		print "$feed_name is not (yet?) a zombie."; $err = 1; break; }
//	else if(($day == $last_day && (($hour < $last_hour) || ($hour == $last_hour && $minute < $last_minute))) || $day < $last_day) {
//					print "$feed_name has fed more recently than this kill."; $err = 1; break;
//	}
}}
if($err == 0) {



$of = $feed[0];
$kill_time = date('Y-m-d') . " $hour:$minute:00";
$ret = mysql_query("UPDATE $table_u SET kills = kills + 1 WHERE id='$of';");
$ret = mysql_query("UPDATE $table_u SET state = -1 WHERE id='$victim';");
$ret = mysql_query("UPDATE $table_u SET feed = TIMESTAMP '$kill_time' + INTERVAL 1 hour WHERE id='$victim';");
if($today == 0) $ret = mysql_query("UPDATE $table_u SET feed = feed - INTERVAL 1 day WHERE id='$victim';");
$ret = mysql_query("UPDATE $table_u SET killed_by = '$of' WHERE id='$victim';");
$ret = mysql_query("UPDATE $table_u SET killed = TIMESTAMP '$kill_time' WHERE id='$victim';");
if($today == 0) $ret = mysql_query("UPDATE $table_u SET killed = killed - INTERVAL 1 day WHERE id='$victim';");

for($i = 0; $i < sizeof($feed); $i++) { if(strlen($feed[$i]) > 0) {
	$f = $feed[$i];
	$kill_time = date('Y-m-d') . " $hour:$minute:00";
	        if(is_resource($ret)) {
     mysql_free_result($ret);
}
        $ret = mysql_query("UPDATE $table_u SET feed = TIMESTAMP '$kill_time' WHERE id = '$f' and timediff(TIMESTAMP '$kill_time' + INTERVAL 2 day,now()) > timediff(feed + INTERVAL 2 day,now());");
        if($ret && $today == 0) $ret = mysql_query("UPDATE $table_u SET feed = feed - INTERVAL 1 day WHERE id='$f';");
}}

	//TWITTER API
	// Get victim name
	$ret = mysql_query("SELECT fname, lname FROM $table_u WHERE id='$victim';");
	$vic_row = mysql_fetch_array($ret);
	// Get zombie name and state
	$ret = mysql_query("SELECT fname, lname, state FROM $table_u WHERE id='$of';");
	$zom_row = mysql_fetch_array($ret);
	// The message you want to send
	// OZ is not revealed, OZ makes kill
	if(!$revealed && $zom_row[2] < -1){
		$message = "The original zombie has killed " . $vic_row[0] . " " . $vic_row[1] . ".";
	}
	// Non-OZ or OZ after reveal makes a kill
	else{
		$message = $zom_row[0] . " " . $zom_row[1] . " has killed " . $vic_row[0] . " " . $vic_row[1] . ".";	
	}
	include("twitter.php");	

	print "Kill reported.<br><a href=$PHP_SELF>Go Back</a>";


} else {
	print "<a href=$PHP_SELF>Go Back</a>";
}
print "</td></tr></table>";
} else {
?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="29" bgcolor="#2E2C2D">&nbsp;</td>
    <td width="900" height="300" rowspan="2" valign="top" bgcolor="#FFFFFF"><table id="Table_01" height="301" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="29" colspan="18" background="images/Top_01.jpg"><div align="right" class="style1">
            <div align="right">
<?php



if($_POST['submit'] == 'Login') {
	$logname = ereg_replace("[^A-Za-z0-9]","",$_POST['user']);
	$logpass = md5(ereg_replace("[^A-Za-z0-9]","",$_POST['pass']));
	$sql = my_quick_con($config) or die("MySQL problem"); 
	$table_u = $config['user_table'];
	$ret = mysql_query("SELECT password FROM $table_u WHERE username='$logname';");
	$pass = mysql_fetch_assoc($ret);
	$pass = $pass['password'];
	if(mysql_num_rows($ret) == 1 && $pass == $logpass) {
		$ret = mysql_query("SELECT id FROM $table_u WHERE username='$logname';");
		$id = mysql_fetch_assoc($ret);
		$id = $id['id'];
		mysql_free_result($ret);
		$_SESSION['user'] = $logname;
		$_SESSION['id'] = $id;
		header('Location:'.$PHP_SELF);
	} else {
		echo "&nbsp;&nbsp;|&nbsp;&nbsp;<font color=red>Invalid username/password</font>";
	}
	mysql_free_result($ret);
}

if(!isset($_SESSION['user'])) {
	echo'<form method=POST action=';
	echo $PHP_SELF;
	echo '>
                <a href="register.php">Register</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	     	<input name="user" type="text" value="Username" size="15" />
              	<input name="pass" type="password" value="Password" size="15" />
		<input type="submit" name="submit" value="Login">
		&nbsp;&nbsp;|&nbsp;&nbsp;<a href="pass_reset.php">Forgot your Password?</a>
	      </form>';

}
else { 
	echo '<a href="account.php">My Account</a>&nbsp;&nbsp;|&nbsp;&nbsp; <a href="logout.php">Log Out</a>';
	}     


?>


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
<form method=POST action=<?php echo $PHP_SELF; ?>>
<center><h1>Report Kills:</h1>
<table border>
<tr>
<td>victim</td>
<td><input type='text' name='victim_id' size=20></td>
</tr>

<tr>
<td colspan=2>
<select name="day">
	<option value='0'>yesterday</option>
	<option value='1' selected>today</option>
</select>
<select name="hour">
<?php
for($i = 0; $i < 24; $i++) {
	print "<option value='$i'>$i</option>";
}
?>
</select>
<select name="minute">
<?php
for($i = 0; $i < 60; $i++) {
	print "<option value='$i'>$i</option>";
}
?>
</select>
</td>
</tr>

<tr>
<td>feed 1</td>
<td>
<select name='feed1'>
	<option></option>
<?php
$pid = $_SESSION['id']; 
if($reveal_oz) $ret = mysql_query("SELECT id, fname, lname, timediff(feed + INTERVAL 2 day, now()) FROM $table_u WHERE state < 0 AND id != '$pid' ORDER BY feed ASC;"); 
else $ret = mysql_query("SELECT id, fname, lname, timediff(feed + INTERVAL 2 day, now()) FROM $table_u WHERE state < 0 AND state != -2 AND id != '$pid' ORDER BY feed ASC;");
for($i = 0; $i < mysql_num_rows($ret); $i++) {
	$row = mysql_fetch_row($ret); 
	$till_starve = $row[3];
	print "<option value='$row[0]'>$row[1] $row[2] ($till_starve)</option>"; 
}
?>
</select>
</td>
</tr>

<tr>
<td>feed 2</td>
<td>
<select name='feed2'>
        <option></option>
<?php
mysql_data_seek($ret, 0);
for($i = 0; $i < mysql_num_rows($ret); $i++) {
        $row = mysql_fetch_row($ret); 
	$till_starve = $row[3];
	print "<option value='$row[0]'>$row[1] $row[2] ($till_starve)</option>";
}
?>
</select>
</td>
</tr>

<tr>
<td colspan=2 align=center>
<input type='submit' name='submit' value='Report Kill'>
</td>
</tr>
</table>
<table width=50%>
<tr><td align=left valign=top>
<ul>
<li>Victim ID is not case sensitive</li>
</ul>
<br><b>Current Time: </b>
<?php 
echo date('l jS \of F Y h:i:s A');
echo "<br />";
$ret = mysql_query("SELECT zone FROM $table_t");
while($row = mysql_fetch_array($ret))
	   echo "<b>Timezone: </b>" . ($row['zone']);
?>
</td></tr>
</table>
</center>
</form>

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



<?php
}
?>



</html>

<?php
mysql_free_result($ret);
mysql_close($sql); 
ob_end_flush();
?>
