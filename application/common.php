<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

//不要随意改动
define('__COMPANYKEY__','yiguankeji');//公司用户配置秘钥key
//公共函数
/**
 * 打印查看对象
 * @param null $obj         对象
 * @param bool $seeType     是否显示变量类型
 */
 function p($obj=NULL,$seeType=false){
     echo '<pre>';
     if($seeType){
         var_dump($obj);
     }else{
         print_r($obj);
     }
     echo '</pre>';
}

/**
 * 接口返回格式
 * @param bool $bool    状态
 * @param $desc         描述内容
 * @param $data         返回参数
 */
function returnJson($bool=false,$desc='fail',$data=[]){
    $json['status'] = $bool ? 1 : 0;
    $json['msg'] = $desc;
    $json['info'] = $data;
    exit(json_encode($json));
}

/**
 * 返回后台主页
 */
function noPermission(){
    echo 'You do not have permission';
    exit;
}
