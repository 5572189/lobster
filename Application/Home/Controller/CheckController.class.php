<?php

    namespace Home\Controller;

    use Common\Controller\CommonController;


    class CheckController extends CommonController
    {
        // 测试服：5分钟执行一次；线上：1分钟执行一次
        public function crontab()
        {

        }

        //点餐系统回调
        function call_back()
        {
            $date = date('Ymd');
            $cache = S(['type' => 'memcache']);

            $ali_order = (array)M('alipay_record')->where(['type' => 'pay' , 'status' => 1])->field('id,uid,out_trade_no')->select();
            if ($ali_order) {
                writeLog(var_export($ali_order , true) , 'call_back' . $date);
                foreach ($ali_order as $q) {
                    $order_id = $q['id'];
                    $key = 'hall_callback' . $order_id;
                    if ($cache->get($key) == 1) {
                        continue;
                    } else {
                        $cache->set($key , 1 , 10);
                        writeLog($order_id , 'callback_return');
                    }

                    $param = [
                        'out_trade_no' => $q['out_trade_no'] ,
                        'pay_type'     => 5 ,
                        'uid'          => $q['uid']
                    ];


                    $result = sendPost('order/order_paid' , $param);

                    $result = json_decode($result , true);

                    if ($result['data']['code'] == 200) {
                        M('alipay_record')->where(['out_trade_no' => $q['out_trade_no']])->save(['status' => 2]);
                    }
                }
            }

            $wx_order = (array)M('wxpay')->where(['paid' => 1])->field('id,uid,ordernum')->select();
            if ($wx_order) {
                writeLog(var_export($wx_order , true) , 'call_back' . $date);
                foreach ($wx_order as $q) {
                    $order_id = $q['id'];
                    $key = 'hall_callback' . $order_id;
                    if ($cache->get($key) == 1) {
                        continue;
                    } else {
                        $cache->set($key , 1 , 10);
                        writeLog($order_id , 'callback_return');
                    }

                    $param = [
                        'out_trade_no' => $q['ordernum'] ,
                        'pay_type'     => 3 ,
                        //'uid'=>$q['uid']
                    ];

                    $result = sendPost('order/order_paid' , $param);

                    $result = json_decode($result , true);

                    if ($result['data']['code'] == 200) {
                        return M('wxpay')->where(['ordernum' => $q['ordernum']])->save(['pushed' => 1 , 'paid' => 2]);
                    }

                }
            }
        }
    }