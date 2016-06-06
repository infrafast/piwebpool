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
        // OPEN CONNECTION...
        $connection = mysql_connect($options["database"]["host"], $options["database"]["username"], $options["database"]["password"]) or die(mysql_error());
        mysql_select_db($options["database"]["name"], $connection) or die(mysql_error());
        
        //$path = $_SERVER['DOCUMENT_ROOT'];
        $sql_filename = './//pumpSchedule.sql';
        $sql_contents = file_get_contents($sql_filename);
        $sql_contents = explode(";", $sql_contents);
         
        foreach($sql_contents as $query){
            $outcome = mysql_query($query);
            if (!$outcome) $result['answer']=$query."failed "." filename:".$sql_filename." query:".$query;
        }        
    break;

	default:
		$result['answer']  = 'Undefined action '.$_['action'];
	break;
}

echo '('.json_encode($result).')';

?>