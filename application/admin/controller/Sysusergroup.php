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
        $where = [];
        //权限组名关键词搜索
        $keyword = input('keyword','');
        if( $keyword == '' ){
            $where['group_name'] = ['like',"%{$keyword}%"];
        }
        $list = Db::table($groupModel->getTable())
            ->where($where)
            ->order('status','desc')
            ->paginate(15);

        $this->assign('list',$list);
        $page = $list->render();
        $this->assign('page',$page);
        return $this->fetch();
    }

    /**
     * 获取所有权限组配置表内容
     */
    public function get_group_list(){
        $group_id = input('group_id',0);
        $powerArr = [];
        if( $group_id > 0 ){
            $info = Db::table($this->groupModel->getTable())
                ->field('value')
                ->where('group_id',$group_id)
                ->find();

            if( empty($info) ){
                returnJson(false,'参数错误');
            }
            $powerArr= explode(',',$info['value']);
        }
        $menuList = $this->getMenuList();
        $menuList = $this->get_group_set($menuList,$powerArr);
        returnJson(true,'success',$menuList);
    }

    /**
     * 配置参数集
     * @param array $menuList       菜单权限内容
     * @param array $powerArr       已设置的权限内容 checked = 1 为已设置
     * @return array
     */
    private function get_group_set($menuList=[],$powerArr=[]){
        if( !empty($menuList) ) {
            foreach ( $menuList as $key => $value ) {
                $value['checked'] = 0;
                if( in_array($value['power'],$powerArr) ){
                    $value['checked'] = 1;
                }
                if(!empty($value['child'])){
                    $value['child'] = $this->get_group_set($value['child'],$powerArr);
                }
                $menuList[$key] = $value;
            }
        }
        return $menuList;
    }

    /**
     * 创建权限组
     */
    public function create_group(){
        //配置参数信息
        $data = input('.post');
        try{
            if( empty($data['group_name']) || empty($data['group_power']) ){
                throw new Exception('参数错误');
            }
            $t = time();
            //检查权限组名是否重复
            $group_name = trim($data['group_name']);
            $checkInfo = Db::table($this->groupModel->getTable())
                ->where('group_name',$group_name)
                ->find();

            if( !empty($checkInfo) )
                throw new Exception('权限组已存在');

            $insertData = array(
                'group_name'    => $group_name,
                'value'         => 'home',
                'add_time'      => $t,
                'edit_time'     => $t,
            );
            if( Db::table($this->groupModel->getTable())->insert($insertData) === false ){
                throw new Exception('网络错误，操作失败');
            }
        }catch( Exception $e ){
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'添加成功');
    }

    /**
     * 更新权限组信息
     */
    public function update_group(){
        //配置参数信息
        $data = input('.post');
        try{
            if( empty($data['group_id']) || empty($data['group_name']) || empty($data['group_power']) ){
                throw new Exception('参数错误');
            }
            $t = time();
            //检查权限组名是否重复
            $group_name = trim($data['group_name']);
            $checkInfo = Db::table($this->groupModel->getTable())
                ->where('group_name',$group_name)
                ->find();

            if( !empty($checkInfo) )
                throw new Exception('权限组名已存在');

            $group_id = trim($data['group_id']);
            $info = Db::table($this->groupModel->getTable())
                ->where('group_id',$group_id)
                ->find();

            if( empty($info) )
                throw new Exception('权限组信息异常');

            $insertData = array(
                'group_name' => $group_name,
                'edit_time'  => $t,
            );
            $updateState = Db::table($this->groupModel->getTable())->where('group_id',$checkInfo['group_id'])->update($insertData);
            if( empty($updateState) ){
                throw new Exception('网络错误，操作失败');
            }
        }catch( Exception $e ){
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'保存成功');
    }

    /**
     * 更新权限配置
     */
    public function update_power(){
        $data = input('.post');
        if( empty($data['group_id']) || empty($data['power_value']) ){
            returnJson(false,'参数错误');
        }
        $group_id = $data['group_id'];
        $power_value = $data['power_value'];
        $updateData['value'] = $power_value;
        $updateState = Db::table($this->groupModel->getTable())->where('group_id',$group_id)->update($updateData);
        if( empty($updateState) ){
            returnJson(false,'网络错误，保存失败');
        }
    }

    //初始化超级管理员权限组
    public function default_super_group()
    {
        $key = Request()->post('key');
        try {
            if ($key == '')
                throw new Exception('非法操作');

            if ($key != __COMPANYKEY__)
                throw new Exception('秘钥错误');

            $t = time();
            //检查超级管理员权限组是否存在
            $info = Db::table($this->groupModel->getTable())->where('status', SysUserGroupModel::SUPER_STATUS)->find();
            $menuList = $this->getMenuList();
            $poser_value = $this->groupModel->filterPowerData($menuList);
            $poser_value = implode(',', $poser_value);
            if (empty($info)) {
                $data = array(
                    'group_name' => '超级管理员',
                    'value' => $poser_value,
                    'status' => SysUserGroupModel::SUPER_STATUS,
                    'add_time' => $t,
                    'edit_time' => $t
                );
                if (Db::table($this->groupModel->getTable())->insert($data) === false)
                    throw new Exception('初始化失败');

            } else {
                $data = array(
                    'value' => $poser_value,
                    'edit_time' => $t
                );
                $updateState = Db::table($this->groupModel->getTable())->where('group_id', $info['group_id'])->update($data);
                if (empty($updateState))
                    throw new Exception('初始化失败');
            }
        }catch( Exception $e ){
            returnJson(false, $e->getMessage());
        }
        returnJson(true, '初始化成功');
    }



}
