<?php
function my_quick_con($config){
        $u = $config['mysql_user'];
        $p = $config['mysql_pass'];
        $d = $config['mysql_db'];
        $con = mysql_connect("localhost", $u, $p);
        mysql_select_db($d, $con);
        return $con;
}
?>

