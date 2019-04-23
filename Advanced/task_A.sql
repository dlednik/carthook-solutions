CREATE TABLE `merchants_daily_analytics` (
  `merchant_id` varchar(12) NOT NULL,
  `analytics_date` date NOT NULL,
  `sales_total` decimal(8,2) NOT NULL,
  `conversions_total` int(4) NOT NULL,
  `postpurchase_revenue_total` decimal(8,2) NOT NULL,
  `visits_total` int(4) NOT NULL,
  UNIQUE KEY `merchant_analytics` (`merchant_id`,`analytics_date`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `funnels_daily_analytics` (
  `merchant_id` varchar(12) NOT NULL,
  `funnel_id` int(8) NOT NULL,
  `analytics_date` date NOT NULL,
  `sales_total` decimal(8,2) NOT NULL,
  `conversions_total` int(4) NOT NULL,
  `postpurchase_revenue_total` decimal(8,2) NOT NULL,
  `visits_total` int(4) NOT NULL,
  UNIQUE KEY `merchant_funnel_analytics` (`merchant_id`,`funnel_id`,`analytics_date`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `merchants_hourly_analytics` (
  `merchant_id` varchar(12) NOT NULL,
  `analytics_date` datetime NOT NULL,
  `sales_total` decimal(8,2) NOT NULL,
  `conversions_total` int(4) NOT NULL,
  `postpurchase_revenue_total` decimal(8,2) NOT NULL,
  `visits_total` int(4) NOT NULL,
  UNIQUE KEY `merchant_analytics` (`merchant_id`,`analytics_date`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `funnels_hourly_analytics` (
  `merchant_id` varchar(12) NOT NULL,
  `funnel_id` int(8) NOT NULL,
  `analytics_date` datetime NOT NULL,
  `sales_total` decimal(8,2) NOT NULL,
  `conversions_total` int(4) NOT NULL,
  `postpurchase_revenue_total` decimal(8,2) NOT NULL,
  `visits_total` int(4) NOT NULL,
  UNIQUE KEY `merchant_funnel_analytics` (`merchant_id`,`funnel_id`,`analytics_date`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `merchants_data` (
  `merchant_id` varchar(12) NOT NULL,
  `first_name` varchar(12) NOT NULL,
  `last_name` varchar(12) NOT NULL,
  PRIMARY KEY (`merchant_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
