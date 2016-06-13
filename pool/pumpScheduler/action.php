<?php
// invoke with
// action.php?action=changeState&pin=11&state=1
// action.php?action=updateSetting&id=actionTableCollapse&value=1
// action.php?action=resetSchedule
require_once('common.php');
require_once('luaContext.php');

$result['state']  = "undef";
$result['answer']  = 'OK';

switch($_['action']){
	case 'changeState':
	    if (intval($_['state'])<0 or intval($_['state'])>1 or $_['pin']!="Filtration" or $_['pin']!="Traitement"){
	        $result['answer']  = 'Bad parameter';     
	    }else  $result['state'] = setPinState($pins[$materials[$_['pin']]],$_['state']);
	break;

	case 'scenario':
	    $result['state'] = (setPinState($pins[$materials["Filtration"]],0));
	    sleep(1);
        $result['state'] = (setPinState($pins[$materials["Filtration"]],1));
	    sleep(1);
        $result['state'] = (setPinState($pins[$materials["Prise libre"]],0));
	    sleep(1);
        $result['state'] = (setPinState($pins[$materials["Prise libre"]],1));
	break;

	case 'getState':
	    if (intval($_['pin'])<1 or intval($_['pin'])>26){
	        $result['answer']  = "ERROR";
	        $result['state'] = 'Bad parameter';
	    }else  $result['state'] = (getPinState($_['pin'],$pins)=='off'?true:false);
	break;

    case 'resetSchedule':
        $result['state'] = "reset done";

        $dbms_schema='pumpSchedule.sql';

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

    case 'updateSetting':
        mysql_connect($options["database"]["host"],$options["database"]["username"],$options["database"]["password"]) or die('error connection');
        mysql_select_db($options["database"]["name"]) or die('error database selection');
        $query="UPDATE `settings` SET `value` = '".$_['value']."' WHERE `id`='".$_['id']."'";
        $outcome = mysql_query($query);
        if (!$outcome) {
             $result['answer']  = "ERROR";
             $result['state'] =  $query; /* mysql_error();*/
        }else{
            $result['state'] = $outcome;
        }       
        mysql_free_result($outcome);        
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

    case 'lua':
        $lua = getLua("luascripts/".$_['file'],$materials);
        $lua->run();
        break;

	default:
		$result['answer']  = "ERROR";
		$result['state'] = 'Undefined action '.$_['action'];
	break;
}

echo '('.json_encode($result).')';

?>