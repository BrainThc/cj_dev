<?php
namespace app\admin\model;
use think\Db;
use think\Model;

/**
 * 文章分类model
 * Class User
 */
class ArticleCate extends Model{

    protected $name = 'article_cate';
    protected $pk = 'art_cate_id';

    /**
     * 配置分类树状
     * @param $cate_list        最高级分类列表
     * @return mixed            返回已处理的列表
     */
    public function getCateTree($cate_list){
        if( !empty($cate_list) ){
            foreach( $cate_list as $key => $cate){
                $cate_son = Db::table($this->getTable())
                    ->where('pid',$cate['art_cate_id'])
                    ->order('sequence','desc')
                    ->select();
                if( !empty($cate_son) ){
                    $cate_son = $this->getCateTree($cate_son);
                }
                $cate_list[$key]['child'] = $cate_son;
            }
        }
        return $cate_list;
    }
}

?>