<?php
/*
 @nom: functions
 @auteur: piwebpool (info@infrafast.com)
 @description: all utilities reused across the application
*/
//


require "include/FreeSMS.php";
include("include/php_serial.class.php");
include_once('include/phpMyGraph5.0.php'); 
#include("configuration.php");
/*
wiringPi
Pin 	BCM
GPIO 	Name 	Header 	Name 	BCM
GPIO 	wiringPi
Pin
– 	– 	3.3v 	1 | 2 	5v 	– 	–
8 	0 	SDA0 	3 | 4 	DNC 	– 	–
9 	1 	SCL0 	5 | 6 	0v 	– 	–
7 	4 	GPIO 7 	7 | 8 	TxD 	14 	15
– 	– 	DNC 	9 | 10 	RxD 	15 	16
0 	17 	GPIO 0 	11 | 12 	GPIO 1 	18 	1
2 	21 	GPIO 2 	13 | 14 	DNC 	– 	–
3 	22 	GPIO 3 	15 | 16 	GPIO 4 	23 	4
– 	– 	DNC 	17 | 18 	GPIO 5 	24 	5
12 	10 	MOSI 	19 | 20 	DNC 	– 	–
13 	9 	MISO 	21 | 22 	GPIO 6 	25 	6
14 	11 	SCLK 	23 | 24 	CE0 	8 	10
– 	– 	DNC 	25 | 26 	CE1 	7 	11
*/


function registerMaterialURLCallBack($material,$url,$valueOn,$valueOff){
    global $options; 
    mysql_connect($options["database"]["host"],$options["database"]["username"],$options["database"]["password"]) or die('error connection');
    mysql_select_db($options["database"]["name"]) or die('error database selection');
    // in case of duplicate, simply erase
    $query="INSERT INTO `listeners` (`url`, `material`, `valueOn`, `valueOff`) VALUES ('".$url."', '".$material."', '".$valueOn."', '".$valueOff."') ON DUPLICATE KEY UPDATE url='".$url."',material='".$material."',valueOn='".$valueOn."',valueOff='".$valueOff."'";
    $outcome = mysql_query($query);
    //appendlog("registerMaterialURLCallBack",$query,$outcome);
    if (!$outcome) return false; else return true;
}

function weburl($url,$statusKey){
    if(!function_exists("curl_init")) die("cURL extension is not installed");
    $curl_options = array(
                        CURLOPT_URL => $url,
                        CURLOPT_HEADER => 0,
                        CURLOPT_RETURNTRANSFER => TRUE,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_SSL_VERIFYPEER => 0,
                        CURLOPT_FOLLOWLOCATION => TRUE,
                        CURLOPT_ENCODING => 'gzip,deflate'                                    
                );
    $ch = curl_init();
    curl_setopt_array( $ch, $curl_options );
    $output = curl_exec( $ch );
    curl_close($ch);
    $arr = json_decode($output,true);
    //appendlog("WEBURL",$url,$statusKey."=".$arr[$statusKey]);
    return $arr[$statusKey];
}

function sendsms($message,$destination){
    $SMSuser = "youruserid";
    $SMSkey = "yourpasskey";
    $feedback="void";            
    $result=true;
    if (!sms( $SMSuser, $SMSkey, $message,$feedback )) $result=false;
    appendlog("SENDSMS:",$result==true?"OK":"ERROR",$feedback);
    return $result;
}

function sendemail($message,$to="szemrot@hotmail.com"){
    // send email
    // subject and recipee should be extracted from settings.
    //html decode to display accents
    $message=html_entity_decode(wordwrap($message,70));
    $subject = "Notification de ".gethostname();
    $from = "noreply@piwebpool.infrafast.github.io";
    $headers = "From:" . $from;
    $result = mail($to,$subject,$message,$headers);
    appendlog("SENDMAIL:",$result==true?"OK":"ERROR",$message);
    return $result;
}

function appendlualog($message,$source="LUALOG"){
    return appendlog($source,"NOTIFICATION",$message);
}

