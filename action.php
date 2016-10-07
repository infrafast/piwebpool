<?php
/*
 @nom: action 
 @auteur: piwebpool (info@infrafast.com)
 @description: execute all actions from the web GUI
*/
//

// invoke with
// action.php?action=changeState&pin=11&state=1
// action.php?action=updateSetting&id=actionTableCollapse&value=1
// action.php?action=resetSchedule
//etc..

require_once('common.php');
require_once('luaContext.php');

$result = array('state'=>'undef', 'answer'=>'OK');

//appendlog("graph.php",$params,"");

if(isset($_['action'])){
    switch($_['action']){
    // ACTION FOR WEBAPP and PLCLINK (JSON QUERY UNDER BRACKET)
        case 'calibrate':
            switch($_['id']){
                case 'Ph':
                    if (!isset($_['value'])) $_['value']="7.00";
                    readSensor(getDevice("ph"),"Cal,clear\n");
                    $frame="Cal,mid,".$_['value']."\n";
                    $result['state']  = readSensor(getDevice("ph"),$frame);
                    appendlog("CALIBRATE",$frame,$result);
                break;
                case 'ORP':
                    if (!isset($_['value'])) $_['value']="650";
                    readSensor(getDevice("ph"),"Cal,clear\n");
                    $frame ="Cal,".$_['value']."\n";
                    readSensor(getDevice("ph"),$frame);
                    $result['state']  = readSensor(getDevice("ph"),$frame);
                    appendlog("CALIBRATE",$frame,$result);
                break;
                case 'Temp':
                    $deltaTemp = "incorrect";
                    if (isset($_['value'])){
                        $deltaTemp = getTemperature() - $_['value'];

                        mysql_connect($options["database"]["host"],$options["database"]["username"],$options["database"]["password"]) or die('error connection');
                        mysql_select_db($options["database"]["name"]) or die('error database selection');
                        // in case of duplicate, simply erase
                        $query="INSERT INTO `settings` (`id`, `value`, `userSetting`, `description`) VALUES ('tempOffset', '".$material."', '".$valueOn."', '".$valueOff."') ON DUPLICATE KEY UPDATE url='".$url."',material='".$material."',valueOn='".$valueOn."',valueOff='".$valueOff."'";
                        $outcome = mysql_query($query);
                        //appendlog("registerMaterialURLCallBack",$query,$outcome);
                        if (!$outcome) return false; else return true;

                    }
                    else{
                        $result['answer']="ERROR";
                        $result['state']  = "Valeur incorrecte ou indéfinie";
                    }
                    appendlog("CALIBRATE",$deltaTemp,$result);
                break;
            	default:
            	     $result['answer']="ERROR";
            	     $result['state']="unknown device ".$_['id'];
            	break;            
            }
        break;
        
        case 'sms':
                if (!sms($_['message'])){
                    $result['answer']="ERROR";
                }
            break;
    
    	case 'getTemperature':
    	//case 'getTemperaturePLC':
    	    $result['state'] = getTemperature();
    	    if ($result['state']==false){
    	        $result['answer']="ERROR";
    	        $result['state']="indispo ";
    	    }
    	    break;
    	    
        //case 'getORPPLC':
    	case 'getORP':
    	    $result['state'] = getORP();
    	    if ($result['state']==false){
    	        $result['answer']="ERROR";
    	        $result['state']="indispo ";
    	    }
    	    break;
    
    	case 'getPh':
    	//case 'getPhPLC':
    	    $result['state'] = getPh();
    	    if ($result['state']==false){
    	        $result['answer']="ERROR";
    	        $result['state']="indispo ";
    	    }
    	    break;
    	
    	case 'getLog':
            $result['state'] = getLog($logfilename);
    	break;
    
        case 'sql':

            if(isset($_['script'])){
                $result['state'] = "OK";
                $dbms_schema="scripts/".$_['script'];
                mysql_connect($options["database"]["host"],$options["database"]["username"],$options["database"]["password"]) or die('error connection');
                mysql_select_db($options["database"]["name"]) or die('error database selection');
          
                $sql_query = @fread(@fopen($dbms_schema, 'r'), @filesize($dbms_schema)) or die("could not process ".$dbms_schema);
                $sql_query = remove_remarks($sql_query);
                $sql_query = split_sql_file($sql_query, ';');
                
                foreach($sql_query as $sql){ 
                    $outcome=mysql_query($sql);
                    if (!$outcome){
                        $result['answer'] = "ERROR";
                        $result['state'] = mysql_error();
                    }
                }
            }else{
                $result['answer'] = "ERROR";
                $result['state'] = "missing script parameter";
            }
        break;
    
        // restore the  code from db to blockly thru ajax call
        case 'getScript':
            mysql_connect($options["database"]["host"],$options["database"]["username"],$options["database"]["password"]) or die('error connection');
            mysql_select_db($options["database"]["name"]) or die('error database selection');
            $query="select `".$_['code']."` from `scripts` WHERE `id`='".$_['id']."'";
            $outcome = mysql_query($query);
            if (!$outcome) {
                 $result['answer']  = "ERROR";
                 $result['state'] =  $query; /* mysql_error();*/
            }else{
                while ($row = mysql_fetch_assoc($outcome)) {
                    // decode special caharacter like accent so they are sent back in the correct text format
                    $result['state']=html_entity_decode(($row[$_['code']])); 
                }
                // result return "undef" in state in case no data match
                mysql_free_result($outcome);
            }     
            mysql_free_result($outcome);
        break;  
        
        // store the xml and lua code generated by blockly
        // we use htmlspecialchars_decode to avoid encoding html special char like < > to &lt and &gt 
        // which would avoid the xml script being interpreted correctly when sent back to blockly via DOM
        case 'updateScript':
            mysql_connect($options["database"]["host"],$options["database"]["username"],$options["database"]["password"]) or die('error connection');
            mysql_select_db($options["database"]["name"]) or die('error database selection');
            $cleanLuaCode=mysql_real_escape_string(htmlspecialchars_decode($_['lua']));
            $cleanXMLCode=mysql_real_escape_string(htmlspecialchars_decode($_['xml']));
            $query="UPDATE `scripts` SET `xml` = '".$cleanXMLCode."',`lua`='".$cleanLuaCode."' WHERE `id`='".$_['id']."'";
            //appendlualog($cleanLuaCode);
            
            $outcome = mysql_query($query);
            if (!$outcome) {
                 $result['answer']  = "ERROR";
                 $result['state'] =  mysql_error(); /* mysql_error();*/
            }else{
                $result['state'] = "Sauvegarde effectuée";
            }       
            mysql_free_result($outcome);
        break;        
    
        
        case 'updateSetting':
            mysql_connect($options["database"]["host"],$options["database"]["username"],$options["database"]["password"]) or die('error connection');
            mysql_select_db($options["database"]["name"]) or die('error database selection');
            $query="UPDATE `settings` SET `value` = '".$_['value']."' WHERE `id`='".$_['id']."'";
            $outcome = mysql_query($query);
            if (!$outcome) {
                 $result['answer']  = "ERROR";
                 $result['state'] = mysql_error(); /* mysql_error();*/
            }else{
                $result['state'] = $outcome;
            }       
            //mysql_free_result($outcome);
        break;
        
        case 'getSetting':
            mysql_connect($options["database"]["host"],$options["database"]["username"],$options["database"]["password"]) or die('error connection');
            mysql_select_db($options["database"]["name"]) or die('error database selection');
            $query="SELECT value FROM `settings` WHERE id='".$_['id']."'";
            $outcome = mysql_query($query);
            if (!$outcome) {
                 $result['answer']  = "ERROR";
                 $result['state'] =  mysql_error();
            }else{
                while ($row = mysql_fetch_assoc($outcome)) {
                    $result['state']=($row['value']); 
                }
                // result return "undef" in state in case no data match
                mysql_free_result($outcome);
            }
            break;        
            
        case 'forceCron':
            $result['state'] = shell_exec('./scripts/hourlypiwebpool.sh');
            // not a good solution as it will be executed by apache with no write access to the logs
            // for strange reason this also return {|main:Runtime error|custom:Runtime error}]  in the log
            // we'd better call the code of cronaction.php here
            break;
    
        case 'run':

            break;    
    
        case 'lua':
            $result['state']='';
           if (!goLua("function run() return 'lua works!'; end",$materials,$pins,$result['state'])) $result['answer']  = "ERROR";
           break;
    
    	default:
    	    $result['answer']  = "ERROR";
            $result['state'] = "undefined action: ".$_['action'];
    	break;
    }
}else if (isset($_['getState'])){
    $material=$_['getState'];
    if (array_key_exists($material, $materials)){    	    
        $result['state'] = getPin($pins[$materials[$material]]);
    }else{
        $result['state'] = "ERROR";
        $result['state'] = "undefined material:".$material;
    }   
}else{   
    // finally, do we have to execute a material type command
	$result['answer']  = "ERROR";
	$result['state'] = 'Undefined call '.$params;
    foreach($materials as $material=>$pin){
        if (isset($_[$material])){
            setPinState($pins[$materials[$material]],$_[$material]);
            $result['state'] = getPin($pins[$materials[$material]]);
            $result['answer']  = "OK";
            break;
        }
    }
}

$returnValue = json_encode($result);
// in case the action include extendedJson it means we expect a standard json answer, without the ( )
if (isset($_['extendedJson'])) {
    $returnValue = '('.$returnValue.')';
}
//header('Content-Type: application/json');
echo $returnValue;
?>