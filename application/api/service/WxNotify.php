<?php


namespace app\api\service;

use app\api\model\Order as OrderModel;
use app\api\model\Product;
use app\api\service\Order as OrderService;
use app\lib\enum\OrderStatusEnum;
use think\Db;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay', EXTEND_PATH, '.Api.php');
class WxNotify extends \WxPayNotify
{
  public function NotifyProcess($data, &$msg)
  {
      if ($data['result_code'] == 'SUCCESS') {
          $orderNo = $data['out_trade_no'];    //订单号
          Db::startTrans();
          try {
              $order = OrderModel::where('order_no', '=', $orderNo)->lock(true)->find(); //lock:查询锁查询订单
              if ($order->status == 1) {    //订单未支付
                  $service = new OrderService();
                  $stockStatus = $service->checkOrderStock($order->id);
                  if ($stockStatus['pass']) {    //通过库存量检测
                      $this->updateOrderStatus($order->id,true);  //更新订单状态
                      $this->reduceStock($stockStatus);      //消减库存量
                  } else {
                      $this->updateOrderStatus($order->id, false);
                  }
              }
              Db::commit();
              return true;

          } catch (Exception $ex) {
              Db::rollback();
              Log::error($ex);
              // 如果出现异常，向微信返回false，请求重新发送通知
              return false;
          }
      }else{
           return true;
      }

  }
    private function reduceStock($stockStatus)
    {     //消减库存量
//        $pIDs = array_keys($status['pStatus']);
        foreach ($stockStatus['pStatusArray'] as $singlePStatus) {
            Product::where('id', '=', $singlePStatus['id'])
                ->setDec('stock', $singlePStatus['count']);  //setDec可以对数据库数据做减法
        }
    }

    private function updateOrderStatus($orderID, $success)
    {       //更新订单状态
        $status = $success ? OrderStatusEnum::PAID : OrderStatusEnum::PAID_BUT_OUT_OF;
        OrderModel::where('id', '=', $orderID)
            ->update(['status' => $status]);
    }
}