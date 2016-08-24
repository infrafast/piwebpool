<?php
/*
 @nom: graph 
 @auteur: piwebpool (info@infrafast.com)
 @description: draw measures and command graphs as well as text pictures
*/
//

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


function ecarttype($array, $nbdecimals=2) {
    if (is_array($array)){
        //moyenne des valeurs
        reset($array);
        $somme=0;
        $nbelement=count($array);
        foreach ($array as $value) {
            $somme += floatval($value);
        }
        $moyenne = $somme/$nbelement;
        //numerateur
        reset($array);
        $sigma=0;
        foreach ($array as $value) {
            $sigma += pow((floatval($value)-$moyenne),2);
        }
        //denominateur = $nbelement
        $ecarttype = sqrt($sigma/$nbelement);
        return number_format($ecarttype, $nbdecimals);
    }else{
        return false;
    }
}



function standard_deviation($aValues, $bSample = false)
{
    $fMean = array_sum($aValues) / count($aValues);
    $fVariance = 0.0;
    foreach ($aValues as $i)
    {
        $fVariance += pow($i - $fMean, 2);
    }
    $fVariance /= ( $bSample ? count($aValues) - 1 : count($aValues) );
    return (float) sqrt($fVariance);
}

//////////////////////////////////////////////////////


//if(!isset($_GET['text'])) $_GET['text'] = "Hello, world!";
//

$cfg['width'] = $_GET["width"] ;
$cfg['height'] = $_GET["height"];
$cfg['key-color'] = "ffffff";
$cfg['column-color'] = "00a2e8";
$cfg['value-label-color'] = "ffffff";
$cfg['average-line-color'] = "ffffff";
//$cfg['box-background-color'] = "ffffff";
$cfg['box-background-color'] = "444444";
//$cfg['background-color'] = "ffffff";
$cfg['background-color'] = "444444";
$cfg['box-border-visible']=false;
$cfg['title-color']="fffffff";
//keyvisible = affichage de l'echelle du temps

$text=null;


