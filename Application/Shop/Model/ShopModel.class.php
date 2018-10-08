<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
/**
 * 默认模型
 * 
 */
namespace Shop\Model;

use Think\Model;

class ShopModel extends Model
{
    /**
     * 数据库真实表名
     * 一般为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     * 
     */
    protected $tableName = 'restaurant';

    protected $_auto = array(
        array('create_time', 'datetime', 1, 'function'),
    );
    protected $_validate = array(
        array('title', 'require', '请填写门店名称！'), //默认情况下用正则进行验证
    );

}
