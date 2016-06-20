<?php
/*
LUA CONTEXT*/
require_once ("functions.php");
include ("configuration.php");

function retrieveLuaCode($table){
    // connect to the database
    if (!$link = mysql_connect($options["database"]["host"], $options["database"]["username"], $options["database"]["password"])) {
        echo 'Could not connect to mysql';
        exit;
    }
    
    if (!mysql_select_db($options["database"]["name"], $link)) {
        echo 'Could not select database';
        exit;
    }     
    
    $sql    = "SELECT lua FROM scripts where id='header'";
    $result = mysql_query($sql, $link);
    
    if (!$result) {
        echo "DB Error, could not query the database\n";
        echo 'MySQL Error: ' . mysql_error();
        exit;
    }
    
    $pumpConsign=0;
        while ($row = mysql_fetch_assoc($result)) {
        $pumpConsign=($row[$temp]);
    }
    // treat error case of unfound timewindow in the table
    //if ($pumpConsign="")
    
    mysql_free_result($result);
    
    
    
    
}


function goLua($luaCode,$materials,$pins,&$feedback){
    
    try{
        //$lua=new Lua($file);
        $lua=new Lua();
        $lua->eval($luaCode);
        // record names of the command as variable and manipulate them directly phyisically in lua using set and get functions
        // since the setPinState function gets the logical pin number, we have to get it from the table
    
        foreach($materials as $material=>$pin){
            $luaVariables[$pin]=getPin($pins[$pin]);
            $lua->assign($material, $pins[$pin]);     
            //echo "{material: ".$material." pin:".$pins[$pin]."}";
            
            // generate XML for blockly toolbox variable
        }
        $lua->assign("temperature",getTemperature());
        $lua->assign("ph",getPh());
        $lua->assign("orp",getORP());
        
        $lua->registerCallback("set", 'setPinState'); 
        $lua->registerCallback("get", 'getPin'); 
        $lua->registerCallback("log", 'appendlualog');
        $lua->registerCallback("sms", 'sendsms');
        $lua->registerCallback("email", 'sendemail');

        // generate XML for blockly toolbox functions

        // execute the script
        $feedback= $lua->run();
        if (!$feedback) $feedback = "Runtime error";
    } catch (LuaException $e) {
         $feedback= $e->getMessage();
         return false;
    }
    return true;
}


?>