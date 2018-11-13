<?php
namespace app\admin\controller;
use app\admin\model\GoodsCatePropVal as GoodsCatePropValModel;
use think\Db;
use app\admin\model\Log as LogModel;
use think\Exception;

class Goodscateprop extends Base
{
    public function _initialize()
    {
        parent::_initialize();
        $this->cateModel = model('GoodsCategory');
        $this->catePropModel = model('GoodsCateProp');
        $this->catePropValModel = model('GoodsCatePropVal');
    }

    public function index(){
        return $this->fetch();
    }

    public function prop_set(){
        $ids = input('param.id',0);
        if( $ids <= 0 ){
            noPermission();
        }
        //检查是否存在
        $info = Db::table($this->cateModel->getTable())
            ->where('cate_id',$ids)
            ->find();
        if( empty($info) ){
            noPermission();
        }
        $this->assign('info',$info);
        $this->assign('val_type',GoodsCatePropValModel::$map_type);
        return $this->fetch();
    }

    public function get_prop_list(){
        $ids = input('post.cate_id',0);
        if( $ids <= 0 ){
            returnJson(false,'参数错误');
        }
        $cate_all = $this->cateModel->getParentCate($ids);
        $prop_list = $this->catePropModel->get_prop_list($cate_all);
        returnJson(true,'success',$prop_list);
    }

    public function get_prop_val_list(){
        $ids = intval(input('post.prop_id',0));
        if( $ids <= 0 ){
            returnJson(false,'参数错误');
        }
        $prop_info = Db::table($this->catePropModel->getTable())->where('prop_id',$ids)->find();
        $info['prop_info'] = $prop_info;
        $list = Db::table($this->catePropValModel->getTable())->where('prop_id',$ids)->select();
        $info['list'] = $list;
        returnJson(true,'success',$info);
    }

    //添加属性类型
    public function create_prop(){
        $data = input('post.');
        try{
            if( empty($data['cate_id']) || empty($data['name']) )
                throw new Exception('参数错误');

            $cate_id = intval($data['cate_id']);
            if( $cate_id <= 0 )
                throw new Exception('参数错误');

            //查询分类
            $where['cate_id'] = $cate_id;
            $info = Db::table($this->cateModel->getTable())
                ->where($where)
                ->find();
            if( empty($info) )
                throw new Exception('参数错误');

            $prop_name = trim($data['name']);
            //上下级继承检查
            // $cate_list = array_merge($this->cateModel->getParentCate($cate_id,false),$this->cateModel->getChildCate($cate_id));
            //检查是否重复 (包括上级继承)
            $cate_list = $this->cateModel->getParentCate($cate_id);
            if( !empty($cate_list) ){
                $cate_str = implode(',',$cate_list);
                $checkWhere = "cate_id in ({$cate_str}) and prop_name = '".$prop_name."'";
                $checkState = Db::table($this->catePropModel->getTable())
                    ->where($checkWhere)
                    ->select();
                if( !empty($checkState) ){
                    throw new Exception('属性类型已存在');
                }
            }
            //添加
            $t = time();
            $insertData['cate_id'] = $cate_id;
            $insertData['prop_name'] = $prop_name;
            $insertData['add_time'] = $t;
            $insertData['edit_time'] = $t;
            Db::startTrans();
            if( Db::table($this->catePropModel->getTable())->insert($insertData) === false )
                throw new Exception('网络错误,添加失败');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::INSERT,'添加：'.$info['cate_name'].' 分类属性:'.$insertData['prop_name']) === false )
                throw new Exception('网络错误，添加失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'添加成功');
    }

