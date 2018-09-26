<?php
namespace app\admin\controller;
use app\admin\model\Article as ArticleModel;
use app\admin\model\Log as LogModel;
use think\Db;
use think\Exception;

class Article extends Base
{

    public function _initialize()
    {
        parent::_initialize();
        $this->articleModel = model('Article');
    }

    public function index(){
        $where = [];
        //关键词搜索
        $keyword = input('keyword','');
        if( $keyword != '' ){
            $where['title'] = ['like',"%{$keyword}%"];
        }
        //栏目筛选
        $art_cate_id = intval(input('cate_id',0));
        if( $art_cate_id > 0 ){
            $where['art_cate_id'] = ['=',$art_cate_id];
        }
        //状态筛选
        $status = intval(input('status',0));
        if( $status > 0 ){
            $where['status'] = ['=',$status];
        }

        $order['sequence'] = 'desc';
        $order['add_time'] = 'desc';
        $order['article_id'] = 'desc';

        $list = Db::table($this->articleModel->getTable())
            ->where($where)
            ->order($order)
            ->paginate(15);

        if( !empty($list) ){
            foreach( $list as $key => $value ){
                $value['edit_date'] = date('Y-m-d H:i:s',$value['edit_time']);
                $list[$key] = $value;
            }
        }

        $page = $list->render();
        $this->assign('list',$list);
        $this->assign('page',$page);
        return $this->fetch();
    }

    //添加页
    public function add(){
        return $this->fetch();
    }

    //添加文章提交
    public function create_article(){
        $data = input('post.');
        try{
            //文章名
            $insertData['title'] = empty($data['title']) ? '' : trim($data['title']);
            if( $insertData['title'] == '' )
                throw new Exception('文章名不能为空');

            //栏目类型
            $insertData['art_cate_id'] = empty($data['art_cate_id']) ? 0 : intval($data['art_cate_id']);
            //检查栏目类型
            if( $insertData['art_cate_id'] > 0 ){
                $articleCateModel = model('articleCate');
                $checkCate = Db::table($articleCateModel->getTable())->where('art_cate_id',$insertData['art_cate_id'])->find();
                if( empty($checkCate) )
                    throw new Exception('栏目不存在');

            }
            //关键词
            $insertData['keyword'] = empty($data['keyword']) ? '' : trim($data['keyword']);
            //描述
            $insertData['description'] = empty($data['description']) ? '' : trim($data['description']);
            //文章内容
            $insertData['content'] = empty($data['content']) ? '' : trim($data['content']);
            //排序
            $insertData['sequence'] = empty($data['sequence']) ? 0 : intval($data['sequence']);
            //阅读权限
            $insertData['read_group'] = empty($data['read_group']) ? 0 : intval($data['read_group']);
            if( !isset(ArticleModel::$map_readgroup[$insertData['read_group']]) )
                throw new Exception('不存在用户类型');

            $t = time();
            $insertData['add_time'] = $t;
            $insertData['edit_time'] = $t;
            Db::startTrans();
            if( Db::table($this->articleModel->getTable())->insert($insertData) === false )
                throw new Exception('网络错误，添加失败');

            //记录日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::INSERT,'添加文章：'.$insertData['title']) === false )
                throw new Exception('网络错误，操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'添加成功');
    }

    /**
     *  设置文章推荐
     */
    public function set_update(){
        $art_id = input('post.article_id',0);

        try{
            if( intval($art_id) <= 0 )
                throw new Exception('参数错误');

            //检查是否存在
            $art_info = Db::table($this->articleModel->getTable())
                ->where('article_id',$art_id)
                ->find();
            if( empty($art_info)  )
                throw new Exception('参数错误');

            Db::startTrans();
            $updateData['recommend'] = $art_info['recommend'] ? 0 : 1;
            $where['article_id'] = ['=',$art_id];
            $updateState = Db::table($this->articleModel->getTable())->where($where)->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误,操作失败');

            //日志记录
            $logModel = model('Log');
            if( $logModel->note(LogModel::UPDATES,"推荐文章：".$art_info['title']." 文章id：".$art_id) === false )
                throw new Exception('网络错误,操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,'参数错误');
        }
        returnJson(true,'操作成功');
    }

    /*
     *  删除文章
     */
    public function set_deleted(){
        $art_id = input('post.article_id',0);
        try{
            if( intval($art_id) <= 0 )
                throw new Exception('参数错误');

            //检查是否存在
            $art_info = Db::table($this->articleModel->getTable())
                ->where('article_id',$art_id)
                ->find();
            if( empty($art_info)  )
                throw new Exception('参数错误');

            Db::startTrans();
            $updateData['deleted'] = empty($data['deleted']) ? 1 : $data['deleted'];
            $where['article_id'] = ['=',$art_id];
            $updateState = Db::table($this->articleModel->getTable())->where($where)->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误,操作失败');

            //日志记录
            $logModel = model('Log');
            $msg = empty($data['deleted']) ? '删除' : '恢复';
            if( $logModel->note(LogModel::UPDATES,$msg."文章：".$art_info['title']." 文章id：".$art_id) === false )
                throw new Exception('网络错误,操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,'参数错误');
        }
        returnJson(true,'操作成功');
    }

    //编辑页面
    public function edit(){
        return $this->fetch();
    }

    //编辑保存文章接口
    public function update_article(){
        $data = input('post.');
        try{
            if( empty($data['article_id']) || intval($data['article_id']) <= 0 )
                throw new Exception('参数错误');

            $art_info = Db::table($this->articleModel->getTable())
                ->where('article_id',$data['article_id'])
                ->find();
            if( empty($art_info) )
                throw new Exception('文章名不能为空');

            $where['art_id'] = ['=',$art_info['article_id']];
            //栏目类型
            $updateData['art_cate_id'] = empty($data['art_cate_id']) ? 0 : intval($data['art_cate_id']);
            //检查栏目类型
            if( $updateData['art_cate_id'] > 0 ){
                $articleCateModel = model('articleCate');
                $checkCate = Db::table($articleCateModel->getTable())->where('art_cate_id',$updateData['art_cate_id'])->find();
                if( empty($checkCate) )
                    throw new Exception('栏目不存在');

            }
            //关键词
            $updateData['keyword'] = empty($data['keyword']) ? '' : trim($data['keyword']);
            //描述
            $updateData['description'] = empty($data['description']) ? '' : trim($data['description']);
            //文章内容
            $updateData['content'] = empty($data['content']) ? '' : trim($data['content']);
            //排序
            $updateData['sequence'] = empty($data['sequence']) ? 0 : intval($data['sequence']);
            //阅读权限
            $updateData['read_group'] = empty($data['read_group']) ? 0 : intval($data['read_group']);
            //文章名
            $updateData['edit_time'] = time();
            //阅读权限
            if( !isset(ArticleModel::$map_readgroup[$updateData['read_group']]) )
                throw new Exception('不存在用户类型');

            Db::startTrans();
            $updateState = Db::table($this->articleModel->getTable())
                ->where($where['art_id'])
                ->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误，保存失败');

            //记录日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::UPDATES,'编辑文章id：'.$art_info['article_id']) === false )
                throw new Exception('网络错误，操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'保存成功');
    }

}