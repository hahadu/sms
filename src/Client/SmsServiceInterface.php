<?php


namespace Hahadu\Sms\Client;

interface SmsServiceInterface
{
        /*****
         * 发送短信方法
         * @param int|string $phone
         * @param array $smsParam 短信内容
         * @param string $template 短信模板
         */
        public function send_sms($phone,$smsParam,$template=NULL);

}