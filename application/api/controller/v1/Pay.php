<?php


namespace app\api\controller\v1;


use app\api\controller\BaseController;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope'=>['only'=>'getPreOrder']
    ];
  public function getPreOrder(){


  }
}