function appendlog($source,$answer,$status,$filename="logfile.txt"){
// Appends lines to file and makes sure the file doesn't grow too much
    $result=true;
    // remove \n and \r so logfile are written on one line only except the last one
    $text =  preg_replace('~[\r\n]+~', '', "[".date("Y-m-d H:i:s")."][".$source.' ' .$answer."][".html_entity_decode($status)."]")."\n";
	if (!file_exists($filename)) { touch($filename); chmod($filename, 0666); }
	// file = 50kB
	if (filesize($filename) > 100000) {
		$filename2 = $filename.".old";
		if (file_exists($filename2)) unlink($filename2);
		rename($filename, $filename2);
		touch($filename); chmod($filename,0666);
	}
	if (!is_writable($filename)) die("<p>\nCannot open log file ($filename)");
	if (!$handle = fopen($filename, 'a')) die("<p>\nCannot open file ($filename)");
	if (fwrite($handle, $text) === false) die("<p>\nCannot write to file ($filename)");
	fclose($handle);
	return $result;
    //return file_put_contents($logfilename, "[".date("Y-m-d H:i:s")."][".$source.' ' .$answer."][".html_entity_decode($status)."]\n" , FILE_APPEND | LOCK_EX);
}

function getLog($logfilename, $lines = 100){
    $data = '';
    $filename="./".$logfilename;
    $fp = fopen($filename, "r");
    $block = 4096;
    $max = filesize($filename);
    
    for($len = 0; $len < $max; $len += $block) 
    {
        $seekSize = ($max - $len > $block) ? $block : $max - $len;
        fseek($fp, ($len + $seekSize) * -1, SEEK_END);
        $data = fread($fp, $seekSize) . $data;
    
        if(substr_count($data, "\n") >= $lines + 1) 
        {
            /* Make sure that the last line ends with a '\n' */
            if(substr($data, strlen($data)-1, 1) !== "\n") {
                $data .= "\n";
            }
    
            preg_match("!(.*?\n){". $lines ."}$!", $data, $match);
            fclose($fp);
            return $match[0];
        }
    }
    fclose($fp);
    return $data; 
}


function sms($SMSkey, $SMSuser,$message,&$feedback){
     $sms = new FreeMobile();
    $sms->setKey($SMSkey)
        ->setUser($SMSuser);
    try {
        // envoi d'un message
        $sms->send($message);
        $feedback = "sent";
        return true;
    } catch (Exception $e) {
        $feedback = $e->getCode()." ".$e->getMessage();
        //echo "Erreur sur envoi de SMS: ".$feedback;
        return false;
    }    
}


function getPinState($pin,$pins){
	$commands = array();
	return getPin($pins[$pin]);
}

function getLuaPin($pin){
	return getPin($pin)==0?"Off":"On";
}

function getPin($pin){
    // this function is to abstract one parameter when called from lua
    // it return 0 or 1 to beconsistent with set and to ease the testing 
    // contrary to the sub-function which is called from php
    exec("gpio read ".$pin,$commands,$return);
    //echo "exec gpio read ".$pin;
    // relay : normally close
    return (trim($commands[0])=="1"?0:1);
}

function setLuaPinState($pin,$state){
    //appendlualog("call setPinState(".$pin.",".$state.")");
    return setPinState($pin,$state=="Off"?0:1);
}

function setPinState($pin,$state){
    global $materials, $options, $pins;
    sleep(1);
    if ($state!=getPin($pin)){
    
        // retrieve the list of all listeners for this material
        mysql_connect($options["database"]["host"],$options["database"]["username"],$options["database"]["password"]) or die('error connection');
        mysql_select_db($options["database"]["name"]) or die('error database selection');
        //revert the material name from its pin value
        $material = array_search(array_search($pin,$pins), $materials);
        // retrieve all registered url for this material
        $sql    = "SELECT url,material,valueOn,valueOff from listeners where material='".$material."';";
        //appendlog("FIRE",$sql,"");
        $outcome = mysql_query($sql);
        if (!$outcome) {
            appendlog("ERROR",$sql,mysql_error());
        }else{
            while ($row = mysql_fetch_assoc($outcome)) {
                $url=($row['url']);
                if ($state==1){
                    $cmd=$row['valueOn'];
                }else{
                    $cmd=$row['valueOff'];
                }
                // replace the %v in the URL string by the value
                $url = str_ireplace("%v",$cmd,$url);
                // replace the %m in the URL string by the value
                $url = str_ireplace("%m",$material,$url);
                //appendlog("FIRE",$state,$url);
                appendlog("SWITCH",$material,$state==0?"Off":"On");
                //issue #24
                //here we put "status" which is the keyword we ecpect to get from the json reply 
                //we however don't exploit the result of the call function because this should be 
                // 1) pass as a parameter to the weburl extracted from the listeners table
                // 2) then it cause the question about the return to the function itself where a NOK from weburl
                // should not return false if th setPin command was successful...
                //fire the state change to all listeners
                weburl($url,"status");
            }
        }    
        //Definis le PIN en tant que sortie
    	system("gpio mode ".$pin." out");
    	//Active/désactive le pin
    	$state=($state==0?1:0);
    	
    	system("gpio write ".$p