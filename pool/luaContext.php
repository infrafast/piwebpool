<?php
/*
LUA CONTEXT */
require_once ("functions.php");
include ("configuration.php");

function goLua($luaCode,$materials,$pins,&$feedback,$link){
    
    try{
        //$lua=new Lua($file);
        $lua=new Lua();
        // record names of the command as variable and manipulate them directly phyisically in lua using set and get functions
        // since the setPinState function gets the logical pin number, we have to get it from the table
    
        foreach($materials as $material=>$pin){
            $luaVariables[$pin]=getPin($pins[$pin]);
            $lua->assign($material, $pins[$pin]);     
            //echo "{material: ".$material." pin:".$pins[$pin]."}";
            
            
        }

        $phValue = getPh();
        $orpValue = getORP();
        $temperatureValue = getTemperature();
        if($phValue==null)  $phValue=-99;
        if($orpValue==null)  $orpValue=-99;
        if($temperatureValue==null)  $temperatureValue=-99;
        $lua->assign("temperature",$temperatureValue);
        $lua->assign("ph",$phValue);
        $lua->assign("orp",$orpValue);
        $lua->assign("period",intval(getCurrentTimeWindow()));
        $lua->assign("hour",intval(getCurrentTime()));

        //db related variables
        $sql    = "SELECT id,value from settings where userSetting=true;";
        $result = mysql_query($sql, $link);
        if (!$result) {
            $feedback=$feedback." ".mysql_error();
            return false;
        }else{
            while ($row = mysql_fetch_assoc($result)) {
                $id=($row['id']);
                $value=($row['value']);
                if (is_numeric($value)) $value='"'.$value.'"';
                //$lua->assign("parametre['".$id."']",$value);
                //appendlualog("   assign(\"parametre['".$id."']\",".$value.")    ");
                $lua->assign($id,$value);
                appendlualog("   assign(".$id.",".$value.")    ");
            }
        }    
        mysql_free_result($result);

        $lua->registerCallback("set", 'setLuaPinState'); 
        $lua->registerCallback("get", 'getLuaPin'); 
        $lua->registerCallback("log", 'appendlualog');
        $lua->registerCallback("sms", 'sendsms');
        $lua->registerCallback("email", 'sendemail');
        $lua->registerCallback("web", 'weburl');
        // execute the script
        $lua->eval($luaCode);
        $retval = $lua->run();
        if (!$retval) $feedback = $feedback."Runtime error";
        else $feedback = $feedback.$retval;
    } catch (LuaException $e) {
         $feedback=$feedback." ".$e->getMessage();
         return false;
    }
    return true;
}


?>