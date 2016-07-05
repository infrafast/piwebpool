<?php

include_once('include/phpMyGraph5.0.php'); 
require('configuration.php');

require "include/gd-text/Box.php";
require "include/gd-text/Color.php";
require "include/gd-text/TextWrapping.php";
require "include/gd-text/HorizontalAlignment.php";
require "include/gd-text/VerticalAlignment.php";

use GDText\Box;
use GDText\Color;

//////////////////////////////////////////////////
function getTrend(array $values) {
    $x_sum = array_sum(array_keys($values));
    $y_sum = array_sum($values);
    $meanX = $x_sum / count($values);
    $meanY = $y_sum / count($values);
    // calculate sums
    $mBase = $mDivisor = 0.0;
    foreach($values as $i => $value) {
        $mBase += ($i - $meanX) * ($value - $meanY);
        $mDivisor += ($i - $meanX) * ($i - $meanX);
    }

    // calculate slope
    $slope = $mBase / $mDivisor;
    return $slope;
}   //  function leastSquareFit()
//////////////////////////////////////////////////////


//if(!isset($_GET['text'])) $_GET['text'] = "Hello, world!";
//

$cfg['width'] = $_GET["width"] ;
$cfg['height'] = $_GET["height"];
$cfg['key-color'] = "00a2e8";
$cfg['column-color'] = "00a2e8";
$cfg['value-label-color'] = "000000";
$cfg['box-background-color'] = "ffffff";
$cfg['background-color'] = "ffffff";
//$cfg['background-color'] = "f0f0f0";
$cfg['box-border-visible']=false;
//keyvisible = affichage de l'echelle du temps

$text=null;

$analyse = array(
		    "pump"=>array("up"=>"pump up message",
		                "down"=>"pump down message",
		                "stable"=>"pump stable message"
		                ),
		                
		    "pac"=>array("up"=>"pac up message",
		                "down"=>"pac down message",
		                "stable"=>"pac stable message"
		                ),
		                
		    "treatment1"=>array("up"=>"treatment1 up message",
		                "down"=>"treatment1 down message",
		                "stable"=>"treatment1 stable message"
		                ),
		                
		    "treatment2"=>array("up"=>"treatment2 up message",
		                "down"=>"treatment2 down message",
		                "stable"=>"treatment2 stable message"
		                ),

		    "ph"=>array("up"=>"ph up message",
		                "down"=>"ph down message",
		                "stable"=>"ph stable message",
		                "high"=>"",
		                "low"=>"",
		                "correct"=>"",
		                ),
		                
		    "orp"=>array("up"=>"orp up message",
		                "down"=>"orp down message",
		                "stable"=>"orp stable message",
		                "high"=>"",
		                "low"=>"",
		                "correct"=>"",
		                ),             		    
		                
		    "temperature"=>array("up"=>"temperature up message",
		                "down"=>"temperature down message",
		                "stable"=>"temperature stable message",
		                "high"=>"",
		                "low"=>"",
		                "correct"=>"",
		                )
            );


$hint = array(
		    "pump"=>array("up"=>"pump up hint message",
		                "down"=>"pump down hint message",
		                "stable"=>"pump stable hint message"
		                ),
		                
		    "pac"=>array("up"=>"pac up hint message",
		                "down"=>"pac down hint message",
		                "stable"=>"pac stable hint message"
		                ),
		                
		    "treatment1"=>array("up"=>"treatment1 up hint message",
		                "down"=>"treatment1 down hint message",
		                "stable"=>"treatment1 stable hint message"
		                ),
		                
		    "treatment2"=>array("up"=>"treatment2 up hint message",
		                "down"=>"treatment2 down hint message",
		                "stable"=>"treatment2 stable hint message"
		                ),

		    "ph"=>array("up"=>"ph up hint message",
		                "down"=>"ph down hint message",
		                "stable"=>"ph stable hint message",
		                "high"=>"",
		                "low"=>"",
		                "correct"=>"",
		                ),
		                
		    "orp"=>array("up"=>"orp up hint message",
		                "down"=>"orp down hint message",
		                "stable"=>"orp stable hint message",
		                "high"=>"",
		                "low"=>"",
		                "correct"=>"",
		                ),             		    
		                
		    "temperature"=>array("up"=>"temperature up hint message",
		                "down"=>"temperature down hint message",
		                "stable"=>"temperature stable hint message",
		                "high"=>"",
		                "low"=>"",
		                "correct"=>"",
		                )
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

// use order by timeStamp to really get the last value but they are aggregated by day...
$sql = "select ".$_GET["graph"].",id, timeStamp from (select ".$_GET["graph"].", id, timeStamp from measures order by timeStamp desc limit ".intval($_GET["period"]).") tempTable order by timeStamp asc";
// use order by id for test purpose
// *******
//$sql = "select ".$_GET["graph"].",id, timeStamp from (select ".$_GET["graph"].", id, timeStamp from measures order by id desc limit ".intval($_GET["period"]).") tempTable order by id asc";
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
    $data[$row['timeStamp']] = $row[$_GET["graph"]];
    // ******* HOUR
    //$data[$hour] = $row[$_GET["graph"]];    
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
        $cfg['horizontal-divider-visible']=false;  
        $cfg['average-line-visible']=false;
        //$cfg['column-divider-visible']=false;
        $cfg['key-visible']=true;
    
        $graph->parseVerticalSimpleColumnGraph($data,$cfg);
    break;
    case "lineType":
        $cfg['key-visible']=true;
        $graph->parseVerticalLineGraph($data,$cfg);
    break;
    case "textType":
        $text.="\nLes stats sont effectuées sur la base de ".$_GET["period"];
        $values = array();
        foreach ($data as $value) {
            $values[] =  $value;
        }
        $trend=getTrend($values);
        $avg=array_sum($values) / count($values);
        $ratio=$trend/$avg;
        $threshold=0.005;

        $conclusion="stable";
        if ($ratio>$threshold) $conclusion="up";
        if ($ratio<-$threshold) $conclusion="down";

        $text.="\nTrend:".$trend;
        $text.="\naverage:".$avg;
        $text.="\nratio:".$ratio;
        $text.="\nconclusion:".$conclusion;
        
        $text.="\n".$analyse[$_GET["graph"]][$conclusion];        
    

        //print_r($data); echo "<br>"; print_r($values); echo "<br>".$text; exit;

    default:
        if ($text==null) $text="unknown or undefined graph type ".$_GET["type"];

        $im = imagecreate($cfg['width'], $cfg['height']);
        $backgroundColor = imagecolorallocate($im, 255, 255, 255);
        imagecolortransparent($img, $backgroundColor);

        $box = new Box($im);
        $box->setFontFace('./fonts/Roboto-Regular.ttf'); // http://www.dafont.com/franchise.font
        $box->setFontColor(new Color(0, 0, 0, 50));
        $box->setTextShadow(new Color(200, 200, 200), 2, 2);
        $box->setFontSize(15);
        $box->setBox(20, 20, 460, 460);
        $box->setTextAlign('left', 'top');
        $box->draw($text);
        
        header("Content-type: image/png");
        imagepng($im);

    break;    
}

?>