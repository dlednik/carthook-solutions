-- 2. Write console commands that return:
-- - best selling merchant of all the merchants (use `sales_total` column)
SELECT SUM(sales_total) as top_seller, merchant_id FROM work_task.merchants_daily_analytics GROUP BY merchant_id ORDER BY top_seller DESC LIMIT 1;

-- - best performing funnel for a specific merchant 
SELECT SUM(sales_total) as top_selling, funnel_id FROM work_task.funnels_daily_analytics WHERE merchant_id='mid_1ArmPPbx' GROUP BY funnel_id ORDER BY top_selling DESC;

-- - 3 hour time period for specific merchant when he sells most (Example: 3:00pm to 6:00pm) (bonus assignment, not necessary) 
SELECT SUM(sales_total) AS sum_hours, HOUR(analytics_date) AS ura FROM work_task.merchants_hourly_analytics WHERE merchant_id='mid_1ArmPPbx' GROUP BY ura ORDER BY ura, sum_hours;

-- - Write a SQL statement that gets an AVG `sales_total` per merchant per day  (bonus assignment, not necessary) 
SELECT AVG(sales_total) as avg_sales, merchant_id FROM work_task.merchants_daily_analytics GROUP BY merchant_id ORDER BY avg_sales DESC;