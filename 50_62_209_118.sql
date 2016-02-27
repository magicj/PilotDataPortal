-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 50.62.209.118:3306
-- Generation Time: Feb 26, 2016 at 07:44 PM
-- Server version: 5.5.43-37.2-log
-- PHP Version: 5.5.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pgcsoaringdb`
--
CREATE DATABASE IF NOT EXISTS `pgcsoaringdb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `pgcsoaringdb`;

-- --------------------------------------------------------

--
-- Table structure for table `additional_resources`
--

CREATE TABLE `additional_resources` (
  `resourceid` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(75) NOT NULL DEFAULT '',
  `status` char(1) NOT NULL DEFAULT 'a',
  `number_available` int(11) NOT NULL DEFAULT '-1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcementid` varchar(16) NOT NULL DEFAULT '',
  `announcement` varchar(255) NOT NULL DEFAULT '',
  `number` smallint(6) NOT NULL DEFAULT '0',
  `start_datetime` int(11) DEFAULT NULL,
  `end_datetime` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `anonymous_users`
--

CREATE TABLE `anonymous_users` (
  `memberid` varchar(16) NOT NULL DEFAULT '',
  `email` varchar(75) NOT NULL DEFAULT '',
  `fname` varchar(30) NOT NULL DEFAULT '',
  `lname` varchar(30) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `groupid` varchar(16) NOT NULL DEFAULT '',
  `group_name` varchar(50) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `memberid` varchar(16) NOT NULL DEFAULT '',
  `email` varchar(75) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `fname` varchar(30) NOT NULL DEFAULT '',
  `lname` varchar(30) NOT NULL DEFAULT '',
  `phone` varchar(16) NOT NULL DEFAULT '',
  `institution` varchar(255) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `e_add` char(1) NOT NULL DEFAULT 'y',
  `e_mod` char(1) NOT NULL DEFAULT 'y',
  `e_del` char(1) NOT NULL DEFAULT 'y',
  `e_app` char(1) NOT NULL DEFAULT 'y',
  `e_html` char(1) NOT NULL DEFAULT 'y',
  `logon_name` varchar(30) DEFAULT NULL,
  `is_admin` smallint(6) DEFAULT '0',
  `lang` varchar(5) DEFAULT NULL,
  `timezone` float NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mutex`
--

CREATE TABLE `mutex` (
  `i` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `memberid` char(16) NOT NULL DEFAULT '',
  `machid` char(16) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_access_app_groups`
--

CREATE TABLE `pgc_access_app_groups` (
  `rec_key` int(11) NOT NULL,
  `app_name` varchar(50) DEFAULT NULL,
  `allowed_group` varchar(15) DEFAULT NULL,
  `rec_active` varchar(1) DEFAULT 'Y'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_access_apps`
--

CREATE TABLE `pgc_access_apps` (
  `app_key` smallint(6) NOT NULL,
  `app_name` varchar(50) DEFAULT NULL,
  `app_active` varchar(1) DEFAULT NULL,
  `app_function` varchar(15) DEFAULT NULL,
  `app_notes` varchar(100) DEFAULT NULL,
  `app_last_used` date DEFAULT NULL,
  `last_user_name` varchar(30) DEFAULT NULL,
  `last_user_id` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_access_functionlist`
--

CREATE TABLE `pgc_access_functionlist` (
  `rec_key` int(11) NOT NULL,
  `app_function` varchar(15) DEFAULT NULL,
  `rec_active` varchar(1) DEFAULT 'Y'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_access_grouplist`
--

CREATE TABLE `pgc_access_grouplist` (
  `rec_key` int(11) NOT NULL,
  `group_name` varchar(15) DEFAULT NULL,
  `rec_active` varchar(1) DEFAULT 'Y'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_access_member_groups`
--

CREATE TABLE `pgc_access_member_groups` (
  `rec_key` int(11) NOT NULL,
  `member_key` int(11) DEFAULT NULL,
  `member_id` varchar(30) DEFAULT NULL,
  `member_name` varchar(30) DEFAULT NULL,
  `assigned_group` varchar(15) DEFAULT NULL,
  `rec_active` varchar(1) DEFAULT 'Y'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_batch_email`
--

CREATE TABLE `pgc_batch_email` (
  `email` char(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_calendar`
--

CREATE TABLE `pgc_calendar` (
  `EventID` int(9) NOT NULL,
  `EventDate` date DEFAULT NULL,
  `EventTitle` varchar(420) DEFAULT NULL,
  `EventLink` varchar(60) DEFAULT NULL,
  `EventOrder` int(2) NOT NULL DEFAULT '1',
  `DateExpired` char(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_cfig_dates`
--

CREATE TABLE `pgc_cfig_dates` (
  `rec_key` smallint(9) NOT NULL,
  `cfig_name` char(30) DEFAULT NULL,
  `duty_date` date DEFAULT NULL,
  `cfig_vacation` char(1) DEFAULT NULL,
  `source_key` int(5) DEFAULT NULL,
  `rec_processed` char(1) DEFAULT NULL,
  `duty_day` char(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_cfig_vacation`
--

CREATE TABLE `pgc_cfig_vacation` (
  `vac_key` int(5) NOT NULL,
  `cfig_name` char(35) NOT NULL,
  `vac_start` date NOT NULL,
  `vac_end` date NOT NULL,
  `saturday` char(3) DEFAULT NULL,
  `sunday` char(3) DEFAULT NULL,
  `monday` char(3) DEFAULT NULL,
  `tuesday` char(3) DEFAULT NULL,
  `wednesday` char(3) DEFAULT NULL,
  `thursday` char(3) DEFAULT NULL,
  `friday` char(3) DEFAULT NULL,
  `alldays` varchar(100) DEFAULT NULL,
  `rec_deleted` char(3) DEFAULT 'NO',
  `vdays` int(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_cfig_vacation_12-2012`
--

CREATE TABLE `pgc_cfig_vacation_12-2012` (
  `vac_key` int(5) NOT NULL,
  `cfig_name` char(35) NOT NULL,
  `vac_start` date NOT NULL,
  `vac_end` date NOT NULL,
  `saturday` char(3) DEFAULT NULL,
  `sunday` char(3) DEFAULT NULL,
  `monday` char(3) DEFAULT NULL,
  `tuesday` char(3) DEFAULT NULL,
  `wednesday` char(3) DEFAULT NULL,
  `thursday` char(3) DEFAULT NULL,
  `friday` char(3) DEFAULT NULL,
  `alldays` varchar(100) DEFAULT NULL,
  `rec_deleted` char(3) DEFAULT 'NO',
  `vdays` int(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_cfig_vacation_copy`
--

CREATE TABLE `pgc_cfig_vacation_copy` (
  `vac_key` int(5) NOT NULL,
  `cfig_name` char(35) NOT NULL,
  `vac_start` date NOT NULL,
  `vac_end` date NOT NULL,
  `saturday` char(3) DEFAULT NULL,
  `sunday` char(3) DEFAULT NULL,
  `monday` char(3) DEFAULT NULL,
  `tuesday` char(3) DEFAULT NULL,
  `wednesday` char(3) DEFAULT NULL,
  `thursday` char(3) DEFAULT NULL,
  `friday` char(3) DEFAULT NULL,
  `alldays` varchar(100) DEFAULT NULL,
  `rec_deleted` char(3) DEFAULT 'NO',
  `vdays` int(4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_class`
--

CREATE TABLE `pgc_class` (
  `rec_index` int(5) NOT NULL,
  `member_name` varchar(40) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `event_name` varchar(40) DEFAULT NULL,
  `primary_instructor` varchar(40) DEFAULT NULL,
  `entered_by` varchar(40) NOT NULL,
  `entry_ip` varchar(30) DEFAULT NULL,
  `event_notes` varchar(250) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_date`
--

CREATE TABLE `pgc_date` (
  `ops_Date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Date for php apps';

-- --------------------------------------------------------

--
-- Table structure for table `pgc_doc_category`
--

CREATE TABLE `pgc_doc_category` (
  `doc_category` varchar(50) DEFAULT NULL,
  `doc_sub_category` varchar(50) DEFAULT NULL,
  `doc_posted` timestamp NULL DEFAULT NULL,
  `doc_modified_id` varchar(50) DEFAULT NULL,
  `doc_path` varchar(50) DEFAULT NULL,
  `doc_count` int(4) DEFAULT NULL,
  `rec_active` varchar(3) DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_doc_category_master`
--

CREATE TABLE `pgc_doc_category_master` (
  `rec_key` smallint(3) NOT NULL,
  `doc_category` varchar(50) NOT NULL DEFAULT '',
  `rec_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rec_modified_id` varchar(50) DEFAULT NULL,
  `rec_active` varchar(3) DEFAULT 'NO',
  `rec_deleted` char(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_doc_combos`
--

CREATE TABLE `pgc_doc_combos` (
  `doc_combo` varchar(100) DEFAULT NULL,
  `doc_category` varchar(50) DEFAULT NULL,
  `doc_sub_category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_doc_lib_folders`
--

CREATE TABLE `pgc_doc_lib_folders` (
  `folder_name` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_doc_lib_list`
--

CREATE TABLE `pgc_doc_lib_list` (
  `rec_id` int(8) NOT NULL,
  `doc_file_name` varchar(200) DEFAULT NULL,
  `doc_display_name` varchar(200) DEFAULT NULL,
  `doc_category` varchar(50) DEFAULT NULL,
  `doc_sub_category` varchar(50) DEFAULT NULL,
  `doc_source` varchar(50) DEFAULT NULL,
  `doc_posted` timestamp NULL DEFAULT NULL,
  `date_posted` varchar(25) DEFAULT NULL,
  `doc_modified_id` varchar(50) DEFAULT NULL,
  `doc_reader` varchar(50) DEFAULT NULL,
  `doc_display` varchar(3) DEFAULT 'NO',
  `doc_path` varchar(50) DEFAULT NULL,
  `doc_upload_folder` varchar(50) DEFAULT NULL,
  `doc_upload_link` varchar(150) DEFAULT NULL,
  `combo_key` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_doc_subcategory_master`
--

CREATE TABLE `pgc_doc_subcategory_master` (
  `rec_key` smallint(3) NOT NULL,
  `doc_category` varchar(50) NOT NULL DEFAULT '',
  `rec_posted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rec_modified_id` varchar(50) DEFAULT NULL,
  `rec_active` varchar(3) DEFAULT 'NO',
  `rec_deleted` char(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_email_master`
--

CREATE TABLE `pgc_email_master` (
  `email_key` tinyint(8) NOT NULL,
  `email_purpose` varchar(50) NOT NULL,
  `email_notes` varchar(200) DEFAULT NULL,
  `email_names` varchar(200) DEFAULT NULL,
  `email_addresses` varchar(300) DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_equipment`
--

CREATE TABLE `pgc_equipment` (
  `rec_key` int(11) NOT NULL,
  `equip_name` varchar(40) DEFAULT NULL,
  `ship_captain` varchar(40) DEFAULT NULL,
  `equip_type` varchar(1) DEFAULT NULL,
  `rec_active` varchar(1) DEFAULT NULL,
  `ship_status` varchar(15) DEFAULT 'In Service'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_field_duty`
--

CREATE TABLE `pgc_field_duty` (
  `date` date NOT NULL,
  `fm` char(40) DEFAULT NULL,
  `afm1` char(40) DEFAULT NULL,
  `afm2` char(40) DEFAULT NULL,
  `afm3` char(40) DEFAULT NULL,
  `fm_sub` char(40) DEFAULT NULL,
  `afm1_sub` char(40) DEFAULT NULL,
  `afm2_sub` char(40) DEFAULT NULL,
  `afm3_sub` char(40) DEFAULT NULL,
  `session` int(1) NOT NULL,
  `modified_by` char(35) NOT NULL,
  `modified_date` datetime NOT NULL,
  `delete_record` char(3) DEFAULT 'NO',
  `cfig` char(40) DEFAULT NULL,
  `tp1` char(40) DEFAULT NULL,
  `tp2` char(40) DEFAULT NULL,
  `fm_count` int(3) DEFAULT NULL,
  `afm_count` int(3) DEFAULT NULL,
  `fm_email` varchar(50) DEFAULT NULL,
  `afm1_email` varchar(50) DEFAULT NULL,
  `afm2_email` varchar(50) DEFAULT NULL,
  `afm3_email` varchar(50) DEFAULT NULL,
  `cfig_email` varchar(50) DEFAULT NULL,
  `fd_type` char(10) DEFAULT NULL,
  `fd_holiday` char(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_field_duty_12-2012`
--

CREATE TABLE `pgc_field_duty_12-2012` (
  `date` date NOT NULL,
  `fm` char(40) DEFAULT NULL,
  `afm1` char(40) DEFAULT NULL,
  `afm2` char(40) DEFAULT NULL,
  `afm3` char(40) DEFAULT NULL,
  `fm_sub` char(40) DEFAULT NULL,
  `afm1_sub` char(40) DEFAULT NULL,
  `afm2_sub` char(40) DEFAULT NULL,
  `afm3_sub` char(40) DEFAULT NULL,
  `session` int(1) NOT NULL,
  `modified_by` char(35) NOT NULL,
  `modified_date` datetime NOT NULL,
  `delete_record` char(3) DEFAULT 'NO',
  `cfig` char(40) DEFAULT NULL,
  `tp1` char(40) DEFAULT NULL,
  `tp2` char(40) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_field_duty_1-2012-Copy`
--

CREATE TABLE `pgc_field_duty_1-2012-Copy` (
  `date` date NOT NULL,
  `fm` char(40) DEFAULT NULL,
  `afm1` char(40) DEFAULT NULL,
  `afm2` char(40) DEFAULT NULL,
  `afm3` char(40) DEFAULT NULL,
  `fm_sub` char(40) DEFAULT NULL,
  `afm1_sub` char(40) DEFAULT NULL,
  `afm2_sub` char(40) DEFAULT NULL,
  `afm3_sub` char(40) DEFAULT NULL,
  `session` int(1) NOT NULL,
  `modified_by` char(35) NOT NULL,
  `modified_date` datetime NOT NULL,
  `delete_record` char(3) DEFAULT 'NO',
  `cfig` char(40) DEFAULT NULL,
  `tp1` char(40) DEFAULT NULL,
  `tp2` char(40) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_field_duty_2013`
--

CREATE TABLE `pgc_field_duty_2013` (
  `date` date NOT NULL,
  `fm` char(40) DEFAULT NULL,
  `afm1` char(40) DEFAULT NULL,
  `afm2` char(40) DEFAULT NULL,
  `afm3` char(40) DEFAULT NULL,
  `fm_sub` char(40) DEFAULT NULL,
  `afm1_sub` char(40) DEFAULT NULL,
  `afm2_sub` char(40) DEFAULT NULL,
  `afm3_sub` char(40) DEFAULT NULL,
  `session` int(1) NOT NULL,
  `modified_by` char(35) NOT NULL,
  `modified_date` datetime NOT NULL,
  `delete_record` char(3) DEFAULT 'NO',
  `cfig` char(40) DEFAULT NULL,
  `tp1` char(40) DEFAULT NULL,
  `tp2` char(40) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_field_duty_2013_copy`
--

CREATE TABLE `pgc_field_duty_2013_copy` (
  `date` date NOT NULL,
  `fm` char(40) DEFAULT NULL,
  `afm1` char(40) DEFAULT NULL,
  `afm2` char(40) DEFAULT NULL,
  `afm3` char(40) DEFAULT NULL,
  `fm_sub` char(40) DEFAULT NULL,
  `afm1_sub` char(40) DEFAULT NULL,
  `afm2_sub` char(40) DEFAULT NULL,
  `afm3_sub` char(40) DEFAULT NULL,
  `session` int(1) NOT NULL,
  `modified_by` char(35) NOT NULL,
  `modified_date` datetime NOT NULL,
  `delete_record` char(3) DEFAULT 'NO',
  `cfig` char(40) DEFAULT NULL,
  `tp1` char(40) DEFAULT NULL,
  `tp2` char(40) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_field_duty_2013_copytk`
--

CREATE TABLE `pgc_field_duty_2013_copytk` (
  `date` date NOT NULL,
  `fm` char(40) DEFAULT NULL,
  `afm1` char(40) DEFAULT NULL,
  `afm2` char(40) DEFAULT NULL,
  `afm3` char(40) DEFAULT NULL,
  `fm_sub` char(40) DEFAULT NULL,
  `afm1_sub` char(40) DEFAULT NULL,
  `afm2_sub` char(40) DEFAULT NULL,
  `afm3_sub` char(40) DEFAULT NULL,
  `session` int(1) NOT NULL,
  `modified_by` char(35) NOT NULL,
  `modified_date` datetime NOT NULL,
  `delete_record` char(3) DEFAULT 'NO',
  `cfig` char(40) DEFAULT NULL,
  `tp1` char(40) DEFAULT NULL,
  `tp2` char(40) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_field_duty_2014_copy`
--

CREATE TABLE `pgc_field_duty_2014_copy` (
  `date` date NOT NULL,
  `fm` char(40) DEFAULT NULL,
  `afm1` char(40) DEFAULT NULL,
  `afm2` char(40) DEFAULT NULL,
  `afm3` char(40) DEFAULT NULL,
  `fm_sub` char(40) DEFAULT NULL,
  `afm1_sub` char(40) DEFAULT NULL,
  `afm2_sub` char(40) DEFAULT NULL,
  `afm3_sub` char(40) DEFAULT NULL,
  `session` int(1) NOT NULL,
  `modified_by` char(35) NOT NULL,
  `modified_date` datetime NOT NULL,
  `delete_record` char(3) DEFAULT 'NO',
  `cfig` char(40) DEFAULT NULL,
  `tp1` char(40) DEFAULT NULL,
  `tp2` char(40) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_field_duty_2015`
--

CREATE TABLE `pgc_field_duty_2015` (
  `date` date NOT NULL,
  `fm` char(40) DEFAULT NULL,
  `afm1` char(40) DEFAULT NULL,
  `afm2` char(40) DEFAULT NULL,
  `afm3` char(40) DEFAULT NULL,
  `fm_sub` char(40) DEFAULT NULL,
  `afm1_sub` char(40) DEFAULT NULL,
  `afm2_sub` char(40) DEFAULT NULL,
  `afm3_sub` char(40) DEFAULT NULL,
  `session` int(1) NOT NULL,
  `modified_by` char(35) NOT NULL,
  `modified_date` datetime NOT NULL,
  `delete_record` char(3) DEFAULT 'NO',
  `cfig` char(40) DEFAULT NULL,
  `tp1` char(40) DEFAULT NULL,
  `tp2` char(40) DEFAULT NULL,
  `fm_count` int(3) DEFAULT NULL,
  `afm_count` int(3) DEFAULT NULL,
  `fm_email` varchar(50) DEFAULT NULL,
  `afm1_email` varchar(50) DEFAULT NULL,
  `afm2_email` varchar(50) DEFAULT NULL,
  `afm3_email` varchar(50) DEFAULT NULL,
  `cfig_email` varchar(50) DEFAULT NULL,
  `fd_type` char(10) DEFAULT NULL,
  `fd_holiday` char(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_field_duty_check`
--

CREATE TABLE `pgc_field_duty_check` (
  `member_id` char(40) DEFAULT NULL,
  `member_name` char(40) DEFAULT NULL,
  `pgc_active` varchar(3) DEFAULT NULL,
  `fd_role` char(5) DEFAULT NULL,
  `fd_credits` int(2) DEFAULT NULL,
  `session1` date DEFAULT NULL,
  `session2` date DEFAULT NULL,
  `session3` date DEFAULT NULL,
  `session4` date DEFAULT NULL,
  `date_list` varchar(60) DEFAULT NULL,
  `fd_holiday` char(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_field_duty_control`
--

CREATE TABLE `pgc_field_duty_control` (
  `fd_session` int(1) NOT NULL,
  `session_start_date` date DEFAULT NULL,
  `session_end_date` date DEFAULT NULL,
  `session_active` char(1) DEFAULT NULL,
  `modified_by` char(35) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `delete_record` char(3) DEFAULT 'NO'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_field_duty_explode`
--

CREATE TABLE `pgc_field_duty_explode` (
  `fd_key` int(8) NOT NULL,
  `fd_date` date DEFAULT NULL,
  `member_name` char(40) DEFAULT NULL,
  `session` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_field_duty_holidays`
--

CREATE TABLE `pgc_field_duty_holidays` (
  `holiday_name` char(20) NOT NULL DEFAULT '',
  `holiday_date` date DEFAULT NULL,
  `holiday_active` char(1) DEFAULT NULL,
  `modified_by` char(35) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `delete_record` char(3) DEFAULT 'NO'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_field_duty_selections`
--

CREATE TABLE `pgc_field_duty_selections` (
  `key_check` char(50) DEFAULT NULL,
  `member_id` char(40) DEFAULT NULL,
  `member_name` char(40) DEFAULT NULL,
  `pgc_active` varchar(3) DEFAULT NULL,
  `fd_role` char(5) DEFAULT NULL,
  `session` int(1) DEFAULT NULL,
  `choice1` date DEFAULT NULL,
  `choice2` date DEFAULT NULL,
  `choice3` date DEFAULT NULL,
  `choice_status` char(10) DEFAULT NULL,
  `date_selected` date DEFAULT NULL,
  `modified_by` char(35) DEFAULT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_ip` char(15) DEFAULT NULL,
  `delete_record` char(3) DEFAULT 'NO',
  `selected_count` int(3) DEFAULT NULL,
  `fd_holiday` char(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_field_duty_selections(2015 copy)`
--

CREATE TABLE `pgc_field_duty_selections(2015 copy)` (
  `key_check` char(50) DEFAULT NULL,
  `member_id` char(40) DEFAULT NULL,
  `member_name` char(40) DEFAULT NULL,
  `pgc_active` varchar(3) DEFAULT NULL,
  `fd_role` char(5) DEFAULT NULL,
  `session` int(1) DEFAULT NULL,
  `choice1` date DEFAULT NULL,
  `choice2` date DEFAULT NULL,
  `choice3` date DEFAULT NULL,
  `choice_status` char(10) DEFAULT NULL,
  `date_selected` date DEFAULT NULL,
  `modified_by` char(35) DEFAULT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_ip` char(15) DEFAULT NULL,
  `delete_record` char(3) DEFAULT 'NO',
  `selected_count` int(3) DEFAULT NULL,
  `fd_holiday` char(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_field_duty_selections_3-20`
--

CREATE TABLE `pgc_field_duty_selections_3-20` (
  `key_check` char(50) DEFAULT NULL,
  `member_id` char(40) DEFAULT NULL,
  `member_name` char(40) DEFAULT NULL,
  `pgc_active` varchar(3) DEFAULT NULL,
  `fd_role` char(5) DEFAULT NULL,
  `session` int(1) DEFAULT NULL,
  `choice1` date DEFAULT NULL,
  `choice2` date DEFAULT NULL,
  `choice3` date DEFAULT NULL,
  `choice_status` char(10) DEFAULT NULL,
  `date_selected` date DEFAULT NULL,
  `modified_by` char(35) DEFAULT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_ip` char(15) DEFAULT NULL,
  `delete_record` char(3) DEFAULT 'NO',
  `selected_count` int(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_field_duty_selections_audit`
--

CREATE TABLE `pgc_field_duty_selections_audit` (
  `audit_key` int(8) NOT NULL,
  `key_check` char(50) DEFAULT NULL,
  `member_id` char(40) DEFAULT NULL,
  `member_name` char(40) DEFAULT NULL,
  `fd_role` char(5) DEFAULT NULL,
  `session` int(1) DEFAULT NULL,
  `choice1` date DEFAULT NULL,
  `choice2` date DEFAULT NULL,
  `choice3` date DEFAULT NULL,
  `choice_status` char(10) DEFAULT NULL,
  `date_selected` date DEFAULT NULL,
  `modified_by` char(35) DEFAULT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_ip` char(15) DEFAULT NULL,
  `delete_record` char(3) DEFAULT 'NO',
  `selected_count` int(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_field_duty_selections_audit(2015 Copy)`
--

CREATE TABLE `pgc_field_duty_selections_audit(2015 Copy)` (
  `audit_key` int(8) NOT NULL,
  `key_check` char(50) DEFAULT NULL,
  `member_id` char(40) DEFAULT NULL,
  `member_name` char(40) DEFAULT NULL,
  `fd_role` char(5) DEFAULT NULL,
  `session` int(1) DEFAULT NULL,
  `choice1` date DEFAULT NULL,
  `choice2` date DEFAULT NULL,
  `choice3` date DEFAULT NULL,
  `choice_status` char(10) DEFAULT NULL,
  `date_selected` date DEFAULT NULL,
  `modified_by` char(35) DEFAULT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_ip` char(15) DEFAULT NULL,
  `delete_record` char(3) DEFAULT 'NO',
  `selected_count` int(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_field_duty_selections_detail`
--

CREATE TABLE `pgc_field_duty_selections_detail` (
  `fd_key` smallint(12) NOT NULL,
  `fd_date` date DEFAULT NULL,
  `member_id` char(40) DEFAULT NULL,
  `member_name` char(40) DEFAULT NULL,
  `fd_role` char(5) DEFAULT NULL,
  `session` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_file_list`
--

CREATE TABLE `pgc_file_list` (
  `doc_file_name` varchar(200) DEFAULT NULL,
  `doc_display_name` varchar(200) DEFAULT NULL,
  `doc_category` varchar(50) DEFAULT NULL,
  `doc_sub_category` varchar(50) DEFAULT NULL,
  `doc_source` varchar(50) DEFAULT NULL,
  `doc_posted` timestamp NULL DEFAULT NULL,
  `doc_modified_id` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_flight_tables`
--

CREATE TABLE `pgc_flight_tables` (
  `hist_key` int(11) NOT NULL,
  `ops_year` int(4) NOT NULL,
  `history_table` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_flightlog_charges`
--

CREATE TABLE `pgc_flightlog_charges` (
  `seq` int(2) NOT NULL DEFAULT '0',
  `altitude` char(5) DEFAULT NULL,
  `charge` decimal(6,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_flightlog_lastpilot`
--

CREATE TABLE `pgc_flightlog_lastpilot` (
  `seq` int(4) NOT NULL,
  `LastPilot` char(20) DEFAULT NULL,
  `TowPlane` char(6) DEFAULT NULL,
  `Date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_flightrisk`
--

CREATE TABLE `pgc_flightrisk` (
  `risk` text NOT NULL,
  `sequence` int(10) UNSIGNED NOT NULL,
  `low` tinyint(10) UNSIGNED ZEROFILL NOT NULL,
  `some` tinyint(10) UNSIGNED ZEROFILL NOT NULL,
  `moderate` tinyint(10) UNSIGNED ZEROFILL NOT NULL,
  `high` tinyint(10) UNSIGNED ZEROFILL NOT NULL,
  `tlow` tinytext NOT NULL,
  `tsome` tinytext NOT NULL,
  `tmoderate` tinytext NOT NULL,
  `thigh` tinytext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Table of flight Risks';

-- --------------------------------------------------------

--
-- Table structure for table `pgc_flightsheet`
--

CREATE TABLE `pgc_flightsheet` (
  `Key` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Glider` char(10) DEFAULT NULL,
  `Flight_Type` char(5) DEFAULT NULL,
  `Pilot1` varchar(30) DEFAULT NULL,
  `Pilot2` varchar(30) DEFAULT NULL,
  `Takeoff` time DEFAULT NULL,
  `Landing` time DEFAULT NULL,
  `Time` decimal(5,2) DEFAULT NULL,
  `Tow Altitude` char(5) DEFAULT '5000',
  `Tow Plane` char(10) DEFAULT NULL,
  `Tow Pilot` varchar(30) DEFAULT NULL,
  `Tow Charge` decimal(5,2) DEFAULT NULL,
  `Notes` varchar(250) DEFAULT NULL,
  `ip` char(20) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mail_count` int(1) DEFAULT NULL,
  `cfig_train` varchar(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_flightsheet_2010`
--

CREATE TABLE `pgc_flightsheet_2010` (
  `Key` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Glider` char(10) DEFAULT NULL,
  `Flight_Type` char(5) DEFAULT NULL,
  `Pilot1` varchar(30) DEFAULT NULL,
  `Pilot2` varchar(30) DEFAULT NULL,
  `Takeoff` time DEFAULT NULL,
  `Landing` time DEFAULT NULL,
  `Time` decimal(5,2) DEFAULT NULL,
  `Tow Altitude` char(5) DEFAULT '5000',
  `Tow Plane` char(10) DEFAULT NULL,
  `Tow Pilot` varchar(30) DEFAULT NULL,
  `Tow Charge` decimal(5,2) DEFAULT NULL,
  `Notes` varchar(31) DEFAULT NULL,
  `ip` char(20) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mail_count` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_flightsheet_2011`
--

CREATE TABLE `pgc_flightsheet_2011` (
  `Key` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Glider` char(10) DEFAULT NULL,
  `Flight_Type` char(5) DEFAULT NULL,
  `Pilot1` varchar(30) DEFAULT NULL,
  `Pilot2` varchar(30) DEFAULT NULL,
  `Takeoff` time DEFAULT NULL,
  `Landing` time DEFAULT NULL,
  `Time` decimal(5,2) DEFAULT NULL,
  `Tow Altitude` char(5) DEFAULT '5000',
  `Tow Plane` char(10) DEFAULT NULL,
  `Tow Pilot` varchar(30) DEFAULT NULL,
  `Tow Charge` decimal(5,2) DEFAULT NULL,
  `Notes` varchar(31) DEFAULT NULL,
  `ip` char(20) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mail_count` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_flightsheet_2012`
--

CREATE TABLE `pgc_flightsheet_2012` (
  `Key` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Glider` char(10) DEFAULT NULL,
  `Flight_Type` char(5) DEFAULT NULL,
  `Pilot1` varchar(30) DEFAULT NULL,
  `Pilot2` varchar(30) DEFAULT NULL,
  `Takeoff` time DEFAULT NULL,
  `Landing` time DEFAULT NULL,
  `Time` decimal(5,2) DEFAULT NULL,
  `Tow Altitude` char(5) DEFAULT '5000',
  `Tow Plane` char(10) DEFAULT NULL,
  `Tow Pilot` varchar(30) DEFAULT NULL,
  `Tow Charge` decimal(5,2) DEFAULT NULL,
  `Notes` varchar(31) DEFAULT NULL,
  `ip` char(20) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mail_count` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_flightsheet_2013`
--

CREATE TABLE `pgc_flightsheet_2013` (
  `Key` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Glider` char(10) DEFAULT NULL,
  `Flight_Type` char(5) DEFAULT NULL,
  `Pilot1` varchar(30) DEFAULT NULL,
  `Pilot2` varchar(30) DEFAULT NULL,
  `Takeoff` time DEFAULT NULL,
  `Landing` time DEFAULT NULL,
  `Time` decimal(5,2) DEFAULT NULL,
  `Tow Altitude` char(5) DEFAULT '5000',
  `Tow Plane` char(10) DEFAULT NULL,
  `Tow Pilot` varchar(30) DEFAULT NULL,
  `Tow Charge` decimal(5,2) DEFAULT NULL,
  `Notes` varchar(31) DEFAULT NULL,
  `ip` char(20) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mail_count` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_flightsheet_2014`
--

CREATE TABLE `pgc_flightsheet_2014` (
  `Key` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Glider` char(10) DEFAULT NULL,
  `Flight_Type` char(5) DEFAULT NULL,
  `Pilot1` varchar(30) DEFAULT NULL,
  `Pilot2` varchar(30) DEFAULT NULL,
  `Takeoff` time DEFAULT NULL,
  `Landing` time DEFAULT NULL,
  `Time` decimal(5,2) DEFAULT NULL,
  `Tow Altitude` char(5) DEFAULT '5000',
  `Tow Plane` char(10) DEFAULT NULL,
  `Tow Pilot` varchar(30) DEFAULT NULL,
  `Tow Charge` decimal(5,2) DEFAULT NULL,
  `Notes` varchar(250) DEFAULT NULL,
  `ip` char(20) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mail_count` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_flightsheet_2014_yearend`
--

CREATE TABLE `pgc_flightsheet_2014_yearend` (
  `Key` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Glider` char(10) DEFAULT NULL,
  `Flight_Type` char(5) DEFAULT NULL,
  `Pilot1` varchar(30) DEFAULT NULL,
  `Pilot2` varchar(30) DEFAULT NULL,
  `Takeoff` time DEFAULT NULL,
  `Landing` time DEFAULT NULL,
  `Time` decimal(5,2) DEFAULT NULL,
  `Tow Altitude` char(5) DEFAULT '5000',
  `Tow Plane` char(10) DEFAULT NULL,
  `Tow Pilot` varchar(30) DEFAULT NULL,
  `Tow Charge` decimal(5,2) DEFAULT NULL,
  `Notes` varchar(250) DEFAULT NULL,
  `ip` char(20) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mail_count` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_flightsheet_2015`
--

CREATE TABLE `pgc_flightsheet_2015` (
  `Key` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Glider` char(10) DEFAULT NULL,
  `Flight_Type` char(5) DEFAULT NULL,
  `Pilot1` varchar(30) DEFAULT NULL,
  `Pilot2` varchar(30) DEFAULT NULL,
  `Takeoff` time DEFAULT NULL,
  `Landing` time DEFAULT NULL,
  `Time` decimal(5,2) DEFAULT NULL,
  `Tow Altitude` char(5) DEFAULT '5000',
  `Tow Plane` char(10) DEFAULT NULL,
  `Tow Pilot` varchar(30) DEFAULT NULL,
  `Tow Charge` decimal(5,2) DEFAULT NULL,
  `Notes` varchar(250) DEFAULT NULL,
  `ip` char(20) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mail_count` int(1) DEFAULT NULL,
  `cfig_train` varchar(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_flightsheet_2015_V2`
--

CREATE TABLE `pgc_flightsheet_2015_V2` (
  `Key` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Glider` char(10) DEFAULT NULL,
  `Flight_Type` char(5) DEFAULT NULL,
  `Pilot1` varchar(30) DEFAULT NULL,
  `Pilot2` varchar(30) DEFAULT NULL,
  `Takeoff` time DEFAULT NULL,
  `Landing` time DEFAULT NULL,
  `Time` decimal(5,2) DEFAULT NULL,
  `Tow Altitude` char(5) DEFAULT '5000',
  `Tow Plane` char(10) DEFAULT NULL,
  `Tow Pilot` varchar(30) DEFAULT NULL,
  `Tow Charge` decimal(5,2) DEFAULT NULL,
  `Notes` varchar(250) DEFAULT NULL,
  `ip` char(20) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mail_count` int(1) DEFAULT NULL,
  `cfig_train` varchar(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_flightsheet_audit`
--

CREATE TABLE `pgc_flightsheet_audit` (
  `Key_Audit` int(11) NOT NULL,
  `Key` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Glider` char(10) DEFAULT NULL,
  `Flight_Type` char(4) DEFAULT NULL,
  `Pilot1` varchar(30) DEFAULT NULL,
  `Pilot2` varchar(30) DEFAULT NULL,
  `Takeoff` time DEFAULT NULL,
  `Landing` time DEFAULT NULL,
  `Time` decimal(5,2) DEFAULT NULL,
  `Tow Altitude` char(4) DEFAULT NULL,
  `Tow Plane` char(10) DEFAULT NULL,
  `Tow Pilot` varchar(30) DEFAULT NULL,
  `Tow Charge` decimal(6,2) DEFAULT NULL,
  `Notes` varchar(31) DEFAULT NULL,
  `ip` char(20) DEFAULT NULL,
  `email` char(30) DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_flightsheet_audit_2015`
--

CREATE TABLE `pgc_flightsheet_audit_2015` (
  `Key_Audit` int(11) NOT NULL,
  `Key` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Glider` char(10) DEFAULT NULL,
  `Flight_Type` char(4) DEFAULT NULL,
  `Pilot1` varchar(30) DEFAULT NULL,
  `Pilot2` varchar(30) DEFAULT NULL,
  `Takeoff` time DEFAULT NULL,
  `Landing` time DEFAULT NULL,
  `Time` decimal(5,2) DEFAULT NULL,
  `Tow Altitude` char(4) DEFAULT NULL,
  `Tow Plane` char(10) DEFAULT NULL,
  `Tow Pilot` varchar(30) DEFAULT NULL,
  `Tow Charge` decimal(6,2) DEFAULT NULL,
  `Notes` varchar(31) DEFAULT NULL,
  `ip` char(20) DEFAULT NULL,
  `email` char(30) DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_flightsheet_save`
--

CREATE TABLE `pgc_flightsheet_save` (
  `Key` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Glider` char(10) DEFAULT NULL,
  `Flight_Type` char(5) DEFAULT NULL,
  `Pilot1` varchar(30) DEFAULT NULL,
  `Pilot2` varchar(30) DEFAULT NULL,
  `Takeoff` time DEFAULT NULL,
  `Landing` time DEFAULT NULL,
  `Time` decimal(5,2) DEFAULT NULL,
  `Tow Altitude` char(5) DEFAULT '5000',
  `Tow Plane` char(10) DEFAULT NULL,
  `Tow Pilot` varchar(30) DEFAULT NULL,
  `Tow Charge` decimal(5,2) DEFAULT NULL,
  `Notes` varchar(31) DEFAULT NULL,
  `ip` char(20) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mail_count` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_flightsheet_temp`
--

CREATE TABLE `pgc_flightsheet_temp` (
  `Key` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Glider` char(10) DEFAULT NULL,
  `Flight_Type` char(5) DEFAULT NULL,
  `Pilot1` varchar(30) DEFAULT NULL,
  `Pilot2` varchar(30) DEFAULT NULL,
  `Takeoff` time DEFAULT NULL,
  `Landing` time DEFAULT NULL,
  `Time` decimal(5,2) DEFAULT NULL,
  `Tow Altitude` char(5) DEFAULT '5000',
  `Tow Plane` char(10) DEFAULT NULL,
  `Tow Pilot` varchar(30) DEFAULT NULL,
  `Tow Charge` decimal(5,2) DEFAULT NULL,
  `Notes` varchar(31) DEFAULT NULL,
  `ip` char(20) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mail_count` int(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_gliders`
--

CREATE TABLE `pgc_gliders` (
  `key` int(11) NOT NULL,
  `glider` char(10) DEFAULT NULL,
  `nnumber` varchar(7) DEFAULT NULL,
  `start_hours` decimal(7,2) DEFAULT '0.00',
  `pgc_hours` decimal(7,2) DEFAULT '0.00',
  `inspection_hours` decimal(7,2) DEFAULT '0.00',
  `inspection_date` date DEFAULT '2010-12-31',
  `delta_hours` decimal(7,2) DEFAULT '0.00',
  `total_hours` decimal(7,2) DEFAULT '0.00',
  `hour_display` char(1) DEFAULT 'Y',
  `nwgt` int(10) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_gliders_10_1012`
--

CREATE TABLE `pgc_gliders_10_1012` (
  `key` int(11) NOT NULL,
  `glider` char(10) DEFAULT NULL,
  `nnumber` varchar(7) DEFAULT NULL,
  `start_hours` decimal(7,2) DEFAULT '0.00',
  `pgc_hours` decimal(7,2) DEFAULT '0.00',
  `inspection_hours` decimal(7,2) DEFAULT '0.00',
  `inspection_date` date DEFAULT '2010-12-31',
  `delta_hours` decimal(7,2) DEFAULT '0.00',
  `total_hours` decimal(7,2) DEFAULT '0.00',
  `hour_display` char(1) DEFAULT 'Y'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_group_types`
--

CREATE TABLE `pgc_group_types` (
  `group_id` int(11) NOT NULL,
  `group_desc` char(20) NOT NULL,
  `active` char(1) NOT NULL DEFAULT 'Y',
  `start_hours` decimal(7,2) DEFAULT '0.00',
  `pgc_hours` decimal(7,2) DEFAULT '0.00',
  `inspection_hours` decimal(7,2) DEFAULT '0.00',
  `delta_hours` decimal(7,2) DEFAULT '0.00',
  `total_hours` decimal(7,2) DEFAULT '0.00',
  `hour_display` char(1) DEFAULT 'Y'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_instruction_types`
--

CREATE TABLE `pgc_instruction_types` (
  `Instruction_type` text,
  `list_order` varchar(2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_instructors`
--

CREATE TABLE `pgc_instructors` (
  `instructorID` int(11) NOT NULL,
  `Name` char(25) NOT NULL,
  `cfig` char(1) DEFAULT 'Y',
  `rec_active` varchar(1) DEFAULT 'Y',
  `mid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_inventory`
--

CREATE TABLE `pgc_inventory` (
  `inv_key` int(11) NOT NULL,
  `inv_category` varchar(20) DEFAULT NULL,
  `inv_desc` varchar(40) DEFAULT NULL,
  `inv_units_initial` int(4) DEFAULT NULL,
  `inv_units_current` int(4) DEFAULT NULL,
  `unit_cost` decimal(10,2) DEFAULT NULL,
  `inv_vendor` varchar(100) DEFAULT NULL,
  `last_restock_date` date DEFAULT NULL,
  `stock_status` varchar(15) DEFAULT NULL,
  `updated_by` varchar(40) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT NULL,
  `rec_deleted` varchar(1) DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_inventory_used`
--

CREATE TABLE `pgc_inventory_used` (
  `inv_used_key` int(11) NOT NULL,
  `sq_key` int(11) DEFAULT NULL,
  `inv_key` int(11) DEFAULT NULL,
  `inv_used_date` date DEFAULT NULL,
  `inv_used_units` int(4) DEFAULT NULL,
  `inv_category` varchar(20) DEFAULT NULL,
  `inv_desc` varchar(40) DEFAULT NULL,
  `inv_units_initial` int(4) DEFAULT NULL,
  `inv_units_current` int(4) DEFAULT NULL,
  `unit_cost` decimal(10,2) DEFAULT NULL,
  `inv_vendor` varchar(100) DEFAULT NULL,
  `last_restock_date` date DEFAULT NULL,
  `stock_status` varchar(15) DEFAULT NULL,
  `updated_by` varchar(40) DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT NULL,
  `rec_deleted` varchar(1) DEFAULT 'N',
  `total_cost` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_job_status`
--

CREATE TABLE `pgc_job_status` (
  `status_key` int(11) NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `job_status` char(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_job_volunteers`
--

CREATE TABLE `pgc_job_volunteers` (
  `volunteer_key` int(11) NOT NULL,
  `job_id` int(11) DEFAULT NULL,
  `post_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `post_id` varchar(50) DEFAULT NULL,
  `job_volunteer_name` varchar(200) DEFAULT NULL,
  `job_volunteer_id` varchar(200) DEFAULT NULL,
  `dup_check_key` varchar(200) DEFAULT NULL,
  `rec_deleted` varchar(3) NOT NULL DEFAULT 'NO'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_jobs`
--

CREATE TABLE `pgc_jobs` (
  `job_key` int(11) NOT NULL,
  `post_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `post_id` varchar(50) DEFAULT NULL,
  `job_sponsor` varchar(50) DEFAULT NULL,
  `job_sponsor_email` varchar(200) DEFAULT NULL,
  `job_leader` varchar(50) DEFAULT NULL,
  `job_leader_email` varchar(200) DEFAULT NULL,
  `job_name` varchar(50) DEFAULT NULL,
  `job_description` varchar(400) DEFAULT NULL,
  `job_materials` varchar(400) DEFAULT NULL,
  `job_volunteers_required` int(2) DEFAULT NULL,
  `job_volunteers` varchar(400) DEFAULT NULL,
  `job_volunteers_email` varchar(400) DEFAULT NULL,
  `job_status` varchar(100) DEFAULT NULL,
  `job_comments` varchar(400) DEFAULT NULL,
  `job_completed` date DEFAULT NULL,
  `sort_order` int(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_member_roster`
--

CREATE TABLE `pgc_member_roster` (
  `customer` char(45) NOT NULL DEFAULT '',
  `phone` char(20) DEFAULT NULL,
  `alt_phone` char(20) DEFAULT NULL,
  `street` char(45) DEFAULT NULL,
  `city` char(30) DEFAULT NULL,
  `state` char(30) DEFAULT NULL,
  `zip` char(15) DEFAULT NULL,
  `email` char(65) DEFAULT NULL,
  `customer_type` char(30) DEFAULT NULL,
  `cell_number` char(20) DEFAULT NULL,
  `pgc_start_date` char(20) DEFAULT NULL,
  `glider_license` char(20) DEFAULT NULL,
  `customer2` char(45) DEFAULT NULL,
  `phone2` char(20) DEFAULT NULL,
  `alt_phone2` char(20) DEFAULT NULL,
  `street2` char(45) DEFAULT NULL,
  `city2` char(30) DEFAULT NULL,
  `state2` char(30) DEFAULT NULL,
  `zip2` char(15) DEFAULT NULL,
  `email2` char(65) DEFAULT NULL,
  `customer_type2` char(30) DEFAULT NULL,
  `cell_number2` char(20) DEFAULT NULL,
  `pgc_start_date2` char(20) DEFAULT NULL,
  `glider_license2` char(20) DEFAULT NULL,
  `active` char(3) DEFAULT NULL,
  `mid` smallint(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_members`
--

CREATE TABLE `pgc_members` (
  `USER_ID` char(40) NOT NULL,
  `USER_PW` char(30) NOT NULL,
  `USER_ALIAS` char(30) DEFAULT NULL,
  `NAME` varchar(40) DEFAULT NULL,
  `PGC_STATUS` char(20) NOT NULL,
  `ROLE` char(10) NOT NULL,
  `update_date` date NOT NULL,
  `pw1` char(30) NOT NULL,
  `pw2` char(30) NOT NULL,
  `active` char(3) DEFAULT NULL,
  `last_login_date` date NOT NULL,
  `new_user_id1` char(40) DEFAULT NULL,
  `new_user_id2` char(40) DEFAULT NULL,
  `old_user_id` char(40) DEFAULT NULL,
  `optout` varchar(1) DEFAULT 'N',
  `mid` smallint(5) UNSIGNED NOT NULL,
  `duty_role` varchar(5) DEFAULT NULL,
  `dt_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_members_10-2012`
--

CREATE TABLE `pgc_members_10-2012` (
  `USER_ID` char(40) NOT NULL,
  `USER_PW` char(30) NOT NULL,
  `NAME` varchar(40) DEFAULT NULL,
  `PGC_STATUS` char(20) NOT NULL,
  `ROLE` char(10) NOT NULL,
  `update_date` date NOT NULL,
  `pw1` char(30) NOT NULL,
  `pw2` char(30) NOT NULL,
  `active` char(3) DEFAULT NULL,
  `last_login_date` date NOT NULL,
  `new_user_id1` char(40) DEFAULT NULL,
  `new_user_id2` char(40) DEFAULT NULL,
  `old_user_id` char(40) DEFAULT NULL,
  `optout` varchar(1) DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_members_10_18_12`
--

CREATE TABLE `pgc_members_10_18_12` (
  `USER_ID` char(40) NOT NULL,
  `USER_PW` char(30) NOT NULL,
  `USER_ALIAS` char(30) DEFAULT NULL,
  `NAME` varchar(40) DEFAULT NULL,
  `PGC_STATUS` char(20) NOT NULL,
  `ROLE` char(10) NOT NULL,
  `update_date` date NOT NULL,
  `pw1` char(30) NOT NULL,
  `pw2` char(30) NOT NULL,
  `active` char(3) DEFAULT NULL,
  `last_login_date` date NOT NULL,
  `new_user_id1` char(40) DEFAULT NULL,
  `new_user_id2` char(40) DEFAULT NULL,
  `old_user_id` char(40) DEFAULT NULL,
  `optout` varchar(1) DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_members_113014`
--

CREATE TABLE `pgc_members_113014` (
  `USER_ID` char(40) NOT NULL,
  `USER_PW` char(30) NOT NULL,
  `USER_ALIAS` char(30) DEFAULT NULL,
  `NAME` varchar(40) DEFAULT NULL,
  `PGC_STATUS` char(20) NOT NULL,
  `ROLE` char(10) NOT NULL,
  `update_date` date NOT NULL,
  `pw1` char(30) NOT NULL,
  `pw2` char(30) NOT NULL,
  `active` char(3) DEFAULT NULL,
  `last_login_date` date NOT NULL,
  `new_user_id1` char(40) DEFAULT NULL,
  `new_user_id2` char(40) DEFAULT NULL,
  `old_user_id` char(40) DEFAULT NULL,
  `optout` varchar(1) DEFAULT 'N',
  `mid` smallint(5) UNSIGNED NOT NULL,
  `duty_role` varchar(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_members_12_08_14`
--

CREATE TABLE `pgc_members_12_08_14` (
  `USER_ID` char(40) NOT NULL,
  `USER_PW` char(30) NOT NULL,
  `USER_ALIAS` char(30) DEFAULT NULL,
  `NAME` varchar(40) DEFAULT NULL,
  `PGC_STATUS` char(20) NOT NULL,
  `ROLE` char(10) NOT NULL,
  `update_date` date NOT NULL,
  `pw1` char(30) NOT NULL,
  `pw2` char(30) NOT NULL,
  `active` char(3) DEFAULT NULL,
  `last_login_date` date NOT NULL,
  `new_user_id1` char(40) DEFAULT NULL,
  `new_user_id2` char(40) DEFAULT NULL,
  `old_user_id` char(40) DEFAULT NULL,
  `optout` varchar(1) DEFAULT 'N',
  `mid` smallint(5) UNSIGNED NOT NULL,
  `duty_role` varchar(5) DEFAULT NULL,
  `dt_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_members_import_csv`
--

CREATE TABLE `pgc_members_import_csv` (
  `F1` char(45) DEFAULT NULL,
  `F2` char(45) DEFAULT NULL,
  `customer` char(45) DEFAULT NULL,
  `F3` char(5) DEFAULT NULL,
  `phone` char(20) DEFAULT NULL,
  `F4` char(5) DEFAULT NULL,
  `alt_phone` char(20) DEFAULT NULL,
  `F5` char(5) DEFAULT NULL,
  `street1` char(45) DEFAULT NULL,
  `F6` char(5) DEFAULT NULL,
  `City` char(30) DEFAULT NULL,
  `F7` char(5) DEFAULT NULL,
  `state` char(30) DEFAULT NULL,
  `F77` char(5) DEFAULT NULL,
  `Zip` char(15) DEFAULT NULL,
  `F8` char(5) DEFAULT NULL,
  `email` char(65) DEFAULT NULL,
  `F9` char(5) DEFAULT NULL,
  `customer_type` char(30) DEFAULT NULL,
  `F10` char(5) DEFAULT NULL,
  `cell_number` char(20) DEFAULT NULL,
  `F11` char(5) DEFAULT NULL,
  `pgc_start_date` char(20) DEFAULT NULL,
  `F12` char(5) DEFAULT NULL,
  `glider_license` char(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_members_joined`
--

CREATE TABLE `pgc_members_joined` (
  `USER_ID` char(40) DEFAULT '',
  `NAME` varchar(40) DEFAULT NULL,
  `duty_role` varchar(5) DEFAULT NULL,
  `dt_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_pilot_ratings`
--

CREATE TABLE `pgc_pilot_ratings` (
  `rating_id` int(11) NOT NULL,
  `pilot_name` char(40) NOT NULL,
  `pgc_rating` char(25) NOT NULL,
  `delete_record` char(3) DEFAULT 'NO',
  `mid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_pilot_signoffs`
--

CREATE TABLE `pgc_pilot_signoffs` (
  `signoffID` int(11) NOT NULL,
  `pilot_ID` int(11) DEFAULT NULL,
  `pilot_name` varchar(40) DEFAULT NULL,
  `signoff_type` varchar(30) DEFAULT NULL,
  `signoff_date` date DEFAULT NULL,
  `instructor` varchar(25) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `status` char(10) DEFAULT NULL,
  `delete_record` char(3) DEFAULT 'NO',
  `modified_by` varchar(35) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_ip` varchar(35) NOT NULL,
  `sys_date` date DEFAULT NULL,
  `days_to_expiry` smallint(4) DEFAULT NULL,
  `30_day_email` date DEFAULT NULL,
  `expiry_email` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_pilot_signoffs_1_6_2012`
--

CREATE TABLE `pgc_pilot_signoffs_1_6_2012` (
  `signoffID` int(11) NOT NULL,
  `pilot_ID` int(11) DEFAULT NULL,
  `pilot_name` varchar(40) DEFAULT NULL,
  `signoff_type` varchar(30) DEFAULT NULL,
  `signoff_date` date DEFAULT NULL,
  `instructor` varchar(25) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `status` char(10) DEFAULT NULL,
  `delete_record` char(3) DEFAULT 'NO',
  `modified_by` varchar(35) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_ip` varchar(35) NOT NULL,
  `sys_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_pilot_signoffs_2012`
--

CREATE TABLE `pgc_pilot_signoffs_2012` (
  `signoffID` int(11) NOT NULL,
  `pilot_ID` int(11) DEFAULT NULL,
  `pilot_name` varchar(40) DEFAULT NULL,
  `signoff_type` varchar(30) DEFAULT NULL,
  `signoff_date` date DEFAULT NULL,
  `instructor` varchar(25) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `status` char(10) DEFAULT NULL,
  `delete_record` char(3) DEFAULT 'NO',
  `modified_by` varchar(35) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_ip` varchar(35) NOT NULL,
  `sys_date` date DEFAULT NULL,
  `days_to_expiry` smallint(4) DEFAULT NULL,
  `30_day_email` date DEFAULT NULL,
  `expiry_email` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_pilot_signoffs_82012`
--

CREATE TABLE `pgc_pilot_signoffs_82012` (
  `signoffID` int(11) NOT NULL,
  `pilot_ID` int(11) DEFAULT NULL,
  `pilot_name` varchar(40) DEFAULT NULL,
  `signoff_type` varchar(30) DEFAULT NULL,
  `signoff_date` date DEFAULT NULL,
  `instructor` varchar(25) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `status` char(10) DEFAULT NULL,
  `delete_record` char(3) DEFAULT 'NO',
  `modified_by` varchar(35) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_ip` varchar(35) NOT NULL,
  `sys_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_pilot_signoffs_bak`
--

CREATE TABLE `pgc_pilot_signoffs_bak` (
  `signoffID` int(11) NOT NULL,
  `pilot_ID` int(11) DEFAULT NULL,
  `pilot_name` varchar(40) DEFAULT NULL,
  `signoff_type` varchar(30) DEFAULT NULL,
  `signoff_date` date DEFAULT NULL,
  `instructor` varchar(25) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `status` char(10) DEFAULT NULL,
  `delete_record` char(3) DEFAULT 'NO',
  `modified_by` varchar(35) NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_ip` varchar(35) NOT NULL,
  `sys_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_pilots`
--

CREATE TABLE `pgc_pilots` (
  `pilot_ID` int(11) NOT NULL,
  `pilot_name` varchar(40) NOT NULL,
  `e_mail` varchar(40) DEFAULT NULL,
  `pgc_member_type` varchar(20) NOT NULL,
  `pgc_rating` varchar(20) DEFAULT NULL,
  `faa_cert` varchar(20) NOT NULL,
  `fly_status` varchar(20) DEFAULT NULL,
  `pgc_ratings` varchar(50) DEFAULT NULL,
  `admin_status` varchar(40) DEFAULT NULL,
  `admin_date` date DEFAULT NULL,
  `adimin_update_id` varchar(40) DEFAULT NULL,
  `batch_update_date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_pirep`
--

CREATE TABLE `pgc_pirep` (
  `pirep_key` int(11) NOT NULL,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_entered` varchar(50) DEFAULT NULL,
  `id_name` varchar(50) DEFAULT NULL,
  `pirep_date` date DEFAULT NULL,
  `pirep_desc` varchar(1000) DEFAULT NULL,
  `rec_deleted` varchar(1) DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_ratings_list`
--

CREATE TABLE `pgc_ratings_list` (
  `rating_id` int(11) NOT NULL,
  `rating_name` char(25) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_request`
--

CREATE TABLE `pgc_request` (
  `request_key` smallint(9) NOT NULL,
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `member_id` char(40) DEFAULT NULL,
  `member_name` char(30) DEFAULT NULL,
  `member_weight` int(3) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `request_time` char(4) DEFAULT NULL,
  `request_type` char(30) DEFAULT NULL,
  `request_cfig` char(30) DEFAULT NULL,
  `cfig_vacation` char(1) DEFAULT NULL,
  `request_cfig2` char(30) DEFAULT NULL,
  `cfig_vacation2` char(1) DEFAULT NULL,
  `request_notes` char(30) DEFAULT NULL,
  `accept_cfig` char(30) DEFAULT NULL,
  `cfig2_vacation` char(1) DEFAULT NULL,
  `cfig_weight` int(3) DEFAULT NULL,
  `accept_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `accept_notes` char(30) DEFAULT NULL,
  `cfig1_email` char(40) DEFAULT NULL,
  `cfig2_email` char(40) DEFAULT NULL,
  `assign_cfig_email` char(40) DEFAULT NULL,
  `orig_request_cfig` char(30) DEFAULT NULL,
  `orig_request_cfig2` char(30) DEFAULT NULL,
  `orig_accept_cfig` char(30) DEFAULT NULL,
  `orig_request_date` date DEFAULT NULL,
  `orig_cfig1_email` char(40) DEFAULT NULL,
  `orig_cfig2_email` char(40) DEFAULT NULL,
  `orig_assign_cfig_email` char(40) DEFAULT NULL,
  `record_deleted` char(1) NOT NULL DEFAULT 'N',
  `source_key` int(5) DEFAULT NULL,
  `request_day` char(10) DEFAULT NULL,
  `rec_processed` char(1) DEFAULT NULL,
  `rec_processed2` char(1) DEFAULT NULL,
  `rec_processed3` char(1) DEFAULT NULL,
  `cfig_confirmed` char(3) NOT NULL DEFAULT 'NO',
  `sched_assist` char(1) DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_request_20112`
--

CREATE TABLE `pgc_request_20112` (
  `request_key` smallint(9) NOT NULL,
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `member_id` char(40) DEFAULT NULL,
  `member_name` char(30) DEFAULT NULL,
  `member_weight` int(3) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `request_time` char(4) DEFAULT NULL,
  `request_type` char(30) DEFAULT NULL,
  `request_cfig` char(30) DEFAULT NULL,
  `cfig_vacation` char(1) DEFAULT NULL,
  `request_cfig2` char(30) DEFAULT NULL,
  `cfig_vacation2` char(1) DEFAULT NULL,
  `request_notes` char(30) DEFAULT NULL,
  `accept_cfig` char(30) DEFAULT NULL,
  `cfig2_vacation` char(1) DEFAULT NULL,
  `cfig_weight` int(3) DEFAULT NULL,
  `accept_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `accept_notes` char(30) DEFAULT NULL,
  `cfig1_email` char(40) DEFAULT NULL,
  `cfig2_email` char(40) DEFAULT NULL,
  `assign_cfig_email` char(40) DEFAULT NULL,
  `orig_request_cfig` char(30) DEFAULT NULL,
  `orig_request_cfig2` char(30) DEFAULT NULL,
  `orig_accept_cfig` char(30) DEFAULT NULL,
  `orig_request_date` date DEFAULT NULL,
  `orig_cfig1_email` char(40) DEFAULT NULL,
  `orig_cfig2_email` char(40) DEFAULT NULL,
  `orig_assign_cfig_email` char(40) DEFAULT NULL,
  `record_deleted` char(1) NOT NULL DEFAULT 'N',
  `source_key` int(5) DEFAULT NULL,
  `request_day` char(10) DEFAULT NULL,
  `rec_processed` char(1) DEFAULT NULL,
  `rec_processed2` char(1) DEFAULT NULL,
  `rec_processed3` char(1) DEFAULT NULL,
  `cfig_confirmed` char(3) NOT NULL DEFAULT 'NO',
  `sched_assist` char(1) DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_request_2012`
--

CREATE TABLE `pgc_request_2012` (
  `request_key` smallint(9) NOT NULL,
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `member_id` char(40) DEFAULT NULL,
  `member_name` char(30) DEFAULT NULL,
  `member_weight` int(3) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `request_time` char(4) DEFAULT NULL,
  `request_type` char(30) DEFAULT NULL,
  `request_cfig` char(30) DEFAULT NULL,
  `cfig_vacation` char(1) DEFAULT NULL,
  `request_cfig2` char(30) DEFAULT NULL,
  `cfig_vacation2` char(1) DEFAULT NULL,
  `request_notes` char(30) DEFAULT NULL,
  `accept_cfig` char(30) DEFAULT NULL,
  `cfig2_vacation` char(1) DEFAULT NULL,
  `cfig_weight` int(3) DEFAULT NULL,
  `accept_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `accept_notes` char(30) DEFAULT NULL,
  `cfig1_email` char(40) DEFAULT NULL,
  `cfig2_email` char(40) DEFAULT NULL,
  `assign_cfig_email` char(40) DEFAULT NULL,
  `orig_request_cfig` char(30) DEFAULT NULL,
  `orig_request_cfig2` char(30) DEFAULT NULL,
  `orig_accept_cfig` char(30) DEFAULT NULL,
  `orig_request_date` date DEFAULT NULL,
  `orig_cfig1_email` char(40) DEFAULT NULL,
  `orig_cfig2_email` char(40) DEFAULT NULL,
  `orig_assign_cfig_email` char(40) DEFAULT NULL,
  `record_deleted` char(1) NOT NULL DEFAULT 'N',
  `source_key` int(5) DEFAULT NULL,
  `request_day` char(10) DEFAULT NULL,
  `rec_processed` char(1) DEFAULT NULL,
  `rec_processed2` char(1) DEFAULT NULL,
  `rec_processed3` char(1) DEFAULT NULL,
  `cfig_confirmed` char(3) NOT NULL DEFAULT 'NO',
  `sched_assist` char(1) DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_request_2013`
--

CREATE TABLE `pgc_request_2013` (
  `request_key` smallint(9) NOT NULL,
  `entry_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `member_id` char(40) DEFAULT NULL,
  `member_name` char(30) DEFAULT NULL,
  `member_weight` int(3) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `request_time` char(4) DEFAULT NULL,
  `request_type` char(30) DEFAULT NULL,
  `request_cfig` char(30) DEFAULT NULL,
  `cfig_vacation` char(1) DEFAULT NULL,
  `request_cfig2` char(30) DEFAULT NULL,
  `cfig_vacation2` char(1) DEFAULT NULL,
  `request_notes` char(30) DEFAULT NULL,
  `accept_cfig` char(30) DEFAULT NULL,
  `cfig2_vacation` char(1) DEFAULT NULL,
  `cfig_weight` int(3) DEFAULT NULL,
  `accept_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `accept_notes` char(30) DEFAULT NULL,
  `cfig1_email` char(40) DEFAULT NULL,
  `cfig2_email` char(40) DEFAULT NULL,
  `assign_cfig_email` char(40) DEFAULT NULL,
  `orig_request_cfig` char(30) DEFAULT NULL,
  `orig_request_cfig2` char(30) DEFAULT NULL,
  `orig_accept_cfig` char(30) DEFAULT NULL,
  `orig_request_date` date DEFAULT NULL,
  `orig_cfig1_email` char(40) DEFAULT NULL,
  `orig_cfig2_email` char(40) DEFAULT NULL,
  `orig_assign_cfig_email` char(40) DEFAULT NULL,
  `record_deleted` char(1) NOT NULL DEFAULT 'N',
  `source_key` int(5) DEFAULT NULL,
  `request_day` char(10) DEFAULT NULL,
  `rec_processed` char(1) DEFAULT NULL,
  `rec_processed2` char(1) DEFAULT NULL,
  `rec_processed3` char(1) DEFAULT NULL,
  `cfig_confirmed` char(3) NOT NULL DEFAULT 'NO',
  `sched_assist` char(1) DEFAULT 'N'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_signoff_import_csv`
--

CREATE TABLE `pgc_signoff_import_csv` (
  `pilot_name` char(35) DEFAULT NULL,
  `signoff_date` date DEFAULT NULL,
  `signoff_type` char(35) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_signoff_nofly`
--

CREATE TABLE `pgc_signoff_nofly` (
  `pilot_name` char(35) NOT NULL,
  `pgc_status` char(20) DEFAULT NULL,
  `pgc_invalid_signoffs` varchar(300) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_signoff_roles`
--

CREATE TABLE `pgc_signoff_roles` (
  `signoffID` int(11) NOT NULL,
  `description` char(30) NOT NULL,
  `update_role` char(10) DEFAULT '',
  `last_update_date` date DEFAULT '0000-00-00',
  `last_update_id` varchar(25) DEFAULT 'SYSTEM',
  `delete_record` char(3) DEFAULT 'NO',
  `sort_order` int(3) DEFAULT '99'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_signoff_types`
--

CREATE TABLE `pgc_signoff_types` (
  `signoffID` int(11) NOT NULL,
  `description` char(30) NOT NULL,
  `target_group` char(15) DEFAULT 'ALL',
  `expires` char(3) DEFAULT 'YES',
  `duration_days` int(4) DEFAULT '365',
  `eom_expiry` char(3) DEFAULT 'NO',
  `member_updates` char(3) DEFAULT 'NO',
  `yearly_reset` char(3) DEFAULT 'NO',
  `group_id` char(1) DEFAULT 'Z',
  `default_signoff_date` date DEFAULT '0000-00-00',
  `default_expire_date` date DEFAULT '0000-00-00',
  `calc_expire_date` char(3) DEFAULT 'YES',
  `active` char(3) DEFAULT 'YES',
  `last_update_date` date DEFAULT '0000-00-00',
  `last_update_id` varchar(25) DEFAULT 'SYSTEM',
  `delete_record` char(3) DEFAULT 'NO',
  `sort_order` int(3) DEFAULT '99'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_squawk`
--

CREATE TABLE `pgc_squawk` (
  `sq_key` int(11) NOT NULL,
  `date_entered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_entered` text,
  `id_name` text,
  `sq_date` date DEFAULT NULL,
  `sq_equipment` varchar(35) DEFAULT NULL,
  `sq_issue` varchar(700) DEFAULT NULL,
  `sq_status` varchar(10) NOT NULL DEFAULT 'OPEN',
  `rec_deleted` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_squawk_metrics`
--

CREATE TABLE `pgc_squawk_metrics` (
  `metrics_equipment` varchar(40) DEFAULT NULL,
  `ship_captain` varchar(40) DEFAULT NULL,
  `new` int(11) DEFAULT NULL,
  `open` int(11) DEFAULT NULL,
  `pending` int(11) DEFAULT NULL,
  `completed` int(11) DEFAULT NULL,
  `total_$` decimal(11,2) DEFAULT NULL,
  `total_hrs` decimal(11,2) DEFAULT NULL,
  `metrics_status` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_squawk_work`
--

CREATE TABLE `pgc_squawk_work` (
  `sq_work_key` int(11) NOT NULL,
  `sq_key` int(11) DEFAULT NULL,
  `work_date` date DEFAULT NULL,
  `worker` varchar(60) DEFAULT NULL,
  `work_hours` decimal(6,2) DEFAULT '0.00',
  `work_desc` varchar(400) DEFAULT NULL,
  `rec_deleted` varchar(1) DEFAULT 'N',
  `entered_by` varchar(40) DEFAULT NULL,
  `entered_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pgc_system`
--

CREATE TABLE `pgc_system` (
  `sys_status` char(4) DEFAULT NULL,
  `request_emails` varchar(100) DEFAULT NULL,
  `flightlog_emails` varchar(100) DEFAULT NULL,
  `expiry_emails` varchar(100) DEFAULT NULL,
  `admin_emails` varchar(100) DEFAULT NULL,
  `expiry_email_run` date DEFAULT NULL,
  `expired_email_run` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `relationship`
--

CREATE TABLE `relationship` (
  `name1` char(35) DEFAULT NULL,
  `age1` int(3) DEFAULT NULL,
  `gender1` char(1) DEFAULT NULL,
  `relationship` char(20) DEFAULT NULL,
  `name2` char(35) DEFAULT NULL,
  `age2` int(3) DEFAULT NULL,
  `gender2` char(1) DEFAULT NULL,
  `record_type` char(1) DEFAULT NULL,
  `seq` int(12) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reminders`
--

CREATE TABLE `reminders` (
  `reminderid` char(16) NOT NULL DEFAULT '',
  `memberid` char(16) NOT NULL DEFAULT '',
  `resid` char(16) NOT NULL DEFAULT '',
  `reminder_time` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_resources`
--

CREATE TABLE `reservation_resources` (
  `resid` char(16) NOT NULL DEFAULT '',
  `resourceid` char(16) NOT NULL DEFAULT '',
  `owner` smallint(6) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_users`
--

CREATE TABLE `reservation_users` (
  `resid` char(16) NOT NULL DEFAULT '',
  `memberid` char(16) NOT NULL DEFAULT '',
  `owner` smallint(6) DEFAULT NULL,
  `invited` smallint(6) DEFAULT NULL,
  `perm_modify` smallint(6) DEFAULT NULL,
  `perm_delete` smallint(6) DEFAULT NULL,
  `accept_code` char(16) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `resid` varchar(16) NOT NULL DEFAULT '',
  `machid` varchar(16) NOT NULL DEFAULT '',
  `scheduleid` varchar(16) NOT NULL DEFAULT '',
  `start_date` int(11) NOT NULL DEFAULT '0',
  `end_date` int(11) NOT NULL DEFAULT '0',
  `starttime` int(11) NOT NULL DEFAULT '0',
  `endtime` int(11) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `modified` int(11) DEFAULT NULL,
  `parentid` varchar(16) DEFAULT NULL,
  `is_blackout` smallint(6) NOT NULL DEFAULT '0',
  `is_pending` smallint(6) NOT NULL DEFAULT '0',
  `summary` text,
  `allow_participation` smallint(6) NOT NULL DEFAULT '0',
  `allow_anon_participation` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `machid` varchar(16) NOT NULL DEFAULT '',
  `scheduleid` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(75) NOT NULL DEFAULT '',
  `location` varchar(250) DEFAULT NULL,
  `rphone` varchar(16) DEFAULT NULL,
  `notes` text,
  `status` char(1) NOT NULL DEFAULT 'a',
  `minres` int(11) NOT NULL DEFAULT '0',
  `maxres` int(11) NOT NULL DEFAULT '0',
  `autoassign` smallint(6) DEFAULT NULL,
  `approval` smallint(6) DEFAULT NULL,
  `allow_multi` smallint(6) DEFAULT NULL,
  `max_participants` int(11) DEFAULT NULL,
  `min_notice_time` int(11) DEFAULT NULL,
  `max_notice_time` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schedule_permission`
--

CREATE TABLE `schedule_permission` (
  `scheduleid` char(16) NOT NULL DEFAULT '',
  `memberid` char(16) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `scheduleid` varchar(16) NOT NULL DEFAULT '',
  `scheduletitle` varchar(75) DEFAULT NULL,
  `daystart` int(11) NOT NULL DEFAULT '0',
  `dayend` int(11) NOT NULL DEFAULT '0',
  `timespan` int(11) NOT NULL DEFAULT '0',
  `timeformat` int(11) NOT NULL DEFAULT '0',
  `weekdaystart` int(11) NOT NULL DEFAULT '0',
  `viewdays` int(11) NOT NULL DEFAULT '0',
  `usepermissions` smallint(6) DEFAULT NULL,
  `ishidden` smallint(6) DEFAULT NULL,
  `showsummary` smallint(6) DEFAULT NULL,
  `adminemail` varchar(75) DEFAULT NULL,
  `isdefault` smallint(6) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `groupid` char(16) NOT NULL DEFAULT '',
  `memberid` char(50) NOT NULL DEFAULT '',
  `is_admin` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_resources`
--
ALTER TABLE `additional_resources`
  ADD PRIMARY KEY (`resourceid`),
  ADD KEY `ar_name` (`name`),
  ADD KEY `ar_status` (`status`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcementid`),
  ADD KEY `announcements_startdatetime` (`start_datetime`),
  ADD KEY `announcements_enddatetime` (`end_datetime`);

--
-- Indexes for table `anonymous_users`
--
ALTER TABLE `anonymous_users`
  ADD PRIMARY KEY (`memberid`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`groupid`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`memberid`),
  ADD KEY `login_email` (`email`),
  ADD KEY `login_password` (`password`),
  ADD KEY `login_logonname` (`logon_name`);

--
-- Indexes for table `mutex`
--
ALTER TABLE `mutex`
  ADD PRIMARY KEY (`i`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`memberid`,`machid`),
  ADD KEY `per_memberid` (`memberid`),
  ADD KEY `per_machid` (`machid`);

--
-- Indexes for table `pgc_access_app_groups`
--
ALTER TABLE `pgc_access_app_groups`
  ADD PRIMARY KEY (`rec_key`),
  ADD UNIQUE KEY `app_name` (`app_name`,`allowed_group`);

--
-- Indexes for table `pgc_access_apps`
--
ALTER TABLE `pgc_access_apps`
  ADD PRIMARY KEY (`app_key`),
  ADD UNIQUE KEY `app_name` (`app_name`);

--
-- Indexes for table `pgc_access_functionlist`
--
ALTER TABLE `pgc_access_functionlist`
  ADD PRIMARY KEY (`rec_key`),
  ADD UNIQUE KEY `rec_key` (`rec_key`);

--
-- Indexes for table `pgc_access_grouplist`
--
ALTER TABLE `pgc_access_grouplist`
  ADD PRIMARY KEY (`rec_key`);

--
-- Indexes for table `pgc_access_member_groups`
--
ALTER TABLE `pgc_access_member_groups`
  ADD PRIMARY KEY (`rec_key`);

--
-- Indexes for table `pgc_batch_email`
--
ALTER TABLE `pgc_batch_email`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pgc_calendar`
--
ALTER TABLE `pgc_calendar`
  ADD PRIMARY KEY (`EventID`);

--
-- Indexes for table `pgc_cfig_dates`
--
ALTER TABLE `pgc_cfig_dates`
  ADD PRIMARY KEY (`rec_key`);

--
-- Indexes for table `pgc_cfig_vacation`
--
ALTER TABLE `pgc_cfig_vacation`
  ADD PRIMARY KEY (`vac_key`);

--
-- Indexes for table `pgc_cfig_vacation_12-2012`
--
ALTER TABLE `pgc_cfig_vacation_12-2012`
  ADD PRIMARY KEY (`vac_key`);

--
-- Indexes for table `pgc_cfig_vacation_copy`
--
ALTER TABLE `pgc_cfig_vacation_copy`
  ADD PRIMARY KEY (`vac_key`);

--
-- Indexes for table `pgc_class`
--
ALTER TABLE `pgc_class`
  ADD PRIMARY KEY (`rec_index`),
  ADD KEY `rec_index` (`rec_index`);

--
-- Indexes for table `pgc_date`
--
ALTER TABLE `pgc_date`
  ADD PRIMARY KEY (`ops_Date`);

--
-- Indexes for table `pgc_doc_category_master`
--
ALTER TABLE `pgc_doc_category_master`
  ADD UNIQUE KEY `rec_key` (`rec_key`),
  ADD UNIQUE KEY `doc_category` (`doc_category`);

--
-- Indexes for table `pgc_doc_combos`
--
ALTER TABLE `pgc_doc_combos`
  ADD UNIQUE KEY `doc_combo` (`doc_combo`);

--
-- Indexes for table `pgc_doc_lib_list`
--
ALTER TABLE `pgc_doc_lib_list`
  ADD PRIMARY KEY (`rec_id`),
  ADD UNIQUE KEY `file_name` (`doc_file_name`);

--
-- Indexes for table `pgc_doc_subcategory_master`
--
ALTER TABLE `pgc_doc_subcategory_master`
  ADD UNIQUE KEY `rec_key` (`rec_key`),
  ADD UNIQUE KEY `doc_category` (`doc_category`);

--
-- Indexes for table `pgc_email_master`
--
ALTER TABLE `pgc_email_master`
  ADD PRIMARY KEY (`email_key`),
  ADD UNIQUE KEY `email_purpose` (`email_purpose`);

--
-- Indexes for table `pgc_equipment`
--
ALTER TABLE `pgc_equipment`
  ADD PRIMARY KEY (`rec_key`);

--
-- Indexes for table `pgc_field_duty`
--
ALTER TABLE `pgc_field_duty`
  ADD PRIMARY KEY (`date`);

--
-- Indexes for table `pgc_field_duty_12-2012`
--
ALTER TABLE `pgc_field_duty_12-2012`
  ADD PRIMARY KEY (`date`);

--
-- Indexes for table `pgc_field_duty_1-2012-Copy`
--
ALTER TABLE `pgc_field_duty_1-2012-Copy`
  ADD PRIMARY KEY (`date`);

--
-- Indexes for table `pgc_field_duty_2013`
--
ALTER TABLE `pgc_field_duty_2013`
  ADD PRIMARY KEY (`date`);

--
-- Indexes for table `pgc_field_duty_2013_copy`
--
ALTER TABLE `pgc_field_duty_2013_copy`
  ADD PRIMARY KEY (`date`);

--
-- Indexes for table `pgc_field_duty_2013_copytk`
--
ALTER TABLE `pgc_field_duty_2013_copytk`
  ADD PRIMARY KEY (`date`);

--
-- Indexes for table `pgc_field_duty_2014_copy`
--
ALTER TABLE `pgc_field_duty_2014_copy`
  ADD PRIMARY KEY (`date`);

--
-- Indexes for table `pgc_field_duty_2015`
--
ALTER TABLE `pgc_field_duty_2015`
  ADD PRIMARY KEY (`date`);

--
-- Indexes for table `pgc_field_duty_control`
--
ALTER TABLE `pgc_field_duty_control`
  ADD PRIMARY KEY (`fd_session`);

--
-- Indexes for table `pgc_field_duty_explode`
--
ALTER TABLE `pgc_field_duty_explode`
  ADD PRIMARY KEY (`fd_key`),
  ADD KEY `fd_date` (`fd_date`);

--
-- Indexes for table `pgc_field_duty_holidays`
--
ALTER TABLE `pgc_field_duty_holidays`
  ADD PRIMARY KEY (`holiday_name`);

--
-- Indexes for table `pgc_field_duty_selections`
--
ALTER TABLE `pgc_field_duty_selections`
  ADD UNIQUE KEY `key_check` (`key_check`);

--
-- Indexes for table `pgc_field_duty_selections(2015 copy)`
--
ALTER TABLE `pgc_field_duty_selections(2015 copy)`
  ADD UNIQUE KEY `key_check` (`key_check`);

--
-- Indexes for table `pgc_field_duty_selections_3-20`
--
ALTER TABLE `pgc_field_duty_selections_3-20`
  ADD UNIQUE KEY `key_check` (`key_check`);

--
-- Indexes for table `pgc_field_duty_selections_audit`
--
ALTER TABLE `pgc_field_duty_selections_audit`
  ADD PRIMARY KEY (`audit_key`);

--
-- Indexes for table `pgc_field_duty_selections_audit(2015 Copy)`
--
ALTER TABLE `pgc_field_duty_selections_audit(2015 Copy)`
  ADD PRIMARY KEY (`audit_key`);

--
-- Indexes for table `pgc_field_duty_selections_detail`
--
ALTER TABLE `pgc_field_duty_selections_detail`
  ADD PRIMARY KEY (`fd_key`);

--
-- Indexes for table `pgc_file_list`
--
ALTER TABLE `pgc_file_list`
  ADD UNIQUE KEY `file_name` (`doc_file_name`);

--
-- Indexes for table `pgc_flight_tables`
--
ALTER TABLE `pgc_flight_tables`
  ADD PRIMARY KEY (`hist_key`);

--
-- Indexes for table `pgc_flightlog_charges`
--
ALTER TABLE `pgc_flightlog_charges`
  ADD PRIMARY KEY (`seq`),
  ADD KEY `seq` (`seq`),
  ADD KEY `seq_2` (`seq`);

--
-- Indexes for table `pgc_flightlog_lastpilot`
--
ALTER TABLE `pgc_flightlog_lastpilot`
  ADD PRIMARY KEY (`seq`);

--
-- Indexes for table `pgc_flightrisk`
--
ALTER TABLE `pgc_flightrisk`
  ADD PRIMARY KEY (`sequence`);

--
-- Indexes for table `pgc_flightsheet`
--
ALTER TABLE `pgc_flightsheet`
  ADD PRIMARY KEY (`Key`);

--
-- Indexes for table `pgc_flightsheet_2010`
--
ALTER TABLE `pgc_flightsheet_2010`
  ADD PRIMARY KEY (`Key`);

--
-- Indexes for table `pgc_flightsheet_2011`
--
ALTER TABLE `pgc_flightsheet_2011`
  ADD PRIMARY KEY (`Key`);

--
-- Indexes for table `pgc_flightsheet_2012`
--
ALTER TABLE `pgc_flightsheet_2012`
  ADD PRIMARY KEY (`Key`);

--
-- Indexes for table `pgc_flightsheet_2013`
--
ALTER TABLE `pgc_flightsheet_2013`
  ADD PRIMARY KEY (`Key`);

--
-- Indexes for table `pgc_flightsheet_2014`
--
ALTER TABLE `pgc_flightsheet_2014`
  ADD PRIMARY KEY (`Key`);

--
-- Indexes for table `pgc_flightsheet_2014_yearend`
--
ALTER TABLE `pgc_flightsheet_2014_yearend`
  ADD PRIMARY KEY (`Key`);

--
-- Indexes for table `pgc_flightsheet_2015`
--
ALTER TABLE `pgc_flightsheet_2015`
  ADD PRIMARY KEY (`Key`);

--
-- Indexes for table `pgc_flightsheet_2015_V2`
--
ALTER TABLE `pgc_flightsheet_2015_V2`
  ADD PRIMARY KEY (`Key`);

--
-- Indexes for table `pgc_flightsheet_audit`
--
ALTER TABLE `pgc_flightsheet_audit`
  ADD PRIMARY KEY (`Key_Audit`);

--
-- Indexes for table `pgc_flightsheet_audit_2015`
--
ALTER TABLE `pgc_flightsheet_audit_2015`
  ADD PRIMARY KEY (`Key_Audit`);

--
-- Indexes for table `pgc_flightsheet_save`
--
ALTER TABLE `pgc_flightsheet_save`
  ADD PRIMARY KEY (`Key`);

--
-- Indexes for table `pgc_flightsheet_temp`
--
ALTER TABLE `pgc_flightsheet_temp`
  ADD PRIMARY KEY (`Key`);

--
-- Indexes for table `pgc_gliders`
--
ALTER TABLE `pgc_gliders`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `pgc_gliders_10_1012`
--
ALTER TABLE `pgc_gliders_10_1012`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `pgc_group_types`
--
ALTER TABLE `pgc_group_types`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `pgc_instructors`
--
ALTER TABLE `pgc_instructors`
  ADD PRIMARY KEY (`instructorID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `pgc_inventory`
--
ALTER TABLE `pgc_inventory`
  ADD PRIMARY KEY (`inv_key`);

--
-- Indexes for table `pgc_inventory_used`
--
ALTER TABLE `pgc_inventory_used`
  ADD PRIMARY KEY (`inv_used_key`),
  ADD UNIQUE KEY `inv_used_key` (`inv_used_key`);

--
-- Indexes for table `pgc_job_status`
--
ALTER TABLE `pgc_job_status`
  ADD PRIMARY KEY (`status_key`);

--
-- Indexes for table `pgc_job_volunteers`
--
ALTER TABLE `pgc_job_volunteers`
  ADD PRIMARY KEY (`volunteer_key`),
  ADD UNIQUE KEY `dup_check_key` (`dup_check_key`);

--
-- Indexes for table `pgc_jobs`
--
ALTER TABLE `pgc_jobs`
  ADD PRIMARY KEY (`job_key`);

--
-- Indexes for table `pgc_member_roster`
--
ALTER TABLE `pgc_member_roster`
  ADD PRIMARY KEY (`customer`),
  ADD KEY `mid` (`mid`);

--
-- Indexes for table `pgc_members`
--
ALTER TABLE `pgc_members`
  ADD PRIMARY KEY (`USER_ID`);

--
-- Indexes for table `pgc_members_10-2012`
--
ALTER TABLE `pgc_members_10-2012`
  ADD PRIMARY KEY (`USER_ID`);

--
-- Indexes for table `pgc_members_10_18_12`
--
ALTER TABLE `pgc_members_10_18_12`
  ADD PRIMARY KEY (`USER_ID`);

--
-- Indexes for table `pgc_members_113014`
--
ALTER TABLE `pgc_members_113014`
  ADD PRIMARY KEY (`USER_ID`);

--
-- Indexes for table `pgc_members_12_08_14`
--
ALTER TABLE `pgc_members_12_08_14`
  ADD PRIMARY KEY (`USER_ID`);

--
-- Indexes for table `pgc_pilot_ratings`
--
ALTER TABLE `pgc_pilot_ratings`
  ADD PRIMARY KEY (`rating_id`),
  ADD UNIQUE KEY `pilot_name` (`pilot_name`,`pgc_rating`);

--
-- Indexes for table `pgc_pilot_signoffs`
--
ALTER TABLE `pgc_pilot_signoffs`
  ADD PRIMARY KEY (`signoffID`),
  ADD UNIQUE KEY `pilot_name` (`pilot_name`,`signoff_type`);

--
-- Indexes for table `pgc_pilot_signoffs_1_6_2012`
--
ALTER TABLE `pgc_pilot_signoffs_1_6_2012`
  ADD PRIMARY KEY (`signoffID`),
  ADD UNIQUE KEY `pilot_name` (`pilot_name`,`signoff_type`);

--
-- Indexes for table `pgc_pilot_signoffs_2012`
--
ALTER TABLE `pgc_pilot_signoffs_2012`
  ADD PRIMARY KEY (`signoffID`),
  ADD UNIQUE KEY `pilot_name` (`pilot_name`,`signoff_type`);

--
-- Indexes for table `pgc_pilot_signoffs_82012`
--
ALTER TABLE `pgc_pilot_signoffs_82012`
  ADD PRIMARY KEY (`signoffID`),
  ADD UNIQUE KEY `pilot_name` (`pilot_name`,`signoff_type`);

--
-- Indexes for table `pgc_pilot_signoffs_bak`
--
ALTER TABLE `pgc_pilot_signoffs_bak`
  ADD PRIMARY KEY (`signoffID`),
  ADD UNIQUE KEY `pilot_name` (`pilot_name`,`signoff_type`);

--
-- Indexes for table `pgc_pilots`
--
ALTER TABLE `pgc_pilots`
  ADD PRIMARY KEY (`pilot_ID`),
  ADD UNIQUE KEY `pilot_name` (`pilot_name`);

--
-- Indexes for table `pgc_pirep`
--
ALTER TABLE `pgc_pirep`
  ADD PRIMARY KEY (`pirep_key`);

--
-- Indexes for table `pgc_ratings_list`
--
ALTER TABLE `pgc_ratings_list`
  ADD PRIMARY KEY (`rating_id`);

--
-- Indexes for table `pgc_request`
--
ALTER TABLE `pgc_request`
  ADD PRIMARY KEY (`request_key`);

--
-- Indexes for table `pgc_request_20112`
--
ALTER TABLE `pgc_request_20112`
  ADD PRIMARY KEY (`request_key`);

--
-- Indexes for table `pgc_request_2012`
--
ALTER TABLE `pgc_request_2012`
  ADD PRIMARY KEY (`request_key`);

--
-- Indexes for table `pgc_request_2013`
--
ALTER TABLE `pgc_request_2013`
  ADD PRIMARY KEY (`request_key`);

--
-- Indexes for table `pgc_signoff_nofly`
--
ALTER TABLE `pgc_signoff_nofly`
  ADD PRIMARY KEY (`pilot_name`);

--
-- Indexes for table `pgc_signoff_roles`
--
ALTER TABLE `pgc_signoff_roles`
  ADD PRIMARY KEY (`signoffID`);

--
-- Indexes for table `pgc_signoff_types`
--
ALTER TABLE `pgc_signoff_types`
  ADD PRIMARY KEY (`signoffID`);

--
-- Indexes for table `pgc_squawk`
--
ALTER TABLE `pgc_squawk`
  ADD PRIMARY KEY (`sq_key`);

--
-- Indexes for table `pgc_squawk_work`
--
ALTER TABLE `pgc_squawk_work`
  ADD PRIMARY KEY (`sq_work_key`);

--
-- Indexes for table `relationship`
--
ALTER TABLE `relationship`
  ADD PRIMARY KEY (`seq`);

--
-- Indexes for table `reminders`
--
ALTER TABLE `reminders`
  ADD PRIMARY KEY (`reminderid`),
  ADD KEY `reminders_time` (`reminder_time`),
  ADD KEY `reminders_memberid` (`memberid`),
  ADD KEY `reminders_resid` (`resid`);

--
-- Indexes for table `reservation_resources`
--
ALTER TABLE `reservation_resources`
  ADD PRIMARY KEY (`resid`,`resourceid`),
  ADD KEY `resresources_resid` (`resid`),
  ADD KEY `resresources_resourceid` (`resourceid`),
  ADD KEY `resresources_owner` (`owner`);

--
-- Indexes for table `reservation_users`
--
ALTER TABLE `reservation_users`
  ADD PRIMARY KEY (`resid`,`memberid`),
  ADD KEY `resusers_resid` (`resid`),
  ADD KEY `resusers_memberid` (`memberid`),
  ADD KEY `resusers_owner` (`owner`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`resid`),
  ADD KEY `res_machid` (`machid`),
  ADD KEY `res_scheduleid` (`scheduleid`),
  ADD KEY `reservations_startdate` (`start_date`),
  ADD KEY `reservations_enddate` (`end_date`),
  ADD KEY `res_startTime` (`starttime`),
  ADD KEY `res_endTime` (`endtime`),
  ADD KEY `res_created` (`created`),
  ADD KEY `res_modified` (`modified`),
  ADD KEY `res_parentid` (`parentid`),
  ADD KEY `res_isblackout` (`is_blackout`),
  ADD KEY `reservations_pending` (`is_pending`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`machid`),
  ADD KEY `rs_scheduleid` (`scheduleid`),
  ADD KEY `rs_name` (`name`),
  ADD KEY `rs_status` (`status`);

--
-- Indexes for table `schedule_permission`
--
ALTER TABLE `schedule_permission`
  ADD PRIMARY KEY (`scheduleid`,`memberid`),
  ADD KEY `sp_scheduleid` (`scheduleid`),
  ADD KEY `sp_memberid` (`memberid`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`scheduleid`),
  ADD KEY `sh_hidden` (`ishidden`),
  ADD KEY `sh_perms` (`usepermissions`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`groupid`,`memberid`),
  ADD KEY `usergroups_groupid` (`groupid`),
  ADD KEY `usergroups_memberid` (`memberid`),
  ADD KEY `usergroups_is_admin` (`is_admin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pgc_access_app_groups`
--
ALTER TABLE `pgc_access_app_groups`
  MODIFY `rec_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_access_apps`
--
ALTER TABLE `pgc_access_apps`
  MODIFY `app_key` smallint(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_access_functionlist`
--
ALTER TABLE `pgc_access_functionlist`
  MODIFY `rec_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_access_grouplist`
--
ALTER TABLE `pgc_access_grouplist`
  MODIFY `rec_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_access_member_groups`
--
ALTER TABLE `pgc_access_member_groups`
  MODIFY `rec_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_calendar`
--
ALTER TABLE `pgc_calendar`
  MODIFY `EventID` int(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_cfig_dates`
--
ALTER TABLE `pgc_cfig_dates`
  MODIFY `rec_key` smallint(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_cfig_vacation`
--
ALTER TABLE `pgc_cfig_vacation`
  MODIFY `vac_key` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_cfig_vacation_12-2012`
--
ALTER TABLE `pgc_cfig_vacation_12-2012`
  MODIFY `vac_key` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_cfig_vacation_copy`
--
ALTER TABLE `pgc_cfig_vacation_copy`
  MODIFY `vac_key` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_class`
--
ALTER TABLE `pgc_class`
  MODIFY `rec_index` int(5) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_doc_category_master`
--
ALTER TABLE `pgc_doc_category_master`
  MODIFY `rec_key` smallint(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_doc_lib_list`
--
ALTER TABLE `pgc_doc_lib_list`
  MODIFY `rec_id` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_doc_subcategory_master`
--
ALTER TABLE `pgc_doc_subcategory_master`
  MODIFY `rec_key` smallint(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_email_master`
--
ALTER TABLE `pgc_email_master`
  MODIFY `email_key` tinyint(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_equipment`
--
ALTER TABLE `pgc_equipment`
  MODIFY `rec_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_field_duty_explode`
--
ALTER TABLE `pgc_field_duty_explode`
  MODIFY `fd_key` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_field_duty_selections_audit`
--
ALTER TABLE `pgc_field_duty_selections_audit`
  MODIFY `audit_key` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_field_duty_selections_audit(2015 Copy)`
--
ALTER TABLE `pgc_field_duty_selections_audit(2015 Copy)`
  MODIFY `audit_key` int(8) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_field_duty_selections_detail`
--
ALTER TABLE `pgc_field_duty_selections_detail`
  MODIFY `fd_key` smallint(12) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_flight_tables`
--
ALTER TABLE `pgc_flight_tables`
  MODIFY `hist_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_flightlog_lastpilot`
--
ALTER TABLE `pgc_flightlog_lastpilot`
  MODIFY `seq` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_flightsheet`
--
ALTER TABLE `pgc_flightsheet`
  MODIFY `Key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_flightsheet_2010`
--
ALTER TABLE `pgc_flightsheet_2010`
  MODIFY `Key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_flightsheet_2011`
--
ALTER TABLE `pgc_flightsheet_2011`
  MODIFY `Key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_flightsheet_2012`
--
ALTER TABLE `pgc_flightsheet_2012`
  MODIFY `Key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_flightsheet_2013`
--
ALTER TABLE `pgc_flightsheet_2013`
  MODIFY `Key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_flightsheet_2014`
--
ALTER TABLE `pgc_flightsheet_2014`
  MODIFY `Key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_flightsheet_2014_yearend`
--
ALTER TABLE `pgc_flightsheet_2014_yearend`
  MODIFY `Key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_flightsheet_2015`
--
ALTER TABLE `pgc_flightsheet_2015`
  MODIFY `Key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_flightsheet_2015_V2`
--
ALTER TABLE `pgc_flightsheet_2015_V2`
  MODIFY `Key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_flightsheet_audit`
--
ALTER TABLE `pgc_flightsheet_audit`
  MODIFY `Key_Audit` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_flightsheet_audit_2015`
--
ALTER TABLE `pgc_flightsheet_audit_2015`
  MODIFY `Key_Audit` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_flightsheet_save`
--
ALTER TABLE `pgc_flightsheet_save`
  MODIFY `Key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_flightsheet_temp`
--
ALTER TABLE `pgc_flightsheet_temp`
  MODIFY `Key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_gliders`
--
ALTER TABLE `pgc_gliders`
  MODIFY `key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_gliders_10_1012`
--
ALTER TABLE `pgc_gliders_10_1012`
  MODIFY `key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_group_types`
--
ALTER TABLE `pgc_group_types`
  MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_instructors`
--
ALTER TABLE `pgc_instructors`
  MODIFY `instructorID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_inventory`
--
ALTER TABLE `pgc_inventory`
  MODIFY `inv_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_inventory_used`
--
ALTER TABLE `pgc_inventory_used`
  MODIFY `inv_used_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_job_status`
--
ALTER TABLE `pgc_job_status`
  MODIFY `status_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_job_volunteers`
--
ALTER TABLE `pgc_job_volunteers`
  MODIFY `volunteer_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_jobs`
--
ALTER TABLE `pgc_jobs`
  MODIFY `job_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_member_roster`
--
ALTER TABLE `pgc_member_roster`
  MODIFY `mid` smallint(6) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_pilot_ratings`
--
ALTER TABLE `pgc_pilot_ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_pilot_signoffs`
--
ALTER TABLE `pgc_pilot_signoffs`
  MODIFY `signoffID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_pilot_signoffs_1_6_2012`
--
ALTER TABLE `pgc_pilot_signoffs_1_6_2012`
  MODIFY `signoffID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_pilot_signoffs_2012`
--
ALTER TABLE `pgc_pilot_signoffs_2012`
  MODIFY `signoffID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_pilot_signoffs_82012`
--
ALTER TABLE `pgc_pilot_signoffs_82012`
  MODIFY `signoffID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_pilot_signoffs_bak`
--
ALTER TABLE `pgc_pilot_signoffs_bak`
  MODIFY `signoffID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_pilots`
--
ALTER TABLE `pgc_pilots`
  MODIFY `pilot_ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_pirep`
--
ALTER TABLE `pgc_pirep`
  MODIFY `pirep_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_ratings_list`
--
ALTER TABLE `pgc_ratings_list`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_request`
--
ALTER TABLE `pgc_request`
  MODIFY `request_key` smallint(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_request_20112`
--
ALTER TABLE `pgc_request_20112`
  MODIFY `request_key` smallint(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_request_2012`
--
ALTER TABLE `pgc_request_2012`
  MODIFY `request_key` smallint(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_request_2013`
--
ALTER TABLE `pgc_request_2013`
  MODIFY `request_key` smallint(9) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_signoff_roles`
--
ALTER TABLE `pgc_signoff_roles`
  MODIFY `signoffID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_signoff_types`
--
ALTER TABLE `pgc_signoff_types`
  MODIFY `signoffID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_squawk`
--
ALTER TABLE `pgc_squawk`
  MODIFY `sq_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pgc_squawk_work`
--
ALTER TABLE `pgc_squawk_work`
  MODIFY `sq_work_key` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `relationship`
--
ALTER TABLE `relationship`
  MODIFY `seq` int(12) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
