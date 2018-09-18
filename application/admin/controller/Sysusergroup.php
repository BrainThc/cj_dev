<?php
namespace app\admin\controller;
use think\Db;
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
        $list = $groupModel->query($sql);
        $this->assign('list',$list);
        return $this->fetch();
    }

    /**
     * 获取所有权限组配置表内容
     */
    public function get_group_list(){
        $menuList = $this->getMenuList();
        retrunJosn(true,'success',$menuList);
    }

    /**
     * 获取权限组配置列表
     */
    public function get_group_site(){
        $menuList = $this->getMenuList();

    }

    /**
     * 创建权限组
     */
    public function create_group(){
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
    public function default_super_group()
    {
        $key = input('key');
        if ($key == '')
            retrunJosn(false, '非法操作');

        if ($key != __COMPANYKEY__)
            retrunJosn(false, '非法操作');

        $t = time();
        //检查超级管理员权限组是否存在
        $info = Db::table($this->groupModel->getTable())->where('status',SysUserGroupModel::SUPER_STATUS)->find();
        $menuList = $this->getMenuList();
        $poser_value = $this->groupModel->filterPowerData($menuList);
        $poser_value = implode(',',$poser_value);
        if(empty($info)){
            $data = array(
                'group_name' => '超级管理员',
                'value' => $poser_value,
                'status' => SysUserGroupModel::SUPER_STATUS,
                'add_time' => $t,
                'edit_time' => $t
            );
            if( Db::table($this->groupModel->getTable())->insert($data) === false )
                retrunJosn(false, '初始化失败');

        }else{
            $data = array(
                'value' => $poser_value,
                'edit_time' => $t
            );
            $updateState = Db::table($this->groupModel->getTable())->where('group_id',$info['group_id'])->update($data);
            if( empty($updateState) )
                retrunJosn(false, '初始化失败',$updateState);
        }
        retrunJosn(true, '初始化成功');
    }



}
