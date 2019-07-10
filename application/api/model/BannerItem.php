<?php

namespace app\api\model;

use think\Model;

class BannerItem extends BaseModel
{
    protected $hidden = ['update_time','delete_time','id','img_id','banner_id'];
    public function img(){
        //belongTo一对一关系
        return $this->belongsTo('Image','img_id','id');

    }
}
