<?php

// this script is to be executed periodically thru crontab (or other means) at least every 2hours in order to query the
// scheduler table to switch the pump on/ff accordingly

if (!$link = mysql_connect('localhost', 'root', 'Quintal74605')) {
    echo 'Could not connect to mysql';
    exit;
}

if (!mysql_select_db('pool', $link)) {
    echo 'Could not select database';
    exit;
}

tw=Date("H");


$sql    = 'SELECT 0to2 FROM pumpSchedule';
$result = mysql_query($sql, $link);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

echo tw;

while ($row = mysql_fetch_assoc($result)) {
    echo $row['0to2'];
    }

mysql_free_result($result);

?>