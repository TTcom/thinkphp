<?php


namespace app\api\service;


use app\api\model\Product;
use app\lib\exception\OrderException;

class Order
{
    // 订单的商品列表，也就是客户端传递过来的products参数
     protected $oProducts;

     // 真实的商品信息（包括库存量）
    protected  $products;

    protected $uid;

    public function place($uid,$oProducts){       //下单
        // oProducts 和 products 作对比
        // products从数据库中查出来
        $this->oProducts = $oProducts;
        $this->products = $this->getProductsByOrder($oProducts);
        $this->uid = $uid;
        $status = $this->getOrderStatus();
        if(!$status['pass']){
            $status['order_id'] = -1;
            return $status;
        }
        //开始创建订单

    }
    private function getOrderStatus(){     //对比商品信息
        $status = [
          'pass' => true,
          'orderPrice' => 0,          //商品价格总和
            'pStatusArray'=>[],   //详细地商品信息
        ];
        foreach ($this->oProducts as $oProduct){
             $pStatus = $this->getProductStatus(
                 $oProduct['product_id'],$oProduct['count'],
                 $this->products
             );
             if(!$pStatus['haveStock']){
                 $status['pass'] = false;
             }
             $status['orderPrice']+= $pStatus['totalPrice'];
             array_push($status['pStatusArray'],$pStatus);
        }
        return $status;


    }
    private function getProductStatus($oPID,$oCount,$products){
        $pIndex = -1;
        $pStatus=[
          'id' => null,
          'haveStock' => false,
          'count' => 0,
          'name'=>'',
          'totalPrice'=> 0
        ];
        for($i=0; $i<count($products);$i++){
            if($oPID == $products[$i]['id']){
                $pIndex = $i;
            }
        }
        if($pIndex == -1){
            //客户端传递的product_id可能根本不存在
            throw new OrderException([
                'msg'=>'id为'.$oPID.'的商品不存在，创建订单失败'
            ]);
        }else{
              $product = $products[$pIndex];
              $pStatus['id'] = $product['id'];
              $pStatus['count'] = $oCount;
              $pStatus['totalPrice'] = $product['price'] * $oCount;
              if($product['stock'] - $oCount >=0){
                  $pStatus['haveStock'] = true;
              }
        }

        return $pStatus;

    }


    private function getProductsByOrder($oProducts){      //根据订单信息查询真实的商品信息
        $oPIDs = [];
        foreach ($oProducts as $item){
            //避免循环的查询数据库
            array_push($oPIDs,$item['product_id']);
        }
        $products = Product::all($oPIDs)      //查询商品
         ->visible(['id','price','stock','name','main_img_url'])   //需要看到哪些数据
        ->toArray();  //转为数组
        return $products;
    }


}