<?php


namespace Hahadu\Sms\think;
use Hahadu\Sms\Client\SmsClient;

class ThinkSmsClient
{
    protected static $sms;
    public function __construct(){
        self::$sms = New SmsClient(config('sms.access_secret'),config('sms.access_key'),config('sms.sign_name'),config('sms.template'));
    }
    public static function init(){
        new self();
    }

    public static function send_sms($phone,$smsParam,$template=NULL){
        self::init();
        return self::$sms->send_sms($phone,$smsParam,$template);
    }

}