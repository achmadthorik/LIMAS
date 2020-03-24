<?php
if (!defined('__ROOT__')) {
    define('__ROOT__', dirname(dirname(__FILE__)));
}
$dir = './../language/' . $lang . '/dashboard.json';
$file = fopen($dir, 'r');
$contents = fread($file, filesize($dir));
fclose($file);
$dlang = json_decode($contents, true);
define('TITLE', $dlang['headertitle']);
define('MENU', array(
    'home'         => array($dlang["headermenu"]["home"],'./', 'glyphicon glyphicon-home hidden-sm'),
    'transactions' => array($dlang["headermenu"]["transactions"],'./transactions.php', 'glyphicon glyphicon-shopping-cart hidden-sm'),
    'reports'      => array($dlang["headermenu"]["reports"],'./reports.php', 'glyphicon glyphicon-tasks hidden-sm'),
    'libraries'    => array($dlang["headermenu"]["libraries"],'./libraries.php', 'glyphicon glyphicon-book hidden-sm'),
    'members'      => array($dlang["headermenu"]["members"],'./members.php', 'glyphicon glyphicon-user hidden-sm'),
    //'settings'     => array($dlang["headermenu"]["settings"],'./settings.php', 'glyphicon glyphicon-cog hidden-sm'),
    //'settings'     => array($dlang["headermenu"]["settings"],'./setting_users.php', 'glyphicon glyphicon-cog hidden-sm'),
    'settings'     => array($dlang["headermenu"]["settings"], './setting_users.php', 'glyphicon glyphicon-user hiden-sm'),
    'about'        => array($dlang["headermenu"]["about"],'./about.php', 'glyphicon glyphicon-info-sign hidden-sm'),
));
define('USER', array(
    //'profile'         => array($dlang['headeruser']["profile"], './profile.php'),
    //'accountsettings' => array($dlang['headeruser']["accountsettings"], './accountsettings.php'),
    'logout'          => array($dlang['headeruser']["logout"], './../processor/logout.php')
));
