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

function getVal(){
	return intval(rand(0,1));
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
		$pinVal=getVal();
		
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

echo "\nph:".$phValue." ORP:".$orpValue." Temp:".$temperatureValue." pinVal:".$pinVal."\n";    

?>
