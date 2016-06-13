<?php
/*
LUA CONTEXT*/
require_once ("functions.php");
require_once ("configuration.php");

function getLua($file){
    $script=$file;
    $lua=new Lua($file);
    $lua->assign("filtration", $materials["Filtration"]); /** assign a PHP var to Lua named from */        
}

function get() 
{
   return $this->$lua;
}

function run() 
{
   return $lua->run();      
}


?>