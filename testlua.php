<?php
/*
 @nom: testdata 
 @auteur: piwebpool (info@infrafast.com)
 @description: running lua scripts stored in the database for test purpose only, non productive use
*/
//
require_once('configuration.php');
require_once('functions.php');
require_once('luaContext.php');

if (!$link = mysql_connect($options["database"]["host"], $options["database"]["username"], $options["database"]["password"])) {
    echo 'Could not connect to mysql';
    exit;
}

if (!mysql_select_db($options["database"]["name"], $link)) {
    echo 'Could not select database';
    exit;
} 

$answer="OK";
$state="";

$concat=array("header","footer");
$i=0;
foreach ($concat as $scriptID) {
    // fetch lua header and footer code
    // i.e. the run() and return
    $sql    = "SELECT lua from scripts where id='".$scriptID."'";
    $result = mysql_query($sql, $link);
    if (!$result) {
        $answer.="+ERROR";
        $state.="+".mysql_error();
    }else{
        while ($row = mysql_fetch_assoc($result)) $concat[$i++]=($row['lua']);
        mysql_free_result($result);
    }                
}
$luaFeedback="";
$scriptID="main";
    $luaFeedback.="|".$scriptID.":";
    // fetch lua code from database
    $sql    = "SELECT lua from scripts where id='".$scriptID."'";
    $result = mysql_query($sql, $link);
    if (!$result) {
        $answer.="+ERROR";
        $state.="+".mysql_error();
    }else{
        $luaCode="";
        while ($row = mysql_fetch_assoc($result)) $luaCode=htmlspecialchars_decode(($row['lua']));
        mysql_free_result($result);
    }
    // call lua execution built from Header + Content + Footer and passing the access to the pins so they can be manipulated by lua code
    goLua($concat[0].$luaCode.$concat[1],$materials,$pins,$luaFeedback,$link,$scriptID);

        
$state.="{".$luaFeedback."}";    
appendlog("LUATEST",$answer,$state, $logfilename);

// sync data to disk
exec("sync");

echo $answer.$state;
?>
