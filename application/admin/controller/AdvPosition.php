<?php
namespace app\admin\controller;
use think\Db;
use app\admin\model\Log as LogModel;
use app\admin\model\AdvPosition as AdvPostModel;
use think\Exception;

/**
 * 广告位控制器
 * Class Sysusergroup
 * @package app\admin\controller
 */
class AdvPosition extends Base
{

    public function _initialize()
    {
        parent::_initialize();
        $this->advPositionModel = model('AdvPosition');
    }

    //获取所有广告位
    public function get_advpost_list(){
        $where = [];
        $page_param = [];
        $where['status'] = ['=',1];
        if( isset($this->in_data['keyword']) && !empty($this->in_data['keyword']) ) {
            $keyword = trim($this->in_data['keyword']);
            $where['pos_name'] = ['like', "%{$keyword}%"];
            $page_param['keyword'] = $keyword;
        }
        if( isset($this->in_data['pos_id']) && !empty($this->in_data['pos_id']) ) {
            $pos_id = intval($this->in_data['pos_id']);
            $where['pos_id'] = ['=', $pos_id];
            $page_param['pos_id'] = $pos_id;
        }
        $cont = input('post.cont_type','advposition');
        $page = intval(input('page',1));
        $size = 10;
        $pageLimit = (($page - 1) * $size).','.$size;
        $list = $this->advPositionModel->where($where)
            ->order('pos_id','asc')
            ->limit($pageLimit)->select();
        $count = $this->advPositionModel->field('count(*)')
            ->where($where)
            ->order('pos_id','asc')
            ->count();
        if( !empty($list) ){
            foreach( $list as $k => $v ){
                $v['pos_type'] = AdvPostModel::$map_type[$v['pos_type']];
                $v['pos_adv_num'] = $v['pos_adv_num'] > 0 ? $v['pos_adv_num'] : '无限制';
                $v['size'] = $v['width'].' * '.$v['height'];
                $list[$k] = $v;
            }
        }

        //分页工具
//        $pageHtml = $list->render();
//        $info['page'] = empty($pageHtml) ? '' : $pageHtml;
        returnJson(true,'success',$list,['count'=>$count]);
    }

    //添加广告位页
//    public function add(){
//        $this->assign('pos_type_list',AdvPostModel::$map_type);
//        return $this->fetch();
//    }

    //添加广告位
    public function create_pos(){
        $data = input('post.');
        try{
            if( empty($data['pos_name']) || empty($data['pos_desc']) )
                throw new Exception('参数错误');

            $t = time();
            $insertData['pos_name'] = trim($data['pos_name']);
            $insertData['pos_desc'] = trim($data['pos_desc']);
            $insertData['pos_type'] = intval($data['pos_type']);
            $insertData['pos_adv_num'] = intval($data['pos_adv_num']);
            $insertData['width'] = empty($data['width']) ? 0 : intval($data['width']);
            $insertData['height'] = empty($data['height']) ? 0 : intval($data['height']);
            $insertData['image'] = trim($data['image']);
            $insertData['add_time'] = $t;
            $insertData['edit_time'] = $t;

            Db::startTrans();
            if( Db::table($this->advPositionModel->getTable())->insert($insertData) === false )
                throw new Exception('网络错误，添加失败');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::INSERT,'添加广告位：'.$insertData['pos_name']) === false )
                throw new Exception('网络错误，添加失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'添加成功');
    }

    public function edit(){
        $id = intval(input('param.id',0));
        if( $id <= 0 ){
            noPermission();
        }
        $where['status'] = 1;
        $where['pos_id'] = $id;
        $info = $this->advPositionModel->where($where)->find();
        if(empty($info)){
            noPermission();
        }
        $this->assign('info',$info);
        $this->assign('pos_type_list',AdvPostModel::$map_type);
        return $this->fetch($this->_act.'/'.$this->_op);
    }

    //添加广告位
    public function update_pos(){
        $data = input('post.');
        try{
            if( empty($data['pos_id']) || empty($data['pos_name']) || empty($data['pos_desc']) )
                throw new Exception('参数错误');

            $pos_id = intval($data['pos_id']);
            $where['pos_id'] = ['=',$pos_id];
            $where['status'] = ['=',1];
            $info = Db::table($this->advPositionModel->getTable())
                ->where($where)
                ->find();

            if(empty($info))
                throw new Exception('参数错误');

            $t = time();
            $insertData['pos_name'] = trim($data['pos_name']);
            $insertData['pos_desc'] = trim($data['pos_desc']);
            $insertData['pos_type'] = intval($data['pos_type']);
            $insertData['pos_adv_num'] = intval($data['pos_adv_num']);
            $insertData['width'] = empty($data['width']) ? 0 : intval($data['width']);
            $insertData['height'] = empty($data['height']) ? 0 : intval($data['height']);
            $insertData['image'] = trim($data['image']);
            $insertData['edit_time'] = $t;

            Db::startTrans();
            $updateState = Db::table($this->advPositionModel->getTable())->where($where)->update($insertData);
            if( empty($updateState) )
                throw new Exception('网络错误，保存失败');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::INSERT,'编辑广告位：'.$info['pos_name']) === false )
                throw new Exception('网络错误，保存失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'保存成功');
    }

    public function del_pos(){
        $ids = intval(input('post.pos_id',0));
        try{
            if( empty($ids) )
                throw new Exception('参数错误');

            $pos_id = $ids;
            $where['pos_id'] = ['=',$pos_id];
            $where['status'] = ['=',1];
            $info = Db::table($this->advPositionModel->getTable())
                ->where($where)
                ->find();

            if(empty($info))
                throw new Exception('参数错误');

            $t = time();
            $insertData['status'] = 0;
            $insertData['edit_time'] = $t;

            //检查是否有授权恢复key
            $keys = trim(input('post.keys',''));
            if( !empty($keys) && $keys == __COMPANYKEY__ ){
                $insertData['status'] = 1;
            }

            Db::startTrans();
            $updateState = Db::table($this->advPositionModel->getTable())->where($where)->update($insertData);
            if( empty($updateState) )
                throw new Exception('网络错误，操作失败');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::DEL,'删除广告位：'.$info['pos_name']) === false )
                throw new Exception('网络错误，操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'操作成功');
    }

}