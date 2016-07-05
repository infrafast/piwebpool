<?php
// this script is to be executed periodically thru anacron by putting it to the hourly folder (or other means) at least every 2hours in order to query the
// scheduler table to switch the pump on/ff accordingly


// since this script can be called from CLI (thru crontab) check if the module exension Lua is loaded or force the load
//if (!extension_loaded('lua')) {
//    dl('lua.so');
//}
// otherwise run this script from cli as:
//php -dextension=lua.so cronaction.php
//

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

$answer="OK";
$state="";

// what time is it now?
$tw=getCurrentTimeWindow()."h";
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
    
    if (!setPinState($pins[$materials["filtration"]],$pumpConsign)){ 
        $answer.="+ERROR";
        $state.="+SetPinState";
    }else{
        $concat=array("header","footer");
        $i=0;
        foreach ($concat as $scriptID) {
            // fetch lua header and footer code
            // i.e. the run() and return
            $sql    = "SELECT lua from scripts where id='".$scriptID."'";
            $result = mysql_query($sql, $link);
            if (!$result) {
                $answer.="+ERROR";
                $state.="+".mysql_error();
            }else{
                while ($row = mysql_fetch_assoc($result)) $concat[$i++]=($row['lua']);
                mysql_free_result($result);
            }                
        }
        $luaFeedback="";
        foreach (array("main","custom") as $scriptID) {
            $luaFeedback.="|".$scriptID.":";
            // fetch lua code from database
            $sql    = "SELECT lua from scripts where id='".$scriptID."'";
            $result = mysql_query($sql, $link);
            if (!$result) {
                $answer.="+ERROR";
                $state.="+".mysql_error();
            }else{
                $luaCode="";
                while ($row = mysql_fetch_assoc($result)) $luaCode=($row['lua']);
                mysql_free_result($result);
            }
            // call lua execution built from Header + Content + Footer and passing the access to the pins so they can be manipulated by lua code
            goLua($concat[0].$luaCode.$concat[1],$materials,$pins,$luaFeedback);
        }
        
    }
    
    //get and update the index
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
            
            $phValue = getPh();
            $orpValue = getORP();
            $temperatureValue = getTemperature();
            if($phValue==null)  $phValue=-99;
            if($orpValue==null)  $orpValue=-99;
            if($temperatureValue==null)  $temperatureValue=-99;

            $sql = "INSERT INTO `measures` (`id`, `timestamp`, `orp`, `ph`, `temperature`";
            foreach($materials as $material=>$pin) $sql = $sql.", `".$materialsColumn[$material]."`";
            $sql = $sql.") VALUES ('".$measureIndex."', CURRENT_TIMESTAMP,'".$orpValue."', '".$phValue."', '".$temperatureValue."'";
            foreach($materials as $material=>$pin) $sql = $sql.", '".getPin($pins[$materials[$material]])."'";
            $sql = $sql.") ON DUPLICATE KEY UPDATE id=".$measureIndex.", orp=".$orpValue.", ph=".$phValue.", temperature=".$temperatureValue.", timestamp=CURRENT_TIME";
            foreach($materials as $material=>$pin) $sql = $sql.", ".$materialsColumn[$material]."=".getPin($pins[$materials[$material]]);
            $sql = $sql.";";

            $result = mysql_query($sql, $link);
            if (!$result) {
                $answer.="+ERROR";
                $state.="+".mysql_error()." ".$sql;
            }            
        }
    }
}
$state.="{Heure:".$tw."}{temperature:".$temp."}{Filtration:".($pumpConsign=="1"?"MARCHE":"ARRET")."}{".$luaFeedback."}";    
appendlog("CRONACTION",$answer,$state, $logfilename);

// sync data to disk
exec("sync");

echo $answer.$state;
?>
