<?php

include_once('include/phpMyGraph5.0.php'); 

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
    echo 'Could not select database';
    exit;
}

$sql    = "SELECT ".$temp." FROM pumpSchedule where timeWindow='".$tw."'";
$result = mysql_query($sql, $link);

if (!$result) {
    $answer="ERROR";
    $state=mysql_error();
}else{
    $pumpConsign=0;
    while ($row = mysql_fetch_assoc($result)) {
        $pumpConsign=($row[$temp]);
    }


$query="select col1, col2 from tab1 where sub_project = 'sometext'";
$result=mysql_query($query);
$row = mysql_fetch_assoc($result);
$data = array($row['col1'] => $row['col2'],);

switch($_GET["graph"]){
    
    case 'orp':

    break;
    
    case 'temperature':

    break;
    
    case 'ph':

    break;    
	
	default:
		echo "No graph specified, call with?&graph=[temperature|orp|pg]";
		return;
	break;
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