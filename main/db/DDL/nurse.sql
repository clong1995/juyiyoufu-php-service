/*
 Navicat Premium Data Transfer

 Source Server         : nurse
 Source Server Type    : MySQL
 Source Server Version : 100034
 Source Host           : 127.0.0.1:3306
 Source Schema         : nurse

 Target Server Type    : MySQL
 Target Server Version : 100034
 File Encoding         : 65001

 Date: 03/07/2018 02:17:54
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id` smallint(5) UNSIGNED NOT NULL,
  `password` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `unionid` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '微信',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for admin_right
-- ----------------------------
DROP TABLE IF EXISTS `admin_right`;
CREATE TABLE `admin_right`  (
  `id` tinyint(2) UNSIGNED NOT NULL,
  `name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for admin_right_relation
-- ----------------------------
DROP TABLE IF EXISTS `admin_right_relation`;
CREATE TABLE `admin_right_relation`  (
  `admin_id` smallint(5) UNSIGNED NOT NULL,
  `right_id` tinyint(2) UNSIGNED NOT NULL,
  INDEX `adminid`(`admin_id`) USING BTREE,
  INDEX `right_id`(`right_id`) USING BTREE,
  CONSTRAINT `adminid` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `right_id` FOREIGN KEY (`right_id`) REFERENCES `admin_right` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for areas
-- ----------------------------
DROP TABLE IF EXISTS `areas`;
CREATE TABLE `areas`  (
  `areaid` int(6) UNSIGNED NOT NULL,
  `area` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cityid` int(6) UNSIGNED NOT NULL,
  PRIMARY KEY (`areaid`) USING BTREE,
  INDEX `areas_cities`(`cityid`) USING BTREE,
  CONSTRAINT `areas_cities` FOREIGN KEY (`cityid`) REFERENCES `cities` (`cityid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '行政区域县区信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for case
-- ----------------------------
DROP TABLE IF EXISTS `case`;
CREATE TABLE `case`  (
  `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for case_nurse_relation
-- ----------------------------
DROP TABLE IF EXISTS `case_nurse_relation`;
CREATE TABLE `case_nurse_relation`  (
  `case_id` tinyint(2) UNSIGNED NOT NULL,
  `nurse_id` smallint(5) UNSIGNED NOT NULL,
  INDEX `caseid`(`case_id`) USING BTREE,
  INDEX `nusercaseid`(`nurse_id`) USING BTREE,
  CONSTRAINT `caseid` FOREIGN KEY (`case_id`) REFERENCES `case` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nusercaseid` FOREIGN KEY (`nurse_id`) REFERENCES `nurse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`  (
  `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名称',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for cities
-- ----------------------------
DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities`  (
  `cityid` int(6) UNSIGNED NOT NULL,
  `city` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `provinceid` int(6) UNSIGNED NOT NULL,
  PRIMARY KEY (`cityid`) USING BTREE,
  INDEX `cities_provinces`(`provinceid`) USING BTREE,
  CONSTRAINT `cities_provinces` FOREIGN KEY (`provinceid`) REFERENCES `provinces` (`provinceid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '行政区域地州市信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for company
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '公司id',
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '第二id',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '密码',
  `unionid` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '微信id',
  PRIMARY KEY (`id`, `phone`) USING BTREE,
  INDEX `id`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for company_info
-- ----------------------------
DROP TABLE IF EXISTS `company_info`;
CREATE TABLE `company_info`  (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'id',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '公司名称',
  `logo` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'log',
  `province` int(6) UNSIGNED NOT NULL COMMENT '省份',
  `city` int(6) UNSIGNED NOT NULL COMMENT '城市',
  `area` int(6) UNSIGNED NOT NULL COMMENT '区县',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `file_id`(`logo`) USING BTREE,
  INDEX `provinces_id`(`province`) USING BTREE,
  INDEX `cicies_id`(`city`) USING BTREE,
  INDEX `areas_id`(`area`) USING BTREE,
  CONSTRAINT `areas_id` FOREIGN KEY (`area`) REFERENCES `areas` (`areaid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cicies_id` FOREIGN KEY (`city`) REFERENCES `cities` (`cityid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `company_id` FOREIGN KEY (`id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `file_id` FOREIGN KEY (`logo`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `provinces_id` FOREIGN KEY (`province`) REFERENCES `provinces` (`provinceid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for company_nurse_relation
-- ----------------------------
DROP TABLE IF EXISTS `company_nurse_relation`;
CREATE TABLE `company_nurse_relation`  (
  `company_id` smallint(5) UNSIGNED NOT NULL COMMENT '公司',
  `nurse_id` smallint(5) UNSIGNED NOT NULL COMMENT '护工',
  INDEX `companyid`(`company_id`) USING BTREE,
  INDEX `nurseid`(`nurse_id`) USING BTREE,
  CONSTRAINT `companyid` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nurseid` FOREIGN KEY (`nurse_id`) REFERENCES `nurse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for company_right
-- ----------------------------
DROP TABLE IF EXISTS `company_right`;
CREATE TABLE `company_right`  (
  `id` tinyint(3) UNSIGNED NOT NULL COMMENT '权限id',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for company_right_relation
-- ----------------------------
DROP TABLE IF EXISTS `company_right_relation`;
CREATE TABLE `company_right_relation`  (
  `user_id` smallint(5) UNSIGNED NOT NULL COMMENT '用户id',
  `right_id` tinyint(3) UNSIGNED NOT NULL COMMENT '权限id',
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `right_id`(`right_id`) USING BTREE,
  CONSTRAINT `company_right_relation_ibfk_1` FOREIGN KEY (`right_id`) REFERENCES `company_right` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `company_right_relation_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for file
-- ----------------------------
DROP TABLE IF EXISTS `file`;
CREATE TABLE `file`  (
  `id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文件的md5',
  `ext` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '扩展名',
  `path` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '保存位置',
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '文件名',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for nurse
-- ----------------------------
DROP TABLE IF EXISTS `nurse`;
CREATE TABLE `nurse`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '第二账号',
  `unionid` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '微信内部id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for nurse_info
-- ----------------------------
DROP TABLE IF EXISTS `nurse_info`;
CREATE TABLE `nurse_info`  (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT '护工id',
  `name` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '姓名',
  `sex` tinyint(1) NOT NULL COMMENT '性别',
  `province` int(6) UNSIGNED NOT NULL COMMENT '省',
  `city` int(6) UNSIGNED NOT NULL COMMENT '市',
  `area` int(6) UNSIGNED NOT NULL COMMENT '区',
  `headimg` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '头想',
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '手机',
  `birthday` datetime(0) NOT NULL COMMENT '生日',
  `workday` datetime(0) NOT NULL COMMENT '从业日期',
  `entryday` datetime(0) NOT NULL COMMENT '入职日期',
  `location` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '居住地址',
  `idcard` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '身份证',
  `idcardimg` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '身份证照片',
  `workcardimg` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '工作证照片',
  `intro` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `provinceid`(`province`) USING BTREE,
  INDEX `cityid`(`city`) USING BTREE,
  INDEX `areaid`(`area`) USING BTREE,
  CONSTRAINT `nurse_id` FOREIGN KEY (`id`) REFERENCES `nurse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `provinceid` FOREIGN KEY (`province`) REFERENCES `provinces` (`provinceid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cityid` FOREIGN KEY (`city`) REFERENCES `cities` (`cityid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `areaid` FOREIGN KEY (`area`) REFERENCES `areas` (`areaid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for nuser_category_relation
-- ----------------------------
DROP TABLE IF EXISTS `nuser_category_relation`;
CREATE TABLE `nuser_category_relation`  (
  `nurse_id` smallint(5) UNSIGNED NOT NULL COMMENT '护工id',
  `cotegory_id` smallint(5) UNSIGNED NOT NULL COMMENT '陪护项目id',
  INDEX `nurse`(`nurse_id`) USING BTREE,
  INDEX `category`(`cotegory_id`) USING BTREE,
  CONSTRAINT `nurse` FOREIGN KEY (`nurse_id`) REFERENCES `nurse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `category` FOREIGN KEY (`cotegory_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for provinces
-- ----------------------------
DROP TABLE IF EXISTS `provinces`;
CREATE TABLE `provinces`  (
  `provinceid` int(6) UNSIGNED NOT NULL,
  `province` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`provinceid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '省份信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `union_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '微信唯一id',
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '电话第二账号',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '密码',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for user_info
-- ----------------------------
DROP TABLE IF EXISTS `user_info`;
CREATE TABLE `user_info`  (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT '用户id',
  `name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '姓名',
  `sex` tinyint(1) UNSIGNED NOT NULL COMMENT '性别',
  `company` smallint(5) UNSIGNED NOT NULL COMMENT '所属公司id',
  `head_imgae` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '头像',
  `province` int(6) UNSIGNED NOT NULL COMMENT '省份',
  `city` int(6) UNSIGNED NOT NULL COMMENT '市',
  `area` int(6) UNSIGNED NOT NULL COMMENT '区县',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `company`(`company`) USING BTREE,
  INDEX `file`(`head_imgae`) USING BTREE,
  INDEX `peovince`(`province`) USING BTREE,
  INDEX `cities`(`city`) USING BTREE,
  INDEX `areas`(`area`) USING BTREE,
  CONSTRAINT `areas` FOREIGN KEY (`area`) REFERENCES `areas` (`areaid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cities` FOREIGN KEY (`city`) REFERENCES `cities` (`cityid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `company` FOREIGN KEY (`company`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `file` FOREIGN KEY (`head_imgae`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `id` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `peovince` FOREIGN KEY (`province`) REFERENCES `provinces` (`provinceid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for viptag
-- ----------------------------
DROP TABLE IF EXISTS `viptag`;
CREATE TABLE `viptag`  (
  `id` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'vip标签' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for viptag_nurse_relation
-- ----------------------------
DROP TABLE IF EXISTS `viptag_nurse_relation`;
CREATE TABLE `viptag_nurse_relation`  (
  `viptag_id` tinyint(2) UNSIGNED NOT NULL,
  `nurse_id` smallint(5) UNSIGNED NOT NULL,
  INDEX `viptagid`(`viptag_id`) USING BTREE,
  INDEX `nuserviptagid`(`nurse_id`) USING BTREE,
  CONSTRAINT `viptagid` FOREIGN KEY (`viptag_id`) REFERENCES `viptag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nuserviptagid` FOREIGN KEY (`nurse_id`) REFERENCES `nurse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
