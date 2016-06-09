<?php
// invoke with action.php?action=changeState&pin=11&state=1

require_once('common.php');

$result['state']  = "undef";
$result['answer']  = 'OK';

$pinParam=$_['pin'];
$stateParam=$_['state'];

switch($_['action']){
	case 'changeState':
	    if (intval($stateParam)<0 or intval(stateParam)>1 or intval($pinParam)<1 or intval($pinParam)>26){
	        $result['answer']  = 'Bad parameter';     
	    }else  $result['state'] = setPinState($pins[$pinParam],$stateParam);
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
	    if (intval($pinParam)<1 or intval($pinParam)>26){
	        $result['answer']  = "ERROR";
	        $result['state'] = 'Bad parameter';
	    }else  $result['state'] = (getPinState($pinParam,$pins)=='off'?true:false);
	break;

    case 'resetSchedule':
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
            mysql_free_result($result);
        }       
        
    break;
    
    case 'getSetting':
        mysql_connect($options["database"]["host"],$options["database"]["username"],$options["database"]["password"]) or die('error connection');
        mysql_select_db($options["database"]["name"]) or die('error database selection');
        $query="SELECT 'value' FROM `settings` WHERE id='".$_['id']."'";
        $outcome = mysql_query($query);
        if (!$outcome) {
             $result['answer']  = "ERROR";
             $result['state'] =  mysql_error();
        }else{
            while ($row = mysql_fetch_assoc($outcome)) {
                $result['state']=($row['value']); 
            }
            $result['state']=$query;
            mysql_free_result($result);
        }
        break;        

	default:
		$result['answer']  = "ERROR";
		$result['state'] = 'Undefined action '.$_['action'];
	break;
}

echo '('.json_encode($result).')';

?>