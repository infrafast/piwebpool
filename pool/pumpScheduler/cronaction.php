<?php
// this script is to be executed periodically thru crontab (or other means) at least every 2hours in order to query the
// scheduler table to switch the pump on/ff accordingly

require_once('configuration.php');
require_once('functions.php');

// connect to the database
if (!$link = mysql_connect($options["database"]["host"], $options["database"]["username"], $options["database"]["password"])) {
    echo 'Could not connect to mysql';
    exit;
}

if (!mysql_select_db($options["database"]["name"], $link)) {
    echo 'Could not select database';
    exit;
} 

// what time is it now?
$tw=getCurrentTimeWindow();
// what is the temperature
$temp=getPoolTemperature();


//treat the case when the tw and temp are forced by user thru the GUI
//in that case override the value here by these value
//ensure the out of range is captured on client side

//then treat the case where tw and temperature are out of range
//e.g.: either get defaut values or raise email error notification
//this would then capture the out of range above



$sql    = "SELECT ".$temp." FROM ".$options["database"]["table"]." where timeWindow='".$tw."'";
$result = mysql_query($sql, $link);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

$pumpConsign="";
while ($row = mysql_fetch_assoc($result)) {
    $pumpConsign=$row[$temp];
}
// treat error case of unfound timewindow in the table
//if ($pumpConsign="")

mysql_free_result($result);

if (!setPinState($pins[$materials["Filtration"]],$pumpConsign)){
    echo 'error setPinState'.$pins[$materials["Filtration"]]." ".$pumpConsign;
    exit;   
}


echo "\n[".date("Y-m-d H:i:s")."][tw:".$tw."][temp:".$temp."][setPinState:".$pins[$materials["Filtration"]]." ".$pumpConsign."]";

?>
