<?php


namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code = 404;
    //错误具体信息
    public $msg = '指定类目不存在，请检查';
    //自定义的错误码
    public $errorCode = 50000;
}