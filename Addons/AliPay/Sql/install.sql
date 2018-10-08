CREATE TABLE `oc_alipay_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lang` char(4) DEFAULT 'cn' COMMENT '语言版本：cn中文，en英文',
  `out_trade_no` varchar(32) NOT NULL DEFAULT '',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '2退款',
  `notify` text NOT NULL,
  `uid` int(10) unsigned NOT NULL DEFAULT '0',
  `type` varchar(20) NOT NULL DEFAULT '',
  `money` decimal(10,2) unsigned DEFAULT '0.00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UDX_OUTTRADE` (`out_trade_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=558 DEFAULT CHARSET=utf8mb4;

