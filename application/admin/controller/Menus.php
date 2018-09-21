<?php
namespace app\admin\controller;
use think\Db;
use app\admin\model\Log as LogModel;
use think\Exception;

/**
 * 管理员权限组控制器
 * Class Sysusergroup
 * @package app\admin\controller
 */
class Menus extends Base
{
    public function _initialize()
    {
        parent::_initialize();
        $this->menusModel = model('Menus');
        $this->menusTypeModel = model('MenusType');

        //获取所有菜单类型
        $type_list = DB::table($this->menusTypeModel->getTable())->select();
        $this->assign('typeList',$type_list);
    }

    public function index(){
        //获取所有导航内容
        $type = intval(input('type',0));
        if( $type > 0 ){
            $where['menus_type'] = ['=',$type];
        }
        $where['pid'] = ['=',0];
        $nav_all = DB::table($this->menusModel->getTable())
            ->where($where)
            ->order('sequence','desc')
            ->select();
        //配置树状结构
        $nav_list = $this->getMenuTree($nav_all,$type);
        p($nav_list);
        exit;
        $this->assign('nav_list',$nav_list);
        return $this->fetch();
    }

    /**
     * 配置树状结构
     * @param $menulist
     * @param $type
     */
    public function getMenuTree($menuSt,$type){
        if( !empty($menuSt) ){
            foreach( $menuSt as $key => $list ){
                $where['pid'] = ['=',$list['id']];
                if( $type > 0 ){
                    $where['menus_type'] = ['=',$type];
                }
                $nav_son = DB::table($this->menusModel->getTable())
                    ->where($where)
                    ->order('sequence','desc')
                    ->select();
                if( !empty($nav_son) ){
                    $nav_son = $this->getMenuTree($nav_son,$type);
                }
                $menuSt[$key]['child'] = $nav_son;
            }
        }
        return $menuSt;
    }

    //添加导航菜单
    public function create_menu(){
        $data = input('.post');
        try{
            if( empty($data['menu_name']) )
                throw new Exception('导航名不能为空');

            $insertData['menu_name'] = trim($data['menu_name']);
            //父级id
            if( empty($data['menus_type']) && intval($data['menus_type']) )
                throw new Exception('导航类型必须设置');

            $insertData['menus_type'] = intval($data['menus_type']);
            //检查类型是否存在
            $checkState = Db::table($this->menusTypeModel->getTable())
                ->where('id',$insertData['menus_type'])
                ->find();
            if( empty($checkState) )
                throw new Exception('导航类型不存在');

            $insertData['menu_url'] = empty($data['menu_url']) ? '' : $data['menu_url'];
            $insertData['menu_icon'] = empty($data['menu_icon']) ? '' : $data['menu_icon'];
            $insertData['pid'] = empty($data['pid']) ? 0 : $data['pid'];
            $insertData['sequence'] = empty($data['sequence']) ? 0 : $data['sequence'];
            $t = time();
            $insertData['add_time'] = $t;
            $insertData['edit_time'] = $t;
            Db::startTrans();
            if( Db::table($this->menusModel->getTable())->insert($insertData) === false )
                throw new Exception('网络错误，添加失败');

            //记录日志
            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::INSERT,'添加导航菜单：'.$insertData['menu_name']) === false )
                throw new Exception('网络错误，操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'添加成功');
    }

    //编辑导航菜单信息
    public function update_menu(){
        $data = input('.post');
        try{
            if( empty($data['id']) && intval($data['id']) > 0 )
                throw new Exception('参数错误');

            $where['id'] = ['=',$data['id']];
            if( empty($data['menu_name']) )
                throw new Exception('导航名不能为空');

            $updateData['menu_name'] = trim($data['menu_name']);
            //父级id
            if( empty($data['menus_type']) && intval($data['menus_type']) )
                throw new Exception('导航类型必须设置');

            $updateData['menus_type'] = intval($data['menus_type']);
            //检查类型是否存在
            $checkState = Db::table($this->menusTypeModel->getTable())
                ->where('id',$updateData['menus_type'])
                ->find();
            if( empty($checkState) )
                throw new Exception('导航类型不存在');

            $updateData['menu_url'] = empty($data['menu_url']) ? '' : $data['menu_url'];
            $updateData['menu_icon'] = empty($data['menu_icon']) ? '' : $data['menu_icon'];
            $updateData['pid'] = empty($data['pid']) ? 0 : $data['pid'];
            $updateData['sequence'] = empty($data['sequence']) ? 0 : $data['sequence'];
            $t = time();
            $updateData['add_time'] = $t;
            $updateData['edit_time'] = $t;
            Db::startTrans();

            if( Db::table($this->menusModel->getTable())->where($where)->update($updateData) === false )
                throw new Exception('网络错误，添加失败');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::INSERT,'添加导航菜单：'.$updateData['menu_name']) === false )
                throw new Exception('网络错误，操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'添加成功');
    }

}
