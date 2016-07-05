 <?php

function leastSquareFit(array $values) {
    $x_sum = array_sum(array_keys($values));
    $y_sum = array_sum($values);
    $meanX = $x_sum / count($values);
    $meanY = $y_sum / count($values);
    // calculate sums
    $mBase = $mDivisor = 0.0;
    foreach($values as $i => $value) {
        $mBase += ($i - $meanX) * ($value - $meanY);
        $mDivisor += ($i - $meanX) * ($i - $meanX);
    }

    // calculate slope
    $slope = $mBase / $mDivisor;
    return $slope;
}   //  function leastSquareFit()


	require_once('functions.php');

$PopulationOfTexas = array(
    1999 => 6.56, // in millions
    2000 => 6.45,
    2001 => 6.50,
    2002 => 6.51
);

//generate an array sohwing the difference in each year compared to the previous year
$differneces = array();
$lastyear = null;
foreach($PopulationOfTexas as $k=>$v){
    if(empty($lastyear)){$lastyear = $v; continue;}
    $differneces[$k] = $v - $lastyear;
    $lastyear = $v;

    //use this later
    $lastitem = array("year"=>$k, "data"=>$v);
}

//get the average difference per year
$count = 0;
$total = 0;
foreach($differneces as $k=>$v){
    $count++;
    $total += $v;
}

$average = number_format(($total/$count), 2);

//make a prediction
$predictions = array();
for($i=0;$i<5;$i++){
    $year = isset($year) ? $year+1 : $lastitem["year"]+1;
    $prediction = isset($prediction) ? $prediction+floatval($average) : $lastitem["data"]+floatval($average);
    $predictions[$year] = $prediction;
}

print_r($predictions);


?>
