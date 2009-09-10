<?php
ob_start();
session_start();
require_once('functions/load_config.php');
require_once('functions/quick_con.php');
$config = load_config('settings/config.dat');
$sql = my_quick_con($config) or die("MySQL problem");
$result = mysql_query("SELECT rules FROM content");

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
		header("Location:$goto");
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
<p><strong><h1>Humans Vs Zombies Rules:</h1></strong>
<p>
                <?php while($row = mysql_fetch_array($result))
                {
                echo $row[0];
                }
                ?>

</p>
<?php
ob_end_flush();
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
        <td height="27" background="images/Bottom_03.jpg"><div align="right" class="style1">| <a href="mailto:Hosting@HVZSource.com" target="_blank">Contact Us</a> | <a href="http://www.humansvszombies.org" target="_blank">Learn More</a> | <a href="http://www.humansvszombies.org/About.php" target="_blank">HvZ News</a>      |</div></td>
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
            <p align="center" class="style8 style2">HVZ Source code ©2008 and Justin Quick.<br />
              Web design and logo ©2008 Max Temkin.<br />
              &quot;Humans vs. Zombies&quot; rules, logo ©2008 Chris Weed.</p>
              <p align="center" class="style8 style2"> HVZ SOURCE is a project created by Chris Weed (Paladin), <br>Joe Sklover (Ranger), Justin Quick (Sourcerer), Trevor Moorman (Rogue), <br>and Max Temkin (Wizard).</p></th>

</body>
</html>
<?php
ob_end_flush();
?>
