<?php
header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');

$uid = 73;
$red_id = 2;
setcookie("RedReminder_".$uid, $red_id, time()+30 * 24 * 3600, '/', '.idea580.com');