<?php

include_once('include/phpMyGraph5.0.php'); 
require('configuration');

$cfg['width'] = 300 ;
$cfg['height'] = 150;
$cfg['average-line-visible']=false;
$cfg['label']=$_GET["period"];



// connect to the database
if (!$link = mysql_connect($options["database"]["host"], $options["database"]["username"], $options["database"]["password"])) {
    echo 'Could not connect to mysql';
    exit;
}




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