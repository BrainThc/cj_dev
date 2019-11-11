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
define('__COMPANYKEY__','cjbanbanda');//公司用户配置秘钥key
//公共函数
/**
 * 打印查看对象
 * @param null $obj         对象
 * @param bool $seeType     是否显示变量类型
 */
if( !function_exists('p') ) {
    function p($obj = NULL, $seeType = false)
    {
        echo '<pre>';
        if ($seeType) {
            var_dump($obj);
        } else {
            print_r($obj);
        }
        echo '</pre>';
    }
}

/**
 * 断点打印查看对象
 * @param null $obj         对象
 * @param bool $seeType     是否显示变量类型
 */
if( !function_exists('pe') ) {
    function pe($obj = NULL, $seeType = false)
    {
        echo '<pre>';
        if ($seeType) {
            var_dump($obj);
        } else {
            print_r($obj);
        }
        echo '</pre>';
        exit;
    }
}

/**
 * 断点json打印查看对象
 * @param null $obj         对象
 * @param bool $seeType     是否显示变量类型
 */
if( !function_exists('je') ) {
    function je($obj = NULL)
    {
        exit(json_encode($obj));
    }
}

/**
 * 接口返回格式
 * @param bool $bool    状态
 * @param $desc         描述内容
 * @param $data         返回参数
 */
if( !function_exists('returnJson') ) {
    function returnJson($code = true, $desc = 'fail', $data = [], $other_param = [])
    {
        $json['code'] = $code ? 0 : 1;
        $json['msg'] = $desc;
        $json['data'] = $data;
        if( !empty($other_param) ){
            foreach($other_param as $pk => $param){
                $json[$pk] = $param;
            }
        }
        exit(json_encode($json));
    }
}

/**
 * 返回后台主页
 */
if( !function_exists('noPermission') ) {
    function noPermission()
    {
        $_postData = input('post.');
        $_getData = input('get.');
        if ((isset($_postData) && !empty($_postData)) || (isset($_getData['v']) && !empty($_getData['v']))) {
            returnJson(false, think\config::get('no_permission_msg'));
        } else {
            include think\config::get('no_permission_tmpl');
            exit;
        }
    }
}


/**
 * 递归处理树状结构数据集（多维数组）
 * @param $arr_all      待处理数据集
 * @param $parent_id    顶级父级id
 * @param $relation     关联关系项 ['parent'=>'id','son'=>'pid']
 * @return array        已处理的数据集
 */
if( !function_exists('setTree') ){
    function setTree($arr_all,$parent_id=0,$relation=['parent'=>'id','son'=>'pid']){
        $tree_arr = [];
        if( empty($relation) || empty($arr_all) ){
            return $arr_all;
        }
        $parent = isset($relation['parent']) ? $relation['parent'] : 'id';
        $son = isset($relation['son']) ? $relation['son'] : 'pid';
        if( !empty($arr_all) ){
            foreach( $arr_all as $tkey => $t ){
                if( $t[$son] == $parent_id ){
                    $t['children'] = setTree($arr_all,$t[$parent],$relation);
                    $tree_arr[] = $t;
                }
            }
        }
        return $tree_arr;
    }
}

/**
 * 递归处理树状结构多维数组转为层级列表(一维数组)
 * @param $list             array   待处理数组列表
 * @param $childField       string  子级的参数字段
 * @param $pNum             integer 初始层级 默认0
 * @param $return_list      array   默认已存在的列表项
 * @return $return_list     array   已处理的数组列表
 */
if( !function_exists('setTreeList') ) {
    function setTreeList($list, $childField='children', $pNum=0, $return_list=[]){
        if(empty($list)){
            return [];
        }
        foreach($list as $k => $v ){
            $v['pNum'] = $pNum;
            $return_list[] = $v;
            if( !empty($v[$childField]) ){
                $return_list = setTreeList($v[$childField], $childField, $pNum+1, $return_list);
            }
        }
        foreach( $return_list as $key => $val ){
            if( isset($val[$childField])){
                unset($val[$childField]);
            }
            $return_list[$key] = $val;
        }
        return $return_list;
    }
}

/**
 * 驼峰转下划线
 * @param  array   $data  [description]
 */
if( !function_exists('humpToLine') )
{
    function humpToLine($str){
        $str = preg_replace_callback("/([A-Z]{1})/",function($matches){
            return '_'.strtolower($matches[0]);
        },$str);

        return trim($str,'_');
    }
}
