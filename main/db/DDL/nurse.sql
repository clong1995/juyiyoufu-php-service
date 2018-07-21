/*
 Navicat Premium Data Transfer

 Source Server         : nurse
 Source Server Type    : MariaDB
 Source Server Version : 100034
 Source Host           : localhost:3306
 Source Schema         : nurse

 Target Server Type    : MariaDB
 Target Server Version : 100034
 File Encoding         : 65001

 Date: 21/07/2018 18:53:02
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

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
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '公司名称',
  `logo` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'log',
  `province` int(6) UNSIGNED NOT NULL COMMENT '省份',
  `city` int(6) UNSIGNED NOT NULL COMMENT '城市',
  `area` int(6) UNSIGNED NOT NULL COMMENT '区县',
  `info` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '备注',
  `license` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '营业执照',
  `license_img` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `employee_id` smallint(5) UNSIGNED NOT NULL COMMENT '负责人',
  PRIMARY KEY (`id`, `name`, `license`) USING BTREE,
  INDEX `company_areas_id`(`area`) USING BTREE,
  INDEX `company_provinces_id`(`province`) USING BTREE,
  INDEX `company_cities_id`(`city`) USING BTREE,
  INDEX `company_logo_id`(`logo`) USING BTREE,
  INDEX `company_license_img_id`(`license_img`) USING BTREE,
  INDEX `company_employee_id`(`employee_id`) USING BTREE,
  CONSTRAINT `company_areas_id` FOREIGN KEY (`area`) REFERENCES `areas` (`areaid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `company_cities_id` FOREIGN KEY (`city`) REFERENCES `cities` (`cityid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `company_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `company_license_img_id` FOREIGN KEY (`license_img`) REFERENCES `file` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `company_logo_id` FOREIGN KEY (`logo`) REFERENCES `file` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `company_provinces_id` FOREIGN KEY (`province`) REFERENCES `provinces` (`provinceid`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for employee
-- ----------------------------
DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee`  (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '公司id',
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '第二id',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '密码',
  `unionid` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '微信id',
  PRIMARY KEY (`id`, `phone`) USING BTREE,
  UNIQUE INDEX `phone`(`phone`) USING BTREE,
  INDEX `id`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 52 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for employee_info
-- ----------------------------
DROP TABLE IF EXISTS `employee_info`;
CREATE TABLE `employee_info`  (
  `employee_id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名字',
  `province_id` int(6) UNSIGNED DEFAULT NULL COMMENT '省份',
  `city_id` int(6) UNSIGNED DEFAULT NULL COMMENT '市',
  `area_id` int(6) UNSIGNED DEFAULT NULL COMMENT '区县',
  `head_image_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '头像',
  `company_id` smallint(6) UNSIGNED NOT NULL COMMENT '所属公司',
  `role_id` tinyint(2) UNSIGNED NOT NULL COMMENT '角色',
  `index_menu_group_id` tinyint(2) UNSIGNED NOT NULL COMMENT '首页菜单',
  PRIMARY KEY (`employee_id`) USING BTREE,
  INDEX `employee_province_id`(`province_id`) USING BTREE,
  INDEX `employee_city_id`(`city_id`) USING BTREE,
  INDEX `employee_area_id`(`area_id`) USING BTREE,
  INDEX `employee_file_id`(`head_image_id`) USING BTREE,
  INDEX `employee_company_id`(`company_id`) USING BTREE,
  INDEX `employee_index_menu_group_id`(`index_menu_group_id`) USING BTREE,
  INDEX `employee_role_id`(`role_id`) USING BTREE,
  CONSTRAINT `employee_area_id` FOREIGN KEY (`area_id`) REFERENCES `areas` (`areaid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `employee_city_id` FOREIGN KEY (`city_id`) REFERENCES `cities` (`cityid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `employee_company_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `employee_file_id` FOREIGN KEY (`head_image_id`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `employee_index_menu_group_id` FOREIGN KEY (`index_menu_group_id`) REFERENCES `index_menu_group` (`index_menu_group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `employee_province_id` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`provinceid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `employee_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
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
-- Table structure for index_menu
-- ----------------------------
DROP TABLE IF EXISTS `index_menu`;
CREATE TABLE `index_menu`  (
  `index_menu_id` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名字',
  `privilege_id` tinyint(2) UNSIGNED NOT NULL COMMENT '权限',
  `in_order` tinyint(2) NOT NULL COMMENT '排序',
  `icon` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图标',
  PRIMARY KEY (`index_menu_id`) USING BTREE,
  INDEX `employee_menu_right_id`(`privilege_id`) USING BTREE,
  CONSTRAINT `employee_menu_right_id` FOREIGN KEY (`privilege_id`) REFERENCES `privilege` (`privilege_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for index_menu_group
-- ----------------------------
DROP TABLE IF EXISTS `index_menu_group`;
CREATE TABLE `index_menu_group`  (
  `index_menu_group_id` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`index_menu_group_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for menu_index_menu_group_relation
-- ----------------------------
DROP TABLE IF EXISTS `menu_index_menu_group_relation`;
CREATE TABLE `menu_index_menu_group_relation`  (
  `index_menu_id` tinyint(2) UNSIGNED NOT NULL,
  `index_menu_group_id` tinyint(2) UNSIGNED NOT NULL,
  INDEX `menu_menu_group_relation_menu_group_id`(`index_menu_group_id`) USING BTREE,
  INDEX `menu_menu_group_relation_menu_id`(`index_menu_id`) USING BTREE,
  CONSTRAINT `menu_menu_group_relation_menu_group_id` FOREIGN KEY (`index_menu_group_id`) REFERENCES `index_menu_group` (`index_menu_group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `menu_menu_group_relation_menu_id` FOREIGN KEY (`index_menu_id`) REFERENCES `index_menu` (`index_menu_id`) ON DELETE CASCADE ON UPDATE CASCADE
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
  `intro` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '简介',
  `company` smallint(6) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `provinceid`(`province`) USING BTREE,
  INDEX `cityid`(`city`) USING BTREE,
  INDEX `areaid`(`area`) USING BTREE,
  INDEX `nurse_company_id`(`company`) USING BTREE,
  CONSTRAINT `areaid` FOREIGN KEY (`area`) REFERENCES `areas` (`areaid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cityid` FOREIGN KEY (`city`) REFERENCES `cities` (`cityid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nurse_company_id` FOREIGN KEY (`company`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nurse_id` FOREIGN KEY (`id`) REFERENCES `nurse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `provinceid` FOREIGN KEY (`province`) REFERENCES `provinces` (`provinceid`) ON DELETE CASCADE ON UPDATE CASCADE
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
  CONSTRAINT `category` FOREIGN KEY (`cotegory_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `nurse` FOREIGN KEY (`nurse_id`) REFERENCES `nurse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for privilege
-- ----------------------------
DROP TABLE IF EXISTS `privilege`;
CREATE TABLE `privilege`  (
  `privilege_id` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT,
  `path` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`privilege_id`, `path`) USING BTREE,
  INDEX `id`(`privilege_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 44 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for privilege_info
-- ----------------------------
DROP TABLE IF EXISTS `privilege_info`;
CREATE TABLE `privilege_info`  (
  `privilege_id` tinyint(2) UNSIGNED NOT NULL,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '权限的名字',
  `info` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '权限说明',
  `privilege_type_id` tinyint(1) UNSIGNED NOT NULL COMMENT '权限类型',
  `t` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  INDEX `privilege_info_id`(`privilege_id`) USING BTREE,
  INDEX `privilege_info_type`(`privilege_type_id`) USING BTREE,
  CONSTRAINT `privilege_info_id` FOREIGN KEY (`privilege_id`) REFERENCES `privilege` (`privilege_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `privilege_info_type` FOREIGN KEY (`privilege_type_id`) REFERENCES `privilege_type` (`privilege_type_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for privilege_type
-- ----------------------------
DROP TABLE IF EXISTS `privilege_type`;
CREATE TABLE `privilege_type`  (
  `privilege_type_id` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`privilege_type_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

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
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role`  (
  `role_id` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '角色名',
  PRIMARY KEY (`role_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for role_info
-- ----------------------------
DROP TABLE IF EXISTS `role_info`;
CREATE TABLE `role_info`  (
  `name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `role_id` tinyint(2) UNSIGNED NOT NULL,
  `info` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '说明',
  INDEX `role_info_id`(`role_id`) USING BTREE,
  CONSTRAINT `role_info_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for role_privilege_relation
-- ----------------------------
DROP TABLE IF EXISTS `role_privilege_relation`;
CREATE TABLE `role_privilege_relation`  (
  `role_id` tinyint(2) UNSIGNED NOT NULL,
  `privilege_id` tinyint(2) UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`, `privilege_id`) USING BTREE,
  INDEX `role_privilege_relation_privilege_id`(`privilege_id`) USING BTREE,
  CONSTRAINT `role_privilege_relation_privilege_id` FOREIGN KEY (`privilege_id`) REFERENCES `privilege` (`privilege_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_privilege_relation_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

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
-- Table structure for user_company_relation
-- ----------------------------
DROP TABLE IF EXISTS `user_company_relation`;
CREATE TABLE `user_company_relation`  (
  `user_id` smallint(5) UNSIGNED NOT NULL COMMENT '用户id',
  `company_id` smallint(5) UNSIGNED NOT NULL COMMENT '陪护公司id',
  `working` tinyint(1) UNSIGNED NOT NULL COMMENT '是否正在服务,1:服务中,2:服务结束',
  PRIMARY KEY (`user_id`) USING BTREE,
  INDEX `company_user_id`(`company_id`) USING BTREE,
  CONSTRAINT `company_user_id` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user__company_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for user_info
-- ----------------------------
DROP TABLE IF EXISTS `user_info`;
CREATE TABLE `user_info`  (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT '用户id',
  `name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '姓名',
  `sex` tinyint(1) UNSIGNED NOT NULL COMMENT '性别',
  `head_imgae` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '头像',
  `province` int(6) UNSIGNED NOT NULL COMMENT '省份',
  `city` int(6) UNSIGNED NOT NULL COMMENT '市',
  `area` int(6) UNSIGNED NOT NULL COMMENT '区县',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `file`(`head_imgae`) USING BTREE,
  INDEX `peovince`(`province`) USING BTREE,
  INDEX `cities`(`city`) USING BTREE,
  INDEX `areas`(`area`) USING BTREE,
  CONSTRAINT `areas` FOREIGN KEY (`area`) REFERENCES `areas` (`areaid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cities` FOREIGN KEY (`city`) REFERENCES `cities` (`cityid`) ON DELETE CASCADE ON UPDATE CASCADE,
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
  CONSTRAINT `nuserviptagid` FOREIGN KEY (`nurse_id`) REFERENCES `nurse` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `viptagid` FOREIGN KEY (`viptag_id`) REFERENCES `viptag` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

SET FOREIGN_KEY_CHECKS = 1;
