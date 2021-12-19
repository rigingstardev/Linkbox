ALTER TABLE `notifications` ADD `send_report_to` INT NOT NULL COMMENT '0 if not application, others - primary key of users table' AFTER `receiver_type`; 

ALTER TABLE `notifications` CHANGE `send_report_to` `send_report_to` INT(11) NOT NULL DEFAULT '0' COMMENT '0 if not application, others - primary key of users table'; 

ALTER TABLE `notifications` CHANGE `receiver_id` `receiver_id` INT(10) UNSIGNED NOT NULL COMMENT 'Can patient Id if ''notification_type '' other than 4, or physician id if the ''notification_type'' = 4 , '; 

ALTER TABLE `notifications` CHANGE `receiver_type` `receiver_type` INT(1) NOT NULL DEFAULT '1' COMMENT '1 - Physician, 2 - Patient'; 

  ALTER TABLE notifications
  DROP FOREIGN KEY  notifications_sender_id_foreign
  
  ALTER TABLE surgical_history
  DROP FOREIGN KEY  surgical_history_patient_medical_report_id_foreign
  
  ALTER TABLE `notifications` CHANGE `sender_type` `sender_type` ENUM('1','2','3') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '2' COMMENT '1 - Admin, 2 - Physician, 3 - Patient'; 
  
   