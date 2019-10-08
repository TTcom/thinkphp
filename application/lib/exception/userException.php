<?php


namespace app\lib\exception;


class userException extends BaseException
{
    public $code = 401;
    public $msg = '用户不存在';
    public $errorCode = 60000;
}