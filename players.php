<?php
ob_start();
session_start();
require_once('functions/load_config.php');
require_once('functions/quick_con.php'); 
$config = load_config('settings/config.dat');
$table_u = $config['user_table'];
$table_v = $config['var_table'];
$table_t = $config['time_table'];
$sql = my_quick_con($config) or die("MySQL problem"); 
// Set default time zone
$ret = mysql_query("SELECT zone FROM $table_t");
while($row = mysql_fetch_array($ret)){
	date_default_timezone_set($row['zone']);
}

// update the starvation times and oz reveal (every 5 minutes, not on every page refresh)
$now = time();
$last_starvation_update = (isset($_SESSION['last_starvation_update'])) ? $_SESSION['last_starvation_update'] : $now;
if($last_starvation_update >= $now + 900) {
	$ret = mysql_query("UPDATE $table_u SET state = -4 WHERE now() > feed + INTERVAL 2 day;");
	$ret = mysql_query("UPDATE $table_u SET starved = feed + INTERVAL 2 day WHERE state = -4;");
	$ret = mysql_query("UPDATE $table_u SET state = 0 WHERE state = -4;");
	$ret = mysql_query("SELECT value FROM $table_v WHERE keyword='oz-revealed';");
	$reveal_oz = mysql_fetch_assoc($ret);
	$reveal_oz = $reveal_oz['value'];
	 
	$_SESSION['last_starvation_update'] = time();
	$_SESSION['oz_revealed'] = $reveal_oz;
} else {
	$reveal_oz = (isset($_SESSION['oz_revealed'])) ? $_SESSION['oz_revealed'] : 0;
}

$state_translate = array('-3'=>'horde', '-2'=>'horde (original)', '-1'=>'horde', '0'=>'deceased', '1'=>'resistance', '2'=>'resistance');
$admin = 0;
if(isset($_SESSION['pass_hash'])) $admin = 1;

