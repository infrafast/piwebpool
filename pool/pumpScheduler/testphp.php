 <?php

	require_once('functions.php');

    //sendemail("test");
    //sendsms("test");
    $id="ph";
    $dev=getDeviceZ();
    if ($dev!=null) echo $id."=".$dev;
    else echo "\nerror";

?>
