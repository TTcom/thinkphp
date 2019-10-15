<?php


namespace app\api\service;


use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use think\Loader;
use think\Log;

// extend/WxPay/WxPay.Api.php

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');

class Pay
{
   private $orderID;
   private $orderNO;

   function __construct($orderID)
   {
        if(!$orderID){
            throw new Exception('订单号不能为空');
        }
        $this->orderID = $orderID;
   }
   public function pay(){
       //订单号可能根本就不存在
       //订单号确实是存在的，但是，订单号和当前用户是不匹配的
       //订单有可能已经被支付过
       //进行库存量检测
       $this->checkOrderValid(); //订单号验证
       $orderService = new OrderService();
       $status = $orderService->checkOrderStock($this->orderID);
       if(!$status['pass']){
           return $status;
       }
       return $this->makeWxPreOrder($status['orderPrice']);
   }
   private function  makeWxPreOrder($totalPrice){   //生成微信预订单
     //openid    代表用户身份
     //获取当前用户的openid
       $openid = Token::getCurrentTokenVar('openid');
       if(!$openid){
           throw new TokenException();
       }
       $wxOrderData = new \WxPayUnifiedOrder();
       $wxOrderData->SetOut_trade_no($this->orderNO);
       $wxOrderData->SetTrade_type('JSAPI');
       $wxOrderData->SetTotal_fee($totalPrice*100); //总金额
       $wxOrderData->SetBody('商贩');
       $wxOrderData->SetOpenid($openid);
       $wxOrderData->SetNotify_url('http://qq.com');
       return $this->getPaySignature($wxOrderData);
   }
   private function getPaySignature($wxOrderData){

       $wxOrder = \WxPayApi::unifiedOrder($wxOrderData);

       // 失败时不会返回result_code
       if($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] !='SUCCESS'){
           Log::record($wxOrder,'error');
           Log::record('获取预支付订单失败','error');

//            throw new Exception('获取预支付订单失败');
       }
       //prepay_id 用于向用户推送消息
        $this->recordPreOrder($wxOrder);
        $signature = $this->sign($wxOrder);
        return $signature;

   }

   private function sign($wxOrder){
       $jsApiPayData = new \WxPayJsApiPay();
       $jsApiPayData->SetAppid(config('wx.app_id'));
       $jsApiPayData->SetTimeStamp((string)time());
       $rand = md5(time() . mt_rand(0,1000));    //生成一个随机数
       $jsApiPayData->SetNonceStr($rand);
       $jsApiPayData->SetPackage('prepay_id='.$wxOrder['prepay_id']);
       $jsApiPayData->SetSignType('md5');
       $sign = $jsApiPayData->MakeSign();
       $rawValues = $jsApiPayData->GetValues();
       $rawValues['paySign'] = $sign;

       unset($rawValues['appId']); //删除元素appId
       return $rawValues;

   }
   private function recordPreOrder($wxOrder){
       OrderModel::where('id','=',$this->orderID)
           ->update(['prepay_id'=>$wxOrder['prepay_id']]);

   }
   private function checkOrderValid(){     //订单号验证
       $order = OrderModel::where('id', '=', $this->orderID)
           ->find();
       if(!$order){
           throw new OrderException();
       }
       if(!Token::isValidOperate($order->user_id)){
           throw new TokenException([
               'msg' => '订单与用户不匹配',
               'errorCode' => 10003
           ]);
       }

       if($order->status != OrderStatusEnum::UNPAID){    //订单不是待支付状态
             throw new OrderException([
                 'msg' => '订单已支付',
                 'errorCode' => 80003,
                 'code' =>400
             ]);
       }
       $this->orderNO = $order->order_no;
       return true;
   }


}