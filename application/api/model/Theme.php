<?php


namespace app\api\model;


class Theme extends BaseModel
{
    protected $hidden = ['update_time','delete_time','id','topic_img_id','head_img_id'];
    public function topicImg(){
        //belongsTo：一对一关系
        return $this->belongsTo('Image','topic_img_id','id');  //model关联image表，外键：topic_img_id；另一张表里的主键关联imaged的id
    }
    public function headImg(){
        return $this->belongsTo('Image','head_img_id','id');

    }
}