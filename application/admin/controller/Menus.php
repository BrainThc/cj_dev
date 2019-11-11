<?php
namespace app\admin\controller;
use app\admin\model\Log as LogModel;
use think\Exception;

/**
 * 导航管理控制器
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

    //获取所有导航类型列表
    public function get_menus_type(){
        //获取所有菜单类型
        $type_list =$this->menusTypeModel->select();
        returnJson(true,'success',$type_list);
    }

    //获取所有导航列表
    public function get_menus_list(){
        //获取所有导航内容
        $data = input('post.',0);
        $where['is_deleted'] = ['=',0];
        if( isset($data['type']) && !empty($data['type']) ){
            $where['menus_type_id'] = ['=',$data['type']];
        }
        if(isset($data['pid'])){//获取某父级下的子级
            $where['pid'] = $data['pid'];
            $whereOr['id'] = $data['pid'];
        }
        $menus_all = $this->menusModel
            ->where($where)
            ->order('sequence','desc')
            ->select();
        if( !empty($menus_all) ){
            foreach( $menus_all as $k => $v ){
                $v['name'] = $v['menu_name'];
                $v['value'] = $v['id'];
                $cateAll[$k] = $v;
            }
        }
        $geType = empty($data['showType']) ? 'list' : $data['showType'];
        switch( $geType ){
            case 'tree' ://普通多维树状数组
                $list = setTree($menus_all);
                break;
            case 'tree_list' ://一维数组分层列表 (注意占用进程资源问题)
                $list = setTreeList(setTree($menus_all));
                break;
            default ://不作处理
                $list = $menus_all;
                break;
        }
        returnJson(true,'success',$list);
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
            $menus['name'] = $menus['menu_name'];
            $menus['value'] = $menus['id'];
            if( isset($menus['child'])){
                unset($menus['child']);
            }
            $menus_all[$key] = $menus;
        }
        return $menus_all;
    }

    //添加页
    public function add(){
        $ids = intval(input('param.typeId',0));
        if( $ids  <= 0 )
            noPermission();

        $this->assign('typeId',$ids);
        return $this->fetch();
    }

    //添加导航菜单
    public function create_menu(){
        $data = input('post.');
        try{
            if( empty($data['menu_name']) )
                throw new Exception('导航名不能为空');

            $insertData['menu_name'] = trim($data['menu_name']);
            //父级id
            if( empty($data['menus_type_id']) && intval($data['menus_type_id']) )
                throw new Exception('导航类型必须设置');

            $insertData['menus_type_id'] = intval($data['menus_type_id']);
            //检查类型是否存在
            $checkState = $this->menusTypeModel
                ->where('id',$insertData['menus_type_id'])
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
            $this->menusModel->startTrans();
            if( $this->menusModel->insert($insertData) === false )
                throw new Exception('网络错误，添加失败');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::INSERT,'添加导航菜单：'.$insertData['menu_name']) === false )
                throw new Exception('网络错误，添加失败');

            $this->menusModel->commit();
        }catch( Exception $e ){
            $this->menusModel->rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'添加成功');
    }

    //编辑页面
    public function edit(){
        $ids = intval(input('param.id',0));
        if( $ids  <= 0 )
            noPermission();

        $where['id'] = ['=',$ids];
        $info = $this->menusModel->where($where)->find();
        if( empty($info) )
            noPermission();

        $this->assign('info',$info);
        return $this->fetch();
    }

    //编辑导航菜单信息
    public function update_menu(){
        $data = input('post.');
        try{
            if( empty($data['menu_id']) && intval($data['menu_id']) > 0 )
                throw new Exception('参数错误');

            $where['id'] = ['=',$data['menu_id']];
            //检查是否存在
            $info = $this->menusModel->where($where)->find();
            if( empty($info) )
                throw new Exception('参数错误');

            if( empty($data['menu_name']) )
                throw new Exception('导航名不能为空');

            $updateData['menu_name'] = trim($data['menu_name']);

            //父级id
            if( !empty($data['menus_type_id']) && intval($data['menus_type_id']) > 0 ) {
                $updateData['menus_type_id'] = intval($data['menus_type_id']);
                //检查类型是否存在
                $checkState = $this->menusTypeModel->where('id', $updateData['menus_type_id'])->find();
                if (empty($checkState))
                    throw new Exception('导航类型不存在');

            }

            $updateData['menu_url'] = empty($data['menu_url']) ? '' : $data['menu_url'];
            $updateData['menu_icon'] = empty($data['menu_icon']) ? '' : $data['menu_icon'];
            $updateData['pid'] = empty($data['pid']) ? 0 : $data['pid'];
            $updateData['sequence'] = empty($data['sequence']) ? 0 : $data['sequence'];
            $t = time();
            $updateData['edit_time'] = $t;
            $this->menusModel->startTrans();

            $updateState = $this->menusModel->where($where)->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误，保存失败');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::UPDATES,'编辑导航菜单：'.$info['menu_name']) === false )
                throw new Exception('网络错误，保存失败');

            $this->menusModel->commit();
        }catch( Exception $e ){
            $this->menusModel->rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'保存成功');
    }

    //修改排序
    public function update_sequence(){
        $data = input('post.');
        try{
            if( empty($data['id']) )
                throw new Exception('参数错误');

            $menu_id = intval($data['id']);
            $where['id'] = ['=',$menu_id];
            //检查栏目是否存在
            $info = $this->menusModel->where($where)->find();
            if( empty($info) )
                throw new Exception('参数错误');

            $updateData['sequence'] = empty($data['sequence']) ? 0 : intval($data['sequence']);
            $this->menusModel->startTrans();
            $updateState = $this->menusModel->where($where)->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误，保存失败');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::UPDATES,'修改 “'.$info['menu_name'].'” 导航排序') === false )
                throw new Exception('网络错误，操作失败');

            $this->menusModel->commit();
        }catch( Exception $e ){
            $this->menusModel->rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'修改成功');

    }

    //删除导航
    public function del_menu(){
        $ids = input('post.id');
        try{
            $data['id'] = empty($ids) ? 0 : intval($ids);
            if( $data['id'] <= 0 )
                throw new Exception('参数错误');

            $where['id'] = ['=',$data['id']];
            //检查是否存在
            $info = $this->menusModel->where($where)->find();
            if( empty($info) )
                throw new Exception('参数错误');

            $this->menusModel->startTrans();
            $updateData['is_deleted'] = 1;
            $status = $this->menusModel->where($where)->update($updateData);
            if( empty($status) )
                throw new Exception('网络错误，操作失败');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::DEL,'删除导航：'.$info['menu_name']) === false )
                throw new Exception('网络错误，操作失败');

            $this->menusModel->commit();
        }catch( Exception $e ){
            $this->menusModel->rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'删除成功');
    }

    //添加导航类型
    public function add_menus_type(){
        $data = input('post.');
        try{
            if( empty($data['type_name']) )
                throw new Exception('参数错误');

            //检查是否已经存在
            $insertData['type_name'] = trim($data['type_name']);
            $where['type_name'] = ['=',$insertData['type_name']];
            $checkInfo = $this->menusTypeModel->where($where)->find();
            if( !empty($checkInfo) )
                throw new Exception('该类型已存在');

            $t = time();
            $insertData['desc'] = trim($data['type_name']);
            $insertData['sequence'] = empty($data['sequence']) ? 0 : inteval($data['sequence']);
            $insertData['add_time'] = $t;
            $insertData['edit_time'] = $t;

            $this->menusTypeModel->startTrans();
            if( $this->menusTypeModel->insert($insertData) === false )
                throw new Exception('网络错误，操作失败');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::INSERT,'添加导航类型：'.$insertData['type_name']) === false )
                throw new Exception('网络错误，操作失败');

            $this->menusTypeModel->commit();
        }catch( Exception $e ){
            $this->menusTypeModel->rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'添加成功');
    }

}
