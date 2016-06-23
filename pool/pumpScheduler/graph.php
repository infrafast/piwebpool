<?php

include_once('include/phpMyGraph5.0.php'); 
require('configuration.php');

$cfg['width'] = $_GET["width"] ;
$cfg['height'] = $_GET["height"];
$cfg['average-line-visible']=false;
//$cfg['label-visible']=false;
$cfg['value-label-visible']=false;
//$cfg['key-visible']=false;
//$cfg['label']=$_GET["period"];

// connect to the database
if (!$link = mysql_connect($options["database"]["host"], $options["database"]["username"], $options["database"]["password"])) {
    echo 'Could not connect to mysql';
    exit;
}


if (!mysql_select_db($options["database"]["name"], $link)) {
    echo 'Could not select database :'.$options["database"]["name"];
    exit;
}

$sql    = "select ".$_GET["graph"].",id, timeStamp from (select ".$_GET["graph"].", id, timeStamp from measures order by timeStamp desc) tempTable order by timeStamp desc limit ".intval($_GET["period"]);

$result = mysql_query($sql, $link);

if (!$result) {
    echo mysql_error();
    exit;
}

$data = array();
while ($row = mysql_fetch_assoc($result)) {
    //$data = array($row['id'] => $row[$_GET["graph"]],);
    $data[$row['timeStamp']] = $row[$_GET["graph"]];
}


header("Content-type: image/png");

//Create phpMyGraph instance
$graph = new phpMyGraph();

//Parse
if ($_GET["type"]=="bar") $graph->parseVerticalSimpleColumnGraph($data,$cfg);
else $graph->parseVerticalLineGraph($data,$cfg);

?>