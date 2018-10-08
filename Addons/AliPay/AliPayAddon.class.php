<?php
namespace Addons\AliPay;
use Common\Controller\Addon;
/**
 * 阿里支付
 * @author Kit <leishuihe@qq.com>
 */
class  AliPayAddon extends Addon{

    //public $admin_list = [[],['title'=>'列表','model'=>'MeiLian']];
   // public $custom_adminlist = 'Addons://MeiLian/MeiLian/index';
    /**
     * 插件信息 
     * @author Kit <leishuihe@qq.com>
     */
    public $info = array(
        'name' => 'AliPay',
        'title' => '支付宝支付接口',
        'description' => '支付宝支付接口',
        'status' => 1,
        'author' => 'Kit',
        'version' => '1.0'
    );

    /**
     * 插件安装方法
     * @author Kit <leishuihe@qq.com>
     */
    public function install(){
        return true;
    }

    /**
     * 插件卸载方法
     * @author Kit <leishuihe@qq.com>
     */
    public function uninstall(){
        return true;
    }
}
