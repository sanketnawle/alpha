-- ------------------------------------------------------------------------------------------------
-- This file is to be used to log any changes in the database schema. All such changes will be 
-- reviewed and moved to production. Strictly follow the format given below for the changes.  
-- Be as specific as possible while giving the reason.
-- ------------------------------------------------------------------------------------------------
-- Date: 8/18/2014
-- Reason:adding another enum review for professors not in database
-- Created by: kt
-- Module Name:user login 
-- ------------------------------------------------------------------------------------------------
-- Queries
-- ------------------------------------------------------------------------------------------------
   ALTER TABLE user MODIFY COLUMN status ENUM('invited','temp','active','inactive','review');
-- ------------------------------------------------------------------------------------------------
-- Date: 08/19/2014
-- Reason: adding color_id to groups
-- Created by: AN
-- Module Name: groups
-- ------------------------------------------------------------------------------------------------
-- Queries
	ALTER TABLE `groups`  ADD `color_id` INT(11) NOT NULL COMMENT 'linked to event_color_table color_id' AFTER `group_desc`,  ADD INDEX (`color_id`);
-- ------------------------------------------------------------------------------------------------

-- ------------------------------------------------------------------------------------------------
-- Date: 08/19/2014
-- Reason: adding color_id to classes
-- Created by: AN
-- Module Name: courses_semester
-- ------------------------------------------------------------------------------------------------
-- Queries
	ALTER TABLE `courses_semester`  ADD `color_id` INT(11) NOT NULL COMMENT 'linked to event_color_table color_id',  ADD INDEX (`color_id`);
-- ------------------------------------------------------------------------------------------------

-- ------------------------------------------------------------------------------------------------
-- Date: 08/20/2014
-- Reason: removing foreign key constraint on file_id from showcase to store IDs from different tables. 
-- Created by: KU
-- Module Name: profile_showcase
-- ------------------------------------------------------------------------------------------------
-- Queries
	ALTER TABLE `showcase`  DROP FOREIGN KEY `showcase_ibfk_2`; 
-- ------------------------------------------------------------------------------------------------

-- ------------------------------------------------------------------------------------------------
-- Date: 08/26/2014
-- Reason: Adding component column in courses_semester to store type of class
-- Created by: AN
-- Module Name: courses_semester
-- ------------------------------------------------------------------------------------------------
-- Queries
	ALTER TABLE `courses_semester`  ADD `component` VARCHAR(200) NOT NULL DEFAULT 'Lecture' COMMENT 'type of class' AFTER `year`
-- ------------------------------------------------------------------------------------------------
-- ------------------------------------------------------------------------------------------------
-- Date: 8/28/2014
-- Reason:change of hash from sha1 to sha512
-- Created by:kt
-- Module Name: user_login
-- ------------------------------------------------------------------------------------------------
-- Queries
	ALTER TABLE login RENAME user_login
 	ALTER TABLE user_login CHANGE password VARCHAR(512);
-- ------------------------------------------------------------------------------------------------
-- ------------------------------------------------------------------------------------------------
-- Date: 8/28/2014
-- Reason: sync event option and notification option
-- Created by:AN
-- Module Name: courses_user
-- ------------------------------------------------------------------------------------------------
 -- Queries
	ALTER TABLE `courses_user`  ADD `sync_events` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'sync all events for this class' AFTER `is_admin`,  
ADD `notifications` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'show notifications for this class' AFTER `sync_events`;
-- ------------------------------------------------------------------------------------------------
-- ------------------------------------------------------------------------------------------------
-- Date: 9/2/2014
-- Reason: Add bug report to prod
-- Created by:KU
-- Module Name: bug report
-- ------------------------------------------------------------------------------------------------
-- Queries
	CREATE TABLE `bug_report` (
 `user_id` int(11) NOT NULL,
 `bug_description` varchar(500) NOT NULL,
 `logged_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
 KEY `user_id` (`user_id`),
 CONSTRAINT `bug_report_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Bug Report Table'
-- ------------------------------------------------------------------------------------------------

