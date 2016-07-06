<?php
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
generate(24,7.31,7.30,300,300,$link,$materialsColumn,$materials,$pins);
//decrease

//stable

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
                
                $phValue=($phStep*$x)+$phv1;
                $phvalue= round( (($phvalue*0.7) + (($phvalue*1.5) - ($phvalue*0.7)) * (mt_rand() / mt_getrandmax())), 1, PHP_ROUND_HALF_UP);
                $orpValue=($orpStep*$x)+($orpv1+(rand(0,8)<3?0:intval(rand(-$orpValue*0.01,$orpValue*0.05))));
                
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
