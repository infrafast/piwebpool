<?php

require_once('configuration.php');
require_once('functions.php');

// this script is to be executed periodically thru crontab (or other means) at least every 2hours in order to query the
// scheduler table to switch the pump on/ff accordingly

connectDB();

// what time is it now?
$tw=getCurrentTimeWindow();
echo "\n".$tw."\n";


$sql    = "SELECT 0to2 FROM ".$options["database"]["table"]." where timeWindow='".$tw."'";
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