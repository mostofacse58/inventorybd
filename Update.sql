 SELECT p.id, p.product_code,p.product_name,p.`stock_qty`,p.`opening_stock`,
  (SELECT IFNULL(SUM(pu.`quantity`),0) FROM `msm_pdelivery_details` pu 
    WHERE p.`id`=pu.product_id AND pu.status=1) as pur_qty,
  (SELECT IFNULL(SUM(i.`quantity`),0) FROM `msm_delivery_details` i 
    WHERE p.`id`=i.product_id AND i.status=1) as issue_qty,
  (SELECT IFNULL(SUM(t.`stock_qty`),0) FROM `msm_product_booking` t 
    WHERE p.`id`=t.product_id AND t.booking_type='entry' AND t.status=1) as entryqty,
  (SELECT IFNULL(SUM(t.`stock_qty`),0) FROM `msm_product_booking` t 
    WHERE p.`id`=t.product_id 
    AND t.booking_type='dispatched' AND t.status=1) as dispatchedqty,
    
  FROM msm_product_info p 
  WHERE p.status=1;


SELECT C.*,(C.opening_stock+purqty+entryqty-issueqty-dispatchedqty) as ddd
FROM (

SELECT p.company_id,p.id,CONCAT("'",p.product_code) as product_code,
p.product_name,p.create_date,
p.stock_qty, p.opening_stock, 

(SELECT IFNULL(SUM(t.stock_qty),0) FROM msm_product_booking t 
    WHERE p.id=t.product_id 
    AND t.booking_type='entry' AND t.status=1) as entryqty,
(SELECT IFNULL(SUM(t.stock_qty),0) FROM msm_product_booking t 
    WHERE p.id=t.product_id 
    AND t.booking_type='dispatched' AND t.status=1) as dispatchedqty,
(SELECT IFNULL(SUM(pu.quantity),0) FROM msm_pdelivery_details pu 
    WHERE p.id=pu.product_id AND pu.status=1) as purqty, 
(SELECT IFNULL(SUM(i.quantity),0) FROM msm_delivery_details i 
    WHERE p.id=i.product_id AND i.status=1) as issueqty 
FROM msm_product_info p ) as C WHERE C.company_id=3 and C.create_date>'2024-01-19';


SELECT i.id,i.name,(SELECT GROUP_CONCAT(pd.expiry_imei_serial SEPARATOR '||') as dd 
  FROM tbl_purchase_details pd 
  WHERE i.id=pd.item_id 
  AND pd.expiry_imei_serial NOT IN ((SELECT prd.expiry_imei_serial 
  FROM tbl_purchase_return_details prd 
  WHERE prd.item_id=pd.item_id AND prd.item_id=i.id) 
  UNION 
(SELECT sd.expiry_imei_serial FROM tbl_sales_details sd, tbl_sale_return_details srd 
  WHERE sd.expiry_imei_serial!=srd.expiry_imei_serial 
  AND sd.food_menu_id=srd.item_id AND sd.food_menu_id=i.id))) as allimei, 

((SELECT IFNULL(count(pd.id),0) FROM tbl_purchase_details pd 
  WHERE i.id=pd.item_id) - (SELECT IFNULL(count(prd.id),0) FROM tbl_purchase_return_details prd 
  WHERE i.id=prd.item_id)- (SELECT IFNULL(count(sd.id),0) FROM tbl_sales_details sd 
  WHERE i.id=sd.food_menu_id) + (SELECT IFNULL(count(srd.id),0) 
  FROM tbl_sale_return_details srd WHERE i.id=srd.item_id)) as stock_qty 
 FROM tbl_items i 
 WHERE i.id = '36';

-- ////////////////////////////

INSERT INTO every_month_using_qty (SELECT NULL as id, p.product_id,'2024-07' as month, (SELECT IFNULL(SUM(ad.quantity),0) FROM spares_use_detail ad 
WHERE p.product_id=ad.product_id AND ad.date LIKE '2024-07%') as total_quantity, 
p.department_id,'2024-07-28' as last_update FROM product_info p 
WHERE p.department_id=12 AND p.product_type=2)

