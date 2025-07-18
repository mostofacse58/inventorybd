-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2025 at 06:44 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_backup`
--

-- --------------------------------------------------------

--
-- Table structure for table `canteen_requisition_item_details`
--

CREATE TABLE `canteen_requisition_item_details` (
  `requisition_detail_id` bigint(20) NOT NULL,
  `requisition_id` bigint(20) NOT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `product_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specification` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `required_qty` decimal(11,2) NOT NULL,
  `unit_price` decimal(12,3) DEFAULT 0.000,
  `amount` decimal(12,3) NOT NULL DEFAULT 0.000,
  `remarks` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_id` int(11) NOT NULL,
  `issue_status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1-No, 2-DONE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `canteen_requisition_master`
--

CREATE TABLE `canteen_requisition_master` (
  `requisition_id` bigint(20) NOT NULL,
  `requisition_no` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_no` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pr_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1-Spares,2-Assets',
  `department_id` int(11) NOT NULL,
  `employee_id` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_note` varchar(350) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requisition_date` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `demand_date` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_by` int(11) NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `take_department_id` int(11) DEFAULT NULL,
  `responsible_department` int(11) NOT NULL,
  `create_date` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `submited_date_time` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_date` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requisition_status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0-reject,1-Create,2-Submit,3-verify,4-Approved,4-Received',
  `tpm_status` int(11) NOT NULL DEFAULT 1 COMMENT '1-Not price confirm,2-Confirm	',
  `tpm_updated_by` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tpm_updated_date` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receive_note` varchar(350) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aproved_date_time` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requisition_attachment` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `general_or_tpm` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1-General,2-TPM',
  `ie_verify` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT 'NO',
  `verify_id` int(11) DEFAULT NULL,
  `verify_name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verify_date` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `asset_encoding` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `canteen_requisition_item_details`
--
ALTER TABLE `canteen_requisition_item_details`
  ADD PRIMARY KEY (`requisition_detail_id`);

--
-- Indexes for table `canteen_requisition_master`
--
ALTER TABLE `canteen_requisition_master`
  ADD PRIMARY KEY (`requisition_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `canteen_requisition_item_details`
--
ALTER TABLE `canteen_requisition_item_details`
  MODIFY `requisition_detail_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `canteen_requisition_master`
--
ALTER TABLE `canteen_requisition_master`
  MODIFY `requisition_id` bigint(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


DROP TABLE canteen_invoice_master;

CREATE TABLE `canteen_invoice_master` (
  `invoice_id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `ref_no` VARCHAR(40)  NULL,
  `invoice_no` VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_date` VARCHAR(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoice_type` TINYINT(4) NOT NULL DEFAULT 1 ,
  `requisition_id` BIGINT(20)  NULL,
  `requisition_no` VARCHAR(40)  NULL,
  `company_id` BIGINT(20) NOT NULL,
  `company_name` VARCHAR(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_address` VARCHAR(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` VARCHAR(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_id` BIGINT(20) NOT NULL,
  `total_amount` DECIMAL(12,3) NOT NULL DEFAULT 0.000,
  `discount` DECIMAL(12,3) DEFAULT 0.000,
  `net_amount` DECIMAL(12,3) NOT NULL DEFAULT 0.000,
  `payment_status` TINYINT(4) NOT NULL DEFAULT 0 COMMENT '0=Pending, 1=Paid, 2=Partially Paid',
  `invoice_status` TINYINT(4) NOT NULL DEFAULT 1 COMMENT '1=Draft, 2=Submitted, 3=Approved, 4=Cancelled',
  `created_by`VARCHAR(250) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `received_id` INT(11) NOT NULL,
  `received_by`VARCHAR(250) NOT NULL,
  `received_date` VARCHAR(30) NULL,
  `audit_id` INT(11) NOT NULL,
  `audit_by`VARCHAR(250) NOT NULL,
  `audit_date` VARCHAR(30) NULL,
  `user_id` INT(11) NOT NULL,
  `note` VARCHAR(3000) NULL,
  PRIMARY KEY (`invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE canteen_invoice_item_details;

CREATE TABLE `canteen_invoice_item_details` (
  `item_detail_id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `invoice_id` BIGINT(20) NOT NULL,
  `product_id` BIGINT(20) DEFAULT NULL,
  `product_code` VARCHAR(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_name` VARCHAR(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specification` VARCHAR(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `required_qty` DECIMAL(12,3) DEFAULT 0.000,
  `quantity` DECIMAL(11,2) NOT NULL,
  `unit_price` DECIMAL(12,3) DEFAULT 0.000,
  `amount` DECIMAL(12,3) NOT NULL DEFAULT 0.000,
  `actualquantity` DECIMAL(11,2) NOT NULL,
  `actualunit_price` DECIMAL(12,3) DEFAULT 0.000,
  `actualamount` DECIMAL(12,3) NOT NULL DEFAULT 0.000,
  `auditquantity` DECIMAL(11,2) NOT NULL,
  `auditunit_price` DECIMAL(12,3) DEFAULT 0.000,
  `auditamount` DECIMAL(12,3) NOT NULL DEFAULT 0.000,
  `invoice_status` TINYINT(4) NOT NULL DEFAULT 1 COMMENT '1=Draft, 2=Submitted, 3=Received, 4=IA',
  `remarks` VARCHAR(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `requisition_no` VARCHAR(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`item_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
