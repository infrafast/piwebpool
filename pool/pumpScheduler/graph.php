<?php

include_once('include/phpMyGraph5.0.php'); 
require('configuration.php');

$cfg['width'] = $_GET["width"] ;
$cfg['height'] = $_GET["height"];
$cfg['key-color'] = "00a2e8";
$cfg['column-color'] = "00a2e8";
$cfg['value-label-color'] = "000000";
$cfg['background-color'] = "f0f0f0";
//keyvisible = affichage de l'echelle du temps

$text=null;

$hint = array(
			"pump"=>array("pump message1","pump message 2"),
			"pac"=>array("PAC message1","PAC message 2"),
		    "treatment1"=>array("treatment1 message1","treatment1 message 2"),
    	    "treatment2"=>array("treatment2 message1","treatment2 message 2"),
		    "ph"=>array("ph message1","ph message 2"),
		    "orp"=>array("orp message1","orp message 2"),              		    
		    "temperature"=>array("temperature message1","temperature message 2")                
                );

// connect to the database
if (!$link = mysql_connect($options["database"]["host"], $options["database"]["username"], $options["database"]["password"])) {
    echo 'Could not connect to mysql';
    exit;
}


if (!mysql_select_db($options["database"]["name"], $link)) {
    echo 'Could not select database :'.$options["database"]["name"];
    exit;
}

$sql = "select ".$_GET["graph"].",id, timeStamp from (select ".$_GET["graph"].", id, timeStamp from measures order by timeStamp desc limit ".intval($_GET["period"]).") tempTable order by timeStamp asc";
//echo $sql; exit;
$result = mysql_query($sql, $link);

if (!$result) {
    echo mysql_error();
    exit;
}

$data = array();
while ($row = mysql_fetch_assoc($result)){
    $date = strtotime($row['timeStamp']);
    $hour = date('DH', $date);    
    //$data[$row['timeStamp']] = $row[$_GET["graph"]];
    $data[$hour] = $row[$_GET["graph"]];    
   // echo "<br>".$row['timeStamp']." ". $row[$_GET["graph"]]." ".$hour;
}
//exit;

header("Content-type: image/png");
//Create phpMyGraph instance
$graph = new phpMyGraph();
//Parse
switch ($_GET["type"]){
    case "barType":
        $cfg['label']=$_GET["title"];
        //$cfg['label-visible']=false;
        $cfg['value-label-visible']=false;
        $cfg['zero-line-visible']=false;
        $cfg['key-visible']=false;
        $cfg['value-visible']=false;
        $cfg['box-border-visible']=false;
        $cfg['horizontal-divider-visible']=false;  
        $cfg['average-line-visible']=false;
        //$cfg['column-divider-visible']=false;
        $cfg['key-visible']=true;
        $cfg['background-color']="F0F0F0";    
    
        $graph->parseVerticalSimpleColumnGraph($data,$cfg);
    break;
    case "lineType":
        $cfg['key-visible']=true;
        $graph->parseVerticalLineGraph($data,$cfg);
    break;
    case "textType":
        $text=$hint[$_GET["graph"]][0];
        $text.="\nLes stats sont effectuées sur la base de ".$_GET["period"];
        // treat message in function (periode). ex: forecast
    default:
        if ($text==null) $text="unknown or undefined graph type ".$_GET["type"];
        $img = imagecreate($cfg['width'], $cfg['height']);
        // Transparent background
        $black = imagecolorallocate($img, 0, 0, 0);
        imagecolortransparent($img, $black);
        // Red text
        $fontsize = 5;
        $red = imagecolorallocate($img, 255, 0, 0);
        imagestring($img, $fontsize, 0, 0, utf8_decode($text), $red);
    
        imagepng($img);
        imagedestroy($img);
    break;    
}


?>