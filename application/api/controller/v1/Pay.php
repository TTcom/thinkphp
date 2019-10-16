<?php


namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\WxNotify;
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
    public function receiveNotify(){   //接收微信推送的消息
        //通知频率为15/15/30/180/1800/1800/1800/1800/3600 单位秒
        //1、检测库存量,超卖可能性比较小
        //2、更新这个订单的status状态
        //3、减库存
        //如果成功处理，我们返回微信成功处理的消息，否则的话，我们需要返回没有成功处理
        //特点：post xml格式  不会携带参数

        $notify = new WxNotify();
        $notify->Handle();


    }
}