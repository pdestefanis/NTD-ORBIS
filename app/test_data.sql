-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 07, 2012 at 10:04 AM
-- Server version: 5.5.9
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

use 'ntd';

TRUNCATE TABLE `approvals`;

-- Dump approvals
INSERT INTO `approvals` VALUES(38, NULL, 1, '2012-07-22 21:20:27');
INSERT INTO `approvals` VALUES(39, NULL, 1, '2012-07-22 21:37:03');
INSERT INTO `approvals` VALUES(40, NULL, 1, '2012-07-23 09:54:04');

-- wipe approvals_stats
TRUNCATE TABLE `approvals_stats`;

-- insert approvals_stats
INSERT INTO `approvals_stats` VALUES(1, 38, 5);
INSERT INTO `approvals_stats` VALUES(2, 39, 2);
INSERT INTO `approvals_stats` VALUES(3, 39, 1);
INSERT INTO `approvals_stats` VALUES(4, 40, 6);


-- wipe locations
TRUNCATE TABLE `locations`;

-- insert locations
INSERT INTO `locations` VALUES(2, 'Gulu Hospital', 'GLH', '2.78', '32.3', 0, 11);
INSERT INTO `locations` VALUES(6, 'Test Facility 1', '124', '0.424444', '33.204167', 0, 0);
INSERT INTO `locations` VALUES(9, 'Test Facility 2', '121', '1.175711', '33.148029', 0, 6);
INSERT INTO `locations` VALUES(11, 'Test Facility 3', '122', '2.234444', '32.385', 0, 6);
INSERT INTO `locations` VALUES(28, 'Test Facility 4', '125', '0.98', '34.33', 0, 11);
INSERT INTO `locations` VALUES(35, 'Dad location', 'la', '-20.000000', '-29.000000', 0, 0);
INSERT INTO `locations` VALUES(36, 'Son location', 'son', '-1.00', '-1.00', 0, 35);
INSERT INTO `locations` VALUES(37, 'Sybling', 'syb', '-2.00', '-2.00', 0, 35);
INSERT INTO `locations` VALUES(38, 'Daughter location', 'dau', '-3.00', '-3.00', 0, 35);
INSERT INTO `locations` VALUES(39, 'Grandson', 'gs', '-4.00', '-4.00', 0, 38);
INSERT INTO `locations` VALUES(40, 'Granddaughter', 'gd', '-5.00', '-5.00', 0, 38);

-- wipe stats
TRUNCATE TABLE `stats`;

-- Insert stats
INSERT INTO `stats` VALUES(1, 20, '2012-07-19 17:06:57', '2012-07-19 17:06:57', 18, NULL, NULL, 35, 1, 20, 1);
INSERT INTO `stats` VALUES(2, 5, '2012-07-19 17:21:05', '2012-07-19 17:21:05', 18, NULL, NULL, 35, 2, 15, 1);
INSERT INTO `stats` VALUES(3, 500, '2012-07-19 17:55:14', '2012-07-19 17:55:14', 22, NULL, NULL, 6, 1, 500, 9);
INSERT INTO `stats` VALUES(4, 100, '2012-07-19 17:55:31', '2012-07-19 17:55:31', 22, NULL, NULL, 6, 2, 400, 9);
INSERT INTO `stats` VALUES(5, 3, '2012-07-19 18:04:28', '2012-07-19 18:04:28', 18, NULL, NULL, 37, 1, 3, 10);
INSERT INTO `stats` VALUES(6, 10, '2012-07-22 21:39:18', '2012-07-22 21:39:18', 18, NULL, NULL, 38, 1, 10, 1);
INSERT INTO `stats` VALUES(7, 100, '2012-07-23 09:56:01', '2012-07-23 09:56:01', 18, NULL, NULL, 35, 1, 115, 1);
INSERT INTO `stats` VALUES(8, 50, '2012-08-07 08:52:08', '2012-08-07 08:52:08', 22, NULL, NULL, 37, 1, 50, 9);
INSERT INTO `stats` VALUES(9, 1, '2012-08-07 08:52:22', '2012-08-07 08:52:22', 22, NULL, NULL, 37, 2, 49, 9);
INSERT INTO `stats` VALUES(10, 5, '2012-08-07 08:52:34', '2012-08-07 08:52:34', 18, NULL, NULL, 37, 1, 8, 9);
INSERT INTO `stats` VALUES(11, 10, '2012-08-07 08:54:21', '2012-08-07 08:54:21', 18, NULL, NULL, 39, 1, 10, 1);
INSERT INTO `stats` VALUES(12, 4, '2012-08-07 08:54:50', '2012-08-07 08:54:50', 18, NULL, NULL, 39, 2, 6, 1);


-- wipe users
TRUNCATE TABLE `users`;

-- insert users
INSERT INTO `users` VALUES(1, 'Administrator', 'admin', 'f8b41181b25c2f23b749e2bc01bf7179c29810a3', 1, '2010-08-29 23:11:29', '2012-08-07 08:55:25', 35, 0, NULL, 1);
INSERT INTO `users` VALUES(3, 'son_user', 'son_user', 'f8b41181b25c2f23b749e2bc01bf7179c29810a3', 3, '2010-08-29 23:11:57', '2012-07-22 21:34:02', 36, 0, NULL, 1);
INSERT INTO `users` VALUES(9, 'mod', 'mod', 'f8b41181b25c2f23b749e2bc01bf7179c29810a3', 1, '2012-01-05 16:29:06', '2012-08-07 08:51:34', 37, 1, NULL, 1);
INSERT INTO `users` VALUES(10, 'sybling_user', 'sybling_user', 'f8b41181b25c2f23b749e2bc01bf7179c29810a3', 2, '2012-07-19 18:03:59', '2012-07-22 21:33:43', 37, 0, NULL, 1);