-- ////////////////////////////




 ALTER TABLE `msmcar_purchase_master` ADD `payment_method` VARCHAR(20) NOT NULL DEFAULT 'Cash' AFTER `grand_total_amount`;



UPDATE msm_project_note SET project_note = REPLACE(project_note, '<p>', '');
UPDATE msm_project_note SET project_note = REPLACE(project_note, '</p>', '');


CREATE TABLE msm_invoice_master_bk LIKE msm_invoice_master;








DELIMITER //

CREATE TRIGGER after_delete_invoice
AFTER DELETE ON msm_invoice_master
FOR EACH ROW
BEGIN
    INSERT INTO msm_invoice_master_bk (`id`, `inv_rinv`, `invoice_no`, `cinvoice_no`, 
      `subject`, `csubject`, `invoice_date`, `cinvoice_date`, `contact_id`, `contact_name`, 
      `contact_address`, `reference_no`, `project_reference_no`, `warehouse_id`, 
      `invoice_interval`, `next_inv_date`, `end_date`, `country_name`, `due_days`, 
      `invoice_duedate`, `delivery_date`, `header_content`, 
      `net_or_gross`, `is_gross_show`, `footer_content`, `currency`, 
      `day_wise_discount_amount`, `no_of_day`, `internal_contact_person_id`, 
      `payment_method`, `subtotal_amount`, `total_net_amount`, `grand_total_amount`, 
      `total_tax`, `total_discount`, `shipping_value`, `paid_amount`, `created_at`, 
      `updated_at`, `user_id`, `company_id`, `this_status`, 
      `pdfview`, `paid_due`, `status`)
    VALUES (OLD.`id`, OLD.`inv_rinv`,OLD. `invoice_no`, OLD.`cinvoice_no`, 
      OLD.`subject`, OLD.`csubject`, OLD.`invoice_date`, 
      OLD.`cinvoice_date`, OLD.`contact_id`, OLD.`contact_name`, 
      OLD.`contact_address`, OLD.`reference_no`, OLD.`project_reference_no`, OLD.`warehouse_id`, 
      OLD.`invoice_interval`,OLD. `next_inv_date`, OLD.`end_date`, OLD.`country_name`, OLD.`due_days`, 
      OLD.`invoice_duedate`, OLD.`delivery_date`, OLD.`header_content`, 
      OLD.`net_or_gross`, OLD.`is_gross_show`, OLD.`footer_content`, OLD.`currency`, 
      OLD.`day_wise_discount_amount`, OLD.`no_of_day`, OLD.`internal_contact_person_id`, 
      OLD.`payment_method`, OLD.`subtotal_amount`, OLD.`total_net_amount`, OLD.`grand_total_amount`, 
      OLD.`total_tax`, OLD.`total_discount`, OLD.`shipping_value`, OLD.`paid_amount`, OLD.`created_at`, 
      OLD.`updated_at`, OLD.`user_id`, OLD.`company_id`, OLD.`this_status`, 
      OLD.`pdfview`, OLD.`paid_due`, OLD.`status`);
END;


//

DELIMITER ;




UPDATE `payment_application_master` SET `pa_type` = 'Safety Stock' WHERE `payment_application_master`.`payment_id` = 14651;
UPDATE `payment_application_detail` SET `pa_type` = 'Safety Stock' WHERE `payment_application_detail`.`payment_id` = 49051;
UPDATE `payment_dept_amount` SET `pa_type` = 'Safety Stock' WHERE `payment_dept_amount`.`payment_id` = 61578;




DELETE FROM `payment_application_master` WHERE `payment_id`=15689;
DELETE FROM `payment_application_detail` WHERE `payment_id`=15689;
DELETE FROM `payment_dept_amount` WHERE `payment_id`=15689;
DELETE FROM `payment_po_amount` WHERE `payment_id`=15689;

DELETE FROM `stock_master_detail` WHERE `FIFO_CODE`='L2507051321210005';
DELETE FROM `purchase_detail` WHERE `FIFO_CODE`='L2507051321210005';
DELETE FROM `item_issue_detail` WHERE `FIFO_CODE`='L2507051321210005';


 