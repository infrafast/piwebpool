<?php
// invoke with
// action.php?action=changeState&pin=11&state=1
// action.php?action=updateSetting&id=actionTableCollapse&value=1
// action.php?action=resetSchedule
require_once('common.php');
require_once('luaContext.php');


$result['state']  = "undef";
$result['answer']  = 'OK';

function xml_encode($mixed,$domElement=null,$DOMDocument=null){
    if(is_null($DOMDocument)){
        $DOMDocument=new DOMDocument;
        $DOMDocument->formatOutput=true;
        xml_encode($mixed,$DOMDocument,$DOMDocument);
        echo $DOMDocument->saveXML();
    }
    else{
        if(is_array($mixed)){
            foreach($mixed as $index=>$mixedElement){
                if(is_int($index)){
                    if($index==0){
                        $node=$domElement;
                    }
                    else{
                        $node=$DOMDocument->createElement($domElement->tagName);
                        $domElement->parentNode->appendChild($node);
                    }
                }
                else{
                    $plural=$DOMDocument->createElement($index);
                    $domElement->appendChild($plural);
                    $node=$plural;
                    if(rtrim($index,'s')!==$index){
                        $singular=$DOMDocument->createElement(rtrim($index,'s'));
                        $plural->appendChild($singular);
                        $node=$singular;
                    }
                }
                xml_encode($mixedElement,$node,$DOMDocument);
            }
        }
        else{
            $domElement->appendChild($DOMDocument->createTextNode($mixed));
        }
    }
}



// actions compatibles WEB et PCLLINK
switch($_['action']){

// ACTION FOR PCLLINK (PURE JSON QUERY)
	case 'getTemp':
	    $result['state'] = getTemperature();
	    if  ($result['state']==false)  $result['state']="ERR";
	    //$result['state'] = getTemperature();   // no "" WORKS!!! 
        echo json_encode($result);
        exit;

// ACTION FOR WEBAPP (JSON QUERY UNDER BRACKET)

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
	case 'getTemperaturePCL':
	    $result['state'] = getTemperature();
	    if ($result['state']==false) $result['answer']="ERROR";
	    break;
	    
    case 'getORPPCL':
	case 'getORP':
	    $result['state'] = getORP();
	    if ($result['state']==false) $result['answer']="ERROR";
	    break;

	case 'getPh':
	case 'getPhPCL':
	    $result['state'] = getPh();
	    if ($result['state']==false) $result['answer']="ERROR";
	    break;
	
	case 'changeState':
	    if (intval($_['state'])<0 or intval($_['state'])>1 or intval($_['pin'])<1 or intval($_['pin'])>26){
	        $result['answer']  = 'ERROR';     
	        $result['state'] = " Bad parameter";
	    }else{
	        $result['state'] = setPinState($pins[$_['pin']],$_['state']);
	    }
	break;
	
	case 'getState':
	    if (intval($_['pin'])<1 or intval($_['pin'])>26){
	        $result['answer']  = "ERROR";
	        $result['state'] = 'Bad parameter';
	    }else{
	        $result['state'] = (getPinState($_['pin'],$pins)=='off'?false:true);
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
	    // no "action" parameter, do we have one from PCL?, we flag it as such for the JSON return value to be properly formatted
	    if (isset($_GET['SwitchFilterPCL'])){
	        $_['action'] = "PCL";
            setPinState($pins[$materials["filtration"]],$_GET['SwitchFilterPCL']);
            $result['state'] = getPin($pins[$materials["filtration"]]); //idem as getFilterStatePCL;
            print "Content-type: text/html\n";
            echo $result['state']; exit;
	    }else if (isset($_GET['switchTreatment1PCL'])){
	        $_['action'] = "PCL";
	    }else if (isset($_GET['getFilterStatePCL'])){
	        $_['action'] = "PCL";
	        $result['state']  = getPin($pins[$materials["filtration"]]); //getPin();
            print "Content-type: text/html\n";
            echo $result['state']; exit;
    	}else{    
        	$result['answer']  = "ERROR";
    		foreach($_ as $key=>$val){
            	$param.=" ".$key.":".$val;
            	$_[$key]=secure($val);
            }
    		$result['state'] = 'Undefined call '.$param;
	    }
	break;
}

$returnValue = json_encode($result);

// in case the action include keyword "PCL" it means we expect a standard json answer, without the ( )
if (strpos($_['action'], 'PCL') === false) {
    $returnValue = '('.$returnValue.')';
}
echo $returnValue;

?>