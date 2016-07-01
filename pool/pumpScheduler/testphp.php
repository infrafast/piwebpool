 <?php

	require_once('functions.php');

    //sendemail("test");
    //sendsms("test");
    $id="toto";
    $dev=getDeviceZ($id);
    if ($dev!=null) echo $id."=".$dev;
    else echo "\nerror";

?>
