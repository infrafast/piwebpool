
<?php

if (!$link = mysql_connect('localhost', 'root', 'Quintal74605')) {
    echo 'Could not connect to mysql';
    exit;
}

if (!mysql_select_db('pool', $link)) {
    echo 'Could not select database';
    exit;
}

$sql    = 'SELECT foo FROM pumpSchedule';
$result = mysql_query($sql, $link);

if (!$result) {
    echo "DB Error, could not query the database\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

while ($row = mysql_fetch_assoc($result)) {
    echo $row; //[''];
}

mysql_free_result($result);

?>
