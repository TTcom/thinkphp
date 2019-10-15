<?php


namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\validate\IDMustBePostiveint;
use app\api\service\Pay as PayService;

class Pay extends BaseController
{
    protected $beforeActionList = [
        'checkExclusiveScope'=>['only'=>'getPreOrder']
    ];
  public function getPreOrder($id=''){

      (new IDMustBePostiveint())->goCheck();  //验证是否为正整数

      $pay = new PayService($id);
       return $pay->pay();


  }
}