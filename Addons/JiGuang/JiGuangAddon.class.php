<?php
namespace Addons\JiGuang;
use Common\Controller\Addon;
/**
 * 极光APP消息推送
 * @author Gavin
 */
class JiGuangAddon extends Addon{

    /**
     * 插件信息 
     * @author Gavin
     */
    public $info = array(
        'name' => 'JiGuang',
        'title' => '极光APP消息推送',
        'description' => '极光APP消息推送',
        'status' => 1,
        'author' => 'Gavin',
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
