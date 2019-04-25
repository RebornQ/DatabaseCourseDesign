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

 Date: 31/05/2018 02:02:39
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
  `d_stu_num_now` int(11) NOT NULL,
  `db_id` int(11) NOT NULL,
  PRIMARY KEY (`d_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dormitories
-- ----------------------------
BEGIN;
INSERT INTO `dormitories` VALUES (1, '101', 4, 4, 1);
INSERT INTO `dormitories` VALUES (2, '102', 4, 2, 1);
INSERT INTO `dormitories` VALUES (3, '103', 4, 2, 1);
INSERT INTO `dormitories` VALUES (4, '101', 4, 2, 2);
INSERT INTO `dormitories` VALUES (5, '101', 4, 0, 4);
INSERT INTO `dormitories` VALUES (6, '102', 4, 2, 2);
INSERT INTO `dormitories` VALUES (7, '104', 4, 2, 1);
INSERT INTO `dormitories` VALUES (8, '101', 4, 0, 5);
INSERT INTO `dormitories` VALUES (9, '105', 4, 0, 1);
INSERT INTO `dormitories` VALUES (10, '101', 4, 2, 3);
COMMIT;

-- ----------------------------
-- Table structure for dormitory_builds
-- ----------------------------
DROP TABLE IF EXISTS `dormitory_builds`;
CREATE TABLE `dormitory_builds` (
  `db_id` int(11) NOT NULL AUTO_INCREMENT,
  `db_name` char(20) NOT NULL,
  `d_price` int(20) NOT NULL,
  PRIMARY KEY (`db_id`),
  UNIQUE KEY `db_name` (`db_name`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dormitory_builds
-- ----------------------------
BEGIN;
INSERT INTO `dormitory_builds` VALUES (1, 'C1', 2500);
INSERT INTO `dormitory_builds` VALUES (2, 'C2', 2500);
INSERT INTO `dormitory_builds` VALUES (3, 'C3', 2500);
INSERT INTO `dormitory_builds` VALUES (4, 'C4', 2500);
INSERT INTO `dormitory_builds` VALUES (5, 'C5', 2500);
INSERT INTO `dormitory_builds` VALUES (6, 'C6', 2500);
INSERT INTO `dormitory_builds` VALUES (7, 'C7', 2500);
INSERT INTO `dormitory_builds` VALUES (8, 'C8', 2500);
INSERT INTO `dormitory_builds` VALUES (9, 'C9', 2500);
INSERT INTO `dormitory_builds` VALUES (10, 'C10', 2500);
INSERT INTO `dormitory_builds` VALUES (11, 'C11', 2500);
INSERT INTO `dormitory_builds` VALUES (12, 'C12', 2500);
INSERT INTO `dormitory_builds` VALUES (13, 'C13', 2500);
INSERT INTO `dormitory_builds` VALUES (14, 'C14', 2500);
INSERT INTO `dormitory_builds` VALUES (15, 'C15', 2500);
INSERT INTO `dormitory_builds` VALUES (16, 'C16', 2500);
INSERT INTO `dormitory_builds` VALUES (17, 'C17', 2500);
INSERT INTO `dormitory_builds` VALUES (18, 'C18', 2500);
INSERT INTO `dormitory_builds` VALUES (19, 'C19', 2500);
INSERT INTO `dormitory_builds` VALUES (20, 'C20', 2500);
INSERT INTO `dormitory_builds` VALUES (21, 'C21', 5000);
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
  UNIQUE KEY `s_no` (`s_no`),
  KEY `d_id` (`d_id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of students
-- ----------------------------
BEGIN;
INSERT INTO `students` VALUES (7, 20180206, '女', 18, '计算机工程学院', '大一', '13211118749', 7, 2);
INSERT INTO `students` VALUES (8, 20180207, '男', 18, '机械工程学院', '大二', '13211118749', 4, 1);
INSERT INTO `students` VALUES (9, 20180208, '男', 18, '机械工程学院', '大二', '13211118749', 7, 4);
INSERT INTO `students` VALUES (10, 20180209, '男', 16, '机械工程学院', '大三', '13211118749', 1, 2);
INSERT INTO `students` VALUES (17, 20180218, '男', 10, '机械工程学院', '大二', '1518713219', 1, 4);
INSERT INTO `students` VALUES (18, 20180210, '男', 19, '信息与通信工程学院', '大一', '13910246102', 1, 1);
INSERT INTO `students` VALUES (19, 20180211, '女', 17, '材料科学与工程学院', '大一', '13910246102', 1, 3);
INSERT INTO `students` VALUES (20, 20180212, '男', 20, '材料科学与工程学院', '大三', '13910246102', 2, 3);
INSERT INTO `students` VALUES (21, 20180213, '男', 21, '材料科学与工程学院', '大二', '13910246102', 2, 4);
INSERT INTO `students` VALUES (22, 20180214, '男', 21, '电气工程学院', '大二', '13910246102', 3, 1);
INSERT INTO `students` VALUES (23, 20180215, '男', 23, '电气工程学院', '大四', '13910246102', 4, 4);
INSERT INTO `students` VALUES (24, 20180216, '男', 24, '机械工程学院', '大三', '13910246102', 6, 3);
INSERT INTO `students` VALUES (25, 20180217, '男', 17, '机械工程学院', '大二', '13910246102', 3, 4);
INSERT INTO `students` VALUES (26, 20180201, '男', 18, '机械工程学院', '大一', '13910246102', 6, 2);
INSERT INTO `students` VALUES (27, 20180202, '男', 19, '计算机工程学院', '大二', '13910246102', 10, 1);
INSERT INTO `students` VALUES (31, 20180219, '男', 24, '机械工程学院', '大一', '13910246102', 10, 3);
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
  PRIMARY KEY (`u_id`),
  UNIQUE KEY `u_no` (`u_no`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES (1, 20180101, 'superadmin1', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (2, 20180102, 'superadmin2', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (3, 20180103, 'superadmin3', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (8, 20180301, '宋阿姨', '21232f297a57a5a743894a0e4a801fc3', 1);
INSERT INTO `users` VALUES (9, 20180302, '李叔叔', '21232f297a57a5a743894a0e4a801fc3', 1);
INSERT INTO `users` VALUES (13, 20180104, 'superadmin4', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (11, 20180105, 'superadmin5', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (12, 20180106, 'superadmin6', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (14, 20180107, 'superadmin7', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (15, 20180108, 'superadmin8', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (16, 20180109, 'superadmin9', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (17, 20180110, 'superadmin10', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (18, 20180111, 'superadmin11', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (19, 20180112, 'superadmin12', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (20, 20180113, 'superadmin13', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (21, 20180114, 'superadmin14', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (22, 20180115, 'superadmin15', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (23, 20180116, 'superadmin16', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (24, 20180117, 'superadmin17', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (25, 20180118, 'superadmin18', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (26, 20180119, 'superadmin19', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (27, 20180120, 'superadmin20', '21232f297a57a5a743894a0e4a801fc3', 0);
INSERT INTO `users` VALUES (32, 20180206, '小花', '21232f297a57a5a743894a0e4a801fc3', -1);
INSERT INTO `users` VALUES (33, 20180207, '小李', '21232f297a57a5a743894a0e4a801fc3', -1);
INSERT INTO `users` VALUES (34, 20180208, '小硐', '21232f297a57a5a743894a0e4a801fc3', -1);
INSERT INTO `users` VALUES (35, 20180209, '小利', '21232f297a57a5a743894a0e4a801fc3', -1);
INSERT INTO `users` VALUES (45, 20180218, '小烈', '21232f297a57a5a743894a0e4a801fc3', -1);
INSERT INTO `users` VALUES (46, 20180210, '小虾', '21232f297a57a5a743894a0e4a801fc3', -1);
INSERT INTO `users` VALUES (47, 20180211, '小溪', '21232f297a57a5a743894a0e4a801fc3', -1);
INSERT INTO `users` VALUES (48, 20180212, '小吴', '21232f297a57a5a743894a0e4a801fc3', -1);
INSERT INTO `users` VALUES (49, 20180213, '小徐', '21232f297a57a5a743894a0e4a801fc3', -1);
INSERT INTO `users` VALUES (50, 20180214, '小龙', '21232f297a57a5a743894a0e4a801fc3', -1);
INSERT INTO `users` VALUES (51, 20180215, '小东', '21232f297a57a5a743894a0e4a801fc3', -1);
INSERT INTO `users` VALUES (52, 20180216, '小齐', '21232f297a57a5a743894a0e4a801fc3', -1);
INSERT INTO `users` VALUES (53, 20180217, '小飞', '21232f297a57a5a743894a0e4a801fc3', -1);
INSERT INTO `users` VALUES (54, 20180201, '小天', '21232f297a57a5a743894a0e4a801fc3', -1);
INSERT INTO `users` VALUES (55, 20180202, '小雷', '21232f297a57a5a743894a0e4a801fc3', -1);
INSERT INTO `users` VALUES (59, 20180219, '小蟹', '21232f297a57a5a743894a0e4a801fc3', -1);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
