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

$phValue = 0;
$orpValue = 0;
$temperatureValue = 0;
$filterValue = 0;
$treatment1Value = 0;
$treatment2Value = 0;
$pacValue = 0;


// for domoticz

$sensorURL = "http://domoticz.infrafast.com/json.htm?type=command&param=udevice&idx=%i&nvalue=0&svalue=%v";
$actuatorURL = "http://domoticz.infrafast.com/json.htm?type=command&param=switchlight&idx=%i&switchcmd=%v";
$devices = array(
			27=>array(&$phValue,$sensorURL),
			28=>array(&$temperatureValue,$sensorURL),
			29=>array(&$orpValue,$sensorURL),
			30=>array(&$filterValue,$actuatorURL),
			31=>array(&$treatment1Value,$actuatorURL)
		);

//            $treatment2Value
//            $pacValue

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
                while ($row = mysql_fetch_assoc($result)) $luaCode=htmlspecialchars_decode(($row['lua']));
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
            //$result = mysql_query($sql, $link);
            if (!$result) {
                $answer.="+ERROR";
                $state.="+".mysql_error()." ".$sql;
            }
            
            // update  Domoticz JSON
            if(!function_exists("curl_init")) die("cURL extension is not installed");
            // url: $id[1] deviceID = $device value: $id[0]
            foreach($devices as $device=>$id){ 
                $jsonCall = str_replace("%i",$device,$id[1]);
                $jsonCall = str_replace("%v",$id[0],$jsonCall);
                $curl_options = array(
                                    CURLOPT_URL => $jsonCall,
                                    CURLOPT_HEADER => 1,
                                    CURLOPT_RETURNTRANSFER => TRUE,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_SSL_VERIFYPEER => 0,
                                    CURLOPT_FOLLOWLOCATION => TRUE,
                                    CURLOPT_ENCODING => 'gzip,deflate',
                                    CURLOPT_USERPWD, $username . ":" . $password                                    
                            );
                $ch = curl_init();
                curl_setopt_array( $ch, $curl_options );
                $output = curl_exec( $ch );
                curl_close($ch);
                $arr = json_decode($output,true);
                echo $output;
//                foreach($arr['status'] as $val)
//                {
//                        echo $val['thumbnailURL'].'<br>';       
//                }                 
            }
        }
    }
}
$state.="{periode:".$tw."}{temperature:".$temp."}{Filtration:".($pumpConsign=="1"?"MARCHE":"ARRET")."}{".$luaFeedback."}";    
appendlog("ACTIONS PERIODIQUES",$answer,$state, $logfilename);

// sync data to disk
exec("sync");

echo $answer.$state;
?>
