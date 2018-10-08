<?php
namespace Addons\MeiLian;
use Common\Controller\Addon;
/**
 * 美联国际短信插件
 * @author Kit <leishuihe@qq.com>
 */
class  MeiLianAddon extends Addon{

    //public $admin_list = [[],['title'=>'列表','model'=>'MeiLian']];
   // public $custom_adminlist = 'Addons://MeiLian/MeiLian/index';
    /**
     * 插件信息
     * @author Kit <leishuihe@qq.com>
     */
    public $info = array(
        'name' => 'MeiLian',
        'title' => '美联国际-短信接口',
        'description' => '通过美联国际短信接口发送短信',
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
