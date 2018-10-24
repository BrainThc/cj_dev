<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
define('SCHEME',$_SERVER['REQUEST_SCHEME'].'://');
define('DOMAIN','yiguan2.com');
//域名绑定配置
$domain_config = array(
    SCHEME.'www.'.DOMAIN => array(
        'model' => 'index',
    ),
    SCHEME.'g.'.DOMAIN => array(
        'model' => 'admin',
    ),
    SCHEME.'a.'.DOMAIN => array(
        'model' => 'api',
    ),
    SCHEME.'p.'.DOMAIN => array(
        'model' => 'api/upload/index',
    )
);
//跨域配置
$allow_origin_config = [];
foreach( $domain_config as $domain => $config ){
    $allow_origin_config[] = $domain;
}
//模块绑定
$model = isset($domain_config[SCHEME.$_SERVER['SERVER_NAME']]) ? $domain_config[SCHEME.$_SERVER['SERVER_NAME']]['model'] : 'index';
define('BIND_MODULE',$model);
//配置跨域
if(isset($_SERVER['HTTP_ORIGIN'])){
    if(in_array($_SERVER['HTTP_ORIGIN'], $allow_origin_config)){
        header('Access-Control-Allow-Origin:'.$_SERVER['HTTP_ORIGIN']);
    }
}
// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
