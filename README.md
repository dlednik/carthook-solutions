_Please note: If possible, try to use Laravel with exercises where it makes sense._

## Basic CS

Solve exercises A,B,C,D and explain your reasoning. It's ok to use pseudo code where needed. Or any popular language you're comfortable with (except if noted otherwise).

A) Design a SQL database to store NBA players, teams and games (column and table contents are all up to you). Users mostly query game results by date and team name. The second most frequent query is players statistics by player name.

B) How would you find files that begin with "0aH" and delete them given a folder (with subfolders)? Assume there are many files in the folder.

C) Write a function that sorts 11 small numbers (<100) as fast as possible. Estimate how long it would take to execute that function 10 Billion (10^10) times on a normal machine?

D) Write a function that sorts 10000 powers (a^b) where a and b are random numbers between 100 and 10000? Estimate how long it would take on your machine?

## Advanced/Practical

A) Import data from links (anticipate very large amounts of data here): 

daily analytics for Merchants : https://app.periscopedata.com/api/carthook/chart/csv/d5345630-811c-cd5a-b3e2-c4a6ac1dae1a/265769  
daily analytics for Funnels : https://app.periscopedata.com/api/carthook/chart/csv/b3bb3bbd-0ea3-8234-64bd-3cb474631c30/284541  
hourly analytics for Merchants: https://app.periscopedata.com/api/carthook/chart/csv/5ab06803-29bf-76b2-6a5a-ad7cf4b7fc21/284541  
hourly analytics for Funnels: https://app.periscopedata.com/api/carthook/chart/csv/b5798a66-e694-a429-cc5e-2f9e163f6438/284541  

Into 4 DB tables with corresponding column names.

1. Write a function that populates a 5th table which will contain merchant_id’s (unique) and two columns with randomly generated merchant names (first_name, last_name)

2. Write console commands that return:
- best selling merchant of all the merchants (use `sales_total` column)
- best performing funnel for a specific merchant 
- 3 hour time period for specific merchant when he sells most (Example: 3:00pm to 6:00pm) (bonus assignment, not necessary) 
- Write a SQL statement that gets an AVG `sales_total` per merchant per day  (bonus assignment, not necessary) 

B) write a 1 page high level description of your solution. Answer: - what you've built - which technologies you've used how it is tied together - your reasons for high-level decisions
Write code that solves A and explain your reasoning .
(B). If you feel anything is unclear, use your own judgement to make assumptions (make sure you explain them in B).