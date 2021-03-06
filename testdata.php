<?php
/*
 @nom: testdata 
 @auteur: piwebpool (info@infrafast.com)
 @description: generate some data in tables for test purpose only, non productive use
*/
//
require_once('configuration.php');
require_once('functions.php');

// connect to the database
if (!$link = mysql_connect($options["database"]["host"], $options["database"]["username"], $options["database"]["password"])) {
    echo 'Could not connect to mysql';
    exit;
}

if (!mysql_select_db($options["database"]["name"], $link)) {
    echo 'Could not select database';
    exit;
} 

//increase
//generate(168,1.01,3.01,1,300,$link,$materialsColumn,$materials,$pins);
//generate(168,6.9,7,680,720,$link,$materialsColumn,$materials,$pins);
//generate(168,7.6,8,780,800,$link,$materialsColumn,$materials,$pins);
//decrease
//generate(168,3.01,1.01,500,300,$link,$materialsColumn,$materials,$pins);
//generate(168,7.2,7,700,720,$link,$materialsColumn,$materials,$pins);
//generate(168,8,7.9,900,800,$link,$materialsColumn,$materials,$pins);
//stable
//generate(168,6.5,6.5,600,600,$link,$materialsColumn,$materials,$pins);
generate(168,12.2,12.2,700,700,$link,$materialsColumn,$materials,$pins);
//generate(168,8.5,8.5,980,950,$link,$materialsColumn,$materials,$pins);
//histeresis

//peak



//waves



function generate($period,$phv1,$phv2,$orpv1,$orpv2,$link,$materialsColumn,$materials,$pins){
    $phStep = ($phv2 - $phv1)/$period;
    $phValue = $phv1;
    $orpStep = ($orpv2 - $orpv1)/$period;
    $orpValue = $orpv1;
    
    for ($x = 0; $x <= $period; $x++) {
        $sql    = "SELECT value from settings where id='measureIndex';";
        $result = mysql_query($sql, $link);
        
        if (!$result) {
                echo "failed query index"; exit;
        }else{
            while ($row = mysql_fetch_assoc($result)) {
                $measureIndex=($row['value']);
            }    
            mysql_free_result($result);
            $measureIndex=$measureIndex+1;
            if ($measureIndex>168) $measureIndex=0;
            $sql="UPDATE settings SET value=".$measureIndex." WHERE id='measureIndex'";
            $result = mysql_query($sql, $link);
            if (!$result) {
                echo mysql_error(); exit;
            }else{
                
                $phValue=round(($phStep*$x)+$phv1+(rand(0,20)/100),2);
                $orpValue=($orpStep*$x)+$orpv1+rand(0,10);
                
                $temperatureValue = getTemperature();
        		$pinVal=intval(rand(0,1));
        		
                $sql = "INSERT INTO `measures` (`id`, `timestamp`, `orp`, `ph`, `temperature`";
                foreach($materials as $material=>$pin) $sql = $sql.", `".$materialsColumn[$material]."`";
                $sql = $sql.") VALUES ('".$measureIndex."', CURRENT_TIMESTAMP,'".$orpValue."', '".$phValue."', '".$temperatureValue."'";
                foreach($materials as $material=>$pin) $sql = $sql.", '".$pinVal."'";
                $sql = $sql.") ON DUPLICATE KEY UPDATE id=".$measureIndex.", orp=".$orpValue.", ph=".$phValue.", temperature=".$temperatureValue.", timestamp=CURRENT_TIME";
                foreach($materials as $material=>$pin) $sql = $sql.", ".$materialsColumn[$material]."=".$pinVal;
                $sql = $sql.";";
        
                $result = mysql_query($sql, $link);
                if (!$result) {
                    echo "error".mysql_error()." ".$sql; exit;
                }            
            }
        }
        echo "\n".$x."/".$measureIndex." ph:".$phValue." ORP:".$orpValue." Temp:".$temperatureValue." pinVal:".$pinVal."\n";    
        sleep(1);
    }
}
?>
