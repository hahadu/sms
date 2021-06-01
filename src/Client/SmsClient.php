<?php


namespace Hahadu\Sms\Client;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use Hahadu\Helper\JsonHelper;
use Hahadu\Sms\Service\Aliyun;

class SmsClient implements SmsServiceInterface
{

    /******
     * 短信服务商
     * @var string
     */
    protected $service;

    /*****
     * 构造函数
     * @param string $accessSecret Secret key
     * @param string $accessKey Secret key id
     * @param string $signName  短信签名
     * @param string $template 短信模板
     * @param string $service 短信服务商
     */
    public function __construct($accessSecret, $accessKey, $signName, $template=NULL,$service="Aliyun")
    {
        $service = strtolower($service);
        switch ($service){
            case $service == 'aliyun':
                $this->service = new Aliyun($accessSecret, $accessKey, $signName, $template);
                break;
            default:
                $this->service = null;
                break;
        }
    }

    /*****
     * 发送短信方法
     * @param int|string $phone
     * @param array $smsParam 短信内容
     * @param string $template 短信模板
     * @return array|string
     * @throws ClientException
     */
    public function send_sms($phone,$smsParam,$template=NULL){
        return $this->service->send_sms($phone,$smsParam,$template);

    }

}