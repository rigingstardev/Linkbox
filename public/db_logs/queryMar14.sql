INSERT INTO `linkbox`.`categories` (`id`, `category`, `active`, `sort_order`) VALUES (NULL, 'Category without [CC]', 'Y', NULL);

UPDATE `linkbox`.`categories` SET `sort_order` = '11' WHERE `categories`.`id` = 11; 

UPDATE `linkbox`.`categories` SET `category` = 'Others with [CC]' WHERE `categories`.`id` = 10; 

INSERT INTO `linkbox`.`category_questions` (`id`, `category_id`, `question`, `answer_type`, `comments`, `active`, `created_at`, `updated_at`) VALUES (NULL, '11', 'Specify your comments', 'textBox', NULL, 'Y', NULL, NULL);

