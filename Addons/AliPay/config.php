<?php

return array(
   /* 'status' => array(
        'title'   => '是否开启登录、注册短信:',
        'type'    => 'radio',
        'options' => array(
            '1' => '开启',
            '0' => '关闭',
        ),
        'value'   => '1',
    ),*/
    'gatewayUrl' => array(
        'title' => '支付宝网关',
        'type'  => 'text',
        'value' => '',
        'tip'   => '',
    ),
    'app_id' => array(
        'title' => 'app_id',
        'type'  => 'text',
        'value' => '',
        'tip'   => '',
    ),
    'merchant_private_key' => array(
        'title' => '商户私钥',
        'type'  => 'text',
        'value' => '',
        'tip'   => '',
    ),
    'alipay_public_key' => array(
        'title' => '支付宝公钥',
        'type'  => 'text',
        'value' => '',
        'tip'   => '',
    ),
    'notify_url' => array(
        'title' => '异步回调地址',
        'type'  => 'text',
        'value' => '',
        'tip'   => '',
    ),
    'return_url' => array(
        'title' => '返回地址',
        'type'  => 'text',
        'value' => '',
        'tip'   => '',
    ),
);
