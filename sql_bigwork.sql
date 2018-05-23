/*
 Navicat Premium Data Transfer

 Source Server         : MySql
 Source Server Type    : MySQL
 Source Server Version : 50722
 Source Host           : localhost:3306
 Source Schema         : sql_bigwork

 Target Server Type    : MySQL
 Target Server Version : 50722
 File Encoding         : 65001

 Date: 23/05/2018 15:05:16
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for dormitories
-- ----------------------------
DROP TABLE IF EXISTS `dormitories`;
CREATE TABLE `dormitories` (
  `d_id` int(11) NOT NULL AUTO_INCREMENT,
  `d_name` char(20) NOT NULL,
  `d_bed_num` int(11) NOT NULL,
  `d_price` int(20) NOT NULL,
  `d_stu_num_now` int(11) NOT NULL,
  `db_id` int(11) NOT NULL,
  PRIMARY KEY (`d_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dormitories
-- ----------------------------
BEGIN;
INSERT INTO `dormitories` VALUES (1, '101', 4, 5000, 3, 1);
INSERT INTO `dormitories` VALUES (2, '102', 4, 5000, 2, 1);
INSERT INTO `dormitories` VALUES (3, '103', 4, 5000, 4, 1);
INSERT INTO `dormitories` VALUES (4, '101', 4, 5000, 1, 2);
INSERT INTO `dormitories` VALUES (5, '101', 4, 5000, 3, 4);
COMMIT;

-- ----------------------------
-- Table structure for dormitory_builds
-- ----------------------------
DROP TABLE IF EXISTS `dormitory_builds`;
CREATE TABLE `dormitory_builds` (
  `db_id` int(11) NOT NULL AUTO_INCREMENT,
  `db_name` char(20) NOT NULL,
  PRIMARY KEY (`db_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dormitory_builds
-- ----------------------------
BEGIN;
INSERT INTO `dormitory_builds` VALUES (1, 'C1');
INSERT INTO `dormitory_builds` VALUES (2, 'C2');
INSERT INTO `dormitory_builds` VALUES (3, 'C3');
INSERT INTO `dormitory_builds` VALUES (4, 'C4');
INSERT INTO `dormitory_builds` VALUES (5, 'C5');
INSERT INTO `dormitory_builds` VALUES (6, 'C6');
INSERT INTO `dormitory_builds` VALUES (7, 'C7');
INSERT INTO `dormitory_builds` VALUES (8, 'C8');
INSERT INTO `dormitory_builds` VALUES (9, 'C9');
INSERT INTO `dormitory_builds` VALUES (10, 'C10');
INSERT INTO `dormitory_builds` VALUES (11, 'C11');
INSERT INTO `dormitory_builds` VALUES (12, 'C12');
INSERT INTO `dormitory_builds` VALUES (13, 'C13');
INSERT INTO `dormitory_builds` VALUES (14, 'C14');
INSERT INTO `dormitory_builds` VALUES (15, 'C15');
INSERT INTO `dormitory_builds` VALUES (16, 'C16');
INSERT INTO `dormitory_builds` VALUES (17, 'C17');
INSERT INTO `dormitory_builds` VALUES (18, 'C18');
INSERT INTO `dormitory_builds` VALUES (19, 'C19');
INSERT INTO `dormitory_builds` VALUES (20, 'C20');
COMMIT;

-- ----------------------------
-- Table structure for students
-- ----------------------------
DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `s_no` int(11) NOT NULL,
  `s_sex` char(20) NOT NULL DEFAULT '男',
  `s_age` int(11) DEFAULT NULL,
  `s_department` char(100) DEFAULT NULL,
  `s_grade` char(20) DEFAULT NULL,
  `s_phone` char(20) DEFAULT NULL,
  `d_id` int(11) NOT NULL,
  `s_bed` int(11) DEFAULT NULL,
  PRIMARY KEY (`s_id`),
  KEY `d_id` (`d_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of students
-- ----------------------------
BEGIN;
INSERT INTO `students` VALUES (1, 20180201, '男', 12, '计算机工程院', '大二', '13203662323', 1, 1);
INSERT INTO `students` VALUES (2, 20180202, '男', 10, '汽车工程院', '大二', '13203662323', 3, 1);
INSERT INTO `students` VALUES (3, 20180203, '男', 11, '汽车工程院', '大一', '13203662323', 3, 1);
INSERT INTO `students` VALUES (4, 20180204, '男', 17, '汽车工程院', '大一', '13203662323', 3, 1);
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_no` int(11) NOT NULL,
  `u_name` char(20) NOT NULL,
  `u_password` char(100) NOT NULL,
  `u_permission` int(11) DEFAULT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES (1, 20180101, 'superadmin1', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (2, 20180102, 'superadmin2', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (3, 20180103, 'superadmin3', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (4, 20180201, '张三', '21232F297A57A5A743894A0E4A801FC3', -1);
INSERT INTO `users` VALUES (5, 20180202, '小明', '21232F297A57A5A743894A0E4A801FC3', -1);
INSERT INTO `users` VALUES (6, 20180203, '小东', '21232F297A57A5A743894A0E4A801FC3', -1);
INSERT INTO `users` VALUES (7, 20180204, '小龙', '81dc9bdb52d04dc20036dbd8313ed055', -1);
INSERT INTO `users` VALUES (8, 20180301, '张阿姨', '21232F297A57A5A743894A0E4A801FC3', 1);
INSERT INTO `users` VALUES (9, 20180302, '李叔叔', '21232F297A57A5A743894A0E4A801FC3', 1);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
