SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS  `api_user_ship`;
CREATE TABLE `api_user_ship` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0' COMMENT '用户id',
  `university_id` int(11) DEFAULT '0' COMMENT '大学id',
  `co_id` int(11) DEFAULT '0',
  `out_id` varchar(50) DEFAULT '' COMMENT '对应我们平台的openid',
  `total` int(11) DEFAULT '0' COMMENT '店铺数量',
  `amount` varchar(255) DEFAULT '',
  `inserttime` int(11) DEFAULT '0' COMMENT '操作时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING BTREE,
  KEY `university_id` (`university_id`) USING BTREE,
  KEY `out_id` (`out_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ERP发货统计表';

DROP TABLE IF EXISTS  `api_user_shop`;
CREATE TABLE `api_user_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0' COMMENT '用户id',
  `university_id` int(11) DEFAULT '0' COMMENT '大学id',
  `co_id` int(11) DEFAULT '0',
  `out_id` varchar(50) DEFAULT '' COMMENT '对应我们平台的openid',
  `total` int(11) DEFAULT '0' COMMENT '店铺数量',
  `shop` tinytext COMMENT '店铺简述',
  `inserttime` int(11) DEFAULT '0' COMMENT '操作时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING BTREE,
  KEY `university_id` (`university_id`) USING BTREE,
  KEY `out_id` (`out_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=558 DEFAULT CHARSET=utf8 COMMENT='ERP店铺统计表';

DROP TABLE IF EXISTS  `api_user_status`;
CREATE TABLE `api_user_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0' COMMENT '用户id',
  `shopstatus` int(11) DEFAULT '99',
  `shipstatus` int(11) DEFAULT '99',
  `inserttime` int(11) DEFAULT '0' COMMENT '操作时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='api数据状态表';

DROP TABLE IF EXISTS  `business`;
CREATE TABLE `business` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` varchar(100) DEFAULT '' COMMENT '商家A编号',
  `nick_name` varchar(100) DEFAULT '' COMMENT '商家',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态（1正常，0删除）',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='商家表';

DROP TABLE IF EXISTS  `business_task`;
CREATE TABLE `business_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` varchar(100) DEFAULT '' COMMENT '商家A编号',
  `type` tinyint(1) DEFAULT '1' COMMENT '类型',
  `grade` int(6) DEFAULT '1' COMMENT '等级',
  `free_amount` decimal(9,2) DEFAULT '0.00' COMMENT '此等级免费赠送的金额',
  `reach_amount` decimal(9,2) DEFAULT '0.00' COMMENT '此等级需要达到的金额',
  `total_amount` decimal(9,2) DEFAULT '0.00' COMMENT '总金额',
  `time` int(11) DEFAULT '0' COMMENT '写入时间',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态（1正常，0删除）',
  PRIMARY KEY (`id`),
  KEY `aid` (`aid`),
  KEY `grade` (`grade`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='商家任务表';

DROP TABLE IF EXISTS  `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `information_id` int(11) DEFAULT '0' COMMENT '资讯信息id',
  `university_name` varchar(32) DEFAULT '' COMMENT '创客大学名称',
  `uid` int(11) DEFAULT '0' COMMENT '用户id',
  `nickname` varchar(50) DEFAULT '' COMMENT '用户昵称',
  `avatar` varchar(150) DEFAULT NULL COMMENT '用户头像',
  `content` varchar(500) DEFAULT '' COMMENT '评论的内容',
  `parent` int(11) DEFAULT '0' COMMENT '父级',
  `floor` int(11) DEFAULT '0' COMMENT '楼层数',
  `likes` int(11) DEFAULT '0' COMMENT '喜欢,点赞',
  `starttime` int(11) DEFAULT '0' COMMENT '写入时间',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态（1正常，0删除）',
  PRIMARY KEY (`id`),
  KEY `information_id` (`information_id`),
  KEY `status` (`status`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8 COMMENT='评论';

DROP TABLE IF EXISTS  `connect`;
CREATE TABLE `connect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `information_id` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT '状态:1收藏0取消收藏',
  `updatetime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `information_id` (`information_id`),
  KEY `uid` (`uid`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8 COMMENT='用户收藏表';

DROP TABLE IF EXISTS  `course`;
CREATE TABLE `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(255) NOT NULL COMMENT '课程名称',
  `big_img` varchar(255) NOT NULL COMMENT '课程主图片',
  `teacher` varchar(20) DEFAULT NULL COMMENT '讲师',
  `plv` varchar(300) NOT NULL COMMENT '视频地址',
  `short_content` text,
  `small_img` varchar(255) DEFAULT NULL COMMENT '课程缩略图',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `create_id` int(11) DEFAULT NULL COMMENT '创建人员',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `update_id` int(11) DEFAULT NULL COMMENT '修改人员',
  `type` int(11) NOT NULL DEFAULT '1' COMMENT '类型',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态',
  `is_home` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS  `course_list`;
CREATE TABLE `course_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text COMMENT '内容',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`),
  KEY `type` (`type`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='课程表';

DROP TABLE IF EXISTS  `curriculum`;
CREATE TABLE `curriculum` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) DEFAULT '0' COMMENT '学校id',
  `date` int(11) DEFAULT '0' COMMENT '日期',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '课程名称',
  `f_subtitle` varchar(255) DEFAULT '' COMMENT '副标题',
  `f_starttime` int(11) DEFAULT '0' COMMENT '开始时间',
  `f_endtime` int(11) DEFAULT '0' COMMENT '结束时间',
  `f_teacher` varchar(25) DEFAULT '' COMMENT '老师',
  `t_subtitle` varchar(255) DEFAULT NULL COMMENT '副标题',
  `t_starttime` int(11) DEFAULT '0' COMMENT '开始时间',
  `t_endtime` int(11) DEFAULT '0' COMMENT '结束',
  `t_teacher` varchar(25) DEFAULT '' COMMENT '老师',
  `classroom` varchar(255) DEFAULT '' COMMENT '教室',
  `introduction` varchar(400) DEFAULT '' COMMENT '简介',
  `image` varchar(255) DEFAULT '' COMMENT '视频介绍图片',
  `plv` varchar(255) DEFAULT '',
  `week` int(11) DEFAULT '1' COMMENT '周（第几周）',
  `date_status` tinyint(1) DEFAULT '1' COMMENT '状态（1上午，2下午，3晚上）',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态（1正常，0不可用）',
  PRIMARY KEY (`id`),
  KEY `university_id` (`university_id`),
  KEY `week` (`week`),
  KEY `date_status` (`date_status`),
  KEY `date` (`date`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=495 DEFAULT CHARSET=utf8 COMMENT='课程';

DROP TABLE IF EXISTS  `curriculum_mark`;
CREATE TABLE `curriculum_mark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `curriculum_id` int(11) DEFAULT '0' COMMENT '课程id',
  `uid` int(11) DEFAULT '0' COMMENT '用户ID',
  `mark_ids` text COMMENT '问题ID串',
  `mark` text COMMENT '问题星级或答案',
  `inserttime` int(11) DEFAULT '0' COMMENT '操作时间',
  PRIMARY KEY (`id`),
  KEY `curriculum_id` (`curriculum_id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=utf8 COMMENT='打分表';

DROP TABLE IF EXISTS  `curriculum_marktotal`;
CREATE TABLE `curriculum_marktotal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `curriculum_id` int(11) DEFAULT '0' COMMENT '课程id',
  `mark_id` int(11) DEFAULT '0' COMMENT '打分问题id',
  `one` int(11) DEFAULT '0' COMMENT '问题的一星级总数',
  `two` int(11) DEFAULT '0' COMMENT '问题的二星级总数',
  `three` int(11) DEFAULT '0' COMMENT '问题的三星级总数',
  `four` int(11) DEFAULT '0' COMMENT '问题的四星级总数',
  `five` int(11) DEFAULT '0' COMMENT '问题的五星级总数',
  `inserttime` int(11) DEFAULT '0' COMMENT '操作时间',
  PRIMARY KEY (`id`),
  KEY `curriculum_id` (`curriculum_id`) USING BTREE,
  KEY `mark_id` (`mark_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=331 DEFAULT CHARSET=utf8 COMMENT='打分统计表';

DROP TABLE IF EXISTS  `dict`;
CREATE TABLE `dict` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dict_no` int(11) DEFAULT NULL,
  `dict_value` varchar(255) DEFAULT NULL,
  `dict_name` varchar(255) DEFAULT NULL,
  `memo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS  `glod_standard`;
CREATE TABLE `glod_standard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openId` varchar(100) DEFAULT '0' COMMENT '用户id',
  `uid` int(11) DEFAULT '0' COMMENT '用户ID',
  `semester_id` int(11) DEFAULT '0' COMMENT '学期数',
  `status` int(11) DEFAULT '0' COMMENT '状态:0未达标1已达标',
  `inserttime` int(11) DEFAULT '0' COMMENT '第一次写放时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='金豆学期达标';

DROP TABLE IF EXISTS  `information`;
CREATE TABLE `information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型:（1热闻，2广播，3活动）',
  `datetime` int(11) DEFAULT '0' COMMENT '活动时间',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text COMMENT '内容',
  `adimage` varchar(255) DEFAULT NULL COMMENT '课程表页的活动图',
  `image` varchar(255) DEFAULT '' COMMENT '图片',
  `sponsor` varchar(50) NOT NULL DEFAULT '' COMMENT '主办方',
  `place` varchar(50) NOT NULL DEFAULT '' COMMENT '地点',
  `count` int(11) DEFAULT '0' COMMENT '评论总数',
  `likes` int(11) NOT NULL DEFAULT '0' COMMENT '点赞，喜欢',
  `comment` int(11) NOT NULL DEFAULT '0' COMMENT '评论数',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态（1正常，0删除）',
  `starttime` int(10) DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COMMENT='新闻，资讯';

DROP TABLE IF EXISTS  `lecturer`;
CREATE TABLE `lecturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_name` varchar(50) DEFAULT '' COMMENT '学校',
  `university_id` int(11) DEFAULT '0' COMMENT '大学id',
  `type` tinyint(1) DEFAULT '1' COMMENT '类型(1讲师，2校务)',
  `name` varchar(50) DEFAULT '' COMMENT '姓名',
  `sex` tinyint(1) DEFAULT '0' COMMENT '性别：1男2女',
  `marry` tinyint(1) DEFAULT NULL COMMENT '婚姻状况(1：已婚，2：未婚)',
  `city` varchar(255) DEFAULT NULL COMMENT '意向服务城市',
  `address` varchar(255) DEFAULT NULL COMMENT '常驻地区',
  `birth_date` int(11) DEFAULT '0' COMMENT '出生年月',
  `phone` varchar(255) DEFAULT NULL COMMENT '联系方式(手机号)',
  `tell` varchar(100) DEFAULT '0' COMMENT '电话',
  `political` varchar(20) DEFAULT '' COMMENT '政治面貌',
  `hukou` varchar(255) DEFAULT '' COMMENT '户口所在地',
  `education` varchar(20) DEFAULT '' COMMENT '学历',
  `report_number` varchar(30) DEFAULT '' COMMENT '证书编号',
  `card_number` varchar(30) DEFAULT '' COMMENT '身份证号',
  `certificate_time` int(11) DEFAULT '0' COMMENT '新华创客讲师证书取得时间',
  `team_role` varchar(30) DEFAULT '' COMMENT '团队角色',
  `speciality` varchar(50) DEFAULT '' COMMENT '特长',
  `work_date` int(11) DEFAULT '0' COMMENT '上岗日期',
  `job_change` varchar(255) DEFAULT '' COMMENT '岗位变更记录',
  `appraisal_records` varchar(255) DEFAULT '' COMMENT '考核记录',
  `nickname` varchar(30) DEFAULT '' COMMENT '讲师花名',
  `qq` varchar(20) DEFAULT '0' COMMENT 'QQ号',
  `wechat` varchar(255) DEFAULT NULL COMMENT '微信号',
  `email` varchar(30) DEFAULT '' COMMENT '电子邮箱',
  `school` varchar(255) DEFAULT NULL COMMENT '毕业所在学校',
  `contact_relationship` varchar(255) DEFAULT NULL COMMENT '与紧急联系人关系',
  `contact_name` varchar(255) DEFAULT NULL COMMENT '紧急联系人',
  `professional` varchar(255) DEFAULT NULL COMMENT '所学专业',
  `teacher_number` varchar(30) DEFAULT NULL COMMENT '讲师编号',
  `remark` varchar(255) DEFAULT '' COMMENT '备注信息',
  `avatar` varchar(255) DEFAULT NULL COMMENT '考核记录',
  `inserttime` int(11) DEFAULT NULL,
  `business_content` text COMMENT '从业经历',
  `teaching_content` text COMMENT '授课经历',
  `evaluation` text COMMENT '自我评价',
  `img` varchar(255) DEFAULT NULL COMMENT '头像',
  `goodat` varchar(255) DEFAULT NULL COMMENT '擅长类目',
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '状态（1：未审核，2：已审核，3：作废（禁用））',
  `is_home` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='师讲表';

DROP TABLE IF EXISTS  `log_video`;
CREATE TABLE `log_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) DEFAULT '0',
  `curriculum_id` int(11) DEFAULT '0' COMMENT '课程id',
  `curriculum_name` varchar(100) DEFAULT '' COMMENT '课程名称',
  `uid` int(11) DEFAULT '0' COMMENT '用户ID',
  `status` int(11) DEFAULT '1' COMMENT '状态:1成功0失败',
  `inserttime` int(11) DEFAULT '0' COMMENT '签到时间',
  `datetime` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `university_id` (`university_id`),
  KEY `curriculum_id` (`curriculum_id`),
  KEY `datetime` (`datetime`)
) ENGINE=InnoDB AUTO_INCREMENT=11161 DEFAULT CHARSET=utf8 COMMENT='视频点播表';

DROP TABLE IF EXISTS  `mark`;
CREATE TABLE `mark` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `curriculum_id` int(11) DEFAULT '0' COMMENT '课程id默认都为0',
  `type` tinyint(4) DEFAULT '0' COMMENT '问题类型0评星1答题',
  `content` text COMMENT '问题',
  `status` int(11) DEFAULT '1' COMMENT '状态:1成功0失败',
  `inserttime` int(11) DEFAULT '0' COMMENT '操作时间',
  PRIMARY KEY (`id`),
  KEY `type` (`type`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='打分问题表';

DROP TABLE IF EXISTS  `qm_access_token`;
CREATE TABLE `qm_access_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_token` varchar(32) DEFAULT NULL,
  `refresh_token` varchar(32) DEFAULT NULL,
  `aid` varchar(50) DEFAULT NULL COMMENT '千米A编号',
  `time` int(11) DEFAULT NULL COMMENT '入库时间',
  `expires_in` int(11) DEFAULT NULL COMMENT '过期时效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='千米授权access_token';

DROP TABLE IF EXISTS  `qm_member`;
CREATE TABLE `qm_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` varchar(20) DEFAULT NULL,
  `member_nick` varchar(32) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `mobile` varchar(18) DEFAULT NULL,
  `admin_id` varchar(20) DEFAULT NULL,
  `own_openId` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='千米商家会员';

DROP TABLE IF EXISTS  `qm_orders`;
CREATE TABLE `qm_orders` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `aid` varchar(32) DEFAULT NULL COMMENT '千米A编号',
  `tid` varchar(50) DEFAULT '' COMMENT '订单编号',
  `payment` decimal(9,2) DEFAULT '0.00' COMMENT '买家实际已支付金额',
  `num` int(5) DEFAULT '0' COMMENT '商品数量',
  `reciver_name` varchar(50) DEFAULT '' COMMENT '姓名',
  `reciver_address` varchar(255) DEFAULT '' COMMENT '地址',
  `reciver_mobile` varchar(50) DEFAULT '' COMMENT '手机号',
  `pay_time` varchar(255) DEFAULT '' COMMENT '买家付款时间格式：yyyy-MM-dd HH:mm:ss',
  `end_time` varchar(255) DEFAULT '' COMMENT '交易完结时间',
  `buyer_nick` varchar(100) DEFAULT '' COMMENT '买家会员编号',
  `pay_order_no` varchar(100) DEFAULT '' COMMENT '千米网支付单编号',
  `total_trade_fee` decimal(9,2) DEFAULT '0.00' COMMENT '订单交易总额，商品总额(total_fee) 减去 优惠总额(discount_fee) 再加上 物流总额(post_fee), 单位：元，2位小数',
  `pay_status` tinyint(2) DEFAULT '0' COMMENT '订单支付状态, -1:全部, 0:未支付, 1:已支付, 2:已退款,4:部分退款',
  `deliver_status` tinyint(2) DEFAULT '0' COMMENT '订单发货状态, -1:全部, 0:未发货, 1:已发货, 2:已退货,3:部分发货,4:部分退货',
  `complete_status` tinyint(2) DEFAULT '0' COMMENT '订单完成状态, -1:全部, 0:进行中, 1:已完成, 2:已作废',
  `seller_nick_name` varchar(50) DEFAULT '' COMMENT '商家登录账号',
  `own_openId` varchar(100) DEFAULT '' COMMENT '用户openId',
  `own_updatetime` int(11) DEFAULT '0' COMMENT '更新时间',
  `own_addtime` int(11) DEFAULT '0' COMMENT '入库时间',
  `own_status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tid` (`tid`),
  KEY `own_openId` (`own_openId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='千米网订单表';

DROP TABLE IF EXISTS  `qm_orders_detail`;
CREATE TABLE `qm_orders_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `aid` varchar(32) DEFAULT NULL COMMENT '千米A编号',
  `qm_orders_id` bigint(20) DEFAULT '0' COMMENT '订单id',
  `tid` varchar(50) DEFAULT '' COMMENT '订单编号',
  `title` varchar(255) DEFAULT '' COMMENT '商品标题',
  `price` decimal(9,2) DEFAULT '0.00' COMMENT '商品销售单价 单位 元，2位小数',
  `num_iid` varchar(100) DEFAULT '' COMMENT '商品编号',
  `sku_id` varchar(100) DEFAULT '' COMMENT 'SKU编号',
  `num` int(6) DEFAULT '0' COMMENT '购买数量 大于0的整数',
  `payment` decimal(9,2) DEFAULT '0.00' COMMENT '优惠后商品单应付总额 单位 元，2位小数',
  `sku_properties_name` varchar(100) DEFAULT '' COMMENT '商品规格',
  `brand_name` varchar(100) DEFAULT '' COMMENT '商品品牌',
  `unit_cost` decimal(9,2) DEFAULT '0.00' COMMENT '成本单价 单位 元，2位小数',
  `own_openId` varchar(100) DEFAULT '' COMMENT '用户openId',
  `own_updatetime` int(11) DEFAULT '0' COMMENT '更新时间',
  `own_addtime` int(11) DEFAULT '0' COMMENT '写入时间',
  `own_status` tinyint(1) DEFAULT '0',
  `own_income` decimal(5,2) DEFAULT NULL COMMENT '收入',
  `buyer_nick` varchar(100) DEFAULT '' COMMENT '买家会员编号',
  PRIMARY KEY (`id`),
  KEY `tid` (`tid`),
  KEY `qm_orders_id` (`qm_orders_id`),
  KEY `own_openId` (`own_openId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='千米网订单详情表';

DROP TABLE IF EXISTS  `report`;
CREATE TABLE `report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '类型',
  `uid` int(11) DEFAULT '0' COMMENT '举报用户ID',
  `comment_id` int(11) DEFAULT '0' COMMENT '评论ID',
  `comment_uid` int(11) DEFAULT '0' COMMENT '被举报用户ID',
  `edittime` int(11) NOT NULL DEFAULT '0' COMMENT '操作时间',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '入库时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态（0未审核,1通过审核,2不通过审核)',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `comment_id` (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='评论举报表';

DROP TABLE IF EXISTS  `sns_answer`;
CREATE TABLE `sns_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sns_qid` int(11) DEFAULT '0' COMMENT '社交问题id',
  `uid` int(11) DEFAULT '0' COMMENT '评论者id',
  `from_answer_id` int(11) DEFAULT '0' COMMENT '和上一个人对话的id',
  `title` varchar(500) DEFAULT '' COMMENT '评论内容',
  `addtime` int(11) DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(1) DEFAULT '0' COMMENT '社交问题id',
  PRIMARY KEY (`id`),
  KEY `sns_qid` (`sns_qid`),
  KEY `uid` (`uid`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=228 DEFAULT CHARSET=utf8 COMMENT='社交评论表';

DROP TABLE IF EXISTS  `sns_likes`;
CREATE TABLE `sns_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sns_qid` int(11) NOT NULL DEFAULT '0' COMMENT '社交问题id',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1正常，0删除',
  PRIMARY KEY (`id`),
  KEY `sns_qid` (`sns_qid`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='社交喜欢表';

DROP TABLE IF EXISTS  `sns_question`;
CREATE TABLE `sns_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `university_id` int(11) NOT NULL DEFAULT '0' COMMENT '创客大学id',
  `university_name` varchar(30) DEFAULT '' COMMENT '大学名称',
  `title` varchar(500) NOT NULL DEFAULT '' COMMENT '标题',
  `img_arr` text COMMENT '图片数组序列化',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1正常，0删除',
  PRIMARY KEY (`id`),
  KEY `university_id` (`university_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=450 DEFAULT CHARSET=utf8 COMMENT='社交问题表';

DROP TABLE IF EXISTS  `subject`;
CREATE TABLE `subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '学科名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态（1正常，0不可用）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='学科名称';

DROP TABLE IF EXISTS  `tmp_mobile`;
CREATE TABLE `tmp_mobile` (
  `mobile` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS  `university_detail`;
CREATE TABLE `university_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) DEFAULT '0',
  `name` varchar(255) NOT NULL COMMENT '学校名称',
  `short_content` text COMMENT '简介',
  `long_content` text COMMENT '详细介绍',
  `img` varchar(255) DEFAULT NULL COMMENT '大学图片',
  `teacher` varchar(20) DEFAULT NULL COMMENT '讲师队长 ',
  `teacher_short` text,
  `create_id` int(11) DEFAULT NULL COMMENT '创建人员',
  `create_time` int(11) DEFAULT NULL COMMENT '创建时间',
  `update_id` int(11) DEFAULT NULL COMMENT '修改人员',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `is_home` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `university_id` (`university_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS  `university_integral`;
CREATE TABLE `university_integral` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) DEFAULT '0' COMMENT '用户openId',
  `use_number` int(11) DEFAULT '0' COMMENT '可用(可提现)资金',
  `total_number` int(11) DEFAULT '0' COMMENT '总金额',
  `addtime` int(11) DEFAULT '0',
  `updatetime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `university` (`university_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='大学资金信息表';

DROP TABLE IF EXISTS  `university_integral_detail`;
CREATE TABLE `university_integral_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户openId',
  `type` tinyint(1) DEFAULT '1' COMMENT '1加，2减',
  `number` int(11) DEFAULT '0' COMMENT '积分数',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '写入时间',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `university_id` (`university_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='大学资金信息详情表';

DROP TABLE IF EXISTS  `university_statistics`;
CREATE TABLE `university_statistics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT '' COMMENT '学校名称',
  `people` int(11) DEFAULT '0' COMMENT '创客大学人数',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态（1正常，0不可用）',
  PRIMARY KEY (`id`),
  KEY `adm_uid` (`people`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='创科大学表';

DROP TABLE IF EXISTS  `user_gold`;
CREATE TABLE `user_gold` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openId` varchar(100) NOT NULL DEFAULT '' COMMENT '用户openId',
  `type` tinyint(1) DEFAULT '1' COMMENT '1加，2减',
  `number` int(11) DEFAULT '0' COMMENT '积分数',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '写入时间',
  PRIMARY KEY (`id`),
  KEY `openId` (`openId`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='积分（金豆）详情表';

DROP TABLE IF EXISTS  `user_integral`;
CREATE TABLE `user_integral` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openId` varchar(100) DEFAULT '0' COMMENT '用户id',
  `number` int(11) DEFAULT '0' COMMENT '可用积分',
  `total_number` int(11) DEFAULT '0' COMMENT '总积分',
  `inserttime` int(11) DEFAULT '0' COMMENT '第一次写放时间',
  `updatetime` int(11) DEFAULT '0' COMMENT '最近一次的更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='积分（金豆）';

DROP TABLE IF EXISTS  `user_integral_detail`;
CREATE TABLE `user_integral_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openId` varchar(100) NOT NULL DEFAULT '' COMMENT '用户openId',
  `type` tinyint(1) DEFAULT '1' COMMENT '1加，2减',
  `number` int(11) DEFAULT '0' COMMENT '积分数',
  `addtime` int(11) NOT NULL DEFAULT '0' COMMENT '写入时间',
  PRIMARY KEY (`id`),
  KEY `openId` (`openId`),
  KEY `type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS  `user_sign`;
CREATE TABLE `user_sign` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) DEFAULT '0',
  `curriculum_id` int(11) DEFAULT '0' COMMENT '课程id',
  `uid` int(11) DEFAULT '0' COMMENT '用户ID',
  `status` int(11) DEFAULT '1' COMMENT '状态:1成功0失败',
  `inserttime` int(11) DEFAULT '0' COMMENT '签到时间',
  `datetime` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING BTREE,
  KEY `curriculum_id` (`curriculum_id`) USING BTREE,
  KEY `datetime` (`datetime`) USING BTREE,
  KEY `university_id` (`university_id`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=70897 DEFAULT CHARSET=utf8 COMMENT='签到';

DROP TABLE IF EXISTS  `wechat_plv`;
CREATE TABLE `wechat_plv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `teacher` varchar(50) DEFAULT NULL COMMENT '讲师',
  `img` varchar(255) DEFAULT NULL COMMENT '图片',
  `plv` varchar(255) DEFAULT NULL COMMENT '视频地址',
  `time` int(11) DEFAULT NULL,
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态（1：正常，0：禁用）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COMMENT='公众号视屏表';

SET FOREIGN_KEY_CHECKS = 1;

/* VIEWS */;
DROP VIEW IF EXISTS `v_business`;
CREATE VIEW `v_business` AS select `a`.`id` AS `id`,`a`.`aid` AS `aid`,`a`.`type` AS `type`,`a`.`grade` AS `grade`,`a`.`free_amount` AS `free_amount`,`a`.`reach_amount` AS `reach_amount`,`a`.`total_amount` AS `total_amount`,`a`.`time` AS `time`,`a`.`status` AS `status`,`b`.`nick_name` AS `nick_name`,`b`.`status` AS `business_status` from (`business_task` `a` left join `business` `b` on((`a`.`aid` = `b`.`aid`)));

DROP VIEW IF EXISTS `v_lecturer`;
CREATE VIEW `v_lecturer` AS select `a`.`id` AS `id`,`a`.`university_name` AS `university_name`,`a`.`university_id` AS `university_id`,`a`.`type` AS `type`,`a`.`name` AS `name`,`a`.`sex` AS `sex`,`a`.`marry` AS `marry`,`a`.`city` AS `city`,`a`.`address` AS `address`,`a`.`birth_date` AS `birth_date`,`a`.`phone` AS `phone`,`a`.`tell` AS `tell`,`a`.`political` AS `political`,`a`.`hukou` AS `hukou`,`a`.`education` AS `education`,`a`.`report_number` AS `report_number`,`a`.`card_number` AS `card_number`,`a`.`certificate_time` AS `certificate_time`,`a`.`team_role` AS `team_role`,`a`.`speciality` AS `speciality`,`a`.`work_date` AS `work_date`,`a`.`job_change` AS `job_change`,`a`.`appraisal_records` AS `appraisal_records`,`a`.`nickname` AS `nickname`,`a`.`qq` AS `qq`,`a`.`wechat` AS `wechat`,`a`.`email` AS `email`,`a`.`school` AS `school`,`a`.`contact_relationship` AS `contact_relationship`,`a`.`contact_name` AS `contact_name`,`a`.`professional` AS `professional`,`a`.`teacher_number` AS `teacher_number`,`a`.`remark` AS `remark`,`a`.`avatar` AS `avatar`,`a`.`inserttime` AS `inserttime`,`a`.`business_content` AS `business_content`,`a`.`teaching_content` AS `teaching_content`,`a`.`evaluation` AS `evaluation`,`a`.`img` AS `img`,`a`.`goodat` AS `goodat`,`a`.`status` AS `status`,`b`.`dict_name` AS `type_name` from (`lecturer` `a` left join `dict` `b` on(((`a`.`type` = `b`.`dict_value`) and (`b`.`dict_no` = 1001))));

