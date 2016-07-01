 <?php

	require_once('functions.php');

    //sendemail("test");
    //sendsms("test");
    $dev=array();
    $dev=getDeviceFromFile();
    if ($dev!=null){
        echo "devices are:\n";
        foreach ($dev as $id=>$device) echo $id.":".$device."\n";
        
        echo "call: ".$dev["tutu"];
        
    }else echo "\nerror";

?>
