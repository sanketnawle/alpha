-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 30, 2014 at 10:01 AM
-- Server version: 5.5.38-35.2-log
-- PHP Version: 5.4.23

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `campusla_urlinq_beta`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `club_member_count`$$
CREATE DEFINER=`campusla`@`localhost` PROCEDURE `club_member_count`(IN `id` INT, OUT `name` INT)
    NO SQL
BEGIN
SET name = group_name;
SELECT group_name 
FROM groups 
WHERE group_id=id;
END$$

DROP PROCEDURE IF EXISTS `testProc`$$
CREATE DEFINER=`campusla`@`localhost` PROCEDURE `testProc`(OUT `v_class_id` CHAR(36), IN `course_id` VARCHAR(20), IN `univ_id` INT, IN `dept_id` INT, IN `semester` ENUM('fall','spring','summer',''), IN `section_id` VARCHAR(20))
    NO SQL
BEGIN
SET v_class_id = section_id;
SELECT class_id INTO v_class_id FROM courses_semester
WHERE `course_id` = course_id
AND `univ_id` = univ_id
AND `dept_id` = dept_id
AND `section_id` = v_class_id
AND `semester` = semester;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bug_report`
--

DROP TABLE IF EXISTS `bug_report`;
CREATE TABLE IF NOT EXISTS `bug_report` (
  `user_id` int(11) NOT NULL,
  `bug_description` varchar(500) NOT NULL,
  `logged_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Bug Report Table';

-- --------------------------------------------------------

--
-- Table structure for table `class_rating`
--

