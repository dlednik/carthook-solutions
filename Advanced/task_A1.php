<?php
// 1. Write a function that populates a 5th table which will contain 
// merchant_id’s (unique) and two columns with randomly generated merchant names (first_name, last_name)

require_once('config.php');

function randomizeMerchantNames() {
    $namesArray = Array();
    $lastNamesArray = Array();
    $handle = fopen('names.txt', "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $values = explode(' ', $line);
            $namesArray[] = $values[0];
            $lastNamesArray[] = $values[1];
        }
    } else {
        die('Error opening file `names.txt`!!!');
    }

    // print_r($columns);
    $db = new mysqli(SERVER, USER, PASS, DB);
    $sql = 'SELECT merchant_id FROM merchants_daily_analytics UNION SELECT merchant_id FROM funnels_daily_analytics UNION SELECT merchant_id FROM merchants_hourly_analytics UNION SELECT merchant_id FROM funnels_hourly_analytics;';
    $results = $db->query($sql);
    while ($result = $results->fetch_assoc()) {
        $randomName = $namesArray[rand(0, 199)];
        $randomLastNames = $lastNamesArray[rand(0, 199)];
        $sql = "INSERT INTO merchants_data (`merchant_id`, `first_name`, `last_name`) VALUES ('".$result['merchant_id']."', '$randomName', '$randomLastNames') ON DUPLICATE KEY UPDATE first_name='$randomName', last_name='$randomLastNames';";
        // echo $sql . PHP_EOL;
        $db->query($sql);
    }
    $db->close();
}

// To test run the function...
randomizeMerchantNames();