<?php

// inclure ici le fichier de la classe
require "include/FreeSMS.php";
include("include/php_serial.class.php");
include_once('include/phpMyGraph5.0.php'); 

function sendsms($message){
    $SMSuser = "19107501";
    $SMSkey = "1NXCXBzJGbNsdb";
    $feedback="void";            
    $result=true;
    if (!sms( $SMSuser, $SMSkey, $message,$feedback )) $result=false;
    appendlog("sendsms:",$result==true?"OK":"ERROR",$feedback);
    return $result;
}

function sendemail($message){
    // send email
    // subject and recipee should be extracted from settings.
    //html decode to display accents
    $message=html_entity_decode(wordwrap($message,70));
    $to = "szemrot@hotmail.com";
    $subject = "Pool Notification";
    $from = "noreply@piweb.infrafast.com";
    $headers = "From:" . $from;
    $result = mail($to,$subject,$message,$headers);
    appendlog("sendemail:",$result==true?"OK":"ERROR",$message);
    return $result;
}

function appendlualog($message,$logfilename){
    return appendlog("LUA","OK",$message);
}

function appendlog($source,$answer,$status,$logfilename){
    return file_put_contents($logfilename, "[".date("Y-m-d H:i:s")."][".$source.' ' .$answer."][".html_entity_decode($status)."]\n" , FILE_APPEND | LOCK_EX);
}

