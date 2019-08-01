<?php


namespace app\lib\exception;


class ProductException extends BaseException
{
    public $code = 404;
    //错误具体信息
    public $msg = '指定商品不存在';
    //自定义的错误码
    public $errorCode = 30000;
}