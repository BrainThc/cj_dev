<?php
namespace app\admin\controller;
use app\admin\model\SysUser as SysUserModel;
use think\Db;

/**
 * Class SysUser
 * @package app\admin\controller
 */

class Sysuser extends Base
{

    public function __construct()
    {
        parent::__construct();
        $this->sysUserModel = model('SysUser');
    }

    //列表主页
    public function index()
    {
        $where = [];
        $keyword = input('keyword','');
        if( $keyword == '' ){
            $where['username'] = ['like',"%{$keyword}%"];
        }
        $userList = Db::table($this->sysUserModel->getTable())
            ->where($where)
            ->order('sys_user_id','asc')
            ->paginate(15);

        if( !empty($userList) ){
            foreach( $userList as $k => $v ){
                $v['last_date'] = date('Y-m-d H:i:s',$v['last_time']);
                $v['statusType'] = SysUserModel::$map_status[$v['status']]['desc'];
                $userList[$k] = $v;
            }
        }
        $page = $userList->render();
        $this->assign('list',$userList);
        $this->assign('page',$page);
        return $this->fetch();
    }

    //刷新用户权限
    public function updateLoginCache(){
        $userInfo = Db::table($this->sysUserModel->getTable())
            ->where('sys_user_id',$this->sysUserId)
            ->find();
        $loginModel = model('Login');
        if( $loginModel->signInfo($userInfo) === false )
            $this->error('刷新状态失败~~~',\think\Url::build('admin/index/index'),'',1);

        $this->redirect('admin/index/index');
        exit;
    }

    //异步获取用户列表
    public function get_sys_user_list(){
    }

    public function add(){
        echo '这里是添加管理员页面';
    }

    /**
     * 创建新管理员接口
     */
    public function createUser(){

    }

    /**
     * 更改管理员信息
     */
    public function updateUser(){

    }

}
