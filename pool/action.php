<?php
// invoke with
// action.php?action=changeState&pin=11&state=1
// action.php?action=updateSetting&id=actionTableCollapse&value=1
// action.php?action=resetSchedule
//
require_once('common.php');
require_once('luaContext.php');

$result = array('state'=>'undef', 'answer'=>'OK');

$param="";
foreach($_ as $key=>$val){
	$param.=" ".$key."=".$val;
	$_[$key]=secure($val);
}

//appendlog("graph.php",$param,"");

function getState($_, $materials,&$result){
    if(isset($_['material'])){
        $material=$_['material'];
        if (array_key_exists($material, $materials)){    	    
            $result['state'] = (getPin($pins[$materials[$materials]])=='off'?false:true);
        }else{
            $result['state'] = "ERROR";
            $result['state'] = "undefined material:".$material;
        }   
    }else{
        $result['state'] = "ERROR";
        $result['state'] = "parameter material missing";
    }  
}

function changeState(){
    
    
}




if(isset($_['action'])){
    switch($_['action']){
    
    // ACTION FOR WEBAPP and PLCLINK (JSON QUERY UNDER BRACKET)
        case 'calibrate':
            switch($_['id']){
                case 'Ph':
                    readSensor(getDevice("ph"),"Cal,clear\n");
                    readSensor(getDevice("ph"),"Cal,mid,7.00\n");
                    $result['state']  = "done";
                break;
                case 'ORP':
                    readSensor(getDevice("ph"),"Cal,clear\n");
                    readSensor(getDevice("ph"),"Cal,650\n");
                    $result['state']  = "done";
                break;
                case 'temp':
                    // not implemented yet
                    $result['state']  = "done";
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
    	case 'getTemperaturePLC':
    	    $result['state'] = getTemperature();
    	    if ($result['state']==false){
    	        $result['answer']="ERROR";
    	        $result['state']="indispo ";
    	    }
    	    break;
    	    
        case 'getORPPLC':
    	case 'getORP':
    	    $result['state'] = getORP();
    	    if ($result['state']==false){
    	        $result['answer']="ERROR";
    	        $result['state']="indispo ";
    	    }
    	    break;
    
    	case 'getPh':
    	case 'getPhPLC':
    	    $result['state'] = getPh();
    	    if ($result['state']==false){
    	        $result['answer']="ERROR";
    	        $result['state']="indispo ";
    	    }
    	    break;
    	
    	case 'getState':
            getState($_,$result);
    	break;
    
    	case 'changeState':
    	    if (array_key_exists($_['material'], $materials)){
    	        if ($_['state']=="0" || $_['state']=="1"){ 
            	    $result['state'] = setPinState($pins[$materials[$_['material']]],$_['state']);
    	        }else{
        	        $result['state'] = "ERROR";
                    $result['state'] = "bad or missing parameter 'state':".$_['state'];   
    	        }
    	    }else{
    	        $result['state'] = "ERROR";
                $result['state'] = "bad or missing parameter 'material':".$_['material'];
    	    }
    	break;    
    
    
    	case 'getLog':
            $result['state'] = getLog($logfilename);
    	break;
    
        case 'resetSchedule':
            $result['state'] = "reset done";
    
            $dbms_schema='settings.sql';
    
            mysql_connect($options["database"]["host"],$options["database"]["username"],$options["database"]["password"]) or die('error connection');
            mysql_select_db($options["database"]["name"]) or die('error database selection');
      
            $sql_query = @fread(@fopen($dbms_schema, 'r'), @filesize($dbms_schema)) or die('problem ');
            $sql_query = remove_remarks($sql_query);
            $sql_query = split_sql_file($sql_query, ';');
            
            foreach($sql_query as $sql){ 
                $outcome=mysql_query($sql);
                if (!$outcome){
                    $result['answer'] = "ERROR";
                    $result['state'] = mysql_error();
                }
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
            $query="UPDATE `scripts` SET `xml` = '".mysql_real_escape_string(htmlspecialchars_decode($_['xml']))."',`lua`='".mysql_real_escape_string(htmlspecialchars_decode($_['lua']))."' WHERE `id`='".$_['id']."'";
            $outcome = mysql_query($query);
            if (!$outcome) {
                 $result['answer']  = "ERROR";
                 $result['state'] =  mysql_error(); /* mysql_error();*/
            }else{
                $result['state'] = $outcome;
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
            $result['state'] = shell_exec('./hourlycrontab.sh');
            // not a good solution as it will be executed by apache with no write access to the logs
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
///////////////////////////////// PLC COMMANDS STARTS HERE /////////////////////////////////////    
////////// SET
}else if (isset($_GET['SwitchFilterPLC'])){
    setPinState($pins[$materials["filtration"]],$_GET['SwitchFilterPLC']);
    $result['state'] = getPin($pins[$materials["filtration"]]);
}else if (isset($_GET['SwitchTreatment1PLC'])){
    setPinState($pins[$materials["filtration"]],$_GET['SwitchTreatment1PLC']);
    $result['state'] = getPin($pins[$materials["traitement1"]]);
////////// GET
}else if (isset($_GET['getStatePLC'])){
    $material = $_GET['getStatePLC'];
    $result['state'] = getPin($pins[$materials[$material]]);
}else{   
	$result['answer']  = "ERROR";
	$result['state'] = 'Undefined call '.$param;
}

$returnValue = json_encode($result);
// in case the action include keyword "PCL" it means we expect a standard json answer, without the ( )
if (strpos($param, 'PLC') === false) {
    $returnValue = '('.$returnValue.')';
}
//header('Content-Type: application/json');
echo $returnValue;
?>