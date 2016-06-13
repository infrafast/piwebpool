<?php
/*
LUA CONTEXT*/
require_once ("functions.php");
require_once ("configuration.php");

function getLua($script)
    static $lua=new Lua($script;)
    $lua->assign("filtration", $materials["Filtration"]); /** assign a PHP var to Lua named from */
    return $lua;
}

function runLua()

}

?>