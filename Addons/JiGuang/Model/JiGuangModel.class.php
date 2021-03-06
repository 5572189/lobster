<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
// +----------------------------------------------------------------------
namespace Addons\JiGuang\Model;

use Think\Model;

class JiGuangModel extends Model {
    protected $tableName = '';
    private $_key = 'b77d5b339dfc5780d38132dc';
    private $_secret = '06ba8ce0756e48769307a6af';

    protected function _initialize () {
        parent::_initialize (); // TODO: Change the autogenerated stub
        require ( "Addons/JiGuang/Jpush/autoload.php" );
    }

    /**
     * @title : app推送
     * @param : $deviceId [是否发送指定用户] $platform 【平台】
     * @time  : 2017年11月21日/下午4:25:09
     */
    public function appPush ( $content , $data = [] , $deviceId = [] , $platform = 0 ) {
        // 格式
        // $data = [
        // 'title' => $title ,
        // 'content_type' => $type,
        // 'extras' => [
        // 'myKey' => $url ,
        // 'title' => $title ,
        // ]
        // ];
        $client = new \JPush\Client ( $this->_key , $this->_secret );
        $pusher = $client->push ();
        if ( $platform == 0 ) {
            $pusher->setPlatform ( 'all' );
        }
        else if ( $platform == 1 ) {
            $pusher->setPlatform ( 'android' );
        }
        else if ( $platform == 2 ) {
            $pusher->setPlatform ( 'ios' );
        }

        if ( empty ( $deviceId ) ) {
            // 推送全部
            $pusher->addAllAudience ();
        }
        else {
            // 推送指定用户
            $pusher->addAlias ( $deviceId );
        }
        $pusher->message ( trim ( $content ) , $data );
        try {
            $rest = $pusher->send ();
            if ( isset ( $rest ['http_code'] ) && $rest ['http_code'] == 200 ) {
                return true;
            }
            else {
                return false;
            }
        }
        catch ( \JPush\Exceptions\JPushException $e ) {
            // try something else here
            print $e;
        }
    }
}
