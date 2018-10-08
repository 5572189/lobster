<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
namespace Admin\Model;

use Think\Model;

/**
 * 用户模型
 * 
 */
class ShopModel extends Model
{
    /**
     * 数据库表名
     * 
     */
    protected $tableName = 'admin_user';

    /**
     * 自动验证规则
     * 
     */
    protected $_validate = array(
        //验证用户名
        array('username', 'require', '用户名不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('username', '3,32', '用户名长度为3-32个字符', self::MUST_VALIDATE, 'length', self::MODEL_BOTH),
        array('username', '', '用户名被占用', self::MUST_VALIDATE, 'unique', self::MODEL_BOTH),
        //array('username', '/^(?!_)(?!\d)(?!.*?_$)[\w\一-\龥]+$/', '用户名只可含有数字、字母、下划线且不以下划线开头结尾，不以数字开头！', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),

        //验证密码
        array('password', 'require', '密码不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_INSERT),
        // array('password', '6,30', '密码长度为6-30位', self::MUST_VALIDATE, 'length', self::MODEL_INSERT),
        // array('password', '/(?!^(\d+|[a-zA-Z]+|[~!@#$%^&*()_+{}:"<>?\-=[\];\',.\/]+)$)^[\w~!@#$%^&*()_+{}:"<>?\-=[\];\',.\/]+$/', '密码至少由数字、字符、特殊字符三种中的两种组成', self::MUST_VALIDATE, 'regex', self::MODEL_INSERT),
        array('repassword', 'password', '两次输入的密码不一致', self::EXISTS_VALIDATE, 'confirm', self::MODEL_INSERT),

        //验证门店名称
        array('shop_name', 'require', '门店名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),

        //验证门店电话
        array('shop_phone', 'require', '门店电话不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
        array('shop_phone', '', '门店电话被占用', self::EXISTS_VALIDATE, 'unique', self::MODEL_BOTH),

        //验证门店图标
        array('shop_logo', 'require', '门店图标不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),

        //验证店内图片
        array('shop_picarr', 'require', '店内图片不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),

        // 验证注册来源
        array('reg_type', 'require', '注册来源不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_INSERT),
    );

    /**
     * 自动完成规则
     * 
     */
    protected $_auto = array(
        array('reg_ip', 'get_client_ip', self::MODEL_INSERT, 'function', 1),
        array('password', 'user_md5', self::MODEL_INSERT, 'function'),
        array('create_time', 'time', self::MODEL_INSERT, 'function'),
        array('update_time', 'time', self::MODEL_BOTH, 'function'),
        array('status', '1', self::MODEL_INSERT),
        array('is_shop', '1', self::MODEL_INSERT),
    );

    /**
     * 用户性别
     * 
     */
    public function user_gender($id = '')
    {
        $list[0]  = '保密';
        $list[1]  = '男';
        $list[2] = '女';
        return $id!=='' ? $list[$id] : $list;
    }
    public function user_gender_key($value='')
    {
        $key = array_search($value, $this->user_gender());
        $key = $key===false ? 0 : $key;
        return $key;
    }
    /**
     * 用户登录
     * 
     */
    public function login($username, $password, $map = [])
    {
        //去除前后空格
        $username = trim($username);

        //匹配登录方式
        if (preg_match("/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/", $username)) {
            $map['email'] = array('eq', $username); // 邮箱登录
        } elseif (preg_match("/^1\d{10}$/", $username)) {
            $map['mobile'] = array('eq', $username); // 手机号登录
        } else {
            $map['username'] = array('eq', $username); // 用户名登录
        }

        $map['status'] = array('eq', 1);
        $user_info     = $this->where($map)->find(); //查找用户
        if (!$user_info) {
            $this->error = '用户不存在或被禁用！';
        } else {
            if (user_md5($password) !== $user_info['password']) {
                $this->error = '密码错误！';
            } else {
                return $user_info;
            }
        }
        return false;
    }

    /**
     * 设置登录状态
     * 
     */
    public function auto_login($user)
    {
        // 记录登录SESSION和COOKIES
        $user = $this->find($user['id']);
        $auth = array(
            'uid'      => $user['id'],
            'username' => $user['username'],
            'nickname' => $user['nickname'],
            'avatar'   => $user['avatar'],
        );
        session('user_auth', $auth);
        session('user_auth_sign', $this->data_auth_sign($auth));
        return $this->is_login();
    }

    /**
     * 数据签名认证
     * @param  array  $data 被认证的数据
     * @return string       签名
     * 
     */
    public function data_auth_sign($data)
    {
        // 数据类型检测
        if (!is_array($data)) {
            $data = (array) $data;
        }
        ksort($data); //排序
        $code = http_build_query($data); // url编码并生成query字符串
        $sign = sha1($code); // 生成签名
        return $sign;
    }

    /**
     * 检测用户是否登录
     * @return integer 0-未登录，大于0-当前登录用户ID
     * 
     */
    public function is_login()
    {
        $user = session('user_auth');
        if (empty($user)) {
            return 0;
        } else {
            if (session('user_auth_sign') == $this->data_auth_sign($user)) {
                return $user['uid'];
            } else {
                return 0;
            }
        }
    }
}