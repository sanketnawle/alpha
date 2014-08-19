--- ------------------------------------------------------------------------------------------------
--- This file is to be used to log any changes in the database schema. All such changes will be 
--- reviewed and moved to production. Strictly follow the format given below for the changes.  
--- Be as specific as possible while giving the reason.
--- ------------------------------------------------------------------------------------------------
--- Date: 8/18/2014
--- Reason:adding another enum review for professors not in database
--- Created by: kt
--- Module Name:user login 
--- ------------------------------------------------------------------------------------------------
--- Queries
--- ------------------------------------------------------------------------------------------------
   ALTER TABLE user MODIFY COLUMN status ENUM('invited','temp','active','inactive','review');
--- ------------------------------------------------------------------------------------------------
--- Date: 08/19/2014
--- Reason: adding color_id to groups
--- Created by: AN
--- Module Name: groups
--- ------------------------------------------------------------------------------------------------
--- Queries
	ALTER TABLE `groups`  ADD `color_id` INT(11) NOT NULL COMMENT 'linked to event_color_table color_id' AFTER `group_desc`,  ADD INDEX (`color_id`) 
--- ------------------------------------------------------------------------------------------------

--- ------------------------------------------------------------------------------------------------
--- Date: 08/19/2014
--- Reason: adding color_id to classes
--- Created by: AN
--- Module Name: courses_semester
--- ------------------------------------------------------------------------------------------------
--- Queries
	ALTER TABLE `courses_semester`  ADD `color_id` INT(11) NOT NULL COMMENT 'linked to event_color_table color_id',  ADD INDEX (`color_id`) 
--- ------------------------------------------------------------------------------------------------

--- ------------------------------------------------------------------------------------------------
--- Date: 
--- Reason:
--- Created by:
--- Module Name: 
--- ------------------------------------------------------------------------------------------------
--- Queries

--- ------------------------------------------------------------------------------------------------

