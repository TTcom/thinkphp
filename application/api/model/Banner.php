<?php


namespace app\api\model;


use think\Db;
use think\Exception;

class Banner
{
        public static function getBannerByID($id)
        {
            //TODO:根据id获取banner信息
            //从表banner_item中查询banner_id为$id的数据
           $result = Db::query('select * from banner_item where banner_id=?',[$id]);

           return $result;

        }
}