<?php


namespace app\lib\exception;


class ThemeException extends BaseException
{
    public $code = 404;
    //错误具体信息
    public $msg = '指定主题不存在';
    //自定义的错误码
    public $errorCode = 30000;
}