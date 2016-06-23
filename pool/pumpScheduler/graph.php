<?php

include_once('include/phpMyGraph5.0.php'); 
require('configuration.php');

$cfg['width'] = 300 ;
$cfg['height'] = 150;
$cfg['average-line-visible']=false;
$cfg['label']=$_GET["period"];


if (!mysql_select_db($options["database"]["name"], $link)) {
    echo 'Could not select database :'.$options["database"]["name"];
    exit;
}

$sql    = "select orp,id from (select ".$_GET["graph"].", id from measures order by id desc) tempTable order by ID ASC limit ".intval($_GET["period"]);
$result = mysql_query($sql, $link);

if (!$result) {
    echo mysql_error();
    exit;
}

while ($row = mysql_fetch_assoc($result)) {
    $pumpConsign=($row[$temp]);
    $data = array($row['id'] => $row[$_GET["graph"]],);
}


$data = array(
    '00' => rand(0,10),
    '01' => rand(0,10),
    '02' => rand(0,10),
    '03' => rand(0,10),
    '04' => rand(0,10),
    '05' => rand(0,10),
    '06' => rand(0,10),
    '07' => rand(0,10),
    '08' => rand(0,10),
    '09' => rand(0,10),
    '10' => rand(0,10)
);

header("Content-type: image/png");

//Create phpMyGraph instance
$graph = new phpMyGraph();

//Parse
$graph->parseVerticalLineGraph($data,$cfg);
?>