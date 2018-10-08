<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
return array(
    // 路由配置
    'URL_ROUTER_ON'     => true,
    'URL_MAP_RULES'     => array(
    ),
    'URL_ROUTE_RULES'   => array(
        'list/:cid\d'  => 'index/lists',
        ':id\d'        => 'index/detail',
        'notice/:id\d' => 'notice/detail',
        'cate/:id\d'   => 'category/detail',
    ),
);
