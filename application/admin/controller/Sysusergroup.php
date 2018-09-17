<?php
namespace app\admin\controller;

use think\Exception;

/**
 * 管理员权限组控制器
 * Class Sysusergroup
 * @package app\admin\controller
 */
class Sysusergroup extends Base
{
    public function __construct()
    {
        parent::__construct();
        $this->groupModel = model('SysUserGroup');
    }

    public function index(){
        p($this->getMenuList());
//        return $this->fetch();
    }

    /**
     * 获取所有权限组配置
     */
    public function getGroupList(){
        $menuList = $this->getMenuList();
        retrunJosn(true,'success',$menuList);
    }

    /**
     * 获取权限组配置列表
     */
    public function getGroupSite(){
        $menuList = $this->getMenuList();

    }

    /**
     * 创建权限组
     */
    public function createGroup(){
        //配置参数信息
        $data = input('.post');
        try{
            if( empty($data['group_name']) ){
                throw new Exception('参数错误');
            }
            if( isset($data['group_power']) && !empty($data['group_power']) )
                throw new Exception('参数错误');



        }catch( Exception $e ){
            retrunJosn(false,$e->getMessage());
        }
        $groupModel = $this->groupModel;
        $menuList = $groupModel->filterPowerData($menuList);
        $menuList = implode(',',$menuList);
        p($menuList);
    }



}
