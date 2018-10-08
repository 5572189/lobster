<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
namespace Home\Controller;

use Common\Controller\CommonController;

class OauthController extends CommonController
{
    public function wechat($callback = '')
    {
        if (!is_weixin()) {
            return;
        }
        $options = [
            'debug'    => false ,
            'app_id'   => C('wechat_appid') ,
            'secret'   => C('wechat_appsecret') ,
            'token'    => C('wechat_apptoken') ,
            'log'      => [
                'level' => 'debug' ,
                'file'  => LOG_PATH . 'easywechat.log' , // XXX: 绝对路径！！！！
            ] ,
            'oauth' =>[
                'scopes'   => ['snsapi_userinfo'] ,
                'callback' => $callback?$callback:'http://' . $_SERVER['HTTP_HOST'] .C('wechat_url').'/shop_id/'.intval(I('get.shop_id',0)),
            ]

        ];

        $app = new \EasyWeChat\Foundation\Application($options);
        $response = $app->oauth->redirect();
        $response->send();
    }
}
