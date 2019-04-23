<?php
// Write a function that sorts 11 small numbers (<100) as fast as possible. 
// Estimate how long it would take to execute that function 10 Billion (10^10) times on a normal machine?

$size = array(11, 100, 1000, 10000, 100000);

function array_insert(&$array, $position, $insert) {
    if (is_int($position)) {
        array_splice($array, $position, 0, $insert);
    } else {
        $pos   = array_search($position, array_keys($array));
        $array = array_merge(
            array_slice($array, 0, $pos),
            $insert,
            array_slice($array, $pos)
        );
    }
}

function fastSort($array) {
    $sorted = array();
    $idx = array();
    for ($i=0; $i<100; $i++) {
        $idx[$i] = 0;
    }

    foreach($array as $number) {
        if (sizeof($sorted) == 0) {
            $sorted[] = $number;
        } else {
            array_insert($sorted, $idx[$number], $number);
        }
        for ($i=$number+1; $i<100; $i++) {
            $idx[$i]++;
        }
        // print_r($idx);
    }
    return $sorted;
}

function quicksort( $array ) {
    if( count( $array ) < 2 ) {
        return $array;
    }
    $left = $right = array( );
    reset( $array );
    $pivot_key  = key( $array );
    $pivot  = array_shift( $array );
    foreach( $array as $k => $v ) {
        if( $v < $pivot )
            $left[$k] = $v;
        else
            $right[$k] = $v;
    }
    return array_merge(quicksort($left), array($pivot_key => $pivot), quicksort($right));
}

$pool = range(0, 99);

echo "PHP asort:" . PHP_EOL;
foreach($size as $len) {
    $numbers = array();
    for($x = 0; $x < $len; $x++) {
        $i = rand(1, count($pool))-1;
        $numbers[] = $pool[$i];
    }
    // print_r($numbers);

    $start = microtime(true);
    asort($numbers);
    // fastSort($numbers);
    echo $len . PHP_EOL;
    echo microtime(true) - $start;
    // print_r($numbers);
    echo PHP_EOL;
}

echo "Mine:" . PHP_EOL;
foreach($size as $len) {
    $numbers = array();
    for($x = 0; $x < $len; $x++) {
        $i = rand(1, count($pool))-1;
        $numbers[] = $pool[$i];
    }
    // print_r($numbers);

    $start = microtime(true);
    // asort($numbers);
    $numbers = quicksort($numbers);
    echo $len . PHP_EOL;
    echo microtime(true) - $start;
    // print_r($numbers);
    echo PHP_EOL;
}

// I compared mine (quicksort) with native PHP sort and it is slower :(
// I tried another aproach (fastsort) where you remember the index where the number needs to be inserted but it's even slower.
// Results on my Aero15x laptop
// PHP asort:
// 11
// 2.0980834960938E-5
// 100
// 1.1920928955078E-5
// 1000
// 0.00012493133544922
// 10000
// 0.001054048538208
// 100000
// 0.012047052383423
// Mine:
// 11
// 8.702278137207E-5
// 100
// 0.00088787078857422
// 1000
// 0.01394510269165
// 10000
// 0.36277103424072
// 100000
// 25.621665000916
// Time increase (for PHP function) is rougly linear and increases by factor 10. So 10 million would take 1204.7052383423 seconds (20minutes).
// My sollution grows exponentialy, equation from excel: 2.07E-5*e(3.407*x). for x=10billion laptop would need until the end of universe :)
// So in this case PHP build in sorting algorithm is better. Also seriously doubt a faster sorting
// function can be written with pure PHP since the build in ones are written in C