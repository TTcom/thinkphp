<?php


namespace app\api\service;


use think\Exception;
use app\api\model\Order as OrderModel;
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
       $orderService = new Order();
       $status = $orderService->checkOrderStock($this->orderID);

   }
   private function checkOrderValid(){
       $order = OrderModel::where()
           ->find();
   }


}