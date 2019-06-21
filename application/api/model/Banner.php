<?php


namespace app\api\model;


use think\Db;
use think\Exception;
use think\Model;

class Banner extends Model
{
   // protected $table = 'category';    //指定要查询的数据库的表名
    public static function getBannerByID($id)
        {

            //TODO:根据id获取banner信息
            //从表banner_item中查询banner_id为$id的数据
//           $result = Db::query('select * from banner_item where banner_id=?',[$id]);
//           return $result;
          //  $result = Db::table('banner_item')->where('banner_id','=',$id)->select();
            //数据的执行方法：select、update、delete、insert；
            // where('字段名'，‘表达式’，‘查询条件’);
            //表达式、数组法、闭包
            $result = Db::table('banner_item')
                ->where(function ($query) use ($id) {
                    $query->where('banner_id', '=', $id);
                })
               ->select();
            //ORM Obeject Relation Mapping 对象关系映射；
        //模型
            return $result;
        }
}