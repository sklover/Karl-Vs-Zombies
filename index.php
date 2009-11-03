<?php
ob_start();
session_start();
require_once('functions/load_config.php');
require_once('functions/quick_con.php');
$config = load_config('settings/config.dat');
 
// get the front content and save it into the session
if(!isset($_SESSION['content']['front'])) {
$sql = my_quick_con($config) or die("MySQL problem");
$result = mysql_query("SELECT value FROM $config[content_table] WHERE keyword='front'");
$row = mysql_fetch_assoc($result);
$_SESSION['content']['front'] = $row['value'];
}
 
$front = $_SESSION['content']['front'];
?>
 
<?php include('template_top.php'); ?>
 
<p>
<?php print $front; ?>
</p>
 
<p>
<div style="padding-right: 15px;">
<img src="http://humansvszombies.org/images/tshirt.jpg" alt="" />
<br /><br />
<b>Humans vs. Zombies</b> t-shirts are now available for <a target="_blank" href="http://humansvszombies.org/merch">order</a>.
<br /><br />
<form name="BB_BuyButtonForm" method="post" id="BB_BuyButtonForm" action="https://checkout.google.com/api/checkout/v2/checkoutForm/Merchant/313607151397793">
<select name="item_selection_1">
<option value="1">$15.00 - Official HvZ T-Shirt (S)</option>
<option value="2">$15.00 - Official HvZ T-Shirt (M)</option>
<option value="3">$15.00 - Official HvZ T-Shirt (L)</option>
<option value="4">$15.00 - Official HvZ T-Shirt (XL)</option>
</select>
<input type="hidden" value="Official HvZ T-Shirt (S)" name="item_option_name_1" />
<input type="hidden" value="15.0" name="item_option_price_1" />
<input type="hidden" value="Free Shipping" name="item_option_description_1" />
<input type="hidden" value="1" name="item_option_quantity_1" />
<input type="hidden" value="USD" name="item_option_currency_1" />
<input type="hidden" value="Official HvZ T-Shirt (M)" name="item_option_name_2" />
<input type="hidden" value="15.0" name="item_option_price_2" />
<input type="hidden" value="Free Shipping" name="item_option_description_2" />
<input type="hidden" value="1" name="item_option_quantity_2" />
<input type="hidden" value="USD" name="item_option_currency_2" />
<input type="hidden" value="Official HvZ T-Shirt (L)" name="item_option_name_3" />
<input type="hidden" value="15.0" name="item_option_price_3" />
<input type="hidden" value="Free Shipping" name="item_option_description_3" />
<input type="hidden" value="1" name="item_option_quantity_3" />
<input type="hidden" value="USD" name="item_option_currency_3" />
<input type="hidden" value="Official HvZ T-Shirt (XL)" name="item_option_name_4" />
<input type="hidden" value="15.0" name="item_option_price_4" />
<input type="hidden" value="Free Shipping" name="item_option_description_4" />
<input type="hidden" value="1" name="item_option_quantity_4" />
<input type="hidden" value="USD" name="item_option_currency_4" /><br />
<input type="image" src="https://checkout.google.com/buttons/buy.gif?merchant_id=313607151397793&amp;w=117&amp;h=48&amp;style=trans&amp;variant=text&amp;loc=en_US" alt="" />
</form>
</div>
</p>
 
<?php include('template_bottom.php'); ?>
 
