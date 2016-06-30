<?php

include_once('include/phpMyGraph5.0.php'); 
require('configuration.php');

//if(!isset($_GET['text'])) $_GET['text'] = "Hello, world!";


$cfg['width'] = $_GET["width"] ;
$cfg['height'] = $_GET["height"];
$cfg['key-color'] = "00a2e8";
$cfg['column-color'] = "00a2e8";
$cfg['value-label-color'] = "000000";
$cfg['background-color'] = "f0f0f0";
//keyvisible = affichage de l'echelle du temps

$text_string=null;

$hint = array(
			"pump"=>array("pump message1","pump message 2"),
			"pac"=>array("PAC message1","PAC message 2"),
		    "treatment1"=>array("treatment1 message1","treatment1 message 2"),
    	    "treatment2"=>array("treatment2 message1","treatment2 message 2"),
		    "ph"=>array("ph message1","ph message 2"),
		    "orp"=>array("orp message1","orp message 2"),              		    
		    "temperature"=>array("temperature message1","temperature message 2")                
                );



function calculateTextBox($text,$fontFile,$fontSize,$fontAngle) {
    /************
    simple function that calculates the *exact* bounding box (single pixel precision).
    The function returns an associative array with these keys:
    left, top:  coordinates you will pass to imagettftext
    width, height: dimension of the image you have to create
    *************/
    $rect = imagettfbbox($fontSize,$fontAngle,$fontFile,$text);
    $minX = min(array($rect[0],$rect[2],$rect[4],$rect[6]));
    $maxX = max(array($rect[0],$rect[2],$rect[4],$rect[6]));
    $minY = min(array($rect[1],$rect[3],$rect[5],$rect[7]));
    $maxY = max(array($rect[1],$rect[3],$rect[5],$rect[7]));
   
    return array(
     "left"   => abs($minX) - 1,
     "top"    => abs($minY) - 1,
     "width"  => $maxX - $minX,
     "height" => $maxY - $minY,
     "box"    => $rect
    );
} 


// STARTS HERE


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
        $text_string=$hint[$_GET["graph"]][0];
        $text_string.="\nLes stats sont effectuées sur la base de ".$_GET["period"];
        // treat message in function (periode). ex: forecast
    default:
        if ($text_string==null) $text_string="unknown or undefined graph type ".$_GET["type"];
        $font_ttf = "./fonts/arial.ttf"; 
        $font_size = 22; 
        $text_angle        = 0; 
        $text_padding    = 10; // Img padding - around text 
        
        $the_box        = calculateTextBox($text_string, $font_ttf, $font_size, $text_angle); 
        
        $imgWidth    = $the_box["width"] + $text_padding; 
        $imgHeight    = $the_box["height"] + $text_padding; 
        
        $image = imagecreate($imgWidth,$imgHeight); 
        imagefill($image, imagecolorallocate($image,200,200,200)); 
        
        $color = imagecolorallocate($image,0,0,0); 
        imagettftext($image, 
            $font_size, 
            $text_angle, 
            $the_box["left"] + ($imgWidth / 2) - ($the_box["width"] / 2), 
            $the_box["top"] + ($imgHeight / 2) - ($the_box["height"] / 2), 
            $color, 
            $font_ttf, 
            $text_string); 
        
        header("Content-Type: image/gif"); 
        imagegif($image); 
        imagedestroy($image);
            
        

    break;    
}

?>