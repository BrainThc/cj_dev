<?php
namespace app\admin\controller;
use think\Db;
use app\admin\model\Log as LogModel;
use think\Exception;

class Articlecate extends Base
{

    public function _initialize()
    {
        parent::_initialize();
        $this->articleCateModel = model('ArticleCate');
    }

    //主页
    public function index(){
        return $this->fetch();
    }

    //获取所有栏目
    public function get_cate_list(){
        $cate_list = Db::table($this->articleCateModel->getTable())
            ->where('pid',0)
            ->order('sequence','desc')
            ->select();

        //获取树状配置
        if( !empty($cate_list) ){
            $cate_list = $this->articleCateModel->getCateTree($cate_list);
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

    //添加页面
    public function add(){
        return $this->fetch();
    }

    //添加栏目
    public function create_cate(){
        $data = input('post.');
        try{
            $insertData['cate_name'] = empty($data['cate_name']) ? '' : trim($data['cate_name']);
            if( $insertData['cate_name'] == '' )
                throw new Exception('栏目名不能为空');

            $insertData['pid'] = empty($data['pid']) ? 0 : intval($data['pid']);
            //检查上级是否存在
            if( $insertData['pid'] > 0 ){
                $checkInfo = Db::table($this->articleCateModel->getTable())->where('art_cate_id',$insertData['pid'])->find();
                if( empty($checkInfo) ){
                    throw new Exception('上级栏目不存在');
                }
            }
            $insertData['sequence'] = empty($data['sequence']) ? 0 : intval($data['sequence']);

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

    //更改排序
    public function update_sequence(){
        $data = input('post.');
        try{
            if( empty($data['art_cate_id']) )
                throw new Exception('参数错误');

            $art_cate_id = intval($data['art_cate_id']);
            $where['art_cate_id'] = ['=',$art_cate_id];
            //检查栏目是否存在
            $info = Db::table($this->articleCateModel->getTable())->where($where)->find();
            if( empty($info) )
                throw new Exception('参数错误');

            $updateData['sequence'] = empty($data['sequence']) ? 0 : intval($data['sequence']);
            Db::startTrans();
            $updateState = Db::table($this->articleCateModel->getTable())->where($where)->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误，保存失败');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::UPDATES,'修改“'.$info['cate_name'].'”文章栏目排序') === false )
                throw new Exception('网络错误，操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'修改成功');
    }

    //编辑页面
    public function edit(){
        $id = intval(input('param.id',0));

        if( $id  <= 0 )
            noPermission();

        $where['art_cate_id'] = ['=',$id];
        //检查是否存在
        $info = Db::table($this->articleCateModel->getTable())->where($where)->find();
        if( empty($info) )
            noPermission();

        $this->assign('info',$info);
        return $this->fetch();
    }

    //提交编辑
    public function update_cate(){
        $data = input('post.');
        try{
            $data['art_cate_id'] = empty($data['art_cate_id']) ? 0 : intval($data['art_cate_id']);
            if( $data['art_cate_id'] <= 0 )
                throw new Exception('参数错误');

            $where['art_cate_id'] = ['=',$data['art_cate_id']];
            //检查是否存在
            $info = Db::table($this->articleCateModel->getTable())->where($where)->find();
            if( empty($info) )
                throw new Exception('参数错误');

            $updateData['cate_name'] = empty($data['cate_name']) ? '' : trim($data['cate_name']);
            if( $updateData['cate_name'] == '' )
                throw new Exception('栏目名不能为空');

            $updateData['pid'] = empty($data['pid']) ? 0 : intval($data['pid']);
            $updateData['sequence'] = empty($data['sequence']) ? 0 : intval($data['sequence']);
            $updateData['edit_time'] = time();

            Db::startTrans();
            $updateState = Db::table($this->articleCateModel->getTable())->where($where)->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误，保存失败');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::UPDATES,'编辑文章栏目：'.$info['cate_name']) === false )
                throw new Exception('网络错误，操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'保存成功');
    }

    public function del_cate(){
        $ids = input('post.id');
        try{
            $data['art_cate_id'] = empty($ids) ? 0 : intval($ids);
            if( $data['art_cate_id'] <= 0 )
                throw new Exception('参数错误');

            $where['art_cate_id'] = ['=',$data['art_cate_id']];
            //检查是否存在
            $info = Db::table($this->articleCateModel->getTable())->where($where)->find();
            if( empty($info) )
                throw new Exception('参数错误');

            //检查是否有文章
            $articleModel = model('article');
            $artile_info = Db::table($articleModel->getTable())->where($where)->find();
            if( !empty($artile_info) )
                throw new Exception('栏目内存文章不能删除');

            Db::startTrans();
            $status = Db::table($this->articleCateModel->getTable())->where($where)->delete();
            if( empty($status) )
                throw new Exception('网络错误，操作失败');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::DEL,'删除文章栏目：'.$info['cate_name']) === false )
                throw new Exception('网络错误，操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'删除成功');
    }

}