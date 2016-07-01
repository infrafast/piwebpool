 <?php

	require_once('functions.php');

    //sendemail("test");
    //sendsms("test");
    $dev=array();
    $dev=getDeviceFromFile();
    if ($dev!=null){
        echo "devices are:\n";
        foreach ($dev as $device=>$id) echo $id.":".$device."\n";
    }else echo "\nerror";

?>
