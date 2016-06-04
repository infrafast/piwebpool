<?php
require_once('common.php');

$result['state']  = 0;
$result['error']  = '';

switch($_['action']){
	case 'changeState':
		setPinState($pins[$_['pin']],$_['state']);
		$result['state'] = 1;
	break;

	case 'demo':
		system("gpio write ".$pins[$materials["Filtration"]]." 1");
		sleep(1);
		system("gpio write ".$pins[$materials["Filtration"]]." 0");
		sleep(1);
		system("gpio write ".$pins[$materials["Prise libre"]]." 1");
		sleep(1);
		system("gpio write ".$pins[$materials["Prise libre"]]." 0");
		$result['state'] = 1;
	break;

	default:
		$result['error']  = 'No action defined';
	break;
}

echo '('.json_encode($result).')';

?>