if($_POST['submit'] == 'refresh') {
	$post_faction_array = array('a'=>'1 = 1', 'r'=>'state > 0', 'h'=>'state < 0', 'd'=>'state = 0'); 
	if(!$reveal_oz) { 
		$post_faction_array['r'] = 'state > 0 OR state = -2';
		$post_faction_array['h'] = 'state = -1 OR state = -3';
	}
	$post_sort_by_array = array('ln'=>'lname', 'fn'=>'fname', 'ks'=>'kills', 'kd'=>'killed', 'fd'=>'feed', 'sd'=>'starved');
	$post_order_array = array('a'=>'ASC', 'd'=>'DESC');

	$faction = $post_faction_array[$_POST['faction']];
	if(!isset($faction)) $faction = '1 = 2';
	$sort_by = $post_sort_by_array[$_POST['sort_by']];
	if(!isset($sort_by)) $sort_by = 'lname';
	$order = $post_order_array[$_POST['order']];
	if(!isset($order)) $order = 'DESC';

	$show_pics = $_POST['show_pics'];
	$show_kills = $_POST['show_kills'];
	$show_killed = $_POST['show_killed'];
	$show_feed = $_POST['show_feed']; 
	$show_starved = $_POST['show_starved']; 
} else {
        $faction = '';
	$sort_by = 'lname';
	$order = 'ASC'; 
	$show_pics = 1;
	$show_kills = 1; 
	$show_killed = 0;
	$show_feed = 1; 
	$show_starved = 0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Humans vs. Zombies :: Source - Player List</title>
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
        if(is_resource($ret)) {
     mysql_free_result($ret);
}

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


<h3>Player List</h3>
<form name="playerListForm" action="players.php" method="post">
<input type="hidden" name="mode" value="refresh" />
<center>
<?php

$faction_array = array('a'=>'All', 'r'=>'Resistance', 'h'=>'Horde', 'd'=>'Deceased');
$sort_by_array = array('ln'=>'Last Name', 'fn'=>'First Name', 'ks'=>'Kills', 'kd'=>'Time Killed', 'fd'=>'Last Feeding', 'sd'=>'Time Starved');
$order_array = array('a'=>'Ascending', 'd'=>'Descending');
print "<select name='faction'>";
while(list($k,$v) = each($faction_array)) {
	print "<option value='$k'";
	if($_POST['faction'] == $k) print "selected";
	print ">$v</option>";
}
print "</select><select name='sort_by'>";
while(list($k,$v) = each($sort_by_array)) {
	print "<option value='$k'";
	if($_POST['sort_by'] == $k) print " selected";
	print ">$v</option>";
}
print "</select><select name='order'>";
while(list($k,$v) = each($order_array)) {
	print "<option value='$k'";
	if($_POST['order'] == $k) print "selected";
	print ">$v</option>";
}
print "</select>";

?>
<input type='submit' name='submit'><br>
<input type="hidden" name="faction_orig" value="<?php print (isset($_POST['faction'])) ? $_POST['faction'] : 'a'; ?>" />
<input type="hidden" name="sort_by_orig" value="<?php print (isset($_POST['sort_by'])) ? $_POST['sort_by'] : 'ln'; ?>" />
<input type="hidden" name="order_orig" value="<?php print (isset($_POST['order'])) ? $_POST['order'] : 'a'; ?>" />
<input type='checkbox' name='show_pics' value='1' <?php if($show_pics) print "checked"; ?>> Pictures
<input type='checkbox' name='show_kills' value='1' <?php if($show_kills) print "checked"; ?>> Kills
<input type='checkbox' name='show_killed' value='1' <?php if($show_killed) print "checked"; ?>> Time Killed
<input type='checkbox' name='show_feed' value='1' <?php if($show_feed) print "checked"; ?>> Last Fed
<input type='checkbox' name='show_starved' value='1' <?php if($show_starved) print "checked"; ?>> Time Starved
</center>
<br /><br />
<?php
// prepare the pagination values
$records = $config['page_records'];
$start = ($page - 1) * $records;
$limit = " LIMIT ".$start.", ".$records;

// player query
$player_query = "SELECT * FROM $table_u $faction ORDER BY $sort_by $order";
$ret = mysql_query($player_query.$limit);

// count query
$count_query = "SELECT COUNT(user_id) AS count FROM $table_u $faction ORDER BY $sort_by $order";
$count_ret = mysql_query($count_query);
$count = mysql_fetch_assoc($count_ret);
$count = $count['count'];

// get the total page count
$pages = ceil($count / $config['page_records']);
?>
<input type="hidden" name="page" value="<?php print $page; ?>" />

<? if($count_ret) include('pagination.php'); ?>

<table width="100%" cellspacing="0" class="data-table">
<tr>
<?php
if($show_pics) print "<td>picture</td>";
?>
<td>name</td>
<td>affiliation</td>
<?php
if($show_kills) print "<td>kills</td>";
if($show_killed) print "<td>time of death</td>";
if($show_feed) print "<td>last feeding time</td>";
if($show_starved) print "<td>time of starvation</td>";
if($admin) print "<td></td>";
?>
</tr>

<?php
// display the records
if($ret && ($rows = mysql_num_rows($ret)) > 0)
{
	for($i = 0; $i < $rows; $i++) {
		$row_id = ($i % 2) + 1;
		print '<tr class="row'.$row_id.'">';
		
		$row = mysql_fetch_assoc($ret);
		
		if($show_pics) {
			print '<td align="center">';
			if(strlen($row['pic_path']) > 0) {
				print '<img src="'.$row['pic_path'].'" class="player-pic '.$state_translate[$row['state']].'-pic">';
			} else {
				print "no image<br>available";
			}
			print "</td>";
		}
		
		print '<td align="center">'.$row['fname'].' '.$row['lname'].'</td>';
		
		print '<td align="center">';
		if($row['state'] == -2 && !$reveal_oz) {
			print '<span class="resistance">resistance</span>';
		} else {
			print '<span class="'.$state_translate[$row['state']].'">'.$state_translate[$row['state']].'</span>';
		}
		print "</td>";
		
		if($show_kills) {
			print '<td align="center">';
			if($row['state'] == -2 && !$reveal_oz) {
				print "0";
			} else {
				print $row['kills'];
			}
			print "</td>";
		}
		
		if($show_killed) {
			print '<td align="center">';
			if($row['state'] <= 0 && ($row['state'] != -2 || $reveal_oz)) {
				print $row['killed'];
			}
			print "</td>";
		}
		
		if($show_feed) {
			print '<td align="center">';
			if($row['state'] <= 0 && ($row['state'] != -2 || $reveal_oz)) { 
				print $row['feed'];
			}
			print "</td>";
		}
		
		if($show_starved) {
			print '<td align="center">';
			if($row['state'] == 0) { 
				print $row['starved'];
			}
			print "</td>";
		}
		print "</tr>";
	}
} else {
	print '<tr><td colspan="7" align="center"> There are no records to display</td></tr>';
}
?>


</table>
<center>
<? if($count_ret) include('pagination.php'); ?>
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
