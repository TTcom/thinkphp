<?php


namespace app\api\model;


use think\Db;
use think\Exception;
use think\Model;

class Banner extends BaseModel
{
   // protected $table = 'category';    //指定要查询的数据库的表名

    protected $hidden = ['update_time','delete_time'];


    public static function getBannerByID($id)
    {
         //TODO:根据id获取banner信息
         $banner = self::with(['items','items.img'])->find($id);
         return $banner;
    }
    public function items(){     //关联模型BannerItem
        return $this->hasMany('BannerItem','banner_id','id');
    }
}