DROP TABLE IF EXISTS `class_rating`;
CREATE TABLE IF NOT EXISTS `class_rating` (
  `user_id` int(11) NOT NULL,
  `class_id` char(36) NOT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`,`class_id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class_review`
--

DROP TABLE IF EXISTS `class_review`;
CREATE TABLE IF NOT EXISTS `class_review` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `class_id` char(36) NOT NULL,
  `anonymous` tinyint(1) NOT NULL,
  `review` text,
  `agree` int(11) NOT NULL DEFAULT '0',
  `disagree` int(11) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_id`),
  KEY `user_id` (`user_id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='student review on classes' AUTO_INCREMENT=46 ;

-- --------------------------------------------------------

--
-- Table structure for table `class_review_vote`
--

DROP TABLE IF EXISTS `class_review_vote`;
CREATE TABLE IF NOT EXISTS `class_review_vote` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vote` varchar(8) NOT NULL,
  PRIMARY KEY (`review_id`,`user_id`),
  KEY `user_id` (`user_id`,`vote`),
  KEY `review_id` (`review_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `confirmation`
--

DROP TABLE IF EXISTS `confirmation`;
CREATE TABLE IF NOT EXISTS `confirmation` (
  `user_id` int(11) NOT NULL,
  `key_email` varchar(255) NOT NULL,
  `time_confirm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `connect`
--

DROP TABLE IF EXISTS `connect`;
CREATE TABLE IF NOT EXISTS `connect` (
  `from_user_id` int(11) NOT NULL COMMENT 'refers to user_id in user table',
  `to_user_id` int(11) NOT NULL COMMENT 'Refers to user(user_id)',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`from_user_id`,`to_user_id`),
  KEY `to_user_id` (`to_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='table stores the connections for all the users';

--
-- Triggers `connect`
--
DROP TRIGGER IF EXISTS `follow_notification`;
DELIMITER //
CREATE TRIGGER `follow_notification` AFTER INSERT ON `connect`
 FOR EACH ROW BEGIN
 
  INSERT INTO general_notifications(owner_id,actor_id,notification_type,id, status) VALUES (NEW.to_user_id, NEW.from_user_id,
  'follow', NEW.from_user_id, 1);
 END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `course_id` varchar(20) NOT NULL,
  `dept_id` int(11) NOT NULL COMMENT 'Refers to department(dept_id)',
  `univ_id` int(11) NOT NULL COMMENT 'refers to university(univ_id)',
  `course_name` varchar(50) NOT NULL,
  `course_desc` text NOT NULL,
  `course_credits` int(11) NOT NULL,
  `course_type` enum('grad','undergrad','phd','both') DEFAULT NULL,
  `dp_blob_id` int(64) unsigned DEFAULT NULL COMMENT 'display_picture img_id',
  `course_visibility_id` int(11) NOT NULL DEFAULT '0' COMMENT 'This column referes to the courses_visibility table',
  PRIMARY KEY (`course_id`,`dept_id`,`univ_id`),
  KEY `dept_id` (`dept_id`),
  KEY `univ_id` (`univ_id`),
  KEY `dp_blob_id` (`dp_blob_id`),
  KEY `courses_visibility_index` (`course_visibility_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `courses_semester`
--

DROP TABLE IF EXISTS `courses_semester`;
CREATE TABLE IF NOT EXISTS `courses_semester` (
  `course_id` varchar(20) NOT NULL COMMENT 'refers to course(course_id)',
  `dept_id` int(11) NOT NULL COMMENT 'Refers to department(dept_id)',
  `univ_id` int(11) NOT NULL COMMENT 'refers to university(univ_id)',
  `section_id` varchar(20) NOT NULL,
  `semester` enum('fall','spring','summer') NOT NULL DEFAULT 'spring',
  `year` year(4) NOT NULL COMMENT 'year',
  `component` varchar(200) NOT NULL DEFAULT 'Lecture' COMMENT 'type of class',
  `color_id` int(11) DEFAULT NULL COMMENT 'linked to event_color_table color_id',
  `class_id` char(36) NOT NULL COMMENT 'Has unique key for each class (updated through trigger)',
  `location` varchar(100) NOT NULL DEFAULT 'TBA',
  `professor` int(11) DEFAULT NULL COMMENT 'due to collected data inconsistency',
  `cover_blob_id` int(64) unsigned DEFAULT NULL COMMENT 'course_cover',
  `dp_blob_id` int(64) unsigned DEFAULT NULL COMMENT 'display picture id',
  `syllabus_id` bigint(20) unsigned DEFAULT NULL COMMENT 'syylabus from file_upload',
  PRIMARY KEY (`course_id`,`dept_id`,`univ_id`,`section_id`,`semester`,`year`),
  UNIQUE KEY `class_id_2` (`class_id`),
  KEY `dept_id` (`dept_id`),
  KEY `univ_id` (`univ_id`),
  KEY `section_id` (`section_id`),
  KEY `class_id` (`class_id`),
  KEY `cs_fk_1` (`univ_id`,`dept_id`),
  KEY `cover_blob` (`cover_blob_id`),
  KEY `dp_blob_id` (`dp_blob_id`),
  KEY `syllabus_id` (`syllabus_id`),
  KEY `color_id` (`color_id`),
  KEY `professor` (`professor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `courses_semester`
--
DROP TRIGGER IF EXISTS `classid_insert`;
DELIMITER //
CREATE TRIGGER `classid_insert` BEFORE INSERT ON `courses_semester`
 FOR EACH ROW BEGIN
IF NEW.class_id = NULL
THEN
 SET NEW.class_id = UUID();
END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `courses_semester_schedule`
--

DROP TABLE IF EXISTS `courses_semester_schedule`;
CREATE TABLE IF NOT EXISTS `courses_semester_schedule` (
  `class_id` char(36) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  PRIMARY KEY (`class_id`,`schedule_id`),
  KEY `schedule_id` (`schedule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Defines the schedule for each class.';

-- --------------------------------------------------------

--
-- Table structure for table `courses_user`
--

DROP TABLE IF EXISTS `courses_user`;
CREATE TABLE IF NOT EXISTS `courses_user` (
  `class_id` char(36) NOT NULL,
  `user_id` int(11) NOT NULL,
  `color_id` int(11) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `sync_events` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'sync all events for this class',
  `notifications` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'show notifications for this class',
  PRIMARY KEY (`class_id`,`user_id`),
  KEY `user_id` (`user_id`),
  KEY `color_id` (`color_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Stores the users who have joined the class';

-- --------------------------------------------------------

--
-- Table structure for table `courses_visibility`
--

DROP TABLE IF EXISTS `courses_visibility`;
CREATE TABLE IF NOT EXISTS `courses_visibility` (
  `visibility_id` int(11) NOT NULL COMMENT 'Contains the ID which will be used as a foriegn key to refer the property',
  `visibility_property` varchar(30) NOT NULL COMMENT 'The corresponding visibility property',
  PRIMARY KEY (`visibility_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_bookmarks`
--

DROP TABLE IF EXISTS `course_bookmarks`;
CREATE TABLE IF NOT EXISTS `course_bookmarks` (
  `class_id` char(36) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`class_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='only courses for a particular user';

-- --------------------------------------------------------

--
-- Table structure for table `course_event`
--

DROP TABLE IF EXISTS `course_event`;
CREATE TABLE IF NOT EXISTS `course_event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` char(36) NOT NULL COMMENT 'Refers to courses_semester(class_id)',
  `title` varchar(255) NOT NULL,
  `description` varchar(500) NOT NULL,
  `start_time` time NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Refers to user(user_id)',
  `recurrence` enum('none','daily','weekly','monthly') NOT NULL,
  `end_time` time DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `is_check` tinyint(1) NOT NULL DEFAULT '0',
  `file_id` bigint(20) unsigned DEFAULT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `theme_id` int(11) DEFAULT '1',
  `location` varchar(255) DEFAULT NULL,
  `hide_notification` tinyint(1) NOT NULL DEFAULT '0',
  `event_class` enum('Essay','Project','Assignment','Guest Lecture','Exam','Lecture','Presentation','Recitation') NOT NULL,
  `made_by_admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1-made by admin;0-normal user',
  PRIMARY KEY (`event_id`),
  KEY `group_id` (`class_id`),
  KEY `user_id` (`user_id`),
  KEY `theme_id` (`theme_id`),
  KEY `file_id` (`file_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Table structure for table `course_event_invited`
--

DROP TABLE IF EXISTS `course_event_invited`;
CREATE TABLE IF NOT EXISTS `course_event_invited` (
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `choice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1:Accept;2:Maybe;3:Decline',
  `show_notification` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:never_show;1:unseen;2:shown;3:seen',
  `is_check` tinyint(1) NOT NULL DEFAULT '0',
  `hide_notification` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_event_meta`
--

DROP TABLE IF EXISTS `course_event_meta`;
CREATE TABLE IF NOT EXISTS `course_event_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `course_files`
--

DROP TABLE IF EXISTS `course_files`;
CREATE TABLE IF NOT EXISTS `course_files` (
  `class_id` char(36) NOT NULL,
  `file_id` bigint(20) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `text_msg` text,
  PRIMARY KEY (`class_id`,`file_id`),
  KEY `class_id` (`class_id`),
  KEY `file_id` (`file_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_follow`
--

DROP TABLE IF EXISTS `course_follow`;
CREATE TABLE IF NOT EXISTS `course_follow` (
  `course_id` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`course_id`,`user_id`),
  KEY `course_id_2` (`course_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Users following courses';

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
CREATE TABLE IF NOT EXISTS `department` (
  `dept_id` int(11) NOT NULL AUTO_INCREMENT,
  `univ_id` int(11) NOT NULL COMMENT 'refers to univ id in university',
  `dept_name` varchar(255) NOT NULL,
  `dept_desc` tinytext,
  `dept_location` tinytext,
  `alias` varchar(20) DEFAULT NULL,
  `dp_blob_id` int(64) unsigned DEFAULT NULL,
  `cover_blob_id` int(64) unsigned DEFAULT NULL,
  PRIMARY KEY (`dept_id`),
  KEY `univ_id` (`univ_id`),
  KEY `dp_blob_id` (`dp_blob_id`),
  KEY `cover_pic_id` (`cover_blob_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `department_follow`
--

DROP TABLE IF EXISTS `department_follow`;
CREATE TABLE IF NOT EXISTS `department_follow` (
  `dept_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  KEY `dept_id` (`dept_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `discussion_table`
--

DROP TABLE IF EXISTS `discussion_table`;
CREATE TABLE IF NOT EXISTS `discussion_table` (
  `event_id` int(11) NOT NULL,
  `disc_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  PRIMARY KEY (`disc_id`),
  KEY `user_id` (`user_id`),
  KEY `event_id` (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=257 ;

-- --------------------------------------------------------

--
-- Table structure for table `display_picture`
--

DROP TABLE IF EXISTS `display_picture`;
CREATE TABLE IF NOT EXISTS `display_picture` (
  `img_id` int(64) unsigned NOT NULL AUTO_INCREMENT,
  `img_name` varchar(64) NOT NULL,
  `img_content` mediumblob NOT NULL,
  `img_type` varchar(128) NOT NULL,
  PRIMARY KEY (`img_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=226 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_color_table`
--

DROP TABLE IF EXISTS `event_color_table`;
CREATE TABLE IF NOT EXISTS `event_color_table` (
  `color_id` int(11) NOT NULL AUTO_INCREMENT,
  `red_code` smallint(6) NOT NULL DEFAULT '255',
  `green_code` smallint(6) NOT NULL DEFAULT '255',
  `blue_code` smallint(6) NOT NULL DEFAULT '255',
  PRIMARY KEY (`color_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_notfications`
--

DROP TABLE IF EXISTS `event_notfications`;
CREATE TABLE IF NOT EXISTS `event_notfications` (
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `event_type` tinyint(4) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`notification_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event_types`
--

DROP TABLE IF EXISTS `event_types`;
CREATE TABLE IF NOT EXISTS `event_types` (
  `event_name` varchar(20) NOT NULL,
  `type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `file_upload`
--

DROP TABLE IF EXISTS `file_upload`;
CREATE TABLE IF NOT EXISTS `file_upload` (
  `file_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL COMMENT 'Name given by the user uploading the file',
  `file_content` longblob NOT NULL COMMENT 'Actual location on server',
  `file_type` varchar(255) DEFAULT NULL,
  `created_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=380 ;

-- --------------------------------------------------------

--
-- Table structure for table `gdrive_share`
--

DROP TABLE IF EXISTS `gdrive_share`;
CREATE TABLE IF NOT EXISTS `gdrive_share` (
  `file_id` bigint(40) unsigned NOT NULL AUTO_INCREMENT,
  `file_gdrive_id` varchar(255) NOT NULL,
  `file_name` varchar(512) NOT NULL,
  `file_url` varchar(512) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `general_notifications`
--

DROP TABLE IF EXISTS `general_notifications`;
CREATE TABLE IF NOT EXISTS `general_notifications` (
  `owner_id` int(11) NOT NULL COMMENT 'user on whom an action is made',
  `actor_id` int(11) NOT NULL COMMENT 'user whose action created this notification',
  `notification_type` varchar(50) NOT NULL COMMENT 'determines the type of notification; cr_invite->course_invite;gr_invite->group_invite;',
  `id` char(36) DEFAULT NULL COMMENT 'id triggered this notification',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `notification_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `check_point` bigint(20) unsigned DEFAULT NULL,
  `group_check_pt` int(11) DEFAULT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=754 ;

-- --------------------------------------------------------

--
-- Table structure for table `google_events`
--

DROP TABLE IF EXISTS `google_events`;
CREATE TABLE IF NOT EXISTS `google_events` (
  `event_id` varchar(30) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `location` text NOT NULL,
  `start_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_date` date NOT NULL,
  `end_time` time NOT NULL,
  `recurrence` varchar(10) NOT NULL,
  `team_id` varchar(20) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Google Calendar Events';

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `univ_id` int(11) NOT NULL COMMENT 'refers to university(univ_id)',
  `group_name` varchar(255) NOT NULL,
  `group_desc` varchar(500) NOT NULL,
  `color_id` int(11) DEFAULT NULL COMMENT 'linked to event_color_table color_id',
  `contact_email` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `founded_on` date DEFAULT NULL,
  `dp_blob_id` int(64) unsigned DEFAULT NULL,
  `cover_blob_id` int(64) unsigned DEFAULT NULL,
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `univ_id` (`univ_id`,`group_name`),
  KEY `cover_pic_id` (`cover_blob_id`),
  KEY `dp_id` (`dp_blob_id`),
  KEY `color_id` (`color_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59198599 ;

--
-- Triggers `groups`
--
DROP TRIGGER IF EXISTS `random_id`;
DELIMITER //
CREATE TRIGGER `random_id` BEFORE INSERT ON `groups`
 FOR EACH ROW SET NEW.group_id = UUID()
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_files`
--

DROP TABLE IF EXISTS `groups_files`;
CREATE TABLE IF NOT EXISTS `groups_files` (
  `group_id` int(11) NOT NULL COMMENT 'refers to the groups(group_id)',
  `file_id` bigint(20) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_description` text,
  PRIMARY KEY (`group_id`,`file_id`,`user_id`),
  KEY `user_id` (`user_id`),
  KEY `file_id` (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Files uploaded to the clubs directly';

-- --------------------------------------------------------

--
-- Table structure for table `group_event`
--

DROP TABLE IF EXISTS `group_event`;
CREATE TABLE IF NOT EXISTS `group_event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL COMMENT 'Refers to groups(group_id)',
  `title` varchar(255) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `start_time` time NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Refers to user(user_id)',
  `recurrence` enum('none','daily','weekly','monthly') NOT NULL,
  `end_time` time NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `file_id` bigint(20) unsigned DEFAULT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `theme_id` int(11) DEFAULT '1',
  `location` varchar(255) DEFAULT NULL,
  `privacy` enum('all','admins','prof','student') NOT NULL DEFAULT 'all',
  `made_by_admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1-made by admin;0-normal user',
  PRIMARY KEY (`event_id`),
  KEY `group_id` (`group_id`),
  KEY `user_id` (`user_id`),
  KEY `file_id` (`file_id`),
  KEY `theme_id` (`theme_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=266 ;

-- --------------------------------------------------------

--
-- Table structure for table `group_event_invited`
--

DROP TABLE IF EXISTS `group_event_invited`;
CREATE TABLE IF NOT EXISTS `group_event_invited` (
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `added` tinyint(1) NOT NULL DEFAULT '0',
  `show_notification` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:never_show;1:show;2:shown;3:seen',
  PRIMARY KEY (`event_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `group_event_meta`
--

DROP TABLE IF EXISTS `group_event_meta`;
CREATE TABLE IF NOT EXISTS `group_event_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `group_users`
--

DROP TABLE IF EXISTS `group_users`;
CREATE TABLE IF NOT EXISTS `group_users` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `color_id` int(11) DEFAULT NULL,
  `join_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`group_id`,`user_id`),
  KEY `user_id` (`user_id`),
  KEY `color_id` (`color_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `group_users`
--
DROP TRIGGER IF EXISTS `new_member_notification`;
DELIMITER //
CREATE TRIGGER `new_member_notification` AFTER INSERT ON `group_users`
 FOR EACH ROW BEGIN
  DECLARE v_user_admin INT;
  DECLARE v_gname VARCHAR(200);
  
  IF NEW.is_admin = 0 THEN
	BEGIN
	   SELECT gu.user_id, g.group_name INTO v_user_admin, v_gname
		FROM group_users gu JOIN groups g
		ON (gu.group_id = g.group_id)
	   WHERE is_admin = 1
		 AND gu.group_id = NEW.group_id;
		
		IF v_user_admin IS NOT NULL THEN
		  BEGIN
			INSERT INTO general_notifications(owner_id,actor_id,notification_type,id,status) VALUES (v_user_admin, NEW.user_id,
					'gr_member', NEW.group_id, 1);
		  END;
		END IF;
	END;
  END IF;
 END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `group_users_tags`
--

DROP TABLE IF EXISTS `group_users_tags`;
CREATE TABLE IF NOT EXISTS `group_users_tags` (
  `tag_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `interests`
--

DROP TABLE IF EXISTS `interests`;
CREATE TABLE IF NOT EXISTS `interests` (
  `interest_id` int(11) NOT NULL AUTO_INCREMENT,
  `interest_type` varchar(255) DEFAULT NULL,
  `interest` varchar(100) NOT NULL,
  PRIMARY KEY (`interest_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

-- --------------------------------------------------------

--
-- Table structure for table `invites`
--

DROP TABLE IF EXISTS `invites`;
CREATE TABLE IF NOT EXISTS `invites` (
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `event_type` tinyint(1) NOT NULL,
  `choice` tinyint(1) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `parent_university`
--

DROP TABLE IF EXISTS `parent_university`;
CREATE TABLE IF NOT EXISTS `parent_university` (
  `parent_univ_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_univ_name` varchar(255) NOT NULL,
  `parent_univ_location` varchar(255) NOT NULL,
  `alias` varchar(20) DEFAULT NULL,
  `weblink` varchar(255) DEFAULT NULL,
  `dp_blob_id` int(64) unsigned DEFAULT NULL COMMENT 'display picture',
  `cover_blob_id` int(64) unsigned DEFAULT NULL COMMENT 'cover picture',
  PRIMARY KEY (`parent_univ_id`),
  KEY `dp_blob_id` (`dp_blob_id`),
  KEY `cover_blob_id` (`cover_blob_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `personal_event`
--

DROP TABLE IF EXISTS `personal_event`;
CREATE TABLE IF NOT EXISTS `personal_event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'Refers to user(user_id)',
  `title` varchar(255) NOT NULL COMMENT 'title of the event',
  `description` varchar(255) DEFAULT NULL,
  `start_time` time NOT NULL,
  `is_check` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-not checked',
  `end_time` time NOT NULL,
  `invites` tinyint(1) NOT NULL DEFAULT '0',
  `recurrence` enum('none','daily','weekly','monthly') NOT NULL DEFAULT 'none',
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `file_id` bigint(20) unsigned DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'time the event was added',
  `theme_id` int(11) DEFAULT '1',
  `reminder_time` timestamp NULL DEFAULT NULL,
  `color_id` int(11) NOT NULL DEFAULT '1',
  `hide_notification` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`event_id`),
  KEY `user_id` (`user_id`),
  KEY `file_id` (`file_id`),
  KEY `theme_id` (`theme_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=346 ;

-- --------------------------------------------------------

--
-- Table structure for table `personal_event_invited`
--

DROP TABLE IF EXISTS `personal_event_invited`;
CREATE TABLE IF NOT EXISTS `personal_event_invited` (
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `choice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-default;1-going;2-maybe;3-not going',
  `show_notification` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0:never_show;1:show;2:shown;3:seen',
  PRIMARY KEY (`event_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `personal_event_meta`
--

DROP TABLE IF EXISTS `personal_event_meta`;
CREATE TABLE IF NOT EXISTS `personal_event_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `target_type` varchar(25) DEFAULT NULL,
  `target_id` char(36) DEFAULT NULL,
  `target_univ_id` int(11) NOT NULL,
  `post_type` enum('status','notes','question') NOT NULL DEFAULT 'status',
  `text_msg` text NOT NULL,
  `sub_text` text,
  `file_id` bigint(40) unsigned DEFAULT NULL,
  `file_share_type` enum('regular','gdrive') DEFAULT NULL,
  `privacy` enum('students','faculty','campus','connections') NOT NULL DEFAULT 'campus',
  `anon` tinyint(1) NOT NULL DEFAULT '0',
  `like_count` int(11) NOT NULL DEFAULT '0',
  `last_activity` timestamp NULL DEFAULT NULL,
  `update_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`),
  KEY `file_id` (`file_id`),
  KEY `post_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=533 ;

--
-- Triggers `posts`
--
DROP TRIGGER IF EXISTS `Update Last Activity`;
DELIMITER //
CREATE TRIGGER `Update Last Activity` BEFORE INSERT ON `posts`
 FOR EACH ROW SET NEW.last_activity = NOW()
//
DELIMITER ;
DROP TRIGGER IF EXISTS `deleteFile`;
DELIMITER //
CREATE TRIGGER `deleteFile` BEFORE DELETE ON `posts`
 FOR EACH ROW BEGIN
 IF OLD.file_id IS NOT NULL THEN
 	DELETE FROM file_upload WHERE file_id = OLD.file_id;
 END IF;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `post_activity`;
DELIMITER //
CREATE TRIGGER `post_activity` BEFORE UPDATE ON `posts`
 FOR EACH ROW SET NEW.last_activity = NOW()
//
DELIMITER ;
DROP TRIGGER IF EXISTS `post_notification`;
DELIMITER //
CREATE TRIGGER `post_notification` AFTER INSERT ON `posts`
 FOR EACH ROW BEGIN
    DECLARE v_post_id BIGINT UNSIGNED;
    DECLARE v_gname VARCHAR(200);
    DECLARE done INT DEFAULT FALSE;
    DECLARE userid INT;
    DECLARE cur CURSOR FOR SELECT user_id FROM group_user WHERE group_id = NEW.target_id;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    INSERT INTO posts_user_inv(post_id,user_id,inv_type) VALUES(NEW.post_id, NEW.user_id, "posted");

	IF NEW.target_type = 'group' THEN
	BEGIN		
		SELECT group_name INTO v_gname
		  FROM groups
		 WHERE group_id = NEW.target_id;
		 
		OPEN cur;
			ins_loop: LOOP
				FETCH cur INTO userid;
				IF done THEN
					LEAVE ins_loop;
				END IF;
				INSERT INTO general_notifications(owner_id,actor_id,notification_type,id,status) VALUES (userid, NEW.user_id,
			'gr_post', NEW.post_id,1);
			END LOOP;
		CLOSE cur;
	END;
	END IF;
        IF NEW.target_type = 'user' THEN
	BEGIN		
		INSERT INTO posts_user_inv(post_id,user_id,inv_type) VALUES(NEW.post_id, NEW.target_id,"profile");
        END;
	END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `posts_hide`
--

DROP TABLE IF EXISTS `posts_hide`;
CREATE TABLE IF NOT EXISTS `posts_hide` (
  `user_id` int(11) NOT NULL,
  `post_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`user_id`,`post_id`),
  KEY `post_id` (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='For posts hidden by users' AUTO_INCREMENT=334 ;

-- --------------------------------------------------------

--
-- Table structure for table `posts_likes`
--

DROP TABLE IF EXISTS `posts_likes`;
CREATE TABLE IF NOT EXISTS `posts_likes` (
  `post_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'refers to post(post_id)',
  `user_id` int(11) NOT NULL COMMENT 'Refers to user(user_id)',
  PRIMARY KEY (`post_id`,`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=530 ;

--
-- Triggers `posts_likes`
--
DROP TRIGGER IF EXISTS `like_notification_update_activity`;
DELIMITER //
CREATE TRIGGER `like_notification_update_activity` AFTER INSERT ON `posts_likes`
 FOR EACH ROW BEGIN
  DECLARE v_post_id BIGINT UNSIGNED;
  DECLARE v_user INT;
  DECLARE done INT DEFAULT FALSE;
  DECLARE v_user_inv INT DEFAULT FALSE;
  DECLARE cur CURSOR FOR SELECT user_id FROM posts_user_inv WHERE post_id = NEW.post_id;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
  
  UPDATE posts SET last_activity = NOW()
   WHERE post_id = NEW.post_id;
   
  SELECT p.post_id, p.user_id INTO v_post_id, v_user
    FROM `posts` p
   WHERE p.post_id = NEW.post_id;

  OPEN cur;
	ins_loop:LOOP  
	FETCH cur INTO v_user;
		IF done THEN
			LEAVE ins_loop;
		END IF;
		IF v_user != NEW.user_id THEN
			INSERT INTO general_notifications(owner_id,actor_id,notification_type,id,status) VALUES (v_user, NEW.user_id,
			'post_like', NEW.post_id,1);
		ELSE
			SET v_user_inv = TRUE;
		END IF;
	END LOOP;
  CLOSE cur;
  
  IF NOT v_user_inv THEN
	INSERT INTO posts_user_inv(post_id, user_id, inv_type) VALUES (NEW.post_id,NEW.user_id,"liked");
  END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `posts_questions`
--

DROP TABLE IF EXISTS `posts_questions`;
CREATE TABLE IF NOT EXISTS `posts_questions` (
  `post_id` bigint(20) unsigned NOT NULL COMMENT 'refers to post(post_id)',
  `tag_type` varchar(20) NOT NULL COMMENT 'Are experts tagged or someone else',
  `tag_id` varchar(20) NOT NULL COMMENT 'id of the person or dep tagged',
  PRIMARY KEY (`post_id`,`tag_type`,`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `posts_questions`
--
DROP TRIGGER IF EXISTS `tagged_notification`;
DELIMITER //
CREATE TRIGGER `tagged_notification` AFTER INSERT ON `posts_questions`
 FOR EACH ROW BEGIN
  DECLARE v_post_id BIGINT UNSIGNED;
  DECLARE v_user INT;
  
  IF NEW.tag_type = 'user' THEN
   BEGIN
	SELECT p.post_id, p.user_id INTO v_post_id, v_user
		  FROM `posts` p
		 WHERE p.post_id = NEW.post_id;
		 
	INSERT INTO general_notifications(owner_id,actor_id,notification_type,id,status) VALUES (NEW.tag_id, v_user,
		'post_tag', NEW.post_id, 1);
        
        INSERT INTO posts_user_inv(post_id,user_id,inv_type) VALUES (NEW.post_id, NEW.tag_id,"tagged");
   END;
  END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `posts_reports`
--

DROP TABLE IF EXISTS `posts_reports`;
CREATE TABLE IF NOT EXISTS `posts_reports` (
  `user_id` bigint(20) unsigned NOT NULL,
  `post_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`post_id`),
  KEY `post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts_user_inv`
--

DROP TABLE IF EXISTS `posts_user_inv`;
CREATE TABLE IF NOT EXISTS `posts_user_inv` (
  `post_id` bigint(20) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `inv_type` varchar(100) DEFAULT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='List of users involved in a post';

-- --------------------------------------------------------

--
-- Table structure for table `prof_attribs`
--

DROP TABLE IF EXISTS `prof_attribs`;
CREATE TABLE IF NOT EXISTS `prof_attribs` (
  `prof_id` int(11) NOT NULL COMMENT 'refers to user_id in user table',
  `designation` varchar(100) DEFAULT 'professor',
  `office_location` varchar(60) DEFAULT NULL,
  `office_hours` varchar(100) DEFAULT NULL COMMENT 'CSV (format: day = starttime:endtime)',
  `website` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`prof_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

DROP TABLE IF EXISTS `reply`;
CREATE TABLE IF NOT EXISTS `reply` (
  `reply_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL COMMENT 'Refers to home_posts(post_id)',
  `user_id` bigint(20) unsigned NOT NULL COMMENT 'refers to user(user_id)',
  `reply_msg` text,
  `up_vote` int(11) NOT NULL DEFAULT '0',
  `down_vote` int(11) NOT NULL DEFAULT '0',
  `file_id` bigint(20) unsigned DEFAULT NULL,
  `anon` tinyint(4) NOT NULL DEFAULT '0',
  `update_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`reply_id`),
  KEY `file_id` (`file_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=342 ;

--
-- Triggers `reply`
--
DROP TRIGGER IF EXISTS `deleteReplyFile`;
DELIMITER //
CREATE TRIGGER `deleteReplyFile` AFTER DELETE ON `reply`
 FOR EACH ROW BEGIN
 IF OLD.file_id IS NOT NULL THEN
 	DELETE FROM file_upload WHERE file_id = OLD.file_id;
 END IF;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `reply_notification`;
DELIMITER //
CREATE TRIGGER `reply_notification` AFTER INSERT ON `reply`
 FOR EACH ROW BEGIN
  DECLARE v_post_id BIGINT UNSIGNED;
  DECLARE v_user INT;
  DECLARE done INT DEFAULT FALSE;
  DECLARE v_user_inv INT DEFAULT FALSE;
  DECLARE cur CURSOR FOR SELECT user_id FROM posts_user_inv WHERE post_id = NEW.post_id;
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
  
  UPDATE posts SET last_activity = NOW()
   WHERE post_id = NEW.post_id;
   
  SELECT p.post_id, p.user_id INTO v_post_id, v_user
    FROM `posts` p
   WHERE p.post_id = NEW.post_id;

  OPEN cur;
	ins_loop:LOOP  
	FETCH cur INTO v_user;
		IF done THEN
			LEAVE ins_loop;
		END IF;
		IF v_user != NEW.user_id THEN
			INSERT INTO general_notifications(owner_id,actor_id,notification_type,id,status) VALUES (v_user, NEW.user_id,
			'post_reply', NEW.post_id,1);
		ELSE
			SET v_user_inv = TRUE;
		END IF;
	END LOOP;
  CLOSE cur;
  
  IF NOT v_user_inv THEN
	INSERT INTO posts_user_inv(post_id, user_id, inv_type) VALUES (NEW.post_id,NEW.user_id,"replied");
  END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `reply_votes`
--

DROP TABLE IF EXISTS `reply_votes`;
CREATE TABLE IF NOT EXISTS `reply_votes` (
  `reply_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `vote_type` enum('upvote','downvote') NOT NULL,
  PRIMARY KEY (`reply_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `reply_votes`
--
DROP TRIGGER IF EXISTS `upvote_notification`;
DELIMITER //
CREATE TRIGGER `upvote_notification` AFTER INSERT ON `reply_votes`
 FOR EACH ROW BEGIN
  DECLARE v_user_reply INT;
  DECLARE v_post_id BIGINT UNSIGNED;
  
  IF NEW.vote_type = 'upvote' THEN
	BEGIN
		SELECT p.post_id, r.user_id INTO v_post_id, v_user_reply
		  FROM reply r JOIN posts p
		  ON (p.post_id = r.post_id)
		 WHERE r.reply_id = NEW.reply_id;
		IF v_user_reply != NEW.user_id THEN
                    INSERT INTO general_notifications(owner_id,actor_id,notification_type,id) VALUES (v_user_reply, NEW.user_id,
                            'upvote', NEW.reply_id);
                END IF;
	END;
  END IF;
 END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `schedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `day` enum('TBA','M','T','W','TH','F','S','SU') NOT NULL DEFAULT 'TBA',
  `start_time` time NOT NULL COMMENT 'start of class',
  `end_time` time NOT NULL COMMENT 'end of class',
  PRIMARY KEY (`schedule_id`),
  UNIQUE KEY `day` (`day`,`start_time`,`end_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=988 ;

-- --------------------------------------------------------

--
-- Table structure for table `showcase`
--

DROP TABLE IF EXISTS `showcase`;
CREATE TABLE IF NOT EXISTS `showcase` (
  `user_id` int(11) NOT NULL,
  `file_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `file_share_type` enum('regular','gdrive','link') NOT NULL,
  `file_desc` text,
  PRIMARY KEY (`user_id`,`file_id`,`file_share_type`),
  KEY `file_id` (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='showcase for the professor';

-- --------------------------------------------------------

--
-- Table structure for table `showcase_links`
--

DROP TABLE IF EXISTS `showcase_links`;
CREATE TABLE IF NOT EXISTS `showcase_links` (
  `link_id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `link` varchar(256) NOT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `student_attribs`
--

DROP TABLE IF EXISTS `student_attribs`;
CREATE TABLE IF NOT EXISTS `student_attribs` (
  `user_id` int(11) NOT NULL COMMENT 'refers to user_id in user table',
  `website` varchar(255) DEFAULT NULL,
  `major` varchar(255) DEFAULT NULL,
  `year` int(11) DEFAULT NULL COMMENT 'year of grad',
  `student_type` enum('grad','undergrad','phd') DEFAULT NULL,
  `minor` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(100) NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `theme_table`
--

DROP TABLE IF EXISTS `theme_table`;
CREATE TABLE IF NOT EXISTS `theme_table` (
  `theme_image` mediumblob NOT NULL,
  `theme_id` int(11) NOT NULL AUTO_INCREMENT,
  `theme_name` char(20) NOT NULL,
  PRIMARY KEY (`theme_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `university`
--

DROP TABLE IF EXISTS `university`;
CREATE TABLE IF NOT EXISTS `university` (
  `univ_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_univ_id` int(11) NOT NULL,
  `univ_name` varchar(255) NOT NULL,
  `univ_location` varchar(255) NOT NULL COMMENT 'Address of the university',
  `univ_desc` tinytext,
  `fb_link` varchar(400) DEFAULT NULL,
  `twitter_link` varchar(400) DEFAULT NULL,
  `alias` varchar(20) DEFAULT NULL,
  `weblink` varchar(50) DEFAULT NULL,
  `dp_blob_id` int(64) unsigned DEFAULT NULL COMMENT 'display_picture img_id',
  `cover_blob_id` int(64) unsigned DEFAULT NULL COMMENT 'display_picture img_id',
  PRIMARY KEY (`univ_id`),
  KEY `parent_univ_id` (`parent_univ_id`),
  KEY `dp_blob_id` (`dp_blob_id`),
  KEY `cover_blob_id` (`cover_blob_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `university_cover`
--

DROP TABLE IF EXISTS `university_cover`;
CREATE TABLE IF NOT EXISTS `university_cover` (
  `img_id` int(11) NOT NULL AUTO_INCREMENT,
  `image` mediumblob NOT NULL,
  `univ_id` int(11) NOT NULL,
  `img_des` text NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`img_id`),
  KEY `univ_id` (`univ_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

-- --------------------------------------------------------

--
-- Table structure for table `univ_semester`
--

DROP TABLE IF EXISTS `univ_semester`;
CREATE TABLE IF NOT EXISTS `univ_semester` (
  `univ_id` int(11) NOT NULL,
  `semester` enum('fall','summer','spring') NOT NULL DEFAULT 'fall',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`univ_id`,`semester`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Stores the semester start and end date for each university';

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) NOT NULL,
  `user_type` char(1) NOT NULL COMMENT 's or p or a',
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `univ_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `user_bio` mediumtext,
  `dp_flag` enum('link','blob') DEFAULT NULL,
  `dp_link` varchar(512) DEFAULT NULL,
  `dp_blob` int(64) unsigned DEFAULT NULL,
  `status` enum('invited','temp','active','inactive','review') DEFAULT NULL,
  `gender` enum('M','F') DEFAULT 'M',
  `Available` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`),
  UNIQUE KEY `user_email_2` (`user_email`),
  KEY `univ_id` (`univ_id`),
  KEY `dept_id` (`dept_id`),
  KEY `dp_blob` (`dp_blob`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=579 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_auth_provider`
--

DROP TABLE IF EXISTS `user_auth_provider`;
CREATE TABLE IF NOT EXISTS `user_auth_provider` (
  `user_id` varchar(255) NOT NULL,
  `auth_key` varchar(255) NOT NULL,
  `auth_provider` enum('facebook') NOT NULL DEFAULT 'facebook',
  `fb_email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_interests`
--

DROP TABLE IF EXISTS `user_interests`;
CREATE TABLE IF NOT EXISTS `user_interests` (
  `user_id` int(11) NOT NULL,
  `interest_id` int(11) NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `interest_id` (`interest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

DROP TABLE IF EXISTS `user_login`;
CREATE TABLE IF NOT EXISTS `user_login` (
  `user_id` int(11) NOT NULL,
  `password` varchar(512) DEFAULT NULL,
  `salt` varchar(256) NOT NULL,
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_login_attempts`
--

DROP TABLE IF EXISTS `user_login_attempts`;
CREATE TABLE IF NOT EXISTS `user_login_attempts` (
  `user_id` int(11) NOT NULL,
  `attempttime` datetime DEFAULT NULL,
  `ipaddress` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_recovery`
--

DROP TABLE IF EXISTS `user_recovery`;
CREATE TABLE IF NOT EXISTS `user_recovery` (
  `user_id` int(11) NOT NULL,
  `key1` varchar(255) NOT NULL,
  `expiry` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bug_report`
--
ALTER TABLE `bug_report`
  ADD CONSTRAINT `bug_report_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `class_rating`
--
ALTER TABLE `class_rating`
  ADD CONSTRAINT `class_rating_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `class_rating_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `courses_semester` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `class_review`
--
ALTER TABLE `class_review`
  ADD CONSTRAINT `class_review_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `class_review_ibfk_6` FOREIGN KEY (`class_id`) REFERENCES `courses_semester` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `class_review_vote`
--
ALTER TABLE `class_review_vote`
  ADD CONSTRAINT `class_review_vote_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `class_review_vote_ibfk_2` FOREIGN KEY (`review_id`) REFERENCES `class_review` (`review_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `connect`
--
ALTER TABLE `connect`
  ADD CONSTRAINT `connect_ibfk_1` FOREIGN KEY (`from_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `connect_ibfk_2` FOREIGN KEY (`to_user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`univ_id`) REFERENCES `university` (`univ_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `courses_ibfk_3` FOREIGN KEY (`dp_blob_id`) REFERENCES `display_picture` (`img_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `courses_ibfk_4` FOREIGN KEY (`course_visibility_id`) REFERENCES `courses_visibility` (`visibility_id`);

--
-- Constraints for table `courses_semester`
--
ALTER TABLE `courses_semester`
  ADD CONSTRAINT `courses_semester_ibfk_1` FOREIGN KEY (`course_id`, `dept_id`, `univ_id`) REFERENCES `courses` (`course_id`, `dept_id`, `univ_id`),
  ADD CONSTRAINT `courses_semester_ibfk_2` FOREIGN KEY (`cover_blob_id`) REFERENCES `display_picture` (`img_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `courses_semester_ibfk_3` FOREIGN KEY (`dp_blob_id`) REFERENCES `display_picture` (`img_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `courses_semester_ibfk_4` FOREIGN KEY (`syllabus_id`) REFERENCES `file_upload` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `courses_semester_ibfk_5` FOREIGN KEY (`color_id`) REFERENCES `event_color_table` (`color_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `courses_semester_ibfk_6` FOREIGN KEY (`professor`) REFERENCES `user` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `cs_fk_1` FOREIGN KEY (`univ_id`, `dept_id`) REFERENCES `department` (`univ_id`, `dept_id`);

--
-- Constraints for table `courses_semester_schedule`
--
ALTER TABLE `courses_semester_schedule`
  ADD CONSTRAINT `courses_semester_schedule_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `courses_semester` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `courses_semester_schedule_ibfk_2` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`schedule_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses_user`
--
ALTER TABLE `courses_user`
  ADD CONSTRAINT `courses_user_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `courses_semester` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `courses_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `courses_user_ibfk_4` FOREIGN KEY (`color_id`) REFERENCES `event_color_table` (`color_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `course_bookmarks`
--
ALTER TABLE `course_bookmarks`
  ADD CONSTRAINT `course_bookmarks_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `courses_semester` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_bookmarks_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course_event`
--
ALTER TABLE `course_event`
  ADD CONSTRAINT `course_event_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_event_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `courses_semester` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_event_ibfk_4` FOREIGN KEY (`theme_id`) REFERENCES `theme_table` (`theme_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `course_event_ibfk_5` FOREIGN KEY (`file_id`) REFERENCES `file_upload` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `course_event_invited`
--
ALTER TABLE `course_event_invited`
  ADD CONSTRAINT `course_event_invited_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `course_event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_event_invited_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course_files`
--
ALTER TABLE `course_files`
  ADD CONSTRAINT `course_files_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `courses_semester` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_files_ibfk_2` FOREIGN KEY (`file_id`) REFERENCES `file_upload` (`file_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_files_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `course_follow`
--
ALTER TABLE `course_follow`
  ADD CONSTRAINT `course_follow_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_follow_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`univ_id`) REFERENCES `university` (`univ_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `department_ibfk_4` FOREIGN KEY (`dp_blob_id`) REFERENCES `display_picture` (`img_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `department_ibfk_5` FOREIGN KEY (`cover_blob_id`) REFERENCES `display_picture` (`img_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `department_follow`
--
ALTER TABLE `department_follow`
  ADD CONSTRAINT `department_follow_ibfk_1` FOREIGN KEY (`dept_id`) REFERENCES `department` (`dept_id`),
  ADD CONSTRAINT `department_follow_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `event_notfications`
--
ALTER TABLE `event_notfications`
  ADD CONSTRAINT `event_notfications_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`univ_id`) REFERENCES `university` (`univ_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `groups_ibfk_2` FOREIGN KEY (`dp_blob_id`) REFERENCES `display_picture` (`img_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `groups_ibfk_3` FOREIGN KEY (`cover_blob_id`) REFERENCES `display_picture` (`img_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `groups_ibfk_4` FOREIGN KEY (`color_id`) REFERENCES `event_color_table` (`color_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `groups_files`
--
ALTER TABLE `groups_files`
  ADD CONSTRAINT `groups_files_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `groups_files_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `groups_files_ibfk_3` FOREIGN KEY (`file_id`) REFERENCES `file_upload` (`file_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `group_event`
--
ALTER TABLE `group_event`
  ADD CONSTRAINT `group_event_ibfk_5` FOREIGN KEY (`theme_id`) REFERENCES `theme_table` (`theme_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `group_event_ibfk_6` FOREIGN KEY (`file_id`) REFERENCES `file_upload` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `group_event_ibfk_7` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_event_ibfk_8` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `group_event_invited`
--
ALTER TABLE `group_event_invited`
  ADD CONSTRAINT `group_event_invited_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `group_event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_event_invited_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `group_users`
--
ALTER TABLE `group_users`
  ADD CONSTRAINT `group_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_users_ibfk_4` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_users_ibfk_6` FOREIGN KEY (`color_id`) REFERENCES `event_color_table` (`color_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `invites`
--
ALTER TABLE `invites`
  ADD CONSTRAINT `invites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `parent_university`
--
ALTER TABLE `parent_university`
  ADD CONSTRAINT `parent_university_ibfk_1` FOREIGN KEY (`dp_blob_id`) REFERENCES `display_picture` (`img_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `parent_university_ibfk_2` FOREIGN KEY (`cover_blob_id`) REFERENCES `display_picture` (`img_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `personal_event`
--
ALTER TABLE `personal_event`
  ADD CONSTRAINT `personal_event_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `personal_event_ibfk_3` FOREIGN KEY (`file_id`) REFERENCES `file_upload` (`file_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `personal_event_ibfk_4` FOREIGN KEY (`theme_id`) REFERENCES `theme_table` (`theme_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `personal_event_invited`
--
ALTER TABLE `personal_event_invited`
  ADD CONSTRAINT `personal_event_invited_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `personal_event_invited_ibfk_3` FOREIGN KEY (`event_id`) REFERENCES `personal_event` (`event_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts_questions`
--
ALTER TABLE `posts_questions`
  ADD CONSTRAINT `posts_questions_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts_user_inv`
--
ALTER TABLE `posts_user_inv`
  ADD CONSTRAINT `posts_user_inv_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_user_inv_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reply`
--
ALTER TABLE `reply`
  ADD CONSTRAINT `reply_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `file_upload` (`file_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `showcase`
--
ALTER TABLE `showcase`
  ADD CONSTRAINT `showcase_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `university`
--
ALTER TABLE `university`
  ADD CONSTRAINT `university_ibfk_1` FOREIGN KEY (`parent_univ_id`) REFERENCES `parent_university` (`parent_univ_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `university_ibfk_2` FOREIGN KEY (`dp_blob_id`) REFERENCES `display_picture` (`img_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `university_ibfk_3` FOREIGN KEY (`cover_blob_id`) REFERENCES `display_picture` (`img_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `university_cover`
--
ALTER TABLE `university_cover`
  ADD CONSTRAINT `university_cover_ibfk_1` FOREIGN KEY (`univ_id`) REFERENCES `university` (`univ_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `university_cover_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `univ_semester`
--
ALTER TABLE `univ_semester`
  ADD CONSTRAINT `univ_semester_ibfk_1` FOREIGN KEY (`univ_id`) REFERENCES `university` (`univ_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`dp_blob`) REFERENCES `display_picture` (`img_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `user_interests`
--
ALTER TABLE `user_interests`
  ADD CONSTRAINT `user_interests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_interests_ibfk_2` FOREIGN KEY (`interest_id`) REFERENCES `interests` (`interest_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_login`
--
ALTER TABLE `user_login`
  ADD CONSTRAINT `user_login_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
