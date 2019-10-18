<?php


namespace app\api\model;


class Theme extends BaseModel
{
    protected $hidden = ['update_time','delete_time','topic_img_id','head_img_id'];
    public function topicImg(){
        //belongsTo：一对一关系
        return $this->belongsTo('Image','topic_img_id','id');  //model关联image表，外键：topic_img_id；另一张表里的主键关联imaged的id
    }
    public function headImg(){
        return $this->belongsTo('Image','head_img_id','id');

    }
    public function products(){     //多对多查询
        return $this->belongsToMany('Product','theme_product','product_id','theme_id');
    }

    public static function getThemeWithProducts($id){

        $theme = self::with('products,topicImg,headImg')
            ->find($id);
        return $theme;

    }
}