function getLog($lines = 24){
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

function getPin($pin){
    // this function is to abstract one parameter when called from lua
    // it return 0 or 1 to beconsistent with set and to ease the testing 
    // contrary to the sub-function which is called from php
    exec("gpio read ".$pin,$commands,$return);
    //echo "exec gpio read ".$pin;
    // relay : normally close
    return (trim($commands[0])=="1"?0:1);
}

function setPinState($pin,$state){
    //Definis le PIN en tant que sortie
	system("gpio mode ".$pin." out");
	//Active/désactive le pin
	$state=($state==0?1:0);
	
	system("gpio write ".$pin." ".$state);
	//echo "{gpio write ".$pin." ".$state."}";
	// here we should capture with the feedback pin and set return accordingly to manage the state"unknown"
	return true;
}

function getTemperature(){
    return rand(-4,32);
}

// use "I" command to determine where PH and ORP and TEMP sensors are connected ttyUSB
function getPh(){
    return round(readSensor("/dev/ttyUSB1"), 2,PHP_ROUND_HALF_UP);  
    //return round( (0 + (10 - 0) * (mt_rand() / mt_getrandmax())), 1, PHP_ROUND_HALF_UP);
}

function getORP(){
    return intval(readSensor("/dev/ttyUSB0"));    
   //return intval(rand(0,1000));
}

function readSensor($device){
    $serial = new PhpSerial;
    $serial->deviceSet($device);
    $serial->confBaudRate(9600);
    $serial->deviceOpen();
    sleep(2);
    $serial->sendMessage("R\r");
    sleep(1);
    $val=$serial->readPort();
    $serial->deviceClose();    
    return $val;  
}



function getPoolTemperature(){
    // should curl to Eniac
    $temp=getTemperature();
    $temp=intval($temp);
    if ($temp/2 <> intval($temp/2)) $temp-=1;
    $tempRange=$temp."to".($temp+2);
    if ($temp>=28) $tempRange="above28";
    if ($temp<0) $tempRange="below0";
    return $tempRange;
}

function secure($string){
	return htmlentities(stripslashes($string),NULL,'UTF-8');
}

function getCurrentTimeWindow(){
    // get the current hours and force multiple to 2
    $tw=date("H");
    //$tw=06; 
    if ($tw/2 <> intval($tw/2)) $tw-=1;
    // format to 2 digit (prefix 0) 
    $prefixDigit="";
    if (strlen($tw)<2) $prefixDigit="0";
    // convert to text with hour so it match the row name in table
    $tw=$prefixDigit.$tw."h";
    return $tw;
}


//
// remove_comments will strip the sql comment lines out of an uploaded sql file
// specifically for mssql and postgres type files in the install....
//
function remove_comments(&$output)
{
   $lines = explode("\n", $output);
   $output = "";

   // try to keep mem. use down
   $linecount = count($lines);

   $in_comment = false;
   for($i = 0; $i < $linecount; $i++)
   {
      if( preg_match("/^\/\*/", preg_quote($lines[$i])) )
      {
         $in_comment = true;
      }

      if( !$in_comment )
      {
         $output .= $lines[$i] . "\n";
      }

      if( preg_match("/\*\/$/", preg_quote($lines[$i])) )
      {
         $in_comment = false;
      }
   }

   unset($lines);
   return $output;
}

//
// remove_remarks will strip the sql comment lines out of an uploaded sql file
//
function remove_remarks($sql)
{
   $lines = explode("\n", $sql);

   // try to keep mem. use down
   $sql = "";

   $linecount = count($lines);
   $output = "";

   for ($i = 0; $i < $linecount; $i++)
   {
      if (($i != ($linecount - 1)) || (strlen($lines[$i]) > 0))
      {
         if (isset($lines[$i][0]) && $lines[$i][0] != "#")
         {
            $output .= $lines[$i] . "\n";
         }
         else
         {
            $output .= "\n";
         }
         // Trading a bit of speed for lower mem. use here.
         $lines[$i] = "";
      }
   }

   return $output;

}

//
// split_sql_file will split an uploaded sql file into single sql statements.
// Note: expects trim() to have already been run on $sql.
//
function split_sql_file($sql, $delimiter)
{
   // Split up our string into "possible" SQL statements.
   $tokens = explode($delimiter, $sql);

   // try to save mem.
   $sql = "";
   $output = array();

   // we don't actually care about the matches preg gives us.
   $matches = array();

   // this is faster than calling count($oktens) every time thru the loop.
   $token_count = count($tokens);
   for ($i = 0; $i < $token_count; $i++)
   {
      // Don't wanna add an empty string as the last thing in the array.
      if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0)))
      {
         // This is the total number of single quotes in the token.
         $total_quotes = preg_match_all("/'/", $tokens[$i], $matches);
         // Counts single quotes that are preceded by an odd number of backslashes,
         // which means they're escaped quotes.
       $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);

         $unescaped_quotes = $total_quotes - $escaped_quotes;

         // If the number of unescaped quotes is even, then the delimiter did NOT occur inside a string literal.
         if (($unescaped_quotes % 2) == 0)
         {
            // It's a complete sql statement.
            $output[] = $tokens[$i];
            // save memory.
            $tokens[$i] = "";
         }
         else
         {
            // incomplete sql statement. keep adding tokens until we have a complete one.
            // $temp will hold what we have so far.
            $temp = $tokens[$i] . $delimiter;
            // save memory..
            $tokens[$i] = "";

            // Do we have a complete statement yet?
            $complete_stmt = false;

            for ($j = $i + 1; (!$complete_stmt && ($j < $token_count)); $j++)
            {
               // This is the total number of single quotes in the token.
               $total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
               // Counts single quotes that are preceded by an odd number of backslashes,
               // which means they're escaped quotes.
               $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);

               $unescaped_quotes = $total_quotes - $escaped_quotes;

               if (($unescaped_quotes % 2) == 1)
               {
                  // odd number of unescaped quotes. In combination with the previous incomplete
                  // statement(s), we now have a complete statement. (2 odds always make an even)
                  $output[] = $temp . $tokens[$j];

                  // save memory.
                  $tokens[$j] = "";
                  $temp = "";

                  // exit the loop.
                  $complete_stmt = true;
                  // make sure the outer loop continues at the right point.
                  $i = $j;
               }
               else
               {
                  // even number of unescaped quotes. We still don't have a complete statement.
                  // (1 odd and 1 even always make an odd)
                  $temp .= $tokens[$j] . $delimiter;
                  // save memory.
                  $tokens[$j] = "";
               }

            } // for..
         } // else
      }
   }

   return $output;
}



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


?>

