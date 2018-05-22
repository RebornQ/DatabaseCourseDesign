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

 Date: 22/05/2018 13:53:56
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for students
-- ----------------------------
DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `s_no` int(11) NOT NULL,
  `s_name` char(20) NOT NULL,
  `s_sex` char(20) NOT NULL DEFAULT '男',
  `s_age` int(11) DEFAULT NULL,
  `s_department` char(100) DEFAULT NULL,
  `s_grade` char(20) DEFAULT NULL,
  `s_phone` char(20) DEFAULT NULL,
  `s_bed` int(11) DEFAULT NULL,
  `s_password` char(100) NOT NULL,
  `s_permission` int(11) NOT NULL DEFAULT '-1',
  `d_id` int(11) NOT NULL,
  PRIMARY KEY (`s_id`),
  KEY `d_id` (`d_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of students
-- ----------------------------
BEGIN;
INSERT INTO `students` VALUES (1, 20180201, '张三', '男', 12, '计算机工程院', '大二', '13203662323', 1, '21232F297A57A5A743894A0E4A801FC3', -1, 101);
INSERT INTO `students` VALUES (2, 20180202, '小明', '男', 10, '汽车工程院', '大二', '13203662323', 1, '21232F297A57A5A743894A0E4A801FC3', -1, 101);
INSERT INTO `students` VALUES (3, 20180203, '小东', '男', 11, '汽车工程院', '大一', '13203662323', 1, '21232F297A57A5A743894A0E4A801FC3', -1, 101);
INSERT INTO `students` VALUES (4, 20180204, '小马', '男', 11, '汽车工程院', '大一', '13203662323', 1, '21232F297A57A5A743894A0E4A801FC3', -1, 101);
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES (1, 20180101, 'superadmin1', '21232F297A57A5A743894A0E4A801FC3', 0);
INSERT INTO `users` VALUES (2, 20180102, 'superadmin2', '21232F297A57A5A743894A0E4A801FC3', 0);
INSERT INTO `users` VALUES (3, 20180103, 'superadmin3', '21232F297A57A5A743894A0E4A801FC3', 0);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
