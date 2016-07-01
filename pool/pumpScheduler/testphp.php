 <?php

	require_once('functions.php');

    //sendemail("test");
    //sendsms("test");
    $dev=array();
    $dev=getDeviceFromFile();
    if ($dev!=null){
        echo "devices are:\n";
        foreach ($device as $dev) echo $device."\n";
    }else echo "\nerror";

?>
