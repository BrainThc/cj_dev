<?php
namespace app\admin\controller;
use think\Db;
use think\Controller;
use think\Exception;

class Articlecate extends Controller
{

    public function _initialize()
    {
        parent::_initialize();
        $this->articleCateModel = model('ArticleCate');
    }

    public function index(){
        //获取所有栏目分类
        $cate_list = Db::table($this->articleCateModel->getTable())
            ->where('pid',0)
            ->order('sequence','desc')
            ->select();
        //获取树状配置
        if( !empty($cate_list) ){
            $cate_list = $this->articleCateModel->getCateTree($cate_list);
        }

        $this->assign('cate_list',$cate_list);
        return $this->fetch();
    }

    //添加页面
    public function add(){
        $this->fetch();
    }

    //添加栏目
    public function create_cate(){
        $data = input('.post');
        try{
            $insertData['cate_name'] = empty($data['cate_name']) ? '' : trim($data['cate_name']);
            if( $insertData['cate_name'] == '' )
                throw new Exception('栏目名不能为空');

            $insertData['pid'] = empty($data['pid']) ? 0 : intval($data['pid']);
            $insertData['sequence'] = empty($data['sequence']) ? 0 : intval($data['sequence']);
            if( $insertData['pid'] < 0 || $insertData['sequence'] < 0 )
                throw new Exception('参数错误');

            $t = time();
            $insertData['add_time'] = $t;
            $insertData['edit_time'] = $t;
            Db::startTrans();
            if( Db::table($this->articleCateModel->getTable())->insert($insertData) === false )
                throw new Exception('网络错误，添加失败');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::INSERT,'添加文章栏目：'.$insertData['cate_name']) === false )
                throw new Exception('网络错误，操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'添加成功');
    }

    //编辑页面
    public function edit(){
        $this->fetch();
    }

    //提交编辑
    public function update_cate(){
        $data = input('.post');
        try{
            if( empty($data['art_cate_id']) || intval($data['art_cate_id']) <= 0 )
                throw new Exception('参数错误');

            $where['art_cate_id'] = ['=',intval($data['art_cate_id'])];
            //检查是否存在
            $info = Db::table($this->articleCateModel->getTable())->where($where)->find();
            if( empty($info) )
                throw new Exception('参数错误');

            $updateData['cate_name'] = empty($data['cate_name']) ? '' : trim($data['cate_name']);
            if( $updateData['cate_name'] == '' )
                throw new Exception('参数错误');

            $updateData['pid'] = empty($data['pid']) ? 0 : intval($data['pid']);
            $updateData['sequence'] = empty($data['sequence']) ? 0 : intval($data['sequence']);
            if( $updateData['sequence'] < 0 || $updateData['sequence'] < 0  )
                throw new Exception('参数错误');

            $updateData['edit_time'] = time();
            Db::startTrans();
            $updateState = Db::table($this->articleCateModel->getTable())->where($where)->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误，保存失败');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::UPDATES,'编辑文章栏目：'.$updateData['cate_name']) === false )
                throw new Exception('网络错误，操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'保存成功');
    }



}