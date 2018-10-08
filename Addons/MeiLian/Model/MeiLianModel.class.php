<?php
    // +----------------------------------------------------------------------
    // | Copyright (c) 2016 http://www.noble-spirits.com All rights reserved.
    // +----------------------------------------------------------------------
    namespace Addons\MeiLian\Model;

    use Think\Model;

    class MeiLianModel extends Model
    {
        protected $tableName = 'addon_meilian';
        /**
         * 后台列表管理相关定义
         * @author Kit <leishuihe@qq.com>
         */
        //public $adminList = array('title' => '邮件列表' , 'model' => 'addon_meilian' , 'search_key' => 'title' , 'order' => 'id desc' , 'map' => null , 'list_grid' => array('title' => array('title' => '标题' , 'type' => 'text' ,) , 'receiver' => array('title' => '收件人' , 'type' => 'text' ,) , 'status' => array('title' => '状态' , 'type' => 'status' ,) ,) , 'field' => array( //后台新增、编辑字段
        //    'title' => array('name' => 'title' , 'title' => '标题' , 'type' => 'text' , 'tip' => '邮件标题' ,) , 'content' => array('name' => 'content' , 'title' => '正文' , 'type' => 'kindeditor' , 'tip' => '邮件正文' ,) , 'receiver' => array('name' => 'receiver' , 'title' => '收件人' , 'type' => 'text' , 'tip' => '填写all表示发给所有用户' ,) ,) ,);

        //发送接口
        function sendSMS($mobile = '' , $content , $encode = 'UTF-8')
        {
            $config = M('admin_addon')->where(['name' => 'MeiLian'])->getField('config');

            $config = json_decode($config , true);
            $username = $config['username'];
            $password_md5 = md5($config['password']);
            $apikey = $config['apikey'];
            //发送链接（用户名，密码，apikey，手机号，内容）
            $url = "http://m.5c.com.cn/api/send/index.php?";
            $data = [
                'username'     => $username ,
                'password_md5' => $password_md5 ,
                'apikey'       => $apikey ,
                'mobile'       => $mobile ,
                'content'      => urlencode($content) ,
                'encode'       => $encode ,
            ];


            $result = $this->_curlSMS($url , $data);

            //print_r($data); //测试
            return $result;
        }

        private function _curlSMS($url , $post_fields = array())
        {
            $ch = curl_init();
            curl_setopt($ch , CURLOPT_URL , $url);//用PHP取回的URL地址（值将被作为字符串）
            curl_setopt($ch , CURLOPT_RETURNTRANSFER , 1);//使用curl_setopt获取页面内容或提交数据，有时候希望返回的内容作为变量存储，而不是直接输出，这时候希望返回的内容作为变量
            curl_setopt($ch , CURLOPT_TIMEOUT , 30);//30秒超时限制
            curl_setopt($ch , CURLOPT_HEADER , 1);//将文件头输出直接可见。
            curl_setopt($ch , CURLOPT_POST , 1);//设置这个选项为一个零非值，这个post是普通的application/x-www-from-urlencoded类型，多数被HTTP表调用。
            curl_setopt($ch , CURLOPT_POSTFIELDS , $post_fields);//post操作的所有数据的字符串。
            $data = curl_exec($ch);//抓取URL并把他传递给浏览器
            curl_close($ch);//释放资源
            $res = explode("\r\n\r\n" , $data);//explode把他打散成为数组

            return $res; //然后在这里返回数组。
        }
    }
