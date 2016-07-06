 <?php
function standard_deviation($aValues, $bSample = false)
{
    $fMean = array_sum($aValues) / count($aValues);
    $fVariance = 0.0;
    foreach ($aValues as $i)
    {
        $fVariance += pow($i - $fMean, 2);
    }
    $fVariance /= ( $bSample ? count($aValues) - 1 : count($aValues) );
    return (float) sqrt($fVariance);
}


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
    0 => 700.56, // in millions
    1 => 706.45,
    2 => 705.50,
    3 => 704.55,
    4 => 763.51,
    5 => 700.49,
    6 => 702.48,
    7 => 706.47,
    8 => 710.5,
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

echo leastSquareFit($PopulationOfTexas);

echo "\nstdev: ".standard_deviation($PopulationOfTexas);

echo "getdevice id ".getDevice("ph");

?>
