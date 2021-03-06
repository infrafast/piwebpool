<?php
/*
 @nom: cronaction 
 @auteur: piwebpool (info@infrafast.com)
 @description: periodic actions to be executed
*/
//
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

$phValue = 0;
$orpValue = 0;
$temperatureValue = 0;
$filterValue = 0;
$treatment1Value = 0;
$treatment2Value = 0;
$pacValue = 0;

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
///////////////////////////////////////////////////////////////
// IS THE SCHEDULER ACTIVE?
///////////////////////////////////////////////////////////////
$sql    = "SELECT value FROM settings where id='scheduler'";
$result = mysql_query($sql, $link);
$schedulerOn="on";    
if (!$result) {
    $answer="ERROR";
    $state=mysql_error();
}else{
    while ($row = mysql_fetch_assoc($result)) {
        $schedulerOn=($row['value']);
    }
}
mysql_free_result($result);
///////////////////////////////////////////////////////////////
// SET THE PUMP ACCORDING TO SCHEDULER
///////////////////////////////////////////////////////////////
if ($schedulerOn!="off"){
    // what time is it now?
    $tw=getCurrentTimeWindow()."h";
    // what is the temperature range
    $temp=getPoolTemperature();    
    $sql    = "SELECT ".$temp." FROM pumpSchedule where timeWindow='".$tw."'";
    $result = mysql_query($sql, $link);
    $pumpConsign=0;
    if (!$result) {
        $answer="ERROR";
        $state=mysql_error();
    }else{
        while ($row = mysql_fetch_assoc($result)) {
            $pumpConsign=($row[$temp]);
        }
    }
    mysql_free_result($result);    
    if (!setPinState($pins[$materials["filtration"]],$pumpConsign)){ 
        $answer.="+ERROR";
        $state.="+SetPinState";
    }
    $state.="{Periode:".$tw.", Temperature:".$temp.", Consigne filtration:".($pumpConsign=="1"?"On":"Off")."}";    
}else{
    $state.="{Scheduler désactivé}";    
}
///////////////////////////////////////////////////////////////
// EXECUTE LUA SCRIPTS
///////////////////////////////////////////////////////////////
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
        while ($row = mysql_fetch_assoc($result)) $luaCode=htmlspecialchars_decode(($row['lua']));
        mysql_free_result($result);
    }
    // call lua execution built from Header + Content + Footer and passing the access to the pins so they can be manipulated by lua code
    goLua($concat[0].$luaCode.$concat[1],$materials,$pins,$luaFeedback,$link,$scriptID);
}
///////////////////////////////////////////////////////////////
// UPDATE MEASURE TABLE BASED ON INDEX
///////////////////////////////////////////////////////////////
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
        $filterValue = (getPin($pins[$materials["filtration"]]))=="1"?"Off":"On";
        $treatment1Value = (getPin($pins[$materials["traitement1"]]))=="1"?"Off":"On";
        $treatment2Value = (getPin($pins[$materials["traitement2"]]))=="1"?"Off":"On";
        $pacValue = (getPin($pins[$materials["pac"]]))=="1"?"Off":"On";
        // ---------------------------------------------------
        if($phValue==null)  $phValue=-99;
        if($orpValue==null)  $orpValue=-99;
        if($temperatureValue==null)  $temperatureValue=-99;
        // ---------------------------------------------------
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

$state.="{".$luaFeedback."}";    
appendlog("ACTIONS PERIODIQUES",$answer,$state, $logfilename);

// sync data to disk
exec("sync");

echo $answer.$state;
?>
