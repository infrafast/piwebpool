<?php
// this script is to be executed periodically thru anacron by putting it to the hourly folder (or other means) at least every 2hours in order to query the
// scheduler table to switch the pump on/ff accordingly


// since this script can be called from CLI (thru crontab) check if the module exension Lua is loaded or force the load
//if (!extension_loaded('lua')) {
//    dl('lua.so');
//}
// otherwise run this script from cli as:
//php -dextension=lua.so cronaction.php


require_once('configuration.php');
require_once('functions.php');
require_once('luaContext.php');

// connect to the database
if (!$link = mysql_connect($options["database"]["host"], $options["database"]["username"], $options["database"]["password"])) {
    echo 'Could not connect to mysql';
    exit;
}

if (!mysql_select_db($options["database"]["name"], $link)) {
    echo 'Could not select database';
    exit;
} 

// what time is it now?
$tw=getCurrentTimeWindow();
// what is the temperature
$temp=getPoolTemperature();

//treat the case when the tw and temp are forced by user thru the GUI
//in that case override the value here by these value
//ensure the out of range is captured on client side
//then treat the case where tw and temperature are out of range
//e.g.: either get defaut values or raise email error notification
//this would then capture the out of range above

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
    // treat error case of unfound timewindow in the table
    //if ($pumpConsign="")
    
    mysql_free_result($result);
    
    $answer="OK";
    if (!setPinState($pins[$materials["filtration"]],$pumpConsign)){ 
        $answer="ERROR";
        $state="SetPinState";
    }else{
        $concat=array("header","footer");
        $i=0;
        foreach ($concat as $scriptID) {
            // fetch lua header and footer code
            // i.e. the run() and return
            $sql    = "SELECT lua from scripts where id='".$scriptID."'";
            $result = mysql_query($sql, $link);
            if (!$result) {
                $answer="ERROR";
                $state=mysql_error();
            }else{
                while ($row = mysql_fetch_assoc($result)) $concat[$i++]=($row['lua']);
                mysql_free_result($result);
            }                
        }
        $luaFeedback="";
        foreach (array("main","custom") as $scriptID) {
            // fetch lua code from database
            $sql    = "SELECT lua from scripts where id='".$scriptID."'";
            $result = mysql_query($sql, $link);
            if (!$result) {
                $answer="ERROR";
                $state=mysql_error();
            }else{
                $luaCode="";
                while ($row = mysql_fetch_assoc($result)) $luaCode=($row['lua']);
                mysql_free_result($result);
            }
            // call lua execution built from Header + Content + Footer and passing the access to the pins so they can be manipulated by lua code
            $lua = goLua($concat[0].$luaCode.$concat[1],$materials,$pins,$luaFeedback);                
        }
        
    }
    
    //get and update the index
    $sql    = "SELECT value from settings where id='measureIndex';";
    $result = mysql_query($sql, $link);
    
    if (!$result) {
        $answer="ERROR";
        $state=mysql_error();
    }else{
        while ($row = mysql_fetch_assoc($result)) {
            $measureIndex=($row['value']);
        }    
        mysql_free_result($result);
        
        $phValue = getPh();
        $orpValue = getORP();
        $treatmentValue = getPin($pins[$materials["traitement"]]);
        $pumpValue = getPin($pins[$materials["filtration"]]);
        $temperatureValue = getTemperature();
        $measureIndex=$measureIndex+1;
        if ($measureIndex>168) $measureIndex=0;
            
        $sql="UPDATE settings SET value=".$measureIndex." WHERE id='measureIndex'";
        $result = mysql_query($sql, $link);
        
        if (!$result) {
            $answer="ERROR";
            $state=mysql_error();
        }else{
            $sql    = "INSERT INTO `measures` (`id`, `timestamp`, `orp`, `ph`, `temperature`,`pump`,`treatment` ) VALUES ('".$measureIndex."', CURRENT_TIMESTAMP,'".$orpValue."', '".$phValue."', '".$temperatureValue."', '".$treatmentValue."', '".$pumpValue."') ON DUPLICATE KEY UPDATE id=".$measureIndex.", orp=".$orpValue.", ph=".$phValue.", temperature=".$temperatureValue.", timestamp=CURRENT_TIME".", pump=".$pumpValue.", treatment=".$treatmentValue.";";
            $result = mysql_query($sql, $link);
            if (!$result) {
                $answer="ERROR";
                $state=mysql_error()." ".$sql;
            }            
        }
    }
}
if ($answer=="OK")
    //$state = "{Heure:".$tw."}{temperature:".$temp."}{Filtration:".$pins[$materials["filtration"]]." ".$pumpConsign."}{Lua:".$luaFeedback."}";
    $state = "{Heure:".$tw."}{temperature:".$temp."}{Filtration:".($pumpConsign=="1"?"MARCHE":"ARRET")."}{Programme:".$luaFeedback."}";    
appendlog("CRONACTION",$answer,$state, $logfilename);

// sync data to disk
exec("sync");

// purge logfile
$lines = file($logfilename);
$nLine = count($lines);
if ($nLine>176){
    $X = 8; // Number of lines to remove
    $first_line = $lines[0];
    $lines = array_slice($lines, $X + 2);
    $lines = array_merge(array($first_line, "\n"), $lines);
    // Write to file
    $file = fopen($logfilename, 'w');
    fwrite($file, implode('', $lines));
    fclose($file);
}


echo $answer.$state;
?>