    //添加属性类型
    public function create_prop_val(){
        $data = input('post.');
        try{
            if( empty($data['prop_id']) || empty($data['name']) )
                throw new Exception('参数错误');

            $prop_id = intval($data['prop_id']);
            if( $prop_id <= 0 )
                throw new Exception('参数错误');

            //查询分类
            $where['prop_id'] = $prop_id;
            $info = Db::table($this->catePropModel->getTable())
                ->where($where)
                ->find();
            if( empty($info) )
                throw new Exception('参数错误');

            $prop_val_name = trim($data['name']);
            //检查是否重复 (包括上级继承)
            $checkWhere = "prop_id = '{$prop_id}' and value = '{$prop_val_name}'";
            $checkState = Db::table($this->catePropValModel->getTable())
                ->where($checkWhere)
                ->select();
            if( !empty($checkState) ){
                throw new Exception('属性值已存在');
            }
            //添加
            $t = time();
            $insertData['prop_id'] = $prop_id;
            $insertData['value'] = $prop_val_name;
            $insertData['add_time'] = $t;
            $insertData['edit_time'] = $t;
            Db::startTrans();
            if( Db::table($this->catePropValModel->getTable())->insert($insertData) === false )
                throw new Exception('网络错误,添加失败');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::INSERT,'添加：分类id:'.$info['cate_id'].'属性类：'.$info['prop_name'].' 属性值：'.$insertData['value']) === false )
                throw new Exception('网络错误，添加失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'添加成功');
    }

    //获取详细
    public function get_prop_val_info(){
        $val_id = input('post.prop_val_id',0);
        if( $val_id <= 0 ){
            returnJson(false,'参数错误');
        }
        $info = Db::table($this->catePropValModel->getTable())
            ->where('prop_val_id',$val_id)
            ->find();
        if( empty($info) ){
            returnJson(false,'参数错误');
        }
        returnJson(true,'success',$info);
    }

    //更新信息
    public function update_prop(){
        $data = input('post.',[]);
        try{
            if( empty($data) )
                throw new Exception('参数错误');

            if( empty($data['prop_id']) || empty($data['prop_name']) )
                throw new Exception('参数错误');

            $t = time();
            $where['prop_id'] = ['=',intval($data['prop_id'])];
            $info = Db::table($this->catePropModel->getTable())
                ->where($where)
                ->find();
            if( empty($info) )
                throw new Exception('参数错误');

            $updateData['prop_name'] = trim($data['prop_name']);
            $updateData['description'] = empty($data['description']) ? '' : trim($data['description']);
            $updateData['edit_time'] = $t;
            $updateState = Db::table($this->catePropModel->getTable())->where($where)->update($updateData);
            if(empty($updateState))
                throw new Exception('网络错误，保存失败');

            //日志记录
            $logModel = model('Log');
            if( $logModel->note(LogModel::UPDATES,"编辑 {$info['prop_name']} 属性类型 信息 id:".$info['prop_id']) === false )
                throw new Exception('网络错误，保存失败');

        }catch( Exception $e ){
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'保存成功');
    }

    //更新信息
    public function update_prop_val(){
        $data = input('post.',[]);
        try{
            if( empty($data) )
                throw new Exception('参数错误');

            if( empty($data['prop_val_id']) || empty($data['prop_id']) || empty($data['value']) )
                throw new Exception('参数错误');

            $t = time();
            $where['prop_val_id'] = ['=',intval($data['prop_val_id'])];
            $where['prop_id'] = ['=',intval($data['prop_id'])];
            $info = Db::table($this->catePropValModel->getTable())
                ->where($where)
                ->find();
            if( empty($info) )
                throw new Exception('参数错误');

            $updateData['value'] = trim($data['value']);
            $updateData['val_type'] = empty($data['val_type']) ? 0 : intval($data['val_type']);
            $updateData['val_img'] = empty($data['val_img']) ? '' : trim($data['val_img']);
            $updateData['description'] = empty($data['description']) ? '' : trim($data['description']);
            $updateData['edit_time'] = $t;
            $updateState = Db::table($this->catePropValModel->getTable())->where($where)->update($updateData);
            if(empty($updateState))
                throw new Exception('网络错误，保存失败');

            //日志记录
            $logModel = model('Log');
            if( $logModel->note(LogModel::UPDATES,"编辑属性 {$info['value']} 分类属性信息 信息id".$info['prop_val_id']) === false )
                throw new Exception('网络错误，保存失败');
            
        }catch( Exception $e ){
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'保存成功');
    }

}