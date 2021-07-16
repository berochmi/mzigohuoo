-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 16, 2021 at 04:04 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bakery`
--

-- --------------------------------------------------------

--
-- Structure for view `v_sales_products`
--

CREATE  VIEW `v_sales_products`  AS  select `a`.`c0d` AS `c0d`,`a`.`sale_id` AS `sale_id`,`c`.`sale_no` AS `sale_no`,`c`.`customer_id` AS `customer_id`,`c`.`customer_name` AS `customer_name`,`c`.`customer_code` AS `customer_code`,`c`.`sale_date` AS `sale_date`,`c`.`sale_type` AS `sale_type`,`c`.`status` AS `status`,`a`.`product_id` AS `product_id`,`b`.`name` AS `product_name`,`b`.`description` AS `product_description`,`b`.`category` AS `product_category`,`b`.`selling_price` AS `selling_price`,`b`.`uom` AS `uom`,`b`.`cost` AS `product_cost`,`b`.`vat` AS `vat`,`b`.`vat_incl` AS `vat_incl`,`a`.`sale_qty` AS `sale_qty`,`a`.`sale_price` AS `sale_price`,`a`.`sale_discount` AS `sale_discount`,`a`.`sale_qty` * `a`.`sale_price` - `b`.`vat_incl` * (`a`.`sale_price` * `a`.`sale_qty` * 100 * `b`.`vat` / (100 * (100 + `b`.`vat_incl` * `b`.`vat`))) - (`a`.`sale_qty` * `a`.`sale_price` - `b`.`vat_incl` * (`a`.`sale_price` * `a`.`sale_qty` * 100 * `b`.`vat` / (100 * (100 + `b`.`vat_incl` * `b`.`vat`)))) * `a`.`sale_discount` / 100 + (`a`.`sale_qty` * `a`.`sale_price` - `b`.`vat_incl` * (`a`.`sale_price` * `a`.`sale_qty` * 100 * `b`.`vat` / (100 * (100 + `b`.`vat_incl` * `b`.`vat`))) - (`a`.`sale_qty` * `a`.`sale_price` - `b`.`vat_incl` * (`a`.`sale_price` * `a`.`sale_qty` * 100 * `b`.`vat` / (100 * (100 + `b`.`vat_incl` * `b`.`vat`)))) * `a`.`sale_discount` / 100) * `b`.`vat` / 100 AS `sale_product_total_amount`,(`a`.`sale_qty` * `a`.`sale_price` - `b`.`vat_incl` * (`a`.`sale_price` * `a`.`sale_qty` * 100 * `b`.`vat` / (100 * (100 + `b`.`vat_incl` * `b`.`vat`))) - (`a`.`sale_qty` * `a`.`sale_price` - `b`.`vat_incl` * (`a`.`sale_price` * `a`.`sale_qty` * 100 * `b`.`vat` / (100 * (100 + `b`.`vat_incl` * `b`.`vat`)))) * `a`.`sale_discount` / 100) * `b`.`vat` / 100 AS `sale_product_total_tax_amount`,`a`.`sale_qty` * `a`.`sale_price` - `b`.`vat_incl` * (`a`.`sale_price` * `a`.`sale_qty` * 100 * `b`.`vat` / (100 * (100 + `b`.`vat_incl` * `b`.`vat`))) AS `sale_product_total_wo_tax`,(`a`.`sale_qty` * `a`.`sale_price` - `b`.`vat_incl` * (`a`.`sale_price` * `a`.`sale_qty` * 100 * `b`.`vat` / (100 * (100 + `b`.`vat_incl` * `b`.`vat`)))) * `a`.`sale_discount` / 100 AS `sale_product_discount_amount`,(`a`.`sale_qty` * `a`.`sale_price` - `b`.`vat_incl` * (`a`.`sale_price` * `a`.`sale_qty` * 100 * `b`.`vat` / (100 * (100 + `b`.`vat_incl` * `b`.`vat`))) - (`a`.`sale_qty` * `a`.`sale_price` - `b`.`vat_incl` * (`a`.`sale_price` * `a`.`sale_qty` * 100 * `b`.`vat` / (100 * (100 + `b`.`vat_incl` * `b`.`vat`)))) * `a`.`sale_discount` / 100) * `b`.`vat` / 100 AS `real_product_vat_amount`,`a`.`sale_qty` * `a`.`sale_price` - `b`.`vat_incl` * (`a`.`sale_price` * `a`.`sale_qty` * 100 * `b`.`vat` / (100 * (100 + `b`.`vat_incl` * `b`.`vat`))) - (`a`.`sale_qty` * `a`.`sale_price` - `b`.`vat_incl` * (`a`.`sale_price` * `a`.`sale_qty` * 100 * `b`.`vat` / (100 * (100 + `b`.`vat_incl` * `b`.`vat`)))) * `a`.`sale_discount` / 100 + (`a`.`sale_qty` * `a`.`sale_price` - `b`.`vat_incl` * (`a`.`sale_price` * `a`.`sale_qty` * 100 * `b`.`vat` / (100 * (100 + `b`.`vat_incl` * `b`.`vat`))) - (`a`.`sale_qty` * `a`.`sale_price` - `b`.`vat_incl` * (`a`.`sale_price` * `a`.`sale_qty` * 100 * `b`.`vat` / (100 * (100 + `b`.`vat_incl` * `b`.`vat`)))) * `a`.`sale_discount` / 100) * `b`.`vat` / 100 AS `real_sale_product_total_amount`,`a`.`store_id` AS `store_id`,`a`.`deleted` AS `deleted`,`a`.`created_by` AS `created_by`,`a`.`created_on` AS `created_on`,`a`.`edited_by` AS `edited_by`,`a`.`edited_on` AS `edited_on` from ((`sales_products` `a` left join `products` `b` on(`b`.`c0d` = `a`.`product_id`)) left join `v_sales` `c` on(`c`.`c0d` = `a`.`sale_id`)) ;

--
-- VIEW  `v_sales_products`
-- Data: None
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
