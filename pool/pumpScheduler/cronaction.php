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

$sql    = "SELECT ".$temp." FROM ".$options["database"]["table"]." where timeWindow='".$tw."'";
$result = mysql_query($sql, $link);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

while ($row = mysql_fetch_assoc($result)) {
    $pumpConsign=$row[$temp];
}

mysql_free_result($result);

system("gpio mode ".$pins[$materials["Filtration"]]." out");
$cmd="gpio write ".$pins[$materials["Filtration"]]." ".$pumpConsign;
system ($cmd);

echo "[".date()."][tw:".$tw."][temp:".$temp."][cmd:".$cmd."]";

?>