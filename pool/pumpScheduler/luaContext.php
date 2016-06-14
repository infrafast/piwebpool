<?php
/*
LUA CONTEXT*/
require_once ("functions.php");
require_once ("configuration.php");

function goLua($file,$materials,$pins,&$feedback){
    try{
        $lua=new Lua($file);
        // record names of the command as variable and manipulate them directly phyisically in lua using set and get functions
        // since the setPinState function gets the logical pin number, we have to get it from the table
    
        foreach($materials as $material=>$pin){
            $luaVariables[$pin]=getPin($pins[$pin]);
            $lua->assign($material, $pins[$pin]);     
            //echo "{material: ".$material." pin:".$pins[$pin]."}";
        }
        $lua->assign("temperature",getTemperature());
        $lua->assign("ph",getPh());
        $lua->assign("orp",getORP());
        
        $lua->registerCallback("set", 'setPinState'); 
        $lua->registerCallback("get", 'getPin'); 

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