<?php


namespace app\api\model;


use think\Model;

class Image extends BaseModel
{
  protected $hidden = ['id','from','delete_time','update_time'];

}