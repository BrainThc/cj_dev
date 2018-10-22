<?php
namespace app\admin\controller;
use think\Db;
use app\admin\model\Log as LogModel;
use think\Exception;

class Goodscate extends Base
{
    public function _initialize()
    {
        parent::_initialize();
        $this->goodsCateModel = model('GoodsCategory');
    }

    public function index(){
        return $this->fetch();
    }

    //获取所有栏目
    public function get_cate_list(){
        $cate_list = Db::table($this->goodsCateModel->getTable())
            ->where('pid',0)
            ->order('sequence','desc')
            ->select();

        //获取树状配置
        if( !empty($cate_list) ){
            $cate_list = $this->goodsCateModel->getCateTree($cate_list);
        }
        $cate_all = [];
        $cate_list = $this->set_cate_list($cate_list,0,$cate_all);
        returnJson(true,'success',$cate_list);
    }

    public function set_cate_list($list,$pNum,$cate_all){
        foreach($list as $k => $i ){
            $i['pNum'] = $pNum;
            $cate_all[] = $i;
            if( !empty($i['child']) ){
                $cate_all = $this->set_cate_list($i['child'],$pNum+1,$cate_all);
            }
        }
        foreach( $cate_all as $key => $cate ){
            if( isset($cate['child'])){
                unset($cate['child']);
            }
            $cate_all[$key] = $cate;
        }
        return $cate_all;
    }

    public function add(){
        return $this->fetch();
    }

    //创建分类提交
    public function create_cate(){
        $data = input('post.');
        try{
            if( empty($data['cate_name']) )
                throw new Exception('分类名不能为空');

            $insertData['cate_name'] = trim($data['cate_name']);
            $insertData['description'] = empty($data['desc']) ? '' : $data['desc'];
            $insertData['cate_icon'] = empty($data['cate_icon']) ? '' : trim($data['cate_icon']);
            $insertData['pid'] = empty($data['pid']) ? 0 : intval($data['pid']);
            $insertData['sequence'] = empty($data['sequence']) ? 0 : $data['sequence'];
            $t = time();
            $insertData['add_time'] = $t;
            $insertData['edit_time'] = $t;
            Db::startTrans();
            if( Db::table($this->goodsCateModel->getTable())->insert($insertData) === false )
                throw new Exception('网络错误，添加失败');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::INSERT,'添加商品分类：'.$insertData['cate_name']) === false )
                throw new Exception('网络错误，添加失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'添加成功');
    }

    //编辑页面
    public function edit(){
        $ids = intval(input('param.id',0));
        if( $ids  <= 0 )
            noPermission();

        $where['cate_id'] = ['=',$ids];
        $info = Db::table($this->goodsCateModel->getTable())
            ->where($where)
            ->find();
        if( empty($info) )
            noPermission();

        $this->assign('info',$info);
        return $this->fetch();
    }

    //编辑分类提交
    public function update_cate(){
        $data = input('post.');
        try{
            if( empty($data['cate_id']) )
                throw new Exception('参数错误');

            //检查是否存在
            $where['cate_id'] = ['=',intval($data['cate_id'])];
            $info = Db::table($this->goodsCateModel->getTable())
                ->where($where)
                ->find();
            if( empty($info) )
                throw new Exception('参数错误');

            if( empty($data['cate_name']) )
                throw new Exception('分类名不能为空');

            $updateData['cate_name'] = trim($data['cate_name']);
            $updateData['description'] = empty($data['desc']) ? '' : $data['desc'];
            $updateData['cate_icon'] = empty($data['cate_icon']) ? '' : trim($data['cate_icon']);
            $updateData['pid'] = empty($data['pid']) ? 0 : intval($data['pid']);
            $updateData['sequence'] = empty($data['sequence']) ? 0 : $data['sequence'];
            $t = time();
            $updateData['edit_time'] = $t;
            Db::startTrans();
            $updateState = Db::table($this->goodsCateModel->getTable())->where($where)->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误，保存失败');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::UPDATES,'编辑商品分类：'.$info['cate_name']) === false )
                throw new Exception('网络错误，保存失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'保存成功');
    }

    //修改排序
    public function update_sequence(){
        $data = input('post.');
        try{
            if( empty($data['cate_id']) )
                throw new Exception('参数错误');

            $cate_id = intval($data['cate_id']);
            $where['cate_id'] = ['=',$cate_id];
            //检查是否存在
            $info = Db::table($this->goodsCateModel->getTable())->where($where)->find();
            if( empty($info) )
                throw new Exception('参数错误');

            $updateData['sequence'] = empty($data['sequence']) ? 0 : intval($data['sequence']);
            Db::startTrans();
            $updateState = Db::table($this->goodsCateModel->getTable())->where($where)->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误，保存失败');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::UPDATES,'修改 “'.$info['cate_name'].'” 商品分类排序') === false )
                throw new Exception('网络错误，操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'修改成功');

    }

}