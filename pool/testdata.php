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
generate(24,1,3,0.3,1,300,10);
//decrease

//stable

//histeresis

//peak

//waves



function generate($period,$phv1,$phv2,$phnoise,$orpv1,$orpv2,$orpnoise){
    $phStep = ($phv2 - $phv1)/$period;
    $phvalue = $phv1;
    $orpStep = ($orpv2 - $orpv1)/$period;
    $orpValue = $orpv1;
    
    for ($x = 0; $x <= $period; $x++) {
        $sql    = "SELECT value from settings where id='measureIndex';";
        $result = mysql_query($sql, $link);
        
        if (!$result) {
            $answer.="+ERROR";
            $state.="+".mysql_error();
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
                $answer.="+ERROR";
                $state.="+".mysql_error();
            }else{
                
                $phValue+=$phStep+round( (0.0 + ($phnoise - 0.0) * (mt_rand() / mt_getrandmax())), 1, PHP_ROUND_HALF_UP);;
                $orpValue.=$orpStep+intval(rand(0,$orpnoise));
                
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
                    $answer.="+ERROR";
                    $state.="+".mysql_error()." ".$sql;
                }            
            }
        }
        echo "\n".$x."/".$measureIndex." ph:".$phValue." ORP:".$orpValue." Temp:".$temperatureValue." pinVal:".$pinVal."\n";    
        sleep(1);
    }
}
?>