$hint = array(
		    "ph"=>array("up"=>array(
		                    "high"=>"Ph up high",
		                    "low"=>"Ph up low",
		                    "correct"=>"Ph up correct"),
		                "down"=>array(
		                    "high"=>"Ph down high",
		                    "low"=>"Ph down low",
		                    "correct"=>"Ph down correct"),
		                "stable"=>array(
		                    "high"=>"Ph stable high",
		                    "low"=>"Ph stable low",
		                    "correct"=>"Ph stable correct"),
		                "unstable"=>array(
		                    "high"=>"Ph unstable high",
		                    "low"=>"Ph unstable low",
		                    "correct"=>"Ph unstable correct"),		                    
                ),
		    "orp"=>array("up"=>array(
		                    "high"=>"orp up high",
		                    "low"=>"orp up low",
		                    "correct"=>"orp up correct"),
		                "down"=>array(
		                    "high"=>"orp down high",
		                    "low"=>"orp down low",
		                    "correct"=>"orp down correct"),
		                "stable"=>array(
		                    "high"=>"orp stable high",
		                    "low"=>"ph stable low",
		                    "correct"=>"orp stable correct"),
		                "unstable"=>array(
		                    "high"=>"orp unstable high",
		                    "low"=>"orp unstable low",
		                    "correct"=>"orp unstable correct"	),	                    
                    ),
		    "temperature"=>array("up"=>array(
	                                "high"=>"temperature up high",
	                                "low"=>"temperature up low",
	                                "correct"=>"temperature up correct"),
		                        "down"=>array(
		                            "high"=>"temperature down high",
		                            "low"=>"temperature down low",
		                            "correct"=>"temperature down correct"),
		                        "stable"=>array(
		                            "high"=>"temperature stable high",
		                            "low"=>"temperature stable low",
		                            "correct"=>"temperature stable correct"),
		                        "unstable"=>array(
		                            "high"=>"temperature unstable high",
		                            "low"=>"temperature unstable low",
		                            "correct"=>"temperature unstable correct"),			                            
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
    //$data[$row['timeStamp']] = $row[$_GET["graph"]];
    // ******* HOUR
    $data[$hour] = $row[$_GET["graph"]];    
   // echo "<br>".$row['timeStamp']." ". $row[$_GET["graph"]]." ".$hour;
}
//exit;

//extract parameters from db
$sql    = "SELECT id,value from settings;";
$result = mysql_query($sql, $link);
$parameter = array();
if (!$result) {
    echo mysql_error();
    exit;
}else{
    while ($row = mysql_fetch_assoc($result)) {
        $id=($row['id']);
        $value=($row['value']);
        $parameter[$id]=$value;
    }
}    
mysql_free_result($result);




header("Content-type: image/png");
//Create phpMyGraph instance
$graph = new phpMyGraph();
//Parse
switch ($_GET["type"]){
    case "barType":
        $cfg['label']=substr($_GET["title"],strpos($_GET["title"], "=")+1);
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
        switch ($_GET["period"]){
            case 8:
                $text.="Ces dernières 8 heures,";
            break;
            case 24:
                $text.="Au cours de cette dernière journée,";
            break;
            case 168:
                $text.="Sur la semaine,";
            break;
            default:
                $text.="Sur une periode de ".$_GET["period"]."heures,";
            break;
        }
        $values = array();
        foreach ($data as $value) {
            $values[] =  $value;
        }
        $trend=getTrend($values);
        $avg=array_sum($values) / count($values);

        $ratio=$trend/$avg;
        $threshold=0.005; //0.0002

        $trendIndicator="stable";
        if ($ratio>$threshold) $trendIndicator="up";
        if ($ratio<-$threshold) $trendIndicator="down";
        $deviation = ecarttype($values);
        $ratioDev=$deviation/$avg;
        if ($ratioDev>0.05) $trendIndicator="unstable";

        $reference=0;
        switch ($_GET["graph"]){
            case "ph":
                $reference=$parameter["PHConsign"];                
            break;
            case "orp";
                $reference=$parameter["ORPConsign"];as
                echo $reference;
                exit;
            break;
            case "temperature";
                $reference=$parameter["TEMPConsign"];
            break;
            default:
                // we have to interpret data for switch
                $periode = $_GET["period"];
                $runRatio = (array_sum($values) / $periode)*100;
                $text.="\nle dispositif à fonctionné ".$runRatio."% du temps";
            break;
        }

        $avg=($avg+$values[count($values)-1])/2;
        // we ponderate the average by re-avergaring with the last measure to make sure the instant value is not falsing the overall estimation
        $diffVal = $avg-$reference;
        $ecartVal = $diffVal/$reference;
        $currentValueIndicator = "correct"; 
        
        if ($ecartVal>0.09){ 
             $currentValueIndicator = "high";
        }else if ($ecartVal<-0.09){ 
             $currentValueIndicator = "low";
        }

        $text.="\n".$hint[$_GET["graph"]][$trendIndicator][$currentValueIndicator];
        $text.="\n\n\n\n\n\n";
        $text.="\nTrend:".$trend;
        $text.="\naverage:".$avg;
        $text.="\nratio:".$ratio;
        $text.="\ntrend:".$trendIndicator;
        $text.="\nvalue:".$currentValueIndicator;
        $text.="\navg:".$avg;
        $text.="\nreference:".$reference;
        $text.="\ndiffVal:".$diffVal;
        $text.="\necartVal:".$ecartVal;
        $text.="\ncurrentValueIndicator:".$currentValueIndicator;
        $text.="\ndeviation:".$deviation;
        $text.="\nratioDev:".$ratioDev;


        //print_r($data); echo "<br>"; print_r($values); echo "<br>".$text; exit;

    default:
        if ($text==null) $text="unknown or undefined graph type ".$_GET["type"];

        $im = imagecreate($cfg['width'], $cfg['height']);
        $backgroundColor = imagecolorallocate($im, 68, 68, 68);
        imagecolortransparent($img, $backgroundColor);

        $box = new Box($im);
        $box->setFontFace('./font/Roboto-Regular.ttf'); // http://www.dafont.com/franchise.font
        $box->setFontColor(new Color(255, 255, 255, 50));
        $box->setTextShadow(new Color(0, 0, 0), 2, 2);
        
        $box->setFontSize(19);
        $box->setBox(10, 10, 460, 460);
        $box->setTextAlign('left', 'top');
        $box->draw($text);
        
        header("Content-type: image/png");
        imagepng($im);

    break;    
}

?>