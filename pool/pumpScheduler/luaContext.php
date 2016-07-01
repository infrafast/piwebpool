<?php
/*
LUA CONTEXT*/
require_once ("functions.php");
include ("configuration.php");

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
            
            
        }
        // generate VARIABLE LIST 
                //foreach ($exportedVariable as $variable=>$variableCall)
//            $lua->assign($variable,$variableCall);
        
        
        $lua->assign("temperature",getTemperature());
        $lua->assign("ph",getPh());
        $lua->assign("orp",getORP());
        $lua->assign("period",intval(getCurrentTimeWindow()));
        $lua->assign("hour",intval(getCurrentTime()));
        
        $lua->registerCallback("set", 'setPinState'); 
        $lua->registerCallback("get", 'getPin'); 
        $lua->registerCallback("log", 'appendlualog');
        $lua->registerCallback("sms", 'sendsms');
        $lua->registerCallback("email", 'sendemail');

        // generate XML for blockly toolbox functions

        // execute the script
        $feedback= $feedback." ".$lua->run();
        if (!$feedback) $feedback = $feedback." "."Runtime error";
        
        echo "\n**********".$feedback."STOP";
    } catch (LuaException $e) {
         $feedback=$feedback." ".$e->getMessage();
         echo "##########".$feedback."STOP";
         return false;
    }
    return true;
}


?>