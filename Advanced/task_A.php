<?php
// A) Import data from links (anticipate very large amounts of data here): 

// daily analytics for Merchants : https://app.periscopedata.com/api/carthook/chart/csv/d5345630-811c-cd5a-b3e2-c4a6ac1dae1a/265769  
// daily analytics for Funnels : https://app.periscopedata.com/api/carthook/chart/csv/b3bb3bbd-0ea3-8234-64bd-3cb474631c30/284541  
// hourly analytics for Merchants: https://app.periscopedata.com/api/carthook/chart/csv/5ab06803-29bf-76b2-6a5a-ad7cf4b7fc21/284541  
// hourly analytics for Funnels: https://app.periscopedata.com/api/carthook/chart/csv/b5798a66-e694-a429-cc5e-2f9e163f6438/284541  

// Into 4 DB tables with corresponding column names.

require_once('config.php');

$fileURLs = Array(
    'https://app.periscopedata.com/api/carthook/chart/csv/d5345630-811c-cd5a-b3e2-c4a6ac1dae1a/265769',
    'https://app.periscopedata.com/api/carthook/chart/csv/b3bb3bbd-0ea3-8234-64bd-3cb474631c30/284541',
    'https://app.periscopedata.com/api/carthook/chart/csv/5ab06803-29bf-76b2-6a5a-ad7cf4b7fc21/284541',
    'https://app.periscopedata.com/api/carthook/chart/csv/b5798a66-e694-a429-cc5e-2f9e163f6438/284541'
);

$tableNames = Array(
    'merchants_daily_analytics',
    'funnels_daily_analytics',
    'merchants_hourly_analytics',
    'funnels_hourly_analytics',
);

function downloadFile($fileURL, $tableName) {
    echo 'Downloading file ' . $fileURL . PHP_EOL;
    // create a new cURL resource
    $fh = fopen($tableName . '.csv', "w");
    $ch = curl_init();
    // set URL and other appropriate options
    curl_setopt($ch, CURLOPT_URL, $fileURL);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FILE, $fh); 
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // grab URL and pass it to the browser
    curl_exec($ch);
    // close cURL resource, and free up system resources
    curl_close($ch);
    fclose($fh);
}

function strToValueArray($stringData) {
    $values = explode(',', $stringData);
    // remove last column as we don't need to import it
    // it's redundant data
    unset($values[sizeof($values)-1]);
    return $values;
}

function importFile($tableName) {
    // Read file line by line and import data
    echo 'Importing file ' . $tableName . '.csv'.PHP_EOL;
    $fileName = $tableName . '.csv';
    $handle = fopen($fileName, "r");
    if ($handle) {
        $columns = strToValueArray(fgets($handle));
        // print_r($columns);
        $db = new mysqli(SERVER, USER, PASS, DB);
        if ($db->connect_errno) {
            error_log("Errno: " . $db->connect_errno . PHP_EOL);
            error_log("Error: " . $db->connect_error . PHP_EOL);
            
            // You might want to show them something nice, but we will simply exit
            die("Error: Failed to make a MySQL connection");
        }
        while (($line = fgets($handle)) !== false) {
            $values = strToValueArray($line);
            // print_r($values);
            $sql = "INSERT INTO $tableName (`" . implode('`, `', $columns)  . "`) VALUES ('" . implode("', '", $values) . "') ON DUPLICATE KEY UPDATE ";
            for ($i=3; $i<sizeof($columns); $i++) {
                // Only pass update for none indexed fields
                if ($i>3) {
                    $sql .= ', ';
                }
                $sql .= $columns[$i] . "='" . $values[$i] . "'";
            }
            $sql .= ';';
            // echo $sql . PHP_EOL;
            $db->query($sql);
            if ($db->connect_errno) {
                echo "Error: Our query failed to execute and here is why: \n";
                error_log("Query: " . $sql . PHP_EOL);
                error_log("Errno: " . $db->errno . PHP_EOL);
                error_log("Error: " . $db->error . PHP_EOL);
            }
        }
        $db->close();
    } else {
        die('Error opening file `'.$fileName.'`!!!');
    } 
}

// First download the data files
$cnt = 0;
foreach($fileURLs as $fileURL) {
    downloadFile($fileURL, $tableNames[$cnt++]);
}

// Now import them into database...
for($idx=0; $idx<4; $idx++) {
    importFile($tableNames[$idx]);
}

echo 'Done!';