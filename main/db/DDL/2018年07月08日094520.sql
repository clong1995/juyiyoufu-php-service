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

 Date: 08/07/2018 09:40:58
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id` smallint(5) UNSIGNED NOT NULL,
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `unionid` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '微信',
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '电话',
  PRIMARY KEY (`id`, `phone`) USING BTREE,
  INDEX `id`(`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (1, 'E10ADC3949BA59ABBE56E057F20F883E', '', 'admin');

-- ----------------------------
-- Table structure for admin_info
-- ----------------------------
DROP TABLE IF EXISTS `admin_info`;
CREATE TABLE `admin_info`  (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '名字',
  PRIMARY KEY (`id`) USING BTREE,
  CONSTRAINT `infoid` FOREIGN KEY (`id`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu`;
CREATE TABLE `admin_menu`  (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '菜单名称',
  `admin_right_id` tinyint(2) UNSIGNED NOT NULL COMMENT '菜单权限id',
  `order` tinyint(2) UNSIGNED NOT NULL COMMENT '菜单排序',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `admin_menu_id`(`admin_right_id`) USING BTREE,
  CONSTRAINT `admin_menu_id` FOREIGN KEY (`admin_right_id`) REFERENCES `admin_right` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for admin_menu_admin_relation
-- ----------------------------
DROP TABLE IF EXISTS `admin_menu_admin_relation`;
CREATE TABLE `admin_menu_admin_relation`  (
  `admin_id` smallint(5) UNSIGNED NOT NULL,
  `admin_menu_id` smallint(5) UNSIGNED NOT NULL,
  INDEX `admin_menu_admin_relation_admin_id`(`admin_id`) USING BTREE,
  INDEX `admin_menu_admin_relation_admin_menu_id`(`admin_menu_id`) USING BTREE,
  CONSTRAINT `admin_menu_admin_relation_admin_id` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `admin_menu_admin_relation_admin_menu_id` FOREIGN KEY (`admin_menu_id`) REFERENCES `admin_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for admin_right
-- ----------------------------
DROP TABLE IF EXISTS `admin_right`;
CREATE TABLE `admin_right`  (
  `id` tinyint(2) UNSIGNED NOT NULL,
  `path` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for admin_right_relation
-- ----------------------------
DROP TABLE IF EXISTS `admin_right_relation`;
CREATE TABLE `admin_right_relation`  (
  `admin_id` smallint(5) UNSIGNED NOT NULL,
  `right_id` tinyint(5) UNSIGNED NOT NULL,
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
-- Records of areas
-- ----------------------------
INSERT INTO `areas` VALUES (110101, '东城区', 110100);
INSERT INTO `areas` VALUES (110102, '西城区', 110100);
INSERT INTO `areas` VALUES (110103, '崇文区', 110100);
INSERT INTO `areas` VALUES (110104, '宣武区', 110100);
INSERT INTO `areas` VALUES (110105, '朝阳区', 110100);
INSERT INTO `areas` VALUES (110106, '丰台区', 110100);
INSERT INTO `areas` VALUES (110107, '石景山区', 110100);
INSERT INTO `areas` VALUES (110108, '海淀区', 110100);
INSERT INTO `areas` VALUES (110109, '门头沟区', 110100);
INSERT INTO `areas` VALUES (110111, '房山区', 110100);
INSERT INTO `areas` VALUES (110112, '通州区', 110100);
INSERT INTO `areas` VALUES (110113, '顺义区', 110100);
INSERT INTO `areas` VALUES (110114, '昌平区', 110100);
INSERT INTO `areas` VALUES (110115, '大兴区', 110100);
INSERT INTO `areas` VALUES (110116, '怀柔区', 110100);
INSERT INTO `areas` VALUES (110117, '平谷区', 110100);
INSERT INTO `areas` VALUES (110228, '密云县', 110200);
INSERT INTO `areas` VALUES (110229, '延庆县', 110200);
INSERT INTO `areas` VALUES (120101, '和平区', 120100);
INSERT INTO `areas` VALUES (120102, '河东区', 120100);
INSERT INTO `areas` VALUES (120103, '河西区', 120100);
INSERT INTO `areas` VALUES (120104, '南开区', 120100);
INSERT INTO `areas` VALUES (120105, '河北区', 120100);
INSERT INTO `areas` VALUES (120106, '红桥区', 120100);
INSERT INTO `areas` VALUES (120107, '塘沽区', 120100);
INSERT INTO `areas` VALUES (120108, '汉沽区', 120100);
INSERT INTO `areas` VALUES (120109, '大港区', 120100);
INSERT INTO `areas` VALUES (120110, '东丽区', 120100);
INSERT INTO `areas` VALUES (120111, '西青区', 120100);
INSERT INTO `areas` VALUES (120112, '津南区', 120100);
INSERT INTO `areas` VALUES (120113, '北辰区', 120100);
INSERT INTO `areas` VALUES (120114, '武清区', 120100);
INSERT INTO `areas` VALUES (120115, '宝坻区', 120100);
INSERT INTO `areas` VALUES (120221, '宁河县', 120200);
INSERT INTO `areas` VALUES (120223, '静海县', 120200);
INSERT INTO `areas` VALUES (120225, '蓟　县', 120200);
INSERT INTO `areas` VALUES (130101, '市辖区', 130100);
INSERT INTO `areas` VALUES (130102, '长安区', 130100);
INSERT INTO `areas` VALUES (130103, '桥东区', 130100);
INSERT INTO `areas` VALUES (130104, '桥西区', 130100);
INSERT INTO `areas` VALUES (130105, '新华区', 130100);
INSERT INTO `areas` VALUES (130107, '井陉矿区', 130100);
INSERT INTO `areas` VALUES (130108, '裕华区', 130100);
INSERT INTO `areas` VALUES (130121, '井陉县', 130100);
INSERT INTO `areas` VALUES (130123, '正定县', 130100);
INSERT INTO `areas` VALUES (130124, '栾城县', 130100);
INSERT INTO `areas` VALUES (130125, '行唐县', 130100);
INSERT INTO `areas` VALUES (130126, '灵寿县', 130100);
INSERT INTO `areas` VALUES (130127, '高邑县', 130100);
INSERT INTO `areas` VALUES (130128, '深泽县', 130100);
INSERT INTO `areas` VALUES (130129, '赞皇县', 130100);
INSERT INTO `areas` VALUES (130130, '无极县', 130100);
INSERT INTO `areas` VALUES (130131, '平山县', 130100);
INSERT INTO `areas` VALUES (130132, '元氏县', 130100);
INSERT INTO `areas` VALUES (130133, '赵　县', 130100);
INSERT INTO `areas` VALUES (130181, '辛集市', 130100);
INSERT INTO `areas` VALUES (130182, '藁城市', 130100);
INSERT INTO `areas` VALUES (130183, '晋州市', 130100);
INSERT INTO `areas` VALUES (130184, '新乐市', 130100);
INSERT INTO `areas` VALUES (130185, '鹿泉市', 130100);
INSERT INTO `areas` VALUES (130201, '市辖区', 130200);
INSERT INTO `areas` VALUES (130202, '路南区', 130200);
INSERT INTO `areas` VALUES (130203, '路北区', 130200);
INSERT INTO `areas` VALUES (130204, '古冶区', 130200);
INSERT INTO `areas` VALUES (130205, '开平区', 130200);
INSERT INTO `areas` VALUES (130207, '丰南区', 130200);
INSERT INTO `areas` VALUES (130208, '丰润区', 130200);
INSERT INTO `areas` VALUES (130223, '滦　县', 130200);
INSERT INTO `areas` VALUES (130224, '滦南县', 130200);
INSERT INTO `areas` VALUES (130225, '乐亭县', 130200);
INSERT INTO `areas` VALUES (130227, '迁西县', 130200);
INSERT INTO `areas` VALUES (130229, '玉田县', 130200);
INSERT INTO `areas` VALUES (130230, '唐海县', 130200);
INSERT INTO `areas` VALUES (130281, '遵化市', 130200);
INSERT INTO `areas` VALUES (130283, '迁安市', 130200);
INSERT INTO `areas` VALUES (130301, '市辖区', 130300);
INSERT INTO `areas` VALUES (130302, '海港区', 130300);
INSERT INTO `areas` VALUES (130303, '山海关区', 130300);
INSERT INTO `areas` VALUES (130304, '北戴河区', 130300);
INSERT INTO `areas` VALUES (130321, '青龙满族自治县', 130300);
INSERT INTO `areas` VALUES (130322, '昌黎县', 130300);
INSERT INTO `areas` VALUES (130323, '抚宁县', 130300);
INSERT INTO `areas` VALUES (130324, '卢龙县', 130300);
INSERT INTO `areas` VALUES (130401, '市辖区', 130400);
INSERT INTO `areas` VALUES (130402, '邯山区', 130400);
INSERT INTO `areas` VALUES (130403, '丛台区', 130400);
INSERT INTO `areas` VALUES (130404, '复兴区', 130400);
INSERT INTO `areas` VALUES (130406, '峰峰矿区', 130400);
INSERT INTO `areas` VALUES (130421, '邯郸县', 130400);
INSERT INTO `areas` VALUES (130423, '临漳县', 130400);
INSERT INTO `areas` VALUES (130424, '成安县', 130400);
INSERT INTO `areas` VALUES (130425, '大名县', 130400);
INSERT INTO `areas` VALUES (130426, '涉　县', 130400);
INSERT INTO `areas` VALUES (130427, '磁　县', 130400);
INSERT INTO `areas` VALUES (130428, '肥乡县', 130400);
INSERT INTO `areas` VALUES (130429, '永年县', 130400);
INSERT INTO `areas` VALUES (130430, '邱　县', 130400);
INSERT INTO `areas` VALUES (130431, '鸡泽县', 130400);
INSERT INTO `areas` VALUES (130432, '广平县', 130400);
INSERT INTO `areas` VALUES (130433, '馆陶县', 130400);
INSERT INTO `areas` VALUES (130434, '魏　县', 130400);
INSERT INTO `areas` VALUES (130435, '曲周县', 130400);
INSERT INTO `areas` VALUES (130481, '武安市', 130400);
INSERT INTO `areas` VALUES (130501, '市辖区', 130500);
INSERT INTO `areas` VALUES (130502, '桥东区', 130500);
INSERT INTO `areas` VALUES (130503, '桥西区', 130500);
INSERT INTO `areas` VALUES (130521, '邢台县', 130500);
INSERT INTO `areas` VALUES (130522, '临城县', 130500);
INSERT INTO `areas` VALUES (130523, '内丘县', 130500);
INSERT INTO `areas` VALUES (130524, '柏乡县', 130500);
INSERT INTO `areas` VALUES (130525, '隆尧县', 130500);
INSERT INTO `areas` VALUES (130526, '任　县', 130500);
INSERT INTO `areas` VALUES (130527, '南和县', 130500);
INSERT INTO `areas` VALUES (130528, '宁晋县', 130500);
INSERT INTO `areas` VALUES (130529, '巨鹿县', 130500);
INSERT INTO `areas` VALUES (130530, '新河县', 130500);
INSERT INTO `areas` VALUES (130531, '广宗县', 130500);
INSERT INTO `areas` VALUES (130532, '平乡县', 130500);
INSERT INTO `areas` VALUES (130533, '威　县', 130500);
INSERT INTO `areas` VALUES (130534, '清河县', 130500);
INSERT INTO `areas` VALUES (130535, '临西县', 130500);
INSERT INTO `areas` VALUES (130581, '南宫市', 130500);
INSERT INTO `areas` VALUES (130582, '沙河市', 130500);
INSERT INTO `areas` VALUES (130601, '市辖区', 130600);
INSERT INTO `areas` VALUES (130602, '新市区', 130600);
INSERT INTO `areas` VALUES (130603, '北市区', 130600);
INSERT INTO `areas` VALUES (130604, '南市区', 130600);
INSERT INTO `areas` VALUES (130621, '满城县', 130600);
INSERT INTO `areas` VALUES (130622, '清苑县', 130600);
INSERT INTO `areas` VALUES (130623, '涞水县', 130600);
INSERT INTO `areas` VALUES (130624, '阜平县', 130600);
INSERT INTO `areas` VALUES (130625, '徐水县', 130600);
INSERT INTO `areas` VALUES (130626, '定兴县', 130600);
INSERT INTO `areas` VALUES (130627, '唐　县', 130600);
INSERT INTO `areas` VALUES (130628, '高阳县', 130600);
INSERT INTO `areas` VALUES (130629, '容城县', 130600);
INSERT INTO `areas` VALUES (130630, '涞源县', 130600);
INSERT INTO `areas` VALUES (130631, '望都县', 130600);
INSERT INTO `areas` VALUES (130632, '安新县', 130600);
INSERT INTO `areas` VALUES (130633, '易　县', 130600);
INSERT INTO `areas` VALUES (130634, '曲阳县', 130600);
INSERT INTO `areas` VALUES (130635, '蠡　县', 130600);
INSERT INTO `areas` VALUES (130636, '顺平县', 130600);
INSERT INTO `areas` VALUES (130637, '博野县', 130600);
INSERT INTO `areas` VALUES (130638, '雄　县', 130600);
INSERT INTO `areas` VALUES (130681, '涿州市', 130600);
INSERT INTO `areas` VALUES (130682, '定州市', 130600);
INSERT INTO `areas` VALUES (130683, '安国市', 130600);
INSERT INTO `areas` VALUES (130684, '高碑店市', 130600);
INSERT INTO `areas` VALUES (130701, '市辖区', 130700);
INSERT INTO `areas` VALUES (130702, '桥东区', 130700);
INSERT INTO `areas` VALUES (130703, '桥西区', 130700);
INSERT INTO `areas` VALUES (130705, '宣化区', 130700);
INSERT INTO `areas` VALUES (130706, '下花园区', 130700);
INSERT INTO `areas` VALUES (130721, '宣化县', 130700);
INSERT INTO `areas` VALUES (130722, '张北县', 130700);
INSERT INTO `areas` VALUES (130723, '康保县', 130700);
INSERT INTO `areas` VALUES (130724, '沽源县', 130700);
INSERT INTO `areas` VALUES (130725, '尚义县', 130700);
INSERT INTO `areas` VALUES (130726, '蔚　县', 130700);
INSERT INTO `areas` VALUES (130727, '阳原县', 130700);
INSERT INTO `areas` VALUES (130728, '怀安县', 130700);
INSERT INTO `areas` VALUES (130729, '万全县', 130700);
INSERT INTO `areas` VALUES (130730, '怀来县', 130700);
INSERT INTO `areas` VALUES (130731, '涿鹿县', 130700);
INSERT INTO `areas` VALUES (130732, '赤城县', 130700);
INSERT INTO `areas` VALUES (130733, '崇礼县', 130700);
INSERT INTO `areas` VALUES (130801, '市辖区', 130800);
INSERT INTO `areas` VALUES (130802, '双桥区', 130800);
INSERT INTO `areas` VALUES (130803, '双滦区', 130800);
INSERT INTO `areas` VALUES (130804, '鹰手营子矿区', 130800);
INSERT INTO `areas` VALUES (130821, '承德县', 130800);
INSERT INTO `areas` VALUES (130822, '兴隆县', 130800);
INSERT INTO `areas` VALUES (130823, '平泉县', 130800);
INSERT INTO `areas` VALUES (130824, '滦平县', 130800);
INSERT INTO `areas` VALUES (130825, '隆化县', 130800);
INSERT INTO `areas` VALUES (130826, '丰宁满族自治县', 130800);
INSERT INTO `areas` VALUES (130827, '宽城满族自治县', 130800);
INSERT INTO `areas` VALUES (130828, '围场满族蒙古族自治县', 130800);
INSERT INTO `areas` VALUES (130901, '市辖区', 130900);
INSERT INTO `areas` VALUES (130902, '新华区', 130900);
INSERT INTO `areas` VALUES (130903, '运河区', 130900);
INSERT INTO `areas` VALUES (130921, '沧　县', 130900);
INSERT INTO `areas` VALUES (130922, '青　县', 130900);
INSERT INTO `areas` VALUES (130923, '东光县', 130900);
INSERT INTO `areas` VALUES (130924, '海兴县', 130900);
INSERT INTO `areas` VALUES (130925, '盐山县', 130900);
INSERT INTO `areas` VALUES (130926, '肃宁县', 130900);
INSERT INTO `areas` VALUES (130927, '南皮县', 130900);
INSERT INTO `areas` VALUES (130928, '吴桥县', 130900);
INSERT INTO `areas` VALUES (130929, '献　县', 130900);
INSERT INTO `areas` VALUES (130930, '孟村回族自治县', 130900);
INSERT INTO `areas` VALUES (130981, '泊头市', 130900);
INSERT INTO `areas` VALUES (130982, '任丘市', 130900);
INSERT INTO `areas` VALUES (130983, '黄骅市', 130900);
INSERT INTO `areas` VALUES (130984, '河间市', 130900);
INSERT INTO `areas` VALUES (131001, '市辖区', 131000);
INSERT INTO `areas` VALUES (131002, '安次区', 131000);
INSERT INTO `areas` VALUES (131003, '广阳区', 131000);
INSERT INTO `areas` VALUES (131022, '固安县', 131000);
INSERT INTO `areas` VALUES (131023, '永清县', 131000);
INSERT INTO `areas` VALUES (131024, '香河县', 131000);
INSERT INTO `areas` VALUES (131025, '大城县', 131000);
INSERT INTO `areas` VALUES (131026, '文安县', 131000);
INSERT INTO `areas` VALUES (131028, '大厂回族自治县', 131000);
INSERT INTO `areas` VALUES (131081, '霸州市', 131000);
INSERT INTO `areas` VALUES (131082, '三河市', 131000);
INSERT INTO `areas` VALUES (131101, '市辖区', 131100);
INSERT INTO `areas` VALUES (131102, '桃城区', 131100);
INSERT INTO `areas` VALUES (131121, '枣强县', 131100);
INSERT INTO `areas` VALUES (131122, '武邑县', 131100);
INSERT INTO `areas` VALUES (131123, '武强县', 131100);
INSERT INTO `areas` VALUES (131124, '饶阳县', 131100);
INSERT INTO `areas` VALUES (131125, '安平县', 131100);
INSERT INTO `areas` VALUES (131126, '故城县', 131100);
INSERT INTO `areas` VALUES (131127, '景　县', 131100);
INSERT INTO `areas` VALUES (131128, '阜城县', 131100);
INSERT INTO `areas` VALUES (131181, '冀州市', 131100);
INSERT INTO `areas` VALUES (131182, '深州市', 131100);
INSERT INTO `areas` VALUES (140101, '市辖区', 140100);
INSERT INTO `areas` VALUES (140105, '小店区', 140100);
INSERT INTO `areas` VALUES (140106, '迎泽区', 140100);
INSERT INTO `areas` VALUES (140107, '杏花岭区', 140100);
INSERT INTO `areas` VALUES (140108, '尖草坪区', 140100);
INSERT INTO `areas` VALUES (140109, '万柏林区', 140100);
INSERT INTO `areas` VALUES (140110, '晋源区', 140100);
INSERT INTO `areas` VALUES (140121, '清徐县', 140100);
INSERT INTO `areas` VALUES (140122, '阳曲县', 140100);
INSERT INTO `areas` VALUES (140123, '娄烦县', 140100);
INSERT INTO `areas` VALUES (140181, '古交市', 140100);
INSERT INTO `areas` VALUES (140201, '市辖区', 140200);
INSERT INTO `areas` VALUES (140202, '城　区', 140200);
INSERT INTO `areas` VALUES (140203, '矿　区', 140200);
INSERT INTO `areas` VALUES (140211, '南郊区', 140200);
INSERT INTO `areas` VALUES (140212, '新荣区', 140200);
INSERT INTO `areas` VALUES (140221, '阳高县', 140200);
INSERT INTO `areas` VALUES (140222, '天镇县', 140200);
INSERT INTO `areas` VALUES (140223, '广灵县', 140200);
INSERT INTO `areas` VALUES (140224, '灵丘县', 140200);
INSERT INTO `areas` VALUES (140225, '浑源县', 140200);
INSERT INTO `areas` VALUES (140226, '左云县', 140200);
INSERT INTO `areas` VALUES (140227, '大同县', 140200);
INSERT INTO `areas` VALUES (140301, '市辖区', 140300);
INSERT INTO `areas` VALUES (140302, '城　区', 140300);
INSERT INTO `areas` VALUES (140303, '矿　区', 140300);
INSERT INTO `areas` VALUES (140311, '郊　区', 140300);
INSERT INTO `areas` VALUES (140321, '平定县', 140300);
INSERT INTO `areas` VALUES (140322, '盂　县', 140300);
INSERT INTO `areas` VALUES (140401, '市辖区', 140400);
INSERT INTO `areas` VALUES (140402, '城　区', 140400);
INSERT INTO `areas` VALUES (140411, '郊　区', 140400);
INSERT INTO `areas` VALUES (140421, '长治县', 140400);
INSERT INTO `areas` VALUES (140423, '襄垣县', 140400);
INSERT INTO `areas` VALUES (140424, '屯留县', 140400);
INSERT INTO `areas` VALUES (140425, '平顺县', 140400);
INSERT INTO `areas` VALUES (140426, '黎城县', 140400);
INSERT INTO `areas` VALUES (140427, '壶关县', 140400);
INSERT INTO `areas` VALUES (140428, '长子县', 140400);
INSERT INTO `areas` VALUES (140429, '武乡县', 140400);
INSERT INTO `areas` VALUES (140430, '沁　县', 140400);
INSERT INTO `areas` VALUES (140431, '沁源县', 140400);
INSERT INTO `areas` VALUES (140481, '潞城市', 140400);
INSERT INTO `areas` VALUES (140501, '市辖区', 140500);
INSERT INTO `areas` VALUES (140502, '城　区', 140500);
INSERT INTO `areas` VALUES (140521, '沁水县', 140500);
INSERT INTO `areas` VALUES (140522, '阳城县', 140500);
INSERT INTO `areas` VALUES (140524, '陵川县', 140500);
INSERT INTO `areas` VALUES (140525, '泽州县', 140500);
INSERT INTO `areas` VALUES (140581, '高平市', 140500);
INSERT INTO `areas` VALUES (140601, '市辖区', 140600);
INSERT INTO `areas` VALUES (140602, '朔城区', 140600);
INSERT INTO `areas` VALUES (140603, '平鲁区', 140600);
INSERT INTO `areas` VALUES (140621, '山阴县', 140600);
INSERT INTO `areas` VALUES (140622, '应　县', 140600);
INSERT INTO `areas` VALUES (140623, '右玉县', 140600);
INSERT INTO `areas` VALUES (140624, '怀仁县', 140600);
INSERT INTO `areas` VALUES (140701, '市辖区', 140700);
INSERT INTO `areas` VALUES (140702, '榆次区', 140700);
INSERT INTO `areas` VALUES (140721, '榆社县', 140700);
INSERT INTO `areas` VALUES (140722, '左权县', 140700);
INSERT INTO `areas` VALUES (140723, '和顺县', 140700);
INSERT INTO `areas` VALUES (140724, '昔阳县', 140700);
INSERT INTO `areas` VALUES (140725, '寿阳县', 140700);
INSERT INTO `areas` VALUES (140726, '太谷县', 140700);
INSERT INTO `areas` VALUES (140727, '祁　县', 140700);
INSERT INTO `areas` VALUES (140728, '平遥县', 140700);
INSERT INTO `areas` VALUES (140729, '灵石县', 140700);
INSERT INTO `areas` VALUES (140781, '介休市', 140700);
INSERT INTO `areas` VALUES (140801, '市辖区', 140800);
INSERT INTO `areas` VALUES (140802, '盐湖区', 140800);
INSERT INTO `areas` VALUES (140821, '临猗县', 140800);
INSERT INTO `areas` VALUES (140822, '万荣县', 140800);
INSERT INTO `areas` VALUES (140823, '闻喜县', 140800);
INSERT INTO `areas` VALUES (140824, '稷山县', 140800);
INSERT INTO `areas` VALUES (140825, '新绛县', 140800);
INSERT INTO `areas` VALUES (140826, '绛　县', 140800);
INSERT INTO `areas` VALUES (140827, '垣曲县', 140800);
INSERT INTO `areas` VALUES (140828, '夏　县', 140800);
INSERT INTO `areas` VALUES (140829, '平陆县', 140800);
INSERT INTO `areas` VALUES (140830, '芮城县', 140800);
INSERT INTO `areas` VALUES (140881, '永济市', 140800);
INSERT INTO `areas` VALUES (140882, '河津市', 140800);
INSERT INTO `areas` VALUES (140901, '市辖区', 140900);
INSERT INTO `areas` VALUES (140902, '忻府区', 140900);
INSERT INTO `areas` VALUES (140921, '定襄县', 140900);
INSERT INTO `areas` VALUES (140922, '五台县', 140900);
INSERT INTO `areas` VALUES (140923, '代　县', 140900);
INSERT INTO `areas` VALUES (140924, '繁峙县', 140900);
INSERT INTO `areas` VALUES (140925, '宁武县', 140900);
INSERT INTO `areas` VALUES (140926, '静乐县', 140900);
INSERT INTO `areas` VALUES (140927, '神池县', 140900);
INSERT INTO `areas` VALUES (140928, '五寨县', 140900);
INSERT INTO `areas` VALUES (140929, '岢岚县', 140900);
INSERT INTO `areas` VALUES (140930, '河曲县', 140900);
INSERT INTO `areas` VALUES (140931, '保德县', 140900);
INSERT INTO `areas` VALUES (140932, '偏关县', 140900);
INSERT INTO `areas` VALUES (140981, '原平市', 140900);
INSERT INTO `areas` VALUES (141001, '市辖区', 141000);
INSERT INTO `areas` VALUES (141002, '尧都区', 141000);
INSERT INTO `areas` VALUES (141021, '曲沃县', 141000);
INSERT INTO `areas` VALUES (141022, '翼城县', 141000);
INSERT INTO `areas` VALUES (141023, '襄汾县', 141000);
INSERT INTO `areas` VALUES (141024, '洪洞县', 141000);
INSERT INTO `areas` VALUES (141025, '古　县', 141000);
INSERT INTO `areas` VALUES (141026, '安泽县', 141000);
INSERT INTO `areas` VALUES (141027, '浮山县', 141000);
INSERT INTO `areas` VALUES (141028, '吉　县', 141000);
INSERT INTO `areas` VALUES (141029, '乡宁县', 141000);
INSERT INTO `areas` VALUES (141030, '大宁县', 141000);
INSERT INTO `areas` VALUES (141031, '隰　县', 141000);
INSERT INTO `areas` VALUES (141032, '永和县', 141000);
INSERT INTO `areas` VALUES (141033, '蒲　县', 141000);
INSERT INTO `areas` VALUES (141034, '汾西县', 141000);
INSERT INTO `areas` VALUES (141081, '侯马市', 141000);
INSERT INTO `areas` VALUES (141082, '霍州市', 141000);
INSERT INTO `areas` VALUES (141101, '市辖区', 141100);
INSERT INTO `areas` VALUES (141102, '离石区', 141100);
INSERT INTO `areas` VALUES (141121, '文水县', 141100);
INSERT INTO `areas` VALUES (141122, '交城县', 141100);
INSERT INTO `areas` VALUES (141123, '兴　县', 141100);
INSERT INTO `areas` VALUES (141124, '临　县', 141100);
INSERT INTO `areas` VALUES (141125, '柳林县', 141100);
INSERT INTO `areas` VALUES (141126, '石楼县', 141100);
INSERT INTO `areas` VALUES (141127, '岚　县', 141100);
INSERT INTO `areas` VALUES (141128, '方山县', 141100);
INSERT INTO `areas` VALUES (141129, '中阳县', 141100);
INSERT INTO `areas` VALUES (141130, '交口县', 141100);
INSERT INTO `areas` VALUES (141181, '孝义市', 141100);
INSERT INTO `areas` VALUES (141182, '汾阳市', 141100);
INSERT INTO `areas` VALUES (150101, '市辖区', 150100);
INSERT INTO `areas` VALUES (150102, '新城区', 150100);
INSERT INTO `areas` VALUES (150103, '回民区', 150100);
INSERT INTO `areas` VALUES (150104, '玉泉区', 150100);
INSERT INTO `areas` VALUES (150105, '赛罕区', 150100);
INSERT INTO `areas` VALUES (150121, '土默特左旗', 150100);
INSERT INTO `areas` VALUES (150122, '托克托县', 150100);
INSERT INTO `areas` VALUES (150123, '和林格尔县', 150100);
INSERT INTO `areas` VALUES (150124, '清水河县', 150100);
INSERT INTO `areas` VALUES (150125, '武川县', 150100);
INSERT INTO `areas` VALUES (150201, '市辖区', 150200);
INSERT INTO `areas` VALUES (150202, '东河区', 150200);
INSERT INTO `areas` VALUES (150203, '昆都仑区', 150200);
INSERT INTO `areas` VALUES (150204, '青山区', 150200);
INSERT INTO `areas` VALUES (150205, '石拐区', 150200);
INSERT INTO `areas` VALUES (150206, '白云矿区', 150200);
INSERT INTO `areas` VALUES (150207, '九原区', 150200);
INSERT INTO `areas` VALUES (150221, '土默特右旗', 150200);
INSERT INTO `areas` VALUES (150222, '固阳县', 150200);
INSERT INTO `areas` VALUES (150223, '达尔罕茂明安联合旗', 150200);
INSERT INTO `areas` VALUES (150301, '市辖区', 150300);
INSERT INTO `areas` VALUES (150302, '海勃湾区', 150300);
INSERT INTO `areas` VALUES (150303, '海南区', 150300);
INSERT INTO `areas` VALUES (150304, '乌达区', 150300);
INSERT INTO `areas` VALUES (150401, '市辖区', 150400);
INSERT INTO `areas` VALUES (150402, '红山区', 150400);
INSERT INTO `areas` VALUES (150403, '元宝山区', 150400);
INSERT INTO `areas` VALUES (150404, '松山区', 150400);
INSERT INTO `areas` VALUES (150421, '阿鲁科尔沁旗', 150400);
INSERT INTO `areas` VALUES (150422, '巴林左旗', 150400);
INSERT INTO `areas` VALUES (150423, '巴林右旗', 150400);
INSERT INTO `areas` VALUES (150424, '林西县', 150400);
INSERT INTO `areas` VALUES (150425, '克什克腾旗', 150400);
INSERT INTO `areas` VALUES (150426, '翁牛特旗', 150400);
INSERT INTO `areas` VALUES (150428, '喀喇沁旗', 150400);
INSERT INTO `areas` VALUES (150429, '宁城县', 150400);
INSERT INTO `areas` VALUES (150430, '敖汉旗', 150400);
INSERT INTO `areas` VALUES (150501, '市辖区', 150500);
INSERT INTO `areas` VALUES (150502, '科尔沁区', 150500);
INSERT INTO `areas` VALUES (150521, '科尔沁左翼中旗', 150500);
INSERT INTO `areas` VALUES (150522, '科尔沁左翼后旗', 150500);
INSERT INTO `areas` VALUES (150523, '开鲁县', 150500);
INSERT INTO `areas` VALUES (150524, '库伦旗', 150500);
INSERT INTO `areas` VALUES (150525, '奈曼旗', 150500);
INSERT INTO `areas` VALUES (150526, '扎鲁特旗', 150500);
INSERT INTO `areas` VALUES (150581, '霍林郭勒市', 150500);
INSERT INTO `areas` VALUES (150602, '东胜区', 150600);
INSERT INTO `areas` VALUES (150621, '达拉特旗', 150600);
INSERT INTO `areas` VALUES (150622, '准格尔旗', 150600);
INSERT INTO `areas` VALUES (150623, '鄂托克前旗', 150600);
INSERT INTO `areas` VALUES (150624, '鄂托克旗', 150600);
INSERT INTO `areas` VALUES (150625, '杭锦旗', 150600);
INSERT INTO `areas` VALUES (150626, '乌审旗', 150600);
INSERT INTO `areas` VALUES (150627, '伊金霍洛旗', 150600);
INSERT INTO `areas` VALUES (150701, '市辖区', 150700);
INSERT INTO `areas` VALUES (150702, '海拉尔区', 150700);
INSERT INTO `areas` VALUES (150721, '阿荣旗', 150700);
INSERT INTO `areas` VALUES (150722, '莫力达瓦达斡尔族自治', 150700);
INSERT INTO `areas` VALUES (150723, '鄂伦春自治旗', 150700);
INSERT INTO `areas` VALUES (150724, '鄂温克族自治旗', 150700);
INSERT INTO `areas` VALUES (150725, '陈巴尔虎旗', 150700);
INSERT INTO `areas` VALUES (150726, '新巴尔虎左旗', 150700);
INSERT INTO `areas` VALUES (150727, '新巴尔虎右旗', 150700);
INSERT INTO `areas` VALUES (150781, '满洲里市', 150700);
INSERT INTO `areas` VALUES (150782, '牙克石市', 150700);
INSERT INTO `areas` VALUES (150783, '扎兰屯市', 150700);
INSERT INTO `areas` VALUES (150784, '额尔古纳市', 150700);
INSERT INTO `areas` VALUES (150785, '根河市', 150700);
INSERT INTO `areas` VALUES (150801, '市辖区', 150800);
INSERT INTO `areas` VALUES (150802, '临河区', 150800);
INSERT INTO `areas` VALUES (150821, '五原县', 150800);
INSERT INTO `areas` VALUES (150822, '磴口县', 150800);
INSERT INTO `areas` VALUES (150823, '乌拉特前旗', 150800);
INSERT INTO `areas` VALUES (150824, '乌拉特中旗', 150800);
INSERT INTO `areas` VALUES (150825, '乌拉特后旗', 150800);
INSERT INTO `areas` VALUES (150826, '杭锦后旗', 150800);

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
-- Records of cities
-- ----------------------------
INSERT INTO `cities` VALUES (110100, '市辖区', 110000);
INSERT INTO `cities` VALUES (110200, '县', 110000);
INSERT INTO `cities` VALUES (120100, '市辖区', 120000);
INSERT INTO `cities` VALUES (120200, '县', 120000);
INSERT INTO `cities` VALUES (130100, '石家庄市', 130000);
INSERT INTO `cities` VALUES (130200, '唐山市', 130000);
INSERT INTO `cities` VALUES (130300, '秦皇岛市', 130000);
INSERT INTO `cities` VALUES (130400, '邯郸市', 130000);
INSERT INTO `cities` VALUES (130500, '邢台市', 130000);
INSERT INTO `cities` VALUES (130600, '保定市', 130000);
INSERT INTO `cities` VALUES (130700, '张家口市', 130000);
INSERT INTO `cities` VALUES (130800, '承德市', 130000);
INSERT INTO `cities` VALUES (130900, '沧州市', 130000);
INSERT INTO `cities` VALUES (131000, '廊坊市', 130000);
INSERT INTO `cities` VALUES (131100, '衡水市', 130000);
INSERT INTO `cities` VALUES (140100, '太原市', 140000);
INSERT INTO `cities` VALUES (140200, '大同市', 140000);
INSERT INTO `cities` VALUES (140300, '阳泉市', 140000);
INSERT INTO `cities` VALUES (140400, '长治市', 140000);
INSERT INTO `cities` VALUES (140500, '晋城市', 140000);
INSERT INTO `cities` VALUES (140600, '朔州市', 140000);
INSERT INTO `cities` VALUES (140700, '晋中市', 140000);
INSERT INTO `cities` VALUES (140800, '运城市', 140000);
INSERT INTO `cities` VALUES (140900, '忻州市', 140000);
INSERT INTO `cities` VALUES (141000, '临汾市', 140000);
INSERT INTO `cities` VALUES (141100, '吕梁市', 140000);
INSERT INTO `cities` VALUES (150100, '呼和浩特市', 150000);
INSERT INTO `cities` VALUES (150200, '包头市', 150000);
INSERT INTO `cities` VALUES (150300, '乌海市', 150000);
INSERT INTO `cities` VALUES (150400, '赤峰市', 150000);
INSERT INTO `cities` VALUES (150500, '通辽市', 150000);
INSERT INTO `cities` VALUES (150600, '鄂尔多斯市', 150000);
INSERT INTO `cities` VALUES (150700, '呼伦贝尔市', 150000);
INSERT INTO `cities` VALUES (150800, '巴彦淖尔市', 150000);
INSERT INTO `cities` VALUES (150900, '乌兰察布市', 150000);
INSERT INTO `cities` VALUES (152200, '兴安盟', 150000);
INSERT INTO `cities` VALUES (152500, '锡林郭勒盟', 150000);
INSERT INTO `cities` VALUES (152900, '阿拉善盟', 150000);
INSERT INTO `cities` VALUES (210100, '沈阳市', 210000);
INSERT INTO `cities` VALUES (210200, '大连市', 210000);
INSERT INTO `cities` VALUES (210300, '鞍山市', 210000);
INSERT INTO `cities` VALUES (210400, '抚顺市', 210000);
INSERT INTO `cities` VALUES (210500, '本溪市', 210000);
INSERT INTO `cities` VALUES (210600, '丹东市', 210000);
INSERT INTO `cities` VALUES (210700, '锦州市', 210000);
INSERT INTO `cities` VALUES (210800, '营口市', 210000);
INSERT INTO `cities` VALUES (210900, '阜新市', 210000);
INSERT INTO `cities` VALUES (211000, '辽阳市', 210000);
INSERT INTO `cities` VALUES (211100, '盘锦市', 210000);
INSERT INTO `cities` VALUES (211200, '铁岭市', 210000);
INSERT INTO `cities` VALUES (211300, '朝阳市', 210000);
INSERT INTO `cities` VALUES (211400, '葫芦岛市', 210000);
INSERT INTO `cities` VALUES (220100, '长春市', 220000);
INSERT INTO `cities` VALUES (220200, '吉林市', 220000);
INSERT INTO `cities` VALUES (220300, '四平市', 220000);
INSERT INTO `cities` VALUES (220400, '辽源市', 220000);
INSERT INTO `cities` VALUES (220500, '通化市', 220000);
INSERT INTO `cities` VALUES (220600, '白山市', 220000);
INSERT INTO `cities` VALUES (220700, '松原市', 220000);
INSERT INTO `cities` VALUES (220800, '白城市', 220000);
INSERT INTO `cities` VALUES (222400, '延边朝鲜族自治州', 220000);
INSERT INTO `cities` VALUES (230100, '哈尔滨市', 230000);
INSERT INTO `cities` VALUES (230200, '齐齐哈尔市', 230000);
INSERT INTO `cities` VALUES (230300, '鸡西市', 230000);
INSERT INTO `cities` VALUES (230400, '鹤岗市', 230000);
INSERT INTO `cities` VALUES (230500, '双鸭山市', 230000);
INSERT INTO `cities` VALUES (230600, '大庆市', 230000);
INSERT INTO `cities` VALUES (230700, '伊春市', 230000);
INSERT INTO `cities` VALUES (230800, '佳木斯市', 230000);
INSERT INTO `cities` VALUES (230900, '七台河市', 230000);
INSERT INTO `cities` VALUES (231000, '牡丹江市', 230000);
INSERT INTO `cities` VALUES (231100, '黑河市', 230000);
INSERT INTO `cities` VALUES (231200, '绥化市', 230000);
INSERT INTO `cities` VALUES (232700, '大兴安岭地区', 230000);
INSERT INTO `cities` VALUES (310100, '市辖区', 310000);
INSERT INTO `cities` VALUES (310200, '县', 310000);
INSERT INTO `cities` VALUES (320100, '南京市', 320000);
INSERT INTO `cities` VALUES (320200, '无锡市', 320000);
INSERT INTO `cities` VALUES (320300, '徐州市', 320000);
INSERT INTO `cities` VALUES (320400, '常州市', 320000);
INSERT INTO `cities` VALUES (320500, '苏州市', 320000);
INSERT INTO `cities` VALUES (320600, '南通市', 320000);
INSERT INTO `cities` VALUES (320700, '连云港市', 320000);
INSERT INTO `cities` VALUES (320800, '淮安市', 320000);
INSERT INTO `cities` VALUES (320900, '盐城市', 320000);
INSERT INTO `cities` VALUES (321000, '扬州市', 320000);
INSERT INTO `cities` VALUES (321100, '镇江市', 320000);
INSERT INTO `cities` VALUES (321200, '泰州市', 320000);
INSERT INTO `cities` VALUES (321300, '宿迁市', 320000);
INSERT INTO `cities` VALUES (330100, '杭州市', 330000);
INSERT INTO `cities` VALUES (330200, '宁波市', 330000);
INSERT INTO `cities` VALUES (330300, '温州市', 330000);
INSERT INTO `cities` VALUES (330400, '嘉兴市', 330000);
INSERT INTO `cities` VALUES (330500, '湖州市', 330000);
INSERT INTO `cities` VALUES (330600, '绍兴市', 330000);
INSERT INTO `cities` VALUES (330700, '金华市', 330000);
INSERT INTO `cities` VALUES (330800, '衢州市', 330000);
INSERT INTO `cities` VALUES (330900, '舟山市', 330000);
INSERT INTO `cities` VALUES (331000, '台州市', 330000);
INSERT INTO `cities` VALUES (331100, '丽水市', 330000);
INSERT INTO `cities` VALUES (340100, '合肥市', 340000);
INSERT INTO `cities` VALUES (340200, '芜湖市', 340000);
INSERT INTO `cities` VALUES (340300, '蚌埠市', 340000);
INSERT INTO `cities` VALUES (340400, '淮南市', 340000);
INSERT INTO `cities` VALUES (340500, '马鞍山市', 340000);
INSERT INTO `cities` VALUES (340600, '淮北市', 340000);
INSERT INTO `cities` VALUES (340700, '铜陵市', 340000);
INSERT INTO `cities` VALUES (340800, '安庆市', 340000);
INSERT INTO `cities` VALUES (341000, '黄山市', 340000);
INSERT INTO `cities` VALUES (341100, '滁州市', 340000);
INSERT INTO `cities` VALUES (341200, '阜阳市', 340000);
INSERT INTO `cities` VALUES (341300, '宿州市', 340000);
INSERT INTO `cities` VALUES (341400, '巢湖市', 340000);
INSERT INTO `cities` VALUES (341500, '六安市', 340000);
INSERT INTO `cities` VALUES (341600, '亳州市', 340000);
INSERT INTO `cities` VALUES (341700, '池州市', 340000);
INSERT INTO `cities` VALUES (341800, '宣城市', 340000);
INSERT INTO `cities` VALUES (350100, '福州市', 350000);
INSERT INTO `cities` VALUES (350200, '厦门市', 350000);
INSERT INTO `cities` VALUES (350300, '莆田市', 350000);
INSERT INTO `cities` VALUES (350400, '三明市', 350000);
INSERT INTO `cities` VALUES (350500, '泉州市', 350000);
INSERT INTO `cities` VALUES (350600, '漳州市', 350000);
INSERT INTO `cities` VALUES (350700, '南平市', 350000);
INSERT INTO `cities` VALUES (350800, '龙岩市', 350000);
INSERT INTO `cities` VALUES (350900, '宁德市', 350000);
INSERT INTO `cities` VALUES (360100, '南昌市', 360000);
INSERT INTO `cities` VALUES (360200, '景德镇市', 360000);
INSERT INTO `cities` VALUES (360300, '萍乡市', 360000);
INSERT INTO `cities` VALUES (360400, '九江市', 360000);
INSERT INTO `cities` VALUES (360500, '新余市', 360000);
INSERT INTO `cities` VALUES (360600, '鹰潭市', 360000);
INSERT INTO `cities` VALUES (360700, '赣州市', 360000);
INSERT INTO `cities` VALUES (360800, '吉安市', 360000);
INSERT INTO `cities` VALUES (360900, '宜春市', 360000);
INSERT INTO `cities` VALUES (361000, '抚州市', 360000);
INSERT INTO `cities` VALUES (361100, '上饶市', 360000);
INSERT INTO `cities` VALUES (370100, '济南市', 370000);
INSERT INTO `cities` VALUES (370200, '青岛市', 370000);
INSERT INTO `cities` VALUES (370300, '淄博市', 370000);
INSERT INTO `cities` VALUES (370400, '枣庄市', 370000);
INSERT INTO `cities` VALUES (370500, '东营市', 370000);
INSERT INTO `cities` VALUES (370600, '烟台市', 370000);
INSERT INTO `cities` VALUES (370700, '潍坊市', 370000);
INSERT INTO `cities` VALUES (370800, '济宁市', 370000);
INSERT INTO `cities` VALUES (370900, '泰安市', 370000);
INSERT INTO `cities` VALUES (371000, '威海市', 370000);
INSERT INTO `cities` VALUES (371100, '日照市', 370000);
INSERT INTO `cities` VALUES (371200, '莱芜市', 370000);
INSERT INTO `cities` VALUES (371300, '临沂市', 370000);
INSERT INTO `cities` VALUES (371400, '德州市', 370000);
INSERT INTO `cities` VALUES (371500, '聊城市', 370000);
INSERT INTO `cities` VALUES (371600, '滨州市', 370000);
INSERT INTO `cities` VALUES (371700, '荷泽市', 370000);
INSERT INTO `cities` VALUES (410100, '郑州市', 410000);
INSERT INTO `cities` VALUES (410200, '开封市', 410000);
INSERT INTO `cities` VALUES (410300, '洛阳市', 410000);
INSERT INTO `cities` VALUES (410400, '平顶山市', 410000);
INSERT INTO `cities` VALUES (410500, '安阳市', 410000);
INSERT INTO `cities` VALUES (410600, '鹤壁市', 410000);
INSERT INTO `cities` VALUES (410700, '新乡市', 410000);
INSERT INTO `cities` VALUES (410800, '焦作市', 410000);
INSERT INTO `cities` VALUES (410900, '濮阳市', 410000);
INSERT INTO `cities` VALUES (411000, '许昌市', 410000);
INSERT INTO `cities` VALUES (411100, '漯河市', 410000);
INSERT INTO `cities` VALUES (411200, '三门峡市', 410000);
INSERT INTO `cities` VALUES (411300, '南阳市', 410000);
INSERT INTO `cities` VALUES (411400, '商丘市', 410000);
INSERT INTO `cities` VALUES (411500, '信阳市', 410000);
INSERT INTO `cities` VALUES (411600, '周口市', 410000);
INSERT INTO `cities` VALUES (411700, '驻马店市', 410000);
INSERT INTO `cities` VALUES (420100, '武汉市', 420000);
INSERT INTO `cities` VALUES (420200, '黄石市', 420000);
INSERT INTO `cities` VALUES (420300, '十堰市', 420000);
INSERT INTO `cities` VALUES (420500, '宜昌市', 420000);
INSERT INTO `cities` VALUES (420600, '襄樊市', 420000);
INSERT INTO `cities` VALUES (420700, '鄂州市', 420000);
INSERT INTO `cities` VALUES (420800, '荆门市', 420000);
INSERT INTO `cities` VALUES (420900, '孝感市', 420000);
INSERT INTO `cities` VALUES (421000, '荆州市', 420000);
INSERT INTO `cities` VALUES (421100, '黄冈市', 420000);
INSERT INTO `cities` VALUES (421200, '咸宁市', 420000);
INSERT INTO `cities` VALUES (421300, '随州市', 420000);
INSERT INTO `cities` VALUES (422800, '恩施土家族苗族自治州', 420000);
INSERT INTO `cities` VALUES (429000, '省直辖行政单位', 420000);
INSERT INTO `cities` VALUES (430100, '长沙市', 430000);
INSERT INTO `cities` VALUES (430200, '株洲市', 430000);
INSERT INTO `cities` VALUES (430300, '湘潭市', 430000);
INSERT INTO `cities` VALUES (430400, '衡阳市', 430000);
INSERT INTO `cities` VALUES (430500, '邵阳市', 430000);
INSERT INTO `cities` VALUES (430600, '岳阳市', 430000);
INSERT INTO `cities` VALUES (430700, '常德市', 430000);
INSERT INTO `cities` VALUES (430800, '张家界市', 430000);
INSERT INTO `cities` VALUES (430900, '益阳市', 430000);
INSERT INTO `cities` VALUES (431000, '郴州市', 430000);
INSERT INTO `cities` VALUES (431100, '永州市', 430000);
INSERT INTO `cities` VALUES (431200, '怀化市', 430000);
INSERT INTO `cities` VALUES (431300, '娄底市', 430000);
INSERT INTO `cities` VALUES (433100, '湘西土家族苗族自治州', 430000);
INSERT INTO `cities` VALUES (440100, '广州市', 440000);
INSERT INTO `cities` VALUES (440200, '韶关市', 440000);
INSERT INTO `cities` VALUES (440300, '深圳市', 440000);
INSERT INTO `cities` VALUES (440400, '珠海市', 440000);
INSERT INTO `cities` VALUES (440500, '汕头市', 440000);
INSERT INTO `cities` VALUES (440600, '佛山市', 440000);
INSERT INTO `cities` VALUES (440700, '江门市', 440000);
INSERT INTO `cities` VALUES (440800, '湛江市', 440000);
INSERT INTO `cities` VALUES (440900, '茂名市', 440000);
INSERT INTO `cities` VALUES (441200, '肇庆市', 440000);
INSERT INTO `cities` VALUES (441300, '惠州市', 440000);
INSERT INTO `cities` VALUES (441400, '梅州市', 440000);
INSERT INTO `cities` VALUES (441500, '汕尾市', 440000);
INSERT INTO `cities` VALUES (441600, '河源市', 440000);
INSERT INTO `cities` VALUES (441700, '阳江市', 440000);
INSERT INTO `cities` VALUES (441800, '清远市', 440000);
INSERT INTO `cities` VALUES (441900, '东莞市', 440000);
INSERT INTO `cities` VALUES (442000, '中山市', 440000);
INSERT INTO `cities` VALUES (445100, '潮州市', 440000);
INSERT INTO `cities` VALUES (445200, '揭阳市', 440000);
INSERT INTO `cities` VALUES (445300, '云浮市', 440000);
INSERT INTO `cities` VALUES (450100, '南宁市', 450000);
INSERT INTO `cities` VALUES (450200, '柳州市', 450000);
INSERT INTO `cities` VALUES (450300, '桂林市', 450000);
INSERT INTO `cities` VALUES (450400, '梧州市', 450000);
INSERT INTO `cities` VALUES (450500, '北海市', 450000);
INSERT INTO `cities` VALUES (450600, '防城港市', 450000);
INSERT INTO `cities` VALUES (450700, '钦州市', 450000);
INSERT INTO `cities` VALUES (450800, '贵港市', 450000);
INSERT INTO `cities` VALUES (450900, '玉林市', 450000);
INSERT INTO `cities` VALUES (451000, '百色市', 450000);
INSERT INTO `cities` VALUES (451100, '贺州市', 450000);
INSERT INTO `cities` VALUES (451200, '河池市', 450000);
INSERT INTO `cities` VALUES (451300, '来宾市', 450000);
INSERT INTO `cities` VALUES (451400, '崇左市', 450000);
INSERT INTO `cities` VALUES (460100, '海口市', 460000);
INSERT INTO `cities` VALUES (460200, '三亚市', 460000);
INSERT INTO `cities` VALUES (469000, '省直辖县级行政单位', 460000);
INSERT INTO `cities` VALUES (500100, '市辖区', 500000);
INSERT INTO `cities` VALUES (500200, '县', 500000);
INSERT INTO `cities` VALUES (500300, '市', 500000);
INSERT INTO `cities` VALUES (510100, '成都市', 510000);
INSERT INTO `cities` VALUES (510300, '自贡市', 510000);
INSERT INTO `cities` VALUES (510400, '攀枝花市', 510000);
INSERT INTO `cities` VALUES (510500, '泸州市', 510000);
INSERT INTO `cities` VALUES (510600, '德阳市', 510000);
INSERT INTO `cities` VALUES (510700, '绵阳市', 510000);
INSERT INTO `cities` VALUES (510800, '广元市', 510000);
INSERT INTO `cities` VALUES (510900, '遂宁市', 510000);
INSERT INTO `cities` VALUES (511000, '内江市', 510000);
INSERT INTO `cities` VALUES (511100, '乐山市', 510000);
INSERT INTO `cities` VALUES (511300, '南充市', 510000);
INSERT INTO `cities` VALUES (511400, '眉山市', 510000);
INSERT INTO `cities` VALUES (511500, '宜宾市', 510000);
INSERT INTO `cities` VALUES (511600, '广安市', 510000);
INSERT INTO `cities` VALUES (511700, '达州市', 510000);
INSERT INTO `cities` VALUES (511800, '雅安市', 510000);
INSERT INTO `cities` VALUES (511900, '巴中市', 510000);
INSERT INTO `cities` VALUES (512000, '资阳市', 510000);
INSERT INTO `cities` VALUES (513200, '阿坝藏族羌族自治州', 510000);
INSERT INTO `cities` VALUES (513300, '甘孜藏族自治州', 510000);
INSERT INTO `cities` VALUES (513400, '凉山彝族自治州', 510000);
INSERT INTO `cities` VALUES (520100, '贵阳市', 520000);
INSERT INTO `cities` VALUES (520200, '六盘水市', 520000);
INSERT INTO `cities` VALUES (520300, '遵义市', 520000);
INSERT INTO `cities` VALUES (520400, '安顺市', 520000);
INSERT INTO `cities` VALUES (522200, '铜仁地区', 520000);
INSERT INTO `cities` VALUES (522300, '黔西南布依族苗族自治', 520000);
INSERT INTO `cities` VALUES (522400, '毕节地区', 520000);
INSERT INTO `cities` VALUES (522600, '黔东南苗族侗族自治州', 520000);
INSERT INTO `cities` VALUES (522700, '黔南布依族苗族自治州', 520000);
INSERT INTO `cities` VALUES (530100, '昆明市', 530000);
INSERT INTO `cities` VALUES (530300, '曲靖市', 530000);
INSERT INTO `cities` VALUES (530400, '玉溪市', 530000);
INSERT INTO `cities` VALUES (530500, '保山市', 530000);
INSERT INTO `cities` VALUES (530600, '昭通市', 530000);
INSERT INTO `cities` VALUES (530700, '丽江市', 530000);
INSERT INTO `cities` VALUES (530800, '思茅市', 530000);
INSERT INTO `cities` VALUES (530900, '临沧市', 530000);
INSERT INTO `cities` VALUES (532300, '楚雄彝族自治州', 530000);
INSERT INTO `cities` VALUES (532500, '红河哈尼族彝族自治州', 530000);
INSERT INTO `cities` VALUES (532600, '文山壮族苗族自治州', 530000);
INSERT INTO `cities` VALUES (532800, '西双版纳傣族自治州', 530000);
INSERT INTO `cities` VALUES (532900, '大理白族自治州', 530000);
INSERT INTO `cities` VALUES (533100, '德宏傣族景颇族自治州', 530000);
INSERT INTO `cities` VALUES (533300, '怒江傈僳族自治州', 530000);
INSERT INTO `cities` VALUES (533400, '迪庆藏族自治州', 530000);
INSERT INTO `cities` VALUES (540100, '拉萨市', 540000);
INSERT INTO `cities` VALUES (542100, '昌都地区', 540000);
INSERT INTO `cities` VALUES (542200, '山南地区', 540000);
INSERT INTO `cities` VALUES (542300, '日喀则地区', 540000);
INSERT INTO `cities` VALUES (542400, '那曲地区', 540000);
INSERT INTO `cities` VALUES (542500, '阿里地区', 540000);
INSERT INTO `cities` VALUES (542600, '林芝地区', 540000);
INSERT INTO `cities` VALUES (610100, '西安市', 610000);
INSERT INTO `cities` VALUES (610200, '铜川市', 610000);
INSERT INTO `cities` VALUES (610300, '宝鸡市', 610000);
INSERT INTO `cities` VALUES (610400, '咸阳市', 610000);
INSERT INTO `cities` VALUES (610500, '渭南市', 610000);
INSERT INTO `cities` VALUES (610600, '延安市', 610000);
INSERT INTO `cities` VALUES (610700, '汉中市', 610000);
INSERT INTO `cities` VALUES (610800, '榆林市', 610000);
INSERT INTO `cities` VALUES (610900, '安康市', 610000);
INSERT INTO `cities` VALUES (611000, '商洛市', 610000);
INSERT INTO `cities` VALUES (620100, '兰州市', 620000);
INSERT INTO `cities` VALUES (620200, '嘉峪关市', 620000);
INSERT INTO `cities` VALUES (620300, '金昌市', 620000);
INSERT INTO `cities` VALUES (620400, '白银市', 620000);
INSERT INTO `cities` VALUES (620500, '天水市', 620000);
INSERT INTO `cities` VALUES (620600, '武威市', 620000);
INSERT INTO `cities` VALUES (620700, '张掖市', 620000);
INSERT INTO `cities` VALUES (620800, '平凉市', 620000);
INSERT INTO `cities` VALUES (620900, '酒泉市', 620000);
INSERT INTO `cities` VALUES (621000, '庆阳市', 620000);
INSERT INTO `cities` VALUES (621100, '定西市', 620000);
INSERT INTO `cities` VALUES (621200, '陇南市', 620000);
INSERT INTO `cities` VALUES (622900, '临夏回族自治州', 620000);
INSERT INTO `cities` VALUES (623000, '甘南藏族自治州', 620000);
INSERT INTO `cities` VALUES (630100, '西宁市', 630000);
INSERT INTO `cities` VALUES (632100, '海东地区', 630000);
INSERT INTO `cities` VALUES (632200, '海北藏族自治州', 630000);
INSERT INTO `cities` VALUES (632300, '黄南藏族自治州', 630000);
INSERT INTO `cities` VALUES (632500, '海南藏族自治州', 630000);
INSERT INTO `cities` VALUES (632600, '果洛藏族自治州', 630000);
INSERT INTO `cities` VALUES (632700, '玉树藏族自治州', 630000);
INSERT INTO `cities` VALUES (632800, '海西蒙古族藏族自治州', 630000);
INSERT INTO `cities` VALUES (640100, '银川市', 640000);
INSERT INTO `cities` VALUES (640200, '石嘴山市', 640000);
INSERT INTO `cities` VALUES (640300, '吴忠市', 640000);
INSERT INTO `cities` VALUES (640400, '固原市', 640000);
INSERT INTO `cities` VALUES (640500, '中卫市', 640000);
INSERT INTO `cities` VALUES (650100, '乌鲁木齐市', 650000);
INSERT INTO `cities` VALUES (650200, '克拉玛依市', 650000);
INSERT INTO `cities` VALUES (652100, '吐鲁番地区', 650000);
INSERT INTO `cities` VALUES (652200, '哈密地区', 650000);
INSERT INTO `cities` VALUES (652300, '昌吉回族自治州', 650000);
INSERT INTO `cities` VALUES (652700, '博尔塔拉蒙古自治州', 650000);
INSERT INTO `cities` VALUES (652800, '巴音郭楞蒙古自治州', 650000);
INSERT INTO `cities` VALUES (652900, '阿克苏地区', 650000);
INSERT INTO `cities` VALUES (653000, '克孜勒苏柯尔克孜自治', 650000);
INSERT INTO `cities` VALUES (653100, '喀什地区', 650000);
INSERT INTO `cities` VALUES (653200, '和田地区', 650000);
INSERT INTO `cities` VALUES (654000, '伊犁哈萨克自治州', 650000);
INSERT INTO `cities` VALUES (654200, '塔城地区', 650000);
INSERT INTO `cities` VALUES (654300, '阿勒泰地区', 650000);
INSERT INTO `cities` VALUES (659000, '省直辖行政单位', 650000);

-- ----------------------------
-- Table structure for company
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company`  (
  `id` smallint(5) UNSIGNED NOT NULL COMMENT 'id',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '公司名称',
  `logo` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'log',
  `province` int(6) UNSIGNED NOT NULL COMMENT '省份',
  `city` int(6) UNSIGNED NOT NULL COMMENT '城市',
  `area` int(6) UNSIGNED NOT NULL COMMENT '区县',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `company_areas_id`(`area`) USING BTREE,
  INDEX `company_cicies_id`(`city`) USING BTREE,
  INDEX `company_file_id`(`logo`) USING BTREE,
  INDEX `company_provinces_id`(`province`) USING BTREE,
  CONSTRAINT `company_areas_id` FOREIGN KEY (`area`) REFERENCES `areas` (`areaid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `company_cicies_id` FOREIGN KEY (`city`) REFERENCES `cities` (`cityid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `company_file_id` FOREIGN KEY (`logo`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `company_provinces_id` FOREIGN KEY (`province`) REFERENCES `provinces` (`provinceid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

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
  INDEX `id`(`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of employee
-- ----------------------------
INSERT INTO `employee` VALUES (11, '15166077180', 'E10ADC3949BA59ABBE56E057F20F883E', NULL);

-- ----------------------------
-- Table structure for employee_info
-- ----------------------------
DROP TABLE IF EXISTS `employee_info`;
CREATE TABLE `employee_info`  (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `province` int(6) UNSIGNED NOT NULL COMMENT '省份',
  `city` int(6) UNSIGNED NOT NULL COMMENT '市',
  `area` int(6) UNSIGNED NOT NULL COMMENT '区县',
  `head_image` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '头像',
  `company` smallint(6) UNSIGNED NOT NULL COMMENT '所属公司',
  INDEX `employee_id`(`id`) USING BTREE,
  INDEX `employee_province_id`(`province`) USING BTREE,
  INDEX `employee_city_id`(`city`) USING BTREE,
  INDEX `employee_area_id`(`area`) USING BTREE,
  INDEX `employee_file_id`(`head_image`) USING BTREE,
  INDEX `employee_company_id`(`company`) USING BTREE,
  CONSTRAINT `employee_area_id` FOREIGN KEY (`area`) REFERENCES `areas` (`areaid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `employee_city_id` FOREIGN KEY (`city`) REFERENCES `cities` (`cityid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `employee_company_id` FOREIGN KEY (`company`) REFERENCES `company` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `employee_file_id` FOREIGN KEY (`head_image`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `employee_id` FOREIGN KEY (`id`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `employee_province_id` FOREIGN KEY (`province`) REFERENCES `provinces` (`provinceid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for employee_right
-- ----------------------------
DROP TABLE IF EXISTS `employee_right`;
CREATE TABLE `employee_right`  (
  `id` tinyint(3) UNSIGNED NOT NULL COMMENT '权限id',
  `name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for employee_right_relation
-- ----------------------------
DROP TABLE IF EXISTS `employee_right_relation`;
CREATE TABLE `employee_right_relation`  (
  `user_id` smallint(5) UNSIGNED NOT NULL COMMENT '用户id',
  `right_id` tinyint(3) UNSIGNED NOT NULL COMMENT '权限id',
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `right_id`(`right_id`) USING BTREE,
  CONSTRAINT `employee_right_relation_ibfk_1` FOREIGN KEY (`right_id`) REFERENCES `employee_right` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `employee_right_relation_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
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
-- Records of file
-- ----------------------------
INSERT INTO `file` VALUES ('5514eddb820475931902c79e33830f65', 'jpeg', 'file', 'timg (1).jpeg');

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
-- Table structure for provinces
-- ----------------------------
DROP TABLE IF EXISTS `provinces`;
CREATE TABLE `provinces`  (
  `provinceid` int(6) UNSIGNED NOT NULL,
  `province` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`provinceid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '省份信息表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of provinces
-- ----------------------------
INSERT INTO `provinces` VALUES (110000, '北京市');
INSERT INTO `provinces` VALUES (120000, '天津市');
INSERT INTO `provinces` VALUES (130000, '河北省');
INSERT INTO `provinces` VALUES (140000, '山西省');
INSERT INTO `provinces` VALUES (150000, '内蒙古自治区');
INSERT INTO `provinces` VALUES (210000, '辽宁省');
INSERT INTO `provinces` VALUES (220000, '吉林省');
INSERT INTO `provinces` VALUES (230000, '黑龙江省');
INSERT INTO `provinces` VALUES (310000, '上海市');
INSERT INTO `provinces` VALUES (320000, '江苏省');
INSERT INTO `provinces` VALUES (330000, '浙江省');
INSERT INTO `provinces` VALUES (340000, '安徽省');
INSERT INTO `provinces` VALUES (350000, '福建省');
INSERT INTO `provinces` VALUES (360000, '江西省');
INSERT INTO `provinces` VALUES (370000, '山东省');
INSERT INTO `provinces` VALUES (410000, '河南省');
INSERT INTO `provinces` VALUES (420000, '湖北省');
INSERT INTO `provinces` VALUES (430000, '湖南省');
INSERT INTO `provinces` VALUES (440000, '广东省');
INSERT INTO `provinces` VALUES (450000, '广西壮族自治区');
INSERT INTO `provinces` VALUES (460000, '海南省');
INSERT INTO `provinces` VALUES (500000, '重庆市');
INSERT INTO `provinces` VALUES (510000, '四川省');
INSERT INTO `provinces` VALUES (520000, '贵州省');
INSERT INTO `provinces` VALUES (530000, '云南省');
INSERT INTO `provinces` VALUES (540000, '西藏自治区');
INSERT INTO `provinces` VALUES (610000, '陕西省');
INSERT INTO `provinces` VALUES (620000, '甘肃省');
INSERT INTO `provinces` VALUES (630000, '青海省');
INSERT INTO `provinces` VALUES (640000, '宁夏回族自治区');
INSERT INTO `provinces` VALUES (650000, '新疆维吾尔自治区');
INSERT INTO `provinces` VALUES (710000, '台湾省');
INSERT INTO `provinces` VALUES (810000, '香港特别行政区');
INSERT INTO `provinces` VALUES (820000, '澳门特别行政区');

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
