B) write a 1 page high level description of your solution. Answer: - what you've built - which technologies you've used how it is tied together - your reasons for high-level decisions
Write code that solves A and explain your reasoning .
(B). If you feel anything is unclear, use your own judgement to make assumptions (make sure you explain them in B).

# technologies
To give solutions to the tasks at hand I wrote code that should runs on PHP 7.x.
It was tested on my machine which has PHP version 7.2.15 installed. For testing database connectivity I used MySQL Community server
version 8.0.15. I have PHP7 on my machine because it is the latest and if possible you should always go with the latest technologies.
Decision for MySQL was in this case purly practical, it is the test server I had available in AWS.

# task_A.php
To solve this task you need to be careful that the code will run even with large files. So my code uses curl library to pull the 
files from the remote location. Reading files into memory with PHP would eventually fail here once the files get too large. Same goes for reading the files. That is why I used fopen with handles so that I can read a file one line at a time. This way I was able to generate SQL code for every line and
import it into the database. I used `ON DUPLICATE KEY UPDATE` option in case data already exists in the database in which case it will just be refreshed. 
A further improvement that could be implemented is to wrap SQL logic into a transaction:
```PHP
$sql = "START TRANSACTION;\n";
$conn->autocommit(false);
while (($line = fgets($handle)) !== false) {
    $values = strToValueArray($line);
    $sql = "INSERT INTO $tableName (`" . implode('`, `', $columns)  . "`) VALUES ('" . implode("', '", $values) . "') ON DUPLICATE KEY UPDATE ";
    for ($i=3; $i<sizeof($columns); $i++) {
        // Only pass update for none indexed fields
        if ($i>3) {
            $sql .= ', ';
        }
        $sql .= $columns[$i] . "='" . $values[$i] . "'";
    }
    $sql .= ';';
    $db->query($sql);
}
$conn->commit() or die('Error importing');
```
And again if it turns out this to be problematic for large amount of lines in a file you could group the commits in batches of 1000 lines for example.

# task_A.sql
Contains database structure. I used combined unique index over `merchant_id`,`funnel_id`,`analytics_date` or `merchant_id`,`analytics_date` fields. Because those together are unique, so it makes sense to group them together. Don't think any other indexes are neccessary for the given task.
If needed could be easily added later.  

# task_A1.php
This file contains code to randomly assign first and last names to merchant_id values. To get unique values for merchant ids you can simply
use SQL UNION, which is what I have done here. After that I again generate the correct SQL and push it into a database. I left the code to ON DUPLICATE KEY UPDATE only update the names. I did this because I assume this is to anonymize the data and so it probably doesn't matter if they get overwritten. In case this is not the case I would only insert the values if they do not yet exist.  

# task_A2
In order to get the best selling merchant of all the merchants you simply need to calculate the sum of sales and group them by merchant_id. 
To get the best one simply order it from top to bottom and only return first merchant, this is our top seller.  
  
This is simmilar to the previous one but now were looking for a specific merchant. We still need to SUM the sales but this time group it by funnel_id. Do a reverse sort and returning only 1st record gives us the top performing funnel for the merchant in quetion.  
  
This one could probably be solved with very complex SQL. I think a better way is to pull the data out for SUM of sales for hours for merchant(s).
An then check in code which three hour period is the top performing. With the data returned this way you could also display a nice chart to the merchant for the whole day. I've done charts like that for a customer before ;)  

This time we calculate AVG of sales and group it by merchant_id. I also did a descending sort to diplay them from best to worse. 