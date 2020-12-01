<?php


namespace Hahadu\Sms\Client;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use Hahadu\Helper\JsonHelper;

class SmsClient
{
    /*****
     * @var $access_key string
     */
    protected $access_key;
    /*****
     * @var $access_secret string
     */
    protected $access_secret;
    /*****
     * 签名名称
     * @var $sign_name string
     */
    protected $sign_name;
    /*****
     * 短信模板
     * @var $sms_template object json
     */
    protected $sms_template;

    /*****
     * 构造函数
     * @param string $accessSecret Secret key
     * @param string $accessKey Secret key id
     * @param string $signName  短信签名
     * @param string $template 短信模板
     */
    public function __construct($accessSecret, $accessKey, $signName, $template=NULL)
    {
        $this->access_key = $accessKey;
        $this->access_secret = $accessSecret;
        $this->sign_name = $signName;
        $this->sms_template = $template;
    }

    static public function configur(){

    }

    /*****
     * 发送短信方法
     * @param int|string $phone
     * @param array $smsParam 短信内容
     * @param string $template 短信模板
     * @throws ClientException
     */
    public function send_sms($phone,$smsParam,$template=NULL){
        if(null!==$template)$this->sms_template = $template;

        AlibabaCloud::accessKeyClient($this->access_key, $this->access_secret)
            ->regionId('cn-hangzhou')
            ->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => "cn-hangzhou",
                        'PhoneNumbers' => $phone,
                        'SignName'     => $this->sign_name,
                        'TemplateCode' => $this->sms_template,
                        'TemplateParam' => JsonHelper::json_encode($smsParam),
                    ],
                ])
                ->request();
            return ($result->toArray());
        } catch (ClientException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        }

    }




}