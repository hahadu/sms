<?php


namespace Hahadu\Sms\think;
use AlibabaCloud\Client\Exception\ClientException;
use Hahadu\Sms\Client\SmsClient;

class ThinkSmsClient
{
    protected static $sms;
    public function __construct(){
        self::$sms = New SmsClient(config('sms.access_secret'),config('sms.access_key'),config('sms.sign_name'),config('sms.template'),config('sms.service'));
    }
    public static function init(){
        new self();
    }

    /*****
     * 发送短信方法
     * @param int|string $phone
     * @param array $smsParam 短信内容
     * @param string $template 短信模板
     * @throws ClientException
     */

    public static function send_sms($phone,$smsParam,$template=NULL){
        self::init();
        return self::$sms->send_sms($phone,$smsParam,$template);
    }

}