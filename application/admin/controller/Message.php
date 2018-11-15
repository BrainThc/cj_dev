<?php
namespace app\admin\controller;
use think\Db;
use think\Controller;
use app\admin\model\Message as MessageModel;
use app\admin\model\Log as LogModel;
use think\Exception;

class Message extends Base
{
    public function _initialize()
    {
        parent::_initialize();
        $this->message = model('Message');
    }

    public function index(){
        $param = input('get.');
        $statusReadList = MessageModel::$map_read_status;
        $statusReplyList = MessageModel::$map_reply_status;
        $where = [];
        //id
        if( isset($param['id']) && !empty($param['id']) ){
            $where['mess_id'] = ['=',intval($param['id'])];
        }
        //阅读状态
        if( isset($param['readStatus']) && isset($statusReadList[$param['readStatus']]) ){
            $where['read_status'] = ['=',$param['readStatus']];
        }
        //回复状态
        if( isset($param['replyStatus']) && isset($statusReplyList[$param['replyStatus']]) ){
            $where['reply_status'] = ['=',$param['replyStatus']];
        }
        $order['read_status'] = 'asc';
        $order['reply_status'] = 'asc';
        $order['add_time'] = 'desc';
        $list = Db::table($this->message->getTable())
            ->where($where)
            ->order($order)
            ->paginate();
        $pageHtml = $list->render();
        $pageHtml = empty($pageHtml) ? '' : $pageHtml;
        $this->assign('list',$list);
        $this->assign('page',$pageHtml);
        $this->assign('statusReadList',$statusReadList);
        $this->assign('statusReplyList',$statusReplyList);
        return $this->fetch();
    }

    //查看内容
    public function read(){
        $id = input('param.id',0);
        if( $id <= 0 )
            noPermission();

        $info = Db::table($this->message->getTable())
            ->where('mess_id',$id)
            ->find();

        if( empty($info) )
            noPermission();

        //获取留言列表
        $info['reply_list'] = Db::table($this->message->getTable('message_reply'))
            ->where('mess_id',$id)
            ->order('add_time','asc')
            ->select();

        $this->assign('info',$info);
        $this->assign('statusReadList',MessageModel::$map_read_status);
        $this->assign('statusReplyList',MessageModel::$map_reply_status);
        $this->assign('userType',MessageModel::$map_user_type);
        return $this->fetch();
    }

    //回复操作
    public function do_reply(){
        try {
            $insertData['mess_id'] = intval(input('post.mess_id',''));
            if( $insertData['mess_id'] <= 0 )
                throw new Exception('参数错误');

            //获取留言主内容
            $where['mess_id'] = ['=',$insertData['mess_id']];
            $info = Db::table($this->message->getTable())
                ->where($where)
                ->find();

            if( empty($info) )
                throw new Exception('参数错误');

            $insertData['content'] = input('post.content','');
            if( empty($insertData['content']) )
                throw new Exception('回复内容不能为空');

            $t = time();
            $insertData['author_id'] = $this->sysUserId;
            $insertData['author_type'] = MessageModel::ADMIN;
            $insertData['mess_title'] = '';
            $insertData['add_time'] = $t;
            $insertData['edit_time'] = $t;

            Db::startTrans();
            if( Db::table($this->message->getTable('message_reply'))->insert($insertData) === false )
                throw new Exception('网络错误，添加失败');

            //更新主内容状态
            $updateData['author_read_status'] = 0;
            $updateData['reply_status'] = 1;
            $updateData['read_status'] = 1;
            $updateData['edit_time'] = $t;
            $updateState = Db::table($this->message->getTable())->where($where)->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误，回复失败');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::INSERT,'回复会员留言id：'.$insertData['mess_id']) === false )
                throw new Exception('网络错误，回复失败');

            Db::commit();
        } catch ( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'回复成功');
    }

    //删除回复
    public function del_reply(){
        $id = intval(input('post.reply_id',0));
        try{
            if( $id <= 0 )
                throw new Exception('参数错误');

            $where['reply_id'] = $id;
            $info = Db::table($this->message->getTable('message_reply'))->where($where)->find();
            if( empty($info) )
                throw new Exception('参数错误');

            Db::startTrans();
            $status = Db::table($this->message->getTable('message_reply'))->where($where)->delete();
            if( empty($status) )
                throw new Exception('网络错误，操作失败');

            //添加日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::DEL,'删除留言回复 留言id：'.$info['mess_id']) === false )
                throw new Exception('网络错误，操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'删除成功');
    }

}