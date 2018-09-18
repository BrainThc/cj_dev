<?php
namespace app\admin\controller;
use app\admin\model\SysUserGroup as SysUserGroupModel;
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
        $groupModel = $this->groupModel;
        $sql = "SELECT * FROM ".$groupModel->getTable();
        echo $sql;
        $list = $groupModel->query($sql);
        p($list,true);
//        return $this->fetch();
    }

    /**
     * 获取所有权限组配置表内容
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
        $menuList = $this->getMenuList();
        $groupModel = $this->groupModel;
        $menuList = $groupModel->filterPowerData($menuList);
        $menuList = implode(',',$menuList);
        p($menuList);
    }

    //初始化超级管理员
    public function defaultSuperGroup($key = '')
    {
        p(SysUserGroupModel::SUPER_STATUS);
        if ($key == '')
            retrunJosn(false, '非法操作');

        if ($key == __COMPANYKEY__)
            retrunJosn(false, '非法操作');

        //检查超级管理员权限组是否存在
        $this->groupModel;
        $menuList = $this->getMenuList();
        $poser_value = $this->groupModel->filterPowerData($menuList);
        $insertData = array(
            'group_name' => '超级管理员',
            'value' => $poser_value,
            'status' => SysUserGroupModel::SUPER_STATUS,
            'add_time' => time(),
            'edit_time' => time()
        );
        Db::table($this->groupModel->getTable())->insert();
    }



}
