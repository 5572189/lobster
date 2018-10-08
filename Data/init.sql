SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for oc_admin_user
-- ----------------------------
CREATE TABLE `oc_admin_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'UID',
  `user_type` int(11) NOT NULL DEFAULT '1' COMMENT '用户类型',
  `nickname` varchar(63) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '昵称',
  `surname` varchar(50) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '姓',
  `username` varchar(31) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(63) NOT NULL DEFAULT '' COMMENT '密码',
  `email` varchar(63) DEFAULT '' COMMENT '邮箱',
  `email_bind` tinyint(1) NOT NULL DEFAULT '0' COMMENT '邮箱验证',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `extra_mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '额外手机',
  `avatar` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '头像',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0未填1男2女',
  `birthday` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '生日',
  `score` decimal(11,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '积分',
  `total_score` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '总积分',
  `invoice_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '可开发票额度',
  `coin` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '金币',
  `luckymoney` float(10,2) NOT NULL DEFAULT '0.00' COMMENT '红包佣金',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '总收益佣金',
  `can_get_money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '可提佣金',
  `get_money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '已取佣金',
  `freeze_money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '冻结佣金',
  `cash_on_delivery` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否 支持货到付款 1-支持 0-不支持',
  `reg_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `reg_ip_address` varchar(50) NOT NULL DEFAULT '' COMMENT '注册时获取的IP地址',
  `reg_country` varchar(20) DEFAULT NULL COMMENT '注册国家',
  `reg_province` varchar(20) DEFAULT NULL COMMENT '注册省',
  `reg_city` varchar(20) DEFAULT NULL COMMENT '注册市',
  `reg_type` varchar(15) NOT NULL DEFAULT '' COMMENT '注册方式',
  `login_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '最后登陆IP',
  `login_ip_address` varchar(50) DEFAULT NULL COMMENT '最后登陆的IP地址',
  `wxqrcode` varchar(255) NOT NULL DEFAULT '' COMMENT '二维码',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '状态1正常;2冻结个人用户,企业禁用;99门店人员离职;',
  `recUid` int(10) unsigned DEFAULT '0' COMMENT '推荐用户id',
  `new_media_id` int(10) DEFAULT '0' COMMENT '新媒体ID',
  `sale_id` int(10) unsigned DEFAULT '0' COMMENT '经理id',
  `insep_id` int(10) unsigned DEFAULT '0' COMMENT '老板ID',
  `shop_id` int(10) unsigned DEFAULT '0' COMMENT '店铺id',
  `shop_bind_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺绑定时间',
  `sex` varchar(5) DEFAULT NULL COMMENT '性别',
  `is_login` int(5) NOT NULL DEFAULT '0' COMMENT '登录状态 0、退出 1、在线 2、被踢出',
  `level` int(5) NOT NULL DEFAULT '1' COMMENT '等级0、粉丝 1、普通会员 2、VIP',
  `openid` varchar(50) NOT NULL COMMENT 'openid',
  `admin_nick` varchar(50) NOT NULL COMMENT '门店角色昵称',
  `admin_level` int(5) NOT NULL COMMENT '门店角色 1、服务员 2、经理 3、老板',
  `num` varchar(15) NOT NULL COMMENT '推荐码',
  `pay_code` varchar(15) NOT NULL COMMENT '支付码',
  `pay_code_time` datetime NOT NULL COMMENT '支付吗失效时间',
  `card_level_expire` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '等级过期时间',
  `card_level` tinyint(2) DEFAULT '0' COMMENT '会员级别0、默认 1、樽享会员 2、金樽会员3、至樽会员',
  `card_read_level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '会员当前已弹窗等级索引',
  `withdraw` decimal(11,2) DEFAULT '0.00' COMMENT '总提现金额',
  `ignored` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '等级忽略金币',
  `degrade_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '降级时间',
  `last_consume` int(10) unsigned DEFAULT '0' COMMENT '最后消费时间',
  `agent_from` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1微信2wap5线下活动6安卓',
  `birthday_date` date DEFAULT '0000-00-00' COMMENT '生日日期',
  `source` int(11) DEFAULT '0' COMMENT '用户注册来源类型：\r\n0、默认；\r\n22、优惠券；\r\n----[old]用户注册途径 0、默认；\r\n1、优惠券；\r\n2、微信公众号；\r\n3、礼卡；\r\n4、蚝派；\r\n5、微信送礼；\r\n7、tbc；\r\n8、公众号储值入口；\r\n9、点餐系统；\r\n10、吃喝玩乐在北京；\r\n11、北京吃货V;\r\n12、餐厅预定;\r\n13、领取grille&TP开业5折优惠券；\r\n14、pizzagram；\r\n15、莫尔顿扒房(深圳)开业；\r\n16、2018祈福送积分活动；\r\n17、商城购物-列表页弹框；\r\n18、商城购物-详情页弹框；\r\n19、TBC；\r\n20、Galleria下午茶券；\r\n21、莫尔顿扒房特惠套餐；',
  `source_id` tinyint(3) DEFAULT '0' COMMENT '用户注册来源id: 0:默认;source=22,数值为优惠券ID',
  `android_code` varchar(20) DEFAULT NULL,
  `ios_code` varchar(20) DEFAULT NULL,
  `enterprise_id` int(10) NOT NULL DEFAULT '0' COMMENT '企业父级ID',
  `online_money` double(10,2) DEFAULT '0.00' COMMENT '线上消费总额',
  `unline_money` double(10,2) DEFAULT '0.00' COMMENT '线下消费总额',
  `staff` tinyint(4) DEFAULT '0' COMMENT '是否公司员工0否1是',
  `deviceId` varchar(255) DEFAULT NULL COMMENT '用户唯一标识(推送消息专用)',
  `is_erp` tinyint(1) DEFAULT '0' COMMENT 'ERP系统中是否已经存在该用户：1存在；',
  `platfrom` varchar(10) NOT NULL DEFAULT '' COMMENT '平台如ns、pizza、tbc',
  `wx_openid` varchar(30) NOT NULL DEFAULT '' COMMENT '微信openid',
  `alipay_id` varchar(30) NOT NULL DEFAULT '' COMMENT '支付宝授权ID',
  `comprehensive_province` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '综合各个数据获取的用户所属地区',
  `province_from` tinyint(4) NOT NULL DEFAULT '0' COMMENT '会员归属地获取来源',
  `health` varchar(30) DEFAULT '' COMMENT '健康证ID',
  `invoice_num_1` int(10) DEFAULT '0' COMMENT '可开发票额度(原有数据)',
  `invoice_num_2` int(10) DEFAULT NULL COMMENT '可开发票额度New',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `ocau_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=38684 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='用户账号表';

CREATE TABLE `oc_admin_access` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `group` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '管理员用户组',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=561 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='后台管理员与用户组对应关系表';

CREATE TABLE `oc_admin_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '部门ID',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上级部门ID',
  `title` varchar(31) NOT NULL DEFAULT '' COMMENT '部门名称',
  `icon` varchar(31) NOT NULL DEFAULT '' COMMENT '图标',
  `menu_auth` text NOT NULL COMMENT '权限列表',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='部门信息表';

CREATE TABLE `oc_admin_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '配置标题',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '配置名称',
  `value` text NOT NULL COMMENT '配置值',
  `group` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组',
  `type` varchar(16) NOT NULL DEFAULT '' COMMENT '配置类型',
  `options` varchar(255) NOT NULL DEFAULT '' COMMENT '配置额外值',
  `tip` varchar(100) NOT NULL DEFAULT '' COMMENT '配置说明',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='系统配置表';

INSERT INTO `oc_admin_user` (`id`, `user_type`, `nickname`, `surname`, `username`, `password`, `email`, `email_bind`, `mobile`, `extra_mobile`, `avatar`, `gender`, `birthday`, `score`, `total_score`, `invoice_num`, `coin`, `luckymoney`, `money`, `can_get_money`, `get_money`, `freeze_money`, `cash_on_delivery`, `reg_ip`, `reg_ip_address`, `reg_country`, `reg_province`, `reg_city`, `reg_type`, `login_ip`, `login_ip_address`, `wxqrcode`, `create_time`, `update_time`, `status`, `recUid`, `new_media_id`, `sale_id`, `insep_id`, `shop_id`, `shop_bind_time`, `sex`, `is_login`, `level`, `openid`, `admin_nick`, `admin_level`, `num`, `pay_code`, `pay_code_time`, `card_level_expire`, `card_level`, `card_read_level`, `withdraw`, `ignored`, `degrade_time`, `last_consume`, `agent_from`, `birthday_date`, `source`, `source_id`, `android_code`, `ios_code`, `enterprise_id`, `online_money`, `unline_money`, `staff`, `deviceId`, `is_erp`, `platfrom`, `wx_openid`, `alipay_id`, `comprehensive_province`, `province_from`, `health`, `invoice_num_1`, `invoice_num_2`) VALUES ('1', '1', '超级管理员', '', 'admin133', '8c0945819a9629261ce5ace62e385979', '', '0', '', '0', '0', '0', '0', '1640.06', '0.00', '0', '0', '0.00', '32.00', '100.00', '0.00', '0.00', '1', '0', '', NULL, NULL, NULL, '', '0', NULL, '', '1438651748', '1438651748', '1', '0', '0', '0', '0', NULL, '0', '', '0', '2', '', '', '0', '', '', '0000-00-00 00:00:00', '0', '0', '0', '0.00', '0.00', '0', '0', '1', '0000-00-00', '0', '0', NULL, NULL, '0', '0.00', '0.00', '0', NULL, '0', '', '', '', '', '0', '', '0', '0');
INSERT INTO `oc_admin_access` (`id`, `uid`, `group`, `create_time`, `update_time`, `sort`, `status`) VALUES ('1', '1', '1', '1438651748', '1438651748', '0', '1');
INSERT INTO `oc_admin_group` (`id`, `pid`, `title`, `icon`, `menu_auth`, `create_time`, `update_time`, `sort`, `status`) VALUES ('1', '0', '超级管理员', '', '', '1426881003', '1427552428', '0', '1');

INSERT INTO `oc_admin_config` VALUES ('1', '站点开关', 'TOGGLE_WEB_SITE', '1', '1', 'select', '0:关闭\r\n1:开启', '站点关闭后将不能访问', '1378898976', '1406992386', '1', '1');
INSERT INTO `oc_admin_config` VALUES ('2', '网站标题', 'WEB_SITE_TITLE', 'Noble Spirits', '1', 'text', '', '网站标题前台显示标题', '1378898976', '1379235274', '2', '1');
INSERT INTO `oc_admin_config` VALUES ('3', '网站口号', 'WEB_SITE_SLOGAN', 'Noble Spirits', '1', 'text', '', '网站口号、宣传标语、一句话介绍', '1434081649', '1434081649', '3', '0');
INSERT INTO `oc_admin_config` VALUES ('4', '网站LOGO', 'WEB_SITE_LOGO', '129', '1', 'picture', '', '网站LOGO', '1407003397', '1407004692', '4', '0');
INSERT INTO `oc_admin_config` VALUES ('5', '网站描述', 'WEB_SITE_DESCRIPTION', 'Noble Spirits', '1', 'textarea', '', '网站搜索引擎描述', '1378898976', '1379235841', '5', '1');
INSERT INTO `oc_admin_config` VALUES ('6', '网站关键字', 'WEB_SITE_KEYWORD', 'Noble Spirits', '1', 'textarea', '', '网站搜索引擎关键字', '1378898976', '1381390100', '6', '1');
INSERT INTO `oc_admin_config` VALUES ('7', '版权信息', 'WEB_SITE_COPYRIGHT', 'Copyright © Nobles All rights reserved.', '1', 'text', '', '设置在网站底部显示的版权信息，如“版权所有 © 2014-2015 科斯克网络科技”', '1406991855', '1406992583', '7', '0');
INSERT INTO `oc_admin_config` VALUES ('8', '网站备案号', 'WEB_SITE_ICP', '', '1', 'text', '', '设置在网站底部显示的备案号，如“苏ICP备1502009-2号\"', '1378900335', '1415983236', '8', '0');
INSERT INTO `oc_admin_config` VALUES ('9', '站点统计', 'WEB_SITE_STATISTICS', '', '1', 'textarea', '', '支持百度、Google、cnzz等所有Javascript的统计代码', '1378900335', '1415983236', '9', '0');
INSERT INTO `oc_admin_config` VALUES ('10', '首页地址', 'INDEX_URL', '', '1', 'text', '', '可以通过配置此项自定义系统首页的地址，比如：http://www.opencmf.cn/user/index.html', '1415983236', '1415983236', '10', '0');
INSERT INTO `oc_admin_config` VALUES ('11', '文件上传大小', 'UPLOAD_FILE_SIZE', '10', '2', 'num', '', '文件上传大小单位：MB', '1428681031', '1428681031', '1', '1');
INSERT INTO `oc_admin_config` VALUES ('12', '图片上传大小', 'UPLOAD_IMAGE_SIZE', '1', '2', 'num', '', '图片上传大小单位：MB', '1428681071', '1428681071', '2', '1');
INSERT INTO `oc_admin_config` VALUES ('13', '后台多标签', 'ADMIN_TABS', '0', '2', 'radio', '0:关闭\r\n1:开启', '', '1453445526', '1453445526', '3', '0');
INSERT INTO `oc_admin_config` VALUES ('14', '分页数量', 'ADMIN_PAGE_ROWS', '15', '2', 'num', '', '分页时每页的记录数', '1434019462', '1434019481', '4', '1');
INSERT INTO `oc_admin_config` VALUES ('15', '后台主题', 'ADMIN_THEME', 'blue', '2', 'select', 'default:默认主题\r\nblue:蓝色理想\r\ngreen:绿色生活', '后台界面主题', '1436678171', '1436690570', '5', '1');
INSERT INTO `oc_admin_config` VALUES ('16', '开发模式', 'DEVELOP_MODE', '0', '3', 'select', '1:开启\r\n0:关闭', '开发模式下会显示菜单管理、配置管理、数据字典等开发者工具', '1432393583', '1432393583', '1', '1');
INSERT INTO `oc_admin_config` VALUES ('17', '是否显示页面Trace', 'SHOW_PAGE_TRACE', '0', '3', 'select', '0:关闭\r\n1:开启', '是否显示页面Trace信息', '1387165685', '1387165685', '2', '1');
INSERT INTO `oc_admin_config` VALUES ('18', '系统加密KEY', 'AUTH_KEY', '_<tPd[A?#~Pe<]$jwIC+}>]X.[l<dJ=o\"qFM[;agaVXi+DI<F%TC#WJ:gkKyim{S', '3', 'textarea', '', '轻易不要修改此项，否则容易造成用户无法登录；如要修改，务必备份原key', '1438647773', '1438647815', '3', '1');
INSERT INTO `oc_admin_config` VALUES ('19', 'URL模式', 'URL_MODEL', '3', '4', 'select', '0:普通模式\r\n1:PATHINFO模式\r\n2:REWRITE模式\r\n3:兼容模式', '', '1438423248', '1438423248', '1', '1');
INSERT INTO `oc_admin_config` VALUES ('20', '静态文件独立域名', 'STATIC_DOMAIN', '', '4', 'text', '', '静态文件独立域名一般用于在用户无感知的情况下平和的将网站图片自动存储到腾讯万象优图、又拍云等第三方服务。', '1438564784', '1438564784', '3', '1');
INSERT INTO `oc_admin_config` VALUES ('21', '配置分组', 'CONFIG_GROUP_LIST', '1:基本\r\n2:系统\r\n3:开发\r\n4:部署\r\n5:授权\r\n6:微信', '2', 'array', '', '配置分组', '1379228036', '1461664400', '5', '1');
INSERT INTO `oc_admin_config` VALUES ('22', '官网账号', 'CT_USERNAME', 'trial', '5', 'text', '', '官网登陆账号（支持用户名、邮箱、手机号）', '1438647815', '1438647815', '1', '1');
INSERT INTO `oc_admin_config` VALUES ('23', '官网密码', 'CT_PASSWORD', 'trial', '5', 'text', '', '官网密码', '1438647815', '1438647815', '2', '1');
INSERT INTO `oc_admin_config` VALUES ('24', '密钥', 'CT_SN', '', '5', 'textarea', '', '密钥请通过登陆http://www.opencmf.cn至个人中心获取', '1438647815', '1438647815', '3', '1');
INSERT INTO `oc_admin_config` VALUES ('25', '微信appid', 'wechat_appid', 'wx1a620fd4afca7168', '6', 'text', '', '', '1461664697', '1461737793', '1', '1');
INSERT INTO `oc_admin_config` VALUES ('26', '微信appsecret：', 'wechat_appsecret', '756a706fe047d4988ee74e67820c86ef', '6', 'text', '', '', '1461664821', '1461664821', '2', '1');
INSERT INTO `oc_admin_config` VALUES ('27', '微信apptoken', 'wechat_apptoken', 'nobles', '6', 'text', '', '', '1461736462', '1461738259', '3', '1');
INSERT INTO `oc_admin_config` VALUES ('28', '微信授权回调地址', 'wechat_url', '/Home/weixin/auth_back', '6', 'text', '', '', '1461737578', '1461824253', '4', '1');
INSERT INTO `oc_admin_config` VALUES ('29', '微信商户id', 'wechat_merchant_id', '1405452902', '6', 'text', '', '', '1461737605', '1461738364', '5', '1');
INSERT INTO `oc_admin_config` VALUES ('30', '微信商户key', 'wechat_key', '0E722EFAB57861F692373E8473EC1B47', '6', 'text', '', '', '1461737623', '1461738397', '6', '1');
INSERT INTO `oc_admin_config` VALUES ('31', '微信首次关注文案', 'wechat_first_subscribe', '欢迎关注Noble Spirits樽尚汇。', '6', 'textarea', '', '', '1461737656', '1461738408', '7', '1');
INSERT INTO `oc_admin_config` VALUES ('40', '钩子类型', 'HOOKS_TYPE', '1:视图\r\n2:模型', '2', 'array', '', '', '1468813490', '1468813552', '0', '1');
INSERT INTO `oc_admin_config` VALUES ('42', '踢下线时长', 'admin_login_time', '2', '6', 'num', '', '客户端踢下线后，过多后可再进行登录(单位：小时)', '1477386204', '1477386427', '0', '1');
INSERT INTO `oc_admin_config` VALUES ('43', '充值返点比', 'RECHARGE_REBATE_RATE', '1', '2', 'text', '', '', '1493021630', '1493021702', '1', '1');
INSERT INTO `oc_admin_config` VALUES ('45', '支付宝测试', 'ALIPAY_DEBUG', '1', '3', 'text', '0', '1代表金额变成0.01', '1500607820', '1500607870', '0', '1');
INSERT INTO `oc_admin_config` VALUES ('46', '每月提现限免额度', 'WITHDRAW_MONTH_TOP', '800', '2', 'num', '', '', '1505440276', '1505440276', '0', '1');
INSERT INTO `oc_admin_config` VALUES ('47', '提现税收比例', 'WITHDRAW_RATE', '20', '2', 'num', '', '', '1505440347', '1505440347', '0', '1');
INSERT INTO `oc_admin_config` VALUES ('48', '视屏文件大小', 'UPLOAD_VIDEO_SIZE', '20', '2', 'num', '', '文件上传大小单位：MB', '1507799067', '1507799067', '1', '1');

CREATE TABLE `oc_admin_module` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `lang` char(4) DEFAULT 'cn' COMMENT '语言版本：cn中文，en英文',
  `name` varchar(31) NOT NULL DEFAULT '' COMMENT '名称',
  `title` varchar(63) NOT NULL DEFAULT '' COMMENT '标题',
  `logo` varchar(63) NOT NULL DEFAULT '' COMMENT '图片图标',
  `icon` varchar(31) NOT NULL DEFAULT '' COMMENT '字体图标',
  `icon_color` varchar(7) NOT NULL DEFAULT '' COMMENT '字体图标颜色',
  `description` varchar(127) NOT NULL DEFAULT '' COMMENT '描述',
  `developer` varchar(31) NOT NULL DEFAULT '' COMMENT '开发者',
  `version` varchar(7) NOT NULL DEFAULT '' COMMENT '版本',
  `user_nav` longtext NOT NULL COMMENT '个人中心导航',
  `config` longtext NOT NULL COMMENT '配置',
  `admin_menu` longtext NOT NULL COMMENT '菜单节点',
  `is_system` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否允许卸载',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='模块功能表';
INSERT INTO `oc_admin_module` (`id`, `lang`, `name`, `title`, `logo`, `icon`, `icon_color`, `description`, `developer`, `version`, `user_nav`, `config`, `admin_menu`, `is_system`, `create_time`, `update_time`, `sort`, `status`) VALUES ('1', 'cn', 'Admin', '系统', '', 'fa fa-cog', '#3CA6F1', '核心系统', '诺伯丝聚酿国际贸易（上海）有限公司', '1.2.0', '', '', '{\"1\":{\"id\":\"1\",\"pid\":\"0\",\"title\":\"系统\",\"url\":\"\",\"icon\":\"fa fa-cog\"},\"2\":{\"pid\":\"1\",\"title\":\"系统功能\",\"icon\":\"fa fa-folder-open-o\",\"id\":\"2\"},\"3\":{\"pid\":\"2\",\"title\":\"系统设置\",\"icon\":\"fa fa-wrench\",\"url\":\"Admin\\/Config\\/group\",\"id\":\"3\"},\"4\":{\"pid\":\"3\",\"title\":\"修改设置\",\"url\":\"Admin\\/Config\\/groupSave\",\"id\":\"4\"},\"5\":{\"pid\":\"2\",\"title\":\"导航管理\",\"icon\":\"fa fa-map-signs\",\"url\":\"Admin\\/Nav\\/index\",\"id\":\"5\"},\"6\":{\"pid\":\"5\",\"title\":\"新增\",\"url\":\"Admin\\/Nav\\/add\",\"id\":\"6\"},\"7\":{\"pid\":\"5\",\"title\":\"编辑\",\"url\":\"Admin\\/Nav\\/edit\",\"id\":\"7\"},\"8\":{\"pid\":\"5\",\"title\":\"设置状态\",\"url\":\"Admin\\/Nav\\/setStatus\",\"id\":\"8\"},\"13\":{\"pid\":\"2\",\"title\":\"配置管理\",\"icon\":\"fa fa-cogs\",\"url\":\"Admin\\/Config\\/index\",\"id\":\"13\"},\"14\":{\"pid\":\"13\",\"title\":\"新增\",\"url\":\"Admin\\/Config\\/add\",\"id\":\"14\"},\"15\":{\"pid\":\"13\",\"title\":\"编辑\",\"url\":\"Admin\\/Config\\/edit\",\"id\":\"15\"},\"16\":{\"pid\":\"13\",\"title\":\"设置状态\",\"url\":\"Admin\\/Config\\/setStatus\",\"id\":\"16\"},\"17\":{\"pid\":\"2\",\"title\":\"上传管理\",\"icon\":\"fa fa-upload\",\"url\":\"Admin\\/Upload\\/index\",\"id\":\"17\"},\"18\":{\"pid\":\"17\",\"title\":\"上传文件\",\"url\":\"Admin\\/Upload\\/upload\",\"id\":\"18\"},\"19\":{\"pid\":\"17\",\"title\":\"删除文件\",\"url\":\"Admin\\/Upload\\/delete\",\"id\":\"19\"},\"20\":{\"pid\":\"17\",\"title\":\"设置状态\",\"url\":\"Admin\\/Upload\\/setStatus\",\"id\":\"20\"},\"21\":{\"pid\":\"17\",\"title\":\"下载远程图片\",\"url\":\"Admin\\/Upload\\/downremoteimg\",\"id\":\"21\"},\"22\":{\"pid\":\"17\",\"title\":\"文件浏览\",\"url\":\"Admin\\/Upload\\/fileManager\",\"id\":\"22\"},\"23\":{\"pid\":\"1\",\"title\":\"系统权限\",\"icon\":\"fa fa-folder-open-o\",\"id\":\"23\"},\"28\":{\"pid\":\"23\",\"title\":\"管理员管理\",\"icon\":\"fa fa-lock\",\"url\":\"Admin\\/Access\\/index\",\"id\":\"28\"},\"29\":{\"pid\":\"28\",\"title\":\"新增\",\"url\":\"Admin\\/Access\\/add\",\"id\":\"29\"},\"30\":{\"pid\":\"28\",\"title\":\"编辑\",\"url\":\"Admin\\/Access\\/edit\",\"id\":\"30\"},\"31\":{\"pid\":\"28\",\"title\":\"设置状态\",\"url\":\"Admin\\/Access\\/setStatus\",\"id\":\"31\"},\"32\":{\"pid\":\"23\",\"title\":\"用户组管理\",\"icon\":\"fa fa-sitemap\",\"url\":\"Admin\\/Group\\/index\",\"id\":\"32\"},\"33\":{\"pid\":\"32\",\"title\":\"新增\",\"url\":\"Admin\\/Group\\/add\",\"id\":\"33\"},\"34\":{\"pid\":\"32\",\"title\":\"编辑\",\"url\":\"Admin\\/Group\\/edit\",\"id\":\"34\"},\"35\":{\"pid\":\"32\",\"title\":\"设置状态\",\"url\":\"Admin\\/Group\\/setStatus\",\"id\":\"35\"},\"36\":{\"pid\":\"1\",\"title\":\"扩展中心\",\"icon\":\"fa fa-folder-open-o\",\"id\":\"36\"},\"44\":{\"pid\":\"36\",\"title\":\"功能模块\",\"icon\":\"fa fa-th-large\",\"url\":\"Admin\\/Module\\/index\",\"id\":\"44\"},\"45\":{\"pid\":\"44\",\"title\":\"安装\",\"url\":\"Admin\\/Module\\/install\",\"id\":\"45\"},\"46\":{\"pid\":\"44\",\"title\":\"卸载\",\"url\":\"Admin\\/Module\\/uninstall\",\"id\":\"46\"},\"47\":{\"pid\":\"44\",\"title\":\"更新信息\",\"url\":\"Admin\\/Module\\/updateInfo\",\"id\":\"47\"},\"48\":{\"pid\":\"44\",\"title\":\"设置状态\",\"url\":\"Admin\\/Module\\/setStatus\",\"id\":\"48\"},\"49\":{\"pid\":\"36\",\"title\":\"插件管理\",\"icon\":\"fa fa-th\",\"url\":\"Admin\\/Addon\\/index\",\"id\":\"49\"},\"50\":{\"pid\":\"49\",\"title\":\"安装\",\"url\":\"Admin\\/Addon\\/install\",\"id\":\"50\"},\"51\":{\"pid\":\"49\",\"title\":\"卸载\",\"url\":\"Admin\\/Addon\\/uninstall\",\"id\":\"51\"},\"52\":{\"pid\":\"49\",\"title\":\"运行\",\"url\":\"Admin\\/Addon\\/execute\",\"id\":\"52\"},\"53\":{\"pid\":\"49\",\"title\":\"设置\",\"url\":\"Admin\\/Addon\\/config\",\"id\":\"53\"},\"54\":{\"pid\":\"49\",\"title\":\"后台管理\",\"url\":\"Admin\\/Addon\\/adminList\",\"id\":\"54\"},\"55\":{\"pid\":\"54\",\"title\":\"新增数据\",\"url\":\"Admin\\/Addon\\/adminAdd\",\"id\":\"55\"},\"56\":{\"pid\":\"54\",\"title\":\"编辑数据\",\"url\":\"Admin\\/Addon\\/adminEdit\",\"id\":\"56\"},\"57\":{\"pid\":\"54\",\"title\":\"设置状态\",\"url\":\"Admin\\/Addon\\/setStatus\",\"id\":\"57\"},\"58\":{\"id\":\"58\",\"pid\":\"36\",\"title\":\"钩子管理\",\"url\":\"Admin\\/addon\\/hooks\",\"icon\":\"fa fa-th\"},\"59\":{\"id\":\"59\",\"pid\":\"58\",\"title\":\"新增\",\"url\":\"Admin\\/Addon\\/addHook\",\"icon\":\"\"},\"60\":{\"id\":\"60\",\"pid\":\"36\",\"title\":\"微信菜单\",\"url\":\"admin\\/wxmenu\\/index\",\"icon\":\"fa fa-comment\"},\"61\":{\"pid\":\"60\",\"title\":\"新增\",\"url\":\"Admin\\/Wxmenu\\/add\",\"icon\":\"fa \",\"id\":\"61\"},\"62\":{\"pid\":\"60\",\"title\":\"编辑\",\"url\":\"Admin\\/Wxmenu\\/edit\",\"icon\":\"fa \",\"id\":\"62\"},\"63\":{\"id\":\"63\",\"pid\":\"60\",\"title\":\"生成菜单\",\"url\":\"Admin\\/Wxmenu\\/build\",\"icon\":\"fa \"},\"64\":{\"pid\":\"58\",\"title\":\"编辑\",\"url\":\"admin\\/addon\\/edithook\",\"icon\":\"fa \",\"id\":\"64\"},\"65\":{\"pid\":\"3\",\"title\":\"清除缓存\",\"url\":\"admin\\/index\\/removeruntime\",\"icon\":\"fa\",\"id\":\"65\"},\"67\":{\"pid\":\"28\",\"title\":\"删除\",\"url\":\"admin\\/access\\/setstatus\\/status\\/delete\",\"icon\":\"fa \",\"id\":\"67\"}}', '1', '1438651748', '1525854943', '0', '1');
INSERT INTO `oc_admin_module` (`id`, `lang`, `name`, `title`, `logo`, `icon`, `icon_color`, `description`, `developer`, `version`, `user_nav`, `config`, `admin_menu`, `is_system`, `create_time`, `update_time`, `sort`, `status`) VALUES ('2', 'cn', 'Cms', 'CMS', '', 'fa fa-newspaper-o', '#9933FF', '门户模块', '上海俏思品牌设计有限公司', '1.2.0', '{\"center\":[{\"title\":\"我的文档\",\"icon\":\"fa fa-list\",\"url\":\"Cms\\/Index\\/my\"}]}', '{\"need_check\":\"0\",\"toggle_comment\":\"1\",\"group_list\":\"1:\\u9ed8\\u8ba4\",\"cate\":\"a:1\",\"taglib\":[\"Cms\"]}', '{\"1\":{\"id\":\"1\",\"pid\":\"0\",\"title\":\"CMS\",\"url\":\"\",\"icon\":\"fa fa-newspaper-o\"},\"2\":{\"pid\":\"1\",\"title\":\"内容管理\",\"icon\":\"fa fa-folder-open-o\",\"id\":\"2\"},\"4\":{\"pid\":\"2\",\"title\":\"文档模型\",\"icon\":\"fa fa-th-large\",\"url\":\"Cms\\/Type\\/index\",\"id\":\"4\"},\"5\":{\"pid\":\"4\",\"title\":\"新增\",\"url\":\"Cms\\/Type\\/add\",\"id\":\"5\"},\"6\":{\"pid\":\"4\",\"title\":\"编辑\",\"url\":\"Cms\\/Type\\/edit\",\"id\":\"6\"},\"7\":{\"pid\":\"4\",\"title\":\"设置状态\",\"url\":\"Cms\\/Type\\/setStatus\",\"id\":\"7\"},\"8\":{\"pid\":\"4\",\"title\":\"字段管理\",\"icon\":\"fa fa-database\",\"url\":\"Cms\\/Attribute\\/index\",\"id\":\"8\"},\"9\":{\"pid\":\"8\",\"title\":\"新增\",\"url\":\"Cms\\/Attribute\\/add\",\"id\":\"9\"},\"10\":{\"pid\":\"8\",\"title\":\"编辑\",\"url\":\"Cms\\/Attribute\\/edit\",\"id\":\"10\"},\"11\":{\"pid\":\"8\",\"title\":\"设置状态\",\"url\":\"Cms\\/Attribute\\/setStatus\",\"id\":\"11\"},\"12\":{\"pid\":\"2\",\"title\":\"栏目分类\",\"icon\":\"fa fa-navicon\",\"url\":\"Cms\\/Category\\/index\",\"id\":\"12\"},\"13\":{\"pid\":\"12\",\"title\":\"新增\",\"url\":\"Cms\\/Category\\/add\",\"id\":\"13\"},\"14\":{\"pid\":\"12\",\"title\":\"编辑\",\"url\":\"Cms\\/Category\\/edit\",\"id\":\"14\"},\"15\":{\"pid\":\"12\",\"title\":\"设置状态\",\"url\":\"Cms\\/Category\\/setStatus\",\"id\":\"15\"},\"16\":{\"pid\":\"2\",\"title\":\"文章管理\",\"icon\":\"fa fa-edit\",\"url\":\"Cms\\/Index\\/index\",\"id\":\"16\"},\"17\":{\"pid\":\"16\",\"title\":\"新增\",\"url\":\"Cms\\/Index\\/add\",\"id\":\"17\"},\"18\":{\"pid\":\"16\",\"title\":\"编辑\",\"url\":\"Cms\\/Index\\/edit\",\"id\":\"18\"},\"19\":{\"pid\":\"16\",\"title\":\"回收文章\",\"url\":\"Cms\\/Index\\/setStatus\\/status\\/recycle\",\"id\":\"19\"},\"39\":{\"pid\":\"12\",\"title\":\"编辑文章\",\"url\":\"cms\\/category\\/edit_with_tree\",\"icon\":\"fa \",\"id\":\"39\"}}', '0', '1453102270', '1525854941', '0', '1');
INSERT INTO `oc_admin_module` (`id`, `lang`, `name`, `title`, `logo`, `icon`, `icon_color`, `description`, `developer`, `version`, `user_nav`, `config`, `admin_menu`, `is_system`, `create_time`, `update_time`, `sort`, `status`) VALUES ('3', 'cn', 'Shop', '餐厅管理', '', 'fa fa-th', '#9933FF', '餐厅模块', '诺伯丝聚酿国际贸易（上海）有限公司', '1.0.0', '', '', '{\"1\":{\"id\":\"1\",\"pid\":\"0\",\"title\":\"餐厅\",\"url\":\"\",\"icon\":\"fa fa-th\"},\"2\":{\"pid\":\"1\",\"title\":\"餐厅管理\",\"icon\":\"fa fa-folder-open-o\",\"id\":\"2\"},\"3\":{\"pid\":\"2\",\"title\":\"餐厅列表\",\"icon\":\"\",\"url\":\"Shop\\/index\\/index\",\"id\":\"3\"},\"301\":{\"pid\":\"3\",\"title\":\"新增\",\"icon\":\"\",\"url\":\"Shop\\/index\\/add\",\"id\":\"301\"},\"302\":{\"pid\":\"3\",\"title\":\"编辑\",\"icon\":\"\",\"url\":\"Shop\\/index\\/edit\",\"id\":\"302\"},\"4\":{\"pid\":\"2\",\"title\":\"餐厅消费记录\",\"icon\":\"\",\"url\":\"Shop\\/consume\\/index\",\"id\":\"4\"},\"401\":{\"pid\":\"4\",\"title\":\"导出\",\"icon\":\"\",\"url\":\"Shop\\/consume\\/export\",\"id\":\"401\"}}', '0', '1519639769', '1525854939', '0', '1');
INSERT INTO `oc_admin_module` (`id`, `lang`, `name`, `title`, `logo`, `icon`, `icon_color`, `description`, `developer`, `version`, `user_nav`, `config`, `admin_menu`, `is_system`, `create_time`, `update_time`, `sort`, `status`) VALUES ('4', 'cn', 'User', '用户', '', 'fa fa-users', '#9933FF', '用户模块', '上海策汇信息科技有限公司', '1.2.0', '', '', '{\"1\":{\"id\":\"1\",\"pid\":\"0\",\"title\":\"用户\",\"url\":\"\",\"icon\":\"fa fa-users\"},\"2\":{\"pid\":\"1\",\"title\":\"用户管理\",\"icon\":\"fa fa-users\",\"id\":\"2\"},\"3\":{\"pid\":\"2\",\"title\":\"用户列表\",\"icon\":\"fa fa-users\",\"url\":\"User\\/wechat\\/index\",\"id\":\"3\"},\"301\":{\"pid\":\"3\",\"title\":\"导出\",\"icon\":\"fa fa-users\",\"url\":\"User\\/wechat\\/export\",\"id\":\"301\"},\"4\":{\"pid\":\"2\",\"title\":\"用户消费统计\",\"icon\":\"fa fa-users\",\"url\":\"User\\/consume\\/index\",\"id\":\"4\"}}', '0', '1519639769', '1525918341', '0', '1');

CREATE TABLE `oc_admin_theme` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '名称',
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '标题',
  `description` varchar(127) NOT NULL DEFAULT '' COMMENT '描述',
  `developer` varchar(32) NOT NULL DEFAULT '' COMMENT '开发者',
  `version` varchar(8) NOT NULL DEFAULT '' COMMENT '版本',
  `config` text COMMENT '主题配置',
  `current` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否当前主题',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='前台主题表';

CREATE TABLE `oc_admin_hook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '钩子ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '钩子名称',
  `description` text NOT NULL COMMENT '描述',
  `addons` varchar(255) NOT NULL DEFAULT '' COMMENT '钩子挂载的插件',
  `type` tinyint(4) unsigned NOT NULL DEFAULT '1' COMMENT '类型',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='钩子表';

CREATE TABLE `oc_admin_upload` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'UID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '文件名',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '文件路径',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '文件链接',
  `ext` char(4) NOT NULL DEFAULT '' COMMENT '文件类型',
  `size` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT '文件sha1编码',
  `location` varchar(15) NOT NULL DEFAULT '' COMMENT '文件存储位置',
  `download` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COMMENT='文件上传表';

CREATE TABLE `oc_admin_nav` (
  `id` int(11) unsigned NOT NULL COMMENT 'ID',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',
  `name` varchar(63) NOT NULL DEFAULT '' COMMENT '导航名称',
  `title` varchar(31) NOT NULL DEFAULT '' COMMENT '导航标题',
  `type` varchar(15) NOT NULL DEFAULT '0' COMMENT '导航类型',
  `value` varchar(127) NOT NULL DEFAULT '' COMMENT '导航值',
  `target` varchar(11) NOT NULL DEFAULT '' COMMENT '打开方式',
  `icon` varchar(32) NOT NULL DEFAULT '' COMMENT '图标',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='前台导航表';

CREATE TABLE `oc_admin_addon` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '插件名或标识',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '中文名',
  `description` text NOT NULL COMMENT '插件描述',
  `config` text COMMENT '配置',
  `author` varchar(32) NOT NULL DEFAULT '' COMMENT '作者',
  `version` varchar(8) NOT NULL DEFAULT '' COMMENT '版本号',
  `adminlist` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '是否有后台列表',
  `type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '插件类型',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '安装时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='插件表';

CREATE TABLE `oc_cms_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父分类ID',
  `group` tinyint(4) NOT NULL DEFAULT '0' COMMENT '分组',
  `doc_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '分类模型',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '分类名称',
  `entitle` varchar(60) DEFAULT NULL,
  `url` varchar(127) NOT NULL COMMENT '链接地址',
  `content` text NOT NULL COMMENT '内容',
  `content_en` text COMMENT '内容（英文）',
  `index_template` varchar(32) NOT NULL DEFAULT '' COMMENT '列表封面模版',
  `detail_template` varchar(32) NOT NULL DEFAULT '' COMMENT '详情页模版',
  `post_auth` tinyint(4) NOT NULL DEFAULT '0' COMMENT '投稿权限',
  `icon` varchar(32) NOT NULL DEFAULT '' COMMENT '缩略图',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='栏目分类表';

INSERT INTO `oc_cms_category` (`id`, `pid`, `group`, `doc_type`, `title`, `entitle`, `url`, `content`, `content_en`, `index_template`, `detail_template`, `post_auth`, `icon`, `create_time`, `update_time`, `sort`, `status`) VALUES ('6', '0', '1', '7', '新闻', '', '', '                            ', NULL, '', '', '1', '', '1511857629', '1511857629', '1', '1');

CREATE TABLE `oc_cms_attribute` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '字段名',
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '字段标题',
  `field` varchar(100) NOT NULL DEFAULT '' COMMENT '字段定义',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '数据类型',
  `value` varchar(100) NOT NULL DEFAULT '' COMMENT '字段默认值',
  `tip` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `show` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示',
  `options` varchar(255) NOT NULL DEFAULT '' COMMENT '参数',
  `doc_type` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '文档模型',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COMMENT='文档属性字段表';
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('1', 'cid', '分类', 'int(11) unsigned NOT NULL ', 'select', '0', '所属分类', '1', '', '0', '1383891233', '1384508336', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('2', 'uid', '用户ID', 'int(11) unsigned NOT NULL ', 'num', '0', '用户ID', '0', '', '0', '1383891233', '1384508336', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('3', 'view', '阅读量', 'varchar(255) NOT NULL', 'num', '0', '标签', '0', '', '0', '1413303715', '1413303715', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('4', 'comment', '评论数', 'int(11) unsigned NOT NULL ', 'num', '0', '评论数', '0', '', '0', '1383891233', '1383894927', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('5', 'good', '赞数', 'int(11) unsigned NOT NULL ', 'num', '0', '赞数', '0', '', '0', '1383891233', '1384147827', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('6', 'bad', '踩数', 'int(11) unsigned NOT NULL ', 'num', '0', '踩数', '0', '', '0', '1407646362', '1407646362', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('7', 'create_time', '创建时间', 'int(11) unsigned NOT NULL ', 'datetime', '0', '创建时间', '1', '', '0', '1383891233', '1383895903', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('8', 'update_time', '更新时间', 'int(11) unsigned NOT NULL ', 'datetime', '0', '更新时间', '0', '', '0', '1383891233', '1384508277', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('9', 'sort', '排序', 'int(11) unsigned NOT NULL ', 'num', '0', '用于显示的顺序', '1', '', '0', '1383891233', '1383895757', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('10', 'status', '数据状态', 'tinyint(4) NOT NULL ', 'radio', '1', '数据状态', '0', '-1:删除\r\n0:禁用\r\n1:正常', '0', '1383891233', '1384508496', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('11', 'pics', '主厨图片', 'varchar(32) NOT NULL', 'pictures', '', '请上传主厨详情封面图，建议尺寸：724*784', '1', '', '3', '1511853588', '1512037996', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('12', 'content', '主厨详细介绍', 'text', 'kindeditor', '', '', '1', '', '3', '1511853600', '1511853600', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('13', 'title', '菜名', 'varchar(128) NOT NULL', 'text', '', '', '1', '', '4', '1511853699', '1511853699', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('14', 'title_en', '菜名（英文）', 'varchar(128) NOT NULL', 'text', '', '', '1', '', '4', '1511853710', '1511853710', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('15', 'pic', '菜单图', 'int(11) UNSIGNED NOT NULL', 'picture', '', '请上传菜单图，建议尺寸324*324', '1', '', '4', '1511853723', '1521027721', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('16', 'title', '视频标题', 'varchar(128) NOT NULL', 'text', '', '', '1', '', '5', '1511856527', '1511856527', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('17', 'tag', '视频标签', 'varchar(128) NOT NULL', 'text', '', '', '1', '', '5', '1511856541', '1511856541', '0', '0');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('18', 'tracks', '时长', 'varchar(128) NOT NULL', 'text', '', '', '1', '', '5', '1511856560', '1511921121', '0', '0');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('19', 'file', '视频文件', 'varchar(32) NOT NULL', 'media', '', '请上传视频，视频大小建议在2M以内', '1', '', '5', '1511856582', '1521028516', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('20', 'title', '餐厅名称', 'varchar(128) NOT NULL', 'text', '', '', '1', '', '6', '1511856720', '1511856720', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('21', 'content', '餐厅介绍详情', 'text', 'kindeditor', '', '', '1', '', '6', '1511856733', '1511856733', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('22', 'open_hours', '营业时间', 'varchar(128) NOT NULL', 'text', '', '', '1', '', '6', '1511856753', '1511856753', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('23', 'address', '地址详情', 'varchar(128) NOT NULL', 'text', '', '', '1', '', '6', '1511856771', '1511943681', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('24', 'telephone', '电话', 'varchar(128) NOT NULL', 'text', '', '', '1', '', '6', '1511856783', '1511856783', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('25', 'pics', '环境详情页图片', 'varchar(32) NOT NULL', 'pictures', '', '请上传环境详情页图片（多图），建议尺寸：宽344px，高500px以内', '1', '', '6', '1511856861', '1512037705', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('26', 'title', '标题', 'varchar(128) NOT NULL', 'text', '', '', '1', '', '7', '1511856932', '1511856932', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('27', 'cover', '列表页封面图', 'int(11) UNSIGNED NOT NULL', 'picture', '', '请上传列表页封面图，建议尺寸：750*472', '1', '', '7', '1511856958', '1512038134', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('28', 'content', '内容', 'text', 'kindeditor', '', '', '1', '', '7', '1511857099', '1511857099', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('29', 'title', '标题', 'varchar(128) NOT NULL', 'text', '', '', '1', '', '8', '1511857240', '1511857240', '0', '0');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('30', 'file', '视频文件', 'varchar(32) NOT NULL', 'media', '', '请上传视频，视频大小建议在2M以内', '1', '', '8', '1511857272', '1521028492', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('31', 'index_pic', '首页封面图', 'int(11) UNSIGNED NOT NULL', 'picture', '', '请上传首页封面图，建议尺寸：620*400', '1', '', '6', '1511858519', '1512037214', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('32', 'list_pic', '环境列表页封面图', 'int(11) UNSIGNED NOT NULL', 'picture', '', '请上传环境列表页封面图，建议尺寸：686*300', '1', '', '6', '1511859543', '1512037541', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('33', 'picture', '餐厅详情页主图', 'varchar(32) NOT NULL', 'pictures', '', '请上传餐厅详情页主图，建议尺寸：750*506', '1', '', '6', '1511860247', '1512037444', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('34', 'city', '城市', 'varchar(128) NOT NULL', 'text', '', '', '1', '', '6', '1511862910', '1511862910', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('35', 'cover', '视频封面', 'int(11) UNSIGNED NOT NULL', 'picture', '', '请上传视频封面，建议尺寸：650*378', '1', '', '8', '1512005937', '1512037166', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('36', 'cover', '视频封面', 'int(11) UNSIGNED NOT NULL', 'picture', '', '请上传视频封面，建议尺寸：750*340', '1', '', '5', '1512005967', '1512037842', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('37', 'title_en', '标题（英文）', 'varchar(128) NOT NULL', 'text', '', '', '1', '', '7', '1519904056', '1519904056', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('38', 'title', '中文描述', 'varchar(1000) NOT NULL', 'textarea', '', '', '1', '', '9', '1521202839', '1521203080', '0', '1');
INSERT INTO `oc_cms_attribute` (`id`, `name`, `title`, `field`, `type`, `value`, `tip`, `show`, `options`, `doc_type`, `create_time`, `update_time`, `sort`, `status`) VALUES ('39', 'title_en', '英文描述', 'varchar(1000) NOT NULL', 'textarea', '', '', '1', '', '9', '1521202857', '1521203072', '0', '1');


CREATE TABLE `oc_cms_type` (
  `id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT COMMENT '模型ID',
  `name` char(16) NOT NULL DEFAULT '' COMMENT '模型名称',
  `title` char(16) NOT NULL DEFAULT '' COMMENT '模型标题',
  `icon` varchar(32) NOT NULL DEFAULT '' COMMENT '缩略图',
  `main_field` int(11) NOT NULL DEFAULT '0' COMMENT '主要字段',
  `list_field` varchar(127) NOT NULL DEFAULT '' COMMENT '列表显示字段',
  `filter_field` varchar(127) NOT NULL DEFAULT '' COMMENT '前台筛选字段',
  `field_sort` varchar(255) NOT NULL COMMENT '表单字段排序',
  `field_group` varchar(255) NOT NULL DEFAULT '' COMMENT '表单字段分组',
  `system` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '系统类型',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='文档模型表';
INSERT INTO `oc_cms_type` (`id`, `name`, `title`, `icon`, `main_field`, `list_field`, `filter_field`, `field_sort`, `field_group`, `system`, `create_time`, `update_time`, `sort`, `status`) VALUES ('1', 'link', '链接', 'fa fa-link', '0', '', '', '', '', '1', '1426580628', '1426580628', '0', '1');
INSERT INTO `oc_cms_type` (`id`, `name`, `title`, `icon`, `main_field`, `list_field`, `filter_field`, `field_sort`, `field_group`, `system`, `create_time`, `update_time`, `sort`, `status`) VALUES ('2', 'page', '单页', 'fa fa-file-text', '0', '', '', '', '', '1', '1426580628', '1426580628', '0', '1');
INSERT INTO `oc_cms_type` (`id`, `name`, `title`, `icon`, `main_field`, `list_field`, `filter_field`, `field_sort`, `field_group`, `system`, `create_time`, `update_time`, `sort`, `status`) VALUES ('7', 'news', '新闻', '', '0', '26', '', '{\"1\":[\"1\",\"26\",\"37\",\"27\",\"28\",\"9\",\"7\"]}', '1:基础\r\n2:扩展', '0', '1511856891', '1521027465', '5', '1');

CREATE TABLE `oc_cms_index` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文档ID',
  `cid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `doc_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '文档类型ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发布者ID',
  `view` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '阅读量',
  `comment` int(11) NOT NULL DEFAULT '0' COMMENT '评论数',
  `good` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '赞数',
  `bad` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '踩数',
  `mark` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收藏',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='文档类型基础表';

CREATE TABLE `oc_wxmenu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang` char(4) DEFAULT 'cn' COMMENT '语言版本：cn中文，en英文',
  `fid` int(11) unsigned DEFAULT '0',
  `name` varchar(50) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0 链接 1关键字',
  `sort` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='微信菜单表';

CREATE TABLE `oc_cms_slider` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '幻灯ID',
  `lang` char(4) CHARACTER SET utf8 DEFAULT 'cn' COMMENT '语言版本：cn中文，en英文',
  `title` char(80) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '标题',
  `description` varchar(200) CHARACTER SET utf8 DEFAULT NULL COMMENT '描述',
  `cover` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '封面ID',
  `cover_en` int(11) DEFAULT NULL COMMENT '封面图（英文）',
  `url` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '点击链接',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `platform` tinyint(5) DEFAULT '1' COMMENT '1:(微信/pc)2:(ios/android\n)3:(微信/pc/ios/android)',
  `jump_page` tinyint(5) DEFAULT '1' COMMENT '跳转页面(1:商品分类2:商品详情3:H5嵌套页面)',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `content` longtext CHARACTER SET utf8 COMMENT '详情',
  `is_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `is_bg` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:有 0：无',
  `begin_time` datetime DEFAULT NULL COMMENT '开始时间',
  `end_time` datetime DEFAULT NULL COMMENT '结束时间',
  `disp_position` tinyint(1) NOT NULL DEFAULT '0' COMMENT '广告展示位 0-首页 1-其它',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT COMMENT='幻灯切换表';

CREATE TABLE `oc_cms_read_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `cid` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `create_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1315 DEFAULT CHARSET=utf8mb4;

CREATE TABLE `oc_restaurant` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(128) NOT NULL COMMENT '餐厅名称',
  `title_en` varchar(128) DEFAULT NULL COMMENT '餐厅名称',
  `content` text COMMENT '餐厅介绍详情',
  `open_hours` varchar(128) NOT NULL COMMENT '营业时间',
  `address` varchar(255) NOT NULL COMMENT '地址详情',
  `telephone` varchar(128) NOT NULL COMMENT '电话',
  `index_pic` int(11) unsigned NOT NULL COMMENT '首页封面图',
  `list_pic` int(11) unsigned NOT NULL COMMENT '环境列表页封面图',
  `picture` varchar(32) NOT NULL COMMENT '餐厅详情页主图',
  `pics` varchar(32) NOT NULL DEFAULT '' COMMENT '环境详情页图片',
  `city` varchar(128) NOT NULL COMMENT '城市name',
  `city_en` varchar(128) DEFAULT NULL COMMENT '城市name_en',
  `ns_shop_id` int(10) NOT NULL COMMENT 'NS对应的shop_id',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1启用；0禁用',
  `sort` smallint(2) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

CREATE TABLE `oc_sms_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(12) NOT NULL DEFAULT '' COMMENT '手机号',
  `code` varchar(10) NOT NULL DEFAULT '' COMMENT '验证码',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发送时间',
  `info` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3523 DEFAULT CHARSET=utf8mb4;