<?php
namespace app\admin\controller;
use app\admin\model\Article as ArticleModel;
use app\admin\model\Log as LogModel;
use think\Cache;
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
        $this->assign('map_readgroup',ArticleModel::$map_readgroup);
        $this->assign('map_status',ArticleModel::$map_status);
        return $this->fetch();
    }

    //获取所有文章列表
    public function get_article_list(){
        $where = [];
        $page_param = [];

        //id搜索
        $article_id = intval(input('article_id',0));
        if( $article_id > 0 ){
            $where['article_id'] = ['=',$article_id];
            $page_param['article_id'] = $article_id;
        }
        //栏目id搜索
        $art_cate_id = intval(input('art_cate_id',0));
        if( $art_cate_id > 0 ){
            $where['art_cate_id'] = ['=',$art_cate_id];
            $page_param['art_cate_id'] = $art_cate_id;
        }
        //关键词搜索
        $keyword = input('keyword','');
        if( $keyword != '' ){
            $where['title'] = ['like',"%{$keyword}%"];
            $page_param['keyword'] = $keyword;
        }
        //可读权限筛选
        $readgroup = input('readgroup','');
        if( isset(ArticleModel::$map_readgroup[$readgroup]) ){
            $where['read_group'] = ['=',$readgroup];
            $page_param['readgroup'] = $readgroup;
        }
        //状态筛选
        $status = input('status','');
        if( $status != '' ){
            $where['status'] = ['=',$status];
            $page_param['status'] = $status;
        }
        //可读筛选
        $is_show = input('is_show','');
        if( $is_show != '' ){
            $where['is_show'] = ['=',$is_show];
            $page_param['show'] = $is_show;
        }

        //是否已删除
        $where['deleted'] = ['=',0];
        $deleted = input('deleted','');
        if( $deleted != '' ){
            $where['deleted'] = ['=',$deleted];
            $page_param['deleted'] = $deleted;
        }

        $order['sequence'] = 'desc';
        $order['article_id'] = 'asc';

        $page = intval(input('page',1));;
        $list = Db::table($this->articleModel->getTable())
            ->where($where)
            ->order($order)
            ->paginate(15,false,['page'=>$page,'path'=>url('admin/article/index',$page_param)]);

        if( !empty($list) ){
            foreach( $list as $key => $value ){
                $value['oldSequence'] = $value['sequence'];
                $value['powerGroup'] = ArticleModel::$map_readgroup[$value['read_group']];
                $value['statusDesc'] = ArticleModel::$map_status[$value['status']];
                $value['edit_date'] = date('Y-m-d H:i:s',$value['edit_time']);
                $list[$key] = $value;
            }
        }
        $info['list'] = $list;
        $pageHtml = $list->render();
        $pageHtml = empty($pageHtml) ? '' : $pageHtml;
        $info['page'] = $pageHtml;
        returnJson(true,'success',$info);
    }

    //添加页
    public function add(){
        $this->assign('map_readgroup',ArticleModel::$map_readgroup);
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

            $insertData['img'] = empty($data['images']) ? '' : trim($data['images']);
            if( $insertData['img'] == '' )
                throw new Exception('文章列表图不能为空');

            //栏目类型
            $insertData['art_cate_id'] = empty($data['cate_id']) ? 0 : intval($data['cate_id']);
            //检查栏目类型
            if( $insertData['art_cate_id'] > 0 ){
                $articleCateModel = model('ArticleCate');
                $checkCate = Db::table($articleCateModel->getTable())->where('art_cate_id',$insertData['art_cate_id'])->find();
                if( empty($checkCate) )
                    throw new Exception('栏目不存在');

            }
            //icon
            $insertData['icon'] = empty($data['icon']) ? '' : trim($data['icon']);
            //关键词
            $insertData['keyword'] = empty($data['keyword']) ? '' : trim($data['keyword']);
            //描述
            $insertData['description'] = empty($data['desc']) ? '' : trim($data['desc']);
            //文章内容
            $insertData['content'] = empty($data['content']) ? '' : trim($data['content']);
            //排序
            $insertData['sequence'] = empty($data['sequence']) ? 0 : intval($data['sequence']);
            //推荐设置
            $insertData['recommend'] = empty($data['recommend']) ? 0 : intval($data['recommend']);
            //阅读权限
            $insertData['read_group'] = empty($data['readgroup']) ? 0 : intval($data['readgroup']);
            if( !isset(ArticleModel::$map_readgroup[$insertData['read_group']]) )
                throw new Exception('不存在用户类型');

            $t = time();
            $insertData['is_show'] = 0;
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

    public function edit(){
        $id = intval(input('param.id',0));
        if( $id <= 0 ) {
            noPermission();
        }
        $info = Db::table($this->articleModel->getTable())
            ->where('article_id',$id)
            ->find();
        if(empty($info)){
            noPermission();
        }
        $this->assign('info',$info);
        $this->assign('map_readgroup',ArticleModel::$map_readgroup);
        return $this->fetch();
    }

    /**
     *  设置文章排序
     */
    public function set_sequence(){
        $art_id = input('post.article_id',0);
        $sequence = intval(input('post.sequence',0));
        try{
            if( intval($art_id) <= 0 )
                throw new Exception('参数错误');

            if( $sequence < 0 )
                throw new Exception('排序不能小于0');

            $where['article_id'] = ['=',$art_id];
            //检查是否存在
            $art_info = Db::table($this->articleModel->getTable())
                ->where($where)
                ->find();
            if( empty($art_info) )
                throw new Exception('参数错误');

            if( $art_info['sequence'] == $sequence )
                throw new Exception('保存成功');

            Db::startTrans();
            $updateData['sequence'] = $sequence;
            $updateState = Db::table($this->articleModel->getTable())->where($where)->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误,操作失败');

            //日志记录
            $logModel = model('Log');
            if( $logModel->note(LogModel::UPDATES,"修改文章id：{$art_id} 排序") === false )
                throw new Exception('网络错误,操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,'参数错误');
        }
        returnJson(true,'操作成功');
    }

    /**
     *  设置文章推荐
     */
    public function set_recomm(){
        $art_id = input('post.article_id',0);
        try{
            if( intval($art_id) <= 0 )
                throw new Exception('参数错误');

            //检查是否存在
            $art_info = Db::table($this->articleModel->getTable())
                ->where('article_id',$art_id)
                ->find();
            if( empty($art_info) )
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

    /**
     *  设置文章审核
     */
    public function set_status(){
        $art_id = input('post.article_id',0);
        try{
            if( intval($art_id) <= 0 )
                throw new Exception('参数错误');

            //检查是否存在
            $art_info = Db::table($this->articleModel->getTable())
                ->where('article_id',$art_id)
                ->find();
            if( empty($art_info) )
                throw new Exception('参数错误');

            Db::startTrans();
            $updateData['status'] = 1;
            $where['article_id'] = ['=',$art_id];
            $updateState = Db::table($this->articleModel->getTable())->where($where)->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误,操作失败');

            //日志记录
            $logModel = model('Log');
            if( $logModel->note(LogModel::UPDATES,"审核文章id：".$art_info['article_id']) === false )
                throw new Exception('网络错误,操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,'参数错误');
        }
        returnJson(true,'操作成功');
    }

    /**
     *  设置文章可读
     */
    public function set_read(){
        $art_id = input('post.article_id',0);
        try{
            if( intval($art_id) <= 0 )
                throw new Exception('参数错误');

            //检查是否存在
            $art_info = Db::table($this->articleModel->getTable())
                ->where('article_id',$art_id)
                ->find();
            if( empty($art_info) )
                throw new Exception('参数错误');

            Db::startTrans();
            $updateData['is_show'] = $art_info['is_show'] == 1 ? 0 : 1;
            $logMsg = $art_info['is_show'] == 1 ? '不可读' : '可读';
            $where['article_id'] = ['=',$art_id];
            $updateState = Db::table($this->articleModel->getTable())->where($where)->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误,操作失败');

            //日志记录
            $logModel = model('Log');
            if( $logModel->note(LogModel::UPDATES,"设置文章id：".$art_info['article_id']." ".$logMsg) === false )
                throw new Exception('网络错误,操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,'参数错误');
        }
        returnJson(true,'设置成功');
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
            $updateData['deleted'] = empty($art_info['deleted']) ? 1 : 0;
            $where['article_id'] = ['=',$art_id];
            $updateState = Db::table($this->articleModel->getTable())->where($where)->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误,操作失败');

            //日志记录
            $logModel = model('Log');
            $msg = empty($art_info['deleted']) ? '删除' : '恢复';
            if( $logModel->note(LogModel::UPDATES,$msg." 文章id：".$art_id) === false )
                throw new Exception('网络错误,操作失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,'参数错误');
        }
        returnJson(true,'操作成功');
    }

    //编辑保存文章接口
    public function update_article(){
        $data = input('post.');
        try{
            if( empty($data['article_id']) || intval($data['article_id']) <= 0 )
                throw new Exception('参数错误');

            $where['article_id'] = ['=',$data['article_id']];
            $art_info = Db::table($this->articleModel->getTable())
                ->where($where)
                ->find();
            if( empty($art_info) )
                throw new Exception('文章名不能为空');

            $updateData['img'] = empty($data['images']) ? '' : trim($data['images']);
            if( $updateData['img'] == '' )
                throw new Exception('文章列表图不能为空');

            //栏目类型
            $updateData['art_cate_id'] = empty($data['cate_id']) ? 0 : intval($data['cate_id']);
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
            $updateData['description'] = empty($data['desc']) ? '' : trim($data['desc']);
            //文章内容
            $updateData['content'] = empty($data['content']) ? '' : trim($data['content']);
            //排序
            $updateData['sequence'] = empty($data['sequence']) ? 0 : intval($data['sequence']);
            //推荐设置
            $insertData['recommend'] = empty($data['recommend']) ? 0 : intval($data['recommend']);
            //阅读权限
            $updateData['read_group'] = empty($data['read_group']) ? 0 : intval($data['read_group']);
            //阅读权限
            if( !isset(ArticleModel::$map_readgroup[$updateData['read_group']]) )
                throw new Exception('不存在用户类型');

            $updateData['edit_time'] = time();
            Db::startTrans();
            $updateState = Db::table($this->articleModel->getTable())
                ->where($where)
                ->update($updateData);
            if( empty($updateState) )
                throw new Exception('网络错误，保存失败');

            //记录日志
            $logModel = model('Log');
            if( $logModel->note(LogModel::UPDATES,'编辑文章id：'.$art_info['article_id']) === false )
                throw new Exception('网络错误，保存失败');

            Db::commit();
        }catch( Exception $e ){
            Db::rollback();
            returnJson(false,$e->getMessage());
        }
        returnJson(true,'保存成功');
    }

}