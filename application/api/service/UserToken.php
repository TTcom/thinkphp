<?php


class UserToken
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wx.app.id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'),
            $this->wxAppID,$this->wxAppSecret,$this->code);

    }

    public function get($code){
       $result = curl_get($this->wxLoginUrl);
       $wxResult = json_decode($result,true);
       if(empty($wxResult)){
           throw new Exception('获取sessionkey是异常,微信内部错误');
       }else{
           $loginFail = array_key_exists('errcode',$wxResult);
           if($loginFail){

           }else{

           }
       }
    }
}