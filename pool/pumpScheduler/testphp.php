<?php

require_once('functions.php');

//sendemail("test");
//sendsms("test");

$ms="warningEau = ' Attention à la qualité de l'eau!';";
echo mysql_real_escape_string(htmlspecialchars(addslashes($ms)));

?>
