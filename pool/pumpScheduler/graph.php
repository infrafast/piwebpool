<?php

include_once('include/phpMyGraph5.0.php'); 
require('configuration.php');

$cfg['width'] = 300 ;
$cfg['height'] = 150;
$cfg['average-line-visible']=false;
$cfg['label']=$_GET["period"];

// connect to the database
if (!$link = mysql_connect($options["database"]["host"], $options["database"]["username"], $options["database"]["password"])) {
    echo 'Could not connect to mysql';
    exit;
}


if (!mysql_select_db($options["database"]["name"], $link)) {
    echo 'Could not select database :'.$options["database"]["name"];
    exit;
}

$sql    = "select ".$_GET["graph"].",id from (select ".$_GET["graph"].", id from measures order by id desc) tempTable order by ID ASC limit ".intval($_GET["period"]);

$result = mysql_query($sql, $link);

if (!$result) {
    echo mysql_error();
    exit;
}

while ($row = mysql_fetch_assoc($result)) {
    $data = array($row['id'] , $row[$_GET["graph"]]);
}


header("Content-type: image/png");

//Create phpMyGraph instance
$graph = new phpMyGraph();

//Parse
$graph->parseVerticalLineGraph($data,$cfg);
?>