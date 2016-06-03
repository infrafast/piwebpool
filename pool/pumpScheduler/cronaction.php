<?php

require_once('configuration.php');

// this script is to be executed periodically thru crontab (or other means) at least every 2hours in order to query the
// scheduler table to switch the pump on/ff accordingly

if (!$link = mysql_connect($options["database"]["host"], $options["database"]["username"], $options["database"]["password"])) {
    echo 'Could not connect to mysql';
    exit;
}

if (!mysql_select_db($options["database"]["name"], $link)) {
    echo 'Could not select database';
    exit;
}

// get the current hours and force multiple to 2
$tw=date("H");
$tw=9;
if ($tw/2 <> intval($tw/2)) $tw-=1;
// format to 2 digit (prefix 0) 
$prefixDigit="";
if ($tw<10) $prefixDigit="0";
// convert to text with hour so it match the row name in table
$tw=$prefixDigit.$tw."h";
echo "\n".$tw."\n";



$sql    = "SELECT 0to2 FROM ".$options["database"]["table"];
$result = mysql_query($sql, $link);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}



while ($row = mysql_fetch_assoc($result)) {
    echo $row['0to2'];
    }

mysql_free_result($result);

?>