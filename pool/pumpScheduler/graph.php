<?php
include_once('include/phpMyGraph5.0.php'); 

//Set config directives
header("Content-type: image/png");
    //$cfg['title'] = 'Example graph';
    $cfg['width'] = 640;
    $cfg['height'] = 480;
    
    //Set data 1
    $data1 = array(
        '00' => 7,
        '01' => 7.5,
        '02' => 7.3,
        '03' => 6.5,
        '04' => 6,
        '05' => 6.3,
        '06' => 7,
        '07' => 6,
        '08' => 7,
        '09' => 7.2,
        '10' => 7.3
    );

    //Set data 2
    $data2 = array(
        '00' => 620,
        '01' => 625,
        '02' => 630,
        '03' => 650,
        '04' => 645,
        '05' => 650,
        '06' => 655,
        '07' => 652,
        '08' => 666,
        '09' => 660,
        '10' => 660
    );
    
    //Create phpMyGraph instance
    $graph = new verticalLineGraph();

    //Parse
    $graph->parseCompare($data1, $data2, $cfg);
?>