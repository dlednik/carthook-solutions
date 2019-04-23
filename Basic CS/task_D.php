<?php
// Write a function that sorts 10000 powers (a^b) where a and b are random numbers between 100 and 10000?
// Estimate how long it would take on your machine?

function sortByLog($a, $b) {
    return $a['power']*log($a['base']) - $b['power']*log($b['base']);
}

$len = 10000;
echo "using PHP usort function to sort " . $len . " powers (a^b) where a and b are random numbers between 100 and 10000:" . PHP_EOL;
$numbers = array();
for($x = 0; $x < $len; $x++) {
    $a = rand(100, 10000);
    $b = rand(100, 10000);
    // echo $a . ' ' . $b . PHP_EOL;
    $numbers[] = array(
        'stringNumber' => $a . '^' .$b,
        'base' => $a, 
        'power' => $b,
        'logValue' => $b * log($a)
    );
}
// print_r($numbers);

$start = microtime(true);
usort($numbers, 'sortByLog');
echo 'Took: ' . (microtime(true) - $start) . ' seconds';
// print_r($numbers);
echo PHP_EOL;

// You can not calculate numbers like that in a typical programming language. You would have to modify it,
// write your own library to operate with them. What you can do is this. If you calculate logarithm of all the 
// numbers and sort them by size you sorted original powers values. So you just store the base and the power for a number and
// let the build in PHP function compare logarithmic values if it's bigger or smaller.