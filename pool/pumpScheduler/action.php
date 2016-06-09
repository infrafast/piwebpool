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
	        $result['answer']  = 'Bad parameter';     
	    }else  $result['state'] = (getPinState($pinParam,$pins)=='off'?true:false);
	break;

    case 'resetSchedule':
        $dbms_schema='pumpSchedule.sql';

        mysql_connect($options["database"]["host"],$options["database"]["username"],$options["database"]["password"]) or die('error connection');
        mysql_select_db($options["database"]["name"]) or die('error database selection');
  
        $sql_query = @fread(@fopen($dbms_schema, 'r'), @filesize($dbms_schema)) or die('problem ');
        $sql_query = remove_remarks($sql_query);
        $sql_query = split_sql_file($sql_query, ';');
        
        foreach($sql_query as $sql) mysql_query($sql) or die('error in query '.$sql);  
    break;

    case 'updateCollapseTableSetting':
        mysql_connect($options["database"]["host"],$options["database"]["username"],$options["database"]["password"]) or die('error connection');
        mysql_select_db($options["database"]["name"]) or die('error database selection');
    break;
    
    case 'getCollapseTableSetting':
        mysql_connect($options["database"]["host"],$options["database"]["username"],$options["database"]["password"]) or die('error connection');
        mysql_select_db($options["database"]["name"]) or die('error database selection');
        
        $outcome = mysql_query("SELECT 'value' FROM `tableCollapseSetting` WHERE id='".$_['id']."'") or die('error in query '.$sql);
        if (!$outcome) {
             $result['answer']  = 'failed '.mysql_error();
        }else{
            while ($row = mysql_fetch_assoc($outcome)) {
                $result['state'] = $row['value'];
            }
            // Free the resources associated with the result set
            // This is done automatically at the end of the script
            mysql_free_result($result);
        }
    break;        


	default:
		$result['answer']  = 'Undefined action '.$_['action'];
	break;
}

echo '('.json_encode($result).')';

?>