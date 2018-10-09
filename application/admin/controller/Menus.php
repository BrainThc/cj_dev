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
    }

    public function index(){
        return $this->fetch();
    }

    //获取所有导航类型列表
    public function get_menus_type(){
        //获取所有菜单类型
        $type_list = Db::table($this->menusTypeModel->getTable())->select();
        returnJson(true,'success',$type_list);
    }

    //获取所有导航列表
    public function get_menus_list(){
        //获取所有导航内容
        $type = intval(input('post.type',0));
        if( $type > 0 ){
            $where['menus_type_id'] = ['=',$type];
        }
        $where['pid'] = ['=',0];
        $nav_all = Db::table($this->menusModel->getTable())
            ->where($where)
            ->order('sequence','desc')
            ->select();
        //配置树状结构
        $nav_list = $this->menusModel->getMenuTree($nav_all,$type);
        $menus_all = [];
        $menus_all = $this->set_menu_list($nav_list,0,$menus_all);

        returnJson(true,'success',$menus_all);
    }

    public function set_menu_list($list,$pNum,$menus_all){
        foreach($list as $k => $i ){
            $i['pNum'] = $pNum;
            $menus_all[] = $i;
            if( !empty($i['child']) ){
                $menus_all = $this->set_menu_list($i['child'],$pNum+1,$menus_all);
            }
        }
        foreach( $menus_all as $key => $menus ){
            if( isset($menus['child'])){
                unset($menus['child']);
            }
            $menus_all[$key] = $menus;
        }
        return $menus_all;
    }

    //添加导航菜单
    public function create_menu(){
        $data = input('post.');
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
        $data = input('post.');
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
            if( $logModel->note(LogModel::UPDATES,'编辑导航菜单：'.$updateData['menu_name']) === false )
                throw new Exception('网络错误，操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'添加成功');
    